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
     * @var $_map object
     */
    protected static $_map;
    
    /**
     * Reducer instance
     * @var $_reduce object
     */
    protected static $_reduce;
    
    /**
     * Params provided for the job
     * @var $_params array
     */
    protected static $_params;
    
    /**
     * Split the job into pages with limit
     * @var $_limit int
     */
    protected static $_limit = 100;
    
    /**
     * Input file name
     * @var $_inputFile string
     */
    protected static $_inputFile;
    
    /**
     * Output file name
     * @var $_outputFile string
     */
    protected static $_outputFile;
    
    /**
     * Error file name
     * @var $_errorFile string
     */
    protected static $_errorFile;
    
    /**
     * Log file name
     * @var $_logFile string
     */
    protected static $_logFile;
    
    /**
     * Contains Output file rows
     * @var $_lines array
     */
    protected static $_lines;
    
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
        $filePath = Config::getValue('base_path') . 'log' . DIRECTORY_SEPARATOR;
        $jobId = $params['deviceType'] . '_' . $params['date'] . '_' . $params['rePull'] . '_' . $params['partition'];
        
        static::$_map = $map;
        static::$_reduce = $reduce;
        static::$_params = $params;
        static::$_inputFile = $filePath . $params['directory'] . DIRECTORY_SEPARATOR . $params['jobPrefix'] . '_inp_' . $jobId . '.txt';
        static::$_outputFile = $filePath . $params['directory'] . DIRECTORY_SEPARATOR . $params['jobPrefix'] . '_out_' . $jobId . '.txt';
        static::$_errorFile = $filePath . $params['directory'] . DIRECTORY_SEPARATOR . $params['jobPrefix'] . '_err_' . $jobId . '.txt';
        static::$_logFile = $filePath . 'go-logs' . DIRECTORY_SEPARATOR;
        
        return true;
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
        $filePath = Config::getValue('base_path') . 'log' . DIRECTORY_SEPARATOR;
        $jobId = $params['deviceType'] . '_' . $params['date'] . '_' . $params['rePull'] . '_' . $params['partition'];
        
        static::$_map = $map;
        static::$_reduce = $reduce;
        static::$_params = $params;
        static::$_inputFile = $filePath . $params['directory'] . DIRECTORY_SEPARATOR . $params['jobPrefix'] . '_inp_' . $jobId . '.txt';
        static::$_outputFile = $filePath . $params['directory'] . DIRECTORY_SEPARATOR . $params['jobPrefix'] . '_out_' . $jobId . '.txt';
        static::$_errorFile = $filePath . $params['directory'] . DIRECTORY_SEPARATOR . $params['jobPrefix'] . '_err_' . $jobId . '.txt';
        static::$_logFile = $filePath . 'go-logs' . DIRECTORY_SEPARATOR;
        
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
        static::$_map->map(
            array(
                'input' => static::$_inputFile,
                'output' => static::$_outputFile,
                'error' => static::$_errorFile,
                'log' => static::$_logFile,
            )
        );
        
        // Process created output file
        static::processOutput();
        
        // Execute reduce
        return static::$_reduce->reduce(static::$_lines);
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