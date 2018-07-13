<?php

use SuiteCRM\Search\ElasticSearch\ElasticSearchIndexer as i;

if (i::isEnabled())
    $job_strings[] = 'runElasticSearchIndexerScheduler';

function runElasticSearchIndexerScheduler()
{
    $i = new i();
    $i->log('@', 'Starting scheduled job');

    try {
        $i->setDifferentialIndexingEnabled(true);
        $i->run();
    } catch (Exception $e) {
        $i->log('!', 'An error has occurred while running a scheduled index');
        return false;
    }

    return true;
}