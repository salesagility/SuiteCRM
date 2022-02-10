{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 *
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

*}
{if !empty($external)}
<input type="checkbox" value="1" name="{$source_id}_external" id="{$source_id}_external"{$externalChecked}> <label for="{$source_id}_external">{$mod.LBL_EXTERNAL} {if !empty($externalHasProperties)}{$mod.LBL_EXTERNAL_SET_PROPERTIES}{/if}</label><br/>
<br/>
{/if}
{if empty($externalOnly)}
<table id="{$source_id}" class="sources_table" border="0" cellspacing="1" cellpadding="1">
<tr>
<td width="33%">
<span><b>{$mod.LBL_ENABLED}</b></span>
</td>
<td width="33%">
<span><b>{$mod.LBL_DISABLED}</b></span>
</td>
<td width="33%">&nbsp;</td>
</tr>
<tr>
<td>
<div id="{$source_id}:enabled_div" class="enabled_module_workarea">
<ul id="{$source_id}:enabled_ul" class="module_draglist">
{foreach from=$enabled_modules item=module}
<li id="{$source_id}:{$module}" class="noBullet2">{sugar_translate label=$module}</li>
{/foreach}
</ul>
</div>
</td>
<td>
<div id="{$source_id}:disabled_div" class="disabled_module_workarea">
<ul id="{$source_id}:disabled_ul" class="module_draglist">
{foreach from=$disabled_modules item=module}
<li id="{$source_id}:{$module}" class="noBullet2">{sugar_translate label=$module}</li>
{/foreach}
</ul>
</div>
</td>
<td>&nbsp;</td>
</tr>
</table>

<script type="text/javascript">
{literal}

var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;

(function() {

YAHOO.example.DDApp = {
init: function() {
{/literal}
	new YAHOO.util.DDTarget("{$source_id}:enabled_ul");
	new YAHOO.util.DDTarget("{$source_id}:disabled_ul");

	{foreach from=$enabled_modules item=module}
	     new YAHOO.example.DDList("{$source_id}:{$module}");
	{/foreach}

	{foreach from=$disabled_modules item=module}
	     new YAHOO.example.DDList("{$source_id}:{$module}");
	{/foreach}
{literal}
}
};


YAHOO.example.DDList = function(id, sGroup, config) {
    YAHOO.example.DDList.superclass.constructor.call(this, id, sGroup, config);
    var el = this.getDragEl();
    Dom.setStyle(el, "opacity", 0.67);
    this.goingUp = false;
    this.lastY = 0;
};


YAHOO.extend(YAHOO.example.DDList, YAHOO.util.DDProxy, {
	    startDrag: function(x, y) {
	        // make the proxy look like the source element
	        var dragEl = this.getDragEl();
	        var clickEl = this.getEl();
	        Dom.setStyle(clickEl, "visibility", "hidden");
	        dragEl.innerHTML = clickEl.innerHTML;
	        Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color"));
	        Dom.setStyle(dragEl, "backgroundColor", Dom.getStyle(clickEl, "backgroundColor"));
	        Dom.setStyle(dragEl, "border", "2px solid gray");
	    },

	    endDrag: function(e) {

	        var srcEl = this.getEl();
	        var proxy = this.getDragEl();

	        // Show the proxy element and animate it to the src element's location
	        Dom.setStyle(proxy, "visibility", "");
	        var a = new YAHOO.util.Motion(
	            proxy, {
	                points: {
	                    to: Dom.getXY(srcEl)
	                }
	            },
	            0.2,
	            YAHOO.util.Easing.easeOut
	        )
	        var proxyid = proxy.id;
	        var thisid = this.id;

	        // Hide the proxy and show the source element when finished with the animation
	        a.onComplete.subscribe(function() {
	                Dom.setStyle(proxyid, "visibility", "hidden");
	                Dom.setStyle(thisid, "visibility", "");
	            });
	        a.animate();
	    },

	    onDragDrop: function(e, id) {
	        // If there is one drop interaction, the li was dropped either on the list,
	        // or it was dropped on the current location of the source element.
	        if (typeof(DDM.interactionInfo) != 'undefined' && DDM.interactionInfo.drop.length === 1) {

	            // The position of the cursor at the time of the drop (YAHOO.util.Point)
	            var pt = DDM.interactionInfo.point;

	            // The region occupied by the source element at the time of the drop
	            var region = DDM.interactionInfo.sourceRegion;
	            // Check to see if we are over the source element's location.  We will
	            // append to the bottom of the list once we are sure it was a drop in
	            // the negative space (the area of the list without any list items)
	            if (!region.intersect(pt)) {
	                var destEl = Dom.get(id);
	                var destDD = DDM.getDDById(id);
	                destEl.appendChild(this.getEl());
	                destDD.isEmpty = false;
	                DDM.refreshCache();
	            }

	        }
	    },

	    onDrag: function(e) {

	        // Keep track of the direction of the drag for use during onDragOver
	        var y = Event.getPageY(e);

	        if (y < this.lastY) {
	            this.goingUp = true;
	        } else if (y > this.lastY) {
	            this.goingUp = false;
	        }

	        this.lastY = y;
	    },

	    onDragOver: function(e, id) {
	        var srcEl = this.getEl();
	        var destEl = Dom.get(id);

	        if (destEl.nodeName.toLowerCase() == "li") {
	            var orig_p = srcEl.parentNode;
	            var p = destEl.parentNode;
		        if (this.goingUp) {
	                p.insertBefore(srcEl, destEl); // insert above
	            } else {
	                p.insertBefore(srcEl, destEl.nextSibling); // insert below
	            }
		        DDM.refreshCache();
	        }
	    }
});


Event.onDOMReady(YAHOO.example.DDApp.init, YAHOO.example.DDApp, true);


})();
{/literal}
</script>
{else}
<table id="{$source_id}" class="sources_table" border="0" cellspacing="1" cellpadding="1" style="display: none"></table>
{/if}
