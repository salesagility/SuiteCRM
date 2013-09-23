<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * SugarCRM Community Edition is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004-2013 SugarCRM Inc.
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
 * FOR A PARTICULAR PURPOSE.  See the GNU Affero General Public License for more
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
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 ********************************************************************************/


require_once('include/Sugarpdf/sugarpdf_config.php');

$SugarpdfSettings = array(
    "sugarpdf_pdf_title"=>array(
        "label"=>$mod_strings["PDF_TITLE"],
        "info_label"=>$mod_strings["PDF_TITLE_INFO"],
        "value"=>PDF_TITLE,
        "class"=>"basic",
        "type"=>"text",
    ),
    "sugarpdf_pdf_subject"=>array(
        "label"=>$mod_strings["PDF_SUBJECT"],
        "info_label"=>$mod_strings["PDF_SUBJECT_INFO"],
        "value"=>PDF_SUBJECT,
        "class"=>"basic",
        "type"=>"text",
    ),
/*    "sugarpdf_pdf_creator"=>array(
        "label"=>$mod_strings["PDF_CREATOR"],
        "info_label"=>$mod_strings["PDF_CREATOR_INFO"],
        "value"=>PDF_CREATOR,
        "class"=>"basic",
        "type"=>"text",
        "required"=>"true"
    ),*/
    "sugarpdf_pdf_author"=>array(
        "label"=>$mod_strings["PDF_AUTHOR"],
        "info_label"=>$mod_strings["PDF_AUTHOR_INFO"],
        "value"=>PDF_AUTHOR,
        "class"=>"basic",
        "type"=>"text",
        "required"=>"true"
    ),
    "sugarpdf_pdf_keywords"=>array(
        "label"=>$mod_strings["PDF_KEYWORDS"],
        "info_label"=>$mod_strings["PDF_KEYWORDS_INFO"],
        "value"=>PDF_KEYWORDS,
        "class"=>"basic",
        "type"=>"text"
    ),
    /*
    "sugarpdf_pdf_header_title"=>array(
        "label"=>$mod_strings["PDF_HEADER_TITLE"],
        "info_label"=>$mod_strings["PDF_HEADER_TITLE_INFO"],
        "value"=>PDF_HEADER_TITLE,
        "class"=>"basic",
        "type"=>"text",
    ),
    "sugarpdf_pdf_header_string"=>array(
        "label"=>$mod_strings["PDF_HEADER_STRING"],
        "info_label"=>$mod_strings["PDF_HEADER_STRING_INFO"],
        "value"=>PDF_HEADER_STRING,
        "class"=>"basic",
        "type"=>"text",
    ),
    */
    "sugarpdf_pdf_header_logo"=>array(
        "label"=>$mod_strings["PDF_HEADER_LOGO"],
        "info_label"=>$mod_strings["PDF_HEADER_LOGO_INFO"],
        "value"=>PDF_HEADER_LOGO,
        "path"=>K_PATH_CUSTOM_IMAGES.PDF_HEADER_LOGO,
        "class"=>"logo",
        "type"=>"image",
    ),
    "new_header_logo"=>array(
        "label"=>$mod_strings["PDF_NEW_HEADER_LOGO"],
        "info_label"=>$mod_strings["PDF_NEW_HEADER_LOGO_INFO"],
        "value"=>"",
        "class"=>"logo",
        "type"=>"file",
    ),
    /*
    "sugarpdf_pdf_header_logo_width"=>array(
        "label"=>$mod_strings["PDF_HEADER_LOGO_WIDTH"],
        "info_label"=>$mod_strings["PDF_HEADER_LOGO_WIDTH_INFO"],
        "value"=>PDF_HEADER_LOGO_WIDTH,
        "class"=>"logo",
        "type"=>"number",
        "required"=>"true",
        "unit"=>PDF_UNIT
    ),
    */
    "sugarpdf_pdf_small_header_logo"=>array(
        "label"=>$mod_strings["PDF_SMALL_HEADER_LOGO"],
        "info_label"=>$mod_strings["PDF_SMALL_HEADER_LOGO_INFO"],
        "value"=>PDF_SMALL_HEADER_LOGO,
        "path"=>K_PATH_CUSTOM_IMAGES.PDF_SMALL_HEADER_LOGO,
        "class"=>"logo",
        "type"=>"image",
    ),
    "new_small_header_logo"=>array(
        "label"=>$mod_strings["PDF_NEW_SMALL_HEADER_LOGO"],
        "info_label"=>$mod_strings["PDF_NEW_SMALL_HEADER_LOGO_INFO"],
        "value"=>"",
        "class"=>"logo",
        "type"=>"file",
    ),
    /*
    "sugarpdf_pdf_small_header_logo_width"=>array(
        "label"=>$mod_strings["PDF_SMALL_HEADER_LOGO_WIDTH"],
        "info_label"=>$mod_strings["PDF_SMALL_HEADER_LOGO_WIDTH_INFO"],
        "value"=>PDF_SMALL_HEADER_LOGO_WIDTH,
        "class"=>"logo",
        "type"=>"number",
        "required"=>"true",
        "unit"=>PDF_UNIT
    ),
*/
    

    "sugarpdf_pdf_filename"=>array(
        "label"=>$mod_strings["PDF_FILENAME"],
        "info_label"=>$mod_strings["PDF_FILENAME_INFO"],
        "value"=>PDF_FILENAME,
        "class"=>"advanced",
        "type"=>"text",
        "required"=>"true"
    ),
    "sugarpdf_pdf_compression"=>array(
        "label"=>$mod_strings["PDF_COMPRESSION"],
        "info_label"=>$mod_strings["PDF_COMPRESSION_INFO"],
        "value"=>PDF_COMPRESSION,
        "class"=>"advanced",
        "type"=>"bool",
    ),
    "sugarpdf_pdf_jpeg_quality"=>array(
        "label"=>$mod_strings["PDF_JPEG_QUALITY"],
        "info_label"=>$mod_strings["PDF_JPEG_QUALITY_INFO"],
        "value"=>PDF_JPEG_QUALITY,
        "class"=>"advanced",
        "type"=>"percent",
        "required"=>"true"
    ),
    "sugarpdf_pdf_pdf_version"=>array(
        "label"=>$mod_strings["PDF_PDF_VERSION"],
        "info_label"=>$mod_strings["PDF_PDF_VERSION_INFO"],
        "value"=>PDF_PDF_VERSION,
        "class"=>"advanced",
        "type"=>"number",
        "required"=>"true"
    ),
    
    
    "sugarpdf_pdf_protection"=>array(
        "label"=>$mod_strings["PDF_PROTECTION"],
        "info_label"=>$mod_strings["PDF_PROTECTION_INFO"],
        "value"=>explode(",",PDF_PROTECTION),
        "class"=>"advanced",
        "type"=>"multiselect",
        "selectList"=>array("print"=>"Print", "modify"=>"Modify", "copy"=>"Copy", "annot-forms"=>"Annotations and forms"),
    ),
    
    "sugarpdf_pdf_user_password"=>array(
        "label"=>$mod_strings["PDF_USER_PASSWORD"],
        "info_label"=>$mod_strings["PDF_USER_PASSWORD_INFO"],
        "value"=>blowfishDecode(blowfishGetKey('sugarpdf_pdf_user_password'), PDF_USER_PASSWORD),
        "class"=>"advanced",
        "type"=>"password"
    ),
    "sugarpdf_pdf_owner_password"=>array(
        "label"=>$mod_strings["PDF_OWNER_PASSWORD"],
        "info_label"=>$mod_strings["PDF_OWNER_PASSWORD_INFO"],
        "value"=>blowfishDecode(blowfishGetKey('sugarpdf_pdf_owner_password'), PDF_OWNER_PASSWORD),
        "class"=>"advanced",
        "type"=>"password"
    ),

    "sugarpdf_pdf_acl_access"=>array(
        "label"=>$mod_strings["PDF_ACL_ACCESS"],
        "info_label"=>$mod_strings["PDF_ACL_ACCESS_INFO"],
        "value"=>PDF_ACL_ACCESS,
        "class"=>"advanced",
        "type"=>"select",
        "selectList"=>array("edit"=>"Edition","list"=>"List","detail"=>"Detail", "export"=>"Export"),
        "required"=>"true"
    ),
    
/*    "sugarpdf_head_magnification"=>array(
        "label"=>$mod_strings["HEAD_MAGNIFICATION"],
        "info_label"=>$mod_strings["HEAD_MAGNIFICATION_INFO"],
        "value"=>HEAD_MAGNIFICATION,
        "class"=>"advanced",
        "type"=>"number",
        "required"=>"true"
    ),*/
/*    "sugarpdf_k_title_magnification"=>array(
        "label"=>$mod_strings["K_TITLE_MAGNIFICATION"],
        "info_label"=>$mod_strings["K_TITLE_MAGNIFICATION_INFO"],
        "value"=>K_TITLE_MAGNIFICATION,
        "class"=>"advanced",
        "type"=>"number",
        "required"=>"true"
    ),*/
    
    "sugarpdf_k_small_ratio"=>array(
        "label"=>$mod_strings["K_SMALL_RATIO"],
        "info_label"=>$mod_strings["K_SMALL_RATIO_INFO"],
        "value"=>K_SMALL_RATIO,
        "class"=>"advanced",
        "type"=>"number",
        "required"=>"true"
    ),
    "sugarpdf_k_cell_height_ratio"=>array(
        "label"=>$mod_strings["K_CELL_HEIGHT_RATIO"],
        "info_label"=>$mod_strings["K_CELL_HEIGHT_RATIO_INFO"],
        "value"=>K_CELL_HEIGHT_RATIO,
        "class"=>"advanced",
        "type"=>"number",
        "required"=>"true"
    ),
    "sugarpdf_pdf_image_scale_ratio"=>array(
        "label"=>$mod_strings["PDF_IMAGE_SCALE_RATIO"],
        "info_label"=>$mod_strings["PDF_IMAGE_SCALE_RATIO_INFO"],
        "value"=>PDF_IMAGE_SCALE_RATIO,
        "class"=>"advanced",
        "type"=>"number",
        "required"=>"true"
    ),
    "sugarpdf_pdf_unit"=>array(
        "label"=>$mod_strings["PDF_UNIT"],
        "info_label"=>$mod_strings["PDF_UNIT_INFO"],
        "value"=>PDF_UNIT,
        "class"=>"advanced",
        "type"=>"select",
    //TODO translate
        "selectList"=>array("mm"=>"Millimeter", "pt"=>"Point", "cm"=>"Centimeter", "in"=>"Inch"),
        "required"=>"true"
    ),
);

// Use the OOB directory for images if there is no image in the custom directory
$small_logo = $SugarpdfSettings['sugarpdf_pdf_small_header_logo']['path'];
$logo = $SugarpdfSettings['sugarpdf_pdf_header_logo']['path'];
if (@getimagesize($logo) === FALSE) {
    $SugarpdfSettings['sugarpdf_pdf_header_logo']['path'] = K_PATH_IMAGES.$SugarpdfSettings['sugarpdf_pdf_header_logo']['value'];
}
if (@getimagesize($small_logo) === FALSE) {
    $SugarpdfSettings['sugarpdf_pdf_small_header_logo']['path'] = K_PATH_IMAGES.$SugarpdfSettings['sugarpdf_pdf_small_header_logo']['value'];
}

?>