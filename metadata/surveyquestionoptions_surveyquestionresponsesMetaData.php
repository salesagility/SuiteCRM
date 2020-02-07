<?php
// created: 2017-03-16 13:41:06
$dictionary["surveyquestionoptions_surveyquestionresponses"] = array(
  'true_relationship_type' => 'many-to-many',
  'relationships' =>
  array(
    'surveyquestionoptions_surveyquestionresponses' =>
    array(
      'lhs_module' => 'SurveyQuestionOptions',
      'lhs_table' => 'surveyquestionoptions',
      'lhs_key' => 'id',
      'rhs_module' => 'SurveyQuestionResponses',
      'rhs_table' => 'surveyquestionresponses',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'surveyquestionoptions_surveyquestionresponses',
      'join_key_lhs' => 'surveyq72c7options_ida',
      'join_key_rhs' => 'surveyq10d4sponses_idb',
    ),
  ),
  'table' => 'surveyquestionoptions_surveyquestionresponses',
  'fields' =>
  array(
    0 =>
    array(
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 =>
    array(
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 =>
    array(
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 =>
    array(
      'name' => 'surveyq72c7options_ida',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 =>
    array(
      'name' => 'surveyq10d4sponses_idb',
      'type' => 'varchar',
      'len' => 36,
    ),
  ),
  'indices' =>
  array(
    0 =>
    array(
      'name' => 'surveyquestionoptions_surveyquestionresponsesspk',
      'type' => 'primary',
      'fields' =>
      array(
        0 => 'id',
      ),
    ),
    1 =>
    array(
      'name' => 'surveyquestionoptions_surveyquestionresponses_alt',
      'type' => 'alternate_key',
      'fields' =>
      array(
        0 => 'surveyq72c7options_ida',
        1 => 'surveyq10d4sponses_idb',
      ),
    ),
  ),
);
