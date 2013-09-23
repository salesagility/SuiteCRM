/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * This implementation takes either a string or object for the
 * oData argument.  If is it a string, we will use it for the display
 * of this node (and it can contain any html code).  If the parameter
 * is an object, we look for a parameter called "html" that will be
 * used for this node's display.
 *
 * @extends YAHOO.widget.Node
 * @constructor
 * @param oData {object} a string or object containing the data that will
 * be used to render this node
 * @param oParent {YAHOO.widget.Node} this node's parent node
 * @param expanded {boolean} the initial expanded/collapsed state
 * @param hasIcon {boolean} specifies whether or not leaf nodes should
 * have an icon
 */
YAHOO.widget.HTMLNode = function(oData, oParent, expanded, hasIcon) {
	if (oParent) { 
		this.init(oData, oParent, expanded);
		this.initContent(oData, hasIcon);
	}
};

YAHOO.widget.HTMLNode.prototype = new YAHOO.widget.Node();

/**
 * The CSS class for the label href.  Defaults to ygtvlabel, but can be
 * overridden to provide a custom presentation for a specific node.
 *
 * @type string
 */
YAHOO.widget.HTMLNode.prototype.contentStyle = "ygtvhtml";

/**
 * The generated id that will contain the data passed in by the implementer.
 *
 * @type string
 */
YAHOO.widget.HTMLNode.prototype.contentElId = null;

/**
 * The HTML content to use for this node's display
 *
 * @type string
 */
YAHOO.widget.HTMLNode.prototype.content = null;

/**
 * Sets up the node label
 *
 * @param {object} An html string or object containing an html property
 * @param {boolean} hasIcon determines if the node will be rendered with an
 * icon or not
 */
YAHOO.widget.HTMLNode.prototype.initContent = function(oData, hasIcon) { 
	if (typeof oData == "string") {
		oData = { html: oData };
	}

	this.html = oData.html;
	this.contentElId = "ygtvcontentel" + this.index;
	this.hasIcon = hasIcon;
};

/**
 * Returns the outer html element for this node's content
 *
 * @return {HTMLElement} the element
 */
YAHOO.widget.HTMLNode.prototype.getContentEl = function() { 
	return document.getElementById(this.contentElId);
};

// overrides YAHOO.widget.Node
YAHOO.widget.HTMLNode.prototype.getNodeHtml = function() { 
	var sb = new Array();

	sb[sb.length] = '<table border="0" cellpadding="0" cellspacing="0">';
	sb[sb.length] = '<tr>';
	
	for (i=0;i<this.depth;++i) {
		sb[sb.length] = '<td class="' + this.getDepthStyle(i) + '">&nbsp;</td>';
	}

	if (this.hasIcon) {
		sb[sb.length] = '<td';
		sb[sb.length] = ' id="' + this.getToggleElId() + '"';
		sb[sb.length] = ' class="' + this.getStyle() + '"';
		sb[sb.length] = ' onclick="javascript:' + this.getToggleLink() + '">&nbsp;';
		if (this.hasChildren(true)) {
			sb[sb.length] = ' onmouseover="this.className=';
			sb[sb.length] = 'YAHOO.widget.TreeView.getNode(\'';
			sb[sb.length] = this.tree.id + '\',' + this.index +  ').getHoverStyle()"';
			sb[sb.length] = ' onmouseout="this.className=';
			sb[sb.length] = 'YAHOO.widget.TreeView.getNode(\'';
			sb[sb.length] = this.tree.id + '\',' + this.index +  ').getStyle()"';
		}
		sb[sb.length] = '</td>';
	}

	sb[sb.length] = '<td';
	sb[sb.length] = ' id="' + this.contentElId + '"';
	sb[sb.length] = ' class="' + this.contentStyle + '"';
	sb[sb.length] = ' >';
	sb[sb.length] = this.html;
	sb[sb.length] = '</td>';
	sb[sb.length] = '</tr>';
	sb[sb.length] = '</table>';

	return sb.join("");
};

