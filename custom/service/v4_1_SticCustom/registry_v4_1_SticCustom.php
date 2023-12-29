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
require_once 'service/v4_1/registry.php';
class registry_v4_1_SticCustom extends registry_v4_1
{
    protected function registerFunction()
    {

        parent::registerFunction();
        $this->serviceClass->registerFunction(
            'set_image',
            array(
                'session' => 'xsd:string',
                'image_data' => 'tns:new_image_file'),
            array(
                'return' => 'xsd:boolean')
        );

        $this->serviceClass->registerFunction(
            'get_image',
            array(
                'session' => 'xsd:string',
                'image_data' => 'tns:image_file'),
            array(
                'return' => 'tns:image_data')
        );

        // Rebuid SinergiaDA views API function
        $this->serviceClass->registerFunction(
            'rebuild_sda',
            array(
                'session' => 'xsd:string',
            ),
            array(
                'return' => 'xsd:string')
        );
    }

    protected function registerTypes()
    {
        parent::registerTypes();

        $this->serviceClass->registerType(
            'new_image_file',
            'complexType',
            'struct',
            'all',
            '',
            array(
                "id" => array('name' => "id", 'type' => 'xsd:string'),
                "module" => array('name' => "id", 'type' => 'xsd:string'),
                "field" => array('name' => "id", 'type' => 'xsd:string'),
                "filename" => array('name' => "filename", 'type' => 'xsd:string'),
                "file" => array('name' => "file", 'type' => 'xsd:string'),
            )
        );

        $this->serviceClass->registerType(
            'image_file',
            'complexType',
            'struct',
            'all',
            '',
            array(
                "id" => array('name' => "id", 'type' => 'xsd:string'),
                "field" => array('name' => "id", 'type' => 'xsd:string'),
            )
        );

        $this->serviceClass->registerType(
            'image_data',
            'complexType',
            'struct',
            'all',
            '',
            array(
                "mime_type" => array('name' => "id", 'type' => 'xsd:string'),
                "data" => array('name' => "id", 'type' => 'xsd:string'),
            )
        );
    }
}
