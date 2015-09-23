<?php
/**
 * @author Alexandr Medvedev <medvedevav@niissu.ru>
 */

namespace Lexty\AuthManager\Authenticator;

use Lexty\AuthManager\Encoder\PasswordEncoderInterface;
use Lexty\AuthManager\Exception\AuthenticationException;
use Lexty\AuthManager\Exception\DisabledException;
use Lexty\AuthManager\Exception\UserNotFoundException;
use Lexty\AuthManager\Token\TokenInterface;
use Lexty\AuthManager\Token\UsernamePasswordToken;

abstract class AbstractUsernamePasswordAuthenticator implements AuthenticatorInterface
{
    /**
     * @var PasswordEncoderInterface
     */
    private $encoder;

    /**
     * @param PasswordEncoderInterface $encoder
     */
    public function __construct(PasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof UsernamePasswordToken;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(TokenInterface $token)
    {
        if (!$this->supports($token)) {
            throw new AuthenticationException(sprintf('The token "%s" does not supported.', get_class($token)));
        }

        $user = $this->findByUsername($token->getUsername());
        if (null === $user) {
            throw new UserNotFoundException(sprintf('User "%s" does not exists.', $token->getUsername()));
        }

        $token->setUser($user);

        if ($this->isDisabledAccount($user)) {
            throw new DisabledException('Account is disabled.');
        }

        $token->setAuthenticated($this->encoder->isPasswordValid($this->getPassword($user), $token->getCredentials(), $this->getSalt($user)));

        return $token;
    }

    /**
     * @param string $username
     *
     * @return mixed
     */
    abstract public function findByUsername($username);

    /**
     * @param mixed $user
     *
     * @return string
     */
    abstract public function getPassword($user);

    /**
     * @param mixed $user
     *
     * @return string
     */
    abstract public function getSalt($user);

    /**
     * @param mixed $user
     *
     * @return bool
     */
    abstract public function isDisabledAccount($user);
}