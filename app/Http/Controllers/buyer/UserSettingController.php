<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Session,
    Redirect,
    Auth,
    Mail
};
use \App\Models\{
    User,
    UserSettings
};
use \App\Http\Helper\ClassroomCopyHelper;

class UserSettingController extends Controller {

    public function updateUserSettings(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            $userId = auth()->user()->id;
            $key = $request->key;
            $attrVal = (int) $request->attrVal;

            UserSettings::where('user_id', $userId)->update([
                $key => $attrVal,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            if($key == 'newsletter'){
                if($attrVal == 1){
                    try {
                        $emailData = ['email'=>auth()->user()->email,'subject'=>'NEWSLETTER SUBSCRIPTION'];
                        $send_mail = Mail::send('emails/neslettersubscribemail', $emailData, function ($message)use ($emailData) {
                                    $message->to($emailData['email']);
                                    $message->cc('admin@classroomcopy.com');
                                    $message->subject($emailData['subject']);
                                });
                    } catch (Exception $e) {
                    }
                    ClassroomCopyHelper::Newsletter_subscribe(auth()->user()->email,auth()->user()->first_name,auth()->user()->surname);
                }
                else{
                    ClassroomCopyHelper::Newsletter_unsubscribe(auth()->user()->email);
                }
            }
            $responseArray['success'] = true;
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

}
