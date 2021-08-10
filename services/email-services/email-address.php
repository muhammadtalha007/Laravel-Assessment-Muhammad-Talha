<?php
declare(strict_types=1);

namespace services\email_services;

class EmailAddress
{
    private $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            throw new \InvalidArgumentException("Invalid Email : Correct Format (example@something.com)", 1502);
        }

            $this->email = $email;
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
