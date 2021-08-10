<?php
declare(strict_types=1);

namespace services\email_services;

class MailConf
{
    private $host;
    private $user;
    private $pass;

    public function __construct(string $host, string $user, string $pass)
    {

        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }


    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }
}
