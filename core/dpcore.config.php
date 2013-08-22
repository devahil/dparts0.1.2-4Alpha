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
     * Change all the parameters as you need.
     * 
     * In the mayor of cases the path of MCRYPT ALGORITHMS and MODES is /usr/local/bin/mcrypt, please
     * consult all the documentation for the topic.
     */
    public $key = "";//Secret passphrase used to encrypt your data
    public $path_algorithms = "/usr/lib64/libmcrypt";
    public $path_modes = "/usr/lib64/libmcrypt";
    public $iv = ""// The second pass for encrypt or decrypt
}

?>
