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
    }

    /**
     * MySQL simple query, this is the basic instruction for the entire structure of the advanced functions
     * @param string $sql
     * @return type database query
     */
    public function query($sql) {
        $result = @mysql_query($sql, $this->connect());
        return $result;
    }

    /**
     * MySQL simple query, this command does not return values, ​​should be used for syntax UPDATE, INSERT or DROP, 
     * which do not require formal return status values
     * @param string $sql 
     */
    public function todo($sql) {
        mysql_query($sql, $this->connect());
    }
    
    /**
     * MySQL simple query, this statement returns a single value that is accessed from the database, this is depending on 
     * the SQL syntax to pass as a parameter
     * @param string $sql
     * @return string 
     */
    public function extract_data($sql) {
        return mysql_result($this->query($sql), 0);
    }

    /**
     * MySQL simple query that returns the settlement of a single model extraction for tuples
     * @param string $sql
     * @return array 
     */
    public function extract_array_row($sql) {
        return mysql_fetch_row($this->query($sql));
    }

    /**
     * MySQL simple query that returns the array of model extraction
     * @param string $sql
     * @return array 
     */
    public function extract_array($sql) {
        return mysql_fetch_array($this->query($sql));
    }
    
    /**
     * MySQL simple query that extracts the attributes (fields) of an entity (table)
     * @param string $entity
     * @return array 
     */
    public function extract_fields($entity) {
        return mysql_fetch_array($this->query("SHOW COLUMNS FROM $entity"));
    }

}

// END class 
?>