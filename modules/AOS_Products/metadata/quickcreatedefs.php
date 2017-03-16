<?php
$module_name = 'AOS_Products';
$viewdefs [$module_name] =
array (
  'QuickCreate' =>
  array (
    'templateMeta' =>
    array (
      'maxColumns' => '2',
      'widths' =>
      array (
        0 =>
        array (
          'label' => '10',
          'field' => '30',
        ),
        1 =>
        array (
          'label' => '10',
          'field' => '30',
        ),
      ),
        "aos_product_category" => array (
            'name' => 'aos_product_category',
            'type' => 'link',
            'relationship' => 'product_categories',
            'source' => 'non-db',
            'link_type'=>'one',
            'module'=>'AOS_Product_Categories',
            'bean_name'=>'AOS_Product_Categories',
            'vname' => 'LBL_AOS_PRODUCT_CATEGORIES_AOS_PRODUCTS_FROM_AOS_PRODUCT_CATEGORIES_TITLE',
        ),
        'aos_product_category_name' => array (
            'required' => false,
            'source' => 'non-db',
            'name' => 'aos_product_category_name',
            'vname' => 'LBL_AOS_PRODUCT_CATEGORYS_NAME',
            'type' => 'relate',
            'massupdate' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => '0',
            'audited' => 1,
            'reportable' => true,
            'len' => '255',
            'id_name' => 'aos_product_category_id',
            'ext2' => 'AOS_Product_Categories',
            'module' => 'AOS_Product_Categories',
            'quicksearch' => 'enabled',
            'studio' => 'visible',
        ),
        "aos_product_category_id" => array (
            'name' => 'aos_product_category_id',
            'type' => 'id',
            'reportable' => false,
            'vname' => 'LBL_AOS_PRODUCT_CATEGORY',
        ),
    ),
      'relationships'=>array (
          "product_categories" => array (
              'lhs_module'=> 'AOS_Product_Categories',
              'lhs_table'=> 'aos_product_categories',
              'lhs_key' => 'id',
              'rhs_module'=> 'AOS_Products',
              'rhs_table'=> 'aos_products',
              'rhs_key' => 'aos_product_category_id',
              'relationship_type'=>'one-to-many',
          ),

      'form' =>
      array (
        'enctype' => 'multipart/form-data',
        'headerTpl' => 'modules/AOS_Products/tpls/EditViewHeader.tpl',
      ),
      'includes' =>
      array (
        0 =>
        array (
          'file' => 'modules/AOS_Products/js/products.js',
        ),
      ),
      'useTabs' => false,
      'tabDefs' =>
      array (
        'DEFAULT' =>
        array (
          'newTab' => false,
          'panelDefault' => 'expanded',
        ),
      ),
    ),
    'panels' =>
    array (
      'default' =>
      array (
        0 => 
        array (
          0 => 
          array (
            'name' => 'name',
            'label' => 'LBL_NAME',
          ),
          1 => 
          array (
            'name' => 'part_number',
            'label' => 'LBL_PART_NUMBER',
          ),
        ),
        1 => 
        array (
          0 => 
          array (
            'name' => 'url',
            'label' => 'LBL_URL',
          ),
          1 => 
          array (
            'name' => 'type',
            'label' => 'LBL_TYPE',
          ),
        ),
        2 => 
        array (
          0 => 
          array (
            'name' => 'cost',
            'label' => 'LBL_COST',
          ),
          1 => 
          array (
            'name' => 'price',
            'label' => 'LBL_PRICE',
          ),
        ),
        3 => 
        array (
          0 => 
          array (
            'name' => 'contact',
            'label' => 'LBL_CONTACT',
          ),
        ),
        4 => 
        array (
          0 => 
          array (
            'name' => 'description',
            'label' => 'LBL_DESCRIPTION',
          ),
        ),
        5 => 
        array (
          0 => 
          array (
            'name' => 'product_image',
            'customCode' => '{$PRODUCT_IMAGE}',
          ),
        ),
      ),
    ),
  ),
);
?>
