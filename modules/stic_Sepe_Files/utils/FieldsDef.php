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
 * Array definition of each of the properties used to build the XML
 * key: Name of the Propery needed (Name of the module for the ID fields)
 * 0 => Database table name
 * 1 => field name in database
 * 2 => Type of field (used to build the format of some fields or validation of data)
 * 3 => array with the validation properties
 * 4 => Name of the module
 * 
 * If there is an update or modification it can be done directly here.
 * NOTE: If the WHERE conditions change, the SQLbuilder might need to be updated as well
 * 
 */
$defACindividual = array(
    "Contacts" => array(
        0 => 'contacts',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'Contacts',
    ),
    "ID_TRABAJADOR" => array(
        0 => 'contacts_cstm',
        1 => 'stic_identification_number_c',
        2 => 'text',
        3 => array(
            "required" => true,
            "length" => 9,
            "pattern" => "/[XYZxyz]?[0-9]{7,8}[a-zA-Z]/"
        ),
        4 => 'Contacts'
    ),
    "NOMBRE_TRABAJADOR" => array(
        0 => 'contacts',
        1 => 'first_name',
        2 => 'text',
        3 => array(
            "required" => true,
            "length" => 15,
            "pattern" => '/^[a-zA-Z ]+$/',
        ),
        4 => 'Contacts'
    ),
    "APELLIDO1_TRABAJADOR" => array(
        0 => 'contacts',
        1 => 'last_name',
        2 => 'text',
        3 => array(
            "required" => true,
            "length" => 20,
            "pattern" => '/^[a-zA-Z ]+$/',
        ),
        4 => 'Contacts'
    ),
    "APELLIDO2_TRABAJADOR" => array(
        0 => '',
        1 => '',
        2 => 'empty',
        3 => array(
            "required" => false,
            "length" => 20,
            "pattern" => '/^[a-zA-Z ]+$/',
        ),
        4 => 'Contacts'
    ),
    "FECHA_NACIMIENTO" => array(
        0 => 'contacts',
        1 => 'birthdate',
        2 => 'date',
        3 => array(
            "required" => true,
            "length" => 8,
            "pattern" => "/\d{4}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])/",
        ),
        4 => 'Contacts'
    ),
    "SEXO_TRABAJADOR" => array(
        0 => 'contacts_cstm',
        1 => 'stic_gender_c',
        2 => 'list',
        3 => array(
            "required" => true,
            "length" => null,
            "pattern" => null,
            "validationList" => "SEXO_TRABAJADOR_LIST",
        ),
        4 => 'Contacts'
    ),
    "NIVEL_FORMATIVO" => array(
        0 => 'contacts_cstm',
        1 => 'sepe_education_level_c',
        2 => 'list',
        3 => array(
            "required" => true,
            "length" => 2,
            "pattern" => null,
            "validationList" => "NIVEL_FORMATIVO_LIST",
        ),
        4 => 'Contacts'
    ),
    "DISCAPACIDAD" => array(
        0 => 'contacts_cstm',
        1 => 'sepe_disability_c',
        2 => 'integer',
        3 => array(
            "required" => true,
            "length" => 1,
            "pattern" => "/[SsNn]/",
        ),
        4 => 'Contacts'
    ),
    "INMIGRANTE" => array(
        0 => 'contacts_cstm',
        1 => 'sepe_immigrant_c',
        2 => 'integer',
        3 => array(
            "required" => true,
            "length" => 1,
            "pattern" => "/[SsNn]/",
        ),
        4 => 'Contacts'
    ),
);

$defACCDindividual = array(
    "PERCEPTOR" => array(
        0 => 'contacts_cstm',
        1 => 'sepe_benefit_perceiver_c',
        2 => 'integer',
        3 => array(
            "required" => true,
            "length" => 1,
            "pattern" => "/[SsNn]/",
        ),
        4 => 'Contacts'
    ),
    "COLECTIVO_INSERCION" => array(
        0 => 'contacts_cstm',
        1 => 'sepe_insertion_difficulties_c',
        2 => 'integer',
        3 => array(
            "required" => true,
            "length" => 1,
            "pattern" => "/[SsNn]/",
        ),
        4 => 'Contacts'
    ),
    "Contacts" => array(
        0 => 'contacts',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'Contacts',
    ),
);

$defACCDactions = array(
    "TIPO_ACCION" => array(
        0 => 'stic_sepe_actions',
        1 => 'type',
        2 => 'list',
        3 => array(
            "required" => true,
            "length" => 1,
            "pattern" => null,
            "validationList" => "TIPO_ACCION_LIST",
        ),
        4 => 'stic_Sepe_Actions',
    ),
    "FECHA_INICIO_ACCION" => array(
        0 => 'stic_sepe_actions',
        1 => 'start_date',
        2 => 'date',
        3 => array(
            "required" => true,
            "length" => 8,
            "pattern" => "/20(1[0-9]|2[0-9])(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])/",
        ),
        4 => 'stic_Sepe_Actions',
    ),
    "FECHA_FINAL_ACCION" => array(
        0 => 'stic_sepe_actions',
        1 => 'end_date',
        2 => 'date',
        3 => array(
            "required" => true,
            "length" => 8,
            "pattern" => "/20(1[0-9]|2[0-9])(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])/",
        ),
        4 => 'stic_Sepe_Actions',
    ),
    "stic_Sepe_Actions" => array(
        0 => 'stic_sepe_actions',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'stic_Sepe_Actions',
    ),
);

$defACindividualCol = array(
    "FECHA_COLOCACION" => array(
        0 => 'stic_job_applications',
        1 => 'contract_start_date',
        2 => 'date',
        3 => array(
            "required" => true,
            "length" => 8,
            "pattern" => "/20(1[0-9]|2[0-9])(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])/",
        ),
        4 => 'stic_Job_Applications',
    ),
    "stic_Job_Applications" => array(
        0 => 'stic_job_applications',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'stic_Job_Applications',
    ),
    "TIPO_CONTRATO" => array(
        0 => 'stic_job_offers',
        1 => 'sepe_contract_type',
        2 => 'list',
        3 => array(
            "required" => true,
            "length" => 3,
            "pattern" => null,
            "validationList" => "TIPO_CONTRATO_AC_LIST",
        ),
        4 => 'stic_Job_Offers',
    ),
    "stic_Job_Offers" => array(
        0 => 'stic_job_offers',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'stic_Job_Offers',
    ),
    "CIF_NIF_EMPRESA" => array(
        0 => 'accounts_cstm',
        1 => 'stic_identification_number_c',
        2 => 'integer',
        3 => array(
            "required" => true,
            "length" => 9,
            "pattern" => "/[XYZxyz]?[0-9]{7,8}[a-zA-Z]/",
            "pattern2" => "/[a-zA-Z][0-9]{7}[a-zA-Z0-9]/"
        ),
        4 => 'Accounts',
    ),
    "RAZON_SOCIAL_EMPRESA" => array(
        0 => 'accounts',
        1 => 'name',
        2 => 'integer',
        3 => array(
            "required" => true,
            "length" => 55,
            "pattern" => null,
        ),
        4 => 'Accounts',
    ),
    "Accounts" => array(
        0 => 'accounts',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'Accounts',
    ),
);
$defACCDindividualCol = array(
    "FECHA_INICIO_CONTRATO" => array(
        0 => 'stic_job_applications',
        1 => 'contract_start_date',
        2 => 'date',
        3 => array(
            "required" => true,
            "length" => 8,
            "pattern" => "/20(1[0-9]|2[0-9])(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])/",
        ),
        4 => 'stic_Job_Applications',
    ),
    "FECHA_FIN_CONTRATO" => array(
        0 => 'stic_job_applications',
        1 => 'contract_end_date',
        2 => 'date',
        3 => array(
            "required" => false,
            "length" => 8,
            "pattern" => "/20(1[0-9]|2[0-9])(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])/",
        ),
        4 => 'stic_Job_Applications',
    ),
    "stic_Job_Applications" => array(
        0 => 'stic_job_applications',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'stic_Job_Applications',
    ),
    "TIPO_CONTRATO" => array(
        0 => 'stic_job_offers',
        1 => 'sepe_contract_type',
        2 => 'list',
        3 => array(
            "required" => true,
            "length" => 3,
            "pattern" => null,
            "validationList" => "TIPO_CONTRATO_ACCD_LIST",
        ),
        4 => 'stic_Job_Offers',
    ),
    "stic_Job_Offers" => array(
        0 => 'stic_job_offers',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'stic_Job_Offers',
    ),
    "CIF_NIF_EMPRESA" => array(
        0 => 'accounts_cstm',
        1 => 'stic_identification_number_c',
        2 => 'integer',
        3 => array(
            "required" => true,
            "length" => 9,
            "pattern" => "/[XYZxyz]?[0-9]{7,8}[a-zA-Z]/",
            "pattern2" => "/[a-zA-Z][0-9]{7}[a-zA-Z0-9]/"
        ),
        4 => 'Accounts',
    ),
    "RAZON_SOCIAL_EMPRESA" => array(
        0 => 'accounts',
        1 => 'name',
        2 => 'integer',
        3 => array(
            "required" => true,
            "length" => 55,
            "pattern" => null,
        ),
        4 => 'Accounts',
    ),
    "Accounts" => array(
        0 => 'accounts',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'Accounts',
    ),
);
$defColocacion = array(
    "COLOCACION" => array(
        0 => null,
        1 => null,
        2 => 'text',
        3 => array(
            "required" => true,
            "length" => 1,
            "pattern" => "/[SsNn]/",
        )
    ),
);

$defACCI = array(
    "Contacts" => array(
        0 => 'contacts',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'Contacts',
    ),
    "ID_TRABAJADOR" => array(
        0 => 'contacts_cstm',
        1 => 'stic_identification_number_c',
        2 => 'text',
        3 => array(
            "required" => true,
            "length" => 9,
            "pattern" => "/[XYZxyz]?[0-9]{7,8}[a-zA-Z]/"
        ),
        4 => 'Contacts'
    ),
    "NOMBRE_TRABAJADOR" => array(
        0 => 'contacts',
        1 => 'first_name',
        2 => 'text',
        3 => array(
            "required" => true,
            "length" => 15,
            "pattern" => '/^[a-zA-Z ]+$/',
        ),
        4 => 'Contacts'
    ),
    "APELLIDO1_TRABAJADOR" => array(
        0 => 'contacts',
        1 => 'last_name',
        2 => 'text',
        3 => array(
            "required" => true,
            "length" => 20,
            "pattern" => '/^[a-zA-Z ]+$/',
        ),
        4 => 'Contacts'
    ),
    "APELLIDO2_TRABAJADOR" => array(
        0 => '',
        1 => '',
        2 => 'empty',
        3 => array(
            "required" => false,
            "length" => 20,
            "pattern" => '/^[a-zA-Z ]+$/',
        ),
        4 => 'Contacts'
    ),
    "stic_Sepe_Incidents" => array(
        0 => 'stic_sepe_incidents',
        1 => 'id',
        2 => 'id',
        3 => array(
            "required" => true,
            "length" => 0,
            "pattern" => null,
        ),
        4 => 'stic_Sepe_Incidents'
    ),
    "TIPO_INCIDENCIA" => array(
        0 => 'stic_sepe_incidents',
        1 => 'type',
        2 => 'list',
        3 => array(
            "required" => true,
            "length" => 3,
            "pattern" => null,
            "validationList" => "TIPO_INCIDENCIA_LIST",
        ),
        4 => 'stic_Sepe_Incidents'
    ),
    "FECHA_INCIDENCIA" => array(
        0 => 'stic_sepe_incidents',
        1 => 'incident_date',
        2 => 'date',
        3 => array(
            "required" => true,
            "length" => 8,
            "pattern" => '/20(1[0-9]|2[0-9])(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])/',
        ),
        4 => 'stic_Sepe_Incidents'
    ),    
);