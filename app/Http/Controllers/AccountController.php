<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    FavouriteItem,
    CartItem,
    Order,
    OrderItem,
    UserSettings,
    Product,
    Cartgiftcard,
    hostsale,
    Country,
    State,
    GiftCards,
    PromoDetails,
    Questions,
    UserCard,
    Store
};
use Illuminate\Support\Facades\{
    Auth,
    Crypt,
    DB,
    Storage
};
use Carbon\Carbon;
use Exception;
use Validator;
use \App\Http\Helper\Web;

class AccountController extends Controller {

    public $itemPerPage = 4;

    public function accountDashboard() {
        $data = [];
        $data['title'] = 'Account Dashboard';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;
        $user = auth()->user();

        return view('account.account_dashboard', compact(['data', 'user']));
    }

    public function accountDashboardMyInbox() {
        $data = [];
        $data['title'] = 'My Inbox';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'My Inbox';
        $data['breadcrumb3'] = false;
        $user = auth()->user();
        $receiver_answer = Questions::where('sender_id',$user->id)->where('type',0)->orderBy('created_at','desc')->take(10)->skip(0)->get();
        $total_receiver_answer =Questions::where('receiver_id',$user->id)->where('type',1)->orderBy('created_at','desc')->count();;
        
        foreach ($receiver_answer as $key => $value) {
            # code...
            $answers = Questions::where('receiver_id',$user->id)->where('type',1)->where('parent_id',$value->id)->get();
            if($answers->isNotEmpty()){
                $receiver_answer[$key]->answers = $answers; 
                // $total_receiver_answer += 1;
            }else{
                unset($receiver_answer[$key]);
            }
        }
        $sent_questions = Questions::where('sender_id',$user->id)->where('type',0)->orderBy('created_at','desc')->take(10)->skip(0)->get();
        $total_sent_questions = Questions::where('sender_id',$user->id)->where('type',0)->orderBy('created_at','desc')->count();
        return view('account.account_dashboard_my_inbox', compact('data','sent_questions','receiver_answer','total_sent_questions','total_receiver_answer'));
    }

    public function accountDashMyProfile() {
        $data = [];
        $data['title'] = 'My Profile';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'My Profile';
        $data['breadcrumb3'] = false;
        $user = User::with(['getUserSettings'])->where('id', auth()->user()->id)->first();
        if ($user->getUserSettings == null) {
            UserSettings::create(['user_id' => auth()->user()->id]);
        }
        $user = User::with(['getUserSettings'])->where('id', auth()->user()->id)->first();

//        $user   = json_encode($user);
        return view('account.account_dashboard_my_profile', compact('data', 'user'));
    }

    public function accountDashMyPurchaseHistory(Request $request) {
        $data = [];
        $data['title'] = 'My Purchase History';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'My Purchase History';
        $data['breadcrumb3'] = false;

        return view('account.account_dashboard_my_purchase_history', compact('data'));
    }

    public function accountDashMyWishlist() {
        $data = [];
        $data['title'] = 'My Wishlist';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'My Wishlist';
        $data['breadcrumb3'] = false;

        return view('account.account_dashboard_my_wishlist', compact('data'));
    }

    public function accountDashMyCart() {
        $data = [];
        $data['title'] = 'My Cart';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['breadcrumb2'] = 'My Cart';
        $data['breadcrumb3'] = false;
        $enc_user_id = Crypt::encrypt(auth()->user()->id);
        $cardRes = UserCard::where('user_id', auth()->user()->id)->where('is_deleted', 0)->get();
        
        $cartItems = CartItem::where('user_id', auth()->user()->id)->with('product')->get();
        $dis = 0;
        foreach($cartItems as $cartItem){
            if($cartItem->type == 'gift'){
                if(!$dis){
                    $dis = 1;
                    break;
                }
            }
            else{
                $pr = Product::where('id',$cartItem->product_id)->first();
                if(!empty($pr)){
                    if(!$dis && $pr->is_paid_or_free == 'paid'){
                        $dis = 1;
                        break;
                    }
                }
            }
        }
        if(!$dis && count($cardRes) == 0){
            $cardRes = [1];
        }
        $data['cards'] = $cardRes;
        return view('account.account_dashboard_my_cart', compact('data', 'enc_user_id'));
    }

    public function personalDetailsUpdate(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {

            //update profile picture
            if($request->profileimage){
                $default_image = 0;
                if ($request->hasfile('image')) {
                    $file = $request->file('image');
                    $path = 'profile_picture';
                    //$name = time().'_'.$file->getClientOriginalName();
                    $name = time() . date("YmdHis") . rand(11, 9999) . '_user-profile' . '.' . $file->getClientOriginalExtension();
                    $uploaded_pic['profile_pic'] = $name;

                    $file->storeAs($path, $name,'s3');
                    
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
                    try {
                        $uploaded_pic['profile_pic'] = '';
                        $user = auth()->user();
                        if ($request->hasfile('pimage')) {

                            $file = $request->file('pimage');
                            $path = 'profile_picture';
                            $name = time() . date("YmdHis") . rand(11, 9999) . '_user-profile' . '.' . $file->getClientOriginalExtension();
                            $uploaded_pic['profile_pic'] = $name;
                            $t = $file->storeAs($path, $name, 's3');

                            $myfile = $uploaded_pic['profile_pic'];
                            $fileExistCheck = Storage::disk('s3')->exists('profile_picture/'.$myfile);
                            if (!$fileExistCheck) {
                                throw new Exception("Error occured while save your profile image!");
                            }
                        }
                        else {
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

                        $updateImage = User::where('id', $user->id)->update(['image' => $uploaded_pic['profile_pic'], 'default_image' => $default_image]);
                        if (!$updateImage) {
                            throw new Exception("Error occured while save your profile image!");
                        }

                        //To Delete old profile image:
                        $path = 'profile_picture';
                        $fileExistCheck1 = Storage::disk('s3')->exists('profile_picture/'.$user->image);
                        if($fileExistCheck1 && !$default_image){
                            Storage::disk('s3')->delete($path . '/' . $user->image);
                        }
                        

                        $getUpdatedImage = User::where('id', $user->id)->select('image')->first();
                        $responseArray['success'] = true;
                        $responseArray['img'] = Storage::disk('s3')->url('profile_picture/'. $getUpdatedImage->image);
                        $responseArray['message'] = 'Profile image updated successfully!';
                    } catch (Exception $ex) {
                        $message = $ex->getMessage();
                        $responseArray['img'] = Storage::disk('s3')->url('profile_picture/'.auth()->user()->image);
                        $responseArray['message'] = $message;
                        if ($request->hasfile('pimage')) {
                            $path = 'profile_picture';
                            Storage::disk('s3')->delete($path . '/' . $uploaded_pic['profile_pic']);
                            //$this->deleteFile($path . '/' . $uploaded_pic['profile_pic']);
                        }
                    }
            }
            //Update Email
            if($request->email){
                $validation = Validator::make($request->all(), ['email' => 'email|required']);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $user = auth()->user();

                    $UserUpdate = User::where('email', $user->email)->update(['email' => $request->email]);
                    if (!$UserUpdate) {
                        throw new Exception("Error occured while updating your email!");
                    }
                    $updatedUserDetails = User::where('id', $user->id)->first();
                    $responseArray['success'] = true;
                    $responseArray['email'] = $updatedUserDetails->email;
                    $responseArray['input_name'] = 'email';
                    $responseArray['message'] = 'Your email updated successfully!';
                }
            }
            //Update full name:
            if ($request->first_name && $request->surname) {
                $validation = Validator::make($request->all(), ['first_name' => 'required', 'surname' => 'required']);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $user = auth()->user();
                    $UserUpdate = User::where('id', $user->id)->update(['first_name' => $request->first_name, 'surname' => $request->surname]);
                    if (!$UserUpdate) {
                        throw new Exception("Error occured while updateing your name!");
                    }
                    $updatedUserDetails = User::where('id', $user->id)->first();
                    $responseArray['success'] = true;
                    $responseArray['name'] = $updatedUserDetails->first_name . ' ' . $updatedUserDetails->surname;
                    $responseArray['input_name'] = 'full_name';
                    $responseArray['message'] = 'Your name updated successfully!';
                }
            }
            //Update Address:
            if (!empty($request->address_line1) && !empty($request->address_line2)) {
                $validation = Validator::make($request->all(), ['address_line1' => 'required|string|max:255', 'address_line2' => 'required|string|max:255', 'postal_code' => 'min:4'],['postal_code' =>'The area code must be at least 4 digits']);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $user = auth()->user();
                    $country = Country::find($request->country);
                    if (empty($country)) {
                        return redirect()->back()->with('error', 'Selected country is invalid!');
                    }
                    $state = $request->state_province_region;
                    
                    if (empty($state)) {
                        return redirect()->back()->with('error', 'Selected State is invalid!');
                    }
                    $UserUpdate = User::where('email', $user->email)->update(['address_line1' => $request->address_line1, 'address_line2' => $request->address_line2 ,'city' => $request->city ,'country' => $country->name , 'state_province_region' => $state , 'postal_code' => $request->postal_code ]);
                    if (!$UserUpdate) {
                        throw new Exception("Error occured while updateing your name!");
                    }
                    $updatedUserDetails = User::where('id', $user->id)->first();
                    $responseArray['success'] = true;
                    $responseArray['address_display1'] = $updatedUserDetails->address_line1 . ' ' . $updatedUserDetails->address_line2 . ' ' . $updatedUserDetails->city;
                    $responseArray['address_display2'] = $updatedUserDetails->state_province_region . ' ' . $updatedUserDetails->country;
                    $responseArray['input_name'] = 'address';
                    $responseArray['message'] = 'Your address updated successfully!';
                }
            }
            //Update phone:
            if (!empty($request->phone) && !empty($request->phone_country_code)) {
                $validation = Validator::make($request->all(), ['phone' => 'required|numeric'], ['phone.required' => 'Phone number is required']);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $user = auth()->user();

                    $phone_country_code = str_replace("+","",$request->phone_country_code);

                    $UserUpdate = User::where('id', $user->id)->update(['phone' => $request->phone, 'phone_country_code' => $phone_country_code]);
                    if (!$UserUpdate) {
                        throw new Exception("Error occured while updateing your name!");
                    }
                    $updatedUserDetails = User::where('id', $user->id)->first();
                    $responseArray['success'] = true;
                    $responseArray['phone'] = '(' . $updatedUserDetails->phone_country_code . ')' . ' ' . $updatedUserDetails->phone;
                    $responseArray['input_name'] = 'phone';
                    $responseArray['message'] = 'Your phone updated successfully!';
                }
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

    public function marketingNewsLetterUpdate(Request $request) {
        return ($request->newsletter == "on") ? 1 : 0;
        $responseArray = ['success' => false, 'message' => ''];
        try {
            //Update full name://($request->newsletter == "on") ? 1 : 0
            if ($request->newsletter == "on") {
//                $validation = Validator::make($request->all(), []);
//                if($validation->fails()){
//                    $responseArray['message']   = $validation->errors()->first();
//                } else {
                $user = auth()->user();

                $UserUpdate = User::where('id', $user->id)->update(['newsletter' => ($request->newsletter == "on") ? 1 : 0]);
                if (!$UserUpdate) {
                    throw new Exception("Error occured while updateing your name!");
                }
                $updatedUserDetails = User::where('id', $user->id)->first();
                $responseArray['success'] = true;
                $responseArray['name'] = $updatedUserDetails->first_name . ' ' . $updatedUserDetails->surname;
                $responseArray['input_name'] = 'full_name';
                $responseArray['message'] = 'Your name updated successfully!';
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 200);
    }

    public function addTofavourite(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), FavouriteItem::$validation);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $product_id = Crypt::decrypt($request->product_id);
                    $favData = [
                        'user_id' => auth()->user()->id,
                        'product_id' => $product_id,
                    ];

                    //To check if already product added to Favourite:-
                    $checkFavItem = FavouriteItem::where('user_id', auth()->user()->id)->where('product_id', $product_id)->count();
                    if ($checkFavItem > 0) {
                        throw new Exception("This item is already added to Favourite");
                    } else {
                        //Add to Favourite Item Create:-
                        $cartItem = FavouriteItem::create($favData);
                        if ($cartItem) {
                            $responseArray['success'] = true;
                            $responseArray['message'] = 'Item Added to Favourite Successfully!';
                        } else {
                            throw new Exception("Error occured in add to Favourite");
                        }
                    }
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function removeFavouriteItem(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), FavouriteItem::$removeFavouriteItemValidation);
                if ($validation->fails()) {
                    $responseArray['error'] = $validation->errors();
                    $responseArray['message'] = 'Validation Error';
                } else {
                    $userId = 0;
                    if (Auth::check()) {
                        $userId = auth()->user()->id;
                    }

                    if ($request->product_id) {
                        $product_id = Crypt::decrypt($request->product_id);
                    }
                    $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $product_id)->first();
                    if (empty($checkFavouriteItem)) {
                        throw new Exception("Error occured in Remove your favourite item");
                    }
                    if (!empty($checkFavouriteItem)) {
                        $favouriteItemUpdate = FavouriteItem::where('user_id', $userId)
                                ->where('id', $checkFavouriteItem->id)
                                ->delete();
                       $totalFavouriteItem = FavouriteItem::where('user_id', $userId)->count();
                        if ($favouriteItemUpdate) {
                            $responseArray['success'] = true;
                            $responseArray['count'] = $totalFavouriteItem;
                            $responseArray['message'] = 'This item Removed from your Favourite Successfully!';
                        } else {
                            throw new Exception("Error occured in Remove your favourite item");
                        }
                    }
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function getFavouriteItemsPaginate(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $product_id = $request->get('_id', null);
                    $type = $request->get('fs_type', null);
                    $favouriteItemQuery = $this->favourite_item_query($request);
                    $favouriteItemData = $this->favourite_item_pagination_data($request, $favouriteItemQuery);
                    return $favouriteItemData;
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function favourite_item_query($request) {
        $product_name = $request->get('product_name', null);
        $sort_by_filter = $request->get('sort_by_filter', null);
        $fav = FavouriteItem::where('user_id', auth()->user()->id)->with('product')->get();
        if(!empty($fav)){
            foreach ($fav as $key => $value) {
                # code...
                $productid = $value->product_id;
                $check = Product::where([['id','=',$productid],['status','=',1],['is_deleted','=',0]])->count();
                if($check == 0){
                    FavouriteItem::where('id', $value->id)->delete();
                }
            }
        }
        $favouriteItemQuery = FavouriteItem::where('user_id', auth()->user()->id)->with('product');
        if (!empty($product_name)) {
            $favouriteItemQuery->whereHas('product', function ($query) use ($product_name) {
                $query->where('product_title', 'like', '%' . $product_name . '%');
                //$query->orWhere('brand_company_name', 'like', '%'.$product_name.'%');
            });
            if ($sort_by_filter == '1') {
                return $favouriteItemQuery->orderBy('id', 'DESC'); 
            }
            if ($sort_by_filter == '2') {
                $favouriteItemQuery = FavouriteItem::where('crc_favourite_item.user_id', auth()->user()->id);
                return $favouriteItemQuery->join('crc_products', 'crc_products.id', 'crc_favourite_item.product_id')->where('crc_products.product_title', 'like', '%' . $product_name . '%')->orderBy('crc_products.single_license','ASC');
            }
            if ($sort_by_filter == '3') {
                $favouriteItemQuery = FavouriteItem::where('crc_favourite_item.user_id', auth()->user()->id);
                return $favouriteItemQuery->select('crc_favourite_item.product_id','crc_favourite_item.id',DB::raw('coalesce(avg(rating),0) as avg_r'))->leftjoin('crc_rate_review', 'crc_rate_review.product_id', 'crc_favourite_item.product_id')->join('crc_products', 'crc_products.id', 'crc_favourite_item.product_id')->where('crc_products.product_title', 'like', '%' . $product_name . '%')->groupBy('crc_favourite_item.product_id','crc_favourite_item.id','crc_favourite_item.id')->orderBy('avg_r','DESC');
            }
            if ($sort_by_filter == '4') {
                $favouriteItemQuery = FavouriteItem::where('crc_favourite_item.user_id', auth()->user()->id);
                return $favouriteItemQuery->join('crc_products', 'crc_products.id', 'crc_favourite_item.product_id')->where('crc_products.product_title', 'like', '%' . $product_name . '%')->orderBy('crc_products.single_license','DESC');
            }
        }
        if (!empty($sort_by_filter)) {

            if ($sort_by_filter == '1') {
               return $favouriteItemQuery->orderBy('id', 'DESC'); 
            }
            if ($sort_by_filter == '2') {
                $favouriteItemQuery = FavouriteItem::where('crc_favourite_item.user_id', auth()->user()->id);
                return $favouriteItemQuery->join('crc_products', 'crc_products.id', 'crc_favourite_item.product_id')->orderBy('crc_products.single_license','ASC');
            }
            if ($sort_by_filter == '3') {
                $favouriteItemQuery = FavouriteItem::where('crc_favourite_item.user_id', auth()->user()->id);
                return $favouriteItemQuery->select('crc_favourite_item.product_id','crc_favourite_item.id',DB::raw('coalesce(avg(rating),0) as avg_r'))->leftjoin('crc_rate_review', 'crc_rate_review.product_id', 'crc_favourite_item.product_id')->join('crc_products', 'crc_products.id', 'crc_favourite_item.product_id')->groupBy('crc_favourite_item.product_id','crc_favourite_item.id','crc_favourite_item.id')->orderBy('avg_r','DESC');
            }
            if ($sort_by_filter == '4') {
                $favouriteItemQuery = FavouriteItem::where('crc_favourite_item.user_id', auth()->user()->id);
                return $favouriteItemQuery->join('crc_products', 'crc_products.id', 'crc_favourite_item.product_id')->orderBy('crc_products.single_license','DESC');
            }
        }
        return $favouriteItemQuery->orderBy('id', 'DESC');
    }

    public function favourite_item_pagination_data($request, $favouriteItemQuery) {
        $per_page = $request->get('per_page', $this->itemPerPage);

        $favouriteItems = $favouriteItemQuery->paginate($per_page);
        $favouriteItems->getCollection()->transform([$this, 'favourite_item_data']);
        return $favouriteItems;
    }

    public function favourite_item_data($favItem) {
        $userId = auth()->user()->id;

        $last_id['last_id'] = 0;
        $avgRating = Web::getProductRating($favItem->product_id);
        $storeRes = \App\Models\Store::where('id', $favItem->product->store_id)->first();
        //check if sale is going for product
        $responsearray = Web::getsingleprice($favItem->product_id,$favItem->product->user_id,$favItem->product->single_license,0);
        $price = $responsearray['price'];
        $is_sale = $responsearray['is_sale'];

        $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $favItem->product_id)->first();
        $is_cart = false;
        $cart_id = null;
        if (!empty($checkCartItem)) {
            $is_cart = true;
            $cart_id = $checkCartItem->id;
        }

        $data = [
            '_id' => Crypt::encrypt($favItem->id),
            'rating' => round($avgRating,2),
            'act_product_id'=>$favItem->product_id,
            'product_id' => Crypt::encrypt($favItem->product_id),
            'product_title' => $favItem->product->product_title,
            'description' => $favItem->product->description,
            'single_license' => $price,
            'actual_single_license' => $favItem->product->single_license,
            'is_paid_or_free' => $favItem->product->is_paid_or_free,
            'main_image' => $favItem->product->main_image ? Storage::disk('s3')->url('products/' . $favItem->product->main_image) : null,
//            'price'             =>  $favItem->price,
            'store_name' => ($storeRes != null) ? $storeRes->store_name : '',
            'store_logo' => ($storeRes != null) ? Storage::disk('s3')->url('store/' . $storeRes->store_logo) : '',
            'product_url' => url('/').'/product-description/'.Crypt::encrypt($favItem->product_id),
            'is_sale' => $is_sale,
            'is_cart' => $is_cart,
            'cart_id' => $cart_id,
            'store_url' => url('/seller-profile/'.str_replace(' ','-',$storeRes->store_name)),

        ];

        $last_id['last_id'] = $favItem->id;
        return array_merge($data, $last_id);
    }

    public function getFavouriteItemShowMore(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $favourite_item_id = $request->get('_id', null);
                    $sort_by_filter = $request->get('sort_by_filter', null);
                    $product_name = $request->get('product_name', null);
                    if (!empty($favourite_item_id)) {
                        $favourite_item_id = Crypt::decrypt($favourite_item_id);
                    }
                    if ($favourite_item_id > 0) {
                        $favouriteItemQuery = FavouriteItem::where('user_id', auth()->user()->id)->with('product')
                                ->where('id', '<', $favourite_item_id);
                        if ($sort_by_filter == 'asc') {
                            $favouriteItemQuery = FavouriteItem::where('user_id', auth()->user()->id)->with('product')
                                    ->where('id', '>', $favourite_item_id);
                        }
//                        if($sort_by_filter == 'desc'){
//                            $favouriteItemQuery = FavouriteItem::with('product')
//                                                        ->where('id', '<', $favourite_item_id);
//                        }
                        if (!empty($product_name)) {
                            $favouriteItemQuery->whereHas('product', function ($query) use ($product_name) {
                                $query->where('product_title', 'like', '%' . $product_name . '%');
                                //$query->orWhere('brand_company_name', 'like', '%'.$product_name.'%');
                            });
                        }

                        $favouriteItems = $favouriteItemQuery->orderBy('id', 'DESC')
                                ->limit(2)
                                ->get();
                    } else {
//                        $favouriteItemQuery  =   Product::with('product');
                        $favouriteItemQuery = FavouriteItem::where('user_id', auth()->user()->id)->with('product');

                        $favouriteItems = $favouriteItemQuery->orderBy('id', 'DESC')
                                ->limit(2)
                                ->get();
                    }

                    $last_id['last_id'] = '';
                    if ($favouriteItems->isNotEmpty()) {
                        foreach ($favouriteItems as $favItem) {
                            $avgRating = Web::getProductRating($favItem->product_id);
                            $data[] = [
                                '_id' => Crypt::encrypt($favItem->id),
                                'rating' => $avgRating,
                                'product_id' => Crypt::encrypt($favItem->product_id),
                                'product_title' => $favItem->product->product_title,
                                'description' => $favItem->product->description,
                                'single_license' => $favItem->product->single_license,
                                'getFavouriteItemShowMore' => $favItem->product->getFavouriteItemShowMore,
                                'main_image' => $favItem->product->main_image ? url('storage/uploads/products/' . $favItem->product->main_image) : null,
                                    //'price'             =>  $favItem->price,
                            ];
                            $last_id['last_id'] = Crypt::encrypt($favItem->id);
                        }
                        $responseArray['success'] = true;
                        $responseArray['data'] = $data;
                        $responseArray['last_id'] = $last_id['last_id'];
                        $responseArray['message'] = 'Favourite Item list fetched.';
                    } else {
                        $responseArray['success'] = true;
                        $responseArray['data'] = [];
                        $responseArray['last_id'] = $last_id['last_id'];
                        $responseArray['message'] = 'Favourite Item not found.';
                    }
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    //Cart items paginate:
    public function getCartItemsPaginate(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $product_id = $request->get('_id', null);

                    $cartItemQuery = $this->cart_item_query($request);
                    $cartItemData = $this->cart_item_pagination_data($request, $cartItemQuery);
                    return $cartItemData;
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function cart_item_query($request) {
        $product_name = $request->get('product_name', null);
        $userId = auth()->user()->id;

        $cartItemQuery = CartItem::where('user_id', $userId)->with('product');
        $cartitem = CartItem::where('user_id', auth()->user()->id)->get();
        if(!empty($cartitem)){
            foreach ($cartitem as $key => $value) {
                # code...
                if($value->type == 'product'){
                    $productid = $value->product_id;
                    $check = Product::leftJoin('users','users.id','=','crc_products.user_id')->where([['crc_products.id','=',$productid],['crc_products.status','=',1],['crc_products.is_deleted','=',0],['users.status','=',1]])->count();
                    if($check == 0){
                        CartItem::where('id', $value->id)->delete();
                    }
                }
            }
        }
        return $cartItemQuery->orderBy('id', 'DESC');
    }

    public function cart_item_pagination_data($request, $cartItemQuery) {
        $per_page = $request->get('per_page', $this->itemPerPage);

        $cartItems = $cartItemQuery->paginate($per_page);
        $cartItems->getCollection()->transform([$this, 'cart_item_data']);
        return $cartItems;
    }

    public function cart_item_data($cartItem) {
        $userId = auth()->user()->id;

        $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $cartItem->product_id)->first();
        $is_favourite = false;
        $favourite_id = null;
        if (!empty($checkFavouriteItem)) {
            $is_favourite = true;
            $favourite_id = $checkFavouriteItem->id;
        }
        $data = array();
        $last_id['last_id'] = 0;
        $totalCartItems['totalCartItems'] = 0;
        $avgRating = Web::getProductRating($cartItem->product_id);
        $storeRes = null;
        $img = null;
        $single_license = null;
        
        if($cartItem->type == 'product'){
            $storeRes = \App\Models\Store::where('id', $cartItem->product->store_id)->first();       
            $img = $cartItem->product->main_image ? Storage::disk('s3')->url('products/' . $cartItem->product->main_image) : null;
            $single_license = $cartItem->product->single_license;
        }
        $giftid = '';
        $recipient_email = '';
        if($cartItem->type == 'gift'){
            $img = url('/images/GIft-Card.jpg');
            $crt = Cartgiftcard::where('id', $cartItem->product_id)->first();
            $single_license = $crt->gift_amount;
            $giftid = url("/gift-card/".Crypt::encrypt($crt->id));
            $recipient_email = $crt->recipient_email;
        }
        
        
       
        if($cartItem->type == 'gift'){
            $img = url('/images/GIft-Card.jpg');
            $crt = Cartgiftcard::where('id', $cartItem->product_id)->first();
            $price = $crt->gift_amount;
            $is_sale = 0;
        }

        //check if sale is going for product
        if($cartItem->type != 'gift'){
            $responsearray = Web::getsingleprice($cartItem->product_id,$cartItem->product->user_id,$cartItem->product->single_license,0);
            $price = $responsearray['price'];
            $is_sale = $responsearray['is_sale'];

            $responseArray = Web::getsingleprice($cartItem->product_id,$cartItem->product->user_id,(!empty($cartItem->product->multiple_license))?$cartItem->product->multiple_license:$cartItem->product->single_license,0);
            $m_price = $responseArray['price'];
        }

        $data = [
            '_id' => Crypt::encrypt($cartItem->id),
            'product_id' => Crypt::encrypt($cartItem->product_id),
            'product_title' => ($cartItem->product != null) ? $cartItem->product->product_title : '',
            'type' => $cartItem->type,
            'description' => ($cartItem->product != null) ? $cartItem->product->description : '',
            'single_license' => round($price,2),
            'actual_single_license' => round( ($cartItem->type != 'gift' ? $cartItem->product->single_license : $price),2),
            'actual_multiple_license' => (!empty($cartItem->product->multiple_license)) ?round( ($cartItem->type != 'gift' ? $cartItem->product->multiple_license : 0),2):0,
            'multiple_license' => ($cartItem->product != null && !empty($m_price)) ? $m_price : '',
            'is_paid_or_free' => ($cartItem->product != null) ? $cartItem->product->is_paid_or_free :'',
            'main_image' => $img,
            'quantity'   =>  $cartItem->quantity,
            'is_favourite' => $is_favourite,
            'favourite_id' => $favourite_id,
            'rating' => round($avgRating,2),
            'store_name' => ($storeRes != null) ? $storeRes->store_name : '',
            'store_logo' => ($storeRes != null) ? Storage::disk('s3')->url('store/' . $storeRes->store_logo) : '',
            'product_url' => ($cartItem->type == 'product' )?url('/').'/product-description/'.Crypt::encrypt($cartItem->product_id):'#',
            'gift_card_id' => $giftid,
            'recipient_email' => $recipient_email,
            'is_sale' => $is_sale,
        ];
        $cartItems = CartItem::where('user_id', $userId)->get();
        if ($cartItems->isNotEmpty()) {
            $totalCartItems['totalCartItems'] = $cartItems->count();
        }
        $last_id['last_id'] = $cartItem->id;

        return array_merge($data, $last_id, $totalCartItems);
    }

    public function addToCart(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), CartItem::$validation);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $product_id = Crypt::decrypt($request->product_id);
                    $cartData = [
                        'user_id' => auth()->user()->id,
                        'product_id' => $product_id,
                    ];

                    //To check if already product added to Favourite:-
                    $checkCartItem = CartItem::where('user_id', auth()->user()->id)->where('product_id', $product_id)->count();
                    if ($checkCartItem > 0) {
                        throw new Exception("This item is already added to cart");
                    } else {
                        //Add to Favourite Item Create:-
                        $cartItem = CartItem::create($cartData);
                        if ($cartItem) {
                            $responseArray['success'] = true;
                            $responseArray['message'] = 'Item added to cart successfully!';
                        } else {
                            throw new Exception("Error occured in add to cart");
                        }
                    }
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function removeCartItem(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), CartItem::$removeCartItemValidation);
                if ($validation->fails()) {
                    $responseArray['error'] = $validation->errors();
                    $responseArray['message'] = 'Validation Error';
                } else {
                    $userId = 0;
                    if (Auth::check()) {
                        $userId = auth()->user()->id;
                    }

                    if ($request->product_id) {
                        $product_id = Crypt::decrypt($request->product_id);
                    }
                    $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $product_id)->first();
                    if (empty($checkCartItem)) {
                        throw new Exception("Error occured in Remove your cart item");
                    }
                    if (!empty($checkCartItem)) {
                        if($checkCartItem->type == 'gift'){
                            $t = Cartgiftcard::where('id', $checkCartItem->product_id)->delete();
                        }
                        $cartItemUpdate = CartItem::where('user_id', $userId)
                                ->where('id', $checkCartItem->id)
                                ->delete();
                        $totalCartItem = CartItem::where('user_id', $userId)->count();
                        if ($cartItemUpdate) {
                            $responseArray['success'] = true;
                            $responseArray['count'] = $totalCartItem;
                            $responseArray['message'] = 'This item Removed from your Cart Successfully!';
                        } else {
                            throw new Exception("Error occured in Remove your cart item");
                        }
                    }
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function changequantitycart(Request $request){
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), CartItem::$validation);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $product_id = Crypt::decrypt($request->product_id);
                    $cartData = [
                        'quantity' => $request->quantity,
                    ];

                    //To check if already product added to Favourite:-
                    $checkCartItem = CartItem::where('user_id', auth()->user()->id)->where('product_id', $product_id)->count();
                
                    if ($checkCartItem < 1) {

                        $cartItem = CartItem::insert([
                                        'product_id' => $product_id,
                                        'user_id' => auth()->user()->id,
                                        'quantity' =>$request->quantity,
                                    ]);
                        $responseArray['success'] = true;
                        $responseArray['message'] = "Cart item Added successfully successfully!";

                    } else {
                        $cartItem = CartItem::where('product_id', $product_id)->update($cartData);
                        if ($cartItem) {
                            $responseArray['success'] = true;
                            $responseArray['message'] = 'Cart item updated successfully successfully!';
                        } else {
                            $responseArray['message'] = "Error occured in add to cart";
                        }
                    }
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);  
    }

    public function totalCartItemCount(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        //get user added product
        $user = User::where('role_id',1)->where('email',auth()->user()->email)->first();
        if(empty($user)){
            return response()->json($responseArray, 201);
        }
        $cartitem = CartItem::where('user_id', $user->id)->get();
        if(!empty($cartitem)){
            foreach ($cartitem as $key => $value) {
                # code...
                if($value->type == 'product'){
                    $productid = $value->product_id;
                    $check = Product::leftJoin('users','users.id','=','crc_products.user_id')->where([['crc_products.id','=',$productid],['crc_products.status','=',1],['crc_products.is_deleted','=',0],['users.status','=',1]])->count();
                    if($check == 0){
                        CartItem::where('id', $value->id)->delete();
                    }   
                }
            }
        }
        try {
            if ($request->isMethod('get')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['error'] = $validation->errors();
                    $responseArray['message'] = 'Validation Error';
                } else {
                    $totalCartItem = CartItem::where('user_id', $user->id)->count();
                    if(!empty($totalCartItem)){
                        $cartitem = CartItem::where('user_id', $user->id)->get();
                        foreach ($cartitem as $key => $value) {
                            # code...
                            if($value->type == 'product'){
                                $productid = $value->product_id;
                                $check = Product::leftJoin('users','users.id','=','crc_products.user_id')->where([['crc_products.id','=',$productid],['crc_products.status','=',1],['crc_products.is_deleted','=',0],['users.status','=',1]])->count();
                                if($check == 0){
                                    CartItem::where('id', $value->id)->delete();
                                }
                            }
                        }
                    }
                    $responseArray['success'] = true;
                    $responseArray['data'] = $totalCartItem;
                    $responseArray['message'] = 'Total cart items count';
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function checkoutItemsDetails(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('get')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['error'] = $validation->errors();
                    $responseArray['message'] = 'Validation Error';
                } else {
                    $userId = auth()->user()->id;
                    $cartItems = CartItem::where('user_id', $userId)->with('product')->get();
                    $totalCartItem = 0;
                    if($cartItems->isNotEmpty()){
                        foreach($cartItems as $itms){
                            $totalCartItem += $itms->quantity;
                        }
                    } 
                    //                    foreach($cartItems as $cartItem){
                    //                        
                    //                    }
                    // $totalCartproductPrice = User::with('cartsWithProductPrice')->find($userId);
                    // $cartProductPriceArr = $totalCartproductPrice->cartsWithProductPrice->pluck('price')->toArray();
                   
                    
                    $totalAmount = 0;
                    
                    // foreach ($cartProductPriceArr as $price) {
                    //     $totalAmount += $price;
                    // }
                    $dis = 0;
                    $giftamount = 0;
                    foreach($cartItems as $cartItem){
                        if($cartItem->type == 'gift'){
                            $cr = Cartgiftcard::where('id', $cartItem->product_id)->first();
                            if(!empty($cr)){
                                $totalAmount += $cr->gift_amount;
                                $giftamount += $cr->gift_amount;
                            }
                            if(!$dis){
                                $dis = 1;
                            }
                        }
                        else{
                            $pr = Product::where('id',$cartItem->product_id)->first();
                            if(!empty($pr) && $pr->is_paid_or_free == 'paid'){
                                //check if sale is going for product
                                $p = $pr->single_license;
                                if($cartItem->quantity > 1 ){
                                    $p = !empty($pr->multiple_license)?$pr->multiple_license:$pr->single_license;
                                }
                                $responsearray = Web::getsingleprice($cartItem->product_id,$pr->user_id,$p,0);
                                $price = $responsearray['price'] * $cartItem->quantity;
                                
                                $totalAmount += $price;
                                if(!$dis && $pr->is_paid_or_free == 'paid'){
                                    $dis = 1;
                                }
                            }
                        }
                    }

                    if ($request->type == 'gift') {
                        
                        $giftCardRes = GiftCards::where('gift_code', $request->val)->first();
                        
                        if ($giftCardRes != null) {
                            $totalAmount = ($totalAmount < $giftCardRes->remaining_amount) ? 0 : $totalAmount - $giftCardRes->remaining_amount;  
                        }
                        
                    }elseif($request->type == 'promotional'){
                        
                        $promotionalRes = PromoDetails::where('promo_code', $request->val)->where('status',1)->first();
                        
                        if($promotionalRes != null){
                            if($promotionalRes->discount_in == 1){
                              $totalAmount = ($totalAmount < $promotionalRes->amount) ? 0 : $totalAmount - $promotionalRes->amount;
                            }
                            else{
                              $totalAmount = $totalAmount - ($totalAmount * ($promotionalRes->amount/100));
                            }
                        }
    
                    }
                    //Buyer Tax 
                    $buyer_tax = 0;
                    if(auth()->user()->country == 'Australia'){
                      $buyer_tax = ($totalAmount-$giftamount)*0.1;
                    }
                    $data = [];
                    $data['totalCartItem'] = $totalCartItem;
                    $data['totalAmount'] = number_format((float) $totalAmount, 2, '.', '');
                    $data['totalAmountshow'] = number_format((float)($totalAmount+$buyer_tax), 2, '.', '');
                    $data['buyertax'] = number_format((float) $buyer_tax, 2, '.', '');
                    $data['disabled'] = $dis;

                    $responseArray['success'] = true;
                    $responseArray['data'] = $data;
                    $responseArray['message'] = 'Total cart items checkout details';
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function getPurchaseHistoryPaginate(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $product_id = $request->get('_id', null);

                    $purchaseHistoryQuery = $this->purchase_history_query($request);
                    $purchaseHistoryData = $this->purchase_history_pagination_data($request, $purchaseHistoryQuery);
                    return $purchaseHistoryData;
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function purchase_history_query($request) {
        $product_name = $request->get('product_name', null);
        $sort_by_sort = $request->get('sort_by_sort', null);
        $sort_by_price = $request->get('sort_by_price', null);
        $sort_by_type = $request->get('sort_by_type', null);

        $userId = auth()->user()->id;
        $orderDetails = Order::where('status', '!=', 0)->where('user_id', $userId)->get();
        $orderIds = $orderDetails->pluck('id');
        $getOrderProductsQuery = OrderItem::whereIn('crc_order_items.order_id', $orderIds)->with('product','giftcard');
       
        if (!empty($product_name)) {
            if(str_contains('classroom copy gift card',strtolower($product_name))){
                $getOrderProductsQuery->whereIn('type',['gift'])->orWhereHas('product', function ($query) use ($product_name) {
                        $query->where('product_title', 'like', '%' . $product_name . '%');
                });
            }
            else{
                $getOrderProductsQuery->where('type','product')->whereHas('product', function ($query) use ($product_name) {
                        $query->where('product_title', 'like', '%' . $product_name . '%');
                }); 
            }
            
            // $getOrderProductsQuery->whereHas('giftcard', function ($query) use ($product_name) {
            //     $query->where('product_title', 'like', '%' . $product_name . '%');
            // });
        }
        if (!empty($sort_by_type)) {
            $getOrderProductsQuery->where('type','product')->whereHas('product', function ($query) use ($sort_by_type) {
                $query->where('product_type', $sort_by_type);
            });
        }
        if (!empty($sort_by_price)) {
            if ($sort_by_price == 'free') {
                $getOrderProductsQuery->where('price','=',0);
            }
            if ($sort_by_price == 'under5') {
                $getOrderProductsQuery->where('price', '<', 5);
            }
            if ($sort_by_price == '5-10') {
                $getOrderProductsQuery->whereBetween('price', [5, 10]);
            }
            if ($sort_by_price == 'over10') {
                $getOrderProductsQuery->where('price', '>', 10);
            }
        }
        if (!empty($sort_by_sort)) {
            if ($sort_by_sort == 'ascending') {
                return $getOrderProductsQuery->orderBy('price', 'asc');
            }
            if ($sort_by_sort == 'descending') {
                return $getOrderProductsQuery->orderBy('price', 'desc');
            }
            if($sort_by_sort  == 'rating'){
               return $getOrderProductsQuery->select('crc_order_items.product_id','crc_order_items.id','crc_order_items.type','crc_order_items.amount','crc_order_items.downloads_left','crc_order_items.created_at','crc_order_items.order_id',DB::raw('coalesce(avg(rating),0) as avg_r'))->leftjoin('crc_rate_review', 'crc_rate_review.product_id', 'crc_order_items.product_id')->groupBy('crc_order_items.product_id','crc_order_items.id')->orderBy('avg_r','DESC'); 
            }
        }
        return $getOrderProductsQuery->orderBy('id', 'DESC');
    }

    public function purchase_history_pagination_data($request, $purchaseHistoryQuery) {
        $per_page = $request->get('per_page', $this->itemPerPage);

        $purchaseHistory = $purchaseHistoryQuery->paginate($per_page);
        $purchaseHistory->getCollection()->transform([$this, 'purchase_history_data']);
        return $purchaseHistory;
    }

    public function purchase_history_data($purchaseHistoryItem) {
        $seller = '';
        $product_title = 'Classroom copy gift card';
        $main_image = url('/images/GIft-Card.jpg');
        $product_file = '';
        $updatedtime = '';
        $type = '';
        if($purchaseHistoryItem->type == 'product' && isset($purchaseHistoryItem->product)){
            $seller = User::where('id', $purchaseHistoryItem->product->user_id)->first();
            $sellerinfo = Store::where('user_id',$purchaseHistoryItem->product->user_id)->first();
            $product_title = $purchaseHistoryItem->product->product_title;
            $main_image = Storage::disk('s3')->url('products/' . $purchaseHistoryItem->product->main_image);
            $product_file = $purchaseHistoryItem->product->product_file;
            $updatedtime  = $purchaseHistoryItem->product->updated_at;
            $type = $purchaseHistoryItem->product->type;
        }
        $recipient_email = '';
        $from_name = '';
        $s_price = 0;
        $m_price = 0;
        if($purchaseHistoryItem->type == 'gift'){
            $crt = Cartgiftcard::where('id', $purchaseHistoryItem->product_id)->first();
            $recipient_email = $crt->recipient_email;
            $from_name = $crt->from_name;
        }
        else{
            if($main_image == url('/images/GIft-Card.jpg')){
                $main_image = url('/images/logo.png');
            }
            if($product_title == 'Classroom copy gift card'){
                $product_title = 'Deleted Product';
            }
            $uid = 0;
            $mp = $purchaseHistoryItem->price;
            $sp = $purchaseHistoryItem->price;
            if(isset($purchaseHistoryItem->product)){
                $uid = $purchaseHistoryItem->product->user_id;
                $mp = !empty($purchaseHistoryItem->product->multiple_license)?$purchaseHistoryItem->product->multiple_license:$purchaseHistoryItem->product->single_license;
                $sp = $purchaseHistoryItem->product->single_license;
            }
            $responsearr = Web::getsingleprice($purchaseHistoryItem->product_id,$uid,$sp,0);
            $s_price = $responsearr['price'];
            $responseArray = Web::getsingleprice($purchaseHistoryItem->product_id,$uid,$mp,0);
            $m_price = $responseArray['price'];
        }
        $getordernumber = Order::where('id',$purchaseHistoryItem->order_id)->first();
        
        //        $last_id['last_id']    = 0;
        $data = [
            '_order_item_id' => Crypt::encrypt($purchaseHistoryItem->id),
            '_order_id' => Crypt::encrypt($purchaseHistoryItem->order_id),
            'order_id' => $purchaseHistoryItem->order_id,
            '_product_id' => Crypt::encrypt($purchaseHistoryItem->product_id),
            'product_title' => $product_title,
            'purchase_price' => $purchaseHistoryItem->amount,
            'downloads_left'  => $purchaseHistoryItem->downloads_left,
            'main_image' => $main_image,
            'product_file' => $product_file ? Storage::disk('s3')->url('products/' . $product_file) : 'null',
            'invoice' => !empty(Storage::disk('s3')->exists('orderinvoice/' . $getordernumber->order_number.'.pdf'))?Storage::disk('s3')->url('orderinvoice/' . $getordernumber->order_number.'.pdf'):'',
            'file_type' => $purchaseHistoryItem->product ? strtoupper($purchaseHistoryItem->product->product_type) : 'NA',
            'purchase_date' => $purchaseHistoryItem->created_at ? Carbon::createFromFormat('Y-m-d H:i:s', $purchaseHistoryItem->created_at)->format('d M Y') : 'NA',
            'updated_date' => $updatedtime ? Carbon::createFromFormat('Y-m-d H:i:s', $updatedtime)->format('d M Y') : '',
            'seller_name' => !empty($sellerinfo) ? $sellerinfo->store_name: 'NA',
            'seller_link' =>!empty($sellerinfo) ? url('/seller-profile/'.str_replace(' ','-',$sellerinfo->store_name)): 'NA',
            'recipient_email' => $recipient_email,
            'from_name' => $from_name,
            'freeproduct' => ($purchaseHistoryItem->product && $purchaseHistoryItem->product->is_paid_or_free == 'free') ? 1:0,
            'single_license' => $s_price, 
            'multiple_license' => $m_price, 
            'type' => $type,
        ];

        return $data;
        //        $last_id['last_id']     = $favItem->id;
        //        return array_merge($data,$last_id);
    }

    public function getPurchaseHistoryShowMore(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $userId = auth()->user()->id;
                    $order_item_id = $request->get('_id', null);
                    $sort_by_sort = $request->get('sort_by_sort', null);
                    $sort_by_price = $request->get('sort_by_price', null);
                    $sort_by_type = $request->get('sort_by_type', null);
                    $product_name = $request->get('product_name', null);
                    if (!empty($order_item_id)) {
                        $order_item_id = Crypt::decrypt($order_item_id);
                    }
                    if ($order_item_id > 0) {
                        $orderDetails = Order::where('status', '!=', 0)->where('user_id', $userId)->get();
                        $orderIds = $orderDetails->pluck('id');

                        $getOrderProductsQuery = OrderItem::whereIn('order_id', $orderIds)->with('product')
                                ->where('id', '<', $order_item_id);
                        if ($sort_by_sort == 'ascending') {
                            $getOrderProductsQuery = OrderItem::whereIn('order_id', $orderIds)->with('product')
                                    ->where('id', '>', $order_item_id);
                        }
                        if (!empty($product_name)) {
                            $getOrderProductsQuery->whereHas('product', function ($query) use ($product_name) {
                                $query->where('product_title', 'like', '%' . $product_name . '%');
                            });
                        }
                        if (!empty($sort_by_type)) {
                            $getOrderProductsQuery->whereHas('product', function ($query) use ($sort_by_type) {
                                $query->where('product_type', $sort_by_type);
                            });
                        }
                        if (!empty($sort_by_price)) {
                            if ($sort_by_price == 'free') {
                                $getOrderProductsQuery->whereHas('product', function ($query) {
                                    $query->where('is_paid_or_free', 'free');
                                });
                            }
                            if ($sort_by_price == 'under5') {
                                $getOrderProductsQuery->whereHas('product', function ($query) {
                                    $query->where('single_license', '<', 5);
                                });
                            }
                            if ($sort_by_price == '5-10') {
                                $getOrderProductsQuery->whereHas('product', function ($query) {
                                    $query->whereBetween('single_license', [5, 10]);
                                });
                            }
                            if ($sort_by_price == 'over10') {
                                $getOrderProductsQuery->whereHas('product', function ($query) {
                                    $query->where('single_license', '>', 10);
                                });
                            }
                        }

                        if (!empty($sort_by_sort)) {
                            if ($sort_by_sort == 'ascending') {
                                $getOrderProductsQuery = $getOrderProductsQuery->orderBy('price', 'asc')
                                        ->limit(2)
                                        ->get();
                            }
                            if ($sort_by_sort == 'descending') {
                                $getOrderProductsQuery = $getOrderProductsQuery->orderBy('price', 'DESC')
                                        ->limit(2)
                                        ->get();
                            }
                        } else {
                            $getOrderProductsQuery = $getOrderProductsQuery->orderBy('id', 'DESC')
                                    ->limit(2)
                                    ->get();
                        }
                    } else {
                        $orderDetails = Order::where('status', '!=', 0)->where('user_id', $userId)->get();
                        $orderIds = $orderDetails->pluck('id');
                        $getOrderProductsQuery = OrderItem::whereIn('order_id', $orderIds)->with('product');

                        $getOrderProductsQuery = $getOrderProductsQuery->orderBy('id', 'DESC')
                                ->limit(2)
                                ->get();
                    }

                    $last_id['last_id'] = '';
                    if ($getOrderProductsQuery->isNotEmpty()) {
                        foreach ($getOrderProductsQuery as $purchaseHistoryItem) {
                            $seller = User::where('id', $purchaseHistoryItem->product->user_id)->first();
                            $data[] = [
                                '_order_item_id' => Crypt::encrypt($purchaseHistoryItem->id),
                                '_order_id' => Crypt::encrypt($purchaseHistoryItem->order_id),
                                'order_id' => $purchaseHistoryItem->order_id,
                                '_product_id' => Crypt::encrypt($purchaseHistoryItem->product_id),
                                'product_title' => $purchaseHistoryItem->product->product_title,
                                'purchase_price' => $purchaseHistoryItem->price,
                                'main_image' => $purchaseHistoryItem->product->main_image ? url('storage/uploads/products/' . $purchaseHistoryItem->product->main_image) : null,
                                'product_file' => $purchaseHistoryItem->product->product_file ? url('storage/uploads/products/' . $purchaseHistoryItem->product->product_file) : null,
                                'file_type' => $purchaseHistoryItem->product ? strtoupper($purchaseHistoryItem->product->product_type) : 'NA',
                                'purchase_date' => $purchaseHistoryItem->created_at ? Carbon::createFromFormat('Y-m-d H:i:s', $purchaseHistoryItem->created_at)->format('d M Y') : 'NA',
                                'seller_name' => !empty($seller) ? $seller->first_name . ' ' . $seller->surname : 'NA',
                            ];
                            $last_id['last_id'] = Crypt::encrypt($purchaseHistoryItem->id);
                        }
                        $responseArray['success'] = true;
                        $responseArray['data'] = $data;
                        $responseArray['last_id'] = $last_id['last_id'];
                        $responseArray['message'] = 'Purchase history Item list fetched.';
                    } else {
                        $responseArray['success'] = true;
                        $responseArray['data'] = [];
                        $responseArray['last_id'] = $last_id['last_id'];
                        $responseArray['message'] = 'Purchase history Item not found.';
                    }
                }
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function changeorderitemdownload(Request $request){
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                
                $orderitemid = Crypt::decrypt($request->orderitemid);
                $itemdata = [
                    'downloads_left' => $request->quantity,
                ];
                //To check if already product added to Favourite:-
                $orderitem = OrderItem::where('user_id', auth()->user()->id)->where('id', $orderitemid)->count();
                if ($orderitem < 0) {
                    $responseArray['message'] = "Invalid orderitem id";
                } else {
                    $orderitem = OrderItem::where('id', $orderitemid)->update($itemdata);
                    if ($orderitem) {
                        $responseArray['success'] = true;
                        $responseArray['message'] = 'Order Item updated successfully!';
                    } else {
                        $responseArray['message'] = "Error occured in updating downloads_left";
                    }
                }

            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function createorderfreeproduct(Request $request){
        $userid = auth()->user()->id;
        $responseArray = ['success' => false,'download' => false,'message' => ''];
        try {
            if ($request->isMethod('post') && !empty($userid)) {
                
                $product_id = Crypt::decrypt($request->product_id);

                //check order exist
                $orderitem = OrderItem::where('user_id', $userid)->where('product_id', $product_id)->count();
                if ($orderitem > 0) {
                    $responseArray['success'] = true;
                    $responseArray['message'] = "Already Order Exist";
                    $responseArray['download'] = true;
                } else {
               
                    $orderNumberCreate = 'CC' . time() . rand(1, 100);
                    $orderData = [
                        'order_number' => $orderNumberCreate,
                        'user_id' => $userid,
                        'total_amount' => 0,
                        'total_quantity' => 1,
                        'status' => 1,
                        'remark' => '',
                        'payment_type' => 'Card',
                    ];
                    $orderCreate = Order::create($orderData);
                    if ($orderCreate) {
                    
                        $orderItemsData = [
                            'order_id' => $orderCreate->id,
                            'user_id' => $userid,
                            'product_id' => $product_id,
                            'quantity' => 1,
                            'downloads_left' => 1,
                            'price' => 0,
                            'amount' => 0,
                            'payment_type' => 'Card',
                            'status' => 1,
                            'type'=> 'product',
                        ];
                        $createOrderItems = OrderItem::create($orderItemsData);
                        $responseArray['success'] = true;
                        $responseArray['message'] = "Order Created";
                        $responseArray['download'] = true;
                    } else {
                        $responseArray['message'] = "Error occured in creating order";
                    }
                }

            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function checkifalreadypurached(Request $request){
        $responseArray = ['success' => false,'message' => '','status'=>2];
        try {
            if(!empty($request->product_id)){
                $product_id = Crypt::decrypt($request->product_id);
                $checkalreadyordered = OrderItem::where('user_id',auth()->user()->id)->where('product_id',$product_id)->first();

                //check if current user author 
                $getseller = User::where('email',auth()->user()->email)->where('role_id',2)->first();
                $checkauthor = Product::where('user_id',$getseller->id)->where('id',$product_id)->first();
                if(!empty($checkauthor)){
                    $responseArray['status'] = 0;
                    $responseArray['message'] = 'Sellers are prohibited <br> from buying their own products.';
                }
                elseif(!empty($checkalreadyordered)){
                    $responseArray['success'] = true;
                    $responseArray['status'] = 1;
                    $responseArray['message'] = 'Product Already Purchased';
                }
            }
            else{
                $responseArray['status'] = 0;
                $responseArray['message'] = 'Please Send Product id';
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }
}