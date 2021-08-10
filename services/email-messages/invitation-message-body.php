<?php

namespace services\email_messages;

class InvitationMessageBody
{
    public function invitationMessageBody($url)
    {
        $emailBody = '
   <body>
   <div style="margin: 0 auto;max-width: 600px;background: rgba(211,211,211,0.68);padding: 30px">


             <div style="margin-left: 10px;margin-right: 10px;font-size: 17px;padding-top: 2px">You are invited to signup. please click on below link to signup</div>
             <div style="margin-left: 10px;margin-right: 10px;font-size: 13px;padding-top: 10px"><a href="'.$url.'">click here</a>
</div><br>
 </div>
            </body>
            ';
        return $emailBody;
    }

    public function verificationCode($code){
        $emailBody = '
   <body>
   <div style="margin: 0 auto;max-width: 600px;background: rgba(211,211,211,0.68);padding: 30px">


             <div style="margin-left: 10px;margin-right: 10px;font-size: 17px;padding-top: 2px">Your verification code is '.$code.'</div>
</div><br>
 </div>
            </body>
            ';
        return $emailBody;
    }

}
