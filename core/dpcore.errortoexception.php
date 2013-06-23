<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */

/**
 * This task is relatively simple. We need to create a custom exception class 
 * and, to handle errors, we must add a public static method that throws an 
 * exception—that is to say, creates an instance of itself.
 * 
 * This class does not need to extend Exception in particular—just an 
 * Exception-de­ rived class. You could, for instance, extend the Observable_Exception.
 */
class coreErrorToException {

    /*
     * 
     */
    public static function handle($errno, $errstr) {
        throw new self($errstr, $errno);
    }

}

set_error_handler(
        array('ErrorToException', 'handle'), E_USER_ERROR | E_WARNING | E_USER_WARNING
);


?>
