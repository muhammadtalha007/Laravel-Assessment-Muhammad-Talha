<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use services\email_messages\InvitationMessageBody;
use services\email_services\EmailAddress;
use services\email_services\EmailBody;
use services\email_services\EmailMessage;
use services\email_services\EmailSender;
use services\email_services\EmailSubject;
use services\email_services\MailConf;
use services\email_services\PhpMail;
use services\email_services\SendEmailService;

class AdminController extends Controller
{
    public function inviteUser(Request $request){
        try {
            if (!empty($request->userEmail)){
                $userEmail = $request->userEmail;
                $subject = new SendEmailService(new EmailSubject("Invitation Email"));
                $mailTo = new EmailAddress($userEmail);
                $message = new InvitationMessageBody();
                $encodedEmail = JWT::encode($userEmail, 'secret-2021');
                $url = url('') . '/signup/' .$encodedEmail;
                $emailBody = $message->invitationMessageBody($url);
                $body = new EmailBody($emailBody);
                $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
                $sendEmail = new EmailSender(new PhpMail(new MailConf(env("MAIL_HOST"), env("MAIL_USERNAME"), env("MAIL_PASSWORD"))));
                $result = $sendEmail->send($emailMessage);
                return json_encode(['status' => true, 'message' => 'Invitation Sent Successfully']);
            }else{
                return json_encode(['status' => false, 'message' => 'Invalid Email']);
            }

        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'Server Error, Please try again later']);
        }
    }
}
