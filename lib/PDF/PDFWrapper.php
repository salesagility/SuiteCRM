<?php
/**
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
 *
 * SuiteCRM is an extension to SugarCRM Community Edition developed by SalesAgility Ltd.
 * Copyright (C) 2011 - 2021 SalesAgility Ltd.
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

namespace SuiteCRM\PDF;

use SuiteCRM\PDF\Exceptions\PDFEngineNotFoundException;
use SuiteCRM\PDF\MPDF\MPDFEngine;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

/**
 * Class PDFWrapper
 * @package SuiteCRM\PDF
 */
class PDFWrapper
{
    /**
     * @var array stores an associative array matching the PDF engine class name with the file it is stored in.
     */
    private static $engines = [
        'MPDFEngine' => [
            'name' => 'MPDFEngine',
            'FQN' => MPDFEngine::class,
            'filepath' => 'lib/PDF/MPDF/MPDFEngine.php'
        ],
    ];

    /** @var string Path to the folder where to load custom engines from */
    private static $customEnginePath = __DIR__ . '/../../custom/Extension/PDFEngines/';

    /**
     * @param string $engineName
     * @param string $file
     * @param string $fqn
     */
    public static function addEngine(string $engineName, string $file, string $fqn): void
    {
        self::$engines[$engineName] = [
            'name' => $engineName,
            'FQN' => $fqn,
            'filepath' => $file,
        ];
    }

    /**
     * @return PDFEngine
     */
    public static function getPDFEngine(): PDFEngine
    {
        $defaultEngine = self::getDefaultEngine();

        return self::fetchEngine($defaultEngine);
    }

    /**
     * Retrieves the available PDF engine class names.
     *
     * @return string[]
     */
    public static function getEngines(): array
    {
        $default = array_keys(self::$engines);
        $custom = [];
        foreach (glob(self::$customEnginePath . '*.php', GLOB_NOSORT) as $file) {
            $file = pathinfo($file);
            $custom[] = $file['filename'];
        }

        return array_merge($default, $custom);
    }

    /**
     * @return string
     */
    public static function getDefaultEngine(): string
    {
        $config = self::getPDFConfig('defaultEngine');

        return $config ?? key(self::$engines);
    }

    /**
     * @param string|PDFEngine $engineName
     * @return PDFEngine
     * @throws PDFEngineNotFoundException
     */
    private static function fetchEngine($engineName): PDFEngine
    {
        if (is_subclass_of($engineName, PDFEngine::class, false)) {
            return $engineName;
        }

        $customEnginePath = self::$customEnginePath . $engineName . '.php';

        if (isset(self::$engines[$engineName])) {
            $engine = self::$engines[$engineName];
        } elseif (isset($customEnginePath)) {
            self::addEngine($engineName, $customEnginePath, $engineName);
            $engine = self::$engines[$engineName];
        } else {
            throw new PDFEngineNotFoundException(
                "PDF engine not found for engine '$engineName''."
            );
        }

        $filename = $engine['filepath'];

        if (!is_file($filename)) {
            throw new PDFEngineNotFoundException(
                "Unable to find PDF file '$filename'' for engine '$engineName''."
            );
        }

        /** @noinspection PhpIncludeInspection */
        require_once $filename;

        if (!is_subclass_of($engine['FQN'], PDFEngine::class)) {
            throw new PDFEngineNotFoundException(
                "The provided class '$engineName' is not a subclass of PDFEngine"
            );
        }

        /** @var PDFEngine */
        return new $engine['FQN']();
    }

    /**
     * @param $key
     * @return mixed|null
     */
    private static function getPDFConfig($key)
    {
        global $sugar_config;

        return $sugar_config['pdf'][$key] ?? null;
    }

    /**
     * @return string|null
     */
    public static function getController(): ?string
    {
        return self::getPDFConfig('controller');
    }
}
