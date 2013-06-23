<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */


/**
 * Like PHP errors, exceptions can be handled automatically using a custom exception 
 * handler that’s specified with the set_exception_handler function.
 * 
 * You’d typically implement an exception handler if you wanted your program to 
 * take a particular action for an uncaught exception—for example, you might want 
 * to redirect the user to an error page, or to log or email the exception so the 
 * developer can correct the issue.
 * 
 * Since exception handlers handle any uncaught exception—not exceptions of specific 
 * types—they’re somewhat easier to implement than error handlers. 
 * 
 * In this Class, we create a custom exception-handling class that logs uncaught 
 * exceptions to a file, and displays a simple error page.
 * 
 */

require_once 'dpcore.config.php';

class coreExceptionHandler {

    protected $_exception;
    protected $_logFile = '/tmp/exception.log';
    

    /**
     * 
     * @param Exception $e
     */
    public function __construct(Exception $e) {
        $this->_exception = $e;
    }
    
    /**
     * The entry point for this exception handler is the static handle method, 
     * which in­ stantiates itself, logs the exception, then displays an error 
     * message by echoing itself (using the magic __toString method). 
     * 
     * If you’re testing this code, make sure you set the $_logFile variable to 
     * an appropriate location and filename.
     * 
     * @param Exception $e
     */
    public static function handle(Exception $e) {
        $self = new self($e);
        $self->log();
        echo $self;
    }
    
    /**
     * This code uses PHP’s error_log function to log the exception backtrace to a file
     */
    public function log() {
        error_log($this->_exception->getTraceAsString(), 3, $this->_logFile);
    }
    
    
    /**
     * The __toString implementation below creates a “pretty” error page that’s 
     * displayed when an exception is handled, preventing the display to users 
     * of any sensitive in­ formation contained in the exception backtrace.
     * 
     * @return string HTML
     */
    public function __toString() {
        $conf = new coreconfig();
        $message = <<<EOH
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Error</title>
  </head>
  <body>
    <h1>An error occurred in this application</h1>
    <p>
      An error occurred in this application; please try again. If
      you continue to receive this message, please
      <a href="mailto:$conf->mailadmin"
          >contact the webmaster</a>.
    </p>
  </body>
</html>
EOH;
        return $message;
    }

}

set_exception_handler(array('ExceptionHandler', 'handle'));
?>
