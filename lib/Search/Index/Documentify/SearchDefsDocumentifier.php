<?php
/**
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

/**
 * Created by PhpStorm.
 * User: viocolano
 * Date: 05/07/18
 * Time: 11:36
 */

namespace SuiteCRM\Search\Index\Documentify;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use ParserSearchFields;

require_once 'modules/ModuleBuilder/parsers/parser.searchfields.php';

/**
 * This class converts a SugarBean into a document using the customisable Search Defs framework.
 *
 * @see ParserSearchFields
 */
class SearchDefsDocumentifier extends AbstractDocumentifier
{
    /** @var array a cache with fields definition */
    protected $fields = [];

    /** @inheritdoc */
    public function documentify(\SugarBean $bean, ParserSearchFields $parser = null)
    {
        $module_name = $bean->module_name;

        if (empty($this->fields[$module_name])) {
            $this->fields[$module_name] = $this->getFieldsToIndex($module_name, $parser);
        }

        // Making a friendly reference to the mapping
        $fields = &$this->fields[$module_name];

        $body = [];

        foreach ($fields as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subvalue) {
                    if (property_exists($bean, $subvalue) && !empty($bean->$subvalue)) {
                        $body[$key][$subvalue] = $this->cleanValue($bean->$subvalue);
                    }
                }
                continue;
            }

            if (property_exists($bean, $value) && !empty($bean->$value)) {
                $body[$value] = $this->cleanValue($bean->$value);
            }
        }

        // TODO fix addresses and phone nesting
        // Maybe create mappings from a field to a target path in the final document?

        if (isset($body['name'])) {
            $name = $body['name'];
            $body['name'] = ['name' => $name];
        }

        return $body;
    }

    /**
     * Parses the Search Defs files and creates a map of fields to index for a given module.
     *
     * The mapping is cached in the class property `$fields`.
     *
     * @param $module string
     * @param ParserSearchFields|null $parser
     * @return string[]
     */
    protected function getFieldsToIndex($module, ParserSearchFields $parser = null)
    {
        if (empty($parser)) {
            $parser = new ParserSearchFields($module);
        }

        $fields = $parser->getSearchFields()[$module];

        $parsedFields = [];

        foreach ($fields as $key => $field) {
            if (isset($field['query_type']) && $field['query_type'] != 'default') {
                // echo "[$module]->$key is not a supported query type!", PHP_EOL;
                continue;
            };

            if (!empty($field['operator'])) {
                // echo "[$module]->$key has an operator!", PHP_EOL;
                continue;
            }

            if (strpos($key, 'range_date') !== false) {
                continue;
            }

            if (empty($field['db_field'])) {
                $parsedFields[] = $key;
                continue;
            }

            foreach ($field['db_field'] as $db_field) {
                $parsedFields[$key][] = $db_field;
            }
        }

        return $parsedFields;
    }

    /**
     * Converts a string to the proper document-friendly encoding and format.
     *
     * Most notably, converts HTML entities to UTF-8 characters.
     *
     * @param $string string
     * @return null|string|string[]
     */
    protected function cleanValue($string)
    {
        return mb_convert_encoding($string, 'UTF-8', 'HTML-ENTITIES');
    }
}