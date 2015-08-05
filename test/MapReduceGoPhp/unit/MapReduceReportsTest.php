<?php

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
 * @license  http://www.barnesandnoble.com/ PHP License 1.0
 * @link     http://www.barnesandnoble.com/
 */

class MapReduceReportsTest extends PHPUnit_Framework_TestCase
{
    public function testApIUrlConfig()
	{
		$url = Config::getValue('go_push_stats_api');
        $loaded = 0;
        if($url)
        {
            $loaded = 1;
        }
		
		$this->assertEquals(1 , $loaded);
	}
    
    public function testParams()
    {
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
        
        $result = PushCampaignStatsJob::setter($mapper , $reducer , $params);
        
        $this->assertEquals(true , $result);
    }
    
    public function testProcessInput()
    {
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
        
        $result = PushCampaignStatsJob::setter($mapper , $reducer , $params);
        
        PushCampaignStatsJob::processInput();
        
        $this->assertEquals(true , file_exists(PushCampaignStatsJob::getter('_inputFile')));
    }
    
    public function testCheckProcessInput()
    {
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
        
        $result = PushCampaignStatsJob::setter($mapper , $reducer , $params);
        
        PushCampaignStatsJob::processInput();
        
        $result = true;
        
        $handle = fopen(PushCampaignStatsJob::getter('_inputFile'), 'r');
        if ($handle)
        {
            while (($line = fgets($handle)) !== false) {
                // process the line read.
                $line = trim($line);
                $count = count(explode('|' , $line));
                
                if($count !== 4)
                {
                    $result = false;
                }
            }
        }
        fclose($handle);
        
        $this->assertEquals(true , $result);
    }
    
    public function testMap()
    {
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
        
        $result = PushCampaignStatsJob::setter($mapper , $reducer , $params);
        
        PushCampaignStatsJob::processInput();
        
        PushCampaignStatsJob::getter('_map')->map(
            array(
                'input' => PushCampaignStatsJob::getter('_inputFile'),
                'output' => PushCampaignStatsJob::getter('_outputFile'),
                'error' => PushCampaignStatsJob::getter('_errorFile'),
                'log' => PushCampaignStatsJob::getter('_logFile'),
            )
        );
        
        $this->assertEquals(true , file_exists(PushCampaignStatsJob::getter('_outputFile')));
    }
    
    public function testProcessOutput()
    {
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
        
        $result = PushCampaignStatsJob::setter($mapper , $reducer , $params);
        
        PushCampaignStatsJob::processInput();
        
        PushCampaignStatsJob::getter('_map')->map(
            array(
                'input' => PushCampaignStatsJob::getter('_inputFile'),
                'output' => PushCampaignStatsJob::getter('_outputFile'),
                'error' => PushCampaignStatsJob::getter('_errorFile'),
                'log' => PushCampaignStatsJob::getter('_logFile'),
            )
        );
        
        PushCampaignStatsJob::processOutput();
        
        $this->assertEquals(true , is_array(PushCampaignStatsJob::getter('_lines')));
    }
    
    public function testCheckProcessOutput()
    {
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
        
        $result = PushCampaignStatsJob::setter($mapper , $reducer , $params);
        
        PushCampaignStatsJob::processInput();
        
        PushCampaignStatsJob::getter('_map')->map(
            array(
                'input' => PushCampaignStatsJob::getter('_inputFile'),
                'output' => PushCampaignStatsJob::getter('_outputFile'),
                'error' => PushCampaignStatsJob::getter('_errorFile'),
                'log' => PushCampaignStatsJob::getter('_logFile'),
            )
        );
        
        PushCampaignStatsJob::processOutput();
        
        
        $result = true;
        
        foreach (PushCampaignStatsJob::getter('_lines') as $val)
        {
            $count = count(explode('|' , $val));
            if($count !== 4)
            {
                $result = false;
            }
        }
        
        $this->assertEquals(true , $result);
    }
    
    public function testReduce()
    {
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
        
        $result = PushCampaignStatsJob::setter($mapper , $reducer , $params);
        
        PushCampaignStatsJob::processInput();
        
        PushCampaignStatsJob::getter('_map')->map(
            array(
                'input' => PushCampaignStatsJob::getter('_inputFile'),
                'output' => PushCampaignStatsJob::getter('_outputFile'),
                'error' => PushCampaignStatsJob::getter('_errorFile'),
                'log' => PushCampaignStatsJob::getter('_logFile'),
            )
        );
        
        PushCampaignStatsJob::processOutput();
        
        $result = PushCampaignStatsJob::getter('_reduce')->reduce(PushCampaignStatsJob::getter('_lines'));
        
        $this->assertEquals(true , (is_array($result) && isset($result['success'] , $result['failed'])));
    }
    
    public function testFinalTest()
    {
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
        
        $result = PushCampaignStatsJob::execute($mapper, $reducer, $params);
        
        $this->assertEquals(true , (is_array($result) && isset($result[0] , $result[1])));
    }
}

?>