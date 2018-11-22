<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use App\Models\Mail;


class SendRegisterEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $code;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $code)
    {
        //
        $this->email = $email;
        $this->code = $code;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $code = ['code' => $this->code];
        $email = $this->email;
        //删除

        Mail::where('email', '=', $email)->where('send_type', '=', 1)->delete();

        Mail::create(['email' => $this->email, 'code' => $this->code, 'send_type' => 1]);


        \Log::info('[注册验证码]:' . $this->email . '验证码为：' . $this->code);
        \Mail::send('mail.emailCode', $code, function ($message) use ($email) {
            $message->from('13037125104@163.com', '陈明');
            $message->subject('注册验证码');
            $message->to($email);
        });

        //存入数据中
    }
}
