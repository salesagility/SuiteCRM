<?php
/**
 * Products, Quotations & Invoices modules.
 * Extensions to SugarCRM
 * @package Advanced OpenSales for SugarCRM
 * @subpackage Products
 * @copyright SalesAgility Ltd http://www.salesagility.com
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU AFFERO GENERAL PUBLIC LICENSE
 * along with this program; if not, see http://www.gnu.org/licenses
 * or write to the Free Software Foundation,Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301  USA
 *
 * @author Salesagility Ltd <support@salesagility.com>
 */

/**
 * THIS CLASS IS FOR DEVELOPERS TO MAKE CUSTOMIZATIONS IN
 */
require_once('modules/AOS_Products/AOS_Products_sugar.php');
class AOS_Products extends AOS_Products_sugar {
	
	function AOS_Products(){	
		parent::AOS_Products_sugar();
	}
	
	function save($check_notify=false){
		global $sugar_config,$mod_strings;
		
		if (isset($_POST['deleteAttachment']) && $_POST['deleteAttachment']=='1') {
			$this->product_image = '';
		}
	
		require_once('include/upload_file.php');
		$GLOBALS['log']->debug('UPLOADING PRODUCT IMAGE');
		$upload_file = new UploadFile('uploadfile');

		if (isset($_FILES['uploadimage']['tmp_name'])&&$_FILES['uploadimage']['tmp_name']!=""){

            if($_FILES['uploadimage']['size'] > $sugar_config['upload_maxsize']) {
                die($mod_strings['LBL_IMAGE_UPLOAD_FAIL'].$sugar_config['upload_maxsize']);

            }
            else {
                $this->product_image=$sugar_config['site_url'].'/'.$sugar_config['upload_dir'].$_FILES['uploadimage']['name'];
                move_uploaded_file($_FILES['uploadimage']['tmp_name'], $sugar_config['upload_dir'].$_FILES['uploadimage']['name']);

            }
	    }

        require_once('modules/AOS_Products_Quotes/AOS_Utils.php');

        perform_aos_save($this);

	    parent::save($check_notify);
    }
	
}
?>
