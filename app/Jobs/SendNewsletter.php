<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{User,Subscribers};

class SendNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $mail_data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail_data)
    {
        //
        $this->mail_data = $mail_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        
        $users = User::join('crc_user_setting', function ($join) {
                            $join->on('crc_user_setting.user_id', '=', 'users.id');
                        })->where('role_id',1)->where('crc_user_setting.newsletter',1)->get();
        $emailData = [];
        $emailData['subject'] = $this->mail_data['subject'];
        $emailData['data'] = $this->mail_data['data'];
        if(!empty($users)){
            foreach ($users as $key => $value) {
                \Mail::send('emails/newsletterbuyer', $emailData, function ($message)use ($emailData,$value) {
                                $message->to($value->email);
                                $message->cc('admin@classroomcopy.com');
                                $message->subject($emailData['subject']);
                            });
            }
        }

        //Subs
        $subs = Subscribers::get();
        if(!empty($subs)){
            foreach ($subs as $k => $v) {
                \Mail::send('emails/newsletterbuyer', $emailData, function ($message)use ($emailData,$v) {
                                $message->to($v->email);
                                $message->cc('admin@classroomcopy.com');
                                $message->subject($emailData['subject']);
                            });
            }
        }
    }  
}
