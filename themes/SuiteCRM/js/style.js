/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Master Subscription
 * Agreement ("License") which can be viewed at
 * http://www.sugarcrm.com/crm/en/msa/master_subscription_agreement_11_April_2011.pdf
 * By installing or using this file, You have unconditionally agreed to the
 * terms and conditions of the License, and You may not use this file except in
 * compliance with the License.  Under the terms of the license, You shall not,
 * among other things: 1) sublicense, resell, rent, lease, redistribute, assign
 * or otherwise transfer Your rights to the Software, and 2) use the Software
 * for timesharing or service bureau purposes such as hosting the Software for
 * commercial gain and/or for the benefit of a third party.  Use of the Software
 * may be subject to applicable fees and any use of the Software without first
 * paying applicable fees is strictly prohibited.  You do not have the right to
 * remove SugarCRM copyrights from the source code or user interface.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *  (i) the "Powered by SugarCRM" logo and
 *  (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * Your Warranty, Limitations of liability and Indemnity are expressly stated
 * in the License.  Please refer to the License for the specific language
 * governing these rights and limitations under the License.  Portions created
 * by SugarCRM are Copyright (C) 2004-2011 SugarCRM, Inc.; All Rights Reserved.
 ********************************************************************************/


/**
 * Handles the global links slide
 */
YAHOO.util.Event.onContentReady("globalLinksModule", function()
{
    if ( !Get_Cookie('globalLinksOpen') ) {
        Set_Cookie('globalLinksOpen','true',30,'/','','');
    }
    if ( Get_Cookie('globalLinksOpen') && Get_Cookie('globalLinksOpen') == 'true' ) {
        document.getElementById('globalLinks').style.width = "auto";
    }
    YUI({combine: true, timeout: 10000, base:"include/javascript/yui3/build/", comboBase:"index.php?entryPoint=getYUIComboFile&"}).use("node", "anim", function(Y) {
        var module = Y.one('#globalLinksModule');

        if ( Get_Cookie('globalLinksOpen') && Get_Cookie('globalLinksOpen') == 'true' ) {
            var content = module.one('#globalLinks').plug(Y.Plugin.NodeFX, {
            from: { width: 0

            },
            to: {
                width:
                function(node) { // dynamic in case of change
                        return node.get('scrollWidth');
                    }
            },
            easing: Y.Easing.easeOut,
            duration: 0.5
        });
            module.toggleClass('yui-closed');

        } else {
        var content = module.one('#globalLinks').plug(Y.Plugin.NodeFX, {
            from: { width:
                    function(node) { // dynamic in case of change
                        return node.get('scrollWidth');
                    }
            },
            to: {
                width: 0
            },
            easing: Y.Easing.backIn,
            duration: 0.5
        });
        }

        var onClick = function(e) {
            module.toggleClass('yui-closed');
            content.fx.set('reverse', !content.fx.get('reverse')); // toggle reverse
            content.fx.run();
            if ( document.getElementById('globalLinksModule').className == 'yui-closed' )
                Set_Cookie('globalLinksOpen','true',30,'/','','');
            else
                Set_Cookie('globalLinksOpen','false',30,'/','','');
        };

        // use dynamic control for dynamic behavior
        var control = Y.Node.create(
        '<a title="show/hide content" class="yui-toggle"><em>toggle</em></a>'
        );

        module.one('#globalLinksCtrl').appendChild(control);
        control.on('click', onClick);
    });
});

SUGAR.themes = SUGAR.namespace("themes");

SUGAR.append(SUGAR.themes, {
    setRightMenuTab: function(el, params) {
        var Dom = YAHOO.util.Dom, Sel = YAHOO.util.Selector;
        var extraMenu = Dom.get("moduleTabExtraMenuAll");
        //Check if the menu we want to show is in the more menu
        if (Dom.isAncestor("MoreAll", el)) {
            var currRight = Dom.getPreviousSibling(extraMenu);
            if (currRight.id == "moduleTab_")
                currRight = Dom.getPreviousSibling(extraMenu);
            //Insert the el to the menu
            Dom.insertAfter(el, currRight);
            //Move the curr right back into the more menu
            Dom.insertBefore(currRight, Sel.query("ul>li", "MoreAll", true));
            Dom.removeClass(currRight, "yuimenubaritem");
            Dom.removeClass(currRight, "yuimenubaritem-hassubmenu");
            Dom.removeClass(currRight, "current");
        }
    },
    setCurrentTab: function(params) {
        var Dom = YAHOO.util.Dom, Sel = YAHOO.util.Selector;
        var el = document.getElementById('moduleTab_' + params.module);
        if (el && el.parentNode) {
            el = el.parentNode;
            SUGAR.themes.setRightMenuTab(el, params);
            var currActiveTab = Sel.query("li.yuimenubaritem.current", "themeTabGroupMenu_All", true);
            if (currActiveTab) {
                if (currActiveTab == el) return;
                Dom.removeClass(currActiveTab, "current");
            }
            Dom.addClass(el, "yuimenubaritem  yuimenubaritem-hassubmenu current");
            var right = Sel.query("li.yuimenubaritem.currentTabRight", "themeTabGroupMenu_All", true);
            Dom.insertAfter(right, el);
        }
    },
    setModuleTabs: function(html) {
        var Dom = YAHOO.util.Dom, Sel = YAHOO.util.Selector;
        var el = document.getElementById('moduleList');
        if (el && el.parentNode) {
            var parent = el.parentNode;

            try {
                //This can fail hard if multiple events fired at the same time
                YAHOO.util.Event.purgeElement(el, true);
                for (var i in allMenuBars) {
                    if (allMenuBars[i].destroy)
                        allMenuBars[i].destroy();
                }
            } catch (e) {
                //If the menu fails to load, we can get leave the user stranded, reload the page instead.
                window.location.reload();
            }
            parent.removeChild(el);
            parent.innerHTML += html;
            el = document.getElementById('moduleList');
            this.loadModuleList();
        }
    },

    loadModuleList: function() {

    // Indentation not changed to preserve history.
    function onSubmenuBeforeShow(p_sType, p_sArgs)
    {
		var oElement,
			oBd,
			oShadow,
			oShadowBody,
			oShadowBodyCenter,
			oVR,
		    oLastViewContainer,
			parentIndex,
			oItem,
			oSubmenu,
			data,
			aItems;


			parentIndex = this.parent.index;


		if (this.parent) {

			oElement = this.element;
			oBd = oElement.firstChild;
			oShadow = oElement.lastChild;
			oLastViewContainer = document.getElementById("lastViewedContainer"+oElement.id);

            // We need to figure out the module name from the ID. Sometimes it will have the group name in it
            // But sometimes it will just use the module name (in the case of the All group which don't have the
            // group prefixes due to the automated testing suite.
            var moduleName = oElement.id;
            var groupName = oElement.parentNode.parentNode.parentNode.id.replace('themeTabGroup_','');
            moduleName = moduleName.replace(groupName+'_','');

			var handleSuccess = function(o){
				if(o.responseText !== undefined){
				data = YAHOO.lang.JSON.parse(o.responseText);
				aItems = oMenuBar.getItems();
				oItem = aItems[parentIndex];
				if(!oItem) return;

                oSubmenu = oItem.cfg.getProperty("submenu");
				if (!oSubmenu) return;
                oSubmenu.removeItem(1,1);
				oSubmenu.addItems(data,1);

				//update shadow height to accomodate new items

				oVR = oShadow.previousSibling;
				oVR.style.height = (oShadow.offsetHeight - 15)+"px";



				}
			}

			var handleFailure = function(o){
				if(o.responseText !== undefined){
					oLastViewContainer.innerHTML = "Failed to load menu";
				}
			}

			var callback =
			{
			  success:handleSuccess,
			  failure:handleFailure
			};

			var sUrl = "index.php?module="+moduleName+"&action=modulelistmenu";

			if(oLastViewContainer && oLastViewContainer.lastChild.firstChild.innerHTML == "&nbsp;") {
				var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, callback);
			}


		}

	}


	function onSubmenuShow(p_sType, p_sArgs) {

	var oElement,
		oShadow,
		oShadowBody,
		oShadowBodyCenter,
		oBd,
		oVR;

	if (this.parent) {

		oElement = this.element;
		var newLeft = oElement.offsetLeft + offsetPadding;
		oElement.style.left = newLeft + "px";
		oBd = oElement.firstChild;
		oShadow = oElement.lastChild;
		oElement.style.top = oElement.offsetTop + "px";
		if(oElement.id.substr(0,4) != "More" && oElement.id.substring(0,8) != "TabGroup") {
			if(oShadow.previousSibling.className != "vr") {

			oVR = document.createElement("div");
			oVR.setAttribute("class", "vr");
			oVR.setAttribute("className", "vr");
			oElement.insertBefore(oVR,oShadow);
			oVR.style.height = (oBd.offsetHeight - 15)+"px";
			oVR.style.top = (oBd.offsetTop+8) +"px";
			oVR.style.left = ((oBd.offsetWidth/2)-10) +"px";

			}
		}

		}

	}

    var nodes = YAHOO.util.Selector.query('#moduleList>div');
    allMenuBars = {};

    for ( var i = 0 ; i < nodes.length ; i++ ) {
	    var currMenuBar = SUGAR.themes.currMenuBar = new YAHOO.widget.MenuBar(nodes[i].id, {
		    autosubmenudisplay: true,
            visible: false,
		    hidedelay: 750,
		    lazyload: true });
	    /*
	      Subscribe to the "beforeShow" and "show" events for
	      each submenu of the MenuBar instance.
	    */

	    currMenuBar.subscribe("beforeShow", onSubmenuBeforeShow);
	    currMenuBar.subscribe("show", onSubmenuShow);

	    /*
	      Call the "render" method with no arguments since the
	      markup for this MenuBar already exists in the page.
	    */

	    currMenuBar.render();
        allMenuBars[nodes[i].id.substr(nodes[i].id.indexOf('_')+1)] = currMenuBar;



        if (typeof YAHOO.util.Dom.getChildren(nodes[i]) == 'object' && YAHOO.util.Dom.getChildren(nodes[i]).shift().style.display != 'none')
        {
            // This is the currently displayed menu bar
            oMenuBar = currMenuBar;
        }
    }


	// Remove the href attribute if we are on an touch device ( like an iPad )
	if ( SUGAR.util.isTouchScreen() ) {
	    var nodes = YAHOO.util.Selector.query('#moduleList a.yuimenubaritemlabel-hassubmenu');
	    YAHOO.util.Dom.batch(nodes, function(el,o) {
	        el.href = '#';
	    });
	}

    } // loadModuleList()
});

/**
 * For the module list menu
 */
YAHOO.util.Event.onContentReady("moduleList", SUGAR.themes.loadModuleList);

/**
 * For the module list menu scrolling functionality
 */
YAHOO.util.Event.onContentReady("tabListContainer", function()
{
    YUI({combine: true, timeout: 10000, base:"include/javascript/yui3/build/", comboBase:"index.php?entryPoint=getYUIComboFile&"}).use("anim", function(Y)
    {
        var content = Y.one('#content');
        var addPage = Y.one('#add_page');
        var tabListContainer = Y.one('#tabListContainer');
        var tabList = Y.one('#tabList');
        var dashletCtrlsElem = Y.one('#dashletCtrls');
        var contentWidth = content.get('offsetWidth');
        var dashletCtrlsWidth = dashletCtrlsElem.get('offsetWidth')+10;
        var addPageWidth = addPage.get('offsetWidth')+2;
        var tabListContainerWidth = tabListContainer.get('offsetWidth');
        var tabListWidthElem = tabList.get('offsetWidth');
        var maxWidth = (contentWidth-3)-(dashletCtrlsWidth+addPageWidth+2);

        var tabListChildren = tabList.get('children');

        var tabListWidth = 0;
        for(i=0;i<tabListChildren.size();i++) {
            if(Y.UA.ie == 7) {
				tabListWidth += tabListChildren.item(i).get('offsetWidth')+2;
			} else {
				tabListWidth += tabListChildren.item(i).get('offsetWidth');
			}
        }

        if(tabListWidth > maxWidth) {
            tabListContainer.setStyle('width',maxWidth+"px");
            tabList.setStyle('width',tabListWidth+"px");
            tabListContainer.addClass('active');
        }


        var node = Y.one('#tabListContainer .yui-bd');
        var anim = new Y.Anim({
            node: node,
            to: {
                scroll: function(node) {
                    return [node.get('scrollLeft') + node.get('offsetWidth'),0]
                }
            },
            easing: Y.Easing.easeOut
        });

        var onClick = function(e) {

            var y = node.get('offsetWidth');
            if (e.currentTarget.hasClass('yui-scrollup')) {
                y = 0 - y;
            }

            anim.set('to', { scroll: [y + node.get('scrollLeft'),0] });
            anim.run();
        };

        Y.all('#tabListContainer .yui-hd a').on('click', onClick);
    });
});

function sugar_theme_gm_switch( groupName ) {
    document.getElementById('themeTabGroup_'+sugar_theme_gm_current).style.display='none';
    sugar_theme_gm_current = groupName;
    YAHOO.util.Connect.asyncRequest('POST','index.php?module=Users&action=ChangeGroupTab&to_pdf=true',false,'newGroup='+groupName);
    document.getElementById('themeTabGroup_'+groupName).style.display='block';

    oMenuBar = allMenuBars[groupName];
}

offsetPadding = 0;

function resizeHeader() {
	var e = document.getElementById("contentTable");
	document.getElementById("moduleList").style.width = e.offsetWidth + "px";
	document.getElementById("header").style.width = e.offsetWidth + 20 + "px";
	document.getElementById("dcmenu").style.width = e.offsetWidth + 20 + "px";

}

function show_user_options()
{
	var el_uo = document.getElementById("user_options");
	var el_ul = document.getElementById("user_link");
	var el_ex = document.getElementById("gear_link");
	var el_dd = document.getElementById("admin_options");

	if(YAHOO.util.Dom.hasClass(el_ex, 'active'))
	{
		YAHOO.util.Dom.removeClass(el_ex, 'active');
		el_dd.style.display = 'none';
	}

	if(el_uo.style.display != 'none')
	{
		el_uo.style.display = 'none';

		YAHOO.util.Dom.removeClass(el_ul, 'active');
	}
	else
	{
		el_uo.style.display = 'block';
		YAHOO.util.Dom.addClass(el_ul, 'active');
	}
}

function show_admin_options()
{
	var el_uo = document.getElementById("admin_options");
	var el_ul = document.getElementById("gear_link");
	var el_ex = document.getElementById("user_link");
	var el_dd = document.getElementById("user_options");

	if(YAHOO.util.Dom.hasClass(el_ex, 'active'))
	{
		YAHOO.util.Dom.removeClass(el_ex, 'active');
		el_dd.style.display = 'none';
	}

	if(el_uo.style.display != 'none')
	{
		el_uo.style.display = 'none';

		YAHOO.util.Dom.removeClass(el_ul, 'active');
	}
	else
	{
		el_uo.style.display = 'block';
		YAHOO.util.Dom.addClass(el_ul, 'active');
	}
}

YAHOO.util.Event.on("user_link", "click", function(e) {
	show_user_options();
});

YAHOO.util.Event.on("gear_link", "click", function(e) {
	show_admin_options();
});

$(document).ready(function(){$("ul.clickMenu").each(function(index,node){$(node).sugarActionMenu();});});YAHOO.util.Event.onAvailable('sitemapLinkSpan',function()
{document.getElementById('sitemapLinkSpan').onclick=function()
{ajaxStatus.showStatus(SUGAR.language.get('app_strings','LBL_LOADING_PAGE'));var smMarkup='';var callback={success:function(r){ajaxStatus.hideStatus();document.getElementById('sm_holder').innerHTML=r.responseText;with(document.getElementById('sitemap').style){display="block";position="absolute";right=0;top=80;}
    document.getElementById('sitemapClose').onclick=function()
    {document.getElementById('sitemap').style.display="none";}}}
    postData='module=Home&action=sitemap&GetSiteMap=now&sugar_body_only=true';YAHOO.util.Connect.asyncRequest('POST','index.php',callback,postData);}});function IKEADEBUG()
{var moduleLinks=document.getElementById('moduleList').getElementsByTagName("a");moduleLinkMouseOver=function()
{var matches=/grouptab_([0-9]+)/i.exec(this.id);var tabNum=matches[1];var moduleGroups=document.getElementById('subModuleList').getElementsByTagName("span");for(var i=0;i<moduleGroups.length;i++){if(i==tabNum){moduleGroups[i].className='selected';}
else{moduleGroups[i].className='';}}
    var groupList=document.getElementById('moduleList').getElementsByTagName("li");var currentGroupItem=tabNum;for(var i=0;i<groupList.length;i++){var aElem=groupList[i].getElementsByTagName("a")[0];if(aElem==null){continue;}
    var classStarter='notC';if(aElem.id=="grouptab_"+tabNum){classStarter='c';currentGroupItem=i;}
    var spanTags=groupList[i].getElementsByTagName("span");for(var ii=0;ii<spanTags.length;ii++){if(spanTags[ii].className==null){continue;}
        var oldClass=spanTags[ii].className.match(/urrentTab.*/);spanTags[ii].className=classStarter+oldClass;}}
    var menuHandle=moduleGroups[tabNum];var parentMenu=groupList[currentGroupItem];if(menuHandle&&parentMenu){updateSubmenuPosition(menuHandle,parentMenu);}};for(var i=0;i<moduleLinks.length;i++){moduleLinks[i].onmouseover=moduleLinkMouseOver;}};function updateSubmenuPosition(menuHandle,parentMenu){var left='';if(left==""){p=parentMenu;var left=0;while(p&&p.tagName.toUpperCase()!='BODY'){left+=p.offsetLeft;p=p.offsetParent;}}
    var bw=checkBrowserWidth();if(!parentMenu){return;}
    var groupTabLeft=left+(parentMenu.offsetWidth / 2);var subTabHalfLength=0;var children=menuHandle.getElementsByTagName('li');for(var i=0;i<children.length;i++){if(children[i].className=='subTabMore'||children[i].parentNode.className=='cssmenu'){continue;}
        subTabHalfLength+=parseInt(children[i].offsetWidth);}
    if(subTabHalfLength!=0){subTabHalfLength=subTabHalfLength / 2;}
    var totalLengthInTheory=subTabHalfLength+groupTabLeft;if(subTabHalfLength>0&&groupTabLeft>0){if(subTabHalfLength>=groupTabLeft){left=1;}else{left=groupTabLeft-subTabHalfLength;}}
    if(totalLengthInTheory>bw){var differ=totalLengthInTheory-bw;left=groupTabLeft-subTabHalfLength-differ-2;}
    if(left>=0){menuHandle.style.marginLeft=left+'px';}}
YAHOO.util.Event.onDOMReady(function()
{if(document.getElementById('subModuleList')){var parentMenu=false;var moduleListDom=document.getElementById('moduleList');if(moduleListDom!=null){var parentTabLis=moduleListDom.getElementsByTagName("li");var tabNum=0;for(var ii=0;ii<parentTabLis.length;ii++){var spans=parentTabLis[ii].getElementsByTagName("span");for(var jj=0;jj<spans.length;jj++){if(spans[jj].className.match(/currentTab.*/)){tabNum=ii;}}}
    var parentMenu=parentTabLis[tabNum];}
    var moduleGroups=document.getElementById('subModuleList').getElementsByTagName("span");for(var i=0;i<moduleGroups.length;i++){if(moduleGroups[i].className.match(/selected/)){tabNum=i;}}
    var menuHandle=moduleGroups[tabNum];if(menuHandle&&parentMenu){updateSubmenuPosition(menuHandle,parentMenu);}}});SUGAR.themes=SUGAR.namespace("themes");SUGAR.append(SUGAR.themes,{allMenuBars:{},setModuleTabs:function(html){var el=document.getElementById('ajaxHeader');if(el){try{YAHOO.util.Event.purgeElement(el,true);for(var i in this.allMenuBars){if(this.allMenuBars[i].destroy)
    this.allMenuBars[i].destroy();}}catch(e){window.location.reload();}
    if(el.hasChildNodes()){while(el.childNodes.length>=1){el.removeChild(el.firstChild);}}
    el.innerHTML+=html;this.loadModuleList();}},actionMenu:function(){$("ul.clickMenu").each(function(index,node){$(node).sugarActionMenu();});},loadModuleList:function(){var nodes=YAHOO.util.Selector.query('#moduleList>div'),currMenuBar;this.allMenuBars={};for(var i=0;i<nodes.length;i++){currMenuBar=SUGAR.themes.currMenuBar=new YAHOO.widget.MenuBar(nodes[i].id,{autosubmenudisplay:true,visible:false,hidedelay:750,lazyload:true});currMenuBar.render();this.allMenuBars[nodes[i].id.substr(nodes[i].id.indexOf('_')+1)]=currMenuBar;if(typeof YAHOO.util.Dom.getChildren(nodes[i])=='object'&&YAHOO.util.Dom.getChildren(nodes[i]).shift().style.display!='none'){oMenuBar=currMenuBar;}}
    YAHOO.util.Event.onAvailable('subModuleList',IKEADEBUG);},setCurrentTab:function(){}});YAHOO.util.Event.onDOMReady(SUGAR.themes.loadModuleList,SUGAR.themes,true);