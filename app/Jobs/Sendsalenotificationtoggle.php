<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{User,UserSettings,Subscribers};

class Sendsalenotificationtoggle implements ShouldQueue
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
        $checkids = UserSettings::select(['user_id'])->where([['special_offer_sale','=',1]])->get();
        $users =array();
        if(!is_null($checkids)){
            $ids = array();
            foreach($checkids as $chk){
                $ids[] = $chk->user_id;
            }
            if(!empty($ids)){
                $users = User::whereIn('id',$checkids)->get();
            }
        }
        $input['subject'] = $this->mail_data['subject'];
        $input['data'] = $this->mail_data['data'];
        if(isset($this->mail_data['sell'])){
            $input['sell'] = 1;
        }
        if(!empty($users)){
            foreach ($users as $key => $value) {
                $input['email'] = $value->email;
                $input['name'] = $value->name;
                \Mail::send('emails/sendbuyersemail',$input, function($message) use($input){
                    $message->cc('admin@classroomcopy.com');
                    $message->to($input['email'], $input['name'])
                        ->subject($input['subject']);
                });
            }  
        }

        //Subs
        /*
        $subs = Subscribers::get();
        if(!empty($subs)){
            foreach ($subs as $k => $v) {
                \Mail::send('emails/sendbuyersemail',$input, function($message) use($input,$v){
                    $message->to($v->email, $v->email)
                        ->subject($input['subject']);
                });
            }
        }
        */
        
    }
}
