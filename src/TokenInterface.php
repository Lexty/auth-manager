<?php

namespace Lexty\AuthManager;

interface TokenInterface extends \Serializable
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return mixed
     */
    public function getUser();

    /**
     * @param mixed $user
     * @return mixed
     */
    public function setUser($user);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @return mixed
     */
    public function getCredentials();

    /**
     * Remove sensitive information from the token.
     */
    public function eraseCredentials();

    /**
     * @return bool
     */
    public function isAuthenticated();

    /**
     * @param bool $authenticated The authenticated flag.
     */
    public function setAuthenticated($authenticated);
}