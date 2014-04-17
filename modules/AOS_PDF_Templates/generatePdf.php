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
 
	if(!isset($_REQUEST['uid']) || empty($_REQUEST['uid']) || !isset($_REQUEST['templateID']) || empty($_REQUEST['templateID'])){
		die('Error retrieving record. This record may be deleted or you may not be authorized to view it.');
	}
	error_reporting(0);
	require_once('modules/AOS_PDF_Templates/PDF_Lib/mpdf.php');
	require_once('modules/AOS_PDF_Templates/templateParser.php');
	require_once('modules/AOS_PDF_Templates/sendEmail.php');
	require_once('modules/AOS_PDF_Templates/AOS_PDF_Templates.php');
	
	global $mod_strings,$sugar_config;
	
	$module_type = $_REQUEST['module'];
	$module_type_file = strtoupper(ltrim(rtrim($module_type,'s'),'AOS_'));
	$module_type_low = strtolower($module_type);
	
	$module = new $module_type();
	$module->retrieve($_REQUEST['uid']);

	$task = $_REQUEST['task'];
	
	$lineItems = array();
    $sql = "SELECT pg.id, pg.product_id, pg.group_id FROM aos_products_quotes pg LEFT JOIN aos_line_item_groups lig ON pg.group_id = lig.id WHERE pg.parent_type = '".$module->object_name."' AND pg.parent_id = '".$module->id."' AND pg.deleted = 0 ORDER BY lig.number ASC, pg.number ASC";
    $res = $module->db->query($sql);
	while($row = $module->db->fetchByAssoc($res)){
            $lineItemsGroups[$row['group_id']][$row['id']]= $row['product_id'];
            $lineItems[$row['id']]= $row['product_id'];

	}

	
	$template = new AOS_PDF_Templates();
	$template->retrieve($_REQUEST['templateID']);
	
	$object_arr = array();
	$object_arr[$module_type] = $module->id;

    //backward compatibility
	$object_arr['Accounts'] = $module->billing_account_id;
	$object_arr['Contacts'] = $module->billing_contact_id;
	$object_arr['Users'] = $module->assigned_user_id;
	$object_arr['Currencies'] = $module->currency_id;
	
	$search = array ('@<script[^>]*?>.*?</script>@si', 		// Strip out javascript
					'@<[\/\!]*?[^<>]*?>@si',		// Strip out HTML tags
					'@([\r\n])[\s]+@',			// Strip out white space
					'@&(quot|#34);@i',			// Replace HTML entities
					'@&(amp|#38);@i',
					'@&(lt|#60);@i',
					'@&(gt|#62);@i',
					'@&(nbsp|#160);@i',
					'@&(iexcl|#161);@i',
					'@&#(\d+);@e',
					'@<address[^>]*?>@si'
	);

	$replace = array ('',
					 '',
					 '\1',
					 '"',
					 '&',
					 '<',
					 '>',
					 ' ',
					 chr(161),
					 'chr(\1)',
					 '<br>'
		);
	
	$header = preg_replace($search, $replace, $template->pdfheader);
	$footer = preg_replace($search, $replace, $template->pdffooter);
	$text = preg_replace($search, $replace, $template->description);
	$text = preg_replace('/\{DATE\s+(.*?)\}/e',"date('\\1')",$text );
	$text = str_replace("\$aos_quotes","\$".$module_type_low,$text);
	$text = str_replace("\$aos_invoices","\$".$module_type_low,$text);
	$text = str_replace("\$total_amt","\$".$module_type_low."_total_amt",$text);
	$text = str_replace("\$discount_amount","\$".$module_type_low."_discount_amount",$text);
	$text = str_replace("\$subtotal_amount","\$".$module_type_low."_subtotal_amount",$text);
	$text = str_replace("\$tax_amount","\$".$module_type_low."_tax_amount",$text);
	$text = str_replace("\$shipping_amount","\$".$module_type_low."_shipping_amount",$text);
	$text = str_replace("\$total_amount","\$".$module_type_low."_total_amount",$text);

    $text = populate_group_lines($text, $lineItemsGroups, $lineItems);

	$converted = templateParser::parse_template($text, $object_arr);
	$header = templateParser::parse_template($header, $object_arr);
	$footer = templateParser::parse_template($footer, $object_arr);
	
	$printable = str_replace("\n","<br />",$converted);



	if($task == 'pdf' || $task == 'emailpdf')
		{
			$file_name = $mod_strings['LBL_PDF_NAME']."_".str_replace(" ","_",$module->name).".pdf";
			
			ob_clean();
			try{
				$pdf=new mPDF('en','A4','','DejaVuSansCondensed',$template->margin_left,$template->margin_right,$template->margin_top,$template->margin_bottom,$template->margin_header,$template->margin_footer);
				$pdf->setAutoFont();
				$pdf->SetHTMLHeader($header);
				$pdf->SetHTMLFooter($footer);
				$pdf->writeHTML($printable);
				if($task == 'pdf'){
					$pdf->Output($file_name, "D");
				}else{
					$fp = fopen($sugar_config['upload_dir'].'attachfile.pdf','wb');
					fclose($fp);
					$pdf->Output($sugar_config['upload_dir'].'attachfile.pdf','F');
					sendEmail::send_email($module,$module_type, '',$file_name, true,$module->id);
				}
			}catch(mPDF_exception $e){
				echo $e;
			}
		}
		else if($task == 'email')
		{
			sendEmail::send_email($module,$module_type, $printable,'', false);
		}
	

function populate_group_lines($text, $lineItemsGroups, $lineItems, $element = 'table'){

    $firstValue = '';
    $firstNum = 0;

    $lastValue = '';
    $lastNum = 0;

    $startElement = '<'.$element;
    $endElement = '</'.$element.'>';


    $groups = new AOS_Line_Item_Groups();
    foreach($groups->field_defs as $name => $arr){
        if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){

            $curNum = strpos($text,'$aos_line_item_groups_'.$name);
            if($curNum)
            {
                if($curNum < $firstNum || $firstNum == 0)
                {
                    $firstValue = '$aos_line_item_groups_'.$name;
                    $firstNum = $curNum;
                }
                if($curNum > $lastNum)
                {
                    $lastValue = '$aos_line_item_groups_'.$name;
                    $lastNum = $curNum;
                }
            }
        }
    }
    if($firstValue !== '' && $lastValue !== ''){
        //Converting Text
        $parts = explode($firstValue,$text);
        $text = $parts[0];
        $parts = explode($lastValue,$parts[1]);
        $groupPart = $firstValue . $parts[0] . $lastValue;

        if(count($lineItemsGroups) != 0){
            //Read line start <tr> value
            $tcount = strrpos($text,$startElement);
            $lsValue = substr($text,$tcount);
            $tcount=strpos($lsValue,">")+1;
            $lsValue = substr($lsValue,0,$tcount);



            //Read line end values
            $tcount=strpos($parts[1],$endElement)+strlen($endElement);
            $leValue = substr($parts[1],0,$tcount);

            //Converting Line Items
            $obb = array();

            $tdTemp = explode($lsValue,$text);

            $groupPart = $lsValue.$tdTemp[count($tdTemp)-1].$groupPart.$leValue;

            $text = $tdTemp[0];

            foreach ($lineItemsGroups as $group_id => $lineItemsArray){
                $groupPartTemp = populate_product_lines($groupPart, $lineItemsArray);
                $groupPartTemp  = populate_service_lines($groupPartTemp , $lineItemsArray);

                $obb['AOS_Line_Item_Groups'] = $group_id;
                $text .= templateParser::parse_template($groupPartTemp, $obb);
                $text .= '<br />';
            }
            $tcount=strpos($parts[1],$endElement)+strlen($endElement);
            $parts[1]= substr($parts[1],$tcount);
        }
        else{
            $tcount = strrpos($text,$startElement);
            $text = substr($text,0,$tcount);

            $tcount=strpos($parts[1],$endElement)+strlen($endElement);
            $parts[1]= substr($parts[1],$tcount);
        }

        $text .= $parts[1];
    } else {
        $text = populate_product_lines($text, $lineItems);
        $text = populate_service_lines($text, $lineItems);
    }
    
	
    return $text;

}

function populate_product_lines($text, $lineItems, $element = 'tr'){
    $firstValue = '';
    $firstNum = 0;

    $lastValue = '';
    $lastNum = 0;

    $startElement = '<'.$element;
    $endElement = '</'.$element.'>';

    //Find first and last valid line values
    $product_quote = new AOS_Products_Quotes();
    foreach($product_quote->field_defs as $name => $arr){
        if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){

            $curNum = strpos($text,'$aos_products_quotes_'.$name);

            if($curNum)
            {
                if($curNum < $firstNum || $firstNum == 0)
                {
                    $firstValue = '$aos_products_quotes_'.$name;
                    $firstNum = $curNum;

                }
                if($curNum > $lastNum)
                {
                    $lastValue = '$aos_products_quotes_'.$name;
                    $lastNum = $curNum;

                }
            }
        }
    }

    $product = new AOS_Products();
    foreach($product->field_defs as $name => $arr){
        if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){

            $curNum = strpos($text,'$aos_products_'.$name);
            if($curNum)
            {
                if($curNum < $firstNum || $firstNum == 0)
                {
                    $firstValue = '$aos_products_'.$name;
					
					
                    $firstNum = $curNum;
                }
                if($curNum > $lastNum)
                {
                    $lastValue = '$aos_products_'.$name;
                    $lastNum = $curNum;
                }
            }
        }
    }

    if($firstValue !== '' && $lastValue !== ''){

        //Converting Text
        $tparts = explode($firstValue,$text);
        $temp = $tparts[0];

        //check if there is only one line item
        if($firstNum == $lastNum){
            $linePart = $firstValue;
        }
        else{
            $tparts = explode($lastValue,$tparts[1]);
            $linePart = $firstValue . $tparts[0] . $lastValue;
        }


        $tcount = strrpos($temp,$startElement);
        $lsValue = substr($temp,$tcount);
        $tcount=strpos($lsValue,">")+1;
        $lsValue = substr($lsValue,0,$tcount);

        //Read line end values
        $tcount=strpos($tparts[1],$endElement)+strlen($endElement);
        $leValue = substr($tparts[1],0,$tcount);
        $tdTemp = explode($lsValue,$temp);

        $linePart = $lsValue.$tdTemp[count($tdTemp)-1].$linePart.$leValue;
        $parts = explode($linePart,$text);
        $text = $parts[0];

        //Converting Line Items
        if(count($lineItems) != 0){
            foreach($lineItems as $id => $productId){
                if($productId != null && $productId != '0'){
                    $obb['AOS_Products_Quotes'] = $id;
                    $obb['AOS_Products'] = $productId;
                    $text .= templateParser::parse_template($linePart, $obb);
                }
            }
        }

        $text .= $parts[1];
    }
    return $text;
}

function populate_service_lines($text, $lineItems, $element = 'tr'){
    $firstValue = '';
    $firstNum = 0;

    $lastValue = '';
    $lastNum = 0;

    $startElement = '<'.$element;
    $endElement = '</'.$element.'>';

    $text = str_replace("\$aos_services_quotes_service","\$aos_services_quotes_product",$text);

    //Find first and last valid line values
    $product_quote = new AOS_Products_Quotes();
    foreach($product_quote->field_defs as $name => $arr){
        if(!((isset($arr['dbType']) && strtolower($arr['dbType']) == 'id') || $arr['type'] == 'id' || $arr['type'] == 'link')){

            $curNum = strpos($text,'$aos_services_quotes_'.$name);
            if($curNum)
            {
                if($curNum < $firstNum || $firstNum == 0)
                {
                    $firstValue = '$aos_products_quotes_'.$name;
                    $firstNum = $curNum;
                }
                if($curNum > $lastNum)
                {
                    $lastValue = '$aos_products_quotes_'.$name;
                    $lastNum = $curNum;
                }
            }
        }
    }
    if($firstValue !== '' && $lastValue !== ''){
        $text = str_replace("\$aos_products","\$aos_null",$text);
        $text = str_replace("\$aos_services","\$aos_products",$text);

        //Converting Text
        $tparts = explode($firstValue,$text);
        $temp = $tparts[0];

        //check if there is only one line item
        if($firstNum == $lastNum){
            $linePart = $firstValue;
        }
        else{
            $tparts = explode($lastValue,$tparts[1]);
            $linePart = $firstValue . $tparts[0] . $lastValue;
        }

        $tcount = strrpos($temp,$startElement);
        $lsValue = substr($temp,$tcount);
        $tcount=strpos($lsValue,">")+1;
        $lsValue = substr($lsValue,0,$tcount);

        //Read line end values
        $tcount=strpos($tparts[1],$endElement)+strlen($endElement);
        $leValue = substr($tparts[1],0,$tcount);
        $tdTemp = explode($lsValue,$temp);

        $linePart = $lsValue.$tdTemp[count($tdTemp)-1].$linePart.$leValue;
        $parts = explode($linePart,$text);
        $text = $parts[0];

        //Converting Line Items
        if(count($lineItems) != 0){
            foreach($lineItems as $id => $productId){
                if($productId == null || $productId == '0'){
                    $obb['AOS_Products_Quotes'] = $id;
                    $text .= templateParser::parse_template($linePart, $obb);
                }
            }
        }

        $text .= $parts[1];
    }
    return $text;
}