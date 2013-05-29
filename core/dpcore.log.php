<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */

/**
 * Logic for emitting a directly stored LOG list data structure
 */
require_once 'dpcore.db.php';

class corelog {
    
    /**
     * Function to insert values ​​in a tuple user, action, date, hour, ip to keep track of activities in the application created 
     * with the core
     * @param string $usr
     * @param string $action 
     */
    public function putlog($usr, $action) {
        $data = new coredb();
        $userip = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO log (user, action, date, hour, ip) VALUES ('$usr', '$accion' ,CURDATE(), CURTIME(), '$userip')";
        $data->todo($sql);
    }

}

?>
