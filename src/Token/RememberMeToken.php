<?php
/**
 * @author Alexandr Medvedev <medvedevav@niissu.ru>
 */

namespace Lexty\AuthManager\Token;

class RememberMeToken extends AbstractToken
{
    private $username;
    private $token;
    private $expired;

    public function __construct($username, $token)
    {

    }
}