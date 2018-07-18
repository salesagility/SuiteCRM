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
        $i->getLogger->error('An error has occurred while running a scheduled indexing' . PHP_EOL . $e->getTraceAsString());
        return false;
    }

    return true;
}