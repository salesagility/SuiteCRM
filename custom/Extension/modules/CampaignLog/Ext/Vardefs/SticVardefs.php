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
// This file adds several calculated fields to make them available in kreporter
$dictionary['CampaignLog']['fields']['campaign_name'] = array(
    'name' => 'campaign_name',
    'vname' => 'LBL_KREPORTER_CAMPAIGN_NAME',
    'type' => 'kreporter',
    'source' => 'non-db',
    'kreporttype' => 'varchar',
    'eval' => array(
        'presentation' => array(
            'eval' => 'SELECT campaigns.name FROM campaigns where campaigns.id={t}.campaign_id GROUP BY campaigns.name',
        ),
        'selection' => array(
            'equals' => 'exists(SELECT campaigns.name FROM campaigns where campaigns.id={t}.campaign_id and campaigns.name=\'{p1}\' GROUP BY campaigns.name)',
            'contains' => 'exists(SELECT campaigns.name FROM campaigns where campaigns.id={t}.campaign_id and campaigns.name like \'%{p1}%\' GROUP BY campaigns.name)',
            'starts' => 'exists(SELECT campaigns.name FROM campaigns where campaigns.id={t}.campaign_id and campaigns.name like \'{p1}%\' GROUP BY campaigns.name)',
        ),
    ),
);

$dictionary['CampaignLog']['fields']['tracker_url_name'] = array(
    'name' => 'tracker_url_name',
    'vname' => 'LBL_KREPORTER_TRACKER_URL_NAME',
    'type' => 'kreporter',
    'source' => 'non-db',
    'kreporttype' => 'varchar',
    'eval' => array(
        'presentation' => array(
            'eval' => 'SELECT campaign_trkrs.tracker_name FROM campaign_trkrs where campaign_trkrs.id={t}.related_id GROUP BY campaign_trkrs.tracker_name',
        ),
        'selection' => array(
            'equals' => 'exists(SELECT campaign_trkrs.tracker_name FROM campaign_trkrs where campaign_trkrs.id={t}.related_id and campaign_trkrs.tracker_name=\'{p1}\' GROUP BY campaign_trkrs.tracker_name)',
            'contains' => 'exists(SELECT campaign_trkrs.tracker_name FROM campaign_trkrs where campaign_trkrs.id={t}.related_id and campaign_trkrs.tracker_name like \'%{p1}%\' GROUP BY campaign_trkrs.tracker_name)',
            'starts' => 'exists(SELECT campaign_trkrs.tracker_name FROM campaign_trkrs where campaign_trkrs.id={t}.related_id and campaign_trkrs.tracker_name like \'{p1}%\' GROUP BY campaign_trkrs.tracker_name)',
        ),
    ),
);

$dictionary['CampaignLog']['fields']['email_marketing_name'] = array(
    'name' => 'email_marketing_name',
    'vname' => 'LBL_KREPORTER_EMAIL_MARKETING_NAME',
    'type' => 'kreporter',
    'source' => 'non-db',
    'kreporttype' => 'varchar',
    'eval' => array(
        'presentation' => array(
            'eval' => 'SELECT email_marketing.name FROM email_marketing where email_marketing.id={t}.marketing_id',
        ),
        'selection' => array(
            'equals' => 'exists(SELECT email_marketing.name FROM email_marketing where email_marketing.id={t}.marketing_id and email_marketing.name=\'{p1}\')',
            'contains' => 'exists(SELECT email_marketing.name FROM email_marketing where email_marketing.id={t}.marketing_id and email_marketing.name like \'%{p1}%\' )',
            'starts' => 'exists(SELECT email_marketing.name FROM email_marketing where email_marketing.id={t}.marketing_id and email_marketing.name like \'{p1}%\' )',
        ),
    ),
);

$dictionary['CampaignLog']['fields']['recipient_name'] = array(
    'name' => 'recipient_name',
    'vname' => 'LBL_KREPORTER_RECIPIENT_NAME',
    'type' => 'kreporter',
    'source' => 'non-db',
    'kreporttype' => 'varchar',
    'eval' => array(
        'presentation' => array(
            'eval' => 'SELECT CONCAT_ws(\' \',contacts.first_name, contacts.last_name) from contacts where contacts.id={t}.target_id UNION SELECT accounts.name from accounts where accounts.id={t}.target_id union SELECT CONCAT_ws(\' \',leads.first_name, leads.last_name) from leads where leads.id={t}.target_id union SELECT CONCAT_ws(\' \',users.first_name, users.last_name) from users where users.id={t}.target_id'),
        'selection' => array(
            'equals' => 'exists(SELECT CONCAT_ws(\' \',contacts.first_name, contacts.last_name) from contacts where contacts.id={t}.target_id and
CONCAT_ws(\' \',contacts.first_name, contacts.last_name)=\'{p1}\' UNION SELECT accounts.name from accounts where accounts.id={t}.target_id and accounts.name=\'{p1}\' union SELECT CONCAT_ws(\' \',leads.first_name, leads.last_name) from leads where leads.id={t}.target_id and CONCAT_ws(\' \',leads.first_name, leads.last_name)=\'{p1}\' union SELECT CONCAT_ws(\' \',users.first_name, users.last_name) from users where users.id={t}.target_id and CONCAT_ws(\' \',users.first_name, users.last_name)=\'{p1}\')',
            'contains' => 'exists(SELECT CONCAT_ws(\' \',contacts.first_name, contacts.last_name) from contacts where contacts.id={t}.target_id and CONCAT_ws(\' \',contacts.first_name, contacts.last_name) like \'%{p1}%\' UNION SELECT accounts.name from accounts where accounts.id={t}.target_id and accounts.name like \'%{p1}%\' union SELECT CONCAT_ws(\' \',leads.first_name, leads.last_name) from leads where leads.id={t}.target_id and CONCAT_ws(\' \',leads.first_name, leads.last_name) like \'%{p1}%\' union SELECT CONCAT_ws(\' \',users.first_name, users.last_name) from users where users.id={t}.target_id and CONCAT_ws(\' \',users.first_name, users.last_name) like \'%{p1}%\')',
            'starts' => 'exists(SELECT CONCAT_ws(\' \',contacts.first_name, contacts.last_name) from contacts where contacts.id={t}.target_id  and CONCAT_ws(\' \',contacts.first_name, contacts.last_name) like \'{p1}%\' UNION SELECT accounts.name from accounts where accounts.id={t}.target_id and accounts.name like \'{p1}%\' union SELECT CONCAT_ws(\' \',leads.first_name, leads.last_name) from leads where leads.id={t}.target_id and CONCAT_ws(\' \',leads.first_name, leads.last_name) like \'{p1}%\' union SELECT CONCAT_ws(\' \',users.first_name, users.last_name) from users where users.id={t}.target_id and CONCAT_ws(\' \',users.first_name, users.last_name) like \'{p1}%\')'),
    ),
);
