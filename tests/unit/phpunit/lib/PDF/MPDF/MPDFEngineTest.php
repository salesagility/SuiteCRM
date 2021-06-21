<?php
/**
 *
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

namespace SuiteCRM\Tests\Unit\lib\PDF\MPDF;

if (!defined('sugarEntry') || !sugarEntry) {
    die('Not A Valid Entry Point');
}

use mPDF;
use SugarThemeRegistry;
use SuiteCRM\PDF\Exceptions\PDFException;
use SuiteCRM\PDF\MPDF\MPDFEngine;
use SuiteCRM\PDF\PDFEngine;
use SuiteCRM\PDF\PDFWrapper;
use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

/**
 * Class PDFWrapperTest
 * @covers MPDFEngine
 */
class MPDFEngineTest extends SuitePHPUnitFrameworkTestCase
{
    /**
     * @var MPDFEngine
     */
    private $pdf;

    public function setUp(): void
    {
        parent::setUp();

        @$this->pdf = PDFWrapper::getPDFEngine();
    }

    public function testWriteFooter(): void
    {
        $this->pdf->writeFooter('{TEST_FOOTER}');
        $footerDetails = $this->pdf->pdf->footerDetails;
        $expected = '{TEST_FOOTER}';

        self::assertIsArray($footerDetails);

        $odd = $footerDetails['odd']['R']['content'];
        $even = $footerDetails['even']['L']['content'];

        self::assertEquals($expected, $odd);
        self::assertEquals($expected, $even);
    }

    public function testWriteHeader(): void
    {
        $this->pdf->writeHeader('{TEST_HEADER}');
        $headerDetails = $this->pdf->pdf->headerDetails;
        $expected = '{TEST_HEADER}';

        self::assertIsArray($headerDetails);

        $odd = $headerDetails['odd']['R']['content'];
        $even = $headerDetails['even']['L']['content'];

        self::assertEquals($expected, $odd);
        self::assertEquals($expected, $even);
    }

    public function testConfigurePDF(): void
    {
        $this->pdf->configurePDF([
            'font' => 'DejaVuSansCondensed',
        ]);
        $actual = $this->pdf->pdf->original_default_font;

        self::assertEquals('dejavusanscondensed', $actual);
    }

    public function testWriteHTML(): void
    {
        $stylesheet = file_get_contents(SugarThemeRegistry::current()->getCSSURL(
            'style.css', false
        ));
        $this->pdf->configurePDF([
            'mode' => 'en',
            'font' => 'DejaVuSansCondensed',
        ]);
        $this->pdf->writeHTML($stylesheet, 1);
        $defaultCSS = $this->pdf->pdf->defaultCSS;

        $actual = $defaultCSS['BODY']['BACKGROUND-COLOR'];

        self::assertEquals('#FFFFFF', $actual);
    }

    public function test__construct(): void
    {
        $engine = new MPDFEngine();
        $mpdfEngine = $engine->pdf;

        self::assertInstanceOf(PDFEngine::class, $engine);
        self::assertInstanceOf(mPDF::class, $mpdfEngine);
    }

    public function testOutputPDF(): void
    {
        $stylesheet = file_get_contents(SugarThemeRegistry::current()->getCSSURL(
            'style.css', false)
        );

        try {
            $this->pdf = PDFWrapper::getPDFEngine();
            $this->pdf->configurePDF([
                'mode' => 'en',
                'font' => 'DejaVuSansCondensed',
            ]);
            $this->pdf->writeHTML($stylesheet, 1);
            @$actual = $this->pdf->outputPDF('TEST_PDF.pdf', 'S');
        } catch (PDFException $e) {
            self::fail($e->getMessage() . "\nTrace:\n" . $e->getTraceAsString());
        }

        self::assertIsString($actual);
    }
}
