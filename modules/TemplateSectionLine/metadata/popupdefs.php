<?php
$popupMeta = array (
    'moduleMain' => 'TemplateSectionLine',
    'varName' => 'TemplateSectionLine',
    'orderBy' => 'templatesectionline.name',
    'whereClauses' => array (
  'name' => 'templatesectionline.name',
  'grp' => 'templatesectionline.grp',
  'description' => 'templatesectionline.description',
),
    'searchInputs' => array (
  1 => 'name',
  4 => 'grp',
  5 => 'description',
),
    'searchdefs' => array (
  'name' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'name' => 'name',
  ),
  'grp' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_GRP',
    'width' => '10%',
    'name' => 'grp',
  ),
  'description' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'name' => 'description',
  ),
),
    'listviewdefs' => array (
  'NAME' => 
  array (
    'type' => 'name',
    'link' => true,
    'label' => 'LBL_NAME',
    'width' => '10%',
    'default' => true,
  ),
  'GRP' => 
  array (
    'type' => 'varchar',
    'label' => 'LBL_GRP',
    'width' => '10%',
    'default' => true,
  ),
  'DESCRIPTION' => 
  array (
    'type' => 'text',
    'label' => 'LBL_DESCRIPTION',
    'sortable' => false,
    'width' => '10%',
    'default' => true,
  ),
),
);
