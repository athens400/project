<?php
namespace Anax\QA;

/**
 * Ensure saves to database are only made by authenticated users
 *
 */
trait TAuthenticateSave
{
    public function authenticateSave()
    {
        return $this->authenticate->isAuthenticated() ? true : false;
    }
}