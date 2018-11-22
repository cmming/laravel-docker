<?php

namespace App\Http\Controllers\Tool;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Mail;
use App\Jobs\SendRegisterEmail;

class MailController extends Controller
{
    private $mail;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    //
    public function sendMailToRegister(Request $request)
    {
        $validator = \Validator::make($request->input(), [
            'email' => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return $this->errorBadRequest($validator);
        }
        $email = $request->get('email');
        //发送重置密码的链接

        $code = $this->randomkeys(8);


        // 用户注册成功后发送邮件
        dispatch(new SendRegisterEmail($email, $code));

        return $this->response->created();
    }

    public function activeCount()
    {
    }

    public function sendMailToResetPwd()
    {
    }

    public function ResetPwd()
    {
    }
}
