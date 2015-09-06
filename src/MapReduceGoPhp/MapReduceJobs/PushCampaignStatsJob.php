<?php

namespace MapReduceGoPhp\MapReduceJobs;
use \MapReduceGoPhp\Core\Config;
use \MapReduceGoPhp\Core\Job;

/**
 * PushCampaignStatsJob Component
 * 
 * This compomnent is used to create jobs for map reduce model
 * for generating push campaign stats
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

final class PushCampaignStatsJob extends Job
{
    /**
     * Gets records count
     * 
     * @param object $date       Mapper instance for this job.
     * @param object $partition  Reducer instance for this job.
     * @param string $deviceType Input params for the job.
     * 
     * @return boolean true in case of success
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function getPushIdsCount($date, $partition, $deviceType)
    {
        return array('ROWS'=>100000);
    }
    
    /**
     * Process input job
     * 
     * @return boolean true in case of success
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function processInput()
    {
        $row = static::getPushIdsCount(static::$params['date'], static::$params['partition'], static::$params['deviceType']);
        $count = 0;
        $url = Config::getValue('go_push_stats_api');
        
        // If ROWS is set
        if (isset($row['ROWS'])) {
            $count = $row['ROWS'];
        }
        
        // Open the file
        $fp = fopen(static::$inputFile, 'w');
        $params = static::$params;
        
        // Generating urls
        for ($startLimit=1; $startLimit<=$count; $startLimit += static::$limit) {
            $endLimit = $startLimit + static::$limit - 1;
            $endLimit = ($endLimit>$count) ? $count:$endLimit;
            $params['startLimit'] = $startLimit;
            $params['endLimit'] = $endLimit;
            $params['jobId'] = mt_rand();
            fwrite($fp, 'URL|' . $url . '|GET|&' . http_build_query($params) . "\n");
        }
        
        // Close the file
        fclose($fp);
    }
    
    /**
     * Process output job
     * 
     * @return boolean true in case of success
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function processOutput()
    {
        // Open a file for processing
        $handle = fopen(static::$outputFile, 'r');
        static::$lines = array();
        
        // If file exists
        if ($handle) {
            // Read file line by line
            while (($line = fgets($handle)) !== false) {
                static::$lines[] = trim($line);
            }
        }
        
        return true;
    }
    
    /**
     * Executes current job
     * 
     * @param object $map    Mapper instance for this job.
     * @param object $reduce Reducer instance for this job.
     * @param string $params Input params for the job.
     * 
     * @return array Result of the job.
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function execute($map, $reduce, $params)
    {
        $result = parent::execute($map, $reduce, $params);
        return array($result['success'], $result['failed'], $result['jobs']);
    }
}

?>