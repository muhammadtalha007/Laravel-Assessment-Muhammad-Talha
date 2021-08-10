<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVerification;
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

class UserController extends Controller
{
    public function signup(Request $request){
        try {
            if (!empty($request->userEmail) && !empty($request->userName) && !empty($request->password)){
                if (strlen($request->userName) < 4 || strlen($request->userName) > 20){
                    return json_encode(['status' => false, 'message' => 'Username should not be less than 4 or greater than 20 characters']);
                }
                $user = new User();
                $user->email = $request->userEmail;
                $user->username = $request->userName;
                $user->password = md5($request->password);
                $user->save();
                $subject = new SendEmailService(new EmailSubject("Verification Code"));
                $mailTo = new EmailAddress($user->email);
                $message = new InvitationMessageBody();
                $code =  random_int(100000, 999999);
                $emailBody = $message->verificationCode($code);
                $body = new EmailBody($emailBody);
                $emailMessage = new EmailMessage($subject->getEmailSubject(), $mailTo, $body);
                $sendEmail = new EmailSender(new PhpMail(new MailConf(env("MAIL_HOST"), env("MAIL_USERNAME"), env("MAIL_PASSWORD"))));
                $result = $sendEmail->send($emailMessage);

                $userVerification = new UserVerification();
                $userVerification->user_id = $user->id;
                $userVerification->code = $code;
                $userVerification->save();
                return json_encode(['status' => true, 'message' => 'Success! Verification Code sent to your email.']);
            }else{
                return json_encode(['status' => false, 'message' => 'Invalid inputs']);
            }

        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'Server Error, Please try again later']);
        }
    }

    public function verifyCode(Request $request){
        try {
            if (!empty($request->userEmail)){
                if (UserVerification::where('code', $request->code)->exists()){
                   $userVerification = UserVerification::where('code', $request->code)->first();
                   $user = User::where('email', $request->userEmail)->where('id', $userVerification->user_id)->exists();
                   if ($user){
                       $userVerification = UserVerification::where('code', $request->code)->first();
                       $userVerification->verified = 1;
                       $userVerification->update();
                       return json_encode(['status' => true, 'message' => 'Verification Successfull! You can now login anytime.']);
                   }else{
                       return json_encode(['status' => false, 'message' => 'Invalid Code']);
                   }
                }else{
                    return json_encode(['status' => false, 'message' => 'Invalid Code']);
                }

            }else{
                return json_encode(['status' => false, 'message' => 'Invalid inputs']);
            }

        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'Server Error, Please try again later']);
        }
    }


    public function login(Request $request){
        try {
            if (!empty($request->userEmail) && !empty($request->password)){
                if (User::where('email', $request->userEmail)->exists()){
                   $user = User::where('email', $request->userEmail)->first();
                   if (!UserVerification::where('user_id', $user->id)->where('verified', 1)->exists()){
                       return json_encode(['status' => false, 'message' => 'You are not verified.']);
                   }
                   if ($user->password == md5($request->password)){
                       $token = JWT::encode($user->id, 'secret-2021');
                       return json_encode(['status' => true, 'message' => 'Login Successfull', 'token' => $token]);
                   }else{
                       return json_encode(['status' => false, 'message' => 'Invalid Email or Password']);
                   }
                }else{
                    return json_encode(['status' => false, 'message' => 'Invalid Email or Password']);
                }

            }else{
                return json_encode(['status' => false, 'message' => 'Invalid inputs']);
            }

        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => 'Server Error, Please try again later']);
        }
    }

    public function updateProfile(Request $request){
        try {
            $userId = JWT::decode($request->token, 'secret-2021', array('HS256'));
            if (User::where('id', $userId)->exists()){
                if (strlen($request->userName) < 4 || strlen($request->userName) > 20){
                    return json_encode(['status' => false, 'message' => 'Username should not be less than 4 or greater than 20 characters']);
                }
                $user = User::where('id', $userId)->first();
                $user->name = $request->name;
                $user->username = $request->userName;

                if ($request->hasfile('avatar')) {
                    $file = $request->file('avatar');
                        $extension = $file->getClientOriginalExtension();
                        if ($extension == 'png' || $extension == 'jpg'){
                            list($width, $height, $type, $attr) = getimagesize($file);
                            if ($width == 256 && $height == 256){
                                $name = rand(0, 1000) .time() . '.' . $file->getClientOriginalExtension();
                                $file->move(base_path('/data') . '/files/', $name);
                                $user->avatar = $name;
                            }else{
                                return json_encode(['status' => false, 'message' => 'Image dimension should 256 X 256']);
                            }

                        }else{
                            return json_encode(['status' => false, 'message' => 'Only image is allowed as avatar']);
                        }

                }
                $user->update();
                return json_encode(['status' => true, 'message' => 'Profile Updated']);
            }else{
                return json_encode(['status' => false, 'message' => 'Access Denied']);
            }

        }catch (\Exception $exception){
            return json_encode(['status' => false, 'message' => $exception->getMessage()]);
        }
    }
}
