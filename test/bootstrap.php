<?php

require __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'SplClassLoader.php';
$oClassLoader = new \SplClassLoader('MapReduceGoPhp', __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src');
$oClassLoader->register();

header('Content-type: text/html; charset=utf-8');

use MapReduceGoPhp\Core\Config;
use MapReduceGoPhp\MapReduce\PushCampaignStatsMapper;
use MapReduceGoPhp\MapReduce\PushCampaignStatsReducer;
use MapReduceGoPhp\MapReduceJobs\PushCampaignStatsJob;

// Set config
Config::setValues(array(
    'go_push_stats_api' => 'http://127.0.0.1:82/map-reduce-go-php/test/TestApi.php?a',
    'go_push_script' => 'C:\\Go\\bin\\go.exe run',
    'base_path' => str_replace('test' , '' , __DIR__),
));