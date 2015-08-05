<?php

namespace MapReduceGoPhp\Core;

/**
 * Reducer Interface Component
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

Interface Reducer
{
    /**
     * Provides reducer functionality
     * 
     * @param array $jobData Job data to be passed.
     * 
     * @return boolean true in case of success
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public function reduce($jobData);
}

?>