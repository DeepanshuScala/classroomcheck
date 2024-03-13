<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    Country,
    State,
    VerifyUser,
    UserSettings,
    GiftCards,
    SellerOfferApplied
};
use Illuminate\Support\Facades\{
    Auth,
    Hash,
    DB,
    Mail,
    Storage,
    Redirect
};
use App\Mail\VerifyMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Session;
use Exception;
use Validator;
use App\Traits\{
    FileProcessing
};
use \App\Http\Helper\ClassroomCopyHelper;

class AuthController extends Controller {

    use FileProcessing;

    public function viewLogin(Request $request) {
        if (Auth::check()) {
            /* if (auth()->user()->role_id == 1) {
              return redirect('/account-dashboard');
              }
              if (auth()->user()->role_id == 2) {
              return redirect('/store-dashboard');
              } */
            if (auth()->user()->role_id == 3) {
                return redirect('/admin/dashboard');
            }
            else{
                if (auth()->user()->role_id == 2){
                    $email = $email = auth()->user()->email;
                    $userData = User::where('role_id', 1)->where('email', $email)->first();
                    if ($userData != null) {
                        Auth::logout();
                        if (!Auth::loginUsingId($userData->id)) {
                            return view('classroom_index');
                        }
                    }   
                }
            }
        }
        
        return view('classroom_index');
    }

    /** + 
     * used to switch on buyer/seller account
     * @param type $type - type of account need to switch
     * @return type
     */
    public function redirectAccountDashboard($type) {
        if (Auth::check()) {

            switch ($type):
                case 'account':
                    if (auth()->user()->role_id == 1) {
                        return redirect('/account-dashboard');
                    }
                    $email = $email = auth()->user()->email;
                    $userData = User::where('role_id', 1)->where('email', $email)->first();
                    if ($userData != null) {
                        Auth::logout();
                        if (Auth::loginUsingId($userData->id)) {
                            return redirect('/account-dashboard');
                        } else {
                            return view('classroom_index');
                        }
                    } else {
                        return view('classroom_index');
                    }
                    break;

                case 'seller':
                    if (auth()->user()->role_id == 2) {
                        if (auth()->user()->process_completion == 1)
                            return redirect('/become-a-seller');
                        else
                            return redirect('/store-dashboard');
                    }
                    $email = $email = auth()->user()->email;
                    $userData = User::where('role_id', 2)->where('email', $email)->first();
                    if ($userData != null) {
                        Auth::logout();
                        if (Auth::loginUsingId($userData->id)) {
                            if (auth()->user()->process_completion == 1)
                                return redirect('/become-a-seller');
                            else
                                return redirect('/store-dashboard');
                        } else {
                            return view('classroom_index');
                        }
                    } else {
                        return view('classroom_index');
                    }
                    break;

                default :
                    return view('classroom_index');
            endswitch;
            
        } else {
            return view('classroom_index');
        }
    }

    /** + 
     * used to add seller as admin relative request
     * @param Request $request - request type get
     */
    public function addSellerAdminRelative(Request $request) {
        $userData = auth()->user();
        $userData->is_admin_relative = 1;
        $userData->save();
        $adminEmail = env('ADMIN_EMAIL');
        $emailData = [
            "first_name" => auth()->user()->first_name,
            "subject" => 'Verify User',
            "verify_user_token" => base64_encode(auth()->user()->id),
            "content" => '',
            'adminEmail' => $adminEmail
        ];
        $send_mail = Mail::send('emails/admin_relative_verify_mail', $emailData, function ($message)use ($emailData) {
                    $message->to($emailData['adminEmail']);
                    $message->cc('admin@classroomcopy.com');
                    $message->subject($emailData['subject']);
                });
        return redirect('/become-a-seller');
    }

    public function authLogin(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            $validation = Validator::make($request->all(), User::$authLoginValidation, User::$authLoginCustomMessage);
            if ($validation->fails()) {
                $responseArray['error'] = $validation->errors();
                $responseArray['message'] = $validation->errors()->first();
            } else {
                $checkUserEmail = User::where('email', $request->email)->first();

                if (!$checkUserEmail) {
                    throw new Exception("Invalid username / Password");
                }
                if ($checkUserEmail->status == 2) {
                    throw new Exception("Your account is In-Active.");
                }

                $credentials = request(['email', 'password']);
                if (!Auth::attempt($credentials)) {
                    $responseArray['error'] = 'Unauthorized';
                    $responseArray['message'] = 'Please enter valid credentials';
                } else {
                    $user_details = auth()->user();
                    if (!$user_details->verified) {
                        Auth::logout();
                        throw new Exception("You need to confirm your account. We have sent you a verification link, please check your email.");
                    }
                    
                    if (!$user_details->status) {
                        
                        //check if seller account activated and completed 
                        $getsellr = User::where('email', auth()->user()->email)->whereNotin('id',[auth()->user()->id])->first();
                        if($getsellr && !$getsellr->status){
                            Auth::logout();
                            //throw new Exception("Your account is In-Active! Please contact site admin using Contact Us");
                            throw new Exception( $getsellr->is_deleted == 1 ?"Your account is Deleted!":"Your account is In-Active! Please contact site admin using Contact Us");
                        }
                        // Auth::logout();
                        // throw new Exception( $user_details->is_deleted == 1 ?"Your account is Deleted!":"Your account is In-Active! Please contact site admin using Contact Us");
                    }
                    if (auth()->user()->role_id == 1) {
                        $responseArray['user_type'] = 'account';
                    } else {
                        $responseArray['user_type'] = 'store';
                    }
                    $responseArray['success'] = true;
                    $responseArray['message'] = 'Logged In Successfully';
                }
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

    public function userRegistration(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            $validation = Validator::make($request->all(), User::$authLoginValidation, User::$authLoginCustomMessage);
            if ($validation->fails()) {
                $responseArray['error'] = $validation->errors();
                $responseArray['message'] = $validation->errors()->first();
            } else {
                
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

    //Account user registration:
    public function accountUserRegister(Request $request) {
        if(Auth::check()){
            return redirect()->route('classroom.index');
        }
        $data = [];
        $data['title'] = 'Account dashboard join now';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account dashboard join now';
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;

        return view('account.account_dash_join_now', compact('data'));
    }

    public function accountUserRegisterPost(Request $request) {
        $responseArray  = ['success' => false, 'message' => ''];

        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), User::$accountSignupValidation, User::$accountSignupCustomMessage);
            if ($validation->fails()) {
                setcookie('error', $validation->errors()->first(), time() + (86400 * 30), "/");
                return redirect()->back()->with('error',$validation->errors()->first());
                //                $responseArray['error']     = $validation->errors();
                //                $responseArray['message']   = $validation->errors()->first();
            }
            $country = Country::find($request->country);
            if (empty($country)) {
                setcookie('error', 'Selected country is invalid!', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Selected country is invalid!');
            }
            $state = $request->state_province_region;
            if (empty($state)) {
                setcookie('error', 'Selected State is invalid!', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Selected State is invalid!');
            }

            //Check email exist
            $checkexist = User::where('email',$request->email)->first();
            if(!empty($checkexist)){
                setcookie('error', 'Email Id Already Exist', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Email Id Already Exist');
            }

            $uploaded_pic['profile_pic'] = null;
            $default_image = 0;
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $path = 'profile_picture';
                //$name = time().'_'.$file->getClientOriginalName();
                $name = time() . date("YmdHis") . rand(11, 9999) . '_user-profile' . '.' . $file->getClientOriginalExtension();
                $uploaded_pic['profile_pic'] = $name;
                $file->storeAs($path, $name, 's3');
                //                $this->deleteFile($path.'/'.$user->profile_pic);
                //                $filename = ['profile_pic'];
                //                $uploaded_pic = $this->fileUploadHandling($request,$filename,$path);
            } else {
                if(isset($request->default_image)){
                    switch($request->default_image){
                        case '1':
                            $uploaded_pic['profile_pic'] = 'default_buyer_logo.png';
                            break;
                        case '2':
                            $uploaded_pic['profile_pic'] = 'default_green_boy_logo.png';
                            break;
                        case '3':
                            $uploaded_pic['profile_pic'] = 'default_blue_boy_beard_logo.png';
                            break;
                        case '4':
                            $uploaded_pic['profile_pic'] = 'default_pink_logo.png';
                            break;
                    }
                }
                $default_image = 1;
            }

            $saveData = [
                'first_name' => $request->first_name,
                'surname' => $request->surname,
                'email' => $request->email,
                'role_id' => 1,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'state_province_region' => $state, //$request->state_province_region,
                'postal_code' => $request->postal_code,
                'country' => $country->name, //$request->country,
                'phone_country_code' => str_replace("+","",$request->phone_country_code), //$request->phone_country_code.$request->phone,
                'phone' => $request->phone, //$request->phone_country_code.$request->phone,
                'mob_phone_country_code' => str_replace("+","",$request->mob_phone_country_code), //$request->mob_phone_country_code.$request->mob_phone,
                'mob_phone' => $request->mob_phone, //$request->mob_phone_country_code.$request->mob_phone,
                'age' => $request->age,
                'image' => $uploaded_pic['profile_pic'],
                'default_image' => $default_image, //($request->default_image == "on") ? 1 : 0,
                'tell_us_about_you' => $request->tell_us_about_you,
                'detail_additional_information' => $request->detail_additional_information,
                'newsletter' => ($request->newsletter == "on") ? 1 : 0,
                'classroom_contributions' => ($request->classroom_contributions == "on") ? 1 : 0,
                'terms_and_conditions' => ($request->terms_and_conditions == "on") ? 1 : 0,
                'password' => Hash::make($request->password), //bcrypt($request->password), 
                'encrypt_pwd' => base64_encode($request->password),
                'status' => 1,
                'verified' => 1,
                'grade_id' => isset($request->grade_id) ? $request->grade_id : 0,
                'interest_area' => isset($request->interest_area) ? $request->interest_area : '',
                'created_at' => now(),
            ];

            $accountUserCreate = User::create($saveData);

            if ($accountUserCreate) {
                //Subscribe to mailchimp
                ClassroomCopyHelper::Newsletter_subscribe($saveData['email'],$saveData['first_name'],$saveData['surname']);
                /* $verifyUser = VerifyUser::create([
                  'user_id' => $accountUserCreate->id,
                  'token' => sha1(time())
                  ]); */

                UserSettings::create(['user_id' => $accountUserCreate->id,'newsletter'=>($request->newsletter == "on") ? 1 : 0]);


                $data = [
                  "name" => $accountUserCreate->first_name,
                  "email" => $accountUserCreate->email,
                  "subject" => 'Thank You for Joining Classroom Copy!',
                  //"verify_user_token" => $accountUserCreate->verifyUser->token,
                  ];

                  $send_mail = Mail::send('emails/buyer_welcome_mail', $data, function ($message)use ($data) {
                  $message->to($data['email']);
                  //$message->cc('admin@classroomcopy.com');
                  $message->subject($data['subject']);
                  });
                $saveData['role_id'] = 2;
                $storeUserCreate = User::create($saveData);

                if ($storeUserCreate) {
                    /* $verifyUser = VerifyUser::create([
                      'user_id' => $accountUserCreate->id,
                      'token' => sha1(time())
                      ]); */
                    if(isset($request->coupon)){
                        if((new \App\Http\Helper\Web)->checkofferstatus()){
                            SellerOfferApplied::create(['userid' => $storeUserCreate->id]);
                        }
                    }
                    UserSettings::create(['user_id' => $storeUserCreate->id]);
                }

                //Check if any gift card exist and if found any assign it 
                $checkexistgift = GiftCards::where('recipient_email',$accountUserCreate->email)->get();
                if(count($checkexistgift)){
                    foreach($checkexistgift as $k => $value){
                        $update = GiftCards::where('id',$value->id)->update(['recipient_user_id'=>$accountUserCreate->id]);
                    }
                }

                DB::commit();
                $credentials = request(['email', 'password']);
                Auth::attempt($credentials);
                return redirect()->route('classroom.index')->with('success', 'User Created Successfully.');
                //return redirect()->route('product.search.view')->with('success', 'User Created Successfully.');
            } else {
                if ($request->hasfile('image')) {
                    $path = 'profile_picture';
                    Storage::disk('s3')->delete($path . '/' . $uploaded_pic['profile_pic']);
                }
                setcookie('error', 'Error occured while creating user.Please try again!', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Error occured while creating user.Please try again!')->withInput();
            }

            $responseArray['success'] = true;
            $responseArray['data'] = $request->toArray();
            $responseArray['message'] = 'User Created Successfully.';
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            //            $responseArray['message'] = $message;
            if ($request->hasfile('image')) {
                $path = 'profile_picture';
                Storage::disk('s3')->delete($path . '/' . $uploaded_pic['profile_pic']);
            }
            DB::rollBack();
            setcookie('error', $message, time() + (86400 * 30), "/");
            return redirect()->back()->with('error', $message)->withInput();
        }
        //        dd($request->toArray());
        //        return response()->json($responseArray, 200);
    }

    //Store user registration:
    public function storeUserRegister(Request $request) {
        if(Auth()->check()){
            return redirect()->route('classroom.index');
        }
        $data = [];
        $data['title'] = 'Store dashboard join now';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store dashboard join now';
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;

        return view('store.store_dash_join_now', compact('data'));
    }

    public function storeUserRegisterPost(Request $request) {
        //$responseArray  = ['success' => false, 'message' => ''];
        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), User::$storeSignupValidation, User::$storeSignupCustomMessage);
            if ($validation->fails()) {
                setcookie('error', $validation->errors()->first(), time() + (86400 * 30), "/");
                return redirect()->back()->with('error', $validation->errors()->first())->withInput();
                //                $responseArray['error']     = $validation->errors();
                //                $responseArray['message']   = $validation->errors()->first();
            }
            $country = Country::find($request->country);
            if (empty($country)) {
                setcookie('error', 'Selected country is invalid!', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Selected country is invalid!');
            }
            $state = State::find($request->state_province_region);
            if (empty($state)) {
                setcookie('error', 'Selected State is invalid!', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Selected State is invalid!');
            }

            // Check email exist
            $checkexist = User::where('email',$request->email)->first();
            if(!empty($checkexist)){
                setcookie('error', 'Email Id Already Exist', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Email Id Already Exist');
            }

            $uploaded_pic['profile_pic'] = null;
            $default_image = 0;
            if ($request->hasfile('image')) {
                $file = $request->file('image');
                $path = 'profile_picture';
                //$name = time().'_'.$file->getClientOriginalName();
                $name = time() . date("YmdHis") . rand(11, 9999) . '_user-profile' . '.' . $file->getClientOriginalExtension();
                $uploaded_pic['profile_pic'] = $name;
                $file->storeAs($path, $name, 's3');
                //                $this->deleteFile($path.'/'.$user->profile_pic);
                //                $filename = ['profile_pic'];
                //                $uploaded_pic = $this->fileUploadHandling($request,$filename,$path);
            } else {
                $default_image = 1;
                switch($request->default_image){
                    case '1':
                        $uploaded_pic['profile_pic'] = 'default_buyer_logo.png';
                        break;
                    case '2':
                        $uploaded_pic['profile_pic'] = 'default_green_boy_logo.png';
                        break;
                    case '3':
                        $uploaded_pic['profile_pic'] = 'default_blue_boy_beard_logo.png';
                        break;
                    case '4':
                        $uploaded_pic['profile_pic'] = 'default_pink_logo.png';
                        break;
                }
                //                $uploaded_pic['profile_pic']    =   'book-img.png';
            }
            $is_admin_relative = ($request->is_admin_relative == "on") ? 1 : 0;
            $saveData = [
                'first_name' => $request->first_name,
                'surname' => $request->surname,
                'email' => $request->email,
                'role_id' => 2,
                'address_line1' => $request->address_line1,
                'address_line2' => $request->address_line2,
                'city' => $request->city,
                'state_province_region' => $state->name,
                'postal_code' => $request->postal_code,
                'country' => $country->name,
                'phone_country_code' => str_replace("+","",$request->phone_country_code),//$request->phone_country_code, //$request->phone_country_code.$request->phone,
                'phone' => $request->phone, //$request->phone_country_code.$request->phone,
                'mob_phone_country_code' => str_replace("+","",$request->mob_phone_country_code), //$request->mob_phone_country_code.$request->mob_phone,
                'mob_phone' => $request->mob_phone, //$request->mob_phone_country_code.$request->mob_phone,
                'age' => $request->age,
                'image' => $uploaded_pic['profile_pic'],
                'default_image' => $default_image, //($request->default_image == "on") ? 1 : 0,
                'tell_us_about_you' => $request->tell_us_about_you,
                'detail_additional_information' => $request->detail_additional_information,
                'newsletter' => ($request->newsletter == "on") ? 1 : 0,
                'classroom_contributions' => ($request->classroom_contributions == "on") ? 1 : 0,
                'terms_and_conditions' => ($request->terms_and_conditions == "on") ? 1 : 0,
                'password' => Hash::make($request->password), //bcrypt($request->password),
                'encrypt_pwd' => base64_encode($request->password),
                'status' => 1,
                'verified' => 1,
                'is_admin_relative' => $is_admin_relative,
                'grade_id' => isset($request->grade_id) ? $request->grade_id : 0,
                'interest_area' => isset($request->interest_area) ? $request->interest_area : '',
                'created_at' => now(),
            ];

            $storeUserCreate = User::create($saveData);
            if ($storeUserCreate) {
                /* $verifyUser = VerifyUser::create([
                  'user_id' => $storeUserCreate->id,
                  'token' => sha1(time())
                  ]); */

                UserSettings::create(['user_id' => $storeUserCreate->id]);

                /* $data = [
                  "first_name" => $storeUserCreate->first_name,
                  "email" => $storeUserCreate->email,
                  "subject" => 'Email verification',
                  "verify_user_token" => $storeUserCreate->verifyUser->token,
                  "content" => '',
                  ];

                  $send_mail = Mail::send('emails/verify_users', $data, function ($message)use ($data) {
                  $message->to($data['email']);
                  $message->subject($data['subject']);
                  }); */

                if ($is_admin_relative == 1) {
                    $adminEmail = env('ADMIN_EMAIL');
                    $emailData = [
                        "first_name" => $storeUserCreate->first_name,
                        "subject" => 'Verify User',
                        "verify_user_token" => base64_encode($storeUserCreate->id),
                        "content" => '',
                        'adminEmail' => $adminEmail
                    ];
                    $send_mail = Mail::send('emails/admin_relative_verify_mail', $emailData, function ($message)use ($emailData) {
                                $message->to($emailData['adminEmail']);
                                $message->cc('admin@classroomcopy.com');
                                $message->subject($emailData['subject']);
                            });
                }
                //buyer register Start
                unset($saveData['is_admin_relative']);
                $saveData['role_id'] = 1;

                $accountUserCreate = User::create($saveData);

                if ($accountUserCreate) {   
                    /* $verifyUser = VerifyUser::create([
                      'user_id' => $accountUserCreate->id,
                      'token' => sha1(time())
                      ]); */

                    UserSettings::create(['user_id' => $accountUserCreate->id]);
                }
                //buyer register End
                
                //Check if any gift card exist and if found any assign it 
                $checkexistgift = GiftCards::where('recipient_email',$accountUserCreate->email)->get();
                if(count($checkexistgift)){
                    foreach($checkexistgift as $k => $value){
                        $update = GiftCards::where('id',$value->id)->update(['recipient_user_id'=>$accountUserCreate->id]);
                    }
                }

                DB::commit();
                $credentials = request(['email', 'password']);
                Auth::attempt($credentials);
                return redirect()->route('classroom.index')->with('success', 'User Created Successfully.');
                //return redirect()->route('product.search.view')->with('success', 'User Created Successfully.');
            } else {
                if ($request->hasfile('image')) {
                    $path = 'profile_picture';
                    Storage::disk('s3')->delete($path . '/' . $uploaded_pic['profile_pic']);
                }
                setcookie('error', 'Error occured while creating user.Please try again!', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Error occured while creating user.Please try again!')->withInput();
            }

            $responseArray['success'] = true;
            $responseArray['data'] = $request->toArray();
            $responseArray['message'] = 'User Created Successfully.';
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            //            $responseArray['message'] = $message;
            if ($request->hasfile('image')) {
                $path = 'profile_picture';
                Storage::disk('s3')->delete($path . '/' . $uploaded_pic['profile_pic']);
            }
            DB::rollBack();
            setcookie('error', $message, time() + (86400 * 30), "/");
            return redirect()->back()->with('error', $message)->withInput();
        }
        //        dd($request->toArray());
        //        return response()->json($responseArray, 200);
    }

    public function forgetPasswordPost(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            $validation = Validator::make($request->all(), User::$forgotPasswordValidation, User::$forgotPasswordCustomMessage);
            if ($validation->fails()) {
                $responseArray['error'] = $validation->errors();
                $responseArray['message'] = $validation->errors()->first();
            } else {
                $checkdb = User::where('email',$request->email)->first();
                if(!empty($checkdb)){
                    $token = Str::random(60);
                    DB::table('password_resets')->insert(['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]);
                    Mail::send('auth.verify', ['token' => $token], function ($message) use ($request) {
                        $message->to($request->email);
                        $message->cc('admin@classroomcopy.com');
                        $message->subject('Reset Password Notification');
                    });

                    $responseArray['success'] = true;
                    $responseArray['message'] = 'We have e-mailed your password reset link!';
                }
                else{
                     $responseArray['message'] = "We don't have any account associated with this email id";
                }
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

    public function getPassword($token) {
        return view('auth.password_reset', ['token' => $token]);
    }

    public function updatePassword(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            $validation = Validator::make($request->all(), User::$updatePasswordValidation, User::$updatePasswordCustomMessage);
            if ($validation->fails()) {
                $responseArray['error'] = $validation->errors();
                $responseArray['message'] = $validation->errors()->first();
            } else {
                $updatePassword = DB::table('password_resets')->where('email', $request->email)->where('token', $request->token)->first();
                if (empty($updatePassword)) {
                    $responseArray['success'] = false;
                    $responseArray['message'] = 'Invalid token!';
                } else {
                    $user = User::where('email', $request->email)
                            ->update(['password' => Hash::make($request->password)]);
                    DB::table('password_resets')->where(['email' => $request->email])->delete();
                    $responseArray['success'] = true;
                    $responseArray['message'] = 'Your password has been changed!';
                }
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

    public function logout(Request $request) {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function accountDashChangePassword(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            $validation = Validator::make($request->all(), User::$changePasswordValidation, User::$changePasswordCustomMessage);
            if ($validation->fails()) {
                $responseArray['error'] = $validation->errors();
                $responseArray['message'] = 'Validation Error';
            } else {
                if ($request->password !== $request->password_confirmation) {
                    throw new Exception("Confirm password doesn't match!");
                }
                $checkCurrentPassword = Hash::check($request->current_password, Auth()->user()->password);
                if (!$checkCurrentPassword) {
                    throw new Exception("Your old password doesn't match");
                }
                $check_newpassword = Hash::check($request->password, auth()->user()->password);
                if ($check_newpassword) {
                    throw new Exception("Please enter a password which is not similar to current password.");
                }
                if ($checkCurrentPassword) {
                    $user = User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
                    if ($user) {
                        $responseArray['success'] = true;
                        $responseArray['message'] = 'Your new password updated successfully!';
                    } else {
                        throw new Exception("Error occured in update your password");
                    }
                }
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function profileImageUpdate(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            $validation = Validator::make($request->all(), User::$profileImageUpdateValidation, User::$profileImageUpdateCustomMessage);
            if ($validation->fails()) {
                $responseArray['img'] = url('storage/uploads/profile_picture/' . auth()->user()->image);
                $responseArray['message'] = $validation->errors()->first();
            } else {
                $user = auth()->user();
                if ($request->hasfile('profileImage')) {
                    $file = $request->file('profileImage');
                    $path = 'public/uploads/profile_picture';
                    $name = time() . date("YmdHis") . rand(11, 9999) . '_user-profile' . '.' . $file->getClientOriginalExtension();
                    $uploaded_pic['profile_pic'] = $name;
                    $file->storeAs($path, $name);
                }
                $myfile = 'public/uploads/profile_picture' . '/' . $uploaded_pic['profile_pic'];
                //                $fileExistCheck = File::exists($myfile);
                $fileExistCheck = Storage::exists($myfile);
                if (!$fileExistCheck) {
                    throw new Exception("Error occured while save your profile image!");
                }
                $updateImage = User::where('id', $user->id)->update(['image' => $uploaded_pic['profile_pic'], 'default_image' => 0]);
                if (!$updateImage) {
                    throw new Exception("Error occured while save your profile image!");
                }
                //To Delete old profile image:
                $path = 'public/uploads/profile_picture';
                $this->deleteFile($path . '/' . $user->image);

                $getUpdatedImage = User::where('id', $user->id)->select('image')->first();
                $responseArray['success'] = true;
                $responseArray['img'] = url('storage/uploads/profile_picture/' . $getUpdatedImage->image);
                $responseArray['message'] = 'Profile image updated successfully!';
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['img'] = url('storage/uploads/profile_picture/' . auth()->user()->image);
            $responseArray['message'] = $message;
            if ($request->hasfile('profileImage')) {
                $path = 'public/uploads/profile_picture';
                $this->deleteFile($path . '/' . $uploaded_pic['profile_pic']);
            }
        }
        return response()->json($responseArray, 200);
    }

}