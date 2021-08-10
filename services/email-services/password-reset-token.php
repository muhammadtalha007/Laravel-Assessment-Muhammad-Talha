<?php
declare(strict_types=1);

namespace services\email_services;

class PasswordResetToken
{
    private $token;
    const MIN_SIZE = 64;
    const MAX_SIZE = 1024;

    public function __construct(int $length)
    {
        if ($this->tokenLengthIsNotLessThanZero($length) && $length < self::MAX_SIZE && $length > self::MIN_SIZE) {
            $this->token = bin2hex(random_bytes($length));
        }
    }

    private function tokenLengthIsNotLessThanZero($length)
    {
        if ($length < 0) {

            throw new \InvalidArgumentException("Password Token Less Than Zero Is Not Allowed", 1503);
        }
        return true;
    }

    public function gettoken()
    {
        return $this->token;
    }

}
