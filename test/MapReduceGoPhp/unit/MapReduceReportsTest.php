<?php

use MapReduceGoPhp\Core\Config;
use MapReduceGoPhp\MapReduce\PushCampaignStatsMapper;
use MapReduceGoPhp\MapReduce\PushCampaignStatsReducer;
use MapReduceGoPhp\MapReduceJobs\PushCampaignStatsJob;

/**
 * MapReduceReportsTest Command
 * 
 * Test script for MapReduceReports
 * 
 * PHP version 5.3
 * 
 * @category Commands
 * @package  PushNotifications
 * @author   Waqar Alamgir <walamgir@folio3.oom>
 * @chainlog none
 * @license  https://raw.githubusercontent.com/waqar-alamgir/map-reduce-go-php/master/LICENSE The MIT License (MIT)
 * @link     https://raw.githubusercontent.com/waqar-alamgir/map-reduce-go-php/master/LICENSE
 */

class MapReduceReportsTest extends PHPUnit_Framework_TestCase
{
	private $_params = array();
	
	public function __construct()
	{
		$device = 'ios';
        $date = '2015-06-29';
        $repull = 'YES_REPULL';
        $singleDay = 'SINGLE_DAY';
        
        $this->params = array(
            'deviceType'=>$device,
            'date'=>date('Ymd', strtotime($date)),
            'rePull'=>(($repull=='NO_REPULL')?0:1),
            'partition'=>(($singleDay=='PARTITION_DAY')?1:0),
            'directory' => 'push-stats',
            'jobPrefix' => 'ps',
            'strJobId' => 'ios-20150629'
        );
	}
	
    public function testApIUrlConfig()
	{
		$url = Config::getValue('go_push_stats_api');
        $loaded = 0;
        if($url)
        {
            $loaded = 1;
        }
		
		$this->assertEquals(1, $loaded);
	}
    
    public function testParams()
    {
        $mapper = new PushCampaignStatsMapper();
        $reducer = new PushCampaignStatsReducer();
        
        $result = PushCampaignStatsJob::setter($mapper, $reducer, $this->params);
        
        $this->assertEquals(true, $result);
    }
    
    public function testProcessInput()
    {
        $mapper = new PushCampaignStatsMapper();
        $reducer = new PushCampaignStatsReducer();
        
        PushCampaignStatsJob::setter($mapper, $reducer, $this->params);
        PushCampaignStatsJob::processInput();
        
        $this->assertEquals(true, file_exists(PushCampaignStatsJob::getter('inputFile')));
    }
    
    public function testCheckProcessInput()
    {
        $mapper = new PushCampaignStatsMapper();
        $reducer = new PushCampaignStatsReducer();
        
        PushCampaignStatsJob::setter($mapper, $reducer, $this->params);
        PushCampaignStatsJob::processInput();
        $result = true;
        $handle = fopen(PushCampaignStatsJob::getter('inputFile'), 'r');
        if ($handle)
        {
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                $line = trim($line);
                $count = count(explode('|', $line));
                
                if($count !== 4)
                {
                    $result = false;
                }
            }
        }
        fclose($handle);
        
        $this->assertEquals(true, $result);
    }
    
    public function testMap()
    {
        $mapper = new PushCampaignStatsMapper();
        $reducer = new PushCampaignStatsReducer();
        
        PushCampaignStatsJob::setter($mapper, $reducer, $this->params);
        PushCampaignStatsJob::processInput();
        PushCampaignStatsJob::getter('map')->map(
            array(
                'input' => PushCampaignStatsJob::getter('inputFile'),
                'output' => PushCampaignStatsJob::getter('outputFile'),
                'error' => PushCampaignStatsJob::getter('errorFile'),
                'log' => PushCampaignStatsJob::getter('logFile'),
            )
        );
        
        $this->assertEquals(true, file_exists(PushCampaignStatsJob::getter('outputFile')));
    }
    
    public function testProcessOutput()
    {
        $mapper = new PushCampaignStatsMapper();
        $reducer = new PushCampaignStatsReducer();
        
        PushCampaignStatsJob::setter($mapper, $reducer, $this->params);
        PushCampaignStatsJob::processInput();
        PushCampaignStatsJob::getter('map')->map(
            array(
                'input' => PushCampaignStatsJob::getter('inputFile'),
                'output' => PushCampaignStatsJob::getter('outputFile'),
                'error' => PushCampaignStatsJob::getter('errorFile'),
                'log' => PushCampaignStatsJob::getter('logFile'),
            )
        );
        PushCampaignStatsJob::processOutput();
        
        $this->assertEquals(true, is_array(PushCampaignStatsJob::getter('lines')));
    }
    
    public function testCheckProcessOutput()
    {
        $mapper = new PushCampaignStatsMapper();
        $reducer = new PushCampaignStatsReducer();
        
        PushCampaignStatsJob::setter($mapper, $reducer, $this->params);
        PushCampaignStatsJob::processInput();
        PushCampaignStatsJob::getter('map')->map(
            array(
                'input' => PushCampaignStatsJob::getter('inputFile'),
                'output' => PushCampaignStatsJob::getter('outputFile'),
                'error' => PushCampaignStatsJob::getter('errorFile'),
                'log' => PushCampaignStatsJob::getter('logFile'),
            )
        );
        PushCampaignStatsJob::processOutput();
        $result = true;
        foreach (PushCampaignStatsJob::getter('lines') as $val)
        {
            $count = count(explode('|', $val));
            if($count !== 4)
            {
                $result = false;
            }
        }
        
        $this->assertEquals(true, $result);
    }
    
    public function testReduce()
    {
        $mapper = new PushCampaignStatsMapper();
        $reducer = new PushCampaignStatsReducer();
        
        PushCampaignStatsJob::setter($mapper, $reducer, $this->params);
        PushCampaignStatsJob::processInput();
        PushCampaignStatsJob::getter('map')->map(
            array(
                'input' => PushCampaignStatsJob::getter('inputFile'),
                'output' => PushCampaignStatsJob::getter('outputFile'),
                'error' => PushCampaignStatsJob::getter('errorFile'),
                'log' => PushCampaignStatsJob::getter('logFile'),
            )
        );
        PushCampaignStatsJob::processOutput();
        $result = PushCampaignStatsJob::getter('reduce')->reduce(PushCampaignStatsJob::getter('lines'));
        
        $this->assertEquals(true, (is_array($result) && isset($result['success'], $result['failed'])));
    }
    
    public function testFinalTest()
    {
        $mapper = new PushCampaignStatsMapper();
        $reducer = new PushCampaignStatsReducer();
        
        $result = PushCampaignStatsJob::execute($mapper, $reducer, $this->params);
        
        $this->assertEquals(true, (is_array($result) && isset($result[0], $result[1])));
    }
}

?>