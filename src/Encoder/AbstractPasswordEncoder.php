<?php
/**
 * @author Alexandr Medvedev <medvedevav@niissu.ru>
 */

namespace Lexty\AuthManager\Encoder;

abstract class AbstractPasswordEncoder implements PasswordEncoderInterface
{
    const MAX_PASSWORD_LENGTH = 4096;

    protected function demergePasswordAndSalt($mergedPasswordSalt)
    {
        if (empty($mergedPasswordSalt)) {
            return ['', ''];
        }
        $password = $mergedPasswordSalt;
        $salt = '';
        $saltBegins = strrpos($mergedPasswordSalt, '{');
        if (false !== $saltBegins && $saltBegins + 1 < strlen($mergedPasswordSalt)) {
            $salt = substr($mergedPasswordSalt, $saltBegins + 1, -1);
            $password = substr($mergedPasswordSalt, 0, $saltBegins);
        }
        return [$password, $salt];
    }

    protected function mergePasswordAndSalt($password, $salt)
    {
        if (empty($salt)) {
            return $password;
        }
        if (false !== strrpos($salt, '{') || false !== strrpos($salt, '}')) {
            throw new \InvalidArgumentException('Cannot use { or } in salt.');
        }
        return $password.'{'.$salt.'}';
    }

    protected function comparePasswords($password1, $password2)
    {
        return $password1 === $password2;
    }

    protected function isPasswordTooLong($password)
    {
        return strlen($password) > static::MAX_PASSWORD_LENGTH;
    }
}