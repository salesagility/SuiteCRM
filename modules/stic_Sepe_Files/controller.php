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

class stic_Sepe_FilesController extends SugarController
{
    protected $fileName = '';
    protected $params = array();
    protected $patternAgreement = "/(0[0-9]|1[0-7]|9[9])CONV\d{4}/";
         

    /**
     * This function is called using the action buttons of the DetailView
     * 
     * It checks the setting selected by the user and calls the functions accordingly
     *
     * @return void
     */
    public function action_generateSepeFile()
    {
        global $app_list_strings;
        global $mod_strings;
        $this->start = microtime(true);
        require_once 'modules/stic_Sepe_Files/utils/XMLgenerator.php';
        require_once 'modules/stic_Sepe_Files/utils/SEPEgetter.php';
        require_once 'modules/stic_Settings/Utils.php';
        require_once 'SticInclude/Utils.php';


        // Getting the CODIGO_AGENCIA Settings
        $this->params['CODIGO_AGENCIA'] = stic_SettingsUtils::getSetting('SEPE_CODIGO_AGENCIA');
        if (!is_numeric($this->params['CODIGO_AGENCIA']) || strlen((string)$this->params['CODIGO_AGENCIA']) != 10) {
            SticUtils::showErrorMessagesAndDie($this, $mod_strings['LBL_ERROR_SEPE_CODIGO_AGENCIA'] . ' <br>SEPE_CODIGO_AGENCIA');
        }

        // Getting the selected absolute month
        $date = $this->bean->fetched_row['reported_month'];
        $month = date("n", strtotime($date));
        $year = date("Y", strtotime($date));
        if (($month > date("n") && $year >= date("Y")) || $year > date("Y")) {
            SticUtils::showErrorMessagesAndDie($this, $mod_strings['LBL_ERROR_DATE_FUTURE'] . ' <br>'.$mod_strings['LBL_REPORTED_MONTH']);
        }

        // Get the file type selected, if it's annual, the month is set to 99
        $fileType = $this->bean->type;
        if ($fileType == 'annual_ac' || $fileType == 'annual_accd') {
            $month = 99;
        }

        // Building the XML param AÑO_MES_ENVIO
        if (strlen($month) === 1) {
            $this->params['AÑO_MES_ENVIO'] = $year.'0'.$month;
        } else {
            $this->params['AÑO_MES_ENVIO'] = $year.$month;
        }

        // Building the result filename
        $this->fileName = str_replace(' ', '_', $app_list_strings['stic_sepe_file_types_list'][$fileType]).($this->bean->agreement ? '_'.$this->bean->agreement : '').'_'.$year.'_'.str_pad($month, 2, 0, STR_PAD_LEFT).'.xml';

        // Selecting function for creating the file
        switch($fileType) {
            case 'annual_ac': 
                $this->annualAC($year);
                break;
            case 'annual_accd': 
                $this->annualACCD($year);
                break;
            case 'monthly_ac': 
                $this->monthlyAC($month, $year);
                break;
            case 'monthly_accd':
                $this->monthlyACCD($month, $year);
                break;
            case 'monthly_acci':
                $this->monthlyACCI($month, $year);
                break;
            default:
                $GLOBALS['log']->error('Line '.__LINE__.': '.__METHOD__.': '." No file_type defined defined");
                break;
        }
    }

    /**
     * It runs the functions to generate a full (aggregated data) yearly AC XML file
     * As it is an annual file, we only need the aggregated data
     *
     * @param integer $year
     * @return void
     */
    public function annualAC($year)
    {
        $this->params['TIPO_FICHERO'] = 'AC';
        // Getting the data from the database using the SEPEgetter class
        $getter = new SEPEgetter();
        $aggregatedData = $getter->getAggregated($this->params['TIPO_FICHERO'], $year);

        // Setting the data to the class that generates the XML
        $xmlGenerator = new XMLgenerator($this->fileName, $this->params['TIPO_FICHERO']);
        $xmlGenerator->setCommonData($this->params);

        // AC actions are empty because this is an annual file
        $xmlGenerator->setACActions();
        $xmlGenerator->setAggregatedData($aggregatedData, 'acanual');

        $this->generateXML($getter, $xmlGenerator);  
    }

     /**
     * It runs the functions to generate a full (aggregated data) yearly ACCD XML file
     * As it is an annual file, we only need the aggregated data
     * 
     * @param integer $year
     * @return void
     */
    public function annualACCD($year)
    {
        global $mod_strings;
        $this->params['TIPO_FICHERO'] = 'ACCD';

        // Before generating the file, we check if the param CODIGO_CONVENIO is valid. If it isn't, it shows the error in the UI and exit
        $this->params['CODIGO_CONVENIO'] = $this->bean->agreement;

        if (strlen((string)$this->params['CODIGO_CONVENIO']) != 10 && !preg_match($this->patternAgreement, $this->params['CODIGO_CONVENIO'])) {
            SticUtils::showErrorMessagesAndDie($this, $mod_strings['LBL_ERROR_PATTERN_SEPE_AGREEMENT'] . ' <br>'.$mod_strings['LBL_AGREEMENT']);
        } 
        // Getting the data from the database using the SEPEgetter class
        $getter = new SEPEgetter();
        $aggregatedData = $getter->getAggregated($this->params['TIPO_FICHERO'], $year, false, $this->params['CODIGO_CONVENIO']);

        // Setting the data to the class that generates the XML
        $xmlGenerator = new XMLgenerator($this->fileName, $this->params['TIPO_FICHERO']);
        $xmlGenerator->setCommonData($this->params);

        // ACCD actions are empty because this is an annual file
        $xmlGenerator->setACCDActions();
        $xmlGenerator->setAggregatedData($aggregatedData, 'accd');

        $this->generateXML($getter, $xmlGenerator); 
    }

    /**
     * It runs the functions to generate a full (Individual and aggregated data) month AC XML file
     *
     * @param integer $month
     * @param integer $year
     * @return void
     */
    public function monthlyAC($month, $year)
    {
        $this->params['TIPO_FICHERO'] = 'AC';

        // Getting the data from the database using the SEPEgetter class
        $getter = new SEPEgetter();
        $individual_data = $getter->getMonthlyACIndividual($month, $year);
        $aggregatedData = $getter->getAggregated($this->params['TIPO_FICHERO'], $year, $month);

        // Setting the data to the class that generates the XML
        $xmlGenerator = new XMLgenerator($this->fileName, $this->params['TIPO_FICHERO']);
        $xmlGenerator->setCommonData($this->params);
        $xmlGenerator->setACActions($individual_data);
        $xmlGenerator->setAggregatedData($aggregatedData, 'ac');

        $this->generateXML($getter, $xmlGenerator);  
    }

    /**
     * It runs the functions to generate a full (Individual and aggregated data) month ACCD XML file
     *
     * @param integer $month
     * @param integer $year
     * @return void
     */
    public function monthlyACCD($month, $year)
    {
        global $mod_strings;
        $this->params['TIPO_FICHERO'] = 'ACCD';

        // Before generating the file, we check if the param CODIGO_CONVENIO is valid. If it isn't, it shows the error in the UI and exit
        $this->params['CODIGO_CONVENIO'] = $this->bean->agreement;
        if (!$this->params['CODIGO_CONVENIO']) {
            SticUtils::showErrorMessagesAndDie($this, $mod_strings['LBL_ERROR_SEPE_AGREEMENT'] . ' <br>'.$mod_strings['LBL_AGREEMENT']);
        }
        if (strlen((string)$this->params['CODIGO_CONVENIO']) != 10 && !preg_match($this->patternAgreement, $this->params['CODIGO_CONVENIO'])) {
            SticUtils::showErrorMessagesAndDie($this, $mod_strings['LBL_ERROR_PATTERN_SEPE_AGREEMENT'] . ' <br>'.$mod_strings['LBL_AGREEMENT']);
        } 
        // Getting the data from the database using the SEPEgetter class
        $getter = new SEPEgetter();
        $individualData = $getter->getMonthlyACCDIndividual($month, $year, $this->params['CODIGO_CONVENIO']);
        $aggregatedData = $getter->getAggregated($this->params['TIPO_FICHERO'], $year, $month, $this->params['CODIGO_CONVENIO']);
        
        // Setting the data to the class that generates the XML
        $xmlGenerator = new XMLgenerator($this->fileName, $this->params['TIPO_FICHERO']);
        $xmlGenerator->setCommonData($this->params);
        $xmlGenerator->setACCDActions($individualData);
        $xmlGenerator->setAggregatedData($aggregatedData, 'accd');

        $this->generateXML($getter, $xmlGenerator);   
    }

    /**
     * It runs the functions to generate a monthly ACCI XML file
     * 
     * This file type doesn't contain any aggregated data
     *
     * @param integer $month
     * @param integer $year
     * @return void
     */
    public function monthlyACCI($month, $year)
    {
        global $mod_strings;
        $this->params['TIPO_FICHERO'] = 'ACCI';

        // Before generating the file, we check if the param CODIGO_CONVENIO is valid. If it isn't, it shows the error in the UI and exit
        $this->params['CODIGO_CONVENIO'] = $this->bean->agreement;
        if (strlen((string)$this->params['CODIGO_CONVENIO']) != 10 && !preg_match($this->patternAgreement, $this->params['CODIGO_CONVENIO'])) {
            SticUtils::showErrorMessagesAndDie($this, $mod_strings['LBL_ERROR_PATTERN_SEPE_AGREEMENT'] . ' <br>'.$mod_strings['LBL_AGREEMENT']);
        } 
        // Getting the data from the database using the SEPEgetter class
        $getter = new SEPEgetter();
        $individual_data = $getter->getMonthlyACCI($month, $year, $this->params['CODIGO_CONVENIO']);

        // Setting the data to the class that generates the XML
        $xmlGenerator = new XMLgenerator($this->fileName, $this->params['TIPO_FICHERO']);
        $xmlGenerator->setCommonData($this->params);
        $xmlGenerator->setACCIincidents($individual_data);

        $this->generateXML($getter, $xmlGenerator);
    }

    /**
     * Function that generates the XML file, providing the getter and XML generator classes, displaying the errors and warning.
     * If there is an error, the file isn't generated and the page is refreshed.
     */
    protected function generateXML($getter, $xmlGenerator) {
        // Retrieve all the errors or warning that might appear and display them in the UI
        $errors = $getter->getErrors();
        $warnings = $getter->getWarnings();
        $this->setErrorsLog($errors, $warnings, empty($errors) ? false : true);
        // Generating XML
        //TODO Enhancement: How to generate the XML and refresh the site?
        $this->bean->status = "generated";
        $this->bean->save();
        $xmlGenerator->getXML(); 
    }
    


    /**
     * Set errors in "log" html field.
     * 
     *
     * @param array $array_errors
     * @param boolean $redirect If true, stops the generation and refresh the site to show the output errors. If it doesn't refresh, it needs to be done manually
     * @return void
     */
    protected function setErrorsLog($errors, $warnings, $redirect) {
        global $mod_strings, $current_user;
        $errors = array_unique($errors);
        $timeElapsed = round(microtime(true) - $this->start, 2) . ' s';
        $this->bean->log = $mod_strings['LBL_SEPE_LOG_TITLE'] .$current_user->name .' | '.date('d/m/Y H:i'). ' | '.$timeElapsed;
        if ($errors) {
            $this->bean->log = $this->bean->log.'<br><br>';
            $this->bean->log = $this->bean->log.'<b>'.$mod_strings['LBL_SEPE_ERRORS_TITLE'].'</b> ';
            $this->bean->log = $this->bean->log.'<p class="msg-error">'.join('<br>', $errors);
        } 
        else {
            $this->bean->log = $this->bean->log.'<br><p class="msg-success">'. $mod_strings['LBL_SEPE_GENERATED_WITHOUT_ERRORS'];
        }
        if ($warnings) {
            $this->bean->log = $this->bean->log.'</p><br>';
            $this->bean->log = $this->bean->log.'<b>'.$mod_strings['LBL_SEPE_WARNINGS_TITLE'].'</b> ';
            $this->bean->log = $this->bean->log.'<p class="msg-warning">'.join('<br>', $warnings);
        }

        $this->bean->save();
        if ($redirect) {
            $queryParams = array(
                'module' => 'stic_Sepe_Files',
                'action' => 'DetailView',
                'record' => $this->bean->id,
            );
            $GLOBALS['log']->debug('Line ' . __LINE__ . ': ' . __METHOD__ . ':  ' . $mod_strings['LBL_SEPE_XML_HAS_ERRORS']);
            SugarApplication::appendErrorMessage('<div class="msg-fatal-lock">' . $mod_strings['LBL_SEPE_XML_HAS_ERRORS'] . '</div>');
            SugarApplication::redirect('index.php?' . http_build_query($queryParams));
        }
    }
}
