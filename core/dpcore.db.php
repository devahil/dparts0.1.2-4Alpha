<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */
/**
 * The structure for the access to all database system based on MySQL
 */
require_once 'dpcore.config.php';

class coredb {

    /**
     * Function that establishes the connection to the primary MySQL database
     * @return type connection
     */
    public function connect() {
        $config = new coreconfig();
        $con = mysql_connect($config->server, $config->user, $config->password);
        mysql_select_db($config->database, $con);
        return $con;
    }// END function connect

    /**
     * MySQL simple query, this is the basic instruction for the entire structure of the advanced functions
     * @param type $sql
     * @return type database query
     */
    public function query($sql) {
        $result = @mysql_query($sql, $this->connect());
        return $result; 
    }// END function query

}

// END class 
?>