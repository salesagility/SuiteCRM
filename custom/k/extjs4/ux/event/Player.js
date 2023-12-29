/**
 * This class manages the playback of an array of "event descriptors". For details on the
 * contents of an "event descriptor", see {@link Ext.ux.event.Recorder}. The events recorded by the
 * {@link Ext.ux.event.Recorder} class are designed to serve as input for this class.
 * 
 * The simplest use of this class is to instantiate it with an {@link #eventQueue} and call
 * {@link #method-start}. Like so:
 *
 *      var player = Ext.create('Ext.ux.event.Player', {
 *          eventQueue: [ ... ],
 *          speed: 2,  // play at 2x speed
 *          listeners: {
 *              stop: function () {
 *                  player = null; // all done
 *              }
 *          }
 *      });
 *
 *      player.start();
 *
 * A more complex use would be to incorporate keyframe generation after playing certain
 * events.
 *
 *      var player = Ext.create('Ext.ux.event.Player', {
 *          eventQueue: [ ... ],
 *          keyFrameEvents: {
 *              click: true
 *          },
 *          listeners: {
 *              stop: function () {
 *                  // play has completed... probably time for another keyframe...
 *                  player = null;
 *              },
 *              keyframe: onKeyFrame
 *          }
 *      });
 *
 *      player.start();
 *
 * If a keyframe can be handled immediately (synchronously), the listener would be:
 *
 *      function onKeyFrame () {
 *          handleKeyFrame();
 *      }
 *
 *  If the keyframe event is always handled asynchronously, then the event listener is only
 *  a bit more:
 *
 *      function onKeyFrame (p, eventDescriptor) {
 *          eventDescriptor.defer(); // pause event playback...
 *
 *          handleKeyFrame(function () {
 *              eventDescriptor.finish(); // ...resume event playback
 *          });
 *      }
 *
 * Finally, if the keyframe could be either handled synchronously or asynchronously (perhaps
 * differently by browser), a slightly more complex listener is required.
 *
 *      function onKeyFrame (p, eventDescriptor) {
 *          var async;
 *
 *          handleKeyFrame(function () {
 *              // either this callback is being called immediately by handleKeyFrame (in
 *              // which case async is undefined) or it is being called later (in which case
 *              // async will be true).
 *
 *              if (async) {
 *                  eventDescriptor.finish();
 *              } else {
 *                  async = false;
 *              }
 *          });
 *
 *          // either the callback was called (and async is now false) or it was not
 *          // called (and async remains undefined).
 *
 *          if (async !== false) {
 *              eventDescriptor.defer();
 *              async = true; // let the callback know that we have gone async
 *          }
 *      }
 */
Ext.define('Ext.ux.event.Player', {
    extend: 'Ext.ux.event.Driver',

    /**
     * @cfg {Array} eventQueue The event queue to playback. This must be provided before
     * the {@link #method-start} method is called.
     */

    /**
     * @cfg {Object} keyFrameEvents An object that describes the events that should generate
     * keyframe events. For example, `{ click: true }` would generate keyframe events after
     * each `click` event.
     */
    keyFrameEvents: {
        click: true
    },

    /**
     * @cfg {Boolean} pauseForAnimations True to pause event playback during animations, false
     * to ignore animations. Default is true.
     */
    pauseForAnimations: true,

    /**
     * @cfg {Number} speed The playback speed multiplier. Default is 1.0 (to playback at the
     * recorded speed). A value of 2 would playback at 2x speed.
     */
    speed: 1.0,

    stallTime: 0,

    tagPathRegEx: /(\w+)(?:\[(\d+)\])?/,
    
    constructor: function (config) {
        var me = this;
        
        me.callParent(arguments);

        me.addEvents(
            /**
             * @event beforeplay
             * Fires before an event is played.
             * @param {Ext.ux.event.Player} this
             * @param {Object} eventDescriptor The event descriptor about to be played.
             */
            'beforeplay',

            /**
             * @event keyframe
             * Fires when this player reaches a keyframe. Typically, this is after events
             * like `click` are injected and any resulting animations have been completed.
             * @param {Ext.ux.event.Player} this
             * @param {Object} eventDescriptor The keyframe event descriptor.
             */
            'keyframe'
        );

        me.eventObject = new Ext.EventObjectImpl();

        me.timerFn = function () {
            me.onTick();
        };
        me.attachTo = me.attachTo || window;
    },

    /**
     * Returns the element given is XPath-like description.
     * @param {String} xpath The XPath-like description of the element.
     * @return {HTMLElement}
     */
    getElementFromXPath: function (xpath) {
        var me = this,
            parts = xpath.split('/'),
            regex = me.tagPathRegEx,
            i, n, m, count, tag, child,
            el = me.attachTo.document;

        el = (parts[0] == '~') ? el.body
                    : el.getElementById(parts[0].substring(1)); // remove '#'

        for (i = 1, n = parts.length; el && i < n; ++i) {
            m = regex.exec(parts[i]);
            count = m[2] ? parseInt(m[2], 10) : 1;
            tag = m[1].toUpperCase();

            for (child = el.firstChild; child; child = child.nextSibling) {
                if (child.tagName == tag) {
                    if (count == 1) {
                        break;
                    }
                    --count;
                }
            }

            el = child;
        }

        return el;
    },

    getTimeIndex: function () {
        var t = this.getTimestamp() - this.stallTime;
        return t * this.speed;
    },

    makeToken: function (eventDescriptor, signal) {
        var me = this,
            t0;

        eventDescriptor[signal] = true;

        eventDescriptor.defer = function () {
            eventDescriptor[signal] = false;
            t0 = me.getTime();
        };

        eventDescriptor.finish = function () {
            eventDescriptor[signal] = true;
            me.stallTime += me.getTime() - t0;

            me.schedule();
        };
    },

    /**
     * This method is called after an event has been played to prepare for the next event.
     * @param {Object} eventDescriptor The descriptor of the event just played.
     */
    nextEvent: function (eventDescriptor) {
        var me = this,
            index = ++me.queueIndex;

        // keyframe events are inserted after a keyFrameEvent is played.
        if (me.keyFrameEvents[eventDescriptor.type]) {
            Ext.Array.insert(me.eventQueue, index, [
                { keyframe: true, ts: eventDescriptor.ts }
            ]);
        }
    },

    /**
     * This method returns the event descriptor at the front of the queue. This does not
     * dequeue the event. Repeated calls return the same object (until {@link #nextEvent}
     * is called).
     */
    peekEvent: function () {
        var me = this,
            queue = me.eventQueue,
            index = me.queueIndex,
            eventDescriptor = queue[index],
            type = eventDescriptor && eventDescriptor.type,
            tmp;

        if (type == 'mduclick') {
            tmp = [
                Ext.applyIf({ type: 'mousedown' }, eventDescriptor),
                Ext.applyIf({ type: 'mouseup' }, eventDescriptor),
                Ext.applyIf({ type: 'click' }, eventDescriptor)
            ];

            me.replaceEvent(index, tmp);
        }

        return queue[index] || null;
    },

    replaceEvent: function (index, events) {
        for (var t, i = 0, n = events.length; i < n; ++i) {
            if (i) {
                t = events[i-1];
                delete t.afterplay;
                delete t.screenshot;

                delete events[i].beforeplay;
            }
        }

        Ext.Array.replace(this.eventQueue, index, 1, events);
    },

    /**
     * This method dequeues and injects events until it has arrived at the time index. If
     * no events are ready (based on the time index), this method does nothing.
     * @return {Boolean} True if there is more to do; false if not (at least for now).
     */
    processEvents: function () {
        var me = this,
            animations = me.pauseForAnimations && me.attachTo.Ext.fx.Manager.items,
            eventDescriptor;

        while ((eventDescriptor = me.peekEvent()) !== null) {
            if (animations && animations.getCount()) {
                return true;
            }
            
            if (eventDescriptor.keyframe) {
                if (!me.processKeyFrame(eventDescriptor)) {
                    return false;
                }
                me.nextEvent(eventDescriptor);
            } else if (eventDescriptor.ts <= me.getTimeIndex() &&
                       me.fireEvent('beforeplay', me, eventDescriptor) !== false &&
                       me.playEvent(eventDescriptor)) {
                if(window.__x && eventDescriptor.screenshot) {
                     __x.poll.sendSyncRequest({cmd: 'screenshot'});
                }       
                me.nextEvent(eventDescriptor);
            } else {
                return true;
            }
        }

        me.stop();
        return false;
    },

    /**
     * This method is called when a keyframe is reached. This will fire the keyframe event.
     * If the keyframe has been handled, true is returned. Otherwise, false is returned.
     * @param {Object} The event descriptor of the keyframe.
     * @return {Boolean} True if the keyframe was handled, false if not.
     */
    processKeyFrame: function (eventDescriptor) {
        var me = this;

        // only fire keyframe event (and setup the eventDescriptor) once...
        if (!eventDescriptor.defer) {
            me.makeToken(eventDescriptor, 'done');
            me.fireEvent('keyframe', me, eventDescriptor);
        }

        return eventDescriptor.done;
    },

    /**
     * Called to inject the given event on the specified target.
     * @param {HTMLElement} target The target of the event.
     * @param {Ext.EventObject} The event to inject.
     */
    injectEvent: function (target, event) {
        event.injectEvent(target);
    },

    playEvent: function (eventDescriptor) {
        var me = this,
            target = me.getElementFromXPath(eventDescriptor.target),
            event;

        if (!target) {
            // not present (yet)... wait for element present...
            // TODO - need a timeout here
            return false;
        }

        if (!me.playEventHook(eventDescriptor, 'beforeplay')) {
            return false;
        }

        if (!eventDescriptor.injected) {
            eventDescriptor.injected = true;
            event = me.translateEvent(eventDescriptor, target);
            me.injectEvent(target, event);
        }

        return me.playEventHook(eventDescriptor, 'afterplay');
    },

    playEventHook: function (eventDescriptor, hookName) {
        var me = this,
            doneName = hookName + '.done',
            firedName = hookName + '.fired',
            hook = eventDescriptor[hookName];

        if (hook && !eventDescriptor[doneName]) {
            if (!eventDescriptor[firedName]) {
                eventDescriptor[firedName] = true;
                me.makeToken(eventDescriptor, doneName);

                me.eventScope[hook](eventDescriptor);
            }
            return false;
        }

        return true;
    },

    schedule: function () {
        var me = this;
        if (!me.timer) {
            me.timer = setTimeout(me.timerFn, 10);
        }
    },

    translateEvent: function (eventDescriptor, target) {
        var me = this,
            event = me.eventObject,
            modKeys = eventDescriptor.modKeys || '',
            xy;

        if ('x' in eventDescriptor) {
            event.xy = xy = Ext.fly(target).getXY();
            xy[0] += eventDescriptor.x;
            xy[1] += eventDescriptor.y;
        }

        if ('wheel' in eventDescriptor) {
            // see getWheelDelta
        }

        event.type = eventDescriptor.type;
        event.button = eventDescriptor.button;
        event.altKey = modKeys.indexOf('A') > 0;
        event.ctrlKey = modKeys.indexOf('C') > 0;
        event.metaKey = modKeys.indexOf('M') > 0;
        event.shiftKey = modKeys.indexOf('S') > 0;
    
        return event;
    },

    //---------------------------------
    // Driver overrides

    onStart: function () {
        var me = this;

        me.queueIndex = 0;
        me.schedule();
    },

    onStop: function () {
        var me = this;

        if (me.timer) {
            clearTimeout(me.timer);
            me.timer = null;
        }
        if (window.__x) {
            __x.poll.sendSyncRequest({cmd: 'finish'});
        }
    },

    //---------------------------------

    onTick: function () {
        var me = this;

        me.timer = null;

        if (me.processEvents()) {
            me.schedule();
        }
    }
});
