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

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

include_once('include/database/MssqlManager.php');

/**
 * SQL Server driver for FreeTDS
 */
class FreeTDSManager extends MssqlManager
{
    public $dbName = 'FreeTDS SQL Server';
    public $variant = 'freetds';
    public $label = 'LBL_MSSQL2';

    protected $capabilities = array(
        "affected_rows" => true,
        'fulltext' => true,
        'limit_subquery' => true,
    );

    protected $type_map = array(
            'int'      => 'int',
            'double'   => 'float',
            'float'    => 'float',
            'uint'     => 'int',
            'ulong'    => 'int',
            'long'     => 'bigint',
            'short'    => 'smallint',
            'varchar'  => 'nvarchar',
            'text'     => 'nvarchar(max)',
            'longtext' => 'nvarchar(max)',
            'date'     => 'datetime',
            'enum'     => 'nvarchar',
            'relate'   => 'nvarchar',
            'multienum'=> 'nvarchar(max)',
            'html'     => 'nvarchar(max)',
            'longhtml' => 'text',
        'emailbody' => 'nvarchar(max)',
            'datetime' => 'datetime',
            'datetimecombo' => 'datetime',
            'time'     => 'datetime',
            'bool'     => 'bit',
            'tinyint'  => 'tinyint',
            'char'     => 'char',
            'blob'     => 'nvarchar(max)',
            'longblob' => 'nvarchar(max)',
            'currency' => 'decimal(26,6)',
            'decimal'  => 'decimal',
            'decimal2' => 'decimal',
            'id'       => 'varchar(36)',
            'url'      => 'nvarchar',
            'encrypt'  => 'nvarchar',
            'file'     => 'nvarchar',
            'decimal_tpl' => 'decimal(%d, %d)',
    );

    public function query($sql, $dieOnError = false, $msg = '', $suppress = false, $keepResult = false)
    {
        global $app_strings;
        if (is_array($sql)) {
            return $this->queryArray($sql, $dieOnError, $msg, $suppress);
        }

        $sql = $this->_appendN($sql);
        return parent::query($sql, $dieOnError, $msg, $suppress, $keepResult);
    }

    /**
     * Check if this driver can be used
     * @return bool
     */
    public function valid()
    {
        return function_exists("mssql_connect") && DBManagerFactory::isFreeTDS();
    }
}
