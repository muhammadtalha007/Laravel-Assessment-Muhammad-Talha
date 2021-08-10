<?php
declare(strict_types=1);

namespace services\email_services;

class EmailBody
{
    private $emailBody;

    public function __construct(string $emailBody)
    {
        $this->emailBody = $emailBody;
    }

    /**
     * @return string
     */
    public function getEmailBody(): string
    {
        return $this->emailBody;
    }
}
