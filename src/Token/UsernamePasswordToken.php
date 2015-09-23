<?php
/**
 * @author Alexandr Medvedev <medvedevav@niissu.ru>
 */

namespace Lexty\AuthManager\Token;


class UsernamePasswordToken extends AbstractToken
{
    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $class = get_class($this);
        $class = substr($class, strrpos($class, '\\') + 1);
        return sprintf(
            '%s(user="%s", password="%s", authenticated=%s)',
            $class, $this->getUsername(),
            $this->getCredentials(),
            json_encode($this->isAuthenticated())
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return $this->password;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        parent::eraseCredentials();
        $this->password = null;
    }
}