<?php
// created: 2015-03-04 12:01:39
$layout_defs["AOK_Knowledge_Base_Categories"]["subpanel_setup"]['aok_knowledgebase_aok_knowledge_base_categories'] = array (
    'order' => 100,
    'module' => 'AOK_KnowledgeBase',
    'subpanel_name' => 'default',
    'sort_order' => 'asc',
    'sort_by' => 'id',
    'title_key' => 'LBL_AOK_KNOWLEDGEBASE_AOK_KNOWLEDGE_BASE_CATEGORIES_FROM_AOK_KNOWLEDGEBASE_TITLE',
    'get_subpanel_data' => 'aok_knowledgebase_aok_knowledge_base_categories',
    'top_buttons' =>
        array (
            0 =>
                array (
                    'widget_class' => 'SubPanelTopButtonQuickCreate',
                ),
            1 =>
                array (
                    'widget_class' => 'SubPanelTopSelectButton',
                    'mode' => 'MultiSelect',
                ),
        ),
);