<?php

namespace Anax\Flash;

/**
 * Store messages for use as user feedback
 * Session must be started elsewhere
 *
 */
class CFlash
{
    

    
    /**
     * Store message to be shown
     *
     * @param string $message to be stored
     *
     * @return void
     */
     
    public function setMessage($message)
    {
        if(isset($_SESSION)) 
        {
            $_SESSION['flash-message'] = $message;
        }
    }
    
    /**
     * Get message
     *
     * @return string message;
     */
    public function getMessage()
    {
        return isset($_SESSION) ? (isset($_SESSION['flash-message']) ? $_SESSION['flash-message'] : null) : null;
    }
    
    public function error($message)
    {
        $this->htmlMessage($message, 'error');
    }
    
    public function success($message)
    {
        $this->htmlMessage($message, 'success');
    }
    
    public function notice($message)
    {
        $this->htmlMessage($message, 'notice');
    }
    
    public function warning($message)
    {
        $this->htmlMessage($message, 'warning');
    }
    
    /**
     * Put message in HTML div container
     *
     * @param string $message
     * @param string $type of message
     *
     * @return void
     */
    public function htmlMessage($message, $type)
    {
        $message = "<div class='flash-{$type}-message'>{$message}</div>";
        $this->setMessage($message);
    }
    
}