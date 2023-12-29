<?php
/**
 * This file is part of KReporter. KReporter is an enhancement developed
 * by Christian Knoll. All rights are (c) 2012 by Christian Knoll
 *
 * This file has been modified by SinergiaTIC in SinergiaCRM.
 * SinergiaCRM is a work developed by SinergiaTIC Association, based on SuiteCRM.
 * Copyright (C) 2013 - 2023 SinergiaTIC Association
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * You can contact Christian Knoll at info@kreporter.org
 * You can contact SinergiaTIC Association at email address info@sinergiacrm.org.
 */

$kreporterWhereOperatorCount = array(
    'ignore' => 0,
    'equals' => 1,
    'notequal' => 1,
    'before' => 1,
    'after' => 1,
    'between' => 2,
    'today' => 0,
    'past' => 0,
    'future' => 0,
    'firstdayofmonth' => 0,
    'nthdayofmonth' => 1,
    'thismonth' => 0,
    'notthismonth' => 0,
    'thisweek' => 0,
    'nextnmonth' => 1,
    'next3month' => 0,
    'next3monthDaily' => 0, 
    'next6month' => 0, 
    'next6monthDaily' => 0, 
    'last3monthDaily' => 0, 
    'last6month' => 0, 
    'last6monthDaily' => 0,
    'lastmonth' => 0,
    'last3month' => 0,
    // STIC-Custom 20211104 AAM - Adding operators "after/before N days"  functionality
    // STIC#458
    'beforendays' => 1,
    'lastndays' => 1,
    'lastnfdays' => 1,
    'lastnddays' => 1,
    'lastnweeks' => 1,
    'notlastnweeks' => 1,
    'lastnfweeks' => 1,
    // STIC-Custom 20211104 AAM - Adding operators "after/before N days"  functionality
    // STIC#458
    'afterndays' => 1,
    'nextndays' => 1,
    'nextnddays' => 1,
    'betwndays' => 2,
    'betwnddays' => 2,
    'nextnweeks' => 1,
    'notnextnweeks' => 1,
    'thisyear' => 0,
    'lastyear' => 0,
    'tyytd' => 0,
    'lyytd' => 0,
    'isempty' => 0,
    'isemptyornull' => 0,
    'isnull' => 0,
    'isnotempty' => 0,
    'oneof' => 1,
    'oneofnot' => 1,
    'oneofnotornull' => 1,
    'starts' => 1,
    'notstarts' => 1,
    'contains' => 1,
    'notcontains' => 1,
    'greater' => 1,
    'greaterequal' => 1,
    'less' => 1,
    'lessequal' => 1,
    'autocomplete' => 1,
    'soundslike' => 1
);

$kreporterWhereOperatorTypes = array(
    'varchar' => array(
        'equals',
        'soundslike',
        'notequal',
        'greater',
        'greaterequal',
        'less',
        'lessequal',
        'starts',
        'notstarts',
        'contains',
        'notcontains',
        'between',
        'isempty',
        'isemptyornull',
        'isnull',
        'isnotempty'
    ),
    'enum' => array(
        'equals',
        'notequal',
        'oneof',
        'oneofnot',
        'oneofnotornull',
        'starts',
        'notstarts',
        'contains',
        'notcontains',
        'isempty',
        'isemptyornull',
        'isnull',
        'isnotempty'
    ),
    'id' => array(
        'equals',
        'autocomplete',
        'isempty',
        'isemptyornull',
        'isnull',
        'isnotempty'
    ),
    'double' => array(
        'equals',
        'notequal',
        'greater',
        'greaterequal',
        'less',
        'lessequal',
        'between',
        'isempty',
        'isemptyornull',
        'isnull',
        'isnotempty'
    ),
    'date' => array(
        'equals',
        'notequal',
        'before',
        // 'lessequal',
        'after',
        // 'greaterequal',
        'past',
        'future',
        'between',
        'today',
        // STIC-Custom 20211104 AAM - Adding operators "after/before N days"  functionality
        // STIC#458
        'beforendays',
        'lastndays',
        'lastnfdays',
        'lastnddays',
        // STIC-Custom 20211104 AAM - Adding operators "after/before N days"  functionality
        // STIC#458
        'afterndays',
        'nextndays',
        'nextnddays',
        'betwndays',
        'betwnddays',
        'thisweek',
        'lastnweeks',
        'notlastnweeks',
        'lastnfweeks',
        'nextnweeks',
        'notnextnweeks',
        'firstdayofmonth',
        // 'nthdayofmonth',
        'thismonth',
        'lastmonth',
        'last3month',
        'notthismonth',
    	'nextnmonth',
        'next3month',
        'next3monthDaily', 
        'next6month', 
        'next6monthDaily', 
        'last3monthDaily', 
        'last6month', 
        'last6monthDaily',
        'thisyear',
        'lastyear',
        'tyytd',
        'lyytd',
        'isempty',
        'isemptyornull',
        'isnull',
        'isnotempty'
    ),
    'bool' => array(
        'equals',
        'notequal',
        'isemptyornull',
        'isnull'
    )
);

$kreporterWhereOperatorAssignments = array(
    'id' => 'id',
    'varchar' => 'varchar',
    // 2013-08-26 add phone field ... BUG#495
    'phone' => 'varchar',
    'name' => 'varchar',
    'relate' => 'varchar',
    'text' => 'varchar',
    'char' => 'varchar',
    'double' => 'double',
    'int' => 'double',
    'float' => 'double',
     //2013-04-06 type decimal
    'decimal' => 'double',
    'currency' => 'double',
    'bool' => 'bool',
    'enum' => 'enum',
    'multienum' => 'enum',
    'radioenum' => 'enum',
    'dynamicenum' => 'enum',
    'parent_type' => 'enum',
    'user_name' => 'enum',
    'assigned_user_name' => 'enum',
    'team_name' => 'enum',
    'date' => 'date',
    'datetime' => 'date',
    'datetimecombo' => 'date', 
    //2013-08-07 added fixed field
    'fixed' => 'varchar'
);

if (file_exists('custom/modules/KReports/config/KReportWhereOperators.php'))
    include('custom/modules/KReports/config/KReportWhereOperators.php');
?>
