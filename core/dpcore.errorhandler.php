<?php

/**
 * 	D-Parts Web App Framework v 0.1.2-4 APLHA
 * 	
 * 	@copyright Devahil Leivzieük, devahil@gmail.com 2010 - 2013
 * 	@author devahil@gmail.com
 * 	
 */

/**
 * An easier solution, however, is to use a single error handler for all error 
 * types you wish to handle, and in it employ a switch statement that uses the 
 * value of the first argument to the handler function—represented by $errno—to 
 * select alternative actions that respond to specific error types. $errno is 
 * the error level of the triggered error, the integer value represented by the 
 * error type constants listed in “What error levels does PHP report?”. 
 * 
 * Then, the error handler needs to return true if the error was handled, 
 * or false if not; returning false tells PHP to pass on error-handling control 
 * to the default error handler. As an example, here’s a PHP 5 class that 
 * imple­ ments a custom error handler which selects alternative actions 
 * appropriate to the level of the error raised.
 * 
 */

require_once 'dpcore.config.php';

class coreErrorHandler {

    protected $_noticeLog = '/tmp/notice.log';
    public $message = '';
    public $filename = '';
    public $line = 0;
    public $vars = array();

    
    /**
     * 
     * The constructor accepts the various error attributes as arguments and 
     * stores them in the object’s properties. The $_noticeLog variable stores 
     * the location of the log file for E_USER_NOTICE level error messages. 
     * 
     * If you’re testing on a Windows machine you should change this value to 
     * something like C:\notice.log, or an appropriate location on your system.
     * 
     * @param type $message
     * @param type $filename
     * @param type $linenum
     * @param type $vars
     */
    public function __construct($message, $filename, $linenum, $vars) {
        $this->message = $message;
        $this->filename = $filename;
        $this->linenum = $linenum;
        $this->vars = $vars;
    }
    
    
    /**
     * 
     * The handle method above instantiates an ErrorHandler object with the 
     * error mes­ sage, filename, line number, and variable context, and then 
     * calls the appropriate handler method based on $errno.
     * 
     * If the error level does not match the levels handled by this class, 
     * it reverts the error flow to the default error handler by returning false.
     * 
     * @param type $errno
     * @param type $errmsg
     * @param type $filename
     * @param type $line
     * @param type $vars
     * @return boolean
     */
    public static function handle($errno, $errmsg, $filename, $line, $vars) {
        $self = new self($errmsg, $filename, $line, $vars);
        switch ($errno) {
            case E_USER_ERROR:
                return $self->handleError();
            case E_USER_WARNING:
            case E_WARNING:
                return $self->handleWarning();
            case E_USER_NOTICE:
            case E_NOTICE:
                return $self->handleNotice();
            default:
                return false;
        }
    }

    /**
     * handleError is used to handle E_USER_ERROR level errors. When it’s called, 
     * this method sends an email to the system administrator and halts execution. 
     * It uses a little-known feature of PHP’s error_log function to send the 
     * email—if you specify 1 for the second argument and an email address as 
     * the third argument, it employs the php.ini settings for sendmail to send 
     * an email. Finally, handleError halts execu­ tion of the script using exit.
     */
    public function handleError() {
        $conf = new coreconfig();
        ob_start();
        debug_print_backtrace();
        $backtrace = ob_get_flush();
        $body = <<<EOT
A fatal error occured in the application:
Message:   {$this->message}
File:      {$this->filename}
Line:      {$this->line}
Backtrace:
{$backtrace}
EOT;
        error_log($body, 1, $conf->mailadmin, "Fatal error occurred\n");
        exit(1);
    }
    
    /**
     * handleWarning is used to handle E_USER_WARNING and E_WARNING errors. 
     * Like handleError above, it sends an email to the system administrator; 
     * however, instead of halting execution, it simply returns the result of 
     * the error_log function—true if the function succeeds, false if it fails.
     * 
     * @return type
     */
    public function handleWarning()
    {
        $conf = new coreconfig();
      $body =<<<EOT
An environmental error occured in the application, and may
 indicate a potential larger issue:
Message:   {$this->message}
File:      {$this->filename}
Line:      {$this->line}
EOT;
    return error_log($body, 1, $conf->mailadmin,
        "Subject: Non-fatal error occurred\n");
}

/**
 * handleNotice handles E_USER_NOTICE and E_NOTICE level errors. 
 * Since notices do not represent dangerous errors, we assume that the system 
 * administrator doesn’t need to know about them immediately, and log them to a 
 * file instead of sending an email.
 * 
 * @return type
 */
public function handleNotice()
    {
      $body =<<<EOT
A NOTICE was raised with the following information:
Message:   {$this->message}
File:      {$this->filename}
Line:      {$this->line}
EOT;
    $body = date('[Y-m-d H:i:s] ') . $body . "\n";
    return error_log($body, 3, $this->_noticeLog);
  }
  
}

set_error_handler(array('ErrorHandler', 'handle'));

?>
