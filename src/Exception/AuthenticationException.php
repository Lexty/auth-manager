<?php
/**
 * @author Alexandr Medvedev <medvedevav@niissu.ru>
 */

namespace Lexty\AuthManager\Exception;


use Lexty\AuthManager\Token\TokenInterface;

class AuthenticationException extends \RuntimeException implements \Serializable
{
    private $token;

    public function getToken()
    {
        return $this->token;
    }

    public function setToken(TokenInterface $token)
    {
        $this->token = $token;
    }

    public function serialize()
    {
        return serialize([
            $this->token,
            $this->code,
            $this->message,
            $this->file,
            $this->line,
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->token,
            $this->code,
            $this->message,
            $this->file,
            $this->line
        ) = unserialize($serialized);
    }
}