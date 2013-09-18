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
    
    /**
     * Class that performs the handling of system messages, these messages kas llamdas corespond to system functions. 
     * sysmessage function can take to show the message that corresponds to each system messages.
     * The id's of the tabulated message, error messages by odd and satisfying action messages with numbers.
     * For aleras system is developed from the message let 1000.Función id user who creates a database, whereas user 
     * Tuen all mysql $ sudo privileges corresponds to your password
     * 
     * @param integer $idmessage
     * @return string
     */
    public function sysmessages($idmessage) {
        switch ($idmessage) {
            case "1":
                return "ERROR 1, PLEASE REFRESH THE SITE OR RESTART YOUR SESSION!";
                break;
            case "2":
                return "PROCEDURE PERFORMED SUCCESSFULLY!";
                break;
            case "3":
                return "UNACCESSIBLE OR CORRUPTED DATA!";
                break;
            case "4":
                return "DATA LOADED SUCCESSFULLY!";
                break;
            case "5":
                return "ERROR 5 REQUIRED DATA NOT FOUND!";
                break;
            case "6":
                return "ERROR 6 DUPLICATE DATA!";
                break;
            case "7";
                return "ERROR CODE: 2, INCORRECT ACCESS!";
                break;
        }
    }
    
}

?>
