<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{User,UserSettings,Follower,Subscribers};

class SendResourceSuggestion implements ShouldQueue
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
        $users = User::where('role_id',2)->where('status',1)->where('process_completion',3)->get();
        if($this->mail_data['buyer'] != 'all'){
            $users = User::where('id',$this->mail_data['buyer'])->get();
        }
        $input['subject'] = $this->mail_data['subject'];
        $input['data'] = $this->mail_data['data'];
        $emailData = $this->mail_data['data'];
        if(!empty($users)){
            foreach ($users as $key => $value) {
                $input['email'] = $value->email;
                $input['name'] = $value->name;
                \Mail::send('emails/sendnotificationbuyer', $input['data'], function ($message)use ($input) {
                    $message->to($input['email']);
                    $message->cc('admin@classroomcopy.com');
                    $message->subject($input['subject']);
                });
            }  
        }
        
    }
}
