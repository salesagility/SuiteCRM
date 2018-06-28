<?php

$hook_array['after_save'][] = [
    100,
    'ElasticSearchAfterSave',
    'lib/Search/ElasticSearch/ElasticSearchHooks.php',
    'SuiteCRM\Search\ElasticSearch\ElasticSearchHooks',
    'beanSaved'
];

$hook_array['after_delete'][] = [
    101,
    'ElasticSearchAfterDelete',
    'lib/Search/ElasticSearch/ElasticSearchHooks.php',
    'SuiteCRM\Search\ElasticSearch\ElasticSearchHooks',
    'beanDeleted'
];
