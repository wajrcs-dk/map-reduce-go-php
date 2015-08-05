<?php

/**
 * Main configuration file for this case study
 *
 * PHP version 5.3
 * 
 * @category MapReduce
 * @package  MapReduceGoPhp
 * @author   Waqar Alamgir <waqaralamgir.tk>
 * @chainlog none
 * @license  https://raw.githubusercontent.com/waqar-alamgir/map-reduce-go-php/master/LICENSE The MIT License (MIT)
 * @link     https://raw.githubusercontent.com/waqar-alamgir/map-reduce-go-php/master/LICENSE
 */

$startTime = microtime(true);
$unit = array('b','kb','mb','gb','tb','pb');

require __DIR__  . DIRECTORY_SEPARATOR . 'SplClassLoader.php';
$oClassLoader = new \SplClassLoader('MapReduceGoPhp', __DIR__);
$oClassLoader->register();

header('Content-type: text/html; charset=utf-8');

use \MapReduceGoPhp\Core\Config;
use \MapReduceGoPhp\MapReduce\PushCampaignStatsMapper;
use \MapReduceGoPhp\MapReduce\PushCampaignStatsReducer;
use \MapReduceGoPhp\MapReduceJobs\PushCampaignStatsJob;

// Set config

Config::setValues(array(
    'go_push_stats_api' => 'http://127.0.0.1:82/other-projects/map-reduce-go-php/test/TestApi.php?a',
    'go_push_script' => 'C:\\Go\\bin\\go.exe run',
    'base_path' => str_replace('src' , '' , __DIR__),
));

$device = 'ios';
$date = '2015-06-29';
$repull = 'YES_REPULL';
$singleDay = 'SINGLE_DAY';

$mapper = new PushCampaignStatsMapper();
$reducer = new PushCampaignStatsReducer();
$params = array(
    'deviceType'=>$device,
    'date'=>date('Ymd', strtotime($date)),
    'rePull'=>(($repull=='NO_REPULL')?0:1),
    'partition'=>(($singleDay=='PARTITION_DAY')?1:0),
    'directory' => 'push-stats',
    'jobPrefix' => 'ps'
);

echo '--------------------------------------------' , PHP_EOL;
echo 'MAP REDUCE MODEL:' , PHP_EOL;
echo 'by Waqar Alamgir' , PHP_EOL;
echo '--------------------------------------------' , PHP_EOL;
$result = PushCampaignStatsJob::execute($mapper, $reducer, $params);
$size = memory_get_usage(true);
echo 'Simulated Final JSON output for job PushCampaignStatsJob:' , PHP_EOL;
echo json_encode($result) , PHP_EOL;
echo '--------------------------------------------' , PHP_EOL;
echo 'Took: ' , (@round(microtime(true)-$startTime , 3) . ' secs') , ' Memory: ' , (@round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i]) , PHP_EOL;
