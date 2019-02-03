<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
global $app_strings;

$dashletMeta['AORReportsDashlet'] = array('module'		=> 'AOR_Reports',
										  'title'       => translate('LBL_AOR_REPORTS_DASHLET', 'AOR_Reports'),
                                          'description' => 'Displays Reports',
                                          'category'    => 'Module Views');
