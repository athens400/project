<?php
namespace Anax\Users;

/**
 * Trait to create gravatar img url from email
 *
 */
trait TGravatar
{
    /**
     * Create and return gravatar url
     *
     * @param string $email
     *
     * @return string url;
     */
    public function getGravatarUrl($email)
    {
        return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($email)));
    }
}