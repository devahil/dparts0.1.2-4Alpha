<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */
/**
 * Interface that enables all the libraries into any project
 */

class autoloader{
    
    public static $loader;
    
    /**
     *
     * @return Object Creation 
     */
    public static function init(){
        if (self::loader == NULL)
            self::$loader = new self();
        
        return self::$loader;
    }
    
    /**
     * Construct the interface!
     */
    public function __construct() {
        spl_autoload_register(array($this.'library'));
    }
    
    /**
     * Return all include access to the core libs!
     * @param type $class 
     */
    public function library($class){
        set_include_path(get_include_path().PATH_SEPARATOR.'../core/');
        spl_autoload_extensions('.php');
        spl_autoload($class);
    }
    
}
?>