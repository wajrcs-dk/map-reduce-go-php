<?php

namespace MapReduceGoPhp\Core;

/**
 * Job Component
 * 
 * This compomnent is used to create jobs for map reduce model
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

abstract class Job
{
    /**
     * Mapper instance
     * @var $map object
     */
    protected static $map;
    
    /**
     * Reducer instance
     * @var $reduce object
     */
    protected static $reduce;
    
    /**
     * Params provided for the job
     * @var $params array
     */
    protected static $params;
    
    /**
     * Split the job into pages with limit
     * @var $limit int
     */
    protected static $limit = 100;
    
    /**
     * Input file name
     * @var $inputFile string
     */
    protected static $inputFile;
    
    /**
     * Output file name
     * @var $outputFile string
     */
    protected static $outputFile;
    
    /**
     * Error file name
     * @var $errorFile string
     */
    protected static $errorFile;
    
    /**
     * Log file name
     * @var $logFile string
     */
    protected static $logFile;
    
    /**
     * Contains Output file rows
     * @var $lines array
     */
    protected static $lines;
    
    /**
     * Sets values for Job instance members
     * 
     * @param object $map    Mapper instance for this job.
     * @param object $reduce Reducer instance for this job.
     * @param string $params Input params for the job.
     * 
     * @return array true
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function setter($map, $reduce, $params)
    {
        static::setFileNames($params);
        static::$map = $map;
        static::$reduce = $reduce;
        
        return true;
    }
    
    /**
     * Sets value for Job instance member
     * 
     * @param string $limit Limit value.
     * 
     * @return null
     * @author Waqar Alamgir <walamgir@folio3.oom>
     */
    public static function overrideLimit($limit)
    {
        static::$limit = $limit;
    }
    
    /**
     * Gets value for Job instance member
     * 
     * @param string $key Gets key.
     * 
     * @return mixed object
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function getter($key)
    {
        return static::$$key;
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
        static::setFileNames($params);
        static::$map = $map;
        static::$reduce = $reduce;
        
        // Free up memory
        $map = null;
        $reduce = null;
        $params = null;
        unset($map);
        unset($reduce);
        unset($params);
        
        // Process input and generate input file
        static::processInput();
        
        // Execute map
        static::$map->map(
            array(
                'input' => static::$inputFile,
                'output' => static::$outputFile,
                'error' => static::$errorFile,
                'log' => static::$logFile,
            )
        );
        
        // Process created output file
        static::processOutput();
        
        // Execute reduce
        return static::$reduce->reduce(static::$lines);
    }
    
     /**
     * Generates and set file names
     * 
     * @param string $params Input params for the job.
     * 
     * @return null
     * @author Waqar Alamgir <walamgir@folio3.oom>
     */
    public static function setFileNames($params)
    {
        $filePath = Config::getValue('base_path') . 'log' . DIRECTORY_SEPARATOR;
        
        static::$params = $params;
        static::$inputFile = $filePath . $params['jobPrefix'] . '_inp_' . $params['strJobId'] . '.txt';
        static::$outputFile = $filePath . $params['jobPrefix'] . '_out_' . $params['strJobId'] . '.txt';
        static::$errorFile = $filePath . $params['jobPrefix'] . '_err_' . $params['strJobId'] . '.txt';
        static::$logFile = $filePath . 'go-logs' . DIRECTORY_SEPARATOR;
    }
    
    /**
     * Process input job
     * 
     * @return boolean true in case of success
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function processInput()
    {
        // ToDo: Override the functionality
    }
    
    /**
     * Process output job
     * 
     * @return boolean true in case of success
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function processOutput()
    {
        // ToDo: Override the functionality
    }
}

?>