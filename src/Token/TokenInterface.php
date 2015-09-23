<?php

namespace Lexty\AuthManager\Token;

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

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes);

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasAttrbiute($key);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getAttrbinute($key);

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function setAttribute($key, $value);
}