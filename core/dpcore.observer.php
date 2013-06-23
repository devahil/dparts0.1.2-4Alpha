<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */

/**
 * This strategy provides some flexibility in terms of the way exceptions are 
 * handled, without requiring the use of an explicit exception handler. 
 * 
 * In addition, you can attach an observer anywhere in your code, which means 
 * that you can decide how to handle any given exception dynamically.
 */


/**
 * This code defines the interface for exception observers. 
 * We’ll implement the Exception_Observer interface in a custom class in just 
 * a minute.
 */
interface Exception_Observer {

    public function update(Observable_Exception $e);
}


?>
