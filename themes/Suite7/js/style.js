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