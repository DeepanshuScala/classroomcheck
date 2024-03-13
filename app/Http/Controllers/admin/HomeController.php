<?php



namespace App\Http\Controllers\admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{

    DB,

    Validator,

    Hash,

    Mail,

    Session,

    Redirect,

    Crypt,

};

use \App\Models\{User , SuggestResource , GradeLevels, crc_report_issue ,Seller_Social_Media,Newsletter,ContactUs,StripeAccount,Store,Product,OrderItem,hostsale,FeatureList,SellerOffer,UserSettings};



class HomeController extends Controller {



    /** + 

     * used to show admin dashboard

     * @param Request $request - request type get

     * @return type

     */

    public function index(Request $request) {

        return view('admin.pages.dashboard');

    }



    public function changePassword(Request $request) {

        try {

            if ($request->isMethod('post')) {

                $validator = Validator::make($request->all(), [

                            'old_password' => 'required',

                            'new_password' => 'required',

                            'confirm_password' => 'required|same:new_password',

                ]);



                if ($validator->fails()) {

                    return redirect()->back()->with('error', $validator->errors()->first())->withInput();

                }

                try {

                    $user_id = auth()->user()->id;

                    $user = auth()->user();



                    if ((Hash::check($request->old_password, $user->password)) == false) {

                        return redirect()->back()->with('error', "Old password doesn't match")->withInput();

                    }

                    if ((Hash::check($request->new_password, auth()->user()->password))) {

                        return redirect()->back()->with('error', "Please enter a password which is not similar to current password")->withInput();

                    }

                    $user->password = Hash::make($request->new_password);

                    $user->updated_at = date('Y-m-d H:i:s');

                    $user->save();

                    return redirect()->back()->with('success', 'Password updated successfully');

                } catch (\Exception $ex) {

                    return redirect()->back()->with('error', $ex->getMessage())->withInput();

                }

            } else {

                return view('admin.pages.change_password');

            }

        } catch (NotFoundHttpException $exception) {

            Redirect::to(url('admin/dashboard'));

        }

    }


    public function suggestaresource(Request $request){
        $pageHeading = "Suggest A Resource";
        $users = User::where('role_id', 2)->orderBy('id', 'DESC')->get();
        
        $sr = SuggestResource::with('gradeLevel','subject','resource')->orderBy('id', 'DESC')->get();
        return view('admin.pages.suggestresource', compact('sr','pageHeading','users'));
    }

    public function issuereported(Request $request){
        if(isset($request['id']) && isset($request['status'])){
            crc_report_issue::where('id',$request['id'])->update(['status'=>$request['status']]);
        }
        $pageHeading = "Product Issues Reported";
        $users = User::orderBy('id', 'DESC')->get();
        
        $sr = crc_report_issue::with('product','user')->orderBy('id', 'DESC')->get();
        return view('admin.pages.issuereported', compact('sr','pageHeading','users'));
    }
    public function sendnotification(Request $request){

        if ($request->isMethod('post')){
            $r = SuggestResource::with('gradeLevel','subject','resource')->where('id',  $request->resourceid)->first();
            $emailData =  array();
            $emailData = [
                    "name" => $r->name,
                    "email" => $r->email,
                    "grade" => $r->gradeLevel->grade,
                    "subject" => $r->subject->name,
                    "resourcetype" => $r->resource->name,
                    "description" => $r->description,
                    "other_description" => $r->description,
                ];
            $mail_data = [
                'subject' => 'Buyer Suggestion By User',
                'data' => $emailData,
                'buyer'=>$request->buyers
            ];

            //update 
            $updt = SuggestResource::where('id',$request->resourceid)->update(['is_sent_to_seller'=>1,'sent_date'=>date("Y-m-d h:i:s")]);

            $job = (new \App\Jobs\SendResourceSuggestion($mail_data))
                    ->delay(now()->addSeconds(2)); 
            dispatch($job);
            // $send_mail = Mail::send('emails/sendnotificationbuyer', $emailData, function ($message)use ($emailData) {
            //                     $message->to('sonkhladeepanshu@gmail.com');
            //                     $message->subject('Buyer Suggestion By User');
            //                 });
        }
    }

    public function sellersocialmediamarketing(Request $request){
        $pageHeading = "Social Media Marketing";
        $sr = Seller_Social_Media::orderBy('id', 'DESC')->get();
        return view('admin.pages.marketing.seller-social-media', compact('sr','pageHeading'));
    }

    public function newsletter(Request $re){
        $pageHeading = "Newsletter Submissions";
        $users = User::where('role_id', 2)->orderBy('id', 'DESC')->get();
        
        $sr = Newsletter::orderBy('id', 'DESC')->get();
        return view('admin.pages.newsletter', compact('sr','pageHeading','users'));
    }

    public function sendbuyernotification(Request $request){
        if ($request->isMethod('post')){
            $mail_data = [
                    'subject' => 'Newsletter',
                    'data' => $request->mail_content
                ];
                
            $job = (new \App\Jobs\SendNewsletter($mail_data))
                    ->delay(now()->addSeconds(2)); 
            dispatch($job);
        }
    }
    public function feedbacks(Request $request){
        $pageHeading = "Feedbacks";
        $sr = ContactUs::orderBy('id', 'DESC')->get();
        return view('admin.pages.feedbacks', compact('sr','pageHeading'));
    }

    public function sellerpayouts(Request $request){
        $pageHeading = "Sellers Payout";
        $stripeConnectUsers = StripeAccount::where('approved_status', 1)->get();
        $stripeConnectUserIdArr =   $stripeConnectUsers->pluck('user_id')->toArray();
        $payOutUserIdArr    = array_values($stripeConnectUserIdArr);
        
        $sellers  =  User::where('role_id', 2)->where('status', 1)->whereIn('id', $payOutUserIdArr)->get();
        return view('admin.pages.seller-payouts', compact('pageHeading','sellers'));
    }

    public function sellerssells(Request $request,$id){
        $uid = base64_decode($id);
        $users = User::find($uid);
        $store = Store::where('user_id',$uid)->first();

        //Get Seller products
        $seller_prods = [];
        $get_seller_prods = Product::select(['id'])->where('user_id',$uid)->where('is_paid_or_free','paid')->get();
        if(count($get_seller_prods)>0){
            foreach($get_seller_prods as $pro){
                $seller_prods[] = $pro->id;
            }
        }

        $sales = OrderItem::with(['product','user','order'])->whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);
        $total_sale_for_period = OrderItem::whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);
        $total_sales = $sales->orderBy('id','DESC')->get();
        if ($users == null) {
            return redirect(url('/admin/users/sellers'))->with('error', "User not valid");
        }else{
            return view('admin.pages.sellers-info', compact(['users','store','total_sales']));
        }
    }

    public function sellerspromotions(Request $request, $id){
        $uid = base64_decode($id);
        $users = User::find($uid);
        $store = Store::where('user_id',$uid)->first();

        //---- Host a sale ----//
        $total_hostasale = hostsale::where('user_id',$uid)->where('is_deleted',0)->get();

        //---- Feautre Listing ----//
        $productResult = Product::where('user_id', $uid)
                            ->where('is_deleted', 0)->where('status',1)->select('id', 'product_title')->get();
        //get confirmed marketing history
        $confirmedMarketingResult = FeatureList::join('crc_products', function ($join) {
                            $join->on('crc_products.id', '=', 'crc_product_feature_list.product_id');
                        })->where('crc_product_feature_list.user_id', $uid)
                        ->whereIn('crc_product_feature_list.payment_status', [1])
                        ->whereIn('crc_product_feature_list.status', [1])
                        ->select('crc_product_feature_list.*', 'crc_products.product_title')->orderBy('crc_product_feature_list.id','Desc')->get();
        $confirmedMarketingResult->each(function ($val) {
            $val->encrypt_id = Crypt::encrypt($val->id);
        });
        $confirmedMarketingResult = $confirmedMarketingResult;


        if ($users == null) {
            return redirect(url('/admin/users/sellers'))->with('error', "User not valid");
        }else{
            return view('admin.pages.sellers-info', compact(['users','store','total_hostasale','confirmedMarketingResult']));
        }
    }

    public function getsinglesale($id){
    
        if(isset($id) && !empty($id)){
            try{
                $checkid = Crypt::Decrypt($id);
                $editsale = hostsale::where('id',$checkid)->get();
               
                if(count($editsale) > 0){
                    $discount = 0;
                    $data['admin'] =1;
                    $data['oldurl'] = url()->previous();
                    $start_date = '';
                    $end_date = '';
                    foreach ($editsale as $key => $value) {
                        
                        if($value->products == 'Entire Store'){
                            $product_list = Product::with('ratings')->where('user_id',$value->user_id)->where('is_deleted',0)->where('status',1)->where('is_paid_or_free','paid')->get();
                        }
                        else{

                            $product_list_arr = explode(',', $value->products);
                            
                            $product_list = Product::with('ratings')->where('user_id',$value->user_id)->where('is_deleted',0)->where('status',1)->where('is_paid_or_free','paid')->whereIn('id',$product_list_arr)->get();
                        }
                        $discount = $value->discount;
                        $start_date = $value->start_date;
                        $end_date = $value->end_date;
                    }
                    $data['products'] = $product_list;
                    $data['discount'] = $discount;
                    $data['start_date'] = $start_date;
                    $data['end_date'] = $end_date;
                }  
                else{
                    return Redirect::to(route('storeDashboard.HostAsale'));
                }
            }catch (Exception $ex){
                return Redirect::to(route('storeDashboard.HostAsale'));
            }
            
        }
        return view('store.store_dashboard_view_a_sale', compact('data'));
    }

    public function updatefeedbackstatus(Request $request){
        $responseArray = ['success' => false, 'message' => ''];
        if(isset($request['id'])){
            ContactUs::where('id',$request['id'])->update(['status'=>1]);
            $responseArray['success'] = true;
        }
        return response()->json($responseArray, 201);
    }

    public function productmanagement(Request $request){
        $pageHeading = "Product Management";
        $products = Product::with('productSubjectArea')->where([['status','=',1],['is_deleted','=',0]])->orderBy('id','DESC')->get();
        return view('admin.pages.productmanagement', compact(['pageHeading','products']));
    }

    public function membermanagement(Request $request){
        $pageHeading = "Member Management";
        $users = User::whereIn('role_id',[1,2])->orderBy('id','DESC')->get();
        return view('admin.pages.membermanagement', compact(['pageHeading','users']));
    }

    public function sellersproducts(Request $request,$id){
        $pageHeading = "Product Management";
        $sellerinfo = '';
        $uid = base64_decode($id);
        $products = Product::with('productSubjectArea')->where([['status','=',1],['is_deleted','=',0],['user_id','=',$uid]])->orderBy('id','DESC')->get();
        return view('admin.pages.productmanagement', compact(['pageHeading','products','sellerinfo','uid']));
    }

    public function sellerscommunications(Request $request,$id){
        $uid = base64_decode($id);
        if(isset($request['id']) && isset($request['status'])){
            crc_report_issue::where('id',$request['id'])->update(['status'=>$request['status']]);
        }
        
        $pageHeading = "Communication";
        $users = User::orderBy('id', 'DESC')->get();

        //Get products 
        $product_arr = array();
        $pr = Product::where('user_id',$uid)->get();
        foreach ($pr as $key => $value) {
            // code...
            $product_arr[] = $value->id;
        }

        $sr = crc_report_issue::with('product','user')->whereIn('product_id',$product_arr)->orderBy('id', 'DESC')->get();
        return view('admin.pages.issuereported', compact('sr','pageHeading','users','uid'));
    }

    public function sellerpercentages(Request $request){
        $pageHeading = "Seller Percentages";
        $result = User::with(['store'])->where('role_id', 2)->orderBy('id', 'DESC')->get();
        return view('admin.pages.sellerpercentages',compact('pageHeading','result'));
    }
    public function editpercentages(Request $request, $id){
        $pageHeading = 'Update Percentages';
        try{
            $_id = base64_decode($id);
            $user = User::with(['store'])->find($_id);
            if(!empty($user)){
                if($request->isMethod('post')){
                    $update = Store::where('user_id',$_id)->update([
                                'sale_commission'=>$request->sale_commission,
                                'transactioncharge_aus'=>$request->transactioncharge_aus,
                                'transactioncharge_other'=>$request->transactioncharge_other,
                                'salestax'=>$request->salestax,
                            ]);
                    if($update){
                        return redirect(url('admin/seller-percentages'))->with('success', "Seller Percentages Updated");
                    }
                }
                return view('admin.pages.updatesellerpercentages',compact('pageHeading','user'));
            }
            else{
                return Redirect::to(url('admin/seller-percentages'))->with('error',"Invalid User Credentials");
            }
        }
        catch (Exception $ex){
            return Redirect::to(url('admin/seller-percentages'));
        }
    }

    public function selleroffer(Request $request){
        $pageHeading = "Seller Offers";
        $result = SellerOffer::first();
        return view('admin.pages.selleroffer',compact('pageHeading','result')); 
    }

    public function activateDeactivateoffer(Request $request,$status){
        try {
            $userData = SellerOffer::first();
            if ($userData == null) {
                return redirect()->back()->with('error', "not valid");
            }
            $msgTxt = ($status == 0) ? 'deactivated' : 'activated';
            if ($userData->is_active == $status) {
                return redirect()->back()->with('error', "Offer already $msgTxt");
            }
            SellerOffer::where('id', 1)->update([
                'is_active' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            return redirect()->back()->with('success', "Offer $msgTxt successfully");
        } catch (NotFoundHttpException $exception) {
            return Redirect::to('admin/dashboard')->with('error', $exception);
        }
    }

    public function featuredlisting(Request $request){
        $pageHeading = "Feature Listing";
        $users = User::where('role_id',2)->orderBy('id','DESC')->get();
        return view('admin.pages.featuredlisting', compact(['pageHeading','users']));
    }

    public function featuredlistingdetails(Request $request,$user_id){
        $pageHeading = 'Feature Listing Details';
        try{
            $_id = base64_decode($user_id);
            $user = User::with(['store'])->find($_id);
            if(!empty($user)){
                $confirmedMarketingResult = FeatureList::join('crc_products', function ($join) {
                                $join->on('crc_products.id', '=', 'crc_product_feature_list.product_id');
                            })->where('crc_product_feature_list.user_id', $_id)
                            ->whereIn('crc_product_feature_list.payment_status', [1])
                            ->whereIn('crc_product_feature_list.status', [1])
                            ->select('crc_product_feature_list.*', 'crc_products.product_title')->orderBy('crc_product_feature_list.id','Desc')->get();
                return view('admin.pages.featuredlistingdetails',compact('pageHeading','confirmedMarketingResult'));
            }
            else{
                return Redirect::to(url('admin/featured-listing'))->with('error',"Invalid Store");
            }
        }
        catch (Exception $ex){
            return Redirect::to(url('admin/featured-listing'));
        }
    }

    public function deleteproduct(Request $request){
        $responseArray = ['success' => false, 'message' => 'not deleted'];
        if(isset($request->product_id)){
            Product::where('id', $request->product_id)->update(['is_deleted'=>1]);
            $responseArray['data'] = 1;
            $responseArray['success'] = true;
            $responseArray['message'] = 'Product Deleted';
        }
        return response()->json($responseArray, 200);
    }

    public function addsellerbanner(Request $request){
        $pageHeading = 'Seller Offer Banner';
        if($request->isMethod('post')){
            $image = '';
            if($request->hasfile('banner')){

                $file = $request->file('banner');
                $validation = Validator::make($request->all(),['banner' => 'dimensions:width=1500,height=330']);
                if ($validation->fails()) {
                    return back()->with('error', 'Banner dimensions must be 1500px*330px');
                }
                $path = 'public/uploads/selleroffer';
                $name = time() . '_' . rand() . '.' . $file->getClientOriginalExtension();
                $image = $name;
                $file->storeAs($path, $name);
                SellerOffer::where('id', 1)->update(['banner'=>$image]);
                return Redirect::to(url('admin/selleroffer'))->with('success',"Banner Updated");
            }
        }
        else{
            return view('admin.pages.addsellerbanner',compact('pageHeading'));
        }
    }

    public function deletesellerbanner(Request $request){
        $result =  SellerOffer::first();
        try{
            unlink(storage_path('app/public/uploads/selleroffer/' . $result->banner));
        }catch(Exception $e){
        }
        SellerOffer::where('id', 1)->update(['banner'=>'']);
        return Redirect::to(url('admin/selleroffer'))->with('success',"Banner Deleted Successfully");
    }

    public function subscribeunsubscribe(Request $request,$user_id){
        $usersetting = UserSettings::where('user_id',$user_id)->first();
        $usersetting->newsletter = !$usersetting->newsletter?1:0;
        $usersetting->save();
        return Redirect::to(url('admin/users/buyers'))->with('success',"Newsletter Subscription Changed Successfully");
    }
}