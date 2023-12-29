<?php
/**
 * This file is part of SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation.
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
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

require_once 'modules/Campaigns/views/view.detail.php';
require_once 'SticInclude/Views.php';

class CustomCampaignsViewDetail extends CampaignsViewDetail {
    public function __construct() {

        parent::__construct();

    }

    public function preDisplay() {

        parent::preDisplay();

        // STIC-custom - 20211019 - STIC#440
        // Set the default buttons of the campaign detail view
        $this->dv->defs['templateMeta']['form']['buttons'][0] = self::editButton;
        $this->dv->defs['templateMeta']['form']['buttons'][1] = self::duplicateButton;
        $this->dv->defs['templateMeta']['form']['buttons'][2] = self::deleteButton;
        $this->dv->defs['templateMeta']['form']['buttons'][3] = self::wizardButton;
        $this->dv->defs['templateMeta']['form']['buttons'][4] = self::testSendButton;
        $this->dv->defs['templateMeta']['form']['buttons'][5] = self::queueSendButton;
        $this->dv->defs['templateMeta']['form']['buttons'][6] = self::markAsSentButton;
        $this->dv->defs['templateMeta']['form']['buttons'][7] = self::viewChangesButton;

        SticViews::preDisplay($this);

        // Write here you custom code
    }

    public function display() {

        parent::display();

        SticViews::display($this);

        echo getVersionedScript("custom/modules/Campaigns/SticUtils.js");

        // Write here you custom code
    }


    // STIC-custom - 20211019 - STIC#440
    // Definitions of the default buttons of the campaign detail view
    private const editButton = 'EDIT';
    private const duplicateButton = 'DUPLICATE';
    private const deleteButton = 'DELETE';
    private const wizardButton = array(
        'customCode' => '<input type="button" class="button" onclick="window.location=\'index.php?module=Campaigns&action=WizardHome&record={$fields.id.value}\';" name="button" id="launch_wizard_button" value="{$MOD.LBL_TO_WIZARD_TITLE}" />',
    );
    private const testSendButton = array(
        'customCode' => '<input title="{$MOD.LBL_TEST_BUTTON_TITLE}"  class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';this.form.mode.value=\'test\';SUGAR.ajaxUI.submitForm(this.form);" type="{$ADD_BUTTON_STATE}" name="button" id="send_test_button" value="{$MOD.LBL_TEST_BUTTON_LABEL}">',
        'sugar_html' => 
        array (
          'type' => 'input',
          'value' => '{$MOD.LBL_TEST_BUTTON_LABEL}',
          'htmlOptions' => 
          array (
            'type' => '{$ADD_BUTTON_STATE}',
            'title' => '{$MOD.LBL_TEST_BUTTON_TITLE}',
            'class' => 'button',
            'onclick' => 'this.form = document.getElementById(\'formDetailView\'); this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';this.form.mode.value=\'test\';SUGAR.ajaxUI.submitForm(this.form);',
            'name' => 'button',
            'id' => 'send_test_button',
          ),
        )
    );
    private const queueSendButton = array(

        'customCode' => '<input title="{$MOD.LBL_QUEUE_BUTTON_TITLE}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';SUGAR.ajaxUI.submitForm(this.form);" type="{$ADD_BUTTON_STATE}" name="button" id="send_emails_button" value="{$MOD.LBL_QUEUE_BUTTON_LABEL}">',
        'sugar_html' => 
        array (
            'type' => 'input',
            'value' => '{$MOD.LBL_QUEUE_BUTTON_LABEL}',
            'htmlOptions' => 
            array (
            'type' => '{$ADD_BUTTON_STATE}',
            'title' => '{$MOD.LBL_QUEUE_BUTTON_TITLE}',
            'class' => 'button',
            'onclick' => 'this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'Schedule\';SUGAR.ajaxUI.submitForm(this.form);',
            'name' => 'button',
            'id' => 'send_emails_button',
            ),
        )
    );
    private const markAsSentButton = array(
        'customCode' => '<input title="{$MOD.LBL_MARK_AS_SENT}" class="button" onclick="this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'DetailView\';this.form.mode.value=\'set_target\';SUGAR.ajaxUI.submitForm(this.form);" type="{$TARGET_BUTTON_STATE}" name="button" id="mark_as_sent_button" value="{$MOD.LBL_MARK_AS_SENT}">',
        'sugar_html' => 
        array (
          'type' => 'input',
          'value' => '{$MOD.LBL_MARK_AS_SENT}',
          'htmlOptions' => 
          array (
            'type' => '{$TARGET_BUTTON_STATE}',
            'title' => '{$MOD.LBL_MARK_AS_SENT}',
            'class' => 'button',
            'onclick' => 'this.form.return_module.value=\'Campaigns\'; this.form.return_action.value=\'TrackDetailView\';this.form.action.value=\'DetailView\';this.form.mode.value=\'set_target\';SUGAR.ajaxUI.submitForm(this.form);',
            'name' => 'button',
            'id' => 'mark_as_sent_button',
          ),
        )
    );
    private const viewChangesButton = array(
        'customCode' => '<script>{$MSG_SCRIPT}</script>'
    );

}
