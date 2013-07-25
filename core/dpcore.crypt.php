<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */
/**
 * In general this class contains all the logic for security actions and protection of your information. 
 * From encrypt data passed as a parameter to generate hash and / or passwords for use in the core of the application
 * 
 * Use a functions that allows encryption of the information to be passed to a database via MCrypt.
 * This encryption is directly dependent on a setting that is located in dpcore.config -> $key , $cipher and $mode attributes.
 */
require_once 'dpcore.config.php';

class corecrypt {

    /**
     * Function to encrypt data passed as parameter in the variable $data
     * @param string $data
     * @return string in cipher mode 
     */
    public function encrypt($data) {
        $cy = new coreconfig();
        return(string)
                base64_encode(
                        mcrypt_encrypt(
                                $cy->cipher, substr(md5($cy->key), 0, mcrypt_get_key_size($cy->cipher, $cy->mode)), $data, $cy->mode, substr(md5($cy->key), 0, mcrypt_get_block_size($cy->cipher, $cy->mode))
                        )
        );
    }

    /**
     * Function to decrypt data passed as parameter in the variable $data
     * @param string $data
     * @return string in normal mode 
     */
    public function decrypt($data) {
        $cyd = new coreconfig();
        return(string)
                mcrypt_decrypt(
                        $cid->cipher, substr(md5($cid->key), 0, mcrypt_get_key_size($cyd->cipher, $cyd->mode)), base64_decode($data), $cyd->mode, substr(md5($cyd->key), 0, mcrypt_get_block_size($cyd->cipher, $cyd->mode))
        );
    }

    /**
     * Function that will help you generate random password mode for use in core applications.
     * This only requires as a parameter the length in characters of the password. 
     * @param integer $num_chars
     * @return string as password generated 
     */
    public function make_pass($num_chars) {
        if ((is_numeric($num_chars)) && ($num_chars > 0) && (!is_null($num_chars))) {
            $password = "";
            $accepted_chars = 'abcdefghijklmnñopqrstuvwxyz1234567890';
            srand(((int) ((double) microtime() * 1000003)));
            for ($i = 0; $i <= $num_chars; $i++) {
                $random_number = rad(0, (strlen($accepted_chars) - 1));
                $password .= $accepted_chars[$random_number];
            }
            return $password;
        }
    }

}

?>
