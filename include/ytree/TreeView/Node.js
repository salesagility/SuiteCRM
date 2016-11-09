/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * The base class for all tree nodes.  The node's presentation and behavior in
 * response to mouse events is handled in Node subclasses.
 *
 * @param oData {object} a string or object containing the data that will
 * be used to render this node
 * @param oParent {Node} this node's parent node
 * @param expanded {boolean} the initial expanded/collapsed state
 * @constructor
 */
YAHOO.widget.Node = function(oData, oParent, expanded) {
	if (oParent) { this.init(oData, oParent, expanded); }
};

YAHOO.widget.Node.prototype = {

    /**
     * The index for this instance obtained from global counter in YAHOO.widget.TreeView.
     *
     * @type int
     */
    index: 0,

    /**
     * This node's child node collection.
     *
     * @type Node[] 
     */
    children: null,

    /**
     * Tree instance this node is part of
     *
     * @type TreeView
     */
    tree: null,

    /**
     * The data linked to this node.  This can be any object or primitive
     * value, and the data can be used in getNodeHtml().
     *
     * @type object
     */
    data: null,

    /**
     * Parent node
     *
     * @type Node
     */
    parent: null,

    /**
     * The depth of this node.  We start at -1 for the root node.
     *
     * @type int
     */
    depth: -1,

    /**
     * The href for the node's label.  If one is not specified, the href will
     * be set so that it toggles the node.
     *
     * @type string
     */
    href: null,

    /**
     * The label href target, defaults to current window
     *
     * @type string
     */
    target: "_self",

    /**
     * The node's expanded/collapsed state
     *
     * @type boolean
     */
    expanded: false,

    /**
     * Can multiple children be expanded at once?
     *
     * @type boolean
     */
    multiExpand: true,

    /**
     * Should we render children for a collapsed node?  It is possible that the
     * implementer will want to render the hidden data...  @todo verify that we 
     * need this, and implement it if we do.
     *
     * @type boolean
     */
    renderHidden: false,

    /**
     * Flag that is set to true the first time this node's children are rendered.
     *
     * @type boolean
     */
    childrenRendered: false,

    /**
     * This node's previous sibling
     *
     * @type Node
     */
    previousSibling: null,

    /**
     * This node's next sibling
     *
     * @type Node
     */
    nextSibling: null,

    /**
     * We can set the node up to call an external method to get the child
     * data dynamically.
     *
     * @type boolean
     * @private
     */
    _dynLoad: false,

    /**
     * Function to execute when we need to get this node's child data.
     *
     * @type function
     */
    dataLoader: null,

    /**
     * This is true for dynamically loading nodes while waiting for the
     * callback to return.
     *
     * @type boolean
     */
    isLoading: false,

    /**
     * The toggle/branch icon will not show if this is set to false.  This
     * could be useful if the implementer wants to have the child contain
     * extra info about the parent, rather than an actual node.
     *
     * @type boolean
     */
    hasIcon: true,

    /**
     * Initializes this node, gets some of the properties from the parent
     *
     * @param oData {object} a string or object containing the data that will
     * be used to render this node
     * @param oParent {Node} this node's parent node
     * @param expanded {boolean} the initial expanded/collapsed state
     */
    init: function(oData, oParent, expanded) {
        this.data		= oData;
        this.children	= [];
        this.index		= YAHOO.widget.TreeView.nodeCount;
        ++YAHOO.widget.TreeView.nodeCount;
        this.logger		= new ygLogger("Node");
        this.expanded	= expanded;

        // oParent should never be null except when we create the root node.
        if (oParent) {
            this.tree			= oParent.tree;
            this.parent			= oParent;
            this.href			= "javascript:" + this.getToggleLink();
            this.depth			= oParent.depth + 1;
            this.multiExpand	= oParent.multiExpand;

            oParent.appendChild(this);
        }
    },

    /**
     * Appends a node to the child collection.
     *
     * @param node {Node} the new node
     * @return {Node} the child node
     * @private
     */
    appendChild: function(node) {
        if (this.hasChildren()) {
            var sib = this.children[this.children.length - 1];
            sib.nextSibling = node;
            node.previousSibling = sib;
        }

        this.tree.regNode(node);
        this.children[this.children.length] = node;
        return node;

    },

    /**
     * Returns a node array of this node's siblings, null if none.
     *
     * @return Node[]
     */
    getSiblings: function() {
        return this.parent.children;
    },

    /**
     * Shows this node's children
     */
    showChildren: function() {
        if (!this.tree.animateExpand(this.getChildrenEl())) {
            if (this.hasChildren()) {
                this.getChildrenEl().style.display = "";
            }
        }
    },

    /**
     * Hides this node's children
     */
    hideChildren: function() {
        this.logger.debug("hiding " + this.index);

        if (!this.tree.animateCollapse(this.getChildrenEl())) {
            this.getChildrenEl().style.display = "none";
        }
    },

    /**
     * Returns the id for this node's container div
     *
     * @return {string} the element id
     */
    getElId: function() {
        return "ygtv" + this.index;
    },

    /**
     * Returns the id for this node's children div
     *
     * @return {string} the element id for this node's children div
     */
    getChildrenElId: function() {
        return "ygtvc" + this.index;
    },

    /**
     * Returns the id for this node's toggle element
     *
     * @return {string} the toggel element id
     */
    getToggleElId: function() {
        return "ygtvt" + this.index;
    },

    /**
     * Returns this node's container html element
     *
     * @return {HTMLElement} the container html element
     */
    getEl: function() {
        return document.getElementById(this.getElId());
    },

    /**
     * Returns the div that was generated for this node's children
     *
     * @return {HTMLElement} this node's children div
     */
    getChildrenEl: function() {
        return document.getElementById(this.getChildrenElId());
    },

    /**
     * Returns the element that is being used for this node's toggle.
     *
     * @return {HTMLElement} this node's toggel html element
     */
    getToggleEl: function() {
        return document.getElementById(this.getToggleElId());
    },

    /**
     * Generates the link that will invoke this node's toggle method
     *
     * @return {string} the javascript url for toggling this node
     */
    getToggleLink: function() {
        return "YAHOO.widget.TreeView.getNode(\'" + this.tree.id + "\'," + 
            this.index + ").toggle()";
    },

    /**
     * Hides this nodes children (creating them if necessary), changes the
     * toggle style.
     */
    collapse: function() {
        // Only collapse if currently expanded
        if (!this.expanded) { return; }

        if (!this.getEl()) {
            this.expanded = false;
            return;
        }

        // hide the child div
        this.hideChildren();
        this.expanded = false;

        if (this.hasIcon) {
            this.getToggleEl().className = this.getStyle();
        }

        // fire the collapse event handler
        this.tree.onCollapse(this);
    },

    /**
     * Shows this nodes children (creating them if necessary), changes the
     * toggle style, and collapses its siblings if multiExpand is not set.
     */
    expand: function() {
        // Only expand if currently collapsed.
        if (this.expanded) { return; }

        if (!this.getEl()) {
            this.expanded = true;
            return;
        }

        if (! this.childrenRendered) {
            this.getChildrenEl().innerHTML = this.renderChildren();
        }

        this.expanded = true;
        if (this.hasIcon) {
            this.getToggleEl().className = this.getStyle();
        }

        // We do an extra check for children here because the lazy
        // load feature can expose nodes that have no children.

        // if (!this.hasChildren()) {
        if (this.isLoading) {
            this.expanded = false;
            return;
        }

        if (! this.multiExpand) {
            var sibs = this.getSiblings();
            for (var i=0; i<sibs.length; ++i) {
                if (sibs[i] != this && sibs[i].expanded) { 
                    sibs[i].collapse(); 
                }
            }
        }

        this.showChildren();

        // fire the expand event handler
        this.tree.onExpand(this);
    },

    /**
     * Returns the css style name for the toggle
     *
     * @return {string} the css class for this node's toggle
     */
    getStyle: function() {
        if (this.isLoading) {
            this.logger.debug("returning the loading icon");
            return "ygtvloading";
        } else {
            // location top or bottom, middle nodes also get the top style
            var loc = (this.nextSibling) ? "t" : "l";

            // type p=plus(expand), m=minus(collapase), n=none(no children)
            var type = "n";
            if (this.hasChildren(true) || this.isDynamic()) {
                type = (this.expanded) ? "m" : "p";
            }

            this.logger.debug("ygtv" + loc + type);
            return "ygtv" + loc + type;
        }
    },

    /**
     * Returns the hover style for the icon
     * @return {string} the css class hover state
     */
    getHoverStyle: function() { 
        var s = this.getStyle();
        if (this.hasChildren(true) && !this.isLoading) { 
            s += "h"; 
        }
        return s;
    },

    /**
     * Recursively expands all of this node's children.
     */
    expandAll: function() { 
        for (var i=0;i<this.children.length;++i) {
            var c = this.children[i];
            if (c.isDynamic()) {
                alert("Not supported (lazy load + expand all)");
                break;
            } else if (! c.multiExpand) {
                alert("Not supported (no multi-expand + expand all)");
                break;
            } else {
                c.expand();
                c.expandAll();
            }
        }
    },

    /**
     * Recursively collapses all of this node's children.
     */
    collapseAll: function() { 
        for (var i=0;i<this.children.length;++i) {
            this.children[i].collapse();
            this.children[i].collapseAll();
        }
    },

    /**
     * Configures this node for dynamically obtaining the child data
     * when the node is first expanded.
     *
     * @param fmDataLoader {function} the function that will be used to get the data.
     */
    setDynamicLoad: function(fnDataLoader) { 
        this.dataLoader = fnDataLoader;
        this._dynLoad = true;
    },

    /**
     * Evaluates if this node is the root node of the tree
     *
     * @return {boolean} true if this is the root node
     */
    isRoot: function() { 
        return (this == this.tree.root);
    },

    /**
     * Evaluates if this node's children should be loaded dynamically.  Looks for
     * the property both in this instance and the root node.  If the tree is
     * defined to load all children dynamically, the data callback function is
     * defined in the root node
     *
     * @return {boolean} true if this node's children are to be loaded dynamically
     */
    isDynamic: function() { 
        var lazy = (!this.isRoot() && (this._dynLoad || this.tree.root._dynLoad));
        // this.logger.debug("isDynamic: " + lazy);
        return lazy;
    },

    /**
     * Checks if this node has children.  If this node is lazy-loading and the
     * children have not been rendered, we do not know whether or not there
     * are actual children.  In most cases, we need to assume that there are
     * children (for instance, the toggle needs to show the expandable 
     * presentation state).  In other times we want to know if there are rendered
     * children.  For the latter, "checkForLazyLoad" should be false.
     *
     * @param checkForLazyLoad {boolean} should we check for unloaded children?
     * @return {boolean} true if this has children or if it might and we are
     * checking for this condition.
     */
    hasChildren: function(checkForLazyLoad) { 
        return ( this.children.length > 0 || 
                (checkForLazyLoad && this.isDynamic() && !this.childrenRendered) );
    },

    /**
     * Expands if node is collapsed, collapses otherwise.
     */
    toggle: function() {
        if (!this.tree.locked && ( this.hasChildren(true) || this.isDynamic()) ) {
            if (this.expanded) { this.collapse(); } else { this.expand(); }
        }
    },

    /**
     * Returns the markup for this node and its children.
     *
     * @return {string} the markup for this node and its expanded children.
     */
    getHtml: function() {
        var sb = [];
        sb[sb.length] = '<div class="ygtvitem" id="' + this.getElId() + '">';
        sb[sb.length] = this.getNodeHtml();
        sb[sb.length] = this.getChildrenHtml();
        sb[sb.length] = '</div>';
        return sb.join("");
    },

    /**
     * Called when first rendering the tree.  We always build the div that will
     * contain this nodes children, but we don't render the children themselves
     * unless this node is expanded.
     *
     * @return {string} the children container div html and any expanded children
     * @private
     */
    getChildrenHtml: function() {
        var sb = [];
        sb[sb.length] = '<div class="ygtvchildren"';
        sb[sb.length] = ' id="' + this.getChildrenElId() + '"';
        if (!this.expanded) {
            sb[sb.length] = ' style="display:none;"';
        }
        sb[sb.length] = '>';

        // Don't render the actual child node HTML unless this node is expanded.
        if (this.hasChildren(true) && this.expanded) {
            sb[sb.length] = this.renderChildren();
        }

        sb[sb.length] = '</div>';

        return sb.join("");
    },

    /**
     * Generates the markup for the child nodes.  This is not done until the node
     * is expanded.
     *
     * @return {string} the html for this node's children
     * @private
     */
    renderChildren: function() {

        this.logger.debug("rendering children for " + this.index);

        var node = this;

        if (this.isDynamic() && !this.childrenRendered) {
            this.isLoading = true;
            this.tree.locked = true;

            if (this.dataLoader) {
                this.logger.debug("Using dynamic loader defined for this node");
                setTimeout( 
                    function() {
                        node.dataLoader(node, 
                            function() { 
                                node.loadComplete(); 
                            });
                    }, 10);
                
            } else if (this.tree.root.dataLoader) {
                this.logger.debug("Using the tree-level dynamic loader");

                setTimeout( 
                    function() {
                        node.tree.root.dataLoader(node, 
                            function() { 
                                node.loadComplete(); 
                            });
                    }, 10);

            } else {
                this.logger.debug("no loader found");
                return "Error: data loader not found or not specified.";
            }

            return "";

        } else {
            return this.completeRender();
        }
    },

    /**
     * Called when we know we have all the child data.
     * @return {string} children html
     */
    completeRender: function() {
        this.logger.debug("renderComplete: " + this.index);
        var sb = [];

        for (var i=0; i < this.children.length; ++i) {
            sb[sb.length] = this.children[i].getHtml();
        }
        
        this.childrenRendered = true;

        return sb.join("");
    },

    /**
     * Load complete is the callback function we pass to the data provider
     * in dynamic load situations.
     */
    loadComplete: function() {
        this.logger.debug("loadComplete: " + this.index);
        this.getChildrenEl().innerHTML = this.completeRender();
        this.isLoading = false;
        this.expand();
        this.tree.locked = false;
    },

    /**
     * Returns this node's ancestor at the specified depth.
     *
     * @param {int} depth the depth of the ancestor.
     * @return {Node} the ancestor
     */
    getAncestor: function(depth) {
        if (depth >= this.depth || depth < 0)  {
            this.logger.debug("illegal getAncestor depth: " + depth);
            return null;
        }

        var p = this.parent;
        
        while (p.depth > depth) {
            p = p.parent;
        }

        return p;
    },

    /**
     * Returns the css class for the spacer at the specified depth for
     * this node.  If this node's ancestor at the specified depth
     * has a next sibling the presentation is different than if it
     * does not have a next sibling
     *
     * @param {int} depth the depth of the ancestor.
     * @return {string} the css class for the spacer
     */
    getDepthStyle: function(depth) {
        return (this.getAncestor(depth).nextSibling) ? 
            "ygtvdepthcell" : "ygtvblankdepthcell";
    },

    /**
     * Get the markup for the node.  This is designed to be overrided so that we can
     * support different types of nodes.
     *
     * @return {string} The HTML that will render this node.
     */
    getNodeHtml: function() { 
        return ""; 
    }

};

