<?php

class WebToLeadFormBuilder {

    // ---- html outputs ----

    private static function getFormStartHTML($styleHref, $suiteGrp1Js, $calendarJs, $webPostUrl, $webFormHeader, $webFormDescription) {
        $formSel = 'form#WebToLeadForm';
        $html = <<<HTML
<style type="text/css">
$formSel, $formSel * {margin: 0; padding: 0; border: none; color: #333; font-size: 12px; line-height: 1.6em; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;}
$formSel {float: left; border: 1px solid #ccc; margin: 10px;}
$formSel h1 {font-size: 32px; font-weight: bold; background-color: rgb(60, 141, 188); color: rgb(247, 247, 247); padding: 10px 20px;}
$formSel h2 {font-size: 24px; font-weight: bold; background-color: rgb(60, 141, 188); color: rgb(247, 247, 247); padding: 10px 20px;}
$formSel h3 {font-size: 12px; font-weight: bold; padding: 10px 20px;}
$formSel h4 {font-size: 10px; font-weight: bold; padding: 10px 20px;}
$formSel h5 {font-size: 8px; font-weight: bold; padding: 10px 20px;}
$formSel h6 {font-size: 6px; font-weight: bold; padding: 10px 20px;}
$formSel p {padding: 10px 20px;}
$formSel input,
$formSel select,
$formSel textarea {border: 1px solid #ccc; display: block; float: left; width: auto; padding: 5px;}
$formSel select {background-color: white;}
$formSel input[type="button"],
$formSel input[type="submit"] {display: inline; float: none; padding: 5px 10px;}
$formSel div.row {padding: 10px 20px;}
$formSel div.col {display: block; float: left; width: 300px;}
$formSel div.clear {display: block; float: none; clear: both; height: 0px; overflow: hidden;}
$formSel div.center {text-align: center;}
$formSel label {display: block; float: left; width: 100px;}
$formSel span.required {color: #FF0000;}
</style>
<link rel="stylesheet" type="text/css" media="all" href="$styleHref">
<script type=\"text/javascript\" src='$suiteGrp1Js'></script>
<script type="text/javascript" src="$calendarJs"></script>
<form action='$webPostUrl' name='WebToLeadForm' method='POST' id='WebToLeadForm'>
    <h2>$webFormHeader</h2></b>
    <p>$webFormDescription</p>
HTML;
        return $html;
    }

    private static function getFormFooterHTML($webFormFooter, $webFormSubmitLabel, $webFormCampaign, $webRedirectURL, $webAssignedUser, $reqFields, $booleanFields) {
        $webFormCampaignInput = $webFormCampaign ? "<input type='hidden' id='campaign_id' name='campaign_id' value='$webFormCampaign'>" : '';
        $webRedirectURLInput = $webRedirectURL ? "<input type='hidden' id='redirect_url' name='redirect_url' value='$webRedirectURL'>" : '';
        $webAssignedUserInput = $webAssignedUser ? "<input type='hidden' id='assigned_user_id' name='assigned_user_id' value='$webAssignedUser'>" : '';
        $reqFieldsInput = $reqFields ? "<input type='hidden' id='req_id' name='req_id' value='$reqFields'>" : '';
        $booleanFieldsInput = $booleanFields ? "<input type='hidden' id='bool_id' name='bool_id' value='$booleanFields'>" : '';

        $html = <<<HTML
$webFormFooter
<div class="row center">
    <input type='button' onclick='submit_form();' class='button' name='Submit' value='$webFormSubmitLabel'/>
    <br>
    <br>
</div>
$webFormCampaignInput
$webRedirectURLInput
$webAssignedUserInput
$reqFieldsInput
$booleanFieldsInput
HTML;
        return $html;
    }

    private static function getFormFinishHTML($webFormRequiredFieldsMsg, $webNotValidEmailAddress, $emailRegex) {
        $html = <<<HTML
</form>
<script type='text/javascript'>
 function submit_form(){
 	if(typeof(validateCaptchaAndSubmit)!='undefined'){
 		validateCaptchaAndSubmit();
 	}else{
 		check_webtolead_fields();
 	}
 }
 function check_webtolead_fields(){
     if(document.getElementById('bool_id') != null){
        var reqs=document.getElementById('bool_id').value;
        bools = reqs.substring(0,reqs.lastIndexOf(';'));
        var bool_fields = new Array();
        var bool_fields = bools.split(';');
        nbr_fields = bool_fields.length;
        for(var i=0;i<nbr_fields;i++){
          if(document.getElementById(bool_fields[i]).value == 'on'){
             document.getElementById(bool_fields[i]).value = 1;
          }
          else{
             document.getElementById(bool_fields[i]).value = 0;
          }
        }
      }
    if(document.getElementById('req_id') != null){
        var reqs=document.getElementById('req_id').value;
        reqs = reqs.substring(0,reqs.lastIndexOf(';'));
        var req_fields = new Array();
        var req_fields = reqs.split(';');
        nbr_fields = req_fields.length;
        var req = true;
        for(var i=0;i<nbr_fields;i++){
          if(document.getElementById(req_fields[i]).value.length <=0 || document.getElementById(req_fields[i]).value==0){
           req = false;
           break;
          }
        }
        if(req){
            document.WebToLeadForm.submit();
            return true;
        }
        else{
          alert('$webFormRequiredFieldsMsg');
          return false;
         }
        return false
   }
   else{
    document.WebToLeadForm.submit();
   }
}
function validateEmailAdd(){
	if(document.getElementById('email1') && document.getElementById('email1').value.length >0) {
		if(document.getElementById('email1').value.match($emailRegex) == null){
		  alert('$webNotValidEmailAddress');
		}
	}
	if(document.getElementById('email2') && document.getElementById('email2').value.length >0) {
		if(document.getElementById('email2').value.match($emailRegex) == null){
		  alert('$webNotValidEmailAddress');
		}
	}
}
</script>
HTML;
        return $html;
    }

    private static function getRowStartHTML() {
        return '<div class="row">';
    }

    private static function getRowFinishHTML() {
        return '    <div class="clear"></div>
                </div>';
    }

    private static function getColFieldStartHTML() {
        return '<div class="col">';
    }

    private static function getColFieldFinishHTML() {
        return '</div>';
    }

    // -- fields

    private static function getFieldLabelHTML($fieldLabel, $fieldRequired, $webRequiredSymbol) {
        $html = '<label>' . $fieldLabel . ($fieldRequired ? "<span class='required'>$webRequiredSymbol</span>" : '') . '</label>';
        return $html;
    }

    private static function getFieldEmptyHTML() {
        $html = '&nbsp;';
        return $html;
    }

    // enums

    private static function getFieldEnumHTML($lead, $fieldName, $appListStringsFieldOptions, $fieldRequired, $fieldLabel, $webRequiredSymbol, $colsField) {
        $html = '';

        $leadOptions = get_select_options_with_id($appListStringsFieldOptions, !empty($lead->$fieldName) ? unencodeMultienum($lead->$fieldName) : '');

        $html .= self::getFieldLabelHTML($fieldLabel, $fieldRequired, $webRequiredSymbol);

        if(isset($lead->field_defs[$colsField]['isMultiSelect']) && $lead->field_defs[$colsField]['isMultiSelect'] ==1){
            $html .= self::getFieldEnumMultiSelectHTML($fieldName, $leadOptions);
        }elseif(ifRadioButton($lead->field_defs[$colsField]['name'])){
            $html .= self::getFieldEnumRadioGroupHTML($appListStringsFieldOptions, $lead, $fieldName, $colsField);
        }else{
            $html .= self::getFieldEnumSelectHTML($fieldName, $leadOptions);
        }
        return $html;
    }

    private static function getFieldEnumMultiSelectHTML($fieldName, $leadOptions) {
        $html = "<select id='{$fieldName}' multiple='true' name='{$fieldName}[]' tabindex='1'>$leadOptions</select>";
        return $html;
    }

    private static function getFieldEnumRadioGroupHTML($appListStringsFieldOptions, $lead, $fieldName, $colsField) {
        $html = '';
        foreach($appListStringsFieldOptions as $field_option_key => $field_option){
            if($field_option != null){
                if(!empty($lead->$fieldName) && in_array($field_option_key,unencodeMultienum($lead->$fieldName))) {
                    $checked = ' checked';
                }
                else {
                    $checked = '';
                }
                $html .="<input id='$colsField"."_$field_option_key'$checked name='$colsField' value='$field_option_key' type='radio'>";
                // todo ??? -->
                $html .="<span ='document.getElementById('".$lead->field_defs[$colsField]."_$field_option_key').checked =true style='cursor:default'; onmousedown='return false;'>$field_option</span><br>";
            }
        }
        return $html;
    }

    private static function getFieldEnumSelectHTML($fieldName, $leadOptions) {
        $html = "<select id=$fieldName name=$fieldName tabindex='1'>$leadOptions</select>";
        return $html;
    }

    // bool

    private static function getFieldBoolHTML($fieldName, $fieldRequired, $fieldLabel, $webRequiredSymbol) {
        $html = self::getFieldLabelHTML($fieldLabel, $fieldRequired, $webRequiredSymbol);
        $html .= "<input type='checkbox' id=$fieldName name=$fieldName>";

        return $html;
    }

    // date

    private static function getFieldDateHTML(TimeDate $timeDate, $fieldName, $fieldRequired, $fieldLabel, $webRequiredSymbol) {
        $cal_dateformat = $timeDate->get_cal_date_format();
        //$LBL_ENTER_DATE = translate('LBL_ENTER_DATE', 'Charts');
        $html = self::getFieldLabelHTML($fieldLabel, $fieldRequired, $webRequiredSymbol);

        $html .= "
				<script type='text/javascript'>
					update{$fieldName}Value = function() {
						var format = '{$cal_dateformat}';
						var month = document.getElementById('{$fieldName}_month').value;
						var day = document.getElementById('{$fieldName}_day').value;
						var year = document.getElementById('{$fieldName}_year').value;
						var val = format.replace('%m', month).replace('%d', day).replace('%Y', year);
						if (!parseInt(month) > 0 || !parseInt(year) > 0 || !parseInt(year) > 0)
							val = '';
						document.getElementById('{$fieldName}').value = val;
					}
				</script>
				<input type='hidden' id='{$fieldName}' name='{$fieldName}'/>";
        $order = explode("%", $cal_dateformat);
        foreach($order as $part)
        {
            if (!isset($part[0]))
                continue;
            if (strToUpper($part[0]) == "M" )
                $html .= "<input class=\"text\"
					name=\"{$fieldName}_month\" size='2' maxlength='2' id='{$fieldName}_month' value=''
					onblur=\"update{$fieldName}Value()\" placeholder=\"" . translate("LBL_MONTH") . "\">";
            else if (strToUpper($part[0]) == "D" )
                $html .=  "<input class=\"text\"
					name=\"{$fieldName}_day\" size='2' maxlength='2' id='{$fieldName}_day' value=''
					onblur=\"update{$fieldName}Value()\" placeholder=\"" . translate("LBL_DAY") . "\">";
            else if (strToUpper($part[0]) == "Y" )
                $html .= "<input class=\"text\"
					name=\"{$fieldName}_year\" size='4' maxlength='4' id='{$fieldName}_year' value=''
					onblur=\"update{$fieldName}Value()\" placeholder=\"" . translate("LBL_YEAR") . "\">";
        }
        return $html;
    }

    // char strings

    private static function getFieldCharsHTML($fieldName, $fieldLabel, $fieldRequired, $webRequiredSymbol) {
        $html = self::getFieldLabelHTML($fieldLabel, $fieldName=='last_name' || $fieldRequired, $webRequiredSymbol);
        $onChangeValidateEmailAdd = $fieldName=='email1'||$fieldName=='email2' ? " onchange='validateEmailAdd();'" : '';
        $html .= "<input id=$fieldName name=$fieldName type='text'$onChangeValidateEmailAdd>";
        return $html;
    }

    // text

    private static function getFieldTextHTML($fieldName, $fieldLabel, $fieldRequired, $webRequiredSymbol) {
        $html  = self::getFieldLabelHTML($fieldLabel, $fieldRequired, $webRequiredSymbol);
        $html .= "<span id='ta_replace'><input id=$fieldName name=$fieldName type='text'></span>";
        return $html;
    }

    // relate

    private static function getFieldRelateHTML($fieldName, $fieldLabel, $fieldRequired, $webRequiredSymbol) {
        $html  = self::getFieldLabelHTML($fieldLabel, $fieldRequired, $webRequiredSymbol);
        $html .= "<span><input id=$fieldName name=$fieldName type='text'></span>";
        return $html;
    }

    // email

    private static function getFieldEmailHTML($fieldName, $fieldRequired, $fieldLabel, $webRequiredSymbol) {
        $html = self::getFieldLabelHTML($fieldLabel, $fieldRequired, $webRequiredSymbol);
        $html .= "<td width='35%' style='font-size: 12px; font-weight: normal;'><span sugar='slot'><input id=$fieldName name=$fieldName type='text' onchange='validateEmailAdd();'></span sugar='slot'></td>";
        return $html;
    }

    // ----------------

    private static function getFormTwoColumns($request, $formCols) {
        $colsFirst = isset($request[$formCols[0]]) ? $request[$formCols[0]] : null;
        $colsSecond = isset($request[$formCols[1]]) ? $request[$formCols[1]] : null;
        if(!empty($colsFirst) && !empty($colsSecond)){
            if(count($colsFirst) < count($colsSecond)){
                $columns= count($colsSecond);
            }
            if(count($colsFirst) > count($colsSecond) || count($colsFirst) == count($colsSecond)){
                $columns= count($colsFirst);
            }
        }
        else if(!empty($colsFirst)){
            $columns= count($colsFirst);
        }
        else if(!empty($colsSecond)){
            $columns= count($colsSecond);
        }
        return $columns;
    }

    private static function getReqFields($requiredFields) {
        $req_fields='';
        if($requiredFields != null ){
            foreach($requiredFields as $req){
                $req_fields=$req_fields.$req.';';
            }
        }
        return $req_fields;
    }

    private static function getBooleanFields($boolFields) {
        $boolean_fields='';
        if($boolFields != null ){
            foreach($boolFields as $boo){
                $boolean_fields=$boolean_fields.$boo.';';
            }
        }
        return $boolean_fields;
    }

    private static function getArrayOfFieldInfo($lead, $colsField, &$requiredFields) {
        $field_vname= preg_replace('/:$/','',translate($lead->field_defs[$colsField]['vname'],'Leads'));
        $field_name= $colsField;
        $field_label = $field_vname .": ";
        if(isset($lead->field_defs[$colsField]['custom_type']) && $lead->field_defs[$colsField]['custom_type'] != null){
            $field_type= $lead->field_defs[$colsField]['custom_type'];
        }
        else{
            $field_type= $lead->field_defs[$colsField]['type'];
        }

        //bug: 47574 - make sure, that webtolead_email1 field has same required attribute as email1 field
        if($colsField == 'webtolead_email1' && isset($lead->field_defs['email1']) && isset($lead->field_defs['email1']['required'])){
            $lead->field_defs['webtolead_email1']['required'] = $lead->field_defs['email1']['required'];
        }

        $field_required = '';
        if(isset($lead->field_defs[$colsField]['required']) && $lead->field_defs[$colsField]['required'] != null
            && $lead->field_defs[$colsField]['required'] != 0){
            $field_required = $lead->field_defs[$colsField]['required'];
            if (! in_array($lead->field_defs[$colsField]['name'], $requiredFields)){
                array_push($requiredFields,$lead->field_defs[$colsField]['name']);
            }
        }
        if($lead->field_defs[$colsField]['name']=='last_name'){
            if (! in_array($lead->field_defs[$colsField]['name'], $requiredFields)){
                array_push($requiredFields,$lead->field_defs[$colsField]['name']);
            }
        }
        $field_options = null;
        if($field_type=='multienum' || $field_type=='enum' || $field_type=='radioenum')  $field_options= $lead->field_defs[$colsField]['options'];
        return array($field_name, $field_label, $field_type, $field_required, $field_options);
    }

    // --------------- generate form ------------------

    public static function generate($request,
                                    $lead,
                                    $siteURL,
                                    $webPostURL,
                                    $webFormHeader,
                                    $webFormDescription,
                                    $appListStrings,
                                    $webRequiredSymbol,
                                    $webFormFooter,
                                    $webFormSubmitLabel,
                                    $webFormCampaign,
                                    $webRedirectURL,
                                    $webAssignedUser,
                                    $webFormRequiredFieldsMsg,
                                    $webNotValidEmailAddress,
                                    $regex,
                                    $timedate,
                                    $formCols = array('colsFirst', 'colsSecond')
                                    ) {

        $calendarCss = getJSPath(SugarThemeRegistry::current()->getCSSURL('calendar-win2k-cold-1.css'));
        $sugarGrp1Js = getJSPath($siteURL.'/cache/include/javascript/sugar_grp1.js');
        $calendarJs = getJSPath($siteURL.'/cache/include/javascript/calendar.js');

        $Web_To_Lead_Form_html = self::getFormStartHTML(
            $calendarCss,
            $sugarGrp1Js,
            $calendarJs,
            $webPostURL,
            $webFormHeader,
            $webFormDescription
        );

        $columns = self::getFormTwoColumns($request, $formCols);


        $required_fields = array();
        $bool_fields = array();
        for($i= 0; $i<$columns;$i++){

            $colsFields = array();
            foreach($formCols as $k => $formCol) {
                $colsFields[$k] = !empty($request[$formCol][$i]) ? $request[$formCol][$i] : null;
            }

            if($colsFieldCount = count($formCols)) {

                $Web_To_Lead_Form_html .= self::getRowStartHTML();

                for ($j = 0; $j < $colsFieldCount; $j++) {

                    $Web_To_Lead_Form_html .= self::getColFieldStartHTML();

                    if (isset($lead->field_defs[$colsFields[$j]]) && $lead->field_defs[$colsFields[$j]] != null) {

                        list($field_name, $field_label, $field_type, $field_required, $field_options) = self::getArrayOfFieldInfo($lead, $colsFields[$j], $required_fields);

                        if ($field_type == 'multienum' || $field_type == 'enum' || $field_type == 'radioenum') {
                            $Web_To_Lead_Form_html .= self::getFieldEnumHTML($lead, $field_name, $appListStrings[$field_options], $field_required, $field_label, $webRequiredSymbol, $colsFields[$j]);
                        }

                        if ($field_type == 'bool') {
                            $Web_To_Lead_Form_html .= self::getFieldBoolHTML($field_name, $field_required, $field_label, $webRequiredSymbol);
                            if (!in_array($lead->field_defs[$colsFields[$j]]['name'], $bool_fields)) {
                                array_push($bool_fields, $lead->field_defs[$colsFields[$j]]['name']);
                            }
                        }

                        if ($field_type == 'date') {
                            $Web_To_Lead_Form_html .= self::getFieldDateHTML($timedate, $field_name, $field_required, $field_label, $webRequiredSymbol);
                        }

                        if ($field_type == 'varchar' || $field_type == 'name' || $field_type == 'phone' || $field_type == 'currency' || $field_type == 'url' || $field_type == 'int') {
                            $Web_To_Lead_Form_html .= self::getFieldCharsHTML($field_name, $field_label, $field_required, $webRequiredSymbol);
                        }

                        if ($field_type == 'text') {
                            $Web_To_Lead_Form_html .= self::getFieldTextHTML($field_name, $field_label, $field_required && false, $webRequiredSymbol);
                        }

                        if ($field_type == 'relate' && $field_name == 'account_name') {
                            $Web_To_Lead_Form_html .= self::getFieldRelateHTML($field_name, $field_label, $field_required && false, $webRequiredSymbol);
                        }

                        if ($field_type == 'email') {
                            $Web_To_Lead_Form_html .= self::getFieldEmailHTML();
                        }

                    } else {
                        $Web_To_Lead_Form_html .= self::getFieldEmptyHTML();
                    }

                    $Web_To_Lead_Form_html .= self::getColFieldFinishHTML();

                }
                $Web_To_Lead_Form_html .= self:: getRowFinishHTML();
            }
        }


        $regFields = self::getReqFields(isset($required_fields) ? $required_fields : null);
        $booleanFields = self::getBooleanFields(isset($bool_fields) ? $bool_fields : null);

        $Web_To_Lead_Form_html .= self::getFormFooterHTML(
            $webFormFooter,
            $webFormSubmitLabel,
            $webFormCampaign,
            $webRedirectURL,
            $webAssignedUser,
            $regFields,
            $booleanFields
        );

        $Web_To_Lead_Form_html .= self::getFormFinishHTML(
            $webFormRequiredFieldsMsg,
            $webNotValidEmailAddress,
            $regex
        );

		return $Web_To_Lead_Form_html;
	}

}
