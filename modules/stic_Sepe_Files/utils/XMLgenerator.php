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

class XMLgenerator {

    protected $accionesACNoColDef = array(
        0 => 'ID_TRABAJADOR',
        1 => 'NOMBRE_TRABAJADOR',
        2 => 'APELLIDO1_TRABAJADOR',
        3 => 'APELLIDO2_TRABAJADOR',
        4 => 'FECHA_NACIMIENTO',
        5 => 'SEXO_TRABAJADOR',
        6 => 'NIVEL_FORMATIVO',
        7 => 'DISCAPACIDAD',
        8 => 'INMIGRANTE',
        9 => 'COLOCACION',
    );

    protected $accionesColDef = array(
        0 => 'FECHA_COLOCACION',
        1 => 'TIPO_CONTRATO',
        2 => 'CIF_NIF_EMPRESA',
        3 => 'RAZON_SOCIAL_EMPRESA',
    );

    protected $accionesACCDNoColDef = array(
        0 => 'ID_TRABAJADOR',
        1 => 'NOMBRE_TRABAJADOR',
        2 => 'APELLIDO1_TRABAJADOR',
        3 => 'APELLIDO2_TRABAJADOR',
        4 => 'FECHA_NACIMIENTO',
        5 => 'SEXO_TRABAJADOR',
        6 => 'NIVEL_FORMATIVO',
        7 => 'DISCAPACIDAD',
        8 => 'INMIGRANTE',
        9 => 'PERCEPTOR',
        10 => 'COLECTIVO_INSERCION',
        11 => 'ACCION',
        12 => 'COLOCACION',
    );

    protected $accionesColACCDDef = array(
        0 => 'TIPO_CONTRATO',
        1 => 'FECHA_INICIO_CONTRATO',
        2 => 'FECHA_FIN_CONTRATO',
        3 => 'CIF_NIF_EMPRESA',
        4 => 'RAZON_SOCIAL_EMPRESA',
    );

    protected $incidentsACCIDef = array(
        0 => 'ID_TRABAJADOR',
        1 => 'NOMBRE_TRABAJADOR',
        2 => 'APELLIDO1_TRABAJADOR',
        3 => 'APELLIDO2_TRABAJADOR',
        4 => 'TIPO_INCIDENCIA',
        5 => 'FECHA_INCIDENCIA',
    );

    protected $agregadosACDef = array(
        0 => 'TOTAL_PERSONAS',
        1 => 'TOTAL_NUEVAS_REGISTRADAS',
        2 => 'TOTAL_PERSONAS_PERCEPTORES',
        3 => 'TOTAL_PERSONAS_INSERCION',
        4 => 'TOTAL_OFERTAS',
        5 => 'TOTAL_OFERTAS_ENVIADAS',
        6 => 'TOTAL_OFERTAS_CUBIERTAS',
        7 => 'TOTAL_PUESTOS',
        8 => 'TOTAL_PUESTOS_CUBIERTOS',
        9 => 'TOTAL_CONTRATOS',
        10 => 'TOTAL_CONTRATOS_INDEFINIDOS',
        11 => 'TOTAL_PERSONAS_COLOCADAS',
    );

    protected $agregadosACCDDef = array(
        0 => 'TOTAL_PERSONAS_ATENDIDAS',
        1 => 'TOTAL_PERSONAS_PERCEPTORES',
        2 => 'TOTAL_PERSONAS_INSERCION',
        3 => 'TOTAL_OFERTAS',
        4 => 'TOTAL_OFERTAS_CUBIERTAS',
        5 => 'TOTAL_PUESTOS',
        6 => 'TOTAL_PUESTOS_CUBIERTOS',
        7 => 'TOTAL_CONTRATOS',
        8 => 'TOTAL_CONTRATOS_INDEFINIDOS',
        9 => 'TOTAL_PERSONAS_ENVIADAS',
        10 => 'TOTAL_PERSONAS_COLOCADAS',
        11 => 'TOTAL_PERSONAS_ACCIONES',
        12 => 'TOTAL_PERSONAS_ACCION_ORIENTACION',
        13 => 'TOTAL_PERSONAS_ACCION_INFORMACION',
        14 => 'TOTAL_PERSONAS_ACCION_FORMACION',
    );

    /**
     * Initializes the class to generate the XML. It sets the headers definition and the type of file AC/ACC/ACCI
     *
     * @param string $name
     * @param string $type
     */
    public function __construct($name, $type) {
    

        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header("Content-Type: application/force-download");
        header("Content-type: application/octet-stream");

        // disable content type sniffing in MSIE
        header("X-Content-Type-Options: nosniff");
        header("Expires: 0");

        // AC is called ENPI in the XML file
        if ($type === 'AC') {
            $type = 'ENPI'; 
            $xsd = 'XML_ENPI_v1.1.xsd';
        } else if($type === 'ACCD') {
            $xsd = 'XML_ACCD_v0.xsd';
        } else if($type === 'ACCI') {
            $xsd = 'XML_ACCI_v0.xsd';
        }

        $this->xml_base = new SimpleXMLElement('<?xml version="1.0" encoding="ISO-8859-1"?><ENVIO_'.$type.' xsi:noNamespaceSchemaLocation="'.$xsd.'" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"></ENVIO_'.$type.'>');
    }
    
    /**
     * It builds the ENVIO_MENSUAL property of the AC/ACCD/ACCI XML. This is the first stage which integrates the details of the agency
     *
     * @param string $type
     * @param string $params
     * @return void
     */
    public function setCommonData($params){

        $envioMensual = $this->xml_base->addChild('ENVIO_MENSUAL');
        if ($params['TIPO_FICHERO'] != 'AC') {
            $envioMensual->addChild('TIPO_FICHERO', $params['TIPO_FICHERO']);
            $envioMensual->addChild('CODIGO_CONVENIO', $params['CODIGO_CONVENIO']);
        }
        $envioMensual->addChild('CODIGO_AGENCIA', $params['CODIGO_AGENCIA']);
        $envioMensual->addChild('AÑO_MES_ENVIO', $params['AÑO_MES_ENVIO']);
        $this->envioMensual = $envioMensual;
    }

    /**
     * It builds the ACCIONES_REALIZADAS property of the AC XML. It includes the individual data of the Applicants
     *
     * @param array $dataArray Array of individual data arrays. Each individual data array contains the properties and values of each field
     * defined in $accionesACDef
     * @return void
     */
    public function setACActions($dataArray = array()){
        $accionesRealizadas = $this->envioMensual->addChild('ACCIONES_REALIZADAS');
        foreach ($dataArray as $data) {
            $accionXml = $accionesRealizadas->addChild('ACCION');
            $dataDef = $this->accionesACNoColDef;
            if ($data['COLOCACION'] === 'S')
                $dataDef = array_merge($dataDef, $this->accionesColDef);
            foreach ($dataDef as $keyDef) {
                $accionXml->addChild($keyDef, $data[$keyDef]);
            }
        }
    }

    /**
     * It builds the ACCIONES_REALIZADAS property of the ACCD XML. It includes the individual data of the Applicants
     *
     * @param array $dataArray Array of individual data arrays. Each individual data array contains the properties and values of each field
     * defined in $accionesACCDDef
     * @return void
     */
    public function setACCDActions($dataArray = array()){
        $actionsDone = $this->envioMensual->addChild('ACCIONES_REALIZADAS');
        foreach ($dataArray as $data) {
            $accionXml = $actionsDone->addChild('DATOS_ACCION');
            $dataDef = $this->accionesACCDNoColDef;
            if ($data['COLOCACION'] === 'S')
                $dataDef = array_merge($dataDef, $this->accionesColACCDDef);
            foreach ($dataDef as $keyDef) {
                if ($keyDef === 'ACCION') {
                    foreach($data[$keyDef] as $actions_array) {
                        $actionsData = $accionXml->addChild('ACCION');
                        foreach($actions_array as $keyActionData => $valueActionData) {
                            $actionsData->addChild($keyActionData, $valueActionData);
                        }
                    }
                }
                else {
                    $accionXml->addChild($keyDef, $data[$keyDef]);
                }
            }
        }
    }

    /**
     * It builds the INCIDENCIAS_LOCALIZADAS property of the ACCI XML. It includes the individual data of the Applicants
     *
     * @param array $dataArray Array of individual data arrays. Each individual data array contains the properties and values of each field
     * defined in $accionesACCDDef
     * @return void
     */
    public function setACCIincidents($dataArray = array()){
        $actionsDone = $this->envioMensual->addChild('INCIDENCIAS_LOCALIZADAS');

        foreach ($dataArray as $data) {
            $accionXml = $actionsDone->addChild('INCIDENCIA');
            $dataDef = $this->incidentsACCIDef;
            foreach ($dataDef as $keyDef) {
                $accionXml->addChild($keyDef, $data[$keyDef]);
            }
        }
    }

    /**
     * It builds the DATOS_AGREGADOS property of the AC and ACCD XML. 
     *
     * @param array $data Array of the indicators needed to build the aggregated data property
     * @return void
     */
    public function setAggregatedData($data, $type = false){
        $aggregatedXml = $this->envioMensual->addChild('DATOS_AGREGADOS');
        $dataDef = $this->agregadosACDef;
        if ($type === 'accd') $dataDef = $this->agregadosACCDDef;
        foreach ($dataDef as $key) {
            $aggregatedXml->addChild($key, $data[$key]);
        }
    }

    /**
     * It generates and download the XML file, 
     *
     * @param boolean $xsd_file If true/string, it uses the XSD schema as validator.
     * @return void
     */
    public function getXML($xsd_file = false) {
        ob_clean();
        libxml_use_internal_errors(true);
        // $xsd_file = 'modules/stic_GeneradorSEPE/utils/XML_ENPI_v1_1.xsd';

        $dom = dom_import_simplexml($this->xml_base)->ownerDocument;
        $dom->encoding = 'ISO-8859-1';
        if ($xsd_file) {
            if (!$dom->schemaValidate($xsd_file)) {
                $errors = libxml_get_errors(); 
                var_dump($errors); 
                $GLOBALS['log']->error('Line '.__LINE__.': '.__METHOD__.': '.'Error building XML', $errors);
            }
        }
        $dom->formatOutput = true;
        echo $dom->saveXML();
        flush();
        die();    
    }
}