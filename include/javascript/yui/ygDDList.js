
/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * @class a YAHOO.util.DDProxy implementation. During the drag over event, the
 * dragged element is inserted before the dragged-over element.
 *
 * @extends YAHOO.util.DDProxy
 * @constructor
 * @param {String} id the id of the linked element
 * @param {String} sGroup the group of related DragDrop objects
 */
function ygDDList(id, sGroup) {

	if (id) {
		this.init(id, sGroup);
		this.initFrame();
	}

	var s = this.getDragEl().style;
	s.borderColor = "transparent";
	s.backgroundColor = "#f6f5e5";
	s.opacity = 0.76;
	s.filter = "alpha(opacity=76)";
}

ygDDList.prototype = new YAHOO.util.DDProxy();

ygDDList.prototype.borderDiv = null;
ygDDList.prototype.originalDisplayProperties = Array();

// Bug #47097 : Dashlets not displayed after moving them
ygDDList.prototype.dashletID = null;
ygDDList.prototype.needsReloadAfterDrop = false;

ygDDList.prototype.startDrag = function(x, y) {
	//this.logger.debug(this.id + " startDrag");

	var dragEl = this.getDragEl();
	var clickEl = this.getEl();

    // Bug #47097 : Dashlets not displayed after moving them
    this.needsReloadAfterDrop = false;
    var chartContainer = YAHOO.util.Dom.getElementsByClassName('chartContainer', 'div', clickEl);
    if ( chartContainer.length != 0 ) {
        // try to find OBJECT tab in canvas if success - SWF used and it needs to be reloaded
        var cee_canvas = YAHOO.util.Dom.get(this.dashletID+'-canvas');
        if ( typeof cee_canvas != 'undefined' && cee_canvas ) {
            // if there is object tag
            var canvas_objects = YAHOO.util.Dom.getElementsBy(function(el){ return true;}, 'OBJECT', cee_canvas);
            if ( canvas_objects.length != 0 ) {
                this.needsReloadAfterDrop = true;
            }
        }
        chartContainer.innerHTML = '';
    }
    
	dragEl.innerHTML = clickEl.innerHTML;
	dragElObjects = dragEl.getElementsByTagName('object');

	
	dragEl.className = clickEl.className;
	dragEl.style.color = clickEl.style.color;
	dragEl.style.border = "1px solid #aaa";

	// save the style of the object 
	clickElRegion = YAHOO.util.Dom.getRegion(clickEl);
	
	this.borderDiv = document.createElement('div'); // create a div to display border
	this.borderDiv.style.height = (clickElRegion.bottom - clickElRegion.top) + 'px';
	this.borderDiv.style.border = '2px dashed #cccccc';
	
	for(i in clickEl.childNodes) { // hide contents of the target elements contents
		if(typeof clickEl.childNodes[i].style != 'undefined') {
			this.originalDisplayProperties[i] = clickEl.childNodes[i].style.display;
			clickEl.childNodes[i].style.display = 'none';
		}

	}
	clickEl.appendChild(this.borderDiv);
};

ygDDList.prototype.endDrag = function(e) {
	// disable moving the linked element
	var clickEl = this.getEl();

	clickEl.removeChild(this.borderDiv); // remove border div
	
	for(i in clickEl.childNodes) { // show target elements contents
		if(typeof clickEl.childNodes[i].style != 'undefined') {
			clickEl.childNodes[i].style.display = this.originalDisplayProperties[i];
		}
	}
	
	if(this.clickHeight) 
	    clickEl.style.height = this.clickHeight;
	else 
		clickEl.style.height = '';
	
	if(this.clickBorder) 
	    clickEl.style.border = this.clickBorder;
	else 
		clickEl.style.border = '';
		
	dragEl = this.getDragEl();
	dragEl.innerHTML = '';

	this.afterEndDrag(e);
    
    // Bug #47097 : Dashlets not displayed after moving them
    if ( this.needsReloadAfterDrop && this.dashletID ) {
        SUGAR.mySugar.retrieveDashlet(this.dashletID); //"predefined_chart"
    }
};

ygDDList.prototype.afterEndDrag = function(e) {

}

ygDDList.prototype.onDrag = function(e, id) {
    
};

ygDDList.prototype.onDragOver = function(e, id) {
	// this.logger.debug(this.id.toString() + " onDragOver " + id);
	var el;
        
    if ("string" == typeof id) {
        el = YAHOO.util.DDM.getElement(id);
    } else { 
        el = YAHOO.util.DDM.getBestMatch(id).getEl();
    }
    
	dragEl = this.getDragEl();
	elRegion = YAHOO.util.Dom.getRegion(el);
	    
//    this.logger.debug('id: ' + el.id);
//    this.logger.debug('size: ' + (elRegion.bottom - elRegion.top));
//    this.logger.debug('getPosY: ' + YAHOO.util.DDM.getPosY(el));
	var mid = YAHOO.util.DDM.getPosY(el) + (Math.floor((elRegion.bottom - elRegion.top) / 2));
//    this.logger.debug('mid: ' + mid);
    	
//    this.logger.debug(YAHOO.util.DDM.getPosY(dragEl) + " <  " + mid);
//    this.logger.debug("Y: " + YAHOO.util.Event.getPageY(e));
	
	if (YAHOO.util.DDM.getPosY(dragEl) < mid ) { // insert on top triggering item
		var el2 = this.getEl();
		var p = el.parentNode;
		p.insertBefore(el2, el);
	}
	if (YAHOO.util.DDM.getPosY(dragEl) >= mid ) { // insert below triggered item
		var el2 = this.getEl();
		var p = el.parentNode;
		p.insertBefore(el2, el.nextSibling);
	}
};

ygDDList.prototype.onDragEnter = function(e, id) {
	// this.logger.debug(this.id.toString() + " onDragEnter " + id);
	// this.getDragEl().style.border = "1px solid #449629";
};

ygDDList.prototype.onDragOut = function(e, id) {
    // I need to know when we are over nothing
	// this.getDragEl().style.border = "1px solid #964428";
}

/////////////////////////////////////////////////////////////////////////////

function ygDDListBoundary(id, sGroup) {
	if (id) {
		this.init(id, sGroup);
		//this.logger = new ygLogger("ygDDListBoundary");
		this.isBoundary = true;
	}
}

ygDDListBoundary.prototype = new YAHOO.util.DDTarget();
