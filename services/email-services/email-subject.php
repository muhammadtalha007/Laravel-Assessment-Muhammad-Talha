<?php
declare(strict_types=1);

namespace services\email_services;

class EmailSubject
{
    private $emailSubject;

    public function __construct(string $emailSubject)
    {
        $this->emailSubject = $emailSubject;
    }

    /**
     * @return string
     */
    public function getEmailSubject(): string
    {
        return $this->emailSubject;
    }
}
