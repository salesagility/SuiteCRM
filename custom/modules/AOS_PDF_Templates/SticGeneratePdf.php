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

/**
 * This code is used by the entrypoint sticGeneratePdf. It's inspired in the file modules/AOS_PDF_Templates/generatePdf.php
 * It receives a PDF template and a record ID, retrieves their beans, creates a PDF merging the record's data and sends 
 * it to the primary email address assigned to the record. If the record does not have a primary address, the user will be able
 * to input it manually in the Email Compose View.
 */

use SuiteCRM\PDF\Exceptions\PDFException;
use SuiteCRM\PDF\PDFWrapper;

if (!isset($_REQUEST['uid']) || empty($_REQUEST['uid']) || !isset($_REQUEST['templateID']) || empty($_REQUEST['templateID'])) {
    die('Error retrieving record. This record may be deleted or you may not be authorized to view it.');
}

require_once 'modules/AOS_PDF_Templates/templateParser.php';

global $mod_strings, $sugar_config, $timedate;

// Retrieving the record and template beans
$bean = BeanFactory::getBean($_REQUEST['module'], $_REQUEST['uid']);
if (!$bean) {
    sugar_die("Invalid Record");
}

$templateBean = BeanFactory::getBean('AOS_PDF_Templates', $_REQUEST['templateID']);
if (!$templateBean) {
    sugar_die("Invalid Template");
}

// Define the patterns used to clean the template HTML code
$search = array('/<script[^>]*?>.*?<\/script>/si', // Strip out javascript
    '/<[\/\!]*?[^<>]*?>/si', // Strip out HTML tags
    '/([\r\n])[\s]+/', // Strip out white space
    '/&(quot|#34);/i', // Replace HTML entities
    '/&(amp|#38);/i',
    '/&(lt|#60);/i',
    '/&(gt|#62);/i',
    '/&(nbsp|#160);/i',
    '/&(iexcl|#161);/i',
    '/<address[^>]*?>/si',
    '/&(apos|#0*39);/',
    '/&#(\d+);/',
);

$replace = array('',
    '',
    '\1',
    '"',
    '&',
    '<',
    '>',
    ' ',
    chr(161),
    '<br>',
    "'",
    'chr(%1)',
);

// Clean the template content
$header = preg_replace($search, $replace, $templateBean->pdfheader);
$footer = preg_replace($search, $replace, $templateBean->pdffooter);
$text = preg_replace($search, $replace, $templateBean->description);
$text = str_replace("<p><pagebreak /></p>", "<pagebreak />", $text);
$text = preg_replace_callback(
    '/\{DATE\s+(.*?)\}/',
    function ($matches) {
        return date($matches[1]);
    },
    $text
);

// The parse_template function requires an array of beans
$beanArray = array();
$beanArray[$bean->module_dir] = $bean->id;

// Parse the template using the record's data
$converted = templateParser::parse_template($text, $beanArray);
$header = templateParser::parse_template($header, $beanArray);
$footer = templateParser::parse_template($footer, $beanArray);

// Replace last break lines by html tags
$printable = str_replace("\n", "<br />", $converted);

// Create output filename
$fileName = str_replace(" ", "_", $bean->name)."_".date('YmdHis') . ".pdf";

// Create a temporary PDF file of the parsed template in the upload folder
try {
    $pdf = PDFWrapper::getPDFEngine();
    $pdf->configurePDF([
        'mode' => 'en',
        'page_size' => $templateBean->page_size,
        'font' => 'DejaVuSansCondensed',
        'margin_left' => $templateBean->margin_left,
        'margin_right' => $templateBean->margin_right,
        'margin_top' => $templateBean->margin_top,
        'margin_bottom' => $templateBean->margin_bottom,
        'margin_header' => $templateBean->margin_header,
        'margin_footer' => $templateBean->margin_footer,
        'orientation' => $templateBean->orientation,
    ]);

    $pdf->writeHeader($header);
    $pdf->writeFooter($footer);
    $pdf->writeHTML($printable);
    $pdf->outputPDF($fileName, "D");

} catch (PDFException $e) {
    LoggerManager::getLogger()->warn('PDFException: ' . $e->getMessage());
}

