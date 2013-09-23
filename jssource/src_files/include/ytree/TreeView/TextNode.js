/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * The default node presentation.  The first parameter should be
 * either a string that will be used as the node's label, or an object
 * that has a string propery called label.  By default, the clicking the
 * label will toggle the expanded/collapsed state of the node.  By
 * changing the href property of the instance, this behavior can be
 * changed so that the label will go to the specified href.
 *
 * @extends YAHOO.widget.Node
 * @constructor
 * @param oData {object} a string or object containing the data that will
 * be used to render this node
 * @param oParent {YAHOO.widget.Node} this node's parent node
 * @param expanded {boolean} the initial expanded/collapsed state
 */
YAHOO.widget.TextNode = function(oData, oParent, expanded) {
	if (oParent) { 
		this.init(oData, oParent, expanded);
		this.setUpLabel(oData);
	}
};

YAHOO.widget.TextNode.prototype = new YAHOO.widget.Node();

/**
 * The CSS class for the label href.  Defaults to ygtvlabel, but can be
 * overridden to provide a custom presentation for a specific node.
 *
 * @type string
 */
YAHOO.widget.TextNode.prototype.labelStyle = "ygtvlabel";

/**
 * The derived element id of the label for this node
 *
 * @type string
 */
YAHOO.widget.TextNode.prototype.labelElId = null;

/**
 * The text for the label.  It is assumed that the oData parameter will
 * either be a string that will be used as the label, or an object that
 * has a property called "label" that we will use.
 *
 * @type string
 */
YAHOO.widget.TextNode.prototype.label = null;

/**
 * Sets up the node label
 * 
 * @param oData string containing the label, or an object with a label property
 */
YAHOO.widget.TextNode.prototype.setUpLabel = function(oData) { 
	if (typeof oData == "string") {
		oData = { label: oData };
	}
	this.label = oData.label;
	
	// update the link
	if (oData.href) {
		this.href = oData.href;
	}

	// set the target
	if (oData.target) {
		this.target = oData.target;
	}

	this.labelElId = "ygtvlabelel" + this.index;
};

/**
 * Returns the label element
 *
 * @return {object} the element
 */
YAHOO.widget.TextNode.prototype.getLabelEl = function() { 
	return document.getElementById(this.labelElId);
};

// overrides YAHOO.widget.Node
YAHOO.widget.TextNode.prototype.getNodeHtml = function() { 
	var sb = new Array();

	sb[sb.length] = '<table border="0" cellpadding="0" cellspacing="0">';
	sb[sb.length] = '<tr>';
	
	for (i=0;i<this.depth;++i) {
		// sb[sb.length] = '<td class="ygtvdepthcell">&nbsp;</td>';
		sb[sb.length] = '<td class="' + this.getDepthStyle(i) + '">&nbsp;</td>';
	}

	var getNode = 'YAHOO.widget.TreeView.getNode(\'' +
					this.tree.id + '\',' + this.index + ')';

	sb[sb.length] = '<td';
	// sb[sb.length] = ' onselectstart="return false"';
	sb[sb.length] = ' id="' + this.getToggleElId() + '"';
	sb[sb.length] = ' class="' + this.getStyle() + '"';
	if (this.hasChildren(true)) {
		sb[sb.length] = ' onmouseover="this.className=';
		sb[sb.length] = getNode + '.getHoverStyle()"';
		sb[sb.length] = ' onmouseout="this.className=';
		sb[sb.length] = getNode + '.getStyle()"';
	}
	sb[sb.length] = ' onclick="javascript:' + this.getToggleLink() + '">&nbsp;';
	sb[sb.length] = '</td>';
	sb[sb.length] = '<td>';
	sb[sb.length] = '<a';
	sb[sb.length] = ' id="' + this.labelElId + '"';
	sb[sb.length] = ' class="' + this.labelStyle + '"';
//	sb[sb.length] = ' href="' + this.href + '"';
	sb[sb.length] = ' href="javascript:set_selected_node(\''+this.tree.id + '\',\''+this.index+'\');'+ this.href +'"';
	sb[sb.length] = ' target="' + this.target + '"';
	if (this.hasChildren(true)) {
		sb[sb.length] = ' onmouseover="document.getElementById(\'';
		sb[sb.length] = this.getToggleElId() + '\').className=';
		sb[sb.length] = getNode + '.getHoverStyle()"';
		sb[sb.length] = ' onmouseout="document.getElementById(\'';
		sb[sb.length] = this.getToggleElId() + '\').className=';
		sb[sb.length] = getNode + '.getStyle()"';
	}
	sb[sb.length] = ' >';
	sb[sb.length] = this.label;
	sb[sb.length] = '</a>';
	sb[sb.length] = '</td>';
	sb[sb.length] = '</tr>';
	sb[sb.length] = '</table>';

	return sb.join("");
};

