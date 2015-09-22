<?php

namespace Lexty\AuthManager;

class AuthenticationManager
{
    /**
     * @var AuthenticatorInterface[]
     */
    private $authenticators = [];

    /**
     * @param AuthenticatorInterface[] $authenticators
     */
    public function __construct(array $authenticators) {
        $this->authenticators = $authenticators;
    }
}