<?php

namespace MapReduceGoPhp\Core;

/**
 * Config Component
 * 
 * This compomnent is used to set and get configuration
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

class Config
{
    /**
     * Map instance
     * @var $_map object
     */
    protected static $_map;
    
    /**
     * Gets a key value from config
     * 
     * @param string $key Key for config value
     * 
     * @return mixed Config key value
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function getValue($key)
    {
        return isset(static::$_map[$key])?static::$_map[$key]:'';
    }
    
    /**
     * Gets a key value from config
     * 
     * @param array $settings Key values pair for config value
     * 
     * @return mixed Config key value
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function setValues($settings)
    {
        static::$_map = $settings;
    }
}

?>