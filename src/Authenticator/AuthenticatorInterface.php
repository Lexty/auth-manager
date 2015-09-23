<?php
/**
 * Created by PhpStorm.
 * User: alexandr
 * Date: 22.09.15
 * Time: 19:19
 */

namespace Lexty\AuthManager\Authenticator;

use Lexty\AuthManager\Token\TokenInterface;

interface AuthenticatorInterface
{
    /**
     * @param TokenInterface $token
     *
     * @return bool
     */
    public function supports(TokenInterface $token);
    /**
     * @param TokenInterface $token
     *
     * @return null|TokenInterface
     */
    public function authenticate(TokenInterface $token);
}