/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.

 * SuiteCRM is an extension to SugarCRM Community Edition developed by Salesagility Ltd.
 * Copyright (C) 2011 - 2014 Salesagility Ltd.
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
 * SugarCRM" logo and "Supercharged by SuiteCRM" logo. If the display of the logos is not
 * reasonably feasible for  technical reasons, the Appropriate Legal Notices must
 * display the words  "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 ********************************************************************************/

/**
  Complex layout init
 */
function complexLayoutInit() {
	var se = SUGAR.email2;
	var Dom = YAHOO.util.Dom;
	se.e2Layout = {
    	getInnerLayout : function(rows) {
        	se.listViewLayout = new YAHOO.widget.Layout('listViewDiv', {
            	parent: se.complexLayout,  
	    		border:true,
	            hideOnLayout: true,
	            height: 400,
            units: [{
              position: "top",
              height: '64',
              scroll: false,
              split: true,
              body: "<div id='dt-pag-nav'></div> "
            }, {
              position: "center",
              scroll: false, // grid should autoScroll itself
              split: true,
              body: "<div id='emailGrid'></div>"
            }, {
					position: "bottom",
				    scroll:true,
				    collapse: false,
				    resize: true,
				    useShim:true,
				    height:'250',
				    body: "<div id='listBottom' />"
				},{
				    position: "right",
				    scroll:true,
				    collapse: false,
				    resize: true,
				    useShim:true,
				    width:'250',
				    body: "<div id='listRight' />",
				    titlebar: false //,header: "right"
				}]
            });
        	se.complexLayout.on("render", function(){
        		var height = SUGAR.email2.innerLayout.get("element").clientHeight - 30;
				SUGAR.email2.innerLayout.get("activeTab").get("contentEl").parentNode.style.height = height + "px";
				SUGAR.email2.listViewLayout.set("height", height);
				SUGAR.email2.listViewLayout.render();
        	});
            se.listViewLayout.render();
            //CSS hack for now
            se.listViewLayout.get("element").parentNode.parentNode.style.padding = "0px"
            var rp = se.listViewLayout.resizePreview = function() {
            	var pre = Dom.get("displayEmailFramePreview");
            	if (pre) {
            		var parent = Dom.getAncestorByClassName(pre, "yui-layout-bd");
            		pre.style.height = (parent.clientHeight - pre.offsetTop) + "px";
            	}
            };
            se.listViewLayout.getUnitByPosition("bottom").on("heightChange", se.autoSetLayout);
            se.listViewLayout.getUnitByPosition("right").on("endResize", se.autoSetLayout);
            se.e2Layout.setPreviewPanel(rows);
            se.previewLayout = se.listViewLayout;
            return se.listViewLayout;
        },
        
        getInnerLayout2Rows : function() {
            return this.getInnerLayout(true);
        },
        getInnerLayout2Columns : function() {
            return this.getInnerLayout(false);
        },
        
        init : function(){
            // initialize state manager, we will use cookies
        	var viewHeight = document.documentElement ? document.documentElement.clientHeight : self.innerHeight;
            var heightOffset = $('#dcmenu').length > 0 ? $('#dcmenu').height() : $('#header').height();
        	se.complexLayout = new YAHOO.widget.Layout("container", {
        		border:true,
                hideOnLayout: true,
                height: Dom.getViewportHeight() - heightOffset - 65,
                width: Dom.getViewportWidth() - 40,
                units: [{
                	position: "center",
                    scroll:false,
                    body: "<div id='emailtabs'></div>"
                },
                {
                	position: "left",
                	scroll: true,
                	body: "<div id='lefttabs'></div>",
                    collapse: true,
                    width: 210,
                    minWidth: 100,
                    resize:true,
                    useShim:true,
                    titlebar: true,
                    header: "&nbsp;"
                },
                {
                    header: Dom.get('footerLinks').innerHTML,
					position: 'bottom',
					id: 'mbfooter',
					height: 22,
					border: false
                }]
            });
        	se.complexLayout.render();
        	var tp = se.innerLayout = new YAHOO.widget.TabView("emailtabs");
			tp.addTab(new YAHOO.widget.Tab({ 
				label: "Inbox",
				scroll : true,
				content : "<div id='listViewDiv'/>",
				id : "center",
				active : true
			}));
        	var centerEl = se.complexLayout.getUnitByPosition('center').get('wrap');
			tp.appendTo(centerEl);
			//CSS hack for now
			tp.get("element").style.borderRight = "1px solid #666"
			
			var listV =  this.getInnerLayout2Rows();
			listV.set("height", tp.get("element").clientHeight - 25);
			listV.render();
            tp.on("activeTabChange", function ()
            {
             	se.complexLayout.resize();
            });

            se.leftTabs = new YAHOO.widget.TabView("lefttabs");
            var folderTab = new YAHOO.widget.Tab({ 
				label: app_strings.LBL_EMAIL_FOLDERS_SHORT,
				scroll : true,
				content : "<div id='emailtree'/>",
				id : "tree",
				active : true
			});
            folderTab.on("activeChange", function(o){ 
            	if (o.newValue) {
            		se.complexLayout.getUnitByPosition("left").set("header", app_strings.LBL_EMAIL_FOLDERS);
            	}
            });
            se.leftTabs.addTab(folderTab);
            
            var tabContent = SUGAR.util.getAndRemove("searchTab");
            var searchTab = new YAHOO.widget.Tab({ 
				label: app_strings.LBL_EMAIL_SEARCH_SHORT,
				scroll : true,
				content : tabContent.innerHTML,
				id : tabContent.id
			});
            searchTab.on("activeChange", function(o){ 
            	if (o.newValue) 
            	{
            		se.complexLayout.getUnitByPosition("left").set("header", app_strings.LBL_EMAIL_SEARCH);
            	   //Setup the calendars if needed
	               Calendar.setup ({inputField : "searchDateFrom", ifFormat : calFormat, showsTime : false, button : "searchDateFrom_trigger", singleClick : true, step : 1, weekNumbers:false});
	               Calendar.setup ({inputField : "searchDateTo", ifFormat : calFormat, showsTime : false, button : "searchDateTo_trigger", singleClick : true, step : 1, weekNumbers:false});
                   
	               //Initalize sqs object for assigned user name 
	               se.e2Layout.initSQSObject('advancedSearchForm','assigned_user_name');  
	               
	               //Attach event handler for when the relate module option is selected for the correct sqs object
	               var parentSearchArgs = {'formName':'advancedSearchForm','fieldName':'data_parent_name_search',
	                                        'moduleSelectField':'data_parent_type_search','fieldId':'data_parent_id_search'};
	               YAHOO.util.Event.addListener('data_parent_type_search', 'change',function(){ 
	                   SUGAR.email2.composeLayout.enableQuickSearchRelate(null,parentSearchArgs) });
	               
	               //If enter key is pressed, perform search
	               var  addKeyPressFields = ['searchSubject','searchFrom','searchTo','data_parent_name_search','searchDateTo','searchDateFrom','attachmentsSearch','assigned_user_name'];
	               for(var i=0; i < addKeyPressFields.length;i++)
	               {
    	               YAHOO.util.Event.addListener(window.document.forms['advancedSearchForm'].elements[addKeyPressFields[i]],"keydown", function(e){
                    		if (e.keyCode == 13) {
                    			YAHOO.util.Event.stopEvent(e);
                    			SUGAR.email2.search.searchAdvanced();
                    		}
            	       });
	               }
				   //Initiate quick search for the search tab.  Do this only when the tab is selected rather than onDomLoad for perf. gains.
	               enableQS(true);
	               //Clear parent values if selecting another parent type.
	               YAHOO.util.Event.addListener('data_parent_type_search','change', 
	                   function(){ 
	                       document.getElementById('data_parent_id_search').value =''; 
	                       document.getElementById('data_parent_name_search').value =''; 
	                   });
            	
            	}
            });
            se.leftTabs.addTab(searchTab);
            
            var resizeTabBody = function() {
            	var height = SUGAR.email2.leftTabs.get("element").clientHeight - 30;
				SUGAR.email2.leftTabs.get("activeTab").get("contentEl").parentNode.style.height = height + "px";
            }
            resizeTabBody();
            se.complexLayout.on("render", resizeTabBody);
            se.leftTabs.on("activeTabChange", resizeTabBody);
			//hack to allow left pane scroll bar to fully show
          	var lefttabsDiv = document.getElementById('lefttabs');
			var lefttabsDivParent = Dom.getAncestorBy(lefttabsDiv);
			var lefttabsDivGParent = Dom.getAncestorBy(lefttabsDivParent);
			lefttabsDivParent.style.width = lefttabsDivGParent.offsetWidth - 10 + "px";
          
        },
        initSQSObject: function(formName,fieldName)
        {
            var fullFieldName = formName + '_' + fieldName; //SQS Convention
            var resultName = fullFieldName + '_' + 'results';
            
            if (QSFieldsArray[fullFieldName] != null) 
            {
                QSFieldsArray[fullFieldName].destroy();
                delete QSFieldsArray[fullFieldName];
            }
            if (QSProcessedFieldsArray[fullFieldName])
            QSProcessedFieldsArray[fullFieldName] = false;

            if( Dom.get(resultName) )
            {
                var obj = document.getElementById(resultName);
                obj.parentNode.removeChild(obj);
            }
        },
        setPreviewPanel: function(rows) {
        	if (rows) {
            	SUGAR.email2.listViewLayout.getUnitByPosition("right").set("width", 0);
            	SUGAR.email2.listViewLayout.getUnitByPosition("bottom").set("height", 250);
            	Dom.get("listRight").innerHTML = "";
            	Dom.get("listBottom").innerHTML = "<div id='_blank' />";
            } else {
            	SUGAR.email2.listViewLayout.getUnitByPosition("bottom").set("height", 0);
            	SUGAR.email2.listViewLayout.getUnitByPosition("right").set("width", 250);
            	Dom.get("listBottom").innerHTML = "";
            	Dom.get("listRight").innerHTML = "<div id='_blank' />";
            }
        }
    };
	se.e2Layout.init();
}

var myBufferedListenerObject = new Object();
myBufferedListenerObject.refit = function() {
    if(SUGAR.email2.grid) {
        SUGAR.email2.grid.autoSize();
    }
}
