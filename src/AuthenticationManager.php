<?php

namespace Lexty\AuthManager;


use Lexty\AuthManager\Exception\AuthenticationException;
use Lexty\AuthManager\Exception\AuthenticatorNotFoundException;
use Lexty\AuthManager\Token\TokenInterface;

class AuthenticationManager implements AuthenticationManagerInterface
{
    /**
     * @var AuthenticatorInterface[]
     */
    private $authenticators = [];
    private $eraseCredentials;

    /**
     * @param AuthenticatorInterface[] $authenticators
     * @param bool                     $eraseCredentials
     */
    public function __construct(array $authenticators, $eraseCredentials)
    {
        if (!$authenticators) {
            throw new \InvalidArgumentException('You must at least add one authenticator.');
        }

        foreach ($authenticators as $authenticator) {
            if (!$authenticator instanceof AuthenticatorInterface) {
                throw new \InvalidArgumentException(sprintf('Authenticator %s must implements the AuthenticatorInterface.', get_class($authenticator)));
            }
        }

        $this->authenticators = $authenticators;
        $this->eraseCredentials = (bool) $eraseCredentials;
    }

    public function authenticate(TokenInterface $token)
    {
        $result = null;

        try {
            foreach ($this->authenticators as $authenticator) {
                if (!$authenticator->supports($token)) {
                    continue;
                }
                $result = $authenticator->authenticate($token);
            }
        } catch (AuthenticationException $e) {
            $e->setToken($token);
            throw $e;
        }

        if (null !== $result) {
            if ($this->eraseCredentials) {
                $result->eraseCredentials();
            }
            return $result;
        }

        $e = new AuthenticatorNotFoundException(sprintf('No Authenticator found for token of class "%s".', get_class($token)));
        $e->setToken($token);
        throw $e;
    }
}