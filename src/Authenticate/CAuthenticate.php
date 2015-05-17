<?php
namespace Anax\Authenticate;

/**
 * Class, check if user is authenticated.
 *
 */
class CAuthenticate implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
    
    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        return $this->session->has('user') ? true : false;
    }
    
    public function getUserId()
    {
        return $this->session->get('user');
    }
}