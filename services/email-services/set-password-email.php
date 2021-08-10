<?php
declare(strict_types=1);

namespace services\email_services;

class SendEmailService
{
    private $emailSubject;

    public function __construct(EmailSubject $emailSubject)
    {
        $this->emailSubject = $emailSubject;

    }

    /**
     * @return \EmailSubject
     */
    public function getEmailSubject(): EmailSubject
    {
        return $this->emailSubject;
    }
}
