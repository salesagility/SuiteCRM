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

class SEPEgetter {

    /**
     * These are the dropdown lists used in the modules, with the items defined by SEPE in some of the fields needed.
     * If there is an update in a list, it will need to be updated here as well
     *
     * @var array
     */
    protected $NIVEL_FORMATIVO_LIST = array(
        0 => '00',
        1 => '10',
        2 => '20',
        3 => '30'
    );
    protected $TIPO_CONTRATO_AC_LIST = array(
        0 => '001',
        1 => '003',
        2 => '005',
        3 => '401',
        4 => '501'
    );
    protected $TIPO_CONTRATO_ACCD_LIST = array(
        0 => '001',
        1 => '002',
        2 => '003',
        3 => '004',
        4 => '005',
    );
    protected $TIPO_ACCION_LIST = array(
        0 => "I",
        1 => "E",
        2 => "O",
        3 => "F",
        4 => "M"
    );
    protected $TIPO_INCIDENCIA_LIST = array(
        0 => "I01",
        1 => "I02",
        2 => "I03",
        3 => "I04",
        4 => "Z01",
        5 => "Z02",
        6 => "Z03",
    );
    protected $SEXO_TRABAJADOR_LIST = array(
        0 => '1',
        1 => '2',
    );

    protected $errorsArray = array();
    protected $warningsArray = array();

    /**
     * It gets, normalize and validate all the necessary information from the database to build the AC monthly file.
     *
     * @param integer $month
     * @param integer $year
     * @return $rowsData Individual daya array
     */
    public function getMonthlyACIndividual($month, $year){
        $rowsData = array();
        require "modules/stic_Sepe_Files/utils/FieldsDef.php";

        // Building SQL queries using the class SQLBuilder
        require_once 'modules/stic_Sepe_Files/utils/SQLbuilder.php';
        $SQLbuilder = new SQLbuilder();
        $sqlQueries = $SQLbuilder->getQueryMonthlyAC($month, $year, $defACindividual, $defACindividualCol);
        $GLOBALS['log']->debug('Line '.__LINE__.': '.__METHOD__.': '." Query AC Individual", $sqlQueries);
        // Running the queries
        $db = DBManagerFactory::getInstance();
        foreach ($sqlQueries as $query) {
            $query_data = $db->query($query);
            while ($row = $db->fetchByAssoc($query_data)) {
                // The data needs to be normalized
                $rowsData[] = $this->normalizeData($row);
            }
        }

        // Checking if the data follows the correct pattern
        $this->validateData($rowsData, array_merge($defACindividual, $defColocacion, $defACindividualCol));
        return $rowsData;
    }

    /**
     * It gets all the information to build the aggregated data.
     *
     * Before getting the data, it runs some validations queries to the CRM, checking if there is any inconsistency in the data.
     * Such as Contacts with SEPE activated Job Offers but without SEPE activation Actions, or the opposite. If there is any, the log
     * will be displayed on the UI
     * 
     * @param integer $month
     * @param integer $year
     * @param integer $type Used to define if the file is AC or ACCD
     * @return $rowsData
     */
    public function getAggregated($type, $year, $month = false, $agreement = false){
        $rowsData = array();
        require "modules/stic_Sepe_Files/utils/FieldsDef.php";

        // Runs the validation queries
        $this->dataConsistencyValidation($year, $month, $agreement);

        // Building SQL queries using the class SQLBuilder
        require_once 'modules/stic_Sepe_Files/utils/SQLbuilder.php';
        $SQLbuilder = new SQLbuilder();
        $sqlQueries = $SQLbuilder->getQueryAggregated($type, $year, $month, $agreement);
        $GLOBALS['log']->debug('Line '.__LINE__.': '.__METHOD__.': '." Query Aggregated", $sqlQueries);

        // Running queries
        $db = DBManagerFactory::getInstance();
        foreach ($sqlQueries as $query) {
            $query_data = $db->query($query);
            foreach ($db->fetchByAssoc($query_data) as $key =>$row) {
                // In this case the data doesn't need to be normalized because it is just digits
                $rowsData[$key] = $row;
            }
        }
        return $rowsData;
    }
    /**
     * It gets, normalize and validate all the necessary information from the database to build the ACCD monthly file.
     * 
     * In this case, the fields array used are both from AC and ACCD
     *
     * @param integer $month
     * @param integer $year
     * @param string $agreement
     * @return $rowsData Individual daya array
     */
    public function getMonthlyACCDIndividual($month, $year, $agreement){
        $rowsData = array();
        require "modules/stic_Sepe_Files/utils/FieldsDef.php";

        // Merging the fields used in this file type
        $ACCDindividual = array_merge($defACindividual, $defACCDindividual);

        // Building SQL queries using the class SQLBuilder
        require_once 'modules/stic_Sepe_Files/utils/SQLbuilder.php';
        $SQLbuilder = new SQLbuilder();
        $sqlQueries = $SQLbuilder->getQueryMonthlyACCD($month, $year,$agreement, $ACCDindividual, $defACCDactions, $defACCDindividualCol);
        $GLOBALS['log']->debug('Line '.__LINE__.': '.__METHOD__.': '." Query ACCD Individual", $sqlQueries);
       
        // Running queries
        $db = DBManagerFactory::getInstance();
        foreach ($sqlQueries as $query) {
            $query_data = $db->query($query);
            while ($row = $db->fetchByAssoc($query_data)) {
                // The data needs to be normalized
                $rowsData[] = $this->normalizeData($row, true);
            }
        }

        // Checking if the data follows the correct pattern
        $this->validateData($rowsData, array_merge($ACCDindividual, $defACCDactions, $defColocacion, $defACCDindividualCol));

        // Regrouping the records by contact
        return $this->regroupedRecords($rowsData);
    }

    /**
     * It gets, normalize and validate all the necessary information from the database to build the ACCI monthly file.
     * 
     * Before getting the data, it runs some validations queries to the CRM, checking if there is any inconsistency in the data.
     * Such as Contacts with SEPE activated Job Offers but without SEPE activation Actions, or the opposite. If there is any, the log
     * will be displayed on the UI
     *
     * @param integer $month
     * @param integer $year
     * @param string $agreement
     * @return $rowsData Individual daya array
     */
    public function getMonthlyACCI($month, $year, $agreement) {
        $rowsData = array();
        require "modules/stic_Sepe_Files/utils/FieldsDef.php";

        // Runs the validation queries
        $this->dataConsistencyValidation($year, $month, $agreement, true);

        // Building SQL queries using the class SQLBuilder
        require_once 'modules/stic_Sepe_Files/utils/SQLbuilder.php';
        $SQLbuilder = new SQLbuilder();
        $sqlQuery = $SQLbuilder->getQueryMonthlyACCI($month, $year, $agreement, $defACCI);
        $GLOBALS['log']->debug('Line '.__LINE__.': '.__METHOD__.': '." Query ACCD Individual", $sqlQuery);

        // Running queries
        $db = DBManagerFactory::getInstance();
        $queryData = $db->query($sqlQuery);
        while ($row = $db->fetchByAssoc($queryData)) {
            $rowsData[] = $this->normalizeData($row);
        }
        return $rowsData;
    }

    /**
     * Regroup all actions from the same person on the ACCD files.
     *
     * @param array $dataArray
     * @return $groupedArray
     */
    protected function regroupedRecords($dataArray) {
        $groupedArray = array();
        foreach($dataArray as $data) {
            $key = $data['Contacts'];
            if (array_key_exists($key, $groupedArray)) {
                if ($data['COLOCACION'] === 'S') {
                    if ($groupedArray[$key]['COLOCACION'] === 'S') {
                        $groupedArray[] = $data;
                    } else {
                        $data['ACCION'] = $groupedArray[$key]['ACCION'];
                        $groupedArray[$key] = $data;
                    }
                } else {
                    $groupedArray[$key]['ACCION'][] = array(
                        'TIPO_ACCION' => $data['TIPO_ACCION'],
                        'FECHA_INICIO_ACCION' => $data['FECHA_INICIO_ACCION'],
                        'FECHA_FINAL_ACCION' => $data['FECHA_FINAL_ACCION'],
                    );
                }   
            } else {
                if ($data['COLOCACION'] === 'S') {
                    $groupedArray[$key] = $data;
                } else {
                    $groupedArray[$key] = $data;
                    $groupedArray[$key]['ACCION'][] = array(
                        'TIPO_ACCION' => $data['TIPO_ACCION'],
                        'FECHA_INICIO_ACCION' => $data['FECHA_INICIO_ACCION'],
                        'FECHA_FINAL_ACCION' => $data['FECHA_FINAL_ACCION'],
                    );
                    unset($groupedArray[$key]['TIPO_ACCION']);
                    unset($groupedArray[$key]['TIPO_ACCION']);
                    unset($groupedArray[$key]['TIPO_ACCION']);
                }
            }
        }
        return $groupedArray;
    }

    /**
     * Normalize all data obtained from the database. Removing and replacing simbols or other characters
     * not allowed by the SEPE XML convention.
     * 
     * It also adapt those list that might be different between file types or CRM-SEPE
     *
     * @param array $individualData
     * @param boolean $isACCD 
     * @return $normalizeData
     */
    protected function normalizeData($individualData, $isACCD = false) {
        $normalizeData = array();
        include "modules/stic_Sepe_Files/utils/TransformedLists.php";
        foreach ($individualData as $key => $value) {
            // Specify the locale used in this conversion, and converts simbols and other characters.
            setlocale(LC_ALL, 'es_ES');
            $transSentence = iconv('UTF-8', 'ASCII//TRANSLIT', $value);      
            // If any of the items is on this list, it will be transformed.           
            switch($key) {
                case 'SEXO_TRABAJADOR':
                    $transSentence = $SEXO_TRABAJADOR[$value] ? $SEXO_TRABAJADOR[$value] : $value;
                break;
                case 'TIPO_CONTRATO':
                    if ($isACCD){
                        $transSentence = $TIPO_CONTRATO[$value] ? $TIPO_CONTRATO[$value] : $value;
                    }
                break;

            }     
            $normalizeData[$key] = $transSentence; 
        }
        return $normalizeData;
    }

    /**
     * Validates the data obtained from the database, it uses validation parameters defined in the definition arrays:
     * Required: If the field isn't empty
     * Pattern: If the value strictly matches a regex pattern
     * Pattern2: Some fields have 2 regex patterns
     * Length: Characters limit in a field
     * 
     * @param array $rowsData An array of contacts and their parameters
     * @param array $defData - An array containing the validation from each contact parameter
     * @return $valid_data - True if valid, -1 if error
     */
    protected function validateData($rowsData, $defData){
        global $mod_strings;

        // Loops through each of the contacts
        foreach($rowsData as $infoIndiv) {

            // Then loops through the data inside each contact
            foreach($infoIndiv as $key => $value) {

                // And checks which validation is required for each parameter
                $validationParams = $defData[$key][3];

                // If the parameter is required and it isn't present, we don't need to continue
                if ($validationParams['required'] && !$value) {
                    $errorMsg = $this->buildError($defData[$key][4], $defData[$key][1], $infoIndiv[$defData[$key][4]], $mod_strings['LBL_ERROR_SEPE_REQUIRED']);
                    $this->errorsArray[] = $errorMsg;
                }
                else if ($value) {

                    // Checking if the value follows the pattern defined in the parameter defition
                    if ($validationParams['pattern'] && !preg_match($validationParams['pattern'], $value)) {
                        // Alternative pattern
                        if ($validationParams['pattern2']) {
                            if (!preg_match($validationParams['pattern2'], $value)) {
                                $errorMsg = $this->buildError($defData[$key][4], $defData[$key][1], $infoIndiv[$defData[$key][4]], $mod_strings['LBL_ERROR_SEPE_PATTERN']);
                                $this->errorsArray[] = $errorMsg;   
                            }
                        } else {
                            $errorMsg = $this->buildError($defData[$key][4], $defData[$key][1], $infoIndiv[$defData[$key][4]], $mod_strings['LBL_ERROR_SEPE_PATTERN']);
                            $this->errorsArray[] = $errorMsg;
                        }
                    }

                    // If the parameter is a DropDown list, check if it's an expected element
                    if ($defData[$key][2] === 'list') {
                        $list = $validationParams['validationList'];
                        if (!in_array($value, $this->$list)){
                            $errorMsg = $this->buildError($defData[$key][4], $defData[$key][1], $infoIndiv[$defData[$key][4]], $mod_strings['LBL_ERROR_SEPE_NOT_IN_LIST']);
                            $this->errorsArray[] = $errorMsg;
                        }
                    }

                    // Checking the length of the parameter
                    if ($validationParams['length'] != 0 && $validationParams['length'] < strlen($value)) {
                        $errorMsg = $this->buildError($defData[$key][4], $defData[$key][1], $infoIndiv[$defData[$key][4]], $mod_strings['LBL_ERROR_SEPE_LENGTH_EXCEEDED']);
                        $this->errorsArray[] = $errorMsg;            
                    }
                }
            }
        }
    }


    /**
     * It is used to validate the consistency of the data in the CRM. Some of the conditions are defined in SQLbuilder
     * If the queries return any value, it will be added in the warning array to be shown in the errors_log of the screen
     * 
     *
     * @param integer $month
     * @param integer $year
     * @param string $agreement
     * @param boolean $acci
     * @return void
     */
    protected function dataConsistencyValidation($year, $month = false, $agreement = false, $acci = false) {
        global $mod_strings;

        // Building queries
        require_once 'modules/stic_Sepe_Files/utils/SQLbuilder.php';
        $SQLbuilder = new SQLbuilder();
        $sqlQueries = $SQLbuilder->dataConsistencyValidationQueries($year, $month, $agreement, $acci);
        $GLOBALS['log']->debug('Line '.__LINE__.': '.__METHOD__.': '." Query Data Consistency Validation", $sqlQueries);
        
        // Running queries
        $db = DBManagerFactory::getInstance();
        foreach($sqlQueries as $key => $query) {
            $queryData = $db->query($query['query']);
            while ($row = $db->fetchByAssoc($queryData)) {
                $this->warningsArray[] = $mod_strings['LBL_WARNING_'.$key]. $row['NAME'].' - '.$this->createLinkToView($query['module'], $row['ID'], $mod_strings['LBL_ERRORS_SEPE_CHECK'], 'DetailView');           
            }
        }
    }
    
    /**
     * Builds an standarized error message including the link of the record
     * 
     * @param string $module
     * @param string $field
     * @param string $beanId
     * @param string $error
     * 
     * @return $errorMsg
     */
    protected function buildError ($module, $field, $beanId, $error) {
        global $mod_strings, $app_list_strings;
        $bean = BeanFactory::getBean($module, $beanId);
        $fieldLabel = translate($bean->field_defs[$field]['vname'], $module);
        $moduleName = $app_list_strings['moduleList'][$module];
        return $error.'"'.$fieldLabel.'"'.' ('.$moduleName.') - '.$bean->name.' - '.$this->createLinkToView($module, $beanId, $mod_strings['LBL_ERRORS_SEPE_CHECK']);             
    }

    /**
     * Creates a link to EditView/DetailView, specifying the module, ID and the text of the link
     *
     * @param string $module
     * @param string $id
     * @param string $text
     * @return htmllink
     */
    protected function createLinkToView ($module, $id, $text, $view = 'EditView') {	
        global $sugar_config;
		$siteUrl = rtrim($sugar_config['site_url'],"/");	// Removes / char if exists (will be added later)
		return "<a target='_blank' href=\"{$siteUrl}/index.php?module={$module}&action=$view&record={$id}\">$text</a>";
    }

    /**
     * Return the errors from the data validation.
     *
     * @return $errorsArray
     */
    public function getErrors(){
        return $this->errorsArray;
    }
    public function getWarnings(){
        return $this->warningsArray;
    }
}
