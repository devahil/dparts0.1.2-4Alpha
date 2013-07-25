<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */
/**
 * Class that implements the message subsystem and system trays messaging user or between users, this class can 
 * somehow extend or operate in parallel with the class or syslogs sysmessages. 
 * 
 * To identify a mail always use $id_mail table involves reading the mails and mails index table. 
 * 
 * For most of the functions are not required to read the message of the table is why sysmail takes an index table, 
 * also the model of message delivery is 1 -> n 
 * 
 * States of the messages:
 * > 0: deleted
 * > 1: unread
 * > 2: read
 * 
 * Includes specific methods for displaying messages and view depending on the skeleton that was placed in the 
 * administration, as the mail subsystem is a general management tool that can store the log and events trays system 
 * towards a specific user, in this case managers.
 */
include_once 'dpcore.db.php';
include_once 'dpcore.log.php';

class coremessage {

    /**
     * Function to create messages as parameters receives the source, which is extracted from _SESSION-> [LOGIN_USER], 
     * subject and message destination are passed from the forms that are created to make the POST function variables.
     * @param string $source
     * @param string $destiny
     * @param string $subject
     * @param string $message 
     */
    public function send_users_message($source, $destiny, $subject, $message) {
        $data = new coredb();
        $status = "1";
        $data->todo("INSERT INTO sysmail (source, subject, message, date, hour) VALUES ('$source', '$subject', '$message', CURDATE(), CURTIME())");
        $id_mail = $data->extract_data("SELECT id_mail FROM sysmail WHERE source = '$source' AND subject = '$subject' AND message LIKE '$message'");
        $data->todo("INSERT INTO indexmail (id_mail, destiny, status) VALUES ('$id_mail', '$destiny', '$status')");
    }
    
    /**
     * Function that removes a selected message, just put the flag 0 reading on campus visible
     * @param string $id_mail 
     */
    public function delete_message($id_mail){
        $data = new coredb();
        $status = "0";
        $data->todo("UPDATE indexmail SET status = '$status' WHERE id_mail = '$id_mail'");
    }
    
    /**
     * Function to create messages from the system, depending on the events of the same. 
     * We need as parameters the system message, the target (tray) and the title of the message.
     * @param string $destiny
     * @param string $title
     * @param string $idmessage 
     */
    public function send_system_message($destiny, $title, $idmessage){
        $data = new coredb();
        $sysm = new corelog();
        $status = "1";
        $source = "SYSTEM";
        $sysm->sysmessages($idmessage);
        $data->todo("INSERT INTO sysmail (source, subject, message, date, hour) VALUES ('$source', '$title', '$sysm', CURDATE(), CURTIME())");
        $id_mail = $data->extract_data("SELECT id_mail FROM sysmail WHERE source = '$source' AND subject = '$title' AND message LIKE '$sysm'");
        $data->todo("INSERT INTO indexmail (id_mail, destiny, status) VALUES ('$id_mail', '$destiny', '$status')");
    }
    
    /**
     * Function to create messages from the system, depending on the events of the same. 
     * We need as parameters the system message, the target (tray) and the title of the message.
     * @param string $destiny
     * @param string $title
     * @param string $log 
     */
    public function send_system_log($destiny, $title, $log){
        $data = new coredb();
        $status = "1";
        $source = "SYSTEM";
        $data->todo("INSERT INTO sysmail (source, subject, message, date, hour) VALUES ('$source', '$title', '$log', CURDATE(), CURTIME())");
        $id_mail = $data->extract_data("SELECT id_mail FROM sysmail WHERE source = '$source' AND subject = '$title' AND message LIKE '$log'");
        $data->todo("INSERT INTO indexmail (id_mail, destiny, status) VALUES ('$id_mail', '$destiny', '$status')");
    }
    
    /**
     * Function that collects the total amount of message tray
     * @param string $user
     * @return string 
     */
    public function collector_count($user){
        $data = new coredb();
        $result = $data->extract_data("SELECT COUNT(id_mail) FROM indexmail WHERE destiny LIKE '$user'");
        if($result == NULL){
            return "0";
        }else{
            return $result;
        }
    }
    
    /**
     * function that collects the total number of unread messages in the tray
     * @param type $user
     * @return integer 
     */
    public function collector_count_nonread($user){
        $data = new coredb();
        $status = "1";
        $result = $data->extract_data("SELECT COUNT(id_mail) FROM indexmail WHERE destiny LIKE '$user' AND status = '$status'");
        if($result == NULL){
            return "0";
        }else{
            return $result;
        }
    }
    
    /**
     * function that collects the total number of read messages in the inbox
     * @param string $user
     * @return integer
     */
    public function collector_count_read($user){
        $data = new coredb();
        $status = "2";
        $result = $data->extract_data("SELECT COUNT(id_mail) FROM indexmail WHERE destiny LIKE '$user' AND status = '$status'");
        if($result == NULL){
            return "0";
        }else{
            return $result;
        }
    }
    
    /**
     * Function that displays the full message to read, passing as a parameter the id_mail
     * @param string $id_mail
     * @return array 
     */
    public function collector_data_message($id_mail){
        $data = new dwaf_mysql();
        $validate = new dwaf_mysql();
        if($validate->extract_data("SELECT status FROM indexmail WHERE id_mail = '$id_mail'") != "0"){
            return $data->extract_array("SELECT * FROM sysmail WHERE id_mail = '$id_mail'");
        }else{
            return "";
        }
    }
    
    

}

?>
