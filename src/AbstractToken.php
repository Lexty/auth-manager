<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 22.09.15
 * Time: 19:42
 */

namespace Lexty\AuthManager;


abstract class AbstractToken implements TokenInterface
{
    private $user;
    private $authenticated = false;

    public function getUsername()
    {
        if (is_string($this->user) || (is_object($this->user) && method_exists($this->user, '__toString'))) {
            return (string) $this->user;
        }
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        if (!is_string($this->user) && !(is_object($this->user) && method_exists($this->user, '__toString'))) {
            throw new \RuntimeException('$user must be an object implementing a __toString method, or a primitive string.');
        }
        $this->user = $user;
    }

    public function getAuthenticated()
    {
        return $this->authenticated;
    }

    public function setAuthenticated($authenticated)
    {
        $this->authenticated = (bool) $authenticated;
    }

    abstract public function getCredentials();
    abstract public function eraseCredentials();
}