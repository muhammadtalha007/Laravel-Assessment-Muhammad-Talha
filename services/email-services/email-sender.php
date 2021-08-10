<?php
declare(strict_types=1);

namespace services\email_services;

use PHPMailer\PHPMailer\PHPMailer;

class EmailSender
{
    private $phpMail;

    public function __construct(PhpMail $phpMail)
    {
        $this->phpMail = $phpMail;
    }

    public function send(EmailMessage $emailMessage)
    {

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAutoTLS = false;
            $mail->SMTPAuth = true;
            $mail->Timeout = 5;
            $mail->Username = 'task.board007@gmail.com';
            $mail->Password = 'Toystory@123';
            $mail->setfrom("support@nincati.com");
            if(!empty(($emailMessage->getAttachment()))){
                $mail->addAttachment($emailMessage->getAttachment());
            }
            foreach ($emailMessage->getAttachmentList() as $attachment)
            {
                $mail->addAttachment($attachment);
            }
            $mail->addAddress($emailMessage->getEmailTo()->getEmail());
            $mail->Subject = ($emailMessage->getSubject()->getEmailSubject());
            $mail->msgHTML($emailMessage->getEmailBody()->getEmailBody());
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
}
