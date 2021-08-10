<?php
declare(strict_types=1);

namespace services\email_services;

class EmailMessage
{
    private $subject;
    private $emailTo;
    private $emailBody;
    private $attachment;
    private $attachmentList;
    private $cc;
    private $bcc;
    private $bccList;

    public function __construct(EmailSubject $subject, EmailAddress $emailTo, EmailBody $emailBody, string $attachment='', string $cc='', string $bcc='')
    {
        $this->emailBody = $emailBody;
        $this->emailTo = $emailTo;
        $this->subject = $subject;
        $this->attachment = $attachment;
        $this->cc = $cc;
        $this->bcc = $bcc;
        $this->attachmentList = [];
        $this->ccList = [];
        $this->bccList = [];
    }

    /**
     * @return EmailBody
     */
    public function getEmailBody(): EmailBody
    {
        return $this->emailBody;
    }

    /**
     * @return EmailAddress
     */
    public function getEmailTo(): EmailAddress
    {
        return $this->emailTo;
    }

    /**
     * @return EmailSubject
     */
    public function getSubject(): EmailSubject
    {
        return $this->subject;
    }

    /**
     * @return mixed
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * @return mixed
     */
    public function getCc()
    {
        return $this->cc;
    }

    /**
     * @return array
     */
    public function getAttachmentList(): array
    {
        return $this->attachmentList;
    }

    /**
     * @return array
     */
    public function getCcList(): array
    {
        return $this->ccList;
    }

    /**
     * @return array
     */
    public function getBccList(): array
    {
        return $this->bccList;
    }

    public function addAttachment($attachment)
    {
        array_push($this->attachmentList, $attachment);
    }

    public function addCc($cc)
    {
        array_push($this->ccList, $cc);
    }

    public function addBcc($bcc)
    {
        array_push($this->bccList, $bcc);
    }

}
