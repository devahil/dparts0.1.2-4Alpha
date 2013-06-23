<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */

/**
 * We create the Observable_Exception class by extending the Exception class. 
 * We add a static property—$_observers—to hold an array of Exception_Observer 
 * instances.
 */
class coreObserver extends Exception {

    public static $_observers = array();
    
    /**
     * A static method is used to attach observers. Type hinting enforces that 
     * only classes of the Exception_Observer type are allowed as observers.
     * 
     * @param Exception_Observer $observer
     */
    public static function attach(Exception_Observer $observer) {
        self::$_observers[] = $observer;
    }
    
    
    /**
     * We override the constructor method so that when the exception is 
     * instantiated all observers are notified via a call to the notify method.
     * 
     * @param type $message
     * @param type $code
     */
    public function __construct($message = null, $code = 0) {
        parent::__construct($message, $code);
        $this->notify();
    }
    
    /**
     * The notify method loops through the array of observers and calls their 
     * update methods, passing a self-reference to the Observable_Exception 
     * object, $this.
     */
    public function notify() {
        foreach (self::$_observers as $observer) {
            $observer->update($this);
        }
    }

}

?>
