/**
 * @extends Ext.ux.event.Driver
 * Event recorder.
 */
Ext.define('Ext.ux.event.Recorder', function () {
    function samePt (pt1, pt2) {
        return pt1.x == pt2.x && pt1.y == pt2.y;
    }

    return {
        extend: 'Ext.ux.event.Driver',

        eventsToRecord: function () {
            var key = { kind: 'keyboard', modKeys: true, key: true, bubbles: true },
                mouse = { kind: 'mouse', button: true, modKeys: true, xy: true, bubbles: true };

            return {
                keydown: key,
                keypress: key,
                keyup: key,

                mousemove: mouse,
                mouseover: mouse,
                mouseout: mouse,
                click: mouse,
                //mousewheel: Ext.apply({ wheel: true }, mouse),
                mousedown: mouse,
                mouseup: mouse,

                scroll: { kind: 'misc', bubbles: false }
            };
        }(),

        ignoreIdRegEx: /ext-gen(?:\d+)/,

        constructor: function (config) {
            var me = this,
                events = config && config.eventsToRecord;

            if (events) {
                me.eventsToRecord = Ext.apply(Ext.apply({}, me.eventsToRecord), // duplicate
                                        events); // and merge
                delete config.eventsToRecord; // don't smash
            }

            me.callParent(arguments);

            me.addEvents(
                /**
                 * @event add
                 * Fires when an event is added to the recording.
                 * @param {Ext.ux.event.Recorder} this
                 * @param {Object} eventDescriptor The event descriptor.
                 */
                'add',

                /**
                 * @event coalesce
                 * Fires when an event is coalesced. This edits the tail of the recorded
                 * event list.
                 * @param {Ext.ux.event.Recorder} this
                 * @param {Object} eventDescriptor The event descriptor that was coalesced.
                 */
                'coalesce'
            );

            me.clear();
            me.modKeys = [];
            me.attachTo = me.attachTo || window;
        },

        clear: function () {
            this.eventsRecorded = [];
        },

        coalesce: function (rec) {
            var me = this,
                events = me.eventsRecorded,
                length = events.length,
                tail = length && events[length-1],
                tailPrev;

            if (!tail) {
                return false;
            }

            if (rec.type == 'mousemove') {
                if (tail.type == 'mousemove' && rec.ts - tail.ts < 200) {
                    rec.ts = tail.ts;
                    events[length-1] = rec;
                    return true;
                }
            } else if (rec.type == 'click') {
                if (length >= 2 && tail.type == 'mouseup' &&
                        (tailPrev = events[length-2]).type == 'mousedown') {
                    if (rec.button == tail.button && rec.button == tailPrev.button &&
                            rec.target == tail.target && rec.target == tailPrev.target &&
                            samePt(rec, tail) && samePt(rec, tailPrev) ) {
                        events.pop(); // remove mouseup
                        tailPrev.type = 'mduclick';
                        return true;
                    }
                }
            }

            return false;
        },

        getElementXPath: function (el) {
            var me = this,
                good = false,
                xpath = [],
                count,
                sibling,
                t,
                tag;

            for (t = el; t; t = t.parentNode) {
                if (t == me.attachTo.document.body) {
                    xpath.unshift('~');
                    good = true;
                    break;
                }
                if (t.id && !me.ignoreIdRegEx.test(t.id)) {
                    xpath.unshift('#' + t.id);
                    good = true;
                    break;
                }

                for (count = 1, sibling = t; !!(sibling = sibling.previousSibling); ) {
                    if (sibling.tagName == t.tagName) {
                        ++count;
                    }
                }

                tag = t.tagName.toLowerCase();
                if (count < 2) {
                    xpath.unshift(tag);
                } else {
                    xpath.unshift(tag + '[' + count + ']');
                }
            }

            return good ? xpath.join('/') : null;
        },

        getRecordedEvents: function () {
            return this.eventsRecorded;
        },

        // DOMNodeInserted
        onDomInsert: function (event, target) {
            this.watchTree(target);
        },

        //DOMNodeRemoved
        onDomRemove: function (event, target) {
            this.unwatchTree(target);
        },

        onEvent: function (e) {
            var me = this,
                info = me.eventsToRecord[e.type],
                root,
                modKeys, elXY,
                rec = {
                    type: e.type,
                    ts: me.getTimestamp(),
                    target: me.getElementXPath(e.target)
                },
                xy;

            if (!rec.target) {
                return;
            }
            root = e.target.ownerDocument;
            root = root.defaultView || root.parentWindow; // Standards || IE
            if (root !== me.attachTo) {
                return;
            }

            if (info.xy) {
                xy = e.getXY();
                if (rec.target) {
                    elXY = Ext.fly(e.getTarget()).getXY();
                    xy[0] -= elXY[0];
                    xy[1] -= elXY[1];
                }
                rec.x = xy[0];
                rec.y = xy[1];
            }

            if (info.button) {
                rec.button = e.button;
            }

            if (info.wheel) {
                rec.wheel = e.getWheelDelta();
            }

            if (info.modKeys) {
                me.modKeys[0] = e.altKey ? 'A' : '';
                me.modKeys[1] = e.ctrlKey ? 'C' : '';
                me.modKeys[2] = e.metaKey ? 'M' : '';
                me.modKeys[3] = e.shiftKey ? 'S' : '';

                modKeys = me.modKeys.join('');
                if (modKeys) {
                    rec.modKeys = modKeys;
                }
            }

            if (info.key) {
                rec.charCode = e.getCharCode();
                rec.keyCode = e.getKey();
            }

            if (me.coalesce(rec)) {
                me.fireEvent('coalesce', me, rec);
            } else {
                me.eventsRecorded.push(rec);
                me.fireEvent('add', me, rec);
            }
        },

        onStart: function () {
            var me = this,
                on = {
                    DOMNodeInserted: me.onDomInsert,
                    DOMNodeRemoved: me.onDomRemove,
                    scope: me
                },
                nonBubbleEvents = (me.nonBubbleEvents = {}),
                ddm = me.attachTo.Ext.dd.DragDropManager,
                evproto = me.attachTo.Ext.EventObjectImpl.prototype;

            me.watchingNodes = {};

            Ext.Object.each(me.eventsToRecord, function (name, value) {
                if (value) {
                    if (value.bubbles) {
                        on[name] = me.onEvent;
                    } else {
                        nonBubbleEvents[name] = value;
                    }
                }
            });

            me.ddmStopEvent = ddm.stopEvent;
            ddm.stopEvent = Ext.Function.createSequence(ddm.stopEvent, function (e) {
                me.onEvent(e);
            });
            me.evStopEvent = evproto.stopEvent;
            evproto.stopEvent = Ext.Function.createSequence(evproto.stopEvent, function () {
                me.onEvent(this);
            });

            var body = me.attachTo.Ext.getBody();
            body.on(on);
            me.watchTree(body.dom);
        },

        onStop: function () {
            var me = this,
                body = me.attachTo.Ext.getBody();

            Ext.Object.each(me.eventsToRecord, function (name, value) {
                if (value) {
                    body.un(name, me.onEvent, me);
                }
            });

            me.attachTo.Ext.dd.DragDropManager.stopEvent = me.ddmStopEvent;
            me.attachTo.Ext.EventObjectImpl.prototype.stopEvent = me.evStopEvent;

            me.unwatchTree(body.dom);
        },

        watchTree: function (root) {
            if (root.nodeType != 1) {
                return; // only ELEMENT_NODE's please...
            }

            var me = this,
                id = (root.tagName == 'BODY') ? '$' : root.id,
                watchingNodes = me.watchingNodes;

            if (id && !watchingNodes[id]) {
                var on = {
                    scope: me
                };

                Ext.Object.each(me.nonBubbleEvents, function (name, value) {
                    if (value) {
                        on[name] = me.onEvent;
                    }
                });
                me.attachTo.Ext.fly(root).on(on);
                watchingNodes[id] = true;
                console.log('watch '+root.tagName+'#'+id);
            }

            Ext.each(root.childNodes, me.watchTree, me);
        },

        unwatchTree: function (root) {
            if (root.nodeType != 1) {
                return; // only ELEMENT_NODE's please...
            }

            var me = this,
                id = (root.tagName == 'BODY') ? '$' : root.id,
                watchingNodes = me.watchingNodes;

            if (id && !watchingNodes[id]) {
                Ext.Object.each(me.nonBubbleEvents, function (name, value) {
                    me.attachTo.Ext.fly(root).un(name, me.onEvent, me);
                });
                delete watchingNodes[id];
                console.log('unwatch '+root.tagName+'#'+id);
            }

            Ext.each(root.childNodes, me.unwatchTree, me);
        }
    };
}());
