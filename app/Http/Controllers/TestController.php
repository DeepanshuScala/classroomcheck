<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User};
use Illuminate\Support\Facades\{Auth, Hash, DB, Mail};
use Illuminate\Support\Str;
use Carbon\Carbon;
use Session;
use Exception;
use Validator;
use App\Traits\{FileProcessing};

class TestController extends Controller {
    use FileProcessing;
    
    public function testView(){
        $data                   =   [];
        $data['title']          =   'Test View';
        $data['home']           =   'Home';
        $data['breadcrumb1']    =   'Test View';
        $data['breadcrumb2']    =   false;
        $data['breadcrumb3']    =   false;
        $alldats = [
            "payee_name" => 'deep',
            "paid_email" => 'sonkhladeepanshu@gmail.com',
            "subject" => 'ji',
            "products" => [],
            "buyeraddress" => 'djewnffe wf wef wef wef erter er er ergergerg ger ger ger  ',
            "buyerpaymethod" =>'Credit Card',
            "couponcode" => 'dewdwefwe3',
            "discount" => 400,
            "subtotal" =>'',
            "salestax" =>'',
            "total" =>400,
            "totalprice" =>300,
            "orderid" =>'34e34r34r4',
        ];

        Mail::send('emails/cart_checkout_payment', $alldats, function ($message)use ($alldats) {
            $message->to('sonkhladeepanshu@gmail.com');
            $message->subject('Hi');
        });
        return view('testView',compact(['data']));
    }
    
    public function imageUpdateTest(Request $request) {
        $responseArray  = ['success' => false, 'message' => ''];
        try {
            $validation = Validator::make(
                $request->all(),
                [
                    'image' => 'required|max:2048',
                ],
                [
                    'image.required' => 'Please select image files!',
                    'image.max' => 'Image size should not be greater than 2mb!',
                ]
            );
            if($validation->fails()){
                $responseArray['error']     = $validation->errors();
                $responseArray['message']   = $validation->errors()->first();
            } else {
                if ($request->hasfile('image')){
                    $file = $request->file('image');
                    $path = 'public/uploads/profile_picture';
                    $name = time().'_'.$file->getClientOriginalName();
                    $uploaded_pic['profile_pic']    =   $name;
//                    $file->storeAs($path,$name);
    //                $this->deleteFile($path.'/'.$user->profile_pic);
    //                $filename = ['profile_pic'];
    //                $uploaded_pic = $this->fileUploadHandling($request,$filename,$path);
                } else {
                    $uploaded_pic['profile_pic']                  =   1;
                }
                $responseArray['success']   = true;
                $responseArray['data']      = $uploaded_pic['profile_pic'];
                $responseArray['message']   = 'Profile image updated successfully!';
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }
    
    
    
    
}
