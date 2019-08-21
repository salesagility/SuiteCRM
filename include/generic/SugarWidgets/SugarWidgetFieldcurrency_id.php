<?php
if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}
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


class SugarWidgetFieldcurrency_id extends SugarWidgetFieldEnum
{
    /**
     * Returns list of beans of currencies including default system currency
     *
     * @param bool $refresh cache
     * @return array list of beans
     */
    public static function getCurrenciesList($refresh = false)
    {
        static $list = false;
        if ($list === false || $refresh == true) {
            $currency = BeanFactory::newBean('Currencies');
            $list = $currency->get_full_list('name');
            $currency->retrieve('-99');
            if (is_array($list)) {
                $list = array_merge(array($currency), $list);
            } else {
                $list = array($currency);
            }
        }
        return $list;
    }

    /**
     * Overriding display of value of currency because of currencies are not stored in app_list_strings
     *
     * @param array $layout_def
     * @return string for display
     */
    public function &displayListPlain($layout_def)
    {
        static $currencies;
        $value = $this->_get_list_value($layout_def);
        if (empty($currencies[$value])) {
            $currency = BeanFactory::newBean('Currencies');
            $currency->retrieve($value);
            $currencies[$value] = $currency->symbol . ' ' . $currency->iso4217;
        }
        return $currencies[$value];
    }

    /**
     * Overriding sorting because of default currency is not present in DB
     *
     * @param array $layout_def
     * @return string for order by
     */
    public function queryOrderBy($layout_def)
    {
        $tmpList = self::getCurrenciesList();
        $list = array();
        foreach ($tmpList as $bean) {
            $list[$bean->id] = $bean->symbol . ' ' . $bean->iso4217;
        }

        $field_def = $this->reporter->all_fields[$layout_def['column_key']];
        if (!empty($field_def['sort_on'])) {
            $order_by = $layout_def['table_alias'].".".$field_def['sort_on'];
        } else {
            $order_by = $this->_get_column_select($layout_def);
        }

        if (empty($layout_def['sort_dir']) || $layout_def['sort_dir'] == 'a') {
            $order_dir = "ASC";
        } else {
            $order_dir = "DESC";
        }
        return $this->reporter->db->orderByEnum($order_by, $list, $order_dir);
    }
}
