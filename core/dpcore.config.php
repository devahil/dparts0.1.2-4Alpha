<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */

/**
 * The structure for the configuration to all core apps
 */
class coreconfig {

    /**
     * Config for the primary server database
     */
    public $server = ""; // Host for the database server
    public $user = ""; // User for the database
    public $password = ""; // Password for the database
    public $database = ""; // Database itself

    /**
     * Site Config
     */
    public $page_title = "";
    public $copyright = "";
    public $docs_dir = "";
    public $dev_dir = "";
    public $framework_dir = "core"; //Don't change
    public $logo = "../shared/images/logo.png"; //Just an example
    public $host = ""; // IP or Domain for AJAX or another things to use
    public $templates = "../templates";
    public $mailadmin = "";//A mail address to systemadmin
    
    /**
     * Crypt Config
     */
    public $key = "";//Secret passphrase used to encrypt your data
    public $cipher = "MCRYPT_SERPENT_256"; //Do not change, only if you want another method.
    public $mode = "MCRYPT_MODE_CBC"; //Do not change, only if you want another method.
}

?>