<?php
declare(strict_types=1);

namespace services\email_services;

class PhpMail
{
    private $mailConf;

    public function __construct(MailConf $mailConf)
    {
        $this->mailConf = $mailConf;
    }

    /**
     * @return MailConf
     */
    public function getMailConf(): MailConf
    {
        return $this->mailConf;
    }

}
