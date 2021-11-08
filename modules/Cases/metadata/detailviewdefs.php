<?php
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

$viewdefs ['Cases'] =
array(
  'DetailView' =>
  array(
    'templateMeta' =>
    array(
      'form' =>
      array(
        'buttons' =>
        array(
          0 => 'EDIT',
          1 => 'DUPLICATE',
          2 => 'DELETE',
          3 => 'FIND_DUPLICATES',
        ),
      ),
      'maxColumns' => '2',
      'widths' =>
      array(
        0 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array(
          'label' => '10',
          'field' => '30',
        ),
      ),
      'useTabs' => true,
      'tabDefs' =>
      array(
        'LBL_CASE_INFORMATION' =>
        array(
          'newTab' => true,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
      'topWidget' => [
          'type' => 'statistics',
          'options' => [
              'statistics' => [
                  [
                      'labelKey' => '',
                      'type' => 'case-days-open',
                      'endLabelKey' => 'LBL_STAT_DAYS'
                  ],
              ],
          ]
      ],
      'sidebarWidgets' => [
          [
              'type' => 'record-thread',
              'labelKey' => 'LBL_CASE_UPDATES',
              'options' => [
                  'recordThread' => [
                      'module' => 'case-updates',
                      'class' => 'case-updates',
                      'filters' => [
                          'parentFilters' => [
                              'id' => 'case_id'
                          ],
                          'orderBy' => 'date_entered',
                          'sortOrder' => 'DESC'
                      ],
                      'item' => [
                          'itemClass' => 'case-updates-item pt-2 pb-2',
                          'collapsible' => true,
                          'dynamicClass' => ['source', 'internal'],
                          'layout' => [
                              'header' => ['rows' => []],
                              'body' =>[
                                  'rows' => [
                                      [
                                          'align' => 'end',
                                          'justify' => 'between',
                                          'cols' => [
                                              [
                                                  'field' => 'author',
                                                  'labelDisplay' => 'none',
                                                  'hideIfEmpty' => true,
                                                  'class' => 'font-weight-bold item-title'
                                              ],
                                              [
                                                  'field' => 'internal',
                                                  'labelDisplay' => 'inline',
                                                  'labelClass' => 'm-0',
                                                  'display' => 'none',
                                                  'hideIfEmpty' => true,
                                                  'class' => 'small ml-auto font-weight-light'
                                              ],
                                          ]
                                      ],
                                      [
                                          'align' => 'start',
                                          'justify' => 'start',
                                          'class' => 'flex-grow-1 item-content',
                                          'cols' => [
                                              [
                                                  'field' => [
                                                      'name' => 'description',
                                                      'type' => 'html',
                                                  ],
                                                  'labelDisplay' => 'none',
                                              ]
                                          ]
                                      ],
                                      [
                                          'justify' => 'end',
                                          'class' => 'flex-grow-1',
                                          'cols' => [
                                              [
                                                  'field' => 'date_entered',
                                                  'labelDisplay' => 'none',
                                                  'hideIfEmpty' => true,
                                                  'class' => 'small ml-auto font-weight-light'
                                              ],
                                          ]
                                      ]
                                  ]
                              ]
                          ],
                      ],
                      'create' => [
                          'presetFields' => [
                              'parentValues' => [
                                  'id' => 'case_id'
                              ],
                          ],
                          'layout' => [
                              'header' => ['rows' => []],
                              'body' =>[
                                  'rows' => [
                                      [
                                          'justify' => 'start',
                                          'class' => 'flex-grow-1',
                                          'cols' => [
                                              [
                                                  'field' => [
                                                      'name' => 'description',
                                                      'metadata' => [
                                                          'rows' => 3
                                                      ]
                                                  ],
                                                  'labelDisplay' => 'top',
                                                  'class' => 'flex-grow-1',
                                              ]
                                          ]
                                      ],
                                      [
                                          'align' => 'end',
                                          'justify' => 'start',
                                          'class' => 'flex-grow-1',
                                          'cols' => [
                                              [
                                                  'field' => 'internal',
                                                  'labelDisplay' => 'inline',
                                              ],
                                          ]
                                      ]
                                  ]
                              ]
                          ],
                      ]
                  ]
              ],
              'acls' => [
                  'Cases' => ['view', 'list']
              ]
          ],
          [
              'type' => 'statistics',
              'labelKey' => 'LBL_NUMBER_OF_CASES_PER_ACCOUNT',
              'options' => [
                  'sidebarStatistic' => [
                      'rows' => [
                          [
                              'align' => 'start',
                              'cols' => [
                                  [
                                      'labelKey' => 'LBL_TOTAL_CASES_FOR_THIS_ACCOUNT',
                                      'size' => 'medium',
                                  ],
                              ]
                          ],
                          [
                              'align' => 'start',
                              'cols' => [
                                  [
                                      'statistic' => 'cases-per-account',
                                      'size' => 'xx-large',
                                      'bold' => true,
                                      'color' => 'green'
                                  ]
                              ]
                          ],
                          [
                              'align' => 'start',
                              'cols' => [
                                  [
                                      'labelKey' => 'LBL_SINCE',
                                      'size' => 'regular',
                                  ],
                                  [
                                      'statistic' => 'get-account-date-entered',
                                      'size' => 'regular',
                                  ],
                              ]
                          ],
                      ]
                  ]
              ],
              'acls' => [
                  'Cases' => ['view', 'list'],
                  'Accounts' => ['view', 'list']
              ]
          ],
      ],
    'panels' =>
    array(
      'lbl_case_information' =>
      array(
        0 =>
        array(
          0 =>
          array(
            'name' => 'case_number',
            'label' => 'LBL_CASE_NUMBER',
          ),
          1 => 'priority',
        ),
        1 =>
        array(
          0 =>
          array(
            'name' => 'state',
            'comment' => 'The state of the case (i.e. open/closed)',
            'label' => 'LBL_STATE',
          ),
          1 => 'status',
        ),
        2 =>
        array(
          0 => 'type',
          1 => 'account_name',
        ),
        3 =>
        array(
          0 =>
          array(
            'name' => 'name',
            'label' => 'LBL_SUBJECT',
          ),
        ),
        4 =>
        array(
          0 => 'description',
        ),
        5 =>
        array(
          0 => 'resolution',
        ),
        6 =>
        array(
          0 =>
          array(
            'name' => 'assigned_user_name',
            'label' => 'LBL_ASSIGNED_TO',
          ),
        ),
        7 =>
        array(
          0 =>
          array(
            'name' => 'date_entered',
            'customCode' => '{$fields.date_entered.value} {$APP.LBL_BY} {$fields.created_by_name.value}',
          ),
          1 =>
          array(
            'name' => 'date_modified',
            'label' => 'LBL_DATE_MODIFIED',
            'customCode' => '{$fields.date_modified.value} {$APP.LBL_BY} {$fields.modified_by_name.value}',
          ),
        ),
      ),
    ),
  ),
);
