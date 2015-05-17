<?php

namespace Anax\Flash;

/**
 * Example for ANAX
 * Store messages for use as user feedback
 * Session must be started elsewhere
 *
 */
class CFlashAnax extends CFlash implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
    public function setMessage($message)
    {
            $this->session->set('flash-message', $message);
    }
    
    /**
     * Get message
     *
     * @return string message;
     */
    public function getMessage()
    {
        return $this->session->get('flash-message');
    }
    
}