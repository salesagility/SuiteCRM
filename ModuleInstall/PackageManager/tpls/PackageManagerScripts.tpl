{*
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

*}
{sugar_getscript file="cache/include/javascript/sugar_grp_yui_widgets.js"}
{literal}
<script>
 /*
        *  a reference to an instance of PackageManagerGrid
        */
        var _pmg;

if(typeof PackageManager == 'undefined') {
	PackageManager = function() {
		var MAX_HEIGHT = 300;
        var MIN_HEIGHT = 0;
        var _treeHeight;
        var _listHeight;
        var _attributes = {
        		height: { to: MAX_HEIGHT }
            };
        var _anim;
        var keys = [ "local_upload","server_upload"];
        var tabPreviousKey = '';
        /*
        *  Maintain an array to hold which packages we would like to download
        */
        var _packages;
        /*
        *	Keep track of the current number of packages that have successfully
        *	downloaded
        */
		var _numDownloadsComplete = 0;
		/*
		*	The number of downloads we have to retrieve
		*/
		var _numPackagesToDownload = 0;
        var _loginPanel;
        var _tabs;
        var _loadingBar;

	    return {
	        search: function() {
	        	PackageManager.showWaiting();
	        	var searchTerm = document.getElementById('search_term').value;
	        	postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=performBasicSearch&search_term=' + searchTerm;
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  {success: PackageManager.completeSearch, failure: PackageManager.completeSearch}, postData);
	        },
	        initWorkingDiv : function(){
	        	statusDiv = document.getElementById('workingStatusDiv');
				statusDiv.className = 'dataLabel';
				statusDiv.style.position = 'absolute';
				var fileview = document.getElementById('treeview');
				var top = fileview.offsetTop;
				var height = fileview.offsetHeight;
				var left = fileview.offsetLeft;
				var width = fileview.offsetWidth;
				statusDiv.style.top = (top+(height/2));
				statusDiv.style.left = (left+(width/2));
	        },
	        initDocumentationDiv : function(){
	        	documentationDiv = document.createElement('div');
				//documentationDiv.className = 'dataLabel';
				//documentationDiv.style.background = '#ffffff';
				documentationDiv.style.position = 'absolute';
				var fileview = document.getElementById('catview');
				var top = fileview.offsetTop;
				var height = fileview.offsetHeight;
				var left = fileview.offsetLeft;
				var width = fileview.offsetWidth;
				documentationDiv.style.top = (top+(height/2));
				documentationDiv.style.left = (left+(width/2));
				documentationDiv.id = 'documentation-div';
				documentationDiv.style.display = 'block';
				formDiv = document.createElement('form');
				documentationDiv.appendChild(formDiv);
				document.body.appendChild(documentationDiv);
	        },
	        initPMG: function(){



	        	//PackageManager.showLoginDialog();
	        	 {/literal}{if $module_load == 'true'}{literal}
	        	 PackageManager.initTabs();
	        	 _pmg = new PackageManagerGrid();
	        	 _pmg.renderAll();
	        	//PackageManager.initWorkingDiv();
	        	//PackageManager.initDocumentationDiv();
	        	{/literal}{elseif $IS_ALIVE == 'true'}{literal}
	        									_loadingBar =
							new YAHOO.widget.Panel("wait",
															{ width:"240px",
															  fixedcenter:true,
															  close:false,
															  draggable:false,
															  modal:true,
															  visible:false,
															  effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}
															}
														);

					_loadingBar.setHeader("{/literal}{$MOD.SEARCHING_UPDATES}{literal}");
					_loadingBar.setBody("<img src=\"include/javascript/yui/assets/rel_interstitial_loading.gif\"/>");
					_loadingBar.render(document.body);
					_loadingBar.show();
	        		_pmg = new PackageManagerGrid();
	        		//PackageManager.refreshGrid();
	        	 	_pmg.renderAll();
	        	 {/literal}{/if}{literal}
	        	//PackageManager.initLicenseDiv();
	        	//PackageManager.initModuleStaging();

    			var tabView = new YAHOO.widget.TabView('demo');
				//PackageManager.checkForUpdates();
	        },
	        download : function(){
	        	if(confirm('{/literal}{$MOD.DOWNLOAD_QUESTION}{literal}')){

	        		_numDownloadsComplete = 0;
	        		_numPackagesToDownload = 0;
	        		var tree = YAHOO.widget.TreeView.getTree('treeview');
	        		var nodes = tree.getNodesByProperty('isSelected', true);

	        		//var nodes = YAHOO.widget.TreeView.getNode(treeid, index);
	        		if(nodes){
	        			PackageManager.showWaiting();
	        										_loadingBar =
							new YAHOO.widget.Panel("wait",
															{ width:"240px",
															  fixedcenter:true,
															  close:false,
															  draggable:false,
															  modal:true,
															  visible:false,
															  effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}
															}
														);

					_loadingBar.setHeader("{/literal}{$MOD.DOWNLOADING}{literal}");
					_loadingBar.setBody("<img src=\"include/javascript/yui/assets/rel_interstitial_loading.gif\"/>");
					_loadingBar.render(document.body);
					_loadingBar.show();
	        			//_numPackagesToDownload = nodes.length;
	        			var count = nodes.length;
	        			for(j = 0; j < count; j++){
	   						if(nodes[j].type == 'release'){
	   							_numPackagesToDownload++;
	   						}
	   					}
	        			_loadingBar.setHeader("{/literal}{$MOD.DL_PACKAGES_DOWNLOADING}{literal} "+_numPackagesToDownload+" {/literal}{$MOD.DL_PACKAGES_PACKAGES}{literal}");


	        			for (i = 0; i < count; i++){
							var release_id = -1;
	        				var package_id = -1;
							var category_id = -1;

							if(nodes[i].type == 'package'){
								var package_id = nodes[i].data.id;
								var category_id = nodes[i].category_id;
							}else if(nodes[i].type == 'release'){
								var release_id = nodes[i].data.id;
								var package_id = nodes[i].package_id;
								var category_id = nodes[i].category_id;
								postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=download&release_id=' + release_id + '&package_id=' + package_id + '&category_id=' + category_id;
								var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								 	{success: PackageManager.downloadComplete, failure: PackageManager.downloadComplete}, postData);
							}
						}
					}//fi
	        	}
	        },
	        downloadComplete : function(data){

	        PackageManager.hideWaiting();
	        	eval(data.responseText);
	        	if(typeof result != 'undefined') {
	        		_numDownloadsComplete++;
					_loadingBar.setHeader("{/literal}{$MOD.DL_PACKAGES_DOWNLOADING}{literal} "+_numDownloadsComplete+" {/literal}{$MOD.DL_PACKAGES_OF}{literal} "+_numPackagesToDownload+ " {/literal}{$MOD.DL_PACKAGES_PACKAGES}{literal}");
	        		if(_numPackagesToDownload == _numDownloadsComplete){
						_loadingBar.hide();
	        			if(!{/literal}{$INSTALLATION}{literal}){
	        				PackageManager.getPackagesInStaging();
	        			}else{
	        				document.installForm.run.value = '';
	        				document.installForm.mode.value = 'noop';
	        				document.installForm.submit();
	        			}
	        		}
				}

	        },
	        getPackagesInStaging : function(){
	        	postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=getPackagesInStaging';
							var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
							{success: PackageManager.populateGrid, failure: PackageManager.populateGrid}, postData);
	        },
	        buildListView : function(result, showDownloadButton){
	        	var result_div = document.getElementById('search_results_div');
				display = "<table class='list view' width='100%'  cellpadding='0' cellspacing='0' width='100%' border='0'>";
		        display += "<tr><th align=left class='listViewThLinkS1'>{/literal}{$MOD.LBL_ML_NAME}{literal}</th><th align=left class='listViewThLinkS1'>{/literal}{$MOD.LBL_ML_TYPE}{literal}</th><th align=left class='listViewThLinkS1'>{/literal}{$MOD.LBL_ML_VERSION}{literal}</th><th align=left class='listViewThLinkS1'>{/literal}{$MOD.LBL_ML_PUBLISHED}{literal}</th><th class='listViewThLinkS1'>{/literal}{$MOD.LBL_ML_DESCRIPTION}{literal}</th><th class='listViewThLinkS1'>{/literal}{$MOD.LBL_ML_ACTION}{literal}</th></tr>";
		        for (var x = 0; x < result['packages'].length; x++)
	   			{
	   				var class_css = "oddListRowS1";
                	if((x % 2) == 0){
                    	class_css = "evenListRowS1";
                	}
	   				install_link = '';
	   				if(showDownloadButton){
                		install_link += "<input type=submit class='button' name=\"btn_mode\" onclick=\"this.form.mode.value='Install';this.form.package_id.value="+result['packages'][x]['id']+";this.form.submit();\" value=\"{/literal}{$MOD.LBL_UW_BTN_DOWNLOAD}{literal}\" />";
                	}
                	display += "<tr class=\""+class_css+"\"><td nowrap=\"nowrap\">"+result['packages'][x]['name']+"</td><td nowrap=\"nowrap\">"+result['packages'][x]['type']+"</td><td nowrap=\"nowrap\">"+result['packages'][x]['version']+"</td><td nowrap=\"nowrap\">"+result['packages'][x]['date_published']+"</td><td nowrap=\"nowrap\">"+result['packages'][x]['description']+"</td><td nowrap=\"nowrap\">"+install_link+"</td></tr>";
	   			}//rof
	   			display += "</table>";
	   			return display;
	        },
	        showStatusMessages: function(message){
	        	if(message != '')
	        		ajaxStatus.flashStatus(message, 5000);
	        },
	        populateGrid : function(data){
	            eval(data.responseText);
	            if(typeof result != 'undefined') {
	        		//uncheck all treenodes
	        		var tree = YAHOO.widget.TreeView.getTree('treeview');
	        		var root = tree.getRoot();

	        		PackageManager.uncheckAll(root);
		        	_pmg.clearGrid();
		   			for (var x = 0; x < result['packages'].length; x++){
						_pmg.addData(result['packages'][x]);
					}
		   		}
	        },
	        uncheckAll : function(node){
	        	var topNodes = node.children;
       		 	for(var i=0; i< topNodes.length; ++i) {
       		 		if(topNodes[i].checked){
            			topNodes[i].uncheck();
            		}
            		PackageManager.uncheckAll(topNodes[i]);
        		}
	        },
	        completeSearch: function(data){

	        	eval(data.responseText);

	        	if(typeof result != 'undefined') {
	        		PackageManager.populateGrid(result);
				}
				PackageManager.hideWaiting();
	        },
	        toggleLowerDiv: function(outer_div, animate_div){
	        {/literal}
                var show_img = '{$SHOW_IMG}';
                var hide_img = '{$HIDE_IMG}';
            {literal}
                var spn = document.getElementById(outer_div);
                var anim_div = document.getElementById(animate_div);

                if(anim_div.style.display == 'block'){
                	anim_div.style.display = 'none';
                }else{
                	anim_div.style.display = 'block';
                }
                spn.innerHTML =(anim_div.style.display == 'none') ? show_img+"&nbsp;Expand" : hide_img+"&nbsp;Collapse";
            },
            toggleDiv: function(outer_div, animate_div){
            {/literal}
                var show_img = '{$SHOW_IMG}';
                var hide_img = '{$HIDE_IMG}';
            {literal}
                var spn = document.getElementById(outer_div);
                var anim_div = document.getElementById(animate_div);
                _attributes.height.to = (_attributes.height.to == MAX_HEIGHT) ? MIN_HEIGHT : MAX_HEIGHT;
                if(!_anim){
                	MAX_HEIGHT = anim_div.offsetHeight;
                    _attributes.height.to = MIN_HEIGHT;
                }
                _anim = new YAHOO.util.Anim(animate_div, _attributes, 0.5, YAHOO.util.Easing.bounceOut);
                if(_attributes.height.to == MIN_HEIGHT){
                	anim_div.style.display = 'none';
                }else{
                	anim_div.style.display = 'block';
                }
                  spn.innerHTML =(_attributes.height.to == MIN_HEIGHT) ? show_img+"&nbsp;Expand" : hide_img+"&nbsp;Collapse";
                _anim.attributes = _attributes;

                 _anim.animate();

            },
            toggleView: function(type){
            	var treeview = document.getElementById('treeview');
            	var searchview = document.getElementById('searchview');
               if(type == 'browse'){
               	treeview.style.display = 'block';
               	searchview.style.display = 'none';
               }else{
               	treeview.style.display = 'none';
               	searchview.style.display = 'block';
               }
            },
            selectTabCSS: function(key){
            	for( var i=0; i<keys.length;i++)
              	{
                	var liclass = '';
                	var linkclass = '';

                	if ( key == keys[i])
                	{
                    	var liclass = 'active';
                    	var linkclass = 'current';
                    	document.getElementById(keys[i]+'_div').style.display = 'block';
                	}else{
                    	document.getElementById(keys[i]+'_div').style.display = 'none';
                	}
                	document.getElementById(keys[i]+'_li').className = liclass;
                	document.getElementById(keys[i]+'_link').className = linkclass;
            	}
                tabPreviousKey = key;
            },
            loadDataForNodeForPackage : function(node, onCompleteCallback){
				PackageManager.showWaiting();
            	var id= node.data.id;
 				var callback =	{
		  			success: function(data) {
			    		eval(data.responseText);
			    		if(typeof result != 'undefined') {
							var tmpNode = node;
							for ( key in result['nodes'] ) {
								if(result['nodes'][key]['type']){

									var myobj = { label: result['nodes'][key]['label'], id:result['nodes'][key]['id']};
		   							tmpNode= new YAHOO.widget.TextNode(myobj, node, false);
									tmpNode.href = "javascript:PackageManager.catClick('treeview',"+tmpNode.index+");";
		   							tmpNode.setDynamicLoad(PackageManager.loadDataForNodeForPackage);
									tmpNode.data['description'] = result['nodes'][key]['description'];
								}else{
									tmpNode = node;
								}
								if(result['nodes'][key]['packages']){
									for(pKey in result['nodes'][key]['packages']){

										if(result['nodes'][key]['packages'][pKey]['releases'] && !result['nodes'][key]['packages'][pKey]['releases'].length && result['nodes'][key]['packages'][pKey]['releases'].length != 0){
											var myobj = { label: result['nodes'][key]['packages'][pKey]['label'], id:result['nodes'][key]['packages'][pKey]['id']};
			   								var tmpNodePackage = new YAHOO.widget.TaskNode(myobj, tmpNode, true);
			   								tmpNodePackage.href = "javascript:PackageManager.packageClick('treeview',"+tmpNodePackage.index+");"
											tmpNodePackage.description = result['nodes'][key]['packages'][pKey]['description']
											tmpNodePackage.type = 'package';
											tmpNodePackage.category_id = result['nodes'][key]['id'];
											tmpNodePackage.onCheckClick = function(){
																			this.data['isSelected'] = this.checked;
																			for (var i=0; i<this.children.length; ++i) {
	            																this.children[i].data['isSelected'] = this.checked;
	        																}
																		  };
											if(result['nodes'][key]['packages'][pKey]['releases']){
												for(releaseKey in result['nodes'][key]['packages'][pKey]['releases']){
													var myobj = { label: result['nodes'][key]['packages'][pKey]['releases'][releaseKey]['label'], id:result['nodes'][key]['packages'][pKey]['releases'][releaseKey]['id']};

			   										if(result['nodes'][key]['packages'][pKey]['releases'][releaseKey]['enable'] == true){
			   											var tmpNodeRelease = new YAHOO.widget.TaskNode(myobj, tmpNodePackage, false);
														tmpNodeRelease.setDynamicLoad(PackageManager.loadDataForNodeForRelease);
														tmpNodeRelease.onCheckClick = function(){this.data['isSelected'] = this.checked;};
													}else{
														var tmpNodeRelease = new YAHOO.widget.TextNode(myobj, tmpNodePackage, true);
													}
													tmpNodeRelease.version = result['nodes'][key]['packages'][pKey]['releases'][releaseKey]['version']
			   										tmpNodeRelease.href = "javascript:PackageManager.releaseClick('treeview',"+tmpNodeRelease.index+");"
													tmpNodeRelease.type = 'release';
													tmpNodeRelease.category_id = tmpNode.data.id;
													tmpNodeRelease.package_id = result['nodes'][key]['packages'][pKey]['id'];
												}//rof
											}//fi
											//tmpNodePackage.setDynamicLoad(PackageManager.loadDataForNodeForPackage);
										}//fi
									}//rof
								}//fi
							}//rof
	   					}//fi
	   				PackageManager.hideWaiting();
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) {if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=getNodes&category_id=' + id;
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);

            },
            showWaiting : function(text){
				ajaxStatus.showStatus(text);
            },
            hideWaiting : function(text){
				ajaxStatus.hideStatus();
            },
            node_click : function(treeid){
				node=YAHOO.namespace(treeid).selectednode;
				//request url.
				document.installForm.mode.value='Install';
				document.installForm.package_id.value=node.data.id;
				document.installForm.submit();
            },
            installPackage : function(file){
				PackageManager.showWaiting();
				//get the list of packages that belong to this node
				var callback =	{
		  			success: function(data) {
			    		eval(data.responseText);
			    		if(typeof result != 'undefined') {
				    		eval(data.responseText);

	        				if(typeof result != 'undefined') {
								var licenseDiv = document.getElementById('licenseDiv');
								licenseDiv.style.display = 'block';
								licenseDiv.innerHTML = result['license_display'];
							}
	   					}//fi
	   				PackageManager.hideWaiting();
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) { if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=getLicenseText&file='+file;
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
            },
            deletePackagae : function(package_id){
				alert(package_id);
            },
			toggle_div : function toggle_div(id)
			{

				var dv = document.getElementById("release_table_"+id);
				var spn = document.getElementById("span_toggle_package_"+id);
				dv.style.display =(dv.style.display == 'none') ? 'block' : 'none';

				spn.innerHTML =(dv.style.display == 'none') ? show_img + "&nbsp;" : hide_img + "&nbsp;";
			},
            processLicense : function(file){
            	var licenseDiv = document.getElementById('licenseDiv');
								licenseDiv.style.display = 'none';
				PackageManager.showWaiting();
				//get the list of packages that belong to this node
				var callback =	{
		  			success: function(data) {
			    		eval(data.responseText);
			    		if(typeof result != 'undefined') {
				    		eval(data.responseText);

	        				if(typeof result != 'undefined') {

							}
	   					}//fi
	   				PackageManager.hideWaiting();
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) { if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=performInstall&file='+file;
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
            },
            getDocumentation : function(package_id, release_id){
            	PackageManager.showWaiting();
            	//var documentationWorkingDiv = document.getElementById('documentationWorkingDiv');
            	//documentationWorkingDiv.style.display = 'block';
	        	//var documentationDiv = document.getElementById('Documentation');
				//get the list of packages that belong to this node
				var callback =	{
		  			success: function(data) {

			    		eval(data.responseText);
			    		if(typeof result != 'undefined') {
			    		var screenshot_count = 0;
			    			var screenshot_html = "<table><tr>";
			    			var html = "<table><tr><th>Name</th><th>Description</th></tr>";
			    			for (var x = 0; x < result['documents'].length; x++){

			    				if(result['documents'][x]['type'] == 'image'){

			    					if((screenshot_count % 3) == 0){
			    						screenshot_html += "<tr>";
			    					}
			    					var url = result['documents'][x]['url'];
			    					if(result['documents'][x]['preview_url']){
			    						url = result['documents'][x]['preview_url'];
			    					}
			    					screenshot_html += "<td><a href='"+result['documents'][x]['url']+"' border='0' target='blank'><img src='"+url+"'></a></td>";
			    					if((screenshot_count % 3) == 0 && screenshot_count > 0){
			    						screenshot_html += "</tr>";
			    					}
			    					screenshot_count++;
			    				}else{
			    					html += "<tr>";
			    					html += "<td><a href='"+result['documents'][x]['url']+"' onClick='PackageManager.downloadedDocumentation("+result['documents'][x]['id']+");' target='blank'>"+result['documents'][x]['name']+"</a></td>";
			    					html += "<td>"+result['documents'][x]['description']+"</td>";
			    					html += "</tr>";
			    				}
			    			}//rof
			    			html += "</table>";
			    			screenshot_html += "</table>";
			    			var detailsTab = _tabs.getTab(1);
        					detailsTab.setContent(html, false);
        					var screenShotTab = _tabs.getTab(2);
        					screenShotTab.setContent(screenshot_html, false);
        					//detailsTab.activate();
							//documentationDiv.innerHTML = html;
							//documentationWorkingDiv.style.display = 'none';
							PackageManager.hideWaiting();
	   					}//fi
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) { documentationWorkingDiv.style.display = 'none'; PackageManager.hideWaiting();if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=getDocumentation&package_id='+package_id+'&release_id='+release_id;
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
	        },
	        downloadedDocumentation : function(document_id){
				var callback =	{
		  			success: function(data) {
	   					if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) { if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=downloadedDocumentation&document_id='+document_id;
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
            },
            packageClick : function(treeid, index){

				node=YAHOO.widget.TreeView.getNode(treeid, index);
				//var dt = document.getElementById('Details');
				var html ="<table>";
				html += "<tr><td>Name:</td><td>"+node.label+"</td></tr>";
				html += "<tr><td>Description:</td><td>"+node.description+"</td></tr>";
				html += "</table>";
				//dt.innerHTML = html;
				PackageManager.getDocumentation(node.data.id, '');
				var detailsTab = _tabs.getTab(0);
        		detailsTab.setContent(html, false);
        		detailsTab.activate();
            },
            releaseClick : function(treeid, index){
				node=YAHOO.widget.TreeView.getNode(treeid, index);
				//var dt = document.getElementById('Details');
				var html ="<table>";
				html += "<tr><td>Description:</td><td>"+node.label+"</td></tr>";
				html += "<tr><td>Version:</td><td>"+node.version+"</td></tr>";
				html += "</table>";
				//dt.innerHTML = html;
				var detailsTab = _tabs.getTab(0);
        		detailsTab.setContent(html, false);
        		detailsTab.activate();
				PackageManager.getDocumentation('', node.data.id);

            },
            catClick : function(treeid, index){
           		var node = YAHOO.namespace(treeid).selectednode;
				//var dt = document.getElementById('Details');
				var html ="<table>";
				html += "<tr><td>Name:</td><td>"+node.label+"</td></tr>";
				html += "<tr><td>Description:</td><td>"+node.data['description']+"</td></tr>";
				html += "</table>";
				//dt.innerHTML = html;
				var detailsTab = _tabs.getTab(0);
        		detailsTab.setContent(html, false);
        		detailsTab.activate();
            },
            select_package : function(package_id){
            	var dv = document.getElementById("package_tr_"+package_id);
            	dv.style.display='none';
            	var downloadTable = document.getElementById('filedownloadtable');
            	var tr = document.createElement('tr');
            	tr.innerHTML = dv.innerHTML
            	downloadTable.appendChild(tr);
            	var table = document.getElementById('fileviewtable');
            	table.deleteRow(0);

            },
            showErrors : function(errors){
            	 dialog = new YAHOO.ext.BasicDialog("loginView", {
                        //modal:true,
                        autoTabs:true,
                        width:500,
                        height:300,
                        shadow:true,
                        minWidth:300,
                        minHeight:250,
                        proxyDrag: true
                });
                dialog.addKeyListener(27, dialog.hide, dialog);
                dialog.addButton('Close', dialog.hide, dialog);
                dialog.addButton('Submit', dialog.hide, dialog).disable();
                dialog.show();
            },
            select_release : function(release_id){
            	var dv = document.getElementById("release_tr_"+release_id);
            },
			checkForUpdates : function(){
				PackageManager.showWaiting();
				var callback =	{
		  			success: function(data) {
			    		eval(data.responseText);
	        				if(typeof result != 'undefined') {
	        					var tree = YAHOO.widget.TreeView.getTree('treeview');
								var root = tree.getRoot();
								var myobj = { label: 'Updates', id:'updates'};
								tmpNode = tree.getNodeByProperty('id', 'updates');
								if(!tmpNode){
		   							tmpNode= new YAHOO.widget.TextNode(myobj, root, false);
									tmpNode.data['description'] = 'Updates Found';
								}else{
									tree.removeChildren(tmpNode);
								}
								tmpNode.expanded = true;

								for (var x = 0; x < result['updates'].length; x++){
									var myobj = { label: result['updates'][x]['label'], id:result['updates'][x]['id']};
		   							var tmpNodeRelease = new YAHOO.widget.TaskNode(myobj, tmpNode, false);
									tmpNodeRelease.version = result['updates'][x]['version'];
		   							tmpNodeRelease.href = "javascript:PackageManager.releaseClick('treeview',"+tmpNodeRelease.index+");"
		   							tmpNodeRelease.setDynamicLoad(PackageManager.loadDataForNodeForRelease);
									if(result['updates'][x]['type'] == 'patch'){
										tmpNodeRelease.onCheckClick = function(){this.uncheck();if(confirm('{/literal}{$MOD.MI_REDIRECT_TO_UPGRADE_WIZARD}{literal}')){location.href = '{/literal}{$UPGARDE_WIZARD_URL}{literal}'}};
									}else{
										tmpNodeRelease.onCheckClick = function(){this.data['isSelected'] = this.checked;};
									}
									tmpNodeRelease.type = 'release';
									tmpNodeRelease.category_id = '';
									tmpNodeRelease.package_id = '';
								}//rof
								tree.draw();
							}//fi
				    if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) { if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}
				PackageManager.hideWaiting();
				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=checkForUpdates&type=modules';
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
			},
			showLoginDialog : function(show){
				var loginView =  document.getElementById('loginView');
				var selectView =  document.getElementById('selectView');
				var collapseLink =  document.getElementById('span_animate_server_div');
				var credentialBtn =  document.getElementById('modifCredentialsBtn');
				var loginStyle = (show ? 'block' : 'none');
				var selectStyle = (show ? 'none' : 'block');
				var collapseStyle = (show ? 'none' : '');
				if(_attributes.height.to == MIN_HEIGHT){
				    MAX_HEIGHT=300;
				    PackageManager.toggleDiv('span_animate_server_div', 'catview');
				}
				loginView.style.display = loginStyle;
				selectView.style.display = selectStyle;
				collapseLink.style.display = collapseStyle;
				credentialBtn.style.display = collapseStyle;
			},
			refreshTreeRoot : function(){
				PackageManager.showWaiting();
				_loadingBar.setHeader("{/literal}{$MOD.LOADING_CATEGORIES}{literal}");
 				var callback =	{
		  			success: function(data) {
						_loadingBar.hide();
			    		eval(data.responseText);
			    		if(typeof result != 'undefined') {
			    			var tree = new YAHOO.widget.TreeView('treeview');

							var node = tree.getRoot();
							for (var x = 0; x < result['nodes'].length; x++){

								var myobj = { label: result['nodes'][x]['label'], id:result['nodes'][x]['id']};
		   						tmpNode= new YAHOO.widget.TextNode(myobj, node, false);
								tmpNode.href = "javascript:PackageManager.catClick('treeview',"+tmpNode.index+");";
		   						tmpNode.setDynamicLoad(PackageManager.loadDataForNodeForPackage);
								tmpNode.data['description'] = result['nodes'][x]['description'];

							}
							tree.draw();
	   					}//fi
	   				PackageManager.hideWaiting();
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) {_loadingBar.hide();if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=getCategories';
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
			},
			refreshGrid : function(){
				PackageManager.showWaiting();
				_loadingBar.setHeader("{/literal}{$MOD.SEARCHING_PACKAGES}{literal}");
 				var callback =	{
		  			success: function(data) {
		  			_loadingBar.hide();
			    		eval(data.responseText);
			    		if(typeof result != 'undefined') {
			    			_pmg.clearGrid();

	   						for (var x = 0; x < result['releases'].length; x++){
								var row = new Array();
								row[0] = result['releases'][x]['description'];
								row[1] = result['releases'][x]['version'];
								row[2] = result['releases'][x]['build_number'];
								row[3] = result['releases'][x]['id'];
								_pmg.addData(row);
							}//rof

	   					}//fi
	   				PackageManager.hideWaiting();
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) {_loadingBar.hide();if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}
				var types = "{/literal}{$GRID_TYPE}{literal}";
				//postData = 'to_pdf=1&module=Administration&action=HandleAjaxCall&method=getReleases&types='+types;
				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=checkForUpdates&type=modules';
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
			},
			refreshHeader : function(){
				PackageManager.showWaiting();
 				var callback =	{
		  			success: function(data) {
			    		eval(data.responseText);
			    		if(typeof result != 'undefined') {
			    			var header_div = document.getElementById('span_display_html');
			    			header_div.innerHTML = result['promotion'];
	   					}//fi
	   				PackageManager.hideWaiting();
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) {if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=getPromotion';
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
			},
			initTabs : function(){
				/*_tabs = new YAHOO.ext.TabPanel('tabs1');
				var detailTab = _tabs.addTab('details', "{/literal}{$MOD.ML_LBL_DETAIILS}{literal}");
				detailTab.setContent('{/literal}{$MOD.ML_DESC_DOCUMENTATION}{literal}', false);
        		_tabs.addTab('documentation', "{/literal}{$MOD.ML_LBL_DOCUMENTATION}{literal}");
        		_tabs.addTab('screenshots', "{/literal}{$MOD.ML_LBL_SCREENSHOTS}{literal}");
        		_tabs.addTab('reviews', "{/literal}{$MOD.ML_LBL_REVIEWS}{literal}");
        		_tabs.activate('details');*/
			},
			remove : function(file){
				if(confirm('{/literal}{$MOD.REMOVE_QUESTION}{literal}')){
				//PackageManager.showWaiting();
				var callback =	{
		  			success: function(data) {
			    		eval(data.responseText);
	        				if(typeof result != 'undefined') {
								PackageManager.getPackagesInStaging();
							}
	   				PackageManager.hideWaiting();
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) {if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=remove&file='+file
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
				}//fi
			},
			authenticate : function(username, password, servername){
			//rrs
								_loadingBar =
							new YAHOO.widget.Panel("wait",
															{ width:"240px",
															  fixedcenter:true,
															  close:false,
															  draggable:false,
															  modal:true,
															  visible:false,
															  effect:{effect:YAHOO.widget.ContainerEffect.FADE, duration:0.5}
															}
														);

					_loadingBar.setHeader("{/literal}{$MOD.AUTHENTICATING}{literal}");
					_loadingBar.setBody("<img src=\"include/javascript/yui/assets/rel_interstitial_loading.gif\"/>");
					_loadingBar.render(document.body);
					_loadingBar.show();
				//PackageManager.showWaiting();
				var btn = document.getElementById('panel_login_button');
				var cbTerms = document.getElementById('cb_terms');
				btn.value = 'Checking...';
				btn.disabled = true;
				var callback =	{
		  			success: function(data) {
						btn.value = 'Login';
						btn.disabled = false;
			    		eval(data.responseText);
	        				if(typeof result != 'undefined') {
								if(result['status'] == 'success'){
									PackageManager.showLoginDialog(false);
									var header_div = document.getElementById('span_display_html');
			    					if(header_div)
			    						header_div.innerHTML = '';
									 {/literal}{if $module_load == 'true'}{literal}

										PackageManager.refreshTreeRoot();
									 {/literal}{else}{literal}
									_pmg = new PackageManagerGrid();

									 	//PackageManager.refreshGrid();
									 	_pmg.renderAll();
									  {/literal}{/if}{literal}
								}else{
									_loadingBar.hide();
									alert(result['status']);
								}
							}
	   				//PackageManager.hideWaiting();
	   				if (typeof onCompleteCallback == 'function') onCompleteCallback();
		  			},
		  			failure: function(data) { _loadingBar.hide();btn.value = 'Login';btn.disabled = false;if (typeof onCompleteCallback == 'function') onCompleteCallback();}
				}

				postData = 'entryPoint=HandleAjaxCall&to_pdf=1&module=Administration&action=HandleAjaxCall&method=authenticate&username='+username+'&password='+password + '&servername=' + servername + '&terms_checked=' + cbTerms.value;
				var cObj = YAHOO.util.Connect.asyncRequest('POST','index.php',
								  callback, postData);
			}
	    };
	}();
}

var _fileGrid;
var _fileDownloadGrid;
var _fileGridInstalled;
{/literal}{$PATCHES}{literal}
{/literal}{$INSTALLED_MODULES}{literal}
PackageManagerGrid = function(){
{/literal}{if $module_load == 'true'}{literal}
        YAHOO.widget.DataTable.MSG_EMPTY = "Empty1";
        YAHOO.widget.DataTable.CLASS_EMPTY = "CLASS EMPT";
        YAHOO.widget.ScrollingDataTable.MSG_EMPTY = "Empty2";
        YAHOO.widget.ScrollingDataTable.CLASS_EMPTY = "EMPTYMORE";
        YAHOO.util.DataSource.MSG_EMPTY = "empty_3";
        var moduleTitleEl = YAHOO.util.Dom.getElementsByClassName("moduleTitle")[0];
        var patch_downloads_tableWidth = moduleTitleEl.clientWidth - 2+ "px";
		var patch_downloads_minWidth = moduleTitleEl.clientWidth / 8.5;
		_fileGrid = new YAHOO.widget.ScrollingDataTable(
                'patch_downloads',
                [
					{key:'name', label: '{/literal}{$ML_FILEGRID_COLUMN.Name}{literal}', minWidth: Math.round(patch_downloads_minWidth*1.5), sortable: true, resizeable: true},
                    {key:'file', label: '{/literal}{$ML_FILEGRID_COLUMN.Install}{literal}', minWidth: Math.round(patch_downloads_minWidth/1.5), formatter: this.renderInstallButton, resizeable: true},
                    {key:'unFile', label: '{/literal}{$ML_FILEGRID_COLUMN.Delete}{literal}', minWidth: Math.round(patch_downloads_minWidth), formatter: this.renderDeleteButton, resizeable: true},
        		    {key:'type', label: '{/literal}{$ML_FILEGRID_COLUMN.Type}{literal}', minWidth: Math.round(patch_downloads_minWidth/1.5)},
        		    {key:'version', label: '{/literal}{$ML_FILEGRID_COLUMN.Version}{literal}', minWidth: Math.round(patch_downloads_minWidth)},
        		    {key:'date', label: '{/literal}{$ML_FILEGRID_COLUMN.Published}{literal}', minWidth: Math.round(patch_downloads_minWidth)},
        	 	    {key:'uninstallable',  label: '{/literal}{$ML_FILEGRID_COLUMN.Uninstallable}{literal}', minWidth: Math.round(patch_downloads_minWidth/1.5)},
        		    {key:'description',label: '{/literal}{$ML_FILEGRID_COLUMN.Description}{literal}', minWidth: Math.round(patch_downloads_minWidth*1.5), sortable: true}
        		],
        		new YAHOO.util.LocalDataSource(mti_data, {
            		responseSchema: {fields: ['name', 'file', 'unFile', 'type', 'version', 'date', 'uninstallable', 'description', 'upload_file'] },
            		height: "190px"
        		}),
                {
                    MSG_EMPTY: "",
                    width : (YAHOO.util.Selector.query('table','content',true).clientWidth - 15) + "px",
                    height: (document.getElementById("patch_downloads").clientHeight - 25 ) + "px"
                }
            );
        _fileGrid.autoSizeColumns = true;
        _fileGrid.MSG_EMPTY = "empty4";
        _fileGrid.subscribe("beforeWidthChange", function() {
        		if (mti_data.length <= 0) {
        			return false;
        		}
        	}
        );
        _fileGrid.getColumn = YAHOO.SUGAR.SelectionGrid.prototype.getColumn;
        //Hack to fix  rendering bug in IE7:
        _fileGrid.on("renderEvent", function(){
            if (mti_data.length > 0)
                setTimeout("if (_fileGrid.getFirstTrEl()) _fileGrid.getFirstTrEl().style.width='100%';", 1000);
            else {
            	_fileGrid.getBdTableEl().style.display = "none";
            	_fileGrid.getHdTableEl().style.width = "100%";
            }
        });

        var moduleTitleEl2 = YAHOO.util.Dom.getElementsByClassName("moduleTitle")[0];
        var installed_grid_tableWidth = moduleTitleEl2.clientWidth - 2+ "px";
		var minWidth = moduleTitleEl2.clientWidth / 7.45;
	    _fileGridInstalled = new YAHOO.widget.ScrollingDataTable('installed_grid',
            [
			    {key:'name', label: '{/literal}{$ML_FILEGRIDINSTALLED_COLUMN.Name}{literal}', sortable: true, 'minWidth' : Math.round(minWidth*1.5)},
                {key:'unFile', label: '{/literal}{$ML_FILEGRIDINSTALLED_COLUMN.Action}{literal}', formatter: this.renderUninstallButton, 'minWidth' : Math.round(minWidth/1.5)},
                {key:'state_file', label: '{/literal}{$ML_FILEGRIDINSTALLED_COLUMN.Enable_Or_Disable}{literal}',formatter: this.renderEnableDisableButton, 'minWidth' : Math.round(minWidth/1.5)},
      		    {key:'type', label: '{/literal}{$ML_FILEGRIDINSTALLED_COLUMN.Type}{literal}', 'minWidth' : Math.round(minWidth/1.5)},
      		    {key:'version', label: '{/literal}{$ML_FILEGRIDINSTALLED_COLUMN.Version}{literal}', 'minWidth' : Math.round(minWidth)},
      		    {key:'date', label: '{/literal}{$ML_FILEGRIDINSTALLED_COLUMN.Date_Installed}{literal}', 'minWidth' : Math.round(minWidth)},
      		    {key:'description', label: '{/literal}{$ML_FILEGRIDINSTALLED_COLUMN.Description}{literal}', sortable: true, 'minWidth' : Math.round(minWidth*1.5)}
      		],
      		new YAHOO.util.LocalDataSource(mti_installed_data, {
          		responseSchema: {fields: ['name', 'file', 'unFile', 'state_file', 'type', 'version', 'date', 'uninstallable', 'description'] },
          	    height: "200px"}),
            {
	    	   MSG_EMPTY: "",
	    	   width : (YAHOO.util.Selector.query('table','content',true).clientWidth - 15 ) + "px",
	    	   height: (document.getElementById("installed_grid").clientHeight - 20 ) + "px"
	    	}
    	);

	    _fileGridInstalled.autoSizeColumns = true;
        _fileGridInstalled.MSG_EMPTY = "empty5";
        //bugfix for http://yuilibrary.com/projects/yui2/ticket/2528034
       	_fileGridInstalled.getColumn = YAHOO.SUGAR.SelectionGrid.prototype.getColumn;

       	_fileGridInstalled.on("renderEvent", function(){
       		if (mti_installed_data.length > 0)
                setTimeout("if(_fileGridInstalled.getFirstTrEl()) _fileGridInstalled.getFirstTrEl().style.width='100%';", 1000);
            else {
            	_fileGridInstalled.getBdTableEl().style.display = "none";
            	_fileGridInstalled.getHdTableEl().style.width = "100%";
            }
        });

{/literal}{else}{literal}
  		_fileGrid = new YAHOO.ext.grid.DDGrid(
                'patch_downloads',
                new YAHOO.ext.grid.DefaultDataModel([]),
                new YAHOO.ext.grid.DefaultColumnModel([
					{label: '{/literal}{$ML_FILEGRID_COLUMN.Description}{literal}', width: 215},
        		    {label: '{/literal}{$ML_FILEGRID_COLUMN.Version}{literal}', width: 72},
        		    {label: '{/literal}{$ML_FILEGRID_COLUMN.Build}{literal}', width: 80, sortable: true, sortType: sort.asUCString},
        		    {label: '{/literal}{$ML_FILEGRID_COLUMN.Action}{literal}', width: 90, renderer: this.renderButtons}
        		])
            );
  	    _fileGrid.autoSizeColumns = true;
    	_fileGrid.autoSizeHeaders = true;
	{/literal}{/if}{literal}
	PackageManager.showStatusMessages('{/literal}{$ML_STATUS_MESSAGE}{literal}');
}

PackageManagerGrid.prototype.renderModuleButtons = function(file){
	var output =  '<table border=0 cellpadding=0 cellspacing=0><tr><td><form action="index.php?module=Administration&view=module&action=UpgradeWizard_prepare" method="post">';
    	output += '<input type=submit class=\'button\' name="btn_mode" onclick="this.form.mode.value=\'Install\';this.form.submit();" value="{/literal}{$MOD.LBL_UW_BTN_INSTALL}{literal}" />';
        output += '<input type=hidden name="install_file" value="'+file+'" />';
		output += '<input type=hidden name="mode"/>';
        output += '</form></td><td>&nbsp;</td>';

        output += '<td><form action="index.php?module=Administration&view=module&action=UpgradeWizard" method="post">';
        output += '<input type=submit class=\'button\' name="run" value="{/literal}{$MOD.LBL_UW_BTN_DELETE_PACKAGE}{literal}" />';
        output += '<input type=hidden name="install_file" value="'+file+'" />';
        output += '</form></td></tr></table>';
        elCell.innerHTML = output;
}

PackageManagerGrid.prototype.renderInstallButton = function(elCell, oRecord, col, data) {
	var file = oRecord.getData().file;
	if(file.indexOf('errors_') == 0){
		var output = "<input type='button' class='button' value='Errors' onClick='javascript:alert(\""+file.substring(7)+"\");'>";
	}else{
		var output =  '<span style="text-align:center;"><form action="index.php?module=Administration&view=module&action=UpgradeWizard_prepare" method="post">';
    	output += '<input type=submit class=\'button\' name="btn_mode" onclick="this.form.mode.value=\'Install\';this.form.submit();" value="{/literal}{$MOD.LBL_UW_BTN_INSTALL}{literal}" />';
        output += '<input type=hidden name="install_file" value="'+file+'" />';
		output += '<input type=hidden name="mode"/>';
        output += '</form></span>';
    }
	elCell.innerHTML = output;
}
PackageManagerGrid.prototype.renderUninstallButton = function(elCell, oRecord, col, data) {
    var file = oRecord.getData().file;
	if(file.indexOf('errors_') == 0){
		var output = "<input type='button' class='button' value='Errors' onClick='javascript:alert(\""+file.substring(7)+"\");'>";
	}else if(file.indexOf('UNINSTALLABLE') == 0){
		var output = '';
	}else{
		var output =  '<span style="text-align:center;"><form action="index.php?module=Administration&view=module&action=UpgradeWizard_prepare" method="post">';
    	output += '<input type=submit class=\'button\' name="btn_mode" onclick="this.form.mode.value=\'Uninstall\';this.form.submit();" value="{/literal}{$MOD.LBL_UW_UNINSTALL}{literal}" />';
        output += '<input type=hidden name="install_file" value="'+file+'" />';
		output += '<input type=hidden name="mode"/>';
        output += '</form></span>';
    }

	elCell.innerHTML = output;
}

PackageManagerGrid.prototype.renderEnableDisableButton = function(elCell, oRecord, col, data) {
	var state_file = oRecord.getData().state_file;
	if(state_file.indexOf('ENABLED_') == 0){
		//enabled
		var output = '<span style="text-align:center;"><form action="index.php?module=Administration&view=module&action=UpgradeWizard_prepare" method="post">';
		file = state_file.substring(8);
		output += '<input type=submit class=\'button\' name="btn_mode" onclick="this.form.mode.value=\'Disable\';this.form.submit();" value="{/literal}{$MOD.LBL_UW_DISABLE}{literal}" />';
		 output += '<input type=hidden name="install_file" value="'+file+'" />';
		output += '<input type=hidden name="mode"/>';
    	output += '</form></span>';
	}else if(state_file.indexOf('UNINSTALLABLE') == 0){
		var output = '';
	}else{
		var output = '<span style="text-align:center;"><form action="index.php?module=Administration&view=module&action=UpgradeWizard_prepare" method="post">';
		file = state_file.substring(9);
    	output += '<input type=submit class=\'button\' name="btn_mode" onclick="this.form.mode.value=\'Enable\';this.form.submit();" value="{/literal}{$MOD.LBL_UW_ENABLE}{literal}" />';
    	output += '<input type=hidden name="install_file" value="'+file+'" />';
		output += '<input type=hidden name="mode"/>';
    	output += '</form></span>';
    }

	elCell.innerHTML = output;
}

PackageManagerGrid.prototype.renderDeleteButton = function(elCell, oRecord, col, file) {

	var upload_file = oRecord.getData().file;
var output = "<span style='text-align:center;'><input type='button' class='button' value='{/literal}{$MOD.LBL_UW_BTN_DELETE_PACKAGE}{literal}' onClick='PackageManager.remove(\""+file+"\");'></span>";
	 	//var output = '<form action="index.php?module=Administration&view=module&action=UpgradeWizard" method="post">';
       // output += '<input type=submit class=\'button\' name="run" value="{/literal}{$MOD.LBL_UW_BTN_DELETE_PACKAGE}{literal}" />';
        //output += '<input type=hidden name="install_file" value="'+file+'" />';
        //output += '</form>';

    elCell.innerHTML = output;
}

PackageManagerGrid.prototype.renderButtons = function(packageID){
	var output = "<input type='button' value='Download' class='button' onClick=\"{/literal}{if $INSTALLATION != 0}{literal}this.form.run.value='upload';{/literal}{/if}{literal}this.form.release_id.value='"+packageID+"';this.form.submit();\">";
    return output;
}
PackageManagerGrid.prototype.renderErrorLink = function(show){
	var output = "<a href='#'>Errors</a>";
    return output;
}
PackageManagerGrid.prototype.clearGrid = function(){
    _fileGrid.deleteRows(0, _fileGrid.getRecordSet().getLength())
}
PackageManagerGrid.prototype.renderAll = function(){
   // _fileGrid.render();
}

PackageManagerGrid.prototype.addData = function(data){
    _fileGrid.addRow(data);
}

YAHOO.util.Event.on(window, 'load', PackageManager.initPMG, PackageManager, true);
</script>
{/literal}
