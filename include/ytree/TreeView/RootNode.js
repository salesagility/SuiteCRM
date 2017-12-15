/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * A custom YAHOO.widget.Node that handles the unique nature of 
 * the virtual, presentationless root node.
 *
 * @extends YAHOO.widget.Node
 * @constructor
 */
YAHOO.widget.RootNode = function(oTree) {
	// Initialize the node with null params.  The root node is a
	// special case where the node has no presentation.  So we have
	// to alter the standard properties a bit.
	this.init(null, null, true);
	
	/**
	 * For the root node, we get the tree reference from as a param
	 * to the constructor instead of from the parent element.
	 *
	 * @type TreeView
	 */
	this.tree = oTree;
};
YAHOO.widget.RootNode.prototype = new YAHOO.widget.Node();

// overrides YAHOO.widget.Node
YAHOO.widget.RootNode.prototype.getNodeHtml = function() { 
	return ""; 
};

