/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/

function gridInit() {
	if(SUGAR.email2.grid) {
		SUGAR.email2.grid.destroy();
	}

	e2Grid = {
		init : function() {

			var Ck = YAHOO.util.Cookie;
			var widths = [ 10, 10, 150, 250, 175, 125 ];

			if (Ck.get("EmailGridWidths")) {
				for (var i=0; i < widths.length; i++) {
					widths[i] = Ck.getSub("EmailGridWidths", i+ "", Number);
				}
			} else {
				for (var i=0; i < widths.length; i++) {
					Ck.setSub("EmailGridWidths", i + "", widths[i], {expires: SUGAR.email2.nextYear});
				}
			}

			// changes "F" to an icon
			function flaggedIcon(cell, record, column, value) {
				if(value != "") {
					cell.innerHTML = "<span style='color: #f00; font-weight:bold;'>!</span>";
				}
			}
			// changes "A" to replied icon
			function repliedIcon(cell, record, column, value) {
				if(value != "") {
					cell.innerHTML = "<img src='index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=export.gif' class='image' border='0' width='10' align='absmiddle'>";
				}
			}
	        function attachIcon(cell, record, column, value) {
				if(value == "1") {
					cell.innerHTML = "<img src='index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=attachment.gif' class='image' border='0' width='10' align='absmiddle'>";
				}
			}

			var colModel =
				[
					{
						label: "<h2><img src='index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=attachment.gif' class='image' border='0' width='10' align='absmiddle'></h2>",
						width: 10,
						sortable: false,
						fixed: true,
						resizeable: true,
						formatter: attachIcon,
						key: 'hasAttach'
					},
				    {
						label: "<span style='color: #f00; font-weight:bold;'>!</span>",
						width: widths[0],
						sortable: true,
						fixed: true,
						resizeable: true,
						formatter: flaggedIcon,
						key: 'flagged'
					},
					{
						label: "<img src='index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=export.gif' class='image' border='0' width='10' align='absmiddle'>",
						width: widths[1],
						sortable: true,
						fixed: true,
						resizeable: true,
						formatter: repliedIcon,
						key: 'status'
					},
					{
						label: app_strings.LBL_EMAIL_FROM,
						width: widths[2],
						sortable: true,
						resizeable: true,
						key: 'from'
					},
					{
						label: app_strings.LBL_EMAIL_SUBJECT,
						width: widths[3],
						sortable: true,
						resizeable: true,
						key: 'subject'
					},
					{
						label: mod_strings.LBL_LIST_DATE,
						width: widths[4],
						sortable: true,
						resizeable: true,
                        key: 'date'
					},
					{
						label: app_strings.LBL_EMAIL_TO,
						width: widths[5],
						sortable: false,
						resizeable: true,
                        key: 'to_addrs'
					},
					{
						label: 'uid',
						hidden: true,
                        key: 'uid'
					},
					{
						label: 'mbox',
						hidden: true,
                        key: 'mbox'
					},
					{
						label: 'ieId',
						hidden: true,
                        key: 'ieId'
					},
					{
						label: 'site_url',
						hidden: true,
                        key: 'site_url'
					},
					{	label: 'seen',
						hidden: true,
                        key: 'seen'
					},
					{	label: 'type',
						hidden: true,
                        key: 'type'
					}
				];

			var dataModel = new YAHOO.util.DataSource(urlBase + "?", {
				responseType: YAHOO.util.DataSource.TYPE_JSON,
				responseSchema: {
				    resultsList: 'Email',
		            fields: ['flagged', 'status', 'from', 'subject', 'date','to_addrs', 'uid', 'mbox', 'ieId', 'site_url', 'seen', 'type', 'AssignedTo','hasAttach'],
		            metaFields: {total: 'TotalCount', unread:"UnreadCount", fromCache: "FromCache"}
				}
		    });
			var params = {
					to_pdf : "true",
					module : "Emails",
					action : "EmailUIAjax",
					emailUIAction : "getMessageList",
					mbox : "INBOX",
					ieId : "",
					forceRefresh : "false"
			};
			if(lazyLoadFolder != null) {
				params['mbox'] = lazyLoadFolder.folder;
				params['ieId'] = lazyLoadFolder.ieId;
				//Check if the folder is a Sugar Folder
				var test = new String(lazyLoadFolder.folder);
				if(test.match(/SUGAR\./)) {
					params['emailUIAction'] = 'getMessageListSugarFolders';
					params['mbox'] = test.substr(6);
				}
			}
			//dataModel.initPaging(urlBase, SUGAR.email2.userPrefs.emailSettings.showNumInList);

			// create the Grid
			var grid = SUGAR.email2.grid = new YAHOO.SUGAR.SelectionGrid('emailGrid', colModel, dataModel, {
				MSG_EMPTY: SUGAR.language.get("Emails", "LBL_EMPTY_FOLDER"),
				dynamicData: true,
				paginator: new YAHOO.widget.Paginator({
					rowsPerPage:parseInt(SUGAR.email2.userPrefs.emailSettings.showNumInList),
					containers : ["dt-pag-nav"],
					template: "<div class='pagination'>{FirstPageLink} {PreviousPageLink} {PageLinks} {NextPageLink} {LastPageLink}</div>",
					firstPageLinkLabel: 	"<button class='button'><div class='paginator-start'/></button>",
					previousPageLinkLabel: 	"<button class='button'><div class='paginator-previous'/></button>",
					nextPageLinkLabel: 		"<button class='button'><div class='paginator-next'/></button>",
					lastPageLinkLabel: 		"<button class='button'><div class='paginator-end'/></button>"
				}),
                initialRequest:SUGAR.util.paramsToUrl(params),
				width:  "800px",
				height: "400px"
			});

			initRowDD();

			//Override Paging request construction
			grid.set("generateRequest", function(oState, oSelf) {
	            oState = oState || {pagination:null, sortedBy:null};
	            var sort = (oState.sortedBy) ? oState.sortedBy.key : oSelf.getColumnSet().keys[5].getKey();
	            var dir = (oState.sortedBy && oState.sortedBy.dir === YAHOO.widget.DataTable.CLASS_ASC) ? "asc" : "desc";
	            var startIndex = (oState.pagination) ? oState.pagination.recordOffset : 0;
	            var results = (oState.pagination) ? oState.pagination.rowsPerPage : null;
	            // Build the request
	            var ret =
		            SUGAR.util.paramsToUrl(oSelf.params) +
		            "&sort=" + sort +
	                "&dir=" + dir +
	                "&start=" + startIndex +
	                ((results !== null) ? "&limit=" + results : "");
	            return  ret;
	        });


			grid.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
				oPayload = oPayload || { };

				oPayload.totalRecords = oResponse.meta.total;
				oPayload.unreadRecords = oResponse.meta.unread;

		        var tabObject = SE.innerLayout.get("tabs")[0];
		        var mboxTitle = "";
		        if (this.params.mbox != null) {
		        	mboxTitle = this.params.mbox;
		        }
		        var tabtext = mboxTitle + " (" + oResponse.meta.total + " " + app_strings.LBL_EMAIL_MESSAGES + " )";
		        tabObject.get("labelEl").firstChild.data = tabtext;

		        if (SE.tree) {
			        var node = SE.tree.getNodeByProperty('id', this.params.ieId) || SE.tree.getNodeByProperty('origText', this.params.mbox);
			        if (node) {
				        node.data.unseen = oResponse.meta.unread;
				        SE.accounts.renderTree();
			        }
		        }
				return oPayload;
			}

			var resize = grid.resizeGrid = function () {
				SUGAR.email2.grid.set("width",  SUGAR.email2.grid.get("element").parentNode.clientWidth + "px");
				SUGAR.email2.grid.set("height", (SUGAR.email2.grid.get("element").parentNode.clientHeight - 47) + "px");
			}
			grid.convertDDRows = function() {
				var rowEl = this.getFirstTrEl();
				while (rowEl != null) {
					new this.DDRow(this, this.getRecord(rowEl), rowEl);
					rowEl = this.getNextTrEl(rowEl);
				}
			}


			grid.on("columnResizeEvent", function(o) {
				//Find the index of the column
				var colSet = SUGAR.email2.grid.getColumnSet().flat;
				for (var i=0; i < colSet.length; i++) {
					if (o.column == colSet[i]) {
						//Store it in the cookie
						Ck.setSub("EmailGridWidths", i + "", o.width, {expires: SUGAR.email2.nextYear});
					}
				}
				//this.resizeGrid();
			}, null, grid);

			grid.on("postRenderEvent", function() {this.convertDDRows()}, null, grid);
			grid.on("rowClickEvent", SUGAR.email2.listView.handleClick);
			grid.on("rowDblclickEvent", SUGAR.email2.listView.getEmail);
			grid.render();
			SUGAR.email2.listViewLayout.on("render", resize);
			resize();

			//Setup the default load parameters
			SUGAR.email2.grid.params = params;

			grid.on('postRenderEvent', SUGAR.email2.listView.setEmailListStyles);
			dataModel.subscribe("requestEvent", grid.disable, grid, true);
			dataModel.subscribe("responseParseEvent", grid.undisable, grid, true);
		}
	};
	e2Grid.init();
};


function initRowDD() {
	var sg = SUGAR.email2.grid,
	Dom = YAHOO.util.Dom;
	sg.DDRow = function(oDataTable, oRecord, elTr) {
		if(oDataTable && oRecord && elTr) {
			this.ddtable = oDataTable;
	        this.table = oDataTable.getTableEl();
	        this.row = oRecord;
	        this.rowEl = elTr;
	        this.newIndex = null;
	        this.init(elTr);
	        this.initFrame(); // Needed for DDProxy
	        this.invalidHandleTypes = {};
	    }
	};

	YAHOO.extend(sg.DDRow, YAHOO.util.DDProxy, {
	    _resizeProxy: function() {
	        this.constructor.superclass._resizeProxy.apply(this, arguments);
	        var dragEl = this.getDragEl(),
	            el = this.getEl();
	        var xy = Dom.getXY(el);

	        Dom.setStyle(dragEl, 'height', this.rowEl.offsetHeight + "px");
	        Dom.setStyle(dragEl, 'width', (parseInt(Dom.getStyle(dragEl, 'width'),10) + 4) + 'px');
	        Dom.setXY(dragEl, [xy[0] - 100, xy[1] - 20] );
	        Dom.setStyle(dragEl, 'display', "");
	    },

	    startDrag: function(x, y) {
	    	//Check if we should be dragging a set of rows rather than just the one.
	    	var selectedRows = this.ddtable.getSelectedRows();
	    	var iSelected = false;
	    	for (var i in selectedRows) {
	    		if (this.rowEl.id == selectedRows[i]) {
	    			iSelected = true;
	    			break
	    		}
	    	}
	    	if (iSelected) {
	    		this.rows = [];
	    		for (var i in selectedRows) {
	    			this.rows[i] = this.ddtable.getRecord(selectedRows[i]);
		    	}
	    	} else {
	    		this.rows = [this.row];
	    		this.ddtable.unselectAllRows();
	    		this.ddtable.selectRow(this.row);
	    	}

	    	//Initialize the dragable proxy
	    	var dragEl = this.getDragEl();
	        var clickEl = this.getEl();
	        Dom.setStyle(clickEl, "opacity", "0.25");
	        dragEl.innerHTML = "<table><tr>" + clickEl.innerHTML + "</tr></table>";
	    	Dom.addClass(dragEl, "yui-dt-liner");
	    	Dom.setStyle(dragEl, "opacity", "0.5");
	        Dom.setStyle(dragEl, "height", (clickEl.clientHeight - 2) + "px");
	        Dom.setStyle(dragEl, "backgroundColor", Dom.getStyle(clickEl, "backgroundColor"));
	  	    Dom.setStyle(dragEl, "border", "2px solid gray");
	    },

	    clickValidator: function(e) {
	    	if (this.row.getData()[0] == " ")
	    		return false;
	        var target = YAHOO.util.Event.getTarget(e);
	    	return ( this.isValidHandleChild(target) &&
	    			(this.id == this.handleElId || this.DDM.handleWasClicked(target, this.id)) );
	    },
	    /**
	     * This function checks that the target of the drag is a table row in this
	     * DDGroup and simply moves the sourceEL to that location as a preview.
	     */
	    onDragOver: function(ev, id) {
	    	var node = SUGAR.email2.tree.getNodeByElement(Dom.get(id));
	    	if (node && node != this.targetNode) {
	    		this.targetNode = node;
	    		SUGAR.email2.folders.unhighliteAll();
	    		node.highlight();
	    	}
	    },

	    onDragOut: function(e, id) {
	    	if (this.targetNode) {
	    		SUGAR.email2.folders.unhighliteAll();
	    		this.targetNode = false;
	    	}
	    },
	    endDrag: function() {
	    	Dom.setStyle(this.getEl(), "opacity", "");
	    	Dom.setStyle(this.getDragEl(), "display", "none");
	    	if (this.targetNode) {
	    		SUGAR.email2.folders.handleDrop(this.rows, this.targetNode);
	    	}
	    	SUGAR.email2.folders.unhighliteAll();
	    	this.rows = null;
	    }
	});
}

function AddressSearchGridInit() {
    function moduleIcon(elCell, oRecord, oColumn, oData) {
    	elCell.innerHTML = "<img src='index.php?entryPoint=getImage&themeName="+SUGAR.themes.theme_name+"&imageName=" + oData + ".gif' class='image' border='0' width='16' align='absmiddle'>";
    };
    function selectionCheckBox(elCell, oRecord, oColumn, oData) {
        elCell.innerHTML =  '<input type="checkbox" onclick="SUGAR.email2.addressBook.grid.toggleSelectCheckbox(\'' + oRecord.getId() + '\', this.checked);">';
    };
    var checkHeader = '<input type="checkbox" ';
    if (SUGAR.email2.util.isIe()) {
        checkHeader += 'style="top:-5px" ';
    }
    checkHeader += 'onclick="SUGAR.email2.addressBook.grid.toggleSelectAll(this.checked);">';
    var colModel =
	    [{
	    	label: checkHeader,
            width: 30,
            formatter: selectionCheckBox,
            key: 'bean_id'
        },
	    {
        	label: mod_strings.LBL_LIST_TYPE,
	        width: 25,
	        formatter: moduleIcon,
	        key: 'bean_module'
        },
	    {
        	label: app_strings.LBL_EMAIL_ADDRESS_BOOK_NAME,
	        width: 180,
	        sortable: true,
	        key: 'name'
	    },
	    {
	    	label: app_strings.LBL_EMAIL_ADDRESS_BOOK_EMAIL_ADDR,
	        width: 300,
	        sortable: true,
	        key: 'email'
	    }];

    var dataModel = new YAHOO.util.DataSource(urlBase + "?", {
		responseType: YAHOO.util.XHRDataSource.TYPE_JSON,
        responseSchema: {
            resultsList: 'Person',
            fields: ['name', 'email', 'bean_id', 'bean_module'],
		    metaFields: {total: 'TotalCount'}
    	},
        //enable sorting on the server accross all data
        remoteSort: true
    });
    dataModel.params = {
		to_pdf		: true,
		module		: "Emails",
		action		: "EmailUIAjax",
		emailUIAction:"getAddressSearchResults"
    }
    var rb = document.getElementById('hasRelatedBean').checked;
	if (rb) {
		var idx = SUGAR.email2.composeLayout.currentInstanceId;
		var relatedBeanId = document.getElementById('data_parent_id' + idx).value;
		var relatedBeanType = document.getElementById('data_parent_type' + idx).value;
		dataModel.params['related_bean_id'] = relatedBeanId;
		dataModel.params['related_bean_type'] = relatedBeanType;
		dataModel.params['person'] = document.getElementById('input_searchPerson').value;
	}
    SUGAR.email2.addressBook.addressBookDataModel = dataModel;

    var grid = SUGAR.email2.addressBook.grid = new YAHOO.widget.ScrollingDataTable("addrSearchGrid", colModel, dataModel, {
    	MSG_EMPTY: "&nbsp;", //SUGAR.language.get("Emails", "LBL_EMPTY_FOLDER"),
		dynamicData: true,
		paginator: new YAHOO.widget.Paginator({
			rowsPerPage: 25,
			containers : ["dt-pag-nav-addressbook"],
			template: "<div class='pagination'>{FirstPageLink} {PreviousPageLink} {PageLinks} {NextPageLink} {LastPageLink}</div>",
					firstPageLinkLabel: 	"<button class='button'><div class='paginator-start'/></button>",
					previousPageLinkLabel: 	"<button class='button'><div class='paginator-previous'/></button>",
					nextPageLinkLabel: 		"<button class='button'><div class='paginator-next'/></button>",
					lastPageLinkLabel: 		"<button class='button'><div class='paginator-end'/></button>"
		}),
		initialRequest:SUGAR.util.paramsToUrl(dataModel.params),
		width:  "560px",
		height: "250px"
    });
	//Override Paging request construction
	grid.set("generateRequest", function(oState, oSelf) {
        oState = oState || {pagination:null, sortedBy:null};
        var sort = (oState.sortedBy) ? oState.sortedBy.key : oSelf.getColumnSet().keys[0].getKey();
        var dir = (oState.sortedBy && oState.sortedBy.dir === YAHOO.widget.DataTable.CLASS_DESC) ? "desc" : "asc";
        var startIndex = (oState.pagination) ? oState.pagination.recordOffset : 0;
        var results = (oState.pagination) ? oState.pagination.rowsPerPage : null;
        // Build the request
        var ret =
            SUGAR.util.paramsToUrl(oSelf.getDataSource().params) +
            "&sort=" + sort + "&dir=" + dir + "&start=" + startIndex +
            ((results !== null) ? "&limit=" + results : "");
        return  ret;
    });

	grid.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload = oPayload || { };
		oPayload.totalRecords = oResponse.meta.total;
		return oPayload;
	}

	grid.clickToggleSelect= function(args) {
		var isIE = (args.event.target == null);
		var targetElement = isIE ? args.event.srcElement : args.event.target;
		if(targetElement.type == null || targetElement.type != 'checkbox') {
			SUGAR.email2.addressBook.grid.toggleSelect(args.target.id);
		}
	}

	grid.reSelectRowsOnRender = function (){
	    var rows = SUGAR.email2.addressBook.grid.getRecordSet().getRecords();
        for (var i = 0; i < rows.length; i++)
        {
        	var emailAddress = rows[i].getData("email");
            var alreadyAdded = SUGAR.email2.addressBook.doesEmailAdddressExistInResultTable(emailAddress);
            if(alreadyAdded)
            {
                rows[i].setData("selected",  true);
        		SUGAR.email2.addressBook.grid.selectRow(rows[i]);
            }
            else
            {
                rows[i].setData("selected",  false);
                SUGAR.email2.addressBook.grid.unselectRow(rows[i]);
            }
        }
	}
	grid.subscribe("rowMouseoverEvent", grid.onEventHighlightRow);
	grid.subscribe("rowMouseoutEvent", grid.onEventUnhighlightRow);
	grid.subscribe("rowClickEvent", grid.clickToggleSelect);
    grid.subscribe("postRenderEvent", grid.reSelectRowsOnRender);

    grid.render();
    dataModel.subscribe("requestEvent", grid.disable, grid, true);
    dataModel.subscribe("responseParseEvent", grid.undisable, grid, true);

    grid.toggleSelectCheckbox = function(id,checked){
        var row = SUGAR.email2.addressBook.grid.getRecord(id);
        row.setData("checked",checked);
    };
    grid.toggleSelect = function(id, checked) {
        var row = SUGAR.email2.addressBook.grid.getRecord(id);
    	checked = row.getData("selected");
        if (!checked)
        {
            SUGAR.email2.addressBook.grid.selectRow(row);
            SE.addressBook.insertContactRowToResultTable(id,null)
        } else
        {
            SUGAR.email2.addressBook.grid.unselectRow(row);
            SE.addressBook.removeRowFromGridResults(id,row.getData("email"));
        }
        row.setData("selected", !checked);
    };

    grid.toggleSelectAll = function(checked) {
        rows = SUGAR.email2.addressBook.grid.getRecordSet().getRecords();
        for (var i = 0; i < rows.length; i++) {
			if (typeof(rows[i]) != "undefined")
				rows[i].setData("checked",  checked);
        }
        var checkBoxes = SUGAR.email2.addressBook.grid.get("element").getElementsByTagName('input');
        for (var i = 0; i < checkBoxes.length; i++) {
            checkBoxes[i].checked = checked;
        }
    };

    //Initialize the grid result table.
    AddressSearchResultsGridInit();
}



/**
*  Initalize the results table for the address book selection.
*
*/
function AddressSearchResultsGridInit()
{

    /* Full name sort function to compare by last name if available */
    var fullNameSort = function(a, b, desc) {
        // Deal with empty values
        if(!YAHOO.lang.isValue(a))
            return (!YAHOO.lang.isValue(b)) ? 0 : 1;
        else if(!YAHOO.lang.isValue(b))
            return -1;

        var aNames = a.getData("name").split(' ');
        var bNames = b.getData("name").split(' ');

        var aSortField = (aNames.length == 2) ? aNames[1] : a.getData("name");
        var bSortField = (bNames.length == 2) ? bNames[1] : b.getData("name");

        return YAHOO.util.Sort.compare(aSortField,bSortField, desc);

    };

    var typeDdOptions = [app_strings.LBL_EMAIL_ADDRESS_BOOK_ADD_TO.replace(/:$/,'') ,
                         app_strings.LBL_EMAIL_ADDRESS_BOOK_ADD_CC.replace(/:$/,''),
                         app_strings.LBL_EMAIL_ADDRESS_BOOK_ADD_BCC.replace(/:$/,'')];

    var ColumnDefs = [{key:'type',label:app_strings.LBL_EMAIL_ADDRESS_BOOK_ADRRESS_TYPE, width: 60, sortable: true, editor: new YAHOO.widget.RadioCellEditor({radioOptions:typeDdOptions,disableBtns:true})},
                     {key:'name',label:app_strings.LBL_EMAIL_ACCOUNTS_NAME,width: 280,sortable: true, sortOptions:{sortFunction:fullNameSort}}];

     var myDataSource = new YAHOO.util.DataSource([]);
	 myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
	 myDataSource.responseSchema = {
	            fields: ["name","type","email_address","display_email_address","bean_id","idx"]
	        };

	 var gridResults = SUGAR.email2.addressBook.gridResults = new YAHOO.widget.ScrollingDataTable("addrSearchResultGrid", ColumnDefs, myDataSource, {
                        width:  "350px",height: "250px", MSG_EMPTY: "&nbsp;"});

     var highlightEditableCell = function(oArgs) {
            var elCell = oArgs.target;
            if(YAHOO.util.Dom.hasClass(elCell, "yui-dt-editable")) {
                this.highlightCell(elCell);
            }
        };

     gridResults.subscribe("cellMouseoverEvent", highlightEditableCell);
     gridResults.subscribe("cellMouseoutEvent", gridResults.onEventUnhighlightCell);
     gridResults.subscribe("cellClickEvent", gridResults.onEventShowCellEditor);
     gridResults.subscribe("rowMouseoverEvent", gridResults.onEventHighlightRow);
	 gridResults.subscribe("rowMouseoutEvent", gridResults.onEventUnhighlightRow);

     //Setup the context menus
     var onContextMenuClick = function(p_sType, p_aArgs, p_myDataTable) {
	     var task = p_aArgs[1];
	     if(task)
	     {
	         var elRow = this.contextEventTarget;
	         elRow = p_myDataTable.getTrEl(elRow);

	         if(elRow)
	         {
	             switch(task.index)
	             {
	                 case 0:
	                     var oRecord = p_myDataTable.getRecord(elRow);
	                     p_myDataTable.deleteRow(elRow);
	                     SUGAR.email2.addressBook.grid.reSelectRowsOnRender();
	             }
	         }
	     }
	 };
     var contextMenu = new YAHOO.widget.ContextMenu("contextmenu",
	                {trigger:gridResults.getTbodyEl()});
	 contextMenu.addItem(app_strings.LBL_EMAIL_DELETE);
	 contextMenu.render("addrSearchResultGrid");
	 contextMenu.clickEvent.subscribe(onContextMenuClick, gridResults);
}
