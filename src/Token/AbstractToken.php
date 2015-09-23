<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 22.09.15
 * Time: 19:42
 */

namespace Lexty\AuthManager\Token;


abstract class AbstractToken implements TokenInterface
{
    /**
     * @var string|object
     */
    private $user;
    /**
     * @var bool
     */
    private $authenticated = false;
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return (string) $this->user;
    }

    /**
     * @return string|object
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param string|object $user The user.
     *
     * @throws \InvalidArgumentException
     */
    public function setUser($user)
    {
        if (!is_string($this->user) && !(is_object($this->user) && method_exists($this->user, '__toString'))) {
            throw new \InvalidArgumentException('$user must be an object implementing a __toString method, or a primitive string.');
        }
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthenticated($authenticated)
    {
        $this->authenticated = (bool) $authenticated;
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthenticated()
    {
        return $this->authenticated;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            is_object($this->user) ? clone $this->user : $this->user,
            $this->authenticated
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->user, $this->authenticated) = unserialize($serialized);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $class = get_class($this);
        $class = substr($class, strrpos($class, '\\') + 1);
        return sprintf('%s(user="%s", authenticated=%s)', $class, $this->getUsername(), json_encode($this->authenticated));
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        if (is_object($this->getUser()) && method_exists($this->getUser(), 'eraseCredentials')) {
            $this->getUser()->eraseCredentials();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function hasAttrbiute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttrbinute($key)
    {
        if (!array_key_exists($key, $this->attributes)) {
            throw new \InvalidArgumentException(sprintf('This token has no "%s" attribute.', $key));
        }
        return $this->attributes[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }
}