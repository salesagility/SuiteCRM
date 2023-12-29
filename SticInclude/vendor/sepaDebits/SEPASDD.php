<?php
/*
 Copyright (c) 2013 Congressus, The Netherlands

 Permission is hereby granted, free of charge, to any person
 obtaining a copy of this software and associated documentation
 files (the "Software"), to deal in the Software without
 restriction, including without limitation the rights to use,
 copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the
 Software is furnished to do so, subject to the following
 conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 OTHER DEALINGS IN THE SOFTWARE. 
 */


/**
 * SEPA SSD (Sepa Direct Debit) 2.0
 * This class creates a Sepa Direct Debit XML File.
 */
class SEPASDD {
    
    private $config;
    private $XML;
    private $batchArray = array();
    
    function __construct($config){
        //Check the config
        $config_validator = $this->validateConfig($config);
        if($config_validator){
            $this->config = $config;
        }else{
            throw new Exception("Invalid config file: ".$config_validator);
        }
        
        //Prepare the document
        $this->prepareDocument();
        $this->createGroupHeader();
    }//__construct
    
    /**
     * Build the main document node and set xml namespaces.
     */
    private function prepareDocument(){
        //Create the XML Instance
        $this->xml = new DOMDocument("1.0","UTF-8");
        
        //Create the document node
        $documentNode = $this->xml->createElement("Document");
        
        //set the namespace
        $documentAttributeXMLNS = $this->xml->createAttribute("xmlns");
        $documentAttributeXMLNS->value = "urn:iso:std:iso:20022:tech:xsd:pain.008.001.02";
        $documentNode->appendChild($documentAttributeXMLNS);
        
        //set the namespace url
        $documentAttributeXMLNSXSI = $this->xml->createAttribute("xmlns:xsi");
        $documentAttributeXMLNSXSI->value = "http://www.w3.org/2001/XMLSchema-intance";
        $documentNode->appendChild($documentAttributeXMLNSXSI);
        
        //create the Direct Debit node
        $CstmrDrctDbtInitnNode = $this->xml->createElement("CstmrDrctDbtInitn");
        $documentNode->appendChild($CstmrDrctDbtInitnNode);
        
        //append the document node to the XML Instance
        $this->xml->appendChild($documentNode);
    }//prepareDocument
    
    /**
     * Function to create the GroupHeader (GrpHdr) in the CstmrDrctDbtInit Node
     */
    private function createGroupHeader(){
        //Retrieve the CstmrDrctDbtInitn node
        $CstmrDrctDbtInitnNode = $this->getCstmrDrctDbtInitnNode();
        
        //Create the required nodes
        $GrpHdrNode     = $this->xml->createElement("GrpHdr");
        $MsgIdNode      = $this->xml->createElement("MsgId");
        $CreDtTmNode    = $this->xml->createElement("CreDtTm");
        $NbOfTxsNode    = $this->xml->createElement("NbOfTxs");
        $CtrlSumNode    = $this->xml->createElement("CtrlSum");
        $InitgPtyNode   = $this->xml->createElement("InitgPty");
        $NmNode         = $this->xml->createElement("Nm");
        
        //Set the values for the nodes
        $MsgIdNode->nodeValue = $this->makeMsgId();
        $CreDtTmNode->nodeValue = date("c");
        $NmNode->nodeValue = htmlentities($this->config['name'],ENT_QUOTES);
        
        //Append the nodes
        $InitgPtyNode->appendChild($NmNode);
        $GrpHdrNode->appendChild($MsgIdNode);
        $GrpHdrNode->appendChild($CreDtTmNode);
        $GrpHdrNode->appendChild($NbOfTxsNode);
        $GrpHdrNode->appendChild($CtrlSumNode);
        $GrpHdrNode->appendChild($InitgPtyNode);
        
        //Append the header to its parent
        $CstmrDrctDbtInitnNode->appendChild($GrpHdrNode);
        
    }//createGroupHeader
    
    /**
     * Public function to add payments
     * @param the payment to be added in the form of an array
     * @throws Exception if payment array is invalid.
     */
    public function addPayment($payment){
        //First validate the payment array
     
        $validationResult = $this->validatePayment($payment);
        if($validationResult !== true){
            throw new Exception("Invalid Payment, error with: ".$validationResult);
        }
        
        //Get the CstmrDrctDbtInitnNode 
        $CstmrDrctDbtInitnNode  = $this->getCstmrDrctDbtInitnNode();
        
        //If there is a batch, the batch will create this information.
        if($this->config['batch'] == false){
            $PmtInfNode             = $this->xml->createElement("PmtInf");
            $PmtInfIdNode           = $this->xml->createElement("PmtInfId");
            $PmtMtdNode             = $this->xml->createElement("PmtMtd");
            $BtchBookgNode          = $this->xml->createElement("BtchBookg");
            $NbOfTxsNode            = $this->xml->createElement("NbOfTxs");
            $CtrlSumNode            = $this->xml->createElement("CtrlSum");
            $PmtTpInfNode           = $this->xml->createElement("PmtTpInf");
            $SvcLvlNode             = $this->xml->createElement("SvcLvl");
            $Cd_SvcLvl_Node         = $this->xml->createElement("Cd");
            $LclInstrmNode          = $this->xml->createElement("LclInstrm");
            $Cd_LclInstrm_Node      = $this->xml->createElement("Cd");
            $SeqTpNode              = $this->xml->createElement("SeqTp");
            $ReqdColltnDtNode       = $this->xml->createElement("ReqdColltnDt");
            $CdtrNode               = $this->xml->createElement("Cdtr");
            $Nm_Cdtr_Node           = $this->xml->createElement("Nm");
            $CdtrAcctNode           = $this->xml->createElement("CdtrAcct");
            $Id_CdtrAcct_Node       = $this->xml->createElement("Id");
            $IBAN_CdtrAcct_Node     = $this->xml->createElement("IBAN");
            if ( isset( $this->config['BIC'] ) ) {
            	$CdtrAgtNode            = $this->xml->createElement("CdtrAgt");
            	$FinInstnId_CdtrAgt_Node= $this->xml->createElement("FinInstnId");
            	$BIC_CdtrAgt_Node       = $this->xml->createElement("BIC");
            }
            $ChrgBrNode             = $this->xml->createElement("ChrgBr");
            $CdtrSchmeIdNode        = $this->xml->createElement("CdtrSchmeId");
            $Nm_CdtrSchmeId_Node    = $this->xml->createElement("Nm");
            $Id_CdtrSchmeId_Node    = $this->xml->createElement("Id");
            $PrvtIdNode             = $this->xml->createElement("PrvtId");
            $OthrNode               = $this->xml->createElement("Othr");
            $Id_Othr_Node           = $this->xml->createElement("Id");
            $SchmeNmNode            = $this->xml->createElement("SchmeNm");
            $PrtryNode              = $this->xml->createElement("Prtry");
            
            $PmtInfIdNode->nodeValue        = $this->makeId();
            $PmtMtdNode->nodeValue          = "DD"; //Direct Debit
            $BtchBookgNode->nodeValue       = "false";
            $NbOfTxsNode->nodeValue         = "1";
            $CtrlSumNode->nodeValue         = $this->intToDecimal($payment['amount']);
            $Cd_SvcLvl_Node->nodeValue      = "SEPA";
            $Cd_LclInstrm_Node->nodeValue   = "CORE";
            $SeqTpNode->nodeValue           = $payment['type']; //Define a check for: FRST RCUR OOFF FNAL
            $ReqdColltnDtNode->nodeValue    = $payment['collection_date']; 
            $Nm_Cdtr_Node->nodeValue        = htmlentities($this->config['name'], ENT_QUOTES);
            $IBAN_CdtrAcct_Node->nodeValue  = $this->config['IBAN'];
            if ( isset( $this->config['BIC'] ) ) {
            	$BIC_CdtrAgt_Node->nodeValue    = $this->config['BIC'];
            }
            $ChrgBrNode->nodeValue          = "SLEV";
            $Nm_CdtrSchmeId_Node->nodeValue = htmlentities($this->config['name'], ENT_QUOTES);
            $Id_Othr_Node->nodeValue        = $this->config['creditor_id'];
            $PrtryNode->nodeValue           = "SEPA";
            
        }else{
            //Get the batch node for this kind of payment to add the DrctDbtTxInf node.
            $batch = $this->getBatch($payment['type'],$payment['collection_date']);
        }
        
        //Create the payment node.
        $DrctDbtTxInfNode       = $this->xml->createElement("DrctDbtTxInf");
        $PmtIdNode              = $this->xml->createElement("PmtId");
        $EndToEndIdNode         = $this->xml->createElement("EndToEndId");
        $InstdAmtNode           = $this->xml->createElement("InstdAmt");
        $DrctDbtTxNode          = $this->xml->createElement("DrctDbtTx");
        $MndtRltdInfNode        = $this->xml->createElement("MndtRltdInf");
        $MndtIdNode             = $this->xml->createElement("MndtId");
        $DtOfSgntrNode          = $this->xml->createElement("DtOfSgntr");
        if ( isset( $payment['BIC'] ) ) {
        	$DbtrAgtNode            = $this->xml->createElement("DbtrAgt");
        	$FinInstnId_DbtrAgt_Node= $this->xml->createElement("FinInstnId");
        	$BIC_DbtrAgt_Node       = $this->xml->createElement("BIC");
        }
        $DbtrNode               = $this->xml->createElement("Dbtr");
        $Nm_Dbtr_Node           = $this->xml->createElement("Nm");
        $DbtrAcctNode           = $this->xml->createElement("DbtrAcct");
        $Id_DbtrAcct_Node       = $this->xml->createElement("Id");
        $IBAN_DbtrAcct_Node     = $this->xml->createElement("IBAN");
        $RmtInfNode             = $this->xml->createElement("RmtInf");
        $UstrdNode              = $this->xml->createElement("Ustrd");

        //Set the payment node information
        $InstdAmtNode->setAttribute("Ccy",$this->config['currency']);
        $InstdAmtNode->nodeValue        = $this->intToDecimal($payment['amount']);
        
        $MndtIdNode->nodeValue          = $payment['mandate_id'];
        $DtOfSgntrNode->nodeValue       = $payment['mandate_date'];
        $BIC_DbtrAgt_Node->nodeValue    = $payment['BIC'];
        $Nm_Dbtr_Node->nodeValue        = htmlentities($payment['name'], ENT_QUOTES);
        $IBAN_DbtrAcct_Node->nodeValue  = $payment['IBAN'];
        $UstrdNode->nodeValue           = htmlentities($payment['description'], ENT_QUOTES);
        $EndToEndIdNode->nodeValue      = $this->makeId();
        
        //Fold the nodes, if batch is enabled, some of this will be done by the batch.
        if($this->config['batch'] == false){
            $PmtInfNode->appendChild($PmtInfIdNode);
            $PmtInfNode->appendChild($PmtMtdNode);
            $PmtInfNode->appendChild($BtchBookgNode);
            $PmtInfNode->appendChild($NbOfTxsNode);
            $PmtInfNode->appendChild($CtrlSumNode);
   
                    $SvcLvlNode->appendChild($Cd_SvcLvl_Node);
                $PmtTpInfNode->appendChild($SvcLvlNode);
                    $LclInstrmNode->appendChild($Cd_LclInstrm_Node);
                $PmtTpInfNode->appendChild($LclInstrmNode);
                $PmtTpInfNode->appendChild($SeqTpNode);
            $PmtInfNode->appendChild($PmtTpInfNode);
            $PmtInfNode->appendChild($ReqdColltnDtNode);
            
                $CdtrNode->appendChild($Nm_Cdtr_Node);
            $PmtInfNode->appendChild($CdtrNode);
            
                    $Id_CdtrAcct_Node->appendChild($IBAN_CdtrAcct_Node);
                $CdtrAcctNode->appendChild($Id_CdtrAcct_Node);
            $PmtInfNode->appendChild($CdtrAcctNode);
            
                    $FinInstnId_CdtrAgt_Node->appendChild($BIC_CdtrAgt_Node);
                $CdtrAgtNode->appendChild($FinInstnId_CdtrAgt_Node);
            $PmtInfNode->appendChild($CdtrAgtNode);
            
            $PmtInfNode->appendChild($ChrgBrNode);
            
                $CdtrSchmeIdNode->appendChild($Nm_CdtrSchmeId_Node);            
                            $OthrNode->appendChild($Id_Othr_Node);
                                $SchmeNmNode->appendChild($PrtryNode);
                            $OthrNode->appendChild($SchmeNmNode);
                        $PrvtIdNode->appendChild($OthrNode);
                    $Id_CdtrSchmeId_Node->appendChild($PrvtIdNode);
                $CdtrSchmeIdNode->appendChild($Id_CdtrSchmeId_Node);
            $PmtInfNode->appendChild($CdtrSchmeIdNode);
            
                    
        }
                $PmtIdNode->appendChild($EndToEndIdNode);    
        
            $DrctDbtTxInfNode->appendChild($PmtIdNode);     
            $DrctDbtTxInfNode->appendChild($InstdAmtNode);
            
                    $MndtRltdInfNode->appendChild($MndtIdNode);
                    $MndtRltdInfNode->appendChild($DtOfSgntrNode);
                $DrctDbtTxNode->appendChild($MndtRltdInfNode);
            $DrctDbtTxInfNode->appendChild($DrctDbtTxNode);
            
            if ( isset( $payment['BIC'] ) ) {
                    	$FinInstnId_DbtrAgt_Node->appendChild($BIC_DbtrAgt_Node);
                	$DbtrAgtNode->appendChild($FinInstnId_DbtrAgt_Node);
            	$DrctDbtTxInfNode->appendChild($DbtrAgtNode);
            }
                $DbtrNode->appendChild($Nm_Dbtr_Node);
            $DrctDbtTxInfNode->appendChild($DbtrNode);
            
                    $Id_DbtrAcct_Node->appendChild($IBAN_DbtrAcct_Node);
                $DbtrAcctNode->appendChild($Id_DbtrAcct_Node); 
            $DrctDbtTxInfNode->appendChild($DbtrAcctNode);
                
                $RmtInfNode->appendChild($UstrdNode);
            $DrctDbtTxInfNode->appendChild($RmtInfNode);
            
                       $PmtIdNode->appendChild($EndToEndIdNode);

        
        if($this->config['batch'] == false){
            
            //Add to the document
            $PmtInfNode->appendChild($DrctDbtTxInfNode);
            $CstmrDrctDbtInitnNode->appendChild($PmtInfNode);
        }else{
            //Update the batch metrics
            $batch['ctrlSum']->nodeValue += $payment['amount'];
            $batch['nbOfTxs']->nodeValue++;
            
            //Add to the batch
            $batch['node']->appendChild($DrctDbtTxInfNode);
        }
           
    }//addPayment
    
    /**
     * Function to finalize and save the document after all payments are added.
     * @return The XML to be echoed or saved to file.
     */
    public function save(){
        $this->finalize();
        $result = $this->xml->saveXML();
        return $result;
    }//save
    
    /**
     * Function to validate xml against the pain.008.001.02 schema definition.
     * @param $xml The xml, as a string, to validate agianst the schema.
     */
    public function validate($xml){
        $domdoc = new DOMDocument();
        $domdoc->loadXML($xml);
        return $domdoc->schemaValidate("pain.008.001.02.xsd");
    }//validate
        

    /**
     * Function to add a custom node to the document.
     * @param $parent_XPATH A valid XPATH expression defining the parent of the new node
     * @param $name The name of the new node
     * @param $value The value of the new node (Optional, default "")
     * @param $attr Key => Value array defining the attributes (Optional, default none)
     */
    public function addCustomNode($parent_XPATH, $name, $value = "", $attr = array() ){
        $xpath = new DOMXPath($this->xml);
        $parent = $xpath->query($parent_XPATH);
        if ( $parent == false || $parent->length == 0 ) {
            throw new Exception("Invalid XPATH expression, or no results found: ".$parent_XPATH);
        }
        $newnode = $this->xml->createElement($name);
        if ( $value != "" ) {
            $newnode->nodeValue = $value;
        }
        if ( !empty($attr) ) {
            foreach($attr as $attr_name => $attr_value){
                $newnode->setAttribute($attr_name, $attr_value);
            }
        }
        $parent->item(0)->appendChild($newnode);
    }//addCustomNode
    
    /**
     * Function to finalize the document, completes the header with metadata, and processes batches.
     */
    private function finalize(){
        if ( !empty( $this->batchArray ) ) {
            $CstmrDrctDbtInitnNode = $this->getCstmrDrctDbtInitnNode();
            foreach ( $this->batchArray as $batch ){
                $batch['ctrlSum']->nodeValue = $this->intToDecimal($batch['ctrlSum']->nodeValue);
                $CstmrDrctDbtInitnNode->appendChild($batch['node']);
            }
        }
        

        $trxCount = $this->xml->getElementsByTagName("DrctDbtTxInf");
        $trxCount = $trxCount->length;
        $trxAmounts = $this->xml->getElementsByTagName("InstdAmt");
        $trxAmountArray = array();
        foreach ( $trxAmounts as $amount ){
            $trxAmountArray[] = $amount->nodeValue;
        }
        $trxAmount = $this->calcTotalAmount($trxAmountArray);
        $xpath = new DOMXPath($this->xml);
        $NbOfTxs_XPATH = "//Document/CstmrDrctDbtInitn/GrpHdr/NbOfTxs";
        $CtrlSum_XPATH = "//Document/CstmrDrctDbtInitn/GrpHdr/CtrlSum";
        $NbOfTxsNode = $xpath->query($NbOfTxs_XPATH)->item(0);
        $CtrlSumNode = $xpath->query($CtrlSum_XPATH)->item(0);
        
        $NbOfTxsNode->nodeValue = $trxCount;
        $CtrlSumNode->nodeValue = $trxAmount;
        
    }//finalize
    
    /**
     * Check the config file for required fields and validity.
     * NOTE: A function entry in this field will NOT be evaluated if the field is not present in the
     * config array. If this is necessary, please include it in the $required array as well.
     * @param $config the config to check.
     * @return TRUE if valid, error string if invalid.
     */
    private function validateConfig($config){
        $required = array("name",
                          "IBAN",
                          "batch",
                          "creditor_id",
                          "currency");
        $functions = array("IBAN" => "validateIBAN",
                           "BIC" => "validateBIC");
        
        foreach ( $required as $requirement ) {
            //Check if the config has the required parameter
            if ( array_key_exists($requirement,$config) ) {
                //It exists, check if not empty
                if ( empty($config[$requirement]) ){
                    return $requirement." is empty.";
                }
            }else{
                return $requirement." does not exist.";
            }
            
        }
        
        foreach ( $functions as $target => $function ){
            //Check if it is even there in the config
            if ( array_key_exists($target,$config) ) {
                //Perform the RegEx
                $function_result = call_user_func("SEPASDD::".$function,$config[$target]);
                if ( $function_result ){
                    continue;
                }else{
                    return $target." does not validate.";
                }
            }  
            
        }
        
        return true;
    }//checkConfig
    
    /**
     * Check a payment for validity
     * @param $payment The payment array
     * @return TRUE if valid, error string if invalid.
     */
    private function validatePayment($payment){
        $required = array("name",
                          "IBAN",
                          "amount",
                          "type",
                          "collection_date",
                          "mandate_id",
                          "mandate_date",
                          "description");
        $functions = array("IBAN" => "validateIBAN",
                           "BIC" => "validateBIC",
                           "amount" => "validateAmount",
                           "collection_date" => "validateDate",
                           "mandate_date" => "validateDate",
                           "type" => "validateDDType");
        
        foreach ( $required as $requirement ) {
            //Check if the config has the required parameter
            if ( array_key_exists($requirement,$payment) ) {
                //It exists, check if not empty
                if ( empty($payment[$requirement]) ){
                    return $requirement." is empty.";
                }
            }else{
                return $requirement." does not exist.";
            }
            
        }
        
        foreach ( $functions as $target => $function ){
            //Check if it is even there in the config
            if ( array_key_exists($target,$payment) ) {
                //Perform the RegEx
                $function_result = call_user_func("SEPASDD::".$function,$payment[$target]);
                
                if ( $function_result ){
                    
                    continue;
                }else{
                   
                    return $target." does not validate.";
                }
            }  
            
        }
        
        return true;
    }//validatePayment
    
    /**
     * Validate an IBAN Number.
     * @param $IBAN the IBAN number to check.
     * @return BOOLEAN TRUE if valid, FALSE if invalid.
     */
    public static function validateIBAN($IBAN){
        $result = preg_match("/[a-zA-Z]{2}[0-9]{2}[a-zA-Z0-9]{4}[0-9]{7}([a-zA-Z0-9]?){0,16}/",$IBAN);
        if ( $result > 0 && $result !== false){
            return true;
        }else{
            return false;
        }
    }//validateIBAN
     
    /**
     * Validate a BIC number.Payment Information 
     * @param $BIC the BIC number to check.
     * @return TRUE if valid, FALSE if invalid.
     */
    public static function validateBIC($BIC){
        $result = preg_match("([a-zA-Z]{4}[a-zA-Z]{2}[a-zA-Z0-9]{2}([a-zA-Z0-9]{3})?)",$BIC);
        if ( $result > 0 && $result !== false){
            return true;
        }else{
            return false;
        }
    }//validateBIC
    
    /**
     * Function to validate a ISO date.
     * @param $date The date to validate.
     * @return True if valid, error string if invalid.
     */
    public static function validateDate($date){
        echo $date;
        $result = DateTime::createFromFormat("Y-m-d",$date);
        echo 'sdfds'; die(); 
        if($result === false){
            return false;
        }else{
            return $date." is not a valid ISO Date";
        }
    }//checkDate
    
    /**
     * Function to validate the Direct Debit Transaction types
     * @param Typecode
     * @return True if valid, error string if invalid.
     */
    public static function validateDDType($type){
        $types = array("FRST",
                       "RCUR",
                       "FNAL",
                       "OOFF");
        if(in_array($type,$types)){
            return true;
        }else{
            return $type." is not a valid Sepa Direct Debit Transaction Type.";
        }
    }//validateDDType
    
    /**
     * Function to validate an amount, to check that amount is in cents.
     * @param $amount The amount to validate.
     * @return TRUE if valid, FALSE if invalid.
     */
    public static function validateAmount($amount){
        return ctype_digit($amount);
    }//validateAmount
    
    /**
     * Function to convert an amount in cents to a decimal (with point).
     * @param $int The amount as decimal string
     * @return The decimal
     */
    private function intToDecimal($int){
        $before = substr($int, 0, -2);
        $after = substr($int, -2);
        if( empty($before) ){
        	$before = 0;
        }
        if( strlen($after) == 1 ){
        	$after = "0".$after;
        }
        return $before.".".$after;
    }//intToDecimal
    
    /**
     * Function to convert an amount in decimal to cents (without point).
     * @param $decimal The amount as decimal
     * @return The amount as integer string
     */
    private function decimalToInt($decimal){
        return str_replace(".","",$decimal);
    }//decimalToInt
    
    /**
     * Function to calculate the sum of the amounts, given as decimals in an array.
     * @param $array The array with decimals
     * @return The decimal sum of the array
     */
    private function calcTotalAmount($array){
        $ints = array();
        $sum = 0;
        foreach($array as $decimal){
            $ints[] = $this->decimalToInt($decimal);
        }
        $sum = array_sum($ints);
        $sum = $this->intToDecimal($sum);
        return $sum;
    }//calcTotalAmount
    
    /**
     * Create a random Message Id f$PmtInfNodeor the header, prefixed with a timestamp.
     * @return the Message Id.
     */
    private function makeMsgId(){
        $random = mt_rand();
        $random = md5($random);
        $random = substr($random,0,12);
        $timestamp = date("dmYsi");
        return $timestamp."-".$random;
    }//makeMsgId
    
    /**
     * Create a random id, combined with the name (truncated at 22 chars).
     * @return the Id.
     */
    private function makeId(){
        $random = mt_rand();
        $random = md5($random);
        $random = substr($random,0,12);
        $name = $this->config['name'];
        $length = strlen($name);
        if($length > 22){
            $name = substr($name,0,22);
        }
        return $name."-".$random;
    }//makeId
    
    /**
     * Function to get the CstmrDrctDbtInitnNode from the current document.
     * @return The CstmrDrctDbtInitn DOMNode.
     * @throws Exception when the node does noet exist or there are more then one.
     */
    private function getCstmrDrctDbtInitnNode(){
        $CstmrDrctDbtInitnNodeList = $this->xml->getElementsByTagName("CstmrDrctDbtInitn");
        if ( $CstmrDrctDbtInitnNodeList->length != 1 ) {
            throw new Exception("Error retrieving node from document: No or Multiple CstmrDrctDbtInitn");
        }
        return $CstmrDrctDbtInitnNodeList->item(0);
    }//getCstmrDrctDbtInitnNode
    
    /**
     * Function to create a batch (PmtInf with BtchBookg set true) element.
     * @param $type The DirectDebit type for this batch.
     * @param $date The required collection date.
     */
    private function getBatch($type,$date){
        
        //If the batch for this type and date already exists, return it.
        if($this->validateDDType($type) && 
           $this->validateDate($date) && 
           array_key_exists($type."::".$date,$this->batchArray)
           ){
            return $this->batchArray[$type."::".$date];
        }
        
        //Create the PmtInf element and its subelements
        $PmtInfNode             = $this->xml->createElement("PmtInf");
        $PmtInfIdNode           = $this->xml->createElement("PmtInfId");
        $PmtMtdNode             = $this->xml->createElement("PmtMtd");
        $BtchBookgNode          = $this->xml->createElement("BtchBookg");
        $NbOfTxsNode            = $this->xml->createElement("NbOfTxs");
        $CtrlSumNode            = $this->xml->createElement("CtrlSum");
        $PmtTpInfNode           = $this->xml->createElement("PmtTpInf");
        $SvcLvlNode             = $this->xml->createElement("SvcLvl");
        $Cd_SvcLvl_Node         = $this->xml->createElement("Cd");
        $LclInstrmNode          = $this->xml->createElement("LclInstrm");
        $Cd_LclInstrm_Node      = $this->xml->createElement("Cd");
        $SeqTpNode              = $this->xml->createElement("SeqTp");
        $ReqdColltnDtNode       = $this->xml->createElement("ReqdColltnDt");
        $CdtrNode               = $this->xml->createElement("Cdtr");
        $Nm_Cdtr_Node           = $this->xml->createElement("Nm");
        $CdtrAcctNode           = $this->xml->createElement("CdtrAcct");
        $Id_CdtrAcct_Node       = $this->xml->createElement("Id");
        $IBAN_CdtrAcct_Node     = $this->xml->createElement("IBAN");
        if ( isset( $this->config['BIC'] ) ) {
        	$CdtrAgtNode            = $this->xml->createElement("CdtrAgt");
        	$FinInstnId_CdtrAgt_Node= $this->xml->createElement("FinInstnId");
        	$BIC_CdtrAgt_Node       = $this->xml->createElement("BIC");
        }
        $ChrgBrNode             = $this->xml->createElement("ChrgBr");
        $CdtrSchmeIdNode        = $this->xml->createElement("CdtrSchmeId");
        $Nm_CdtrSchmeId_Node    = $this->xml->createElement("Nm");
        $Id_CdtrSchmeId_Node    = $this->xml->createElement("Id");
        $PrvtIdNode             = $this->xml->createElement("PrvtId");
        $OthrNode               = $this->xml->createElement("Othr");
        $Id_Othr_Node           = $this->xml->createElement("Id");
        $SchmeNmNode            = $this->xml->createElement("SchmeNm");
        $PrtryNode              = $this->xml->createElement("Prtry");
        
        //Fill in the blanks
        $PmtInfIdNode->nodeValue        = $this->makeId();
        $PmtMtdNode->nodeValue          = "DD"; //Direct Debit
        $BtchBookgNode->nodeValue       = "true";
        $CtrlSumNode->nodeValue         = "0";
        $Cd_SvcLvl_Node->nodeValue      = "SEPA";
        $Cd_LclInstrm_Node->nodeValue   = "CORE";
        $SeqTpNode->nodeValue           = $type; //Define a check for: FRST RCUR OOFF FNAL
        $ReqdColltnDtNode->nodeValue    = $date; 
        $Nm_Cdtr_Node->nodeValue        = htmlentities($this->config['name'], ENT_QUOTES);
        $IBAN_CdtrAcct_Node->nodeValue  = $this->config['IBAN'];
        if ( isset( $this->config['BIC'] ) ) {
        	$BIC_CdtrAgt_Node->nodeValue    = $this->config['BIC'];
        }
        $ChrgBrNode->nodeValue          = "SLEV";
        $Nm_CdtrSchmeId_Node->nodeValue = htmlentities($this->config['name'], ENT_QUOTES);
        $Id_Othr_Node->nodeValue        = $this->config['creditor_id'];
        $PrtryNode->nodeValue           = "SEPA";
        
        //Fold the batch information
        $PmtInfNode->appendChild($PmtInfIdNode);
        $PmtInfNode->appendChild($PmtMtdNode);
        $PmtInfNode->appendChild($BtchBookgNode);
        $PmtInfNode->appendChild($NbOfTxsNode);
        $PmtInfNode->appendChild($CtrlSumNode);
        
                $SvcLvlNode->appendChild($Cd_SvcLvl_Node);
            $PmtTpInfNode->appendChild($SvcLvlNode);
                $LclInstrmNode->appendChild($Cd_LclInstrm_Node);
            $PmtTpInfNode->appendChild($LclInstrmNode);
            $PmtTpInfNode->appendChild($SeqTpNode);
        $PmtInfNode->appendChild($PmtTpInfNode);
        $PmtInfNode->appendChild($ReqdColltnDtNode);
        
            $CdtrNode->appendChild($Nm_Cdtr_Node);
        $PmtInfNode->appendChild($CdtrNode);
        
                $Id_CdtrAcct_Node->appendChild($IBAN_CdtrAcct_Node);
            $CdtrAcctNode->appendChild($Id_CdtrAcct_Node);
        $PmtInfNode->appendChild($CdtrAcctNode);
        
        if ( isset( $this->config['BIC'] ) ) {
                	$FinInstnId_CdtrAgt_Node->appendChild($BIC_CdtrAgt_Node);
            	$CdtrAgtNode->appendChild($FinInstnId_CdtrAgt_Node);
        	$PmtInfNode->appendChild($CdtrAgtNode);
        }
        $PmtInfNode->appendChild($ChrgBrNode);
        
            $CdtrSchmeIdNode->appendChild($Nm_CdtrSchmeId_Node);            
                        $OthrNode->appendChild($Id_Othr_Node);
                            $SchmeNmNode->appendChild($PrtryNode);
                        $OthrNode->appendChild($SchmeNmNode);
                    $PrvtIdNode->appendChild($OthrNode);
                $Id_CdtrSchmeId_Node->appendChild($PrvtIdNode);
            $CdtrSchmeIdNode->appendChild($Id_CdtrSchmeId_Node);
        $PmtInfNode->appendChild($CdtrSchmeIdNode);
        
        //Add it to the batchArray.       
        $this->batchArray[$type."::".$date]['node'] = $PmtInfNode;
        $this->batchArray[$type."::".$date]['ctrlSum'] = $CtrlSumNode;
        $this->batchArray[$type."::".$date]['nbOfTxs'] = $NbOfTxsNode;
        
        //Return the batch array for this type and date.
        return $this->batchArray[$type."::".$date];
    }//getBatch
}
?>