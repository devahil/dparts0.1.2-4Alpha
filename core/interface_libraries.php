<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 *
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 *
 */
/**
 * Interface that enables all the libraries into any project
 * Deactivates all error notifications, for handler exception Class.
*/

error_reporting(0);

require_once 'dpcore.compress.php';
require_once 'dpcore.config.php';
require_once 'dpcore.crypt.php';
require_once 'dpcore.db.php';
require_once 'dpcore.errorhandler.php';
require_once 'dpcore.errortoexception.php';
require_once 'dpcore.exceptionhandler.php';
require_once 'dpcore.file.php';
require_once 'dpcore.helpers.php';
require_once 'dpcore.log.php';
require_once 'dpcore.logobserver.php';
require_once 'dpcore.messagesubsystem.php';
require_once 'dpcore.observable.php';
require_once 'dpcore.observer.php';
require_once 'dpcore.search.php';
require_once 'dpcore.xmlserializer.php';
require_once 'dpcore.security.php'
?>
