<?php

namespace Lexty\AuthManager;

use Lexty\AuthManager\Token\TokenInterface;

interface AuthenticationManagerInterface
{
    public function authenticate(TokenInterface $token);
}