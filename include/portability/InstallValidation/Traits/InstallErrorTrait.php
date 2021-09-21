<?php

/**
 * SuiteCRM is a customer relationship management program developed by SalesAgility Ltd.
 * Copyright (C) 2021 SalesAgility Ltd.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU Affero General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SALESAGILITY, SALESAGILITY DISCLAIMS THE
 * WARRANTY OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see http://www.gnu.org/licenses.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License
 * version 3, these Appropriate Legal Notices must retain the display of the
 * "Supercharged by SuiteCRM" logo. If the display of the logos is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display
 * the words "Supercharged by SuiteCRM".
 */

trait InstallErrorTrait
{
    /**
     * @var array $messages
     */
    protected $messages = [
        'phpVersion' => [
            'label' => 'LBL_CHECKSYS_PHPVER',
            'error' => 'ERR_CHECKSYS_PCRE_VER'
        ],
        'PCREVersion' => [
            'label' => 'LBL_CHECKSYS_PCRE',
            'error' => 'ERR_CHECKSYS_PHP_INVALID_VER'
        ],
        'iisVersion' => [
            'label' => 'LBL_CHECKSYS_IISVER',
            'error' => 'ERR_CHECKSYS_IIS_INVALID_VER'
        ],
        'fastCgi' => [
            'label' => 'LBL_CHECKSYS_FASTCGI',
            'error' => 'ERR_CHECKSYS_FASTCGI'
        ],
        'fastCgiLogging' => [
            'label' => 'LBL_CHECKSYS_FASTCGI',
            'error' => 'ERR_CHECKSYS_FASTCGI_LOGGING'
        ],
        'xml_parser_create' =>
            [
                'label' => 'LBL_CHECKSYS_XML',
                'error' => 'LBL_CHECKSYS_XML_NOT_AVAILABLE'
            ],
        'json_decode' =>
            [
                'label' => 'LBL_CHECKSYS_JSON',
                'error' => 'ERR_CHECKSYS_JSON_NOT_AVAILABLE'
            ],
        'mb_strlen' =>
            [
                'label' => 'LBL_CHECKSYS_MBSTRING',
                'error' => 'ERR_CHECKSYS_MBSTRING'
            ],
        'ZipArchive' =>
            [
                'label' => 'LBL_CHECKSYS_ZIP',
                'error' => 'ERR_CHECKSYS_ZIP'
            ],
        'IsWritableConfig' =>
            [
                'label' => 'LBL_CHECKSYS_CONFIG',
                'error' => 'ERR_CHECKSYS_CONFIG_NOT_WRITABLE'
            ],
        'IsWritableConfigO' =>
            [
                'label' => 'LBL_CHECKSYS_OVERRIDE_CONFIG',
                'error' => 'ERR_CHECKSYS_CONFIG_OVERRIDE_NOT_WRITABLE'
            ],
        'IsWritableCustomDir' =>
            [
                'label' => 'LBL_CHECKSYS_CUSTOM',
                'error' => 'ERR_CHECKSYS_CUSTOM_NOT_WRITABLE'
            ],
        'IsWritableCacheDir' =>
            [
                'label' => 'LBL_CHECKSYS_CACHE',
                'error' => 'LBL_CHECKSYS_FIX_FILES'
            ],
        'IsWritableModDir' =>
            [
                'label' => 'LBL_CHECKSYS_MODULE',
                'error' => 'LBL_CHECKSYS_FIX_MODULE_FILES'
            ],
        'IsWritableUploadDir' =>
            [
                'label' => 'LBL_CHECKSYS_ZLIB',
                'error' => 'ERR_CHECKSYS_ZLIB'
            ],
        'gzclose' =>
            [
                'label' => 'LBL_CHECKSYS_UPLOAD',
                'error' => 'LBL_CHECKSYS_FIX_FILES'
            ],
        'curl_init' =>
            [
                'label' => 'LBL_CHECKSYS_CURL',
                'error' => 'ERR_CHECKSYS_CURL'
            ],
        'upload_limit' =>
            [
                'label' => 'LBL_UPLOAD_MAX_FILESIZE_TITLE',
                'error' => 'ERR_UPLOAD_MAX_FILESIZE'
            ],
        'imagecreatetruecolor' =>
            [
                'label' => 'LBL_SPRITE_SUPPORT',
                'error' => 'ERROR_SPRITE_SUPPORT'
            ],
        'phpIniLocation' =>
            [
                'label' => 'LBL_CHECKSYS_PHP_INI',
                'error' => ''
            ],
        'imap' =>
            [
                'label' => 'LBL_CHECKSYS_IMAP',
                'error' => 'ERR_CHECKSYS_IMAP'
            ],
        'memory_limit' =>
            [
                'label' => 'LBL_CHECKSYS_MEM',
                'error' => ''
            ]
    ];

}
