<?php

/**
 * Test API Component
 * 
 * This compomnent is used to generate API response.
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

class TestApi
{
    /**
     * Sends API response
     * 
     * @return void
     * @author Waqar Alamgir <waqaralamgir.tk>
     */
    public static function bootstrap()
    {
        $failed = rand(0, 9);
        $success = 100 - $failed;
        
        // Generates boolean random
        if (rand(0, 9)) {
            static::sendResponse(200 , array('jobId'=>$_GET['jobId'], 'success'=>$success, 'failed'=>$failed));
        } else {
           static::sendResponse(500 , array('jobId'=>$_GET['jobId'], 'success'=>$success, 'failed'=>$failed)); 
        }
    }
    
    /**
     * Get Status Code message
     * 
     * @param $status Either 200, 401, 404, 500, 501
     * 
     * @return string
     */
    private static function getStatusCodeMessage($status)
    {
        // List of error codes and their messages
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
    
    /**
     * Send API Responses
     * 
     * @param int $status Either 200, 401, 404, 500, 501
     * @param string|Array $message Message to return, in case of error, this function will implement its own Message
     * @param string $contentType Content type
     * 
     * @return void
     */
    public static function sendResponse($status, $message, $contentType='application/json')
    {
        // set the status
        $status_header = 'HTTP/1.1 ' . $status . ' ' . static::getStatusCodeMessage($status);
        header($status_header);
        // and the content type
        header('Content-type: ' . $contentType);
        
        // In case of error, we'll have empty Message
        if (empty($message)) {
            
            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 400:
                    $message = 'The request failed. Most likely something was missed or passed improperly in parameters.';
                    break;
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your request.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }
        }
        
        // Prepare Return array
        $returnArray = array('status'=>$status,'message'=>$message);
        
        echo json_encode($returnArray);
    }
}

TestApi::bootstrap();

?>