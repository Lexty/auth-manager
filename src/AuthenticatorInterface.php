<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 22.09.15
 * Time: 19:19
 */

namespace Lexty\AuthManager;

interface AuthenticatorInterface
{
    public function authenticate(TokenInterface $token);
}