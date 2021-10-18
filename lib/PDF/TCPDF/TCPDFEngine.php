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

namespace SuiteCRM\PDF\TCPDF;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use SuiteCRM\PDF\PDFEngine;
use TCPDF;

/**
 * Class TFPDFEngine
 * @package SuiteCRM\PDF\TCPDF
 */
class TCPDFEngine extends PDFEngine
{
    /**
     * @var TCPDF
     */
    public $pdf;

    /**
     * @var array
     */
    public $pdfOptions;

    /**
     * @var string
     */
    private static $configMapperFile = __DIR__ . '/../../../lib/PDF/MPDF/configMapping.php';

    /**
     * @var int
     */
    private $maxExecutionTime;

    /**
     * TFPDFEngine constructor.
     * @param TCPDF|null $pdf
     */
    public function __construct(TCPDF $pdf = null)
    {
        $this->pdf = $pdf ?? new TCPDF();
        $this->maxExecutionTime = ini_get('max_execution_time');
        set_time_limit(0);
    }

    /**
     * @param string $html
     * @return void
     */
    public function writeHTML(string $html): void
    {
        $this->pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    }

    /**
     * @param string $name
     * @param string $destination
     * @param string $fullName
     * @return string|null
     */
    public function outputPDF(string $name, string $destination, string $fullName = ''): ?string
    {
        $this->pdf->Output(__DIR__ . '/../../../' . $name, $destination);

        set_time_limit($this->maxExecutionTime);

        return null;
    }

    /**
     * @param string|array $html
     * @return void
     */
    public function writeHeader(string $html): void
    {
        $this->pdf->setHeaderData($html);
    }

    /**
     * @param string|array $html
     * @return void
     */
    public function writeFooter(string $html): void
    {
        $this->pdf->setFooterData($html);
    }

    public function writeBlankPage(): void
    {
        $this->pdf->AddPage();
    }

    /**
     * @param array $options
     * @return void
     */
    public function configurePDF(array $options): void
    {
        /** @noinspection PhpIncludeInspection */
        $configOptions = include self::$configMapperFile;
        $this->pdfOptions = $configOptions;

        $this->pdf = new TCPDF(
            $configOptions['orientation'],
            $configOptions['unit'],
            $configOptions['page_size'],
            true,
            'UTF-8',
            false
        );

        $this->pdf->setHeaderMargin($configOptions['mgh']);
        $this->pdf->setFooterMargin($configOptions['mgf']);
        $this->pdf->SetAutoPageBreak(true, $configOptions['mgb']);

        $this->writeBlankPage();
    }
}
