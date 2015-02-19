<?php

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

