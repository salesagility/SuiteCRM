<?php
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2017 SalesAgility Ltd.
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
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
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
 * reasonably feasible for technical reasons, the Appropriate Legal Notices must
 * display the words "Powered by SugarCRM" and "Supercharged by SuiteCRM".
 */

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

class Jjwg_MapsViewMap_Display extends SugarView
{

    /**
     * @deprecated deprecated since version 7.6, PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code, use __construct instead
     */
    function Jjwg_MapsViewMap_Display()
    {
        $deprecatedMessage = 'PHP4 Style Constructors are deprecated and will be remove in 7.8, please update your code';
        if (isset($GLOBALS['log'])) {
            $GLOBALS['log']->deprecated($deprecatedMessage);
        } else {
            trigger_error($deprecatedMessage, E_USER_DEPRECATED);
        }
        self::__construct();
    }

    function __construct()
    {
        parent::__construct();
    }

    function display()
    {
        // Limit URI query string parameters. Used to avoid URL length errors.
        $valid_names = array(
            'action',
            'module',
            'entryPoint',
            'submit',
            'cron',
            'geocoding_process',
            'process_trigger',
            'distance',
            'unit_type',
            'record',
            'related_id',
            'related_module',
            'quick_address',
            'display_module',
            'list_id',
            'uid',
            'current_post'
        );
        $url = $GLOBALS['sugar_config']['site_url'] . '/index.php?module=' . $GLOBALS['currentModule'] . '&action=map_markers';
        foreach (array_keys($_REQUEST) as $key) {
            if (in_array($key, $valid_names) && !in_array($key, array('action', 'module', 'entryPoint'))) {
                $url .= '&' . $key . '=' . urlencode($_REQUEST[$key]);
            }
        }

        ?>
        <script type="text/javascript"
                src="modules/jjwg_Maps/javascript/jquery.iframe-auto-height.plugin.1.9.3.min.js"></script>
        <script>

          function resizeDataTables() {
            $('#mapDisplayIframe').css('height: 200px;');
            setTimeout(function () {
              $('#resizeMapDisplayIframe').trigger("click");
            }, 250);
          }

          $(document).ready(function () {

            // fire iframe resize when window is resized
            var windowResizeFunction = function (resizeFunction, iframe) {
              $(window).resize(function () {
                resizeFunction(iframe);
              });
            };

            // fire iframe resize when a link is clicked
            var clickFunction = function (resizeFunction, iframe) {
              $('#resizeMapDisplayIframe').click(function () {
                resizeFunction(iframe);
                return false
              });
            };

            $('#mapDisplayIframe').iframeAutoHeight({
              debug: false,
              triggerFunctions: [
                windowResizeFunction,
                clickFunction
              ]
            });

          });

        </script>

        <iframe id="mapDisplayIframe" src="<?php echo $url; ?>"
                width="100%" height="800" frameborder="0" marginheight="0" marginwidth="0"
                scrolling="auto"><p>Sorry, your browser does not support iframes.</p></iframe>

        <?php
        if (empty($_REQUEST['uid']) && empty($_REQUEST['current_post'])) {
            ?>
            <p>IFrame:
                <a href="<?php echo htmlspecialchars($url); ?>"><?php echo $GLOBALS['mod_strings']['LBL_MAP']; ?>URL</a>
                <a href="#" id="resizeMapDisplayIframe" style="display: none;">.</a>
            </p>
            <?php
        }
        ?>


        <?php

    }
}
