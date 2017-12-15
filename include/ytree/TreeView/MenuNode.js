/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * A menu-specific implementation that differs from TextNode in that only 
 * one sibling can be expanded at a time.
 * @extends YAHOO.widget.TextNode
 * @constructor
 */
YAHOO.widget.MenuNode = function(oData, oParent, expanded) {
	if (oParent) { 
		this.init(oData, oParent, expanded);
		this.setUpLabel(oData);
	}

    /**
     * Menus usually allow only one branch to be open at a time.
     * @type boolean
     */
	this.multiExpand = false;

};

YAHOO.widget.MenuNode.prototype = new YAHOO.widget.TextNode();

