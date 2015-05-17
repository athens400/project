<?php
namespace Anax\Authenticate;

/**
 * Trait, check if user is authenticated
 *
 */
trait TAuthenticate
{
    /**
     * Check if user is authenticated
     *
     * @return bool
     */
    public function authenticateUser()
    {
        return $this->session->has('user');
    }
    
    /**
     * Get user id
     *
     * @return userid
     */
    public function getUserId()
    {
        return $this->session->get('user');
    }
    
    public function isAdmin()
    {   
        return $this->session->get('admin');
    }
    
    public function isOwner($id)
    {
        return $this->getUserId() == $id;
    }
}