<?php
/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 *
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 *
 */
/**
 * Class that contains the logic functions for control of sessions and blocks.
 * Provides access to certain of the apps built with the framework.
 *
 * The access control functionality must be written in the header or at the beginning
 * of any page protect needed by the same with the next block of code:
 *
 *       $access_level=5;
 *
 *       if ($acess_level <= $_SESSION['user_level']){
 *           header ("Location: [the location that you provide to handle exceptions]");
 *           exit;
 *       }
 *
 * In the strict sense, in the first line of these code we establishing security
 * parameters and access levels for each page.
 *
 * For example we can provide:
 *
 * 0 = developer mode
 * 1 = administrator mode
 * 2 = operation
 * 3 = otherwise
 *
 * So the session control also has a management approach of deliverable information to
 * users of the applications using these levels.
 *
 * The way to apply is through logical comparisons:
 *
 * If the maximum allowed level of access to a site is $ACCESS_LEVEL = 5, 
 * then all users listed in the example above could see this site.
 *
 * But if $ACCESS_LEVEL = 2, only members of the group of developers and administrators could see it.
 *
 * Another way is through comparative strictly inside the if:
 * $acess_level <= $ _SESSION ['user_level'], just changing the signs "<" and ">" by the criteria we need.
 */


require_once 'dpcore.config.php';
require_once 'dpcore.db.php';


class coresecurity {

    public function validate_user_session($user,$pass){
        $data = new coredb();
        if($data->extract_data("SELECT usuario FROM usuarios WHERE usuario LIKE '$user' AND pass LIKE '$pass'")==NULL){
            //no coinciden
            return "0";
        }else{
            //coinciden
            return "1";
        }   
    }
    
    public function create_session($user,$pass){
        $pass = md5($pass);
        $data = new coredb();
        $sect = "sessiondelivery";
        $param=$this->validate_user_session($user, $pass);
        if($param==0){
            unset($user,$pass);
            header('Location: ../index.php');
        }else{
            $usuario_datos=$data->extract_array("SELECT ID,usuario,pass,nivel_acceso FROM usuarios WHERE usuario LIKE '$user' and pass LIKE '$pass'");
            
            session_name($sect);
            session_start();
            session_cache_limiter('nocache,private');
            $_SESSION['usuario_id']=$usuario_datos['ID'];
            $_SESSION['usuario_nivel']=$usuario_datos['nivel_acceso'];
            $_SESSION['usuario_login']=$user;
            $_SESSION['usuario_password']=$pass;
            /* Creamos la sesión */
            unset($user,$pass);
            
        }
    }
    
}
?>

