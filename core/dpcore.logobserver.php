<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */

/**
 * This particular implementation of Exception_Observer logs exception information 
 * to a file. If you’re testing this code, make sure you set the $_filename 
 * variable to an appropriate location and filename.
 * 
 * This strategy offers more flexibility than simply handling the logging or 
 * reporting in the constructor method of a custom exception class, or defining 
 * an exception handler function. Firstly, if you build a hierarchy of exception 
 * classes deriving from the Observable_Exception class, you can attach any number 
 * of observers to each type of observable exception, allowing for the customization 
 * of the exception envir­ onment at any time without necessitating that changes 
 * be made to the actual excep­ tion code. It also means that only the top-level 
 * exception class needs to contain any additional code; all classes that derive 
 * from that class can be empty stubs. Finally, each observer’s update method can 
 * use type hinting via PHP’s instanceof operator to decide whether or not any 
 * action needs to be taken.
 */

require_once 'dpcore.observer.php';
require_once 'dpcore.observable.php';

class coreLogExceptionObserver {

    protected $_filename = '../tmp/exception.log';

    /**
     * 
     * @param type $filename
     */
    public function __construct($filename = null) {
        if ((null !== $filename) && is_string($filename)) {
            $this->_filename = $filename;
        }
    }
    
    /**
     * 
     * @param Observable_Exception $e
     */
    public function update(Observable_Exception $e) {
        error_log($e->getTraceAsString(), 3, $this->_filename);
    }

}

?>
