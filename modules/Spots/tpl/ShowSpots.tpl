{*
/**
 *
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2018 SalesAgility Ltd.
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
*}
<link rel="stylesheet" type="text/css" href="include/javascript/c3/c3.min.css">
<script type="text/javascript" src="include/javascript/touchPunch/jquery.ui.touch-punch.min.js"></script>
<link rel="stylesheet" type="text/css" href="include/javascript/pivottable/pivot.css">
<script type="text/javascript" src="include/javascript/suitespots/suitespots.js"></script>
{literal}
<script>
    function snapshotForm(theForm) {
        var snapshotTxt = '';
        var elemList = theForm.elements;
        var elem;
        var elemType;

        for (var i = 0; i < elemList.length; i++) {
            elem = elemList[i];

            //The pvtRenderer and pvtAggregator checks are to not add the suite spot items
            //I have used $.hasClass as the element.classlist.contains is not implemented in all browsers
            if (typeof(elem.type) == 'undefined' || $(elem).hasClass('pvtRenderer') || $(elem).hasClass('pvtAggregator') || $(elem).hasClass('pvtAttrDropdown')) {
                continue;
            }
            elemType = elem.type.toLowerCase();
            snapshotTxt = snapshotTxt + elem.name;

            if (elemType == 'text' || elemType == 'textarea' || elemType == 'password') {
                snapshotTxt = snapshotTxt + elem.value;
            }
            else if (elemType == 'select' || elemType == 'select-one' || elemType == 'select-multiple') {
                var optionList = elem.options;
                for (var ii = 0; ii < optionList.length; ii++) {
                    if (optionList[ii].selected) {
                        snapshotTxt = snapshotTxt + optionList[ii].value;
                    }
                }
            }

            else if (elemType == 'radio' || elemType == 'checkbox') {
                if (elem.selected) {
                    snapshotTxt = snapshotTxt + 'checked';
                }
            }
            else if (elemType == 'hidden') {
                //Remove the whitespace around elements to facilitate the comparison of changed values
                //http://stackoverflow.com/a/31502096
                snapshotTxt = snapshotTxt + elem.value.replace(/("[^"]*")|\s/g, "$1");
            }
        }

        return snapshotTxt;
    }

    var SpotsObj = (function () {
        const _this = this;
        const buttonIds = ['SAVE_HEADER', 'SAVE_FOOTER', 'save_and_continue'];

        this.setEvents = function (buttons) {
            for (var i = 0; i < buttons.length; i++) {
                var button = document.getElementById(buttons[i]);

                if (button) {
                    button.addEventListener('click', function () {
                        window.onbeforeunload = sendAndRedirect('EditView', 'Saving Spots...', '?module=Spots');
                    });
                }
            }
        };
        function resetButtons() {
            if (document.getElementById('EditView')) {
                _this.setEvents(buttonIds);
            }
        }

        var result = {};
        result.resetButtons = resetButtons;

        return result;
    })();

    SpotsObj.resetButtons();
</script>
{/literal}

<div id="output" style="overflow: auto"></div>
