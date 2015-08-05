<?php

namespace MapReduceGoPhp\MapReduce;
use \MapReduceGoPhp\Core\Mapper;
use \MapReduceGoPhp\Core\Config;

/**
 * Mapper Interface Component
 * 
 * This compomnent is used to create mapper
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

class PushCampaignStatsMapper implements Mapper
{
    /**
     * Provides mapper functionality for generating push campaign stats
     * 
     * @param array $jobData Job data to be passed.
     * 
     * @return boolean true in case of success
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public function map($jobData)
    {
        $command = Config::getValue('go_push_script');
        $scriptaPath = Config::getValue('base_path') . 'mini-go-cluster' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bootstrap.go';
        $cmd = $command  . ' ' . $scriptaPath . ' ' . $jobData['input'] . ' ' . $jobData['output'] . ' ' . $jobData['error'] . ' ' . $jobData['log'];
        
        exec($cmd);
    }
}

?>