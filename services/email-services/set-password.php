<?php
declare(strict_types=1);

namespace services\email_services;

class SetPassword
{
    private $password;
    const MIN_LENGTH = 8;

    public function __construct(string $password)
    {
        if ($this->passwordShouldNotBeEmpty($password) && $this->passwordShouldBeMoreThanEightCharacters($password))
        {
            $this->password = $password;
        }
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    private function passwordShouldNotBeEmpty(string $password)
    {
        if (empty($password))
        {
            throw new \InvalidArgumentException("Password Should Not Be Empty!", 4008);
        } else {
            return true;
        }
    }

    private function passwordShouldBeMoreThanEightCharacters(string $password)
    {
        if (strlen($password) < self::MIN_LENGTH)
        {
            throw new \InvalidArgumentException("Password Should Be Greater Than 8 Characters!", 4009);
        } else {
            return true;
        }
    }
}
