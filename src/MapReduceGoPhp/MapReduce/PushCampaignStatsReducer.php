<?php

namespace MapReduceGoPhp\MapReduce;
use \MapReduceGoPhp\Core\Reducer;

/**
 * PushCampaignStatsReducer Component
 * 
 * This compomnent is used to create reducer
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

class PushCampaignStatsReducer implements Reducer
{
    /**
     * Provides reducer functionality for generating push campaign stats
     * 
     * @param array $jobData Job data to be passed.
     * 
     * @return boolean true in case of success
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public function reduce($jobData)
    {
        $dataList = array();
        $dataList['success'] = 0;
        $dataList['failed'] = 0;
        $dataList['jobs'] = 0;
        $dataList['error'] = 'Response is empty.';
        
        // Traverse array
        foreach ($jobData as $line) {
            // Process the line read.
            if ($line != '') {
                $data = explode('|', $line);
                
                ++$dataList['jobs'];
                
                // Count data
                if (count($data) === 4) {
                    // Removed & from start of the string (query params)
                    $params = array();
                    parse_str(substr($data[2], 1), $params);
                    
                    // If output is empty
                    if ($data[3] === '') {
                        $dataList['success'] += 0;
                        $dataList['failed'] += ($params['endLimit'] - $params['startLimit']);
                        $dataList['error'] = 'Unable to parse response.';
                    } else {
                        $data = json_decode($data[3]);
                        
                        // If http code is 200 then it means that everything went well.
                        if (isset($data->status) && $data->status == '200') {
                            $dataList['success'] += $data->message->success;
                            $dataList['failed'] += $data->message->failed;
                            $dataList['error'] = 'Void';
                        } else if (isset($data->status , $data->message->error)) {
                            // If http code is not 200 then it means that there is some error.
                            $dataList['success'] += 0;
                            $dataList['failed'] += ($params['endLimit'] - $params['startLimit'] + 1);
                            $dataList['error'] = 'Http ' . $data->status . ' | ' . $data->message->error;
                        } else {
                            // This is suppose to be invalid response.
                            $dataList['success'] += 0;
                            $dataList['failed'] += ($params['endLimit'] - $params['startLimit'] + 1);
                            $dataList['error'] = 'Unable to parse response after decode.';
                        }
                    }
                }
            }
        }
        
        return $dataList;
    }
}

?>