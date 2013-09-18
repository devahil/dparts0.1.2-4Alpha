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
 *           header ("Location: $redir?error_login=5");
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

require_once 'dpcore.log.php';
require_once 'dpcore.crypt.php';
require_once 'dpcore.config.php';

class coresessioncontrol {

    public function access_control($user, $pass){

        // objects
        $conf = new coreconfig();
        $message = new corelog();
        $data = new coredb();
        $cry = new corecrypt();

        $url = explode("?",$_SERVER['HTTP_REFERER']);
        $pag_referida=$url[0];
        $redir=$pag_referida;
     
        if ($_SERVER['HTTP_REFERER'] == ""){
            die ($message->sysmessages("7"));
            exit;
        }

        //--- begin of check system

        if (isset($user) && isset($pass)) {


        /**
         * If you can not connect to the database failed left the scrip 0 and redirect to the error page.
         */

            $result = $data->query("SELECT ID,usuario,pass,level FROM $table_users WHERE usuario='".$user."'") or die(header ("Location:  $redir?error_login=1"));

            if (mysql_num_rows($result) != 0) {

                $login = stripslashes($user);
                $password = $cry->encrypt($pass);

                $user_data = mysql_fetch_array($result);
            /**
             * We check the user name again contrasting with BD this time without backslashes, etc ...
             * If not correct, we left the script redirect to Error 4 error page.
             */
                if ($login != $user_data['usuario']) {
                    return Header ("Location: $redir?error_login=4");
                    exit;}

                // si el password no es correcto ..
                // salimos del script con error 3 y redireccinamos hacia la p�gina de error
                if ($password != $user_data['pass']) {
                    return Header ("Location: $redir?error_login=3");
                    exit;
                }

                unset($login);
                unset ($password);

                session_name($conf->app_session);
                session_start();
                session_cache_limiter('nocache,private');

                $_SESSION['user_id']=$user_data['ID'];
                $_SESSION['user_level']=$user_data['level'];
                $_SESSION['user_login']=$user_data['usuario'];
                $_SESSION['user_password']=$user_data['pass'];

                $pag=$_SERVER['PHP_SELF'];
                return Header ("Location: $pag?");
                exit;

            } else {
                return Header ("Location: $redir?error_login=2");
                exit;}
        }

        //--- the verificate system end
        // the else condition begins
        else {

            session_name($conf->app_session);
            session_start();

        /**
         * Check if variables are created identifying the user session,
         * the most common case is that once "killed" the session will try again
         * with the browser backwards.
         */

            if (!isset($_SESSION['user_login']) && !isset($_SESSION['user_password'])){

                session_destroy();
                die ($message->sysmessages("7"));
                exit;
            }
        }
        // --- end of else

    }

}
?>
