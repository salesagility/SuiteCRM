<!DOCTYPE html>
<html>
    <head>
		<?php
		if (!file_exists("fielddefs/localization.php")) die('There is a problem with your installation. Please contact NS-Team at quickcrm@nst-team.fr');
		require_once('fielddefs/localization.php');
		$language=$default_language;
		if(isset($_REQUEST['language'])){
			$language=$_REQUEST['language'];
		}
		// language files for Sugar Fields
		if (!file_exists("fielddefs/modules_$language.js")) {
//			echo "console.log('language $language not found');";
			$language="en_us";
		}
		// language file for QuickCRM interface
		if ($language=='es_ES') {
				$conf_language='es_es';
		} else {
			$conf_language=$language; 
		}
		if (!file_exists("js/mobile_$language.js")) $conf_language="en_us";
		?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
		<meta name="apple-itunes-app" content="app-id=593452214">
        <link rel="apple-touch-icon" href="images/QuickCRM-CE.png"/>
        <script type="text/javascript" src="lib/jquery-1.8.2.min.js"></script>
		<?php
        echo <<<EOQ
        <script type="text/javascript" src="config.js?v=$time"></script>
        <script type="text/javascript" src="fielddefs/$language.js"></script>
        <script type="text/javascript" src="fielddefs/modules_$language.js"></script>
        <script type="text/javascript" src="fielddefs/fields.js"></script>
        <script type="text/javascript" src="js/mobile_$conf_language.js"></script>
EOQ;
		?>
        <script type="text/javascript" src="lib/modernizr.js"></script>
        <link rel="stylesheet" href="lib/jquerymobile/jquery.mobile-1.3.2.min.css" />
        <link rel="stylesheet" href="lib/jquerymobile/jqm-icon-pack-fa.css" />
        <link rel="stylesheet" href="lib/mobiscroll/mobiscroll-2.5.custom.min.css" />
        <script type="text/javascript" src="lib/jquerymobile/jquery.mobile-1.3.2.min.js"></script>
        <script type="text/javascript" src="lib/mobiscroll/mobiscroll-2.5.custom.min.js"></script>
        <script type="text/javascript" src="lib/json2.min.js"></script>
		<script type="text/javascript" language="Javascript">
			var froot="./", QCRM={}, app_version="",mobile_app=false, sugar_flavor='CE', ForceCE=false, loaded_scripts=false, proxy_url, QuickCRMAddress = '.', ServerAddress='../',myTimeZone,qusers, mobile_usr=new Array(),  init_module = '', init_record="";
				QCRM={
					OffLine:false,
					StoredVersion:false,
					UpdatedConfig:false,
					TimeDiff:false,
					JJWG:false,
					calendar: {enabled:false,dates:{},init:false, currDate:new Date()}
				};
			$( document ).bind( "mobileinit", function() {
				$.mobile.defaultPageTransition = 'none';
			});
		proxy_url=(QuickCRMAddress+(QuickCRMAddress.substr(-1)==="/"?"":"/"))+(mobile_app?"REST":"../service/v"+(sugar_version >= '6.4'?'4_1':(sugar_version >= '6.2'?'4':'2')))+"/rest.php";
		</script>
        <script type="text/javascript" src="js/quickcrm-utils-ce-3.2.min.js"></script>
        <script type="text/javascript" src="js/quickcrm-ce-3.3.2.min.js"></script>
		<?php
		if (file_exists("../custom/QuickCRM/custom.js")) {
			echo '<script type="text/javascript" src="../custom/QuickCRM/custom.js?v='.time().'"></script>';
		}
		?>
		

		<?php
		if(isset($_REQUEST['module']) && isset($_REQUEST['record'])){
        echo <<<EOQ
<script type="text/javascript" language="Javascript">
	init_module = '{$_REQUEST['module']}'; init_record='{$_REQUEST['record']}';
</script>
EOQ;
		}
		?>
		<!-- Mobile language file and UI -->
        <link rel="stylesheet" href="css/quickcrm331.css" />
        <title>QuickCRM CE</title>
    </head>
    <body>

        <div id="LoginPage" data-role="page" data-theme="b" data-title="QuickCRM">
            <div data-role="header">
                <h1 id="LoginPageTitle">QuickCRM</h1>
            </div>  
            <div data-role="content">
				<div id="LoginCustom">
				</div>
				<div id="LoginLoading">
					<p>... Loading</p>
				</div>
				<div id="HomeWarning">
				</div>
				<div id="LoginForm" style="display: none;">
                <p id="LoginPageMessage"></p>
				<fieldset data-role="controlgroup" data-mini="true">
					<label id="SettingsUsernameLabel" for="SettingsUsername"></label>
					<input id="SettingsUsername" type="text" />
				</fieldset>
                
				<fieldset data-role="controlgroup" data-mini="true">
					<label id="SettingsPasswordLabel" for="SettingsPassword"></label>
					<input id="SettingsPassword" type="password" />
				</fieldset>
                
				
				</div>
            </div>
			<div data-role="popup" id="AlertLoginPage"></div>
            <div data-role="footer" data-position="fixed" style="height:38px" data-theme="b">
                <p style="font-size:14px" id="LoginFooter"></p>
            </div><!-- /footer -->
        </div>

        <div id="HomePage" data-role="page" data-theme="c" data-title="Home" class="ui-responsive-panel">
            <div data-role="panel" data-theme="a" id="HomePanel" data-display="reveal" data-dismissible="false">
				<table width="100%"><tr>
					<td><a href="#" onclick="OpenHelp()" data-icon="question"  data-theme="a" data-role="button" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a></td>
					<td align="center"><a href="#LockPage" data-rel="dialog" id="LockBtn" data-icon="lock"  data-theme="a" data-role="button" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a></td>
					<td align="right"><a id="LogOutButton" href="javascript:Disconnect();LogOutUser();" data-theme="a" data-role="button" data-icon="power" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a></td>
				</tr></table>
				<input id="PanelSearchText" type="text" data-mini="true" data-clear-btn="true"></input>
				<div>
					<ul id="PanelSearchDiv" data-role="listview" data-theme="a" data-filter="false" />
				</div>
				<br>
				<div>
					<ul id="LastViewedPanelDiv" data-theme="a" data-role="listview" data-filter="false" style="list-style: none;margin: 0;padding: 0;">
					</ul>
				</div>
			</div>
            <div data-role="header">
				<a href="#HomePanel" data-icon="reorder" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a>
                <h1 id="HomePageTitle">QuickCRM</h1>
                <a id="NotifyHomeBtn" href="#HomeNotify" data-rel="popup" data-theme="e" data-icon="flag" data-iconpos="notext"  style="display:none;" class="ui-btn-right"></a>
				<div id="HomeBar" data-role="navbar" data-mini="true" >
					<ul>
						<li><a id="AllModulesLinkLabel" href="#AllModulesPopup" data-rel="popup" data-theme="c" data-role="button" data-icon="faplus"  data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a></li>
						<li><a id="ActivitiesLinkLabel" href="#ActivitiesListPage" data-theme="c" data-transition="none" data-role="button" data-icon="calendar" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a></li>
						<li id="MapsContainer"><a id="MapsLinkLabel" href="#" onclick="javascript:JJWG.ShowMapSearch();" data-theme="c" data-role="button" data-icon="mappin" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc ui-disabled"></a></li>
						<li id="OffLineContainer"><a id="SyncPageLinkLabel" href="#SyncPage" data-theme="c" data-role="button" data-icon="retweet" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a></li>
						<li><a id="AdminPageLinkLabel" href="#AllOptions" data-theme="c" data-role="button" data-icon="wrench" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a></li>
					</ul>
				</div>	
            </div>
            <div data-role="content">
				<div id="HomeCustom">
				</div>
				<div id="Favorites" class="IconWrapper">
				</div>
				<div id="Creates" class="IconWrapper">
				</div>
                <ul class="IconWrapper" id="HomeMenu">
                </ul>
                <a id='lnkPwd' href="#EnterPwdPage" data-rel="dialog" data-position-to="window" style='display:none;'></a>
				<div id="AllModulesPopup" data-role="popup" data-theme="c">
					<ul id="AllModulesPopupDiv" data-role="listview" data-theme="c" data-split-theme="c" data-filter="false" />
				</div>
            </div><!-- /content -->
        </div>

        <div id="ActivitiesListPage" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
                <h1 id="ActivitiesListPageTitle"></h1>
            </div>
            <div id="ActivitiesListPageSubMenu">
				<div data-role="controlgroup"  style="text-align: center" data-mini="true" data-type="horizontal" >
					<input type="radio" name="ActPeriod" id="ActPeriod_missed" value="missed" class="custom" data-theme="c"/>
					<label for="ActPeriod_missed"></label>
					<input type="radio" name="ActPeriod" id="ActPeriod_today" value="today" class="custom" data-theme="c" checked="checked"  />
					<label for="ActPeriod_today"></label>
					<input type="radio" name="ActPeriod" id="ActPeriod_7days" value="7days" class="custom" data-theme="c"   />
					<label for="ActPeriod_7days"></label>
					<input type="radio" name="ActPeriod" id="ActPeriod_30days" value="30days" class="custom" data-theme="c"   />
					<label for="ActPeriod_30days"></label>
				</div>
            </div>
            <div data-role="content">
                <ul id="AllActivitiesListDiv" data-role="listview" data-split-theme="c" data-filter="false" />
            </div><!-- /content -->
            <div data-role="footer" data-position="fixed" data-theme="a">
				<div data-role="navbar">
					<ul>
						<li><a id="ActivitiesListPageHomeBtn" href="#HomePage" data-role="button" data-icon="home" data-direction="reverse"></a></li>
						<li><a id="ActivitiesLastViewedBtn" href="#LastViewedListPage" data-role="button" data-icon="page" data-direction="reverse"></a></li>
						<li><a id="ActivitiesAllModulesBtn" href="#AllModulesListPage" data-role="button" data-icon="grid" data-direction="reverse"></a></li>
					</ul>
				</div>
            </div>
        </div>

        <div id="LastViewedListPage" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
                <h1 id="LastViewedListPageTitle"></h1>
            </div>
            <div data-role="content">
                <ul id="LastViewedListDiv" data-role="listview" data-split-theme="c" data-filter="false" />
            </div><!-- /content -->
            <div data-role="footer" data-position="fixed" data-theme="a">
				<div data-role="navbar">
					<ul>
						<li><a id="LastViewedListPageHomeBtn" href="#HomePage" data-icon="home" data-direction="reverse"></a></li>
						<li><a id="LastViewedCalendarBtn" href="#ActivitiesListPage" data-role="button" data-icon="calendar" data-direction="reverse"></a></li>
						<li><a id="LastViewedGSBtn" href="#GlobalSearch" data-rel="dialog" data-transition="none" data-role="button" data-icon="search"></a></li>
						<li><a id="LastViewedAllModulesBtn" href="#AllModulesListPage" data-role="button" data-icon="grid" data-direction="reverse"></a></li>
					</ul>
				</div>
            </div>
        </div>

        <div id="GSListPage" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
                <h1 id="GSPageTitle"></h1>
            </div>
            <div data-role="content">
                <ul id="GSListDiv" data-role="listview" data-split-theme="c" data-filter="false" />
            </div><!-- /content -->
            <div data-role="footer" data-position="fixed" data-theme="a">
				<div data-role="navbar">
					<ul>
						<li><a id="GSListPageHomeBtn" href="#HomePage" data-icon="home" data-direction="reverse"></a></li>
						<li><a id="GSCalendarBtn" href="#ActivitiesListPage" data-role="button" data-icon="calendar" data-direction="reverse"></a></li>
						<li><a id="GSLastViewedBtn" href="#LastViewedListPage" data-role="button" data-icon="page" data-direction="reverse"></a></li>
						<li><a id="GSGSBtn" href="#GlobalSearch" data-rel="dialog" data-transition="none" data-role="button" data-icon="search"></a></li>
						<li><a id="GSAllModulesBtn" href="#AllModulesListPage" data-role="button" data-icon="grid" data-direction="reverse"></a></li>
					</ul>
				</div>
            </div>
        </div>

        <div id="AllModulesListPage" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
                <h1 id="AllModulesListPageTitle"></h1>
            </div>
            <div data-role="content">
                <ul id="AllModulesListDiv" data-role="listview" data-split-theme="c" data-filter="false" />
            </div><!-- /content -->
            <div data-role="footer" data-position="fixed" data-theme="a">
				<div data-role="navbar">
					<ul>
						<li><a id="AllModulesListPageHomeBtn" href="#HomePage" data-icon="home" data-direction="reverse"></a></li>
						<li><a id="AllModulesCalendarBtn" href="#ActivitiesListPage" data-role="button" data-icon="calendar" data-direction="reverse"></a></li>
						<li><a id="AllModulesGSBtn" href="#GlobalSearch" data-rel="dialog" data-transition="none" data-role="button" data-icon="search"></a></li>
						<li><a id="AllModulesLastViewedBtn" href="#LastViewedListPage" data-role="button" data-icon="page" data-direction="reverse"></a></li>
					</ul>
				</div>
            </div>
        </div>

        <div id="QLogout" data-role="page" data-theme="b">
            <div data-role="header" data-theme="b">
                <h1 id="QDialogTitle">QuickCRM</h1>
            </div>
            <div data-role="content">
                <h3 id="QDialogLabel"></h3>
				<div style="margin:0 auto; margin-left:auto; margin-right:auto; align:center; text-align:center;">
					<a id="CancelLogout"  href="#HomePage" data-role="button" data-mini="true" data-inline="true" data-theme="c"></a>
					<a id="ConfirmLogout" href="javascript:LogOutUser();" data-role="button" data-inline="true" data-mini="true"  ></a>
				</div>
            </div>
        </div>
		
        <div id="AllOptions" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
				<a href="#" data-role="button" data-rel="back" data-icon="arrow-l" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a>
                <h1 id="AllOptionsTitle"></h1>
            </div>
            <div data-role="content">
					<ul data-role="listview" data-theme="c" data-filter="false" >
						<li><a id="OptionsGeneralLnk" href="#OptionsGeneral" data-transition="slide"></a></li>
						<li><a id="OptionsHomeLnk" href="#OptionsHome" data-transition="slide"></a></li>
						<li><a id="OptionsSortOrderLnk" href="#OptionsSortOrder" data-transition="slide"></a></li>
						<li id="OptFilterOldDiv" ><a id="OptionsFilterOldLnk" href="#OptionsFilterOld" data-transition="slide"></a></li>
						<li id="OptActDiv" ><a id="OptionsActLnk" href="#OptionsAct" data-transition="slide">Calls and meetings</a></li>
						<li id="ContactNSTEAMContainer">
						<li id="OptGetPro"><a id="OptGetProLnk" href="#" style="white-space:normal;" onclick="OpenQuickCRM()"></a></li>
                    </li>
					</ul>
            </div>
        </div>
		
        <div id="OptionsGeneral" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
				<a href="#" data-role="button" onclick="OptionsGeneralSave();" data-rel="back" data-icon="arrow-l" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a>
                <h1 id="OptionsGeneralTitle"></h1>
            </div>
            <div data-role="content">
					<div data-role="fieldcontain">
						<fieldset data-role="controlgroup" data-mini="true">
							<legend id="OptToolbarLbl"></legend>
							<input type="checkbox" name="OptIconsLabels" id="OptIconsLabels" class="custom" data-theme="c" />
							<label for="OptIconsLabels"></label>
						</fieldset>
					</div>
					<div data-role="fieldcontain" data-mini="true">
						<label for="OptRowsPerPage"></label>
						<input type="range" name="OptRowsPerPage" id="OptRowsPerPage" value="20" step="5" min="5" max="500" data-theme="c" data-track-theme="b" />
					</div>

					<div id="RowsPerDashlet" data-role="fieldcontain" data-mini="true">
						<label for="OptRowsPerDashlet"></label>
						<input type="range" name="OptRowsPerDashlet" id="OptRowsPerDashlet" value="5" step="5" min="5" max="20" data-theme="c" data-track-theme="b" />
					</div>

					<div data-role="fieldcontain">
						<fieldset data-role="controlgroup" data-mini="true">
							<legend id="OptHideEmptySubPLbl">Subpanels</legend>
							<input type="checkbox" name="OptHideEmptySubP" id="OptHideEmptySubP" class="custom" data-theme="c" />
							<label for="OptHideEmptySubP"></label>
						</fieldset>
					</div>
					<div data-role="fieldcontain" id="OptAlertDiv">
						<fieldset data-role="controlgroup" data-mini="true">
							<legend id="OptAlertsLbl"></legend>
							<input type="checkbox" name="OptAlerts" id="OptAlerts" class="custom" data-theme="c" />
							<label for="OptAlerts"></label>
						</fieldset>
					</div>
            </div>
        </div>
	
        <div id="OptionsHome" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
				<a href="#" data-role="button" onclick="OptionsHomeSave();" data-rel="back" data-icon="arrow-l" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a>
                <h1 id="OptionsHomeTitle"></h1>
            </div>
            <div data-role="content">
				<div data-role="fieldcontain">
					<fieldset id="OptHomeIcons" data-role="controlgroup"  data-mini="true"/>
				</div>
            </div>
        </div>
	
        <div id="OptionsSortOrder" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
				<a href="#" data-role="button" onclick="OptionsSortOrderSave();" data-rel="back" data-icon="arrow-l" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a>
                <h1 id="OptionsSortOrderTitle"></h1>
            </div>
            <div data-role="content">
					<ul id="ModulesListSort" data-role="listview" data-theme="c" data-filter="false" />
            </div>
        </div>
	
        <div id="OptionsFilterOld" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
				<a href="#" data-role="button" onclick="OptionsFilterOldSave();" data-rel="back" data-icon="arrow-l" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a>
                <h1 id="OptionsFilterOldTitle"></h1>
            </div>
        </div>
	
        <div id="OptionsAct" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
				<a href="#" data-role="button" onclick="OptionsActSave();" data-rel="back" data-icon="arrow-l" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a>
                <h1 id="OptionsActTitle"></h1>
            </div>
        </div>
	
		<div id="GlobalSearch" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
                <h1 id="GlobalSearchTitle"></h1>
            </div>
            <div data-role="content">
					<input id="GSSearchText" type="text"></input>
					<a id="GSSubmit" href="javascript:GlobalSearch('GSSearchText','GSListDiv','GSListPage',40);" data-mini="true" data-role="button" data-theme="c"></a>  
			</div>
		</div>
		<div id="LockPage" data-role="page" data-theme="c">
            <div data-role="header" data-theme="b">
                <h1 id="LockPageTitle"></h1>
            </div>
            <div data-role="content">
				<div id="AppLocked">
					<h3 id="AppUnlockTitle"></h3>
					<fieldset data-role="controlgroup" data-mini="true">
						<label id="RemoveLockLabel" for="RemoveLock"></label>
						<input id="RemoveLock" type="password" />
					</fieldset>
				</div>
				<div id="AppUnlocked">
					<h3 id="AppDefLockTitle"></h3>
					<fieldset data-role="controlgroup" data-mini="true">
						<label id="DefPasswordLabel" for="DefPassword"></label>
						<input id="DefPassword" type="password" />
					</fieldset>
					<fieldset data-role="controlgroup" data-mini="true">
						<label id="DefPassword2Label" for="DefPassword2"></label>
						<input id="DefPassword2" type="password" />
					</fieldset>
				</div>
				<div >
					<em id="LockErr"></em>
				</div>
				<div class="ui-grid-a">
					<div class="ui-block-a"><a id="LockPageCancelBtn" href="#" data-role="button" data-rel="back" data-theme="c"></a></div>
					<div class="ui-block-b"><a id="LockPageConfirmBtn" href="javascript:SaveLockPage();" data-role="button" ></a></div>
				</div>
			</div>
		</div>

		<div id="EnterPwdPage" data-role="page" data-theme="c">
            <div data-role="content">
				<div>
					<fieldset data-role="controlgroup" data-mini="true">
						<label id="EnterPasswordLabel" for="EnterPassword"></label>
						<input id="EnterPassword" type="password" />
					</fieldset>
					<div >
						<em id="PwdErr"></em>
					</div>
					<a id="EnterPwdConfirmBtn" href="javascript:PasswordEntered();" data-role="button" ></a>
				</div>
			</div>
		</div>

        <div id="DownloadPage" data-role="page" data-theme="b">
            <div data-role="header" data-theme="b">
				<a href="#" data-role="button" data-rel="back"  data-icon="arrow-l" data-iconpos="notext" data-shadow="false" data-iconshadow="false" class="ui-icon-nodisc"></a>
                <h1 id="DownloadPageTitle"></h1>
           </div>

            <div data-role="content">
				<div id="DownloadDiv"></div>
            </div>
        </div>

    </body>
</html>
