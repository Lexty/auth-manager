<?php
/**
 * @author Alexandr Medvedev <medvedevav@niissu.ru>
 */

namespace Lexty\AuthManager\Encoder;

use Lexty\AuthManager\Exception\BadCredentialsException;

class BCryptPasswordEncoder extends AbstractPasswordEncoder
{
    /**
     * @var int
     */
    private $cost;

    public function __construct($cost)
    {
        $cost = (int) $cost;
        if ($cost < 4 || $cost > 31) {
            throw new \InvalidArgumentException('Cost must be in the range of 4-31.');
        }
        $this->cost = $cost;
    }

    public function encodePassword($raw, $salt)
    {
        if ($this->isPasswordTooLong($raw)) {
            throw new BadCredentialsException('Invalid password.');
        }
        $options = ['cost' => $this->cost];
        if ($salt) {
            $options['salt'] = $salt;
        }
        return password_hash($raw, PASSWORD_BCRYPT, $options);
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        return !$this->isPasswordTooLong($raw) && password_verify($raw, $encoded);
    }
}