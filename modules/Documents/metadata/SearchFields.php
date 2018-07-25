<?php
$searchFields['Documents'] = array(
  'document_name' =>
  array(
    'query_type' => 'default',
  ),
  'category_id' =>
  array(
    'query_type' => 'default',
    'options' => 'document_category_dom',
    'template_var' => 'CATEGORY_OPTIONS',
  ),
  'subcategory_id' =>
  array(
    'query_type' => 'default',
    'options' => 'document_subcategory_dom',
    'template_var' => 'SUBCATEGORY_OPTIONS',
  ),
  'active_date' =>
  array(
    'query_type' => 'default',
  ),
  'exp_date' =>
  array(
    'query_type' => 'default',
  ),
  'assigned_user_id' =>
  array(
    'query_type' => 'default',
  ),
  'filename' =>
  array(
    'query_type' => 'format',
    'operator' => 'subquery',
    'subquery' => 'SELECT document_revisions.id FROM document_revisions
			           WHERE document_revisions.deleted=0
				   AND document_revisions.filename LIKE \'{0}\'',
    'db_field' =>
    array(
      0 => 'document_revision_id',
    ),
  ),
  'range_date_entered' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_entered' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_entered' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'range_date_modified' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'start_range_date_modified' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
  'end_range_date_modified' =>
  array(
    'query_type' => 'default',
    'enable_range_search' => true,
    'is_date_field' => true,
  ),
    'favorites_only' => array(
        'query_type'=>'format',
        'operator' => 'subquery',
        'checked_only' => true,
        'subquery' => "SELECT favorites.parent_id FROM favorites
			                    WHERE favorites.deleted = 0
			                        and favorites.parent_type = 'Documents'
			                        and favorites.assigned_user_id = '{1}'",
        'db_field'=>array('id')),
);
