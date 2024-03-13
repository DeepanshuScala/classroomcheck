<?php

namespace App\Http\Controllers\seller\marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Validator,
    Session,
    Redirect,
    Auth,
    Crypt
};
use \App\Models\{
    User,
    Seller_Social_Media,
    Newsletter
};

class MarketingController extends Controller {

    /**
     * used to show newsletter page
     * @param Request $request- request type get
     * @return type
     */
    public function newsletter(Request $request) {
        $data = [];
        $data['title'] = 'Featured Listings';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Marketing';
        $data['breadcrumb2_link'] = route('storeDashboard.marketingDashboard');
        $data['breadcrumb3'] = 'Newsletter';
        if($request->isMethod('post')){

            try{

                $check = Newsletter::where('product',$request->product_id)->first();
                if($check){
                    return redirect()->back()->with('error', 'Newsletter with Product already exist');
                }
                $saveData = [
                    'store_url' => $request->store_url,
                    'store_name' => $request->store_name,
                    'email' => $request->email,
                    'store_user_id' => auth()->user()->id,
                    'resource_grade' => $request->resource_grade, 
                    'resource_subject' => $request->resource_subject, 
                    'product_price_type' => $request->product_price_type, 
                    'product' => $request->product_id, 
                    'previous_listing' => $request->previous_listing,
                ];
                $newsletetr = Newsletter::create($saveData);
                if($newsletetr){
                    return redirect()->back()->with('success', 'Created Successfully.');
                }
            }catch (Exception $ex) {
                $message = $ex->getMessage();
                DB::rollBack();
                return redirect()->back()->with('error', $message)->withInput();
            }
        }
        return view('store.marketing.newsletter', compact('data'));
    }

    /**
     * used to show social media page
     * @param Request $request - request type get
     * @return type
     */
    public function socialMedia(Request $request) {
        $data = [];
        $data['title'] = 'Featured Listings';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Marketing';
        $data['breadcrumb2_link'] = route('storeDashboard.marketingDashboard');
        $data['breadcrumb3'] = 'Social Media';
        if($request->isMethod('post')){

            try{
                $validation = Validator::make($request->all(), Seller_Social_Media::$storeSignupValidation, Seller_Social_Media::$accountSignupCustomMessage);
                if ($validation->fails()) {
                    return redirect()->back()->with('error',$validation->errors()->first());
                }
                $uploaded_pic['media'] = null;
                if ($request->hasfile('media')) {
                    $file = $request->file('media');
                    $path = 'store/seller_socialmedia';
                    $name = time() . date('YmdHis') . auth()->user()->id . rand(1, 9999) . '_seller-media' . '.' . $file->getClientOriginalExtension();
                    $uploaded_pic['media'] = $name;
                    $file->storeAs($path, $name, 's3');
                }
                
                $saveData = [
                    'storeurl' => $request->storeurl,
                    'store_name' => $request->store_name,
                    'email' => $request->email,
                    'user_id' => auth()->user()->id,
                    'store_fb_url' => $request->store_fb_url,
                    'store_insta_url' => $request->store_insta_url,
                    'submission_type' => $request->submission_type,
                    'submission_type_details' => $request->submission_type_details, 
                    'resource_grade' => $request->resource_grade, 
                    'resource_subject' => $request->resource_subject, 
                    'explain_submission' => $request->explain_submission, 
                    'media' => $uploaded_pic['media'], 
                ];
                $createsocialsellere = Seller_Social_Media::create($saveData);
                if($createsocialsellere){
                    return redirect()->back()->with('success', 'Created Successfully.');
                }
            }catch (Exception $ex) {
                $message = $ex->getMessage();
                if ($request->hasfile('media')) {
                    $path = 'store/seller_socialmedia';
                    Storage::disk('s3')->delete($path . '/' . $uploaded_pic['media']);
                }
                DB::rollBack();
                return redirect()->back()->with('error', $message)->withInput();
            }
        }
        return view('store.marketing.social_media', compact('data'));
    }

}