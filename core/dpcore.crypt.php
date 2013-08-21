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

    public function safe_b64encode($string) {

        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    /**
     * Function to encrypt data passed as parameter in the $data variable
     * @param string $value
     * @return boolean
     */
    public function encrypt($value){
        $cy = new coreconfig();
        if(!$value){
            return false;
        }
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_SERPENT, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_SERPENT, $cy->key, $text, MCRYPT_MODE_CBC, $iv);
        return trim($this->safe_b64encode($crypttext));
    }

    /**
     * Function to decrypt data passed as parameter in the $data variable
     * @param string $value
     * @return boolean
     */
    public function decrypt($value){
        $cy = new coreconfig();
        if(!$value){
            return false;
        }
        $crypttext = $this->safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_SERPENT, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_SERPENT, $cy->key, $crypttext, MCRYPT_MODE_CBC, $iv);
        return trim($decrypttext);
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
    
    /**
     * Function that returns a list of Algorithms supported by your server
     * @return array
     */
    public function get_algorithms(){
        $cnf = new coreconfig();
        return $algorithms = mcrypt_list_algorithms($cnf->path_algorithms);
    }
    
    /**
     * Function that returns a list of Modes supported by your server
     * @return array
     */
    public function get_modes(){
        $cnf = new coreconfig();
        return $modes = mcrypt_list_modes($cnf->path_modes);
    }

}

?>
