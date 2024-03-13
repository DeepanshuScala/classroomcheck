<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Redirect,
    DB,
    Session,
    Validator,
    Crypt,
    Mail
};

use App\Models\{
    User,
    Country,
    State,
    Product,
    ProductImage,
    FavouriteItem,
    CartItem,
    VerifyUser,
    Store,
    Follower,
    UserCard,
    GiftCards,
    FeatureList,
    GradeLevels,
    SubjectDetails,
    ResourceTypes,
    crc_report_issue
};

class Issuereport extends Controller
{
    //
    public function store_issue(Request $request){
    	$userId = auth()->user()->id;
    	$reportAdded = crc_report_issue::create([
                            'order_id' =>$request->order_id,
                            'product_id' =>Crypt::decrypt($request->product_id),
                            'user_id' => $userId,
                            'subject' =>$request->subject,
                            'issue' => $request->issue
                ]);
                if ($reportAdded->id > 0) {
                    try {
                        $emailData = ['email'=>auth()->user()->email,'subject'=>'REPORTED PRODUCT ISSUES'];
                        $send_mail = Mail::send('emails/issue_report', $emailData, function ($message)use ($emailData) {
                                    $message->to($emailData['email']);
                                    $message->subject($emailData['subject']);
                                });
                    } catch (Exception $e) {
                    }
                    $responseArray['success'] = true;
                    $responseArray['message'] = "Issue Reported rated successfully";
                } else {
                    $responseArray['success'] = false;
                    $responseArray['message'] = "Something went wrong, Please try again later!";
                }
        return response()->json($responseArray, 200);
    }
}
