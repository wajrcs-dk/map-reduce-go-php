<?php

require __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'SplClassLoader.php';
$oClassLoader = new \SplClassLoader('MapReduceGoPhp', __DIR__);
$oClassLoader->register();

header('Content-type: text/html; charset=utf-8');

use \MapReduceGoPhp\Core\Config;
use \MapReduceGoPhp\MapReduce\PushCampaignStatsMapper;
use \MapReduceGoPhp\MapReduce\PushCampaignStatsReducer;
use \MapReduceGoPhp\MapReduceJobs\PushCampaignStatsJob;
