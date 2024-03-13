<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Crypt,
    Mail,
    Redirect,
    Session,
    Storage,
    DB
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
    Order,
    OrderItem,
    hostsale,
    ReviewReply,
    Questions,
    RateReviews,
    SellerOfferApplied
};
use Exception;
use Validator;
use \App\Http\Helper\Web;
use Artisan;
use Carbon\Carbon;
use ZipArchive;
use Log;

class HomeController extends Controller {

    public $itemPerPage = 8;

    public function verifyUser($token) {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->verified = 1;
                $verifyUser->user->save();
                $status = "Your e-mail is verified. You can now login.";
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return redirect('/')->with('error', "Sorry your email cannot be identified.");
        }
        return redirect('/')->with('success', $status);
    }

    public function helpFaq(Request $request) {
        $data = [];
        $data['title'] = 'Help & Faq';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'FAQ';
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;

        return view('help_faq', compact('data'));
    }

    public function documentAndPolicies(Request $request) {
        $data = [];
        $data['title'] = 'Document & Policies';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'FAQ';
        $data['breadcrumb1_link'] = route('help.faq');
        $data['breadcrumb2'] = 'Documents And Policies';
        $data['breadcrumb3'] = false;

        return view('document_and_policies', compact('data'));
    }

    public function becomeAseller(Request $request) {
        $data = [];
        $data['title'] = 'Become A Seller';
        $data['home'] = 'Home';
        $data['is_store_added'] = 0;
        if (Auth::check()) {
            /* if (auth()->user()->role_id == 1) {
              $data['breadcrumb1'] = 'Account Dashboard';
              }
              if (auth()->user()->role_id == 2) {
              $data['breadcrumb1'] = 'Store Dashboard';
              $storeRes = Store::where('user_id', auth()->user()->id)->first();
              $data['is_store_added'] = ($storeRes == null) ? 0 : 1;
              }
              $data['breadcrumb2'] = 'Become A Seller';
              $data['breadcrumb3'] = false; */

            if (auth()->user()->role_id == 2) {
                $data['breadcrumb1'] = 'Store Dashboard';
                $data['breadcrumb1_link'] = route('store.dashboard');
                $storeRes = Store::where('user_id', auth()->user()->id)->first();
                $data['is_store_added'] = ($storeRes == null) ? 0 : 1;
                $data['breadcrumb2'] = 'Become A Seller';
                $data['breadcrumb3'] = false;
            } else {
                $email = $email = auth()->user()->email;
                $userData = User::where('role_id', 2)->where('email', $email)->first();
                if ($userData != null) {
                    Auth::logout();
                    if (Auth::loginUsingId($userData->id)) {
                        $data['breadcrumb1'] = 'Store Dashboard';
                        $data['breadcrumb1_link'] = route('store.dashboard');
                        $storeRes = Store::where('user_id', auth()->user()->id)->first();
                        $data['is_store_added'] = ($storeRes == null) ? 0 : 1;
                        $data['breadcrumb2'] = 'Become A Seller';
                        $data['breadcrumb3'] = false;
                    } else {
                        $data['breadcrumb1'] = 'Become A Seller';
                        $data['breadcrumb2'] = false;
                        $data['breadcrumb3'] = false;
                    }
                } else {
                    $data['breadcrumb1'] = 'Become A Seller';
                    $data['breadcrumb2'] = false;
                    $data['breadcrumb3'] = false;
                }
            }
        } else {
            $data['breadcrumb1'] = 'Become A Seller';
            $data['breadcrumb2'] = false;
            $data['breadcrumb3'] = false;
        }


        return view('become_a_seller', compact('data'));
    }

    /*     * *********
      public function searchResult(Request $request) {
      $data                   =   [];
      $data['title']          =   'Search Products';
      $data['home']           =   'Home';
      if(Auth::check()){
      if(auth()->user()->role_id == 1){
      $data['breadcrumb1']    =   'Account Dashboard';
      }
      if(auth()->user()->role_id == 2){
      $data['breadcrumb1']    =   'Store Dashboard';
      }
      $data['breadcrumb2']    =   'Search Products';
      $data['breadcrumb3']    =   false;
      } else {
      $data['breadcrumb1']    =   'Search Products';
      $data['breadcrumb2']    =   false;
      $data['breadcrumb3']    =   false;
      }


      return view('search_result', compact('data'));
      }
     * ********* */

    public function productSearchView(Request $request) {
        $data = [];
        $data['title'] = 'Search Products';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = false;
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;
        $result = [];
        $result = FeatureList::join('crc_products', function ($join) {
                            $join->on('crc_products.id', '=', 'crc_product_feature_list.product_id');
                        })->whereIn('crc_product_feature_list.status', [1])
                        ->whereIn('crc_product_feature_list.payment_status', [1])
                        ->where('date', date('Y-m-d'))->where([['crc_products.status','=',1],['crc_products.is_deleted','=',0]])
                        ->select('crc_products.*')->distinct()->get();
        if (count($result) > 0) {
            foreach ($result as $key => $row) {
                $userId = (auth()->user() != null) ? auth()->user()->id : 0;
                $avgRating = Web::getProductRating($row->id);
                $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $row->id)->first();
                $is_favourite = false;
                $favourite_id = null;
                if (!empty($checkFavouriteItem)) {
                    $is_favourite = true;
                    $favourite_id = $checkFavouriteItem->id;
                }
                $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $row->id)->first();
                $is_cart = false;
                $cart_id = null;
                if (!empty($checkCartItem)) {
                    $is_cart = true;
                    $cart_id = $checkCartItem->id;
                }
               
                //check if sale is going for product
                $responsearray = Web::getsingleprice($row->id,$row->user_id,$row->single_license,0);
                $price = $responsearray['price'];
                $is_sale = $responsearray['is_sale'];
                

                $result[$key]->rating = $avgRating;
                $result[$key]->_id = Crypt::encrypt($row->id);
                $result[$key]->prod_id = $row->id;
                $result[$key]->main_image = Storage::disk('s3')->url('products/' . $row->main_image);
                $result[$key]->auth_user = auth()->user() ? true : false;
                $result[$key]->is_favourite = $is_favourite;
                $result[$key]->favourite_id = $favourite_id;
                $result[$key]->is_cart = $is_cart;
                $result[$key]->cart_id = $cart_id;
                $result[$key]->is_sale = $is_sale;
                $result[$key]->actual_single_license = $row->single_license;
                $result[$key]->single_license = $price;
                $result[$key]->productRatingcount = count(RateReviews::where([['type', '=', 1], ['product_id', '=', $row->id]])->get());
                $result[$key]->sellername = Web::storeDetail(@$row->user_id,'store_name');
                $result[$key]->sellerimage  = Web::storeDetail(@$row->user_id,'store_logo');
                $result[$key]->sellerurl  = url('/seller-profile/'.str_replace(' ','-',Web::storeDetail(@$row->user_id,'store_name')));
            }
        }
        $data['featureProdRes'] = $result;
        $postData = $request->all();

        return view('product_search_view', compact('data', 'postData'));
    }

    public function getProductFilterSearchShowMore(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $product_id = $request->get('_id', null);
                    $price = $request->get('fs_price', null);
                    $format = $request->get('fs_format', null);
                    $type = $request->get('fs_type', null);
                    $language = $request->get('fs_language', null);
                    $subjectArea = $request->get('fs_subject', null);
                    $store_id = $request->get('store_id', null);
                    $grade = $request->get('grade', null);
                    $search_keyword = $request->get('search_keyword', null);
                    if (!empty($product_id)) {
                        $product_id = Crypt::decrypt($product_id);
                    }
                    if ($product_id > 0) {
                        $productsQuery = Product::where([['is_deleted','=',0],['status','=',1]])->with('productImages')
                                ->where('id', '<', $product_id);
                        if (!empty($format)) {
                            $productsQuery->where(function ($query) use ($format) {
                                $query->where('product_type', '=', $format);
                            });
                        }
                        if (!empty($subjectArea)) {
                            $productsQuery->where(function ($query) use ($subjectArea) {
                                $query->where('subject_area', '=', $subjectArea);
                            });
                        }
                        if (!empty($store_id)) {
                            $productsQuery->where(function ($query) use ($store_id) {
                                $query->where('store_id', '=', $store_id);
                            });
                        }
                        if (!empty($grade)) {
                            $productsQuery->where(function ($query) use ($grade) {
                                $query->whereRaw("find_in_set($grade,year_level)");
                            });
                        }
                        if (!empty($language)) {
                            $productsQuery->where(function ($query) use ($language) {
                                $query->where("language", '=', $language);
                            });
                        }
                        if (!empty($type)) {
                            $productsQuery->where(function ($query) use ($type) {
                                $query->where("resource_type", '=', $type);
                            });
                        }
                        if (!empty($price)) {
                            switch ($price):
                                case 'free':
                                    $productsQuery->where(function ($query) {
                                        $query->where("is_paid_or_free", '=', 'free');
                                    });
                                    break;
                                case 'less_than_5':
                                    $productsQuery->where(function ($query) {
                                        $query->where("is_paid_or_free", '=', 'paid');
                                        $query->where("single_license", '>=', 0);
                                        $query->where("multiple_license", '<=', 5);
                                    });
                                    break;
                                case '5_10':
                                    $productsQuery->where(function ($query) {
                                        $query->where("is_paid_or_free", '=', 'paid');
                                        $query->where("single_license", '>=', 5);
                                        $query->where("multiple_license", '<=', 10);
                                    });
                                    break;
                                case 'greater_than_10':
                                    $productsQuery->where(function ($query) {
                                        $query->where("is_paid_or_free", '=', 'paid');
                                        $query->where("single_license", '>=', 10);
                                        //$query->where("multiple_license", '<', 5);
                                    });
                                    break;
                                case 'on_sale':
                                    break;
                            endswitch;
                        }
                        if (!empty($search_keyword)) {
                            $productsQuery->where(function ($query) use ($search_keyword) {
                                $query->where("product_title", 'LIKE', '%' . $search_keyword . '%');
                            });
                        }
                        $products = $productsQuery->orderBy('id', 'DESC')
                                ->limit($this->itemPerPage)
                                ->get();
                    } else {
                        $productsQuery = Product::where([['is_deleted','=',0],['status','=',1]])->with('productImages');
                        if (!empty($format)) {
                            $productsQuery->where(function ($query) use ($format) {
                                $query->where('product_type', '=', $format);
                            });
                        }
                        if (!empty($subjectArea)) {
                            $productsQuery->where(function ($query) use ($subjectArea) {
                                $query->where('subject_area', '=', $subjectArea);
                            });
                        }
                        if (!empty($store_id)) {
                            $productsQuery->where(function ($query) use ($store_id) {
                                $query->where('store_id', '=', $store_id);
                            });
                        }
                        if (!empty($grade)) {
                            $productsQuery->where(function ($query) use ($grade) {
                                $query->whereRaw("find_in_set($grade,year_level)");
                            });
                        }
                        if (!empty($language)) {
                            $productsQuery->where(function ($query) use ($language) {
                                $query->where("language", '=', $language);
                            });
                        }
                        if (!empty($type)) {
                            $productsQuery->where(function ($query) use ($type) {
                                $query->where("resource_type", '=', $type);
                            });
                        }
                        if (!empty($price)) {
                            switch ($price):
                                case 'free':
                                    $productsQuery->where(function ($query) {
                                        $query->where("is_paid_or_free", '=', 'free');
                                    });
                                    break;
                                case 'less_than_5':
                                    $productsQuery->where(function ($query) {
                                        $query->where("is_paid_or_free", '=', 'paid');
                                        $query->where("single_license", '>=', 0);
                                        $query->where("multiple_license", '<=', 5);
                                    });
                                    break;
                                case '5_10':
                                    $productsQuery->where(function ($query) {
                                        $query->where("is_paid_or_free", '=', 'paid');
                                        $query->where("single_license", '>=', 5);
                                        $query->where("multiple_license", '<=', 10);
                                    });
                                    break;
                                case 'greater_than_10':
                                    $productsQuery->where(function ($query) {
                                        $query->where("is_paid_or_free", '=', 'paid');
                                        $query->where("single_license", '>=', 10);
                                        //$query->where("multiple_license", '<', 5);
                                    });
                                    break;
                                case 'on_sale':
                                    break;
                            endswitch;
                        }
                        if (!empty($search_keyword)) {
                            $productsQuery->where(function ($query) use ($search_keyword) {
                                $query->where("product_title", 'LIKE', '%' . $search_keyword . '%');
                            });
                        }
                        $products = $productsQuery->orderBy('id', 'DESC')
                                ->limit($this->itemPerPage)
                                ->get();
                    }

                    $last_id['last_id'] = '';
                    if ($products->isNotEmpty()) {
                        $userId = 0;
                        if (Auth::check()) {
                            $userId = auth()->user()->id;
                        }
                        foreach ($products as $product) {
                            $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $product->id)->first();
                            $is_favourite = false;
                            $favourite_id = null;
                            if (!empty($checkFavouriteItem)) {
                                $is_favourite = true;
                                $favourite_id = $checkFavouriteItem->id;
                            }
                            $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $product->id)->first();
                            $is_cart = false;
                            $cart_id = null;
                            if (!empty($checkCartItem)) {
                                $is_cart = true;
                                $cart_id = $checkCartItem->id;
                            }
                            $avgRating = Web::getProductRating($product->id);
                            $data[] = [
                                '_id' => Crypt::encrypt($product->id),
                                'prod_id' => $product->id,
                                'product_title' => $product->product_title,
                                'product_type' => $product->product_type,
                                'product_file' => $product->product_file,
                                'single_license' => $product->single_license,
                                'multiple_license' => $product->multiple_license,
                                'is_paid_or_free' => $product->is_paid_or_free,
                                'main_image' => Storage::disk('s3')->url('products/' . $product->main_image),
                                'description' => $product->description,
                                'is_favourite' => $is_favourite,
                                'favourite_id' => $favourite_id,
                                'is_cart' => $is_cart,
                                'cart_id' => $cart_id,
                                'auth_user' => auth()->user() ? true : false,
                                'rating' => $avgRating
                            ];
                            $last_id['last_id'] = Crypt::encrypt($product->id);
                        }
                        $responseArray['success'] = true;
                        $responseArray['data'] = $data;
                        $responseArray['last_id'] = $last_id['last_id'];
                        $responseArray['message'] = 'Products list resources you may like fetched.';
                    } else {
                        $responseArray['success'] = true;
                        $responseArray['data'] = [];
                        $responseArray['last_id'] = $last_id['last_id'];
                        $responseArray['message'] = 'Products list resources you may like not found.';
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

    public function accountDashboardViewForStore(Request $request) {
        $data = [];
        $data['title'] = 'Account Dashboard';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;

        return view('account_dashboard_view_for_store_user', compact('data'));
    }

    public function storeDashboardViewForAccount(Request $request) {
        $data = [];
        $data['title'] = 'Store Dashboard';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;

        return view('store_dashboard_view_for_account_user', compact('data'));
    }

    public function getCountriesList(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), Country::$getCountriesValidation);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $country_name = $request->get('country_name', null);
                    $countries = Country::where('status', 1);
                    if (!empty($country_name)) {
                        $countries->where(function ($query) use ($country_name) {
                            $query->orWhere('name', 'like', '%' . $country_name . '%');
                            $query->orWhere('sortname', 'like', '%' . $country_name . '%');
                        });
                    }
                    $countries = $countries->orderBy('priority', 'DESC')->get();
                    $data = [];
                    if ($countries->isNotEmpty()) {
                        foreach ($countries as $country) {
                            $data['countries'][] = [
                                'id' => $country->id,
                                'sortname' => $country->sortname,
                                'name' => $country->name,
                                'slug' => $country->slug,
                                'phonecode' => $country->phonecode,
                                'status' => $country->status,
                            ];
                        }
                        $responseArray['success'] = true;
                        $responseArray['data'] = $data;
                        $responseArray['message'] = 'Countries List.';
                    } else {
                        $responseArray['success'] = false;
                        $responseArray['data'] = $data;
                        $responseArray['message'] = 'Oops! Nothing found';
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

    public function getStatesByCountry(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), State::$getstatesByCountryValidation);
                if ($validation->fails()) {
                    $responseArray['error'] = $validation->errors();
                    $responseArray['message'] = 'Validation Error';
                } else {
                    $state_name = $request->get('state_name', null);
                    $Country = Country::find($request->country_id);
                    // $statesByCountry      =   State::where('status', 1)->where('country_id', $request->country_id)->orderBy('name', 'asc')->get();
                    // $statesByCountry = State::where('status', 1)->where('country_id', $request->country_id);
                    // if (!empty($state_name)) {
                    //     $statesByCountry->where(function ($query) use ($state_name) {
                    //         $query->where('name', $state_name);
                    //     });
                    // }
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => 'https://api.countrystatecity.in/v1/countries/'.$Country->sortname.'/states',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_HTTPHEADER => array(
                        'X-CSCAPI-KEY: ZHF2QzVYVFlNWVFDamhlS21xUW9KQzhGWU5HZ2hEQUROMlhDVk5LZA=='
                      ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    $statesByCountry = json_decode($response,true);

                    $data = [];
                    if (!empty($statesByCountry)) {
                        foreach ($statesByCountry as $state) {
                            $data['states_by_country'][] = [
                                'id' => $state['id'],
                                'name' => $state['name'],
                                'country_id' => $request->country_id,
                                'status' => 1,
                            ];
                        }

                        $responseArray['success'] = true;
                        $responseArray['data'] = $data;
                        $responseArray['message'] = 'States by Country List.';
                        $responseArray['country'] = $Country;
                    } else {
                        $responseArray['success'] = false;
                        $responseArray['data'] = $data;
                        $responseArray['message'] = 'Oops! Nothing found';
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

    public function homeResourcesYouMayLike(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $product_id = $request->get('_id', null);
                    if (!empty($product_id)) {
                        $product_id = Crypt::decrypt($product_id);
                    }
                    if ($product_id > 0) {

                        $productsQuery = $this->filter_products_query($request);
                        $products = $productsQuery->where([['crc_products.id', '<', $product_id]])
                                ->orderBy('crc_products.id', 'DESC')
                                ->limit($this->itemPerPage)
                                ->get();
                    } else {
                        $productsQuery = $this->filter_products_query($request);
                        $products = $productsQuery->orderBy('crc_products.id', 'DESC')
                                ->limit(8)
                                ->get();
                    }

                    $last_id['last_id'] = '';
                    if ($products->isNotEmpty()) {
                        $userId = 0;
                        if (Auth::check()) {
                            $userId = auth()->user()->id;
                        }

                        foreach ($products as $product) {
                            // $proinfo = User::where('id',$product->user_id)->first();
                            // if($proinfo){

                            // }
                            $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $product->id)->first();
                            $is_favourite = false;
                            $favourite_id = null;
                            if (!empty($checkFavouriteItem)) {
                                $is_favourite = true;
                                $favourite_id = $checkFavouriteItem->id;
                            }
                            $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $product->id)->first();
                            $is_cart = false;
                            $cart_id = null;
                            if (!empty($checkCartItem)) {
                                $is_cart = true;
                                $cart_id = $checkCartItem->id;
                            }
                            $avgRating = Web::getProductRating($product->id);

                            //check if sale is going for product
                            $responsearray = Web::getsingleprice($product->id,$product->user_id,$product->single_license,0);
                            $price = $responsearray['price'];
                            $is_sale = $responsearray['is_sale'];


                            $data[] = [
                                '_id' => Crypt::encrypt($product->id),
                                'prodid' => $product->id,
                                'product_title' => $product->product_title,
                                'product_type' => $product->product_type,
                                'product_file' => $product->product_file,
                                'is_paid_or_free' => $product->is_paid_or_free,
                                'single_license' => $price,
                                'actual_single_license' => $product->single_license,
                                'multiple_license' => $product->multiple_license,
                                'main_image' => Storage::disk('s3')->url('products/' . $product->main_image),
                                'description' => $product->description,
                                'rating' => $avgRating,
                                'is_favourite' => $is_favourite,
                                'favourite_id' => $favourite_id,
                                'is_cart' => $is_cart,
                                'cart_id' => $cart_id,
                                'auth_user' => auth()->user() ? true : false,
                                'is_sale' => $is_sale,
                                'productRatingcount' => count(RateReviews::where([['type', '=', 1], ['product_id', '=', $product->id]])->get()),
                                'sellername' => Web::storeDetail(@$product->user_id,'store_name'),
                                'sellerimage' => Web::storeDetail(@$product->user_id,'store_logo'),
                                'sellerurl' => url('/seller-profile/'.str_replace(' ','-',Web::storeDetail(@$product->user_id,'store_name')))
                            ];
                            //$data['last_id']           = $product->id;
                            $last_id['last_id'] = Crypt::encrypt($product->id);
                        
                        }
                        
                        $responseArray['success'] = true;
                        $responseArray['data'] = $data;
                        $responseArray['last_id'] = $last_id['last_id'];
                        $responseArray['message'] = 'Products list resources you may like fetched.';
                    } else {
                        $responseArray['success'] = true;
                        $responseArray['data'] = [];
                        $responseArray['last_id'] = $last_id['last_id'];
                        $responseArray['message'] = 'Products list resources you may like not found.';
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

    public function getProductFilterSearchPaginate(Request $request) {//return $request->toArray();
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    
                    $productsQuery = $this->filter_products_query($request);
                    $productsData = $this->filter_products_pagination_data($request, $productsQuery);
                    return $productsData;
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

    public function filter_products_query($request) {
        $format = $request->get('fs_format', null);
        $price = $request->get('fs_price', null);
        $type = $request->get('fs_type', null);
        $subjectArea = $request->get('fs_subject', null);
        $store_id = $request->get('store_id', null);
        $grade = $request->get('fs_grade', null);
        $language = $request->get('fs_language', null);
        $search_keyword = $request->get('search_keyword', null);
        $sortby = $request->get('sort-by',null);

        ///fs_product_subject
        $productsQuery = Product::with(['productImages'])->leftJoin('users', 'users.id', '=', 'crc_products.user_id')->select('crc_products.*')->where([['crc_products.is_deleted','=', 0],['crc_products.status','=',1]])->where('users.status',1);
        if (!empty($format)) {
            $productsQuery->where(function ($query) use ($format) {
                $query->where('product_type', '=', $format);
            });
        }
        if (!empty($subjectArea)) {
            $productsQuery->where(function ($query) use ($subjectArea) {
                $query->with(['productSubjectSubArea'])->where('subject_area', '=', $subjectArea);
            });
        }
        if (!empty($store_id)) {
            $productsQuery->where(function ($query) use ($store_id) {
                $query->where('store_id', '=', $store_id);
            });
        }
        if (!empty($grade)) {
            $productsQuery->where(function ($query) use ($grade) {
                $query->whereRaw("find_in_set($grade,year_level)")->orwhereRaw("find_in_set(' ".$grade."',year_level)");
            });
        }
        if (!empty($language)) {
            if($language == 1){
                $language = [1,2,3,4];
            }
            $productsQuery->where(function ($query) use ($language) {
                if(is_array($language)){
                    $query->whereIn('language', $language);
                }
                else{
                    $query->where('language','=',$language);
                }
            });
        }
        if (!empty($type)) {
            $productsQuery->where(function ($query) use ($type) {
                $query->where("resource_type", '=', $type);
            });
        }
        if (!empty($search_keyword)) {
            
            $gd = GradeLevels::select(['id'])->where('grade','LIKE','%'.$search_keyword.'%')->pluck('id');
            $v = '';
            if(!is_null($gd)){
                foreach ($gd as $key => $value) {
                   $v = $value;
                }
            }

            //resource type 
            $rt = ResourceTypes::select(['id'])->where('name','LIKE','%'.$search_keyword.'%')->pluck('id');
            $r = '';
            if(!is_null($rt)){
                foreach ($rt as $k => $vt) {
                   $r = $vt;
                }
            }

            $productsQuery->where(function ($query) use ($search_keyword,$v,$r) {
                $query->where("product_title", 'LIKE', '%' . $search_keyword . '%')->orWhere("custom_category", 'LIKE', '%' . $search_keyword . '%')->orWhere("product_type", 'LIKE', '%' . $search_keyword . '%')->orwhereHas("productSubjectArea",function($q) use($search_keyword){
                    $q->where('name','LIKE','%'.$search_keyword.'%');
                })->with('productSubjectArea')->orwhereHas("searchproductSubjectSubArea",function($q) use($search_keyword){
                    $q->where('name','LIKE','%'.$search_keyword.'%');
                })->with('searchproductSubjectSubArea')->orwhereHas("searchproductSubjectSubSubArea",function($q) use($search_keyword){
                    $q->where('name','LIKE','%'.$search_keyword.'%');
                })->with('productstore')->orwhereHas("productstore",function($q) use($search_keyword){
                    $q->where('store_name','LIKE','%'.$search_keyword.'%');
                })->with('searchproductSubjectSubSubArea')->orwhereHas("productlanguage",function($q) use($search_keyword){
                    $q->where('language','LIKE','%'.$search_keyword.'%');
                })->with('productlanguage')->orwhereRaw("find_in_set(' ".$v."',year_level)")->orwhereRaw("find_in_set('".$v."',year_level)")->orwhereRaw("find_in_set('".$r."',resource_type)")->orwhereRaw("find_in_set(' ".$r."',resource_type)");
            });
        }
        if (!empty($price)) {
            switch ($price):
                case 'free':
                    $productsQuery->where(function ($query) {
                        $query->where("is_paid_or_free", '=', 'free');
                    });
                    break;
                case 'less_than_5':
                    $productsQuery->where(function ($query) {
                        $query->where("is_paid_or_free", '=', 'paid');
                        $query->where("single_license", '>=', 0);
                        $query->where("single_license", '<=', 5);
                    });
                    break;
                case '5_10':
                    $productsQuery->where(function ($query) {
                        $query->where("is_paid_or_free", '=', 'paid');
                        $query->where("single_license", '>=', 5);
                        $query->where("single_license", '<=', 10);
                    });
                    break;
                case 'greater_than_10':
                    $productsQuery->where(function ($query) {
                        $query->where("is_paid_or_free", '=', 'paid');
                        $query->where("single_license", '>=', 10);
                        //$query->where("multiple_license", '<', 5);
                    });
                    break;
                case 'on_sale':
                    $hsalec = hostsale::get();
                    $prod_arr = array();
                    if(count($hsalec) > 0){
                        foreach ($hsalec as $key => $value) {
                            if( strtotime(date('Y-m-d')) >= strtotime($value->start_date) && strtotime(date('Y-m-d')) <= strtotime($value->end_date) ){
                                if($value->products == 'Entire Store'){
                                    $pr = Product::select(['id'])->where([['is_deleted','=', 0],['status','=',1],['user_id','=',$value->user_id],["is_paid_or_free", '=', 'paid']])->get();
                                    if(count($pr)){
                                        foreach($pr as $t){
                                            $prod_arr[] = $t->id;
                                        }
                                    } 
                                }
                                else
                                {
                                    $sale_prods = explode(',', $value->products);
                                    foreach($sale_prods as $pr){
                                        $prod_arr[] = $pr;
                                    }
                                }
                                  
                            }
                        }
                    }
                    $productsQuery->whereIn('crc_products.id',$prod_arr);
                    break;
            endswitch;
        }

        if(!empty($sortby)){
            switch ($sortby):
                case 'h2l':
                    return $productsQuery->orderBy('single_license','DESC');
                    break;
                case 'l2h':
                    return $productsQuery->orderBy('single_license','ASC');
                    break;
                case 'rating':
                    return $productsQuery->withCount(['ratings as average_rating' => function   ($query)  {
                                $query->select(DB::raw('coalesce(avg(rating),0)'));
                            }])->orderByDesc('average_rating');
                    break;
                case 'recent':
                    return $productsQuery->orderBy('id','DESC');
                    break;

                case 'best-seller':
                    return $productsQuery->withCount(['orders as average' => function   ($query)  {
                                $query->select(DB::raw('coalesce(avg(quantity),0)'));
                            }])->orderByDesc('average');
                    break;
            endswitch;
        }
        return $productsQuery;
    }

    public function filter_products_pagination_data($request, $productsQuery) {
        $per_page = $request->get('per_page', $this->itemPerPage);
        //        $per_page           =   4;
        $products = $productsQuery->paginate($per_page);
        $products->getCollection()->transform([$this, 'filter_product_data']);
        return $products;
    }

    public function filter_product_data($product) {
        $userId = 0;
        if (Auth::check()) {
            $userId = auth()->user()->id;
        }
        $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $product->id)->first();
        $is_favourite = false;
        $favourite_id = null;
        if (!empty($checkFavouriteItem)) {
            $is_favourite = true;
            $favourite_id = $checkFavouriteItem->id;
        }
        $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $product->id)->first();
        $is_cart = false;
        $cart_id = null;
        if (!empty($checkCartItem)) {
            $is_cart = true;
            $cart_id = $checkCartItem->id;
        }
        $last_id['last_id'] = 0;
        $avgRating = Web::getProductRating($product->id);

        $price = $product->single_license;
        $is_sale = 0;
        //check if sale is going for product
        $responsearray = Web::getsingleprice($product->id,$product->user_id,$product->single_license,0);
        $price = $responsearray['price'];
        $is_sale = $responsearray['is_sale'];

        $data = [
            '_id' => Crypt::encrypt($product->id),
            'prod_id' =>$product->id,
            'product_title' => $product->product_title,
            'product_type' => $product->product_type,
            'product_file' => $product->product_file,
            'single_license' => $price,
            'actual_single_license' => $product->single_license,
            'multiple_license' => $product->multiple_license,
            'is_paid_or_free' => $product->is_paid_or_free,
            'main_image' => Storage::disk('s3')->url('products/' . $product->main_image),
            'description' => $product->description,
            'is_favourite' => $is_favourite,
            'favourite_id' => $favourite_id,
            'is_cart' => $is_cart,
            'cart_id' => $cart_id,
            'auth_user' => auth()->user() ? true : false,
            'rating' => $avgRating,
            'is_sale' => $is_sale,
            'productRatingcount' => count(RateReviews::where([['type', '=', 1], ['product_id', '=', $product->id]])->get()),
            'sellername' => Web::storeDetail(@$product->user_id,'store_name'),
            'sellerimage' => Web::storeDetail(@$product->user_id,'store_logo'),
            'sellerurl' => url('/seller-profile/'.str_replace(' ','-',Web::storeDetail(@$product->user_id,'store_name')))
        ];
        $last_id['last_id'] = Crypt::encrypt($product->id);
        return array_merge($data, $last_id);
    }

    public function productDescription(Request $request, $id) {
        $data = [];
        $data['title'] = 'Product Description Page';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Product Description Page';
        $data['breadcrumb2'] = false;
        $data['breadcrumb3'] = false;

        $product_id = Crypt::decrypt($id);
        $_id = $id;

        $product = Product::where('id', $product_id)->first();
        $total_ques = Questions::where('product_id', $product_id)->where('type',0)->orderBy('created_at','desc')->count();
        $questions = Questions::where('product_id', $product_id)->where('type',0)->orderBy('created_at','desc')->skip(0)->take(10)->get();
        foreach ($questions as $key => $que) {
            # code...
            $answers = Questions::where('product_id', $product_id)->where('parent_id',$que->id)->get();
            $questions[$key]->answers =  $answers;
            $questions[$key]->answered = false;
            if($answers->isNotEmpty()){
                $questions[$key]->answered = true;
            }
        }

        $product->product_file = ($product->product_file != '' && $product->product_file != null) ? url('storage/uploads/products/' . $product->product_file) : '';
        $productSeller = User::where('id', $product->user_id)->first();
        $productSeller->total_product_count = Web::getTotalProductCount(@$product->user_id);
        $productSeller->store_image = Web::storeDetail(@$product->user_id,'store_logo');
        $productSeller->store_name = Web::storeDetail(@$product->user_id,'store_name');
        
        $productImages = ProductImage::where('product_id', $product_id)->orderby('id','DESC')->take(3)->get();
        //Wish List && Cart:
        $userId = 0;
        if (Auth::check()) {
            $userId = auth()->user()->id;
        }

        $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $product->id)->first();
        $is_favourite = false;
        $favourite_id = null;
        if (!empty($checkFavouriteItem)) {
            $is_favourite = true;
            $favourite_id = $checkFavouriteItem->id;
        }
        $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $product->id)->first();
        $is_cart = false;
        $cart_id = null;
        if (!empty($checkCartItem)) {
            $is_cart = true;
            $cart_id = $checkCartItem->id;
        }
        //check follower or not
        $checkFollowedOrNot = Follower::where('followed_to', $product->user_id)->where('followed_by', $userId)->first();
        $followed = ($checkFollowedOrNot != null) ? true : false;
        //get follower count
        $followerCount = Follower::where('followed_to', $product->user_id)->count();
        $followerCount = Web::thousandsCurrencyFormat($followerCount);
        //get rating of product
        $productRating = Web::getProductRating($product->id);
        $productRatingcount = count(RateReviews::where([['type', '=', 1], ['product_id', '=', $product->id]])->get());
        //get reviews
        $reviews = Web::getProductReviews($product->id);
        //get grade levels
        $gradeLevelArr = [];
        $gradeLevel = GradeLevels::whereIn('id', explode(', ', $product->year_level))->get();
        foreach ($gradeLevel as $grade) {
            $gradeLevelArr[] = $grade['grade'];
        }
        $product->gradeLevelStr = implode(',', $gradeLevelArr);
        //get subject area
        $subjectArea = SubjectDetails::where('id', $product->subject_area)->first();
        $product->subjectAreaStr = ($subjectArea != null) ? $subjectArea->name : 'N/A';
         
        //get resource type
        $resourceTypeArr = [];
        $resourceType = ResourceTypes::whereIn('id', explode(',',$product->resource_type))->get();
        foreach ($resourceType as $r) {
            $resourceTypeArr[] = $r['name'];
        }
        $product->resourceTypeStr = implode(',', $resourceTypeArr);
        $product->auth_user = auth()->user() ? true : false;

        //Get related products
        $reldata =  array();
        $relproducts = Product::where([['user_id', '=', $product->user_id],['status','=',1],['is_deleted','=',0]])
                                ->whereNot('id',$product_id)
                                ->orderBy('id', 'DESC')
                                ->limit(4)
                                ->get();
        foreach ($relproducts as $pr) {
            $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $pr->id)->first();
            $is_rel_favourite = false;
            $favourite_rel_id = null;
            if (!empty($checkFavouriteItem)) {
                $is_rel_favourite = true;
                $favourite_rel_id = $checkFavouriteItem->id;
            }
            $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $pr->id)->first();
            $is_rel_cart = false;
            $cart_rel_id = null;
            if (!empty($checkCartItem)) {
                $is_rel_cart = true;
                $cart_rel_id = $checkCartItem->id;
            }
            $avgRating = Web::getProductRating($pr->id);
        
            //check if sale is going for product
            $responsearray = Web::getsingleprice($pr->id,$pr->user_id,$pr->single_license,0);
            $price = $responsearray['price'];
            $is_sale = $responsearray['is_sale'];
            

            $reldata[] = [
                '_id' => Crypt::encrypt($pr->id),
                'product_title' => $pr->product_title,
                'product_type' => $pr->product_type,
                'product_file' => $pr->product_file,
                'is_paid_or_free' => $pr->is_paid_or_free,
                'single_license' => $price,
                'actual_single_license' => $pr->single_license,
                'multiple_license' => $pr->multiple_license,
                'main_image' => Storage::disk('s3')->url('products/' . $pr->main_image),
                'description' => $pr->description,
                'rating' => $avgRating,
                'is_favourite' => $is_rel_favourite,
                'favourite_id' => $favourite_rel_id,
                'is_cart' => $is_rel_cart,
                'cart_id' => $cart_rel_id,
                'auth_user' => auth()->user() ? true : false,
                'is_sale' => $is_sale,
                'productRatingcount' => count(RateReviews::where([['type', '=', 1], ['product_id', '=', $pr->id]])->get()),
                'sellername' => Web::storeDetail(@$pr->user_id,'store_name'),
                'sellerimage' => Web::storeDetail(@$pr->user_id,'store_logo'),
            ];
            //$data['last_id']           = $product->id;
        }

        return view('product_description', compact('data', 'product', 'productSeller', 'productImages', 'is_favourite', 'favourite_id', 'is_cart', 'cart_id', '_id', 'followed', 'followerCount', 'productRating', 'reviews' ,'reldata','questions','total_ques','productRatingcount'));
    }

    /** + 
     * used to get seller details
     * @param type $token - (base64_encode) encrypted value of user id
     * @return type
     */
    public function getAdminRelativeDetails($token) {
        $data = [];
        $data['title'] = 'Contribution';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'User';
        $user_id = base64_decode($token);
        $data['userDetails'] = User::where('id', $user_id)->where('role_id', 2)->first();
        return view('store.seller_details_for_verify', compact('data'));
    }

    /** + 
     * used to approve/reject is admin relative request 
     * @param Request $request - request type post
     * @return type
     */
    public function verifyAdminRelative(Request $request) {
        $user_id = $request->user_id;
        $status = $request->status;
        $userDetails = User::where('id', $user_id)->where('role_id', 2)->first();
        $responseArray = ['success' => false, 'message' => ''];
        if ($userDetails == null) {
            $responseArray['success'] = false;
            $responseArray['message'] = "User Not Valid";
        } else {
            User::where('id', $user_id)->update(['is_admin_relative' => $status]);
            $responseArray['success'] = true;
            $email = $userDetails->email;
            if ($status == 2) {
                $emailData = [
                    "first_name" => $userDetails->first_name,
                    "subject" => 'Account Approve',
                    "content" => '',
                    'email' => $email
                ];
                $send_mail = Mail::send('emails/relative_approve_mail', $emailData, function ($message)use ($emailData) {
                            $message->to($emailData['email']);
                            $message->cc('admin@classroomcopy.com');
                            $message->subject($emailData['subject']);
                        });
                $responseArray['message'] = "Request approved successfully";
            } else {
                $emailData = [
                    "first_name" => $userDetails->first_name,
                    "subject" => 'Account Reject',
                    "content" => '',
                    'email' => $email
                ];
                $send_mail = Mail::send('emails/relative_reject_mail', $emailData, function ($message)use ($emailData) {
                            $message->to($emailData['email']);
                            $message->cc('admin@classroomcopy.com');
                            $message->subject($emailData['subject']);
                        });
                $responseArray['message'] = "Request rejected successfully";
            }
        }
        return response()->json($responseArray, 200);
    }
    
    public function getTopsellerproducts(Request $request){

        $product_ids_string = $request->get('_id', null);
        $product_ids = array();
        $products = array();
        if (!empty($product_ids_string)) {
            $prod_arr = explode(',', $product_ids_string);
            foreach($prod_arr as $pro){
                $product_ids[] = Crypt::decrypt($pro);
            }
        }
        if(count($product_ids) < 8 ){
            if (!empty($product_ids)) {
                $products = Product::leftJoin('crc_order_items','crc_order_items.product_id','=','crc_products.id')
                           ->leftJoin('users','users.id','=','crc_products.user_id')
                           ->select('crc_products.id','crc_products.user_id','crc_products.product_title','crc_products.product_type','crc_products.product_file','crc_products.is_paid_or_free','crc_products.single_license','crc_products.multiple_license','crc_products.main_image','crc_products.description',
                                DB::raw('SUM(crc_order_items.quantity) as total'))->whereNotin('crc_products.id',$product_ids)->where([['crc_products.is_deleted','=',0],['crc_products.status','=',1],['crc_order_items.quantity','>',0],['users.status','=',1]])
                           ->groupBy('crc_products.id','crc_products.user_id','crc_products.product_title','crc_products.product_type','crc_products.product_file','crc_products.is_paid_or_free','crc_products.single_license','crc_products.multiple_license','crc_products.main_image','crc_products.description')
                           ->orderBy('total','desc')
                           ->limit(8)
                           ->get();
            } else {
                $products = Product::leftJoin('crc_order_items','crc_order_items.product_id','=','crc_products.id')
                            ->leftJoin('users','users.id','=','crc_products.user_id')
                           ->select('crc_products.id','crc_products.user_id','crc_products.product_title','crc_products.product_type','crc_products.product_file','crc_products.is_paid_or_free','crc_products.single_license','crc_products.multiple_license','crc_products.main_image','crc_products.description',
                                DB::raw('SUM(crc_order_items.quantity) as total'))->where([['crc_products.is_deleted','=',0],['crc_products.status','=',1],['crc_order_items.quantity','>',0],['users.status','=',1]])
                           ->groupBy('crc_products.id','crc_products.user_id','crc_products.product_title','crc_products.product_type','crc_products.product_file','crc_products.is_paid_or_free','crc_products.single_license','crc_products.multiple_license','crc_products.main_image','crc_products.description')
                           ->orderBy('total','desc')
                           ->limit(8)
                           ->get();
            }   
        }
        
        $userId = 0;
        if (Auth::check()) {
            $userId = auth()->user()->id;
        }
        $last_id = array();
        if (count($products) > 0) {
            foreach ($products as $product) {
                $checkFavouriteItem = FavouriteItem::where('user_id', $userId)->where('product_id', $product->id)->first();
                $is_favourite = false;
                $favourite_id = null;
                if (!empty($checkFavouriteItem)) {
                    $is_favourite = true;
                    $favourite_id = $checkFavouriteItem->id;
                }
                $checkCartItem = CartItem::where('user_id', $userId)->where('product_id', $product->id)->first();
                $is_cart = false;
                $cart_id = null;
                if (!empty($checkCartItem)) {
                    $is_cart = true;
                    $cart_id = $checkCartItem->id;
                }
                $avgRating = Web::getProductRating($product->id);

                $price = $product->single_license;
                //check if sale is going for product
                $responsearray = Web::getsingleprice($product->id,$product->user_id,$product->single_license,0);
                $price = $responsearray['price'];
                $is_sale = $responsearray['is_sale'];

                $data[] = [
                    '_id' => Crypt::encrypt($product->id),
                    'product_title' => $product->product_title,
                    'product_type' => $product->product_type,
                    'product_file' => $product->product_file,
                    'is_paid_or_free' => $product->is_paid_or_free,
                    'single_license' => $price,
                    'actual_single_license' => $product->single_license,
                    'multiple_license' => $product->multiple_license,
                    'main_image' => Storage::disk('s3')->url('products/' . $product->main_image),
                    'description' => $product->description,
                    'rating' => $avgRating,
                    'is_favourite' => $is_favourite,
                    'favourite_id' => $favourite_id,
                    'is_cart' => $is_cart,
                    'cart_id' => $cart_id,
                    'prodid'  => $product->id,
                    'auth_user' => auth()->user() ? true : false,
                    'is_sale'   => $is_sale,
                    'productRatingcount' => count(RateReviews::where([['type', '=', 1], ['product_id', '=', $product->id]])->get()),
                    'sellername' => Web::storeDetail(@$product->user_id,'store_name'),
                    'sellerimage' => Web::storeDetail(@$product->user_id,'store_logo'),
                    'sellerurl' => url('/seller-profile/'.str_replace(' ','-',Web::storeDetail(@$product->user_id,'store_name'))),
                ];
                $last_id[] = Crypt::encrypt($product->id);
            }
            if(!empty($product_ids)){
                foreach ($product_ids as $pid) {
                    $last_id[] = Crypt::encrypt($pid);
                }
            }
            $responseArray['success'] = true;
            $responseArray['data'] = $data;
            $responseArray['last_id'] = $last_id;
            $responseArray['message'] = 'Products list top sellers fetched.';
        }else{
            $responseArray['success'] = true;
            $responseArray['data'] = [];
            $responseArray['last_id'] = $last_id;
            $responseArray['message'] = 'Products list resources you may like not found.';
        }       
        return response()->json($responseArray, 201);
    }

    public function executejobs(){
        Artisan::call('queue:work --stop-when-empty', []);
    }

    public function giftinaccount(){
        $data = [];
        $data['title'] = 'Gift Cards';
        $data['home'] = 'Home';
        $data['is_store_added'] = 0;
        $data['breadcrumb1'] = 'Account Dashboard';
        $data['breadcrumb1_link'] = route('account.dashboard');
        $data['cards'] = GiftCards::with(['orders'])->where('recipient_user_id', auth()->user()->id)->get();
        $data['breadcrumb2'] = 'Gift Cards';
        return view('account.account_gift_in_account', compact('data'));
    }


    //Single author infos
    public function getsingleauthorInfo($id){
        try{
            $storename = str_replace('-',' ',$id);
            $storinfo = Store::where('store_name',$storename)->first();
            $user = User::find($storinfo->user_id);
            if ($user->process_completion != 3) {
                return Redirect::to(route('classroom.index'));
            } else {
                $user_id = $storinfo->user_id;
                $data = [];
                $data['title'] = 'Store Products';
                $data['home'] = 'Home';
                $data['breadcrumb1'] = 'Products';
                $data['breadcrumb2'] = false;
                $storeRes = Store::where('user_id', $user_id)->first();
                $data['store_result'] = $storeRes;
                // $data['breadcrumb1'] = $storeRes->store_name;
                $allreview = Web::getSellerProductsReviews($user_id);
                foreach ($allreview as $key => $value) {
                    # code...
                    //echo $value->seller_user_id;
                    $user1 = User::find($value->user_id);
                    $reply = ReviewReply::where('review_id',$value->id)->first();
                    $allreview[$key]->reply = false;
                    $allreview[$key]->reply_text = "";
                    if(!empty($reply)){
                        $allreview[$key]->reply_text = $reply->reply;
                        $allreview[$key]->reply = true;
                    }
                    $allreview[$key]->reviewer_user_name = @$user1->first_name." ".substr(@$user1->surname,0,1).'.';
                    if($user->default_image == 0 ){
                        $allreview[$key]->reviewer_user_image = url('storage/uploads/profile_picture/'.$user->image);
                    }else{
                        $allreview[$key]->reviewer_user_image = asset('images/book-img.png');
                    }
                }
                return view('store_user_info', compact('data','allreview','user_id','user'));
            }
        }catch(Exception $e){
            return redirect()->route('classroom.index');
        }
        
    }

    public function addQuestion(Request $request){
        try{
            if (Auth::user()){
                $msg = "Question Added Successfully";
                $data = $request->all();
                $action = isset($request->action)?$request->action:"add";
                if($action == "edit"){
                    $question = Questions::find($request->question_id);;
                    $question->question = $request->answer;
                    $question->save();
                }else{
                    if($request->type == "seller"){
                        $question = Questions::find($request->question_id);;
                        $answer = $question->replicate();
                        $answer->sender_id = $question->receiver_id;//auth()->user()->id;
                        $answer->receiver_id = $question->sender_id;
                        $answer->question = $request->answer;
                        $answer->parent_id = $request->question_id;
                        $answer->type = "1";
                        $answer->created_at = Carbon::now();
                        $answer->save();
                        $msg = "Anser Added Successfully";
                        $user_image = (new \App\Http\Helper\Web)->userDetail(@$answer->sender_id,'image');
                        $first_name = (new \App\Http\Helper\Web)->userDetail(@$answer->sender_id,'first_name');
                        $surname = (new \App\Http\Helper\Web)->userDetail(@$answer->sender_id,'surname');
                        $answer->user_image = $user_image;
                        $answer->username = $first_name." ".$surname;
                        $question->date = date('F d, Y',strtotime($answer->created_at));
                        $data = $answer;
                        if($question->notify == 1){
                            $user_notify = User::find($question->sender_id);
                            $notify_name = $user_notify->first_name;
                            $notify_email = $user_notify->email;
                            $store_name = (new \App\Http\Helper\Web)->storeDetail(@$answer->sender_id,'store_name');
                            $maildata = [
                                "user_name"     => ucfirst($notify_name),
                                "user_email"    => $notify_email,
                                'store_name'    => $store_name,
                                'store_url'     => url('/seller-profile/'.str_replace(' ','-',$store_name)), 
                                'answer'        => $request->answer,
                            ];
                            
                            \Mail::send('emails/quetion_answer_notify', $maildata, function($message) use($notify_email,$notify_name){
                                $message->cc('admin@classroomcopy.com');
                                $message->to($notify_email, $notify_name)
                                    ->subject("Replied Your Question");
                            });
                        }
                    }else{
                        $product_id = $product_id = Crypt::decrypt($request->productid);;
                        $sender_id = Auth::user()->id; // login user
                        $receiver_id = $request->selletid; // seller user
                        $user_question = $request->question;
                        $type = ($request->type == "seller")?1:0;
                        $notify = $request->notify;
                        $question = new Questions();
                        //$question->sender_id->parent_id
                        $question->sender_id = $sender_id;
                        $question->receiver_id = $receiver_id;
                        $question->product_id = $product_id;
                        $question->question = $user_question;
                        $question->notify =$notify;
                        $question->type = $type;

                        $question->save();

                        $user_image = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'image');
                        $first_name = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'first_name');
                        $surname = (new \App\Http\Helper\Web)->userDetail(@$question->sender_id,'surname');
                        $question->user_image = $user_image;
                        $question->username = $first_name." ".$surname;
                        $question->date = date('F d, Y',strtotime($question->created_at));
                        $data = $question;

                        $notify_email = (new \App\Http\Helper\Web)->userDetail(@$question->receiver_id,'email');
                        $notify_name = (new \App\Http\Helper\Web)->userDetail(@$question->receiver_id,'first_name').' '.(new \App\Http\Helper\Web)->userDetail(@$question->receiver_id,'surname');
                        $maildata = [
                            "user_name"     => ucfirst($notify_name),
                            "user_email"    => $notify_email, 
                            'question'      => $user_question,
                        ];
                        
                        \Mail::send('emails/question_received_seller', $maildata, function($message) use($notify_email,$notify_name){
                            $message->cc('admin@classroomcopy.com');
                            $message->to($notify_email, $notify_name)
                                ->subject("Question received");
                        });
                    }
                }
                
                $responseArray = ['success' => true, 'message' => $msg];
                $responseArray['data'] = $data;
                return response()->json($responseArray, 200);
            }else{

                $msg = "Something went wrong! Unauthorized";
                $responseArray = ['success' => true, 'message' => $msg];
                $responseArray['data'] = $request->all();
                return response()->json($responseArray, 200);
            }

        }catch (Exception $ex){
            //dd($ex);
            $responseArray = ['success' => false];
            $responseArray['data'] = $ex;
            $responseArray['message'] = $ex->getMessage();
            return response()->json($responseArray, 201);
        }
    }

    public function loadMore(Request $request){
        try{
            $product_id = Crypt::decrypt($request->productid);
            $take = $request->take;
            $skip = $request->skip;
            $questions = Questions::where('product_id', $product_id)->where('type',0)->orderBy('created_at','desc')->skip($skip)->take($take)->get();
            foreach ($questions as $key => $que) {
                # code...
                $user_image = (new \App\Http\Helper\Web)->userDetail(@$que->sender_id,'image');
                $first_name = (new \App\Http\Helper\Web)->userDetail(@$que->sender_id,'first_name');
                $surname = (new \App\Http\Helper\Web)->userDetail(@$que->sender_id,'surname');
                $questions[$key]->user_image = $user_image;
                $questions[$key]->username = $first_name." ".$surname;
                $questions[$key]->date = date('F d, Y',strtotime($que->created_at));

                $answers = Questions::where('product_id', $product_id)->where('parent_id',$que->id)->get();
                $questions[$key]->answers =  $answers;
                $questions[$key]->answered = false;
                if($answers->isNotEmpty()){
                    $questions[$key]->answered = true;
                }
            }
            // return response()->json([
            //     'html' => view($view_name)->render()
            // ]);
            //return view('load_more_quesctions', compact('questions'));
            $msg = "Question Added Successfully";

            $responseArray = ['success' => true, 'message' => $msg];
            $responseArray['data'] = $questions;
            $responseArray['html'] = view('load_more_quesctions',compact('questions'))->render();

            return response()->json($responseArray, 200);

        }catch (Exception $ex){
            dd($ex);
            $responseArray = ['success' => false];
            $responseArray['data'] = $ex;
            $responseArray['message'] = $ex->getMessage();
            return response()->json($responseArray, 201);
        }
    }

    public function accountMyInboxLoadMore(Request $request){
        try{
            $user = auth()->user();
            //$product_id = Crypt::decrypt($request->productid);
            $responseArray['html'] = '';
            $take = $request->take;
            $skip = $request->skip;
            $type = $request->type;
            if(isset($request->type) && @$type == "received"){
                $receiver_answer = Questions::where('sender_id',$user->id)->where('type',0)->orderBy('created_at','desc')->take($take)->skip($skip)->get();
        
                foreach ($receiver_answer as $key => $value) {
                    # code...
                    $user_image = (new \App\Http\Helper\Web)->userDetail(@$value->sender_id,'image');
                    $first_name = (new \App\Http\Helper\Web)->userDetail(@$value->sender_id,'first_name');
                    $surname = (new \App\Http\Helper\Web)->userDetail(@$value->sender_id,'surname');
                    $receiver_answer[$key]->user_image = $user_image;
                    $receiver_answer[$key]->username = $first_name." ".$surname;
                    $receiver_answer[$key]->date = date('F d, Y',strtotime($value->created_at));


                    $answers = Questions::where('receiver_id',$user->id)->where('type',1)->where('parent_id',$value->id)->get();
                    if($answers->isNotEmpty()){
                        $receiver_answer[$key]->answers = $answers; 
                    }else{
                        unset($receiver_answer[$key]);
                    }
                }
                $data = $receiver_answer;
                $html = view('load_more_quesctions_account_my_inbox',compact('receiver_answer','type'))->render();

            }else{
                $sent_questions = Questions::where('sender_id',$user->id)->where('type',0)->orderBy('created_at','desc')->take($take)->skip($skip)->get();
                $data = $sent_questions;
                $html = view('load_more_quesctions_account_my_inbox',compact('sent_questions','type'))->render();

            }

            
            
            //return view('load_more_quesctions_account_my_inbox', compact('sent_questions'));
            $msg = "Question Added Successfully";

            $responseArray = ['success' => true, 'message' => $msg];
            $responseArray['data'] = $data;
            $responseArray['html'] = $html;

            return response()->json($responseArray, 200);

        }catch (Exception $ex){
            dd($ex);
            $responseArray = ['success' => false];
            $responseArray['data'] = $ex;
            $responseArray['message'] = $ex->getMessage();
            return response()->json($responseArray, 201);
        }
    }

    public function storeMyInboxLoadMore(Request $request){
        try{
            $user = auth()->user();
            $userid = auth()->user()->id;
            $userid = ($userid == $request->user_id) ? $userid : $request->user_id;

            //$product_id = Crypt::decrypt($request->productid);
            $responseArray['html'] = '';
            $take = $request->take;
            $skip = $request->skip;
            $type = $request->type;
            $view_more = $request->view_more;
            $count = 0;
            $total_sent_question = 0 ;
            $check = isset($request->from)?$request->from:'';
            if( (isset($request->type) && @$type == "received") || !empty($check)){
                $receiver_answer = Questions::where('receiver_id',$userid)->where('type',0)->orderBy('created_at','desc')->take($take)->skip($skip)->get();
                $total_receiver_answer =  Questions::where('receiver_id',$userid)->where('type',0)->orderBy('created_at','desc')->count();
                foreach ($receiver_answer as $key => $value) {
                    # code...
                    $receiver_answer[$key]->answered = false;
                    $answers = Questions::where('parent_id',$value->id)->where('sender_id',$userid)->where('type',1)->first();
                    if(!empty($answers)){
                        $receiver_answer[$key]->answered = true;
                        $receiver_answer[$key]->answer = $answers;
                    }
                }
                $data = $receiver_answer;//$request->all();
                $type = !empty($check)?'received':$type;
                $html = view('load_more_quesctions_store_my_inbox',compact('receiver_answer','total_receiver_answer','type','check','view_more'))->render();

            }else{

                $sent_questions = Questions::where('sender_id',$userid)->where('type',1)->orderBy('created_at','desc')->take($take)->skip($skip)->get();
                $total_sent_question =  Questions::where('sender_id',$userid)->where('type',1)->orderBy('created_at','desc')->count();
                $count = count($sent_questions);
                foreach ($sent_questions as $key => $value) {
                    # code...
                    $question = Questions::where('receiver_id',$userid)->where('type',0)->where('id',$value->parent_id)->first();
                    $sent_questions[$key]->question1 = $question;
                    
                }
                $data = $sent_questions;
                $html = view('load_more_quesctions_store_my_inbox',compact('sent_questions','type','total_sent_question','view_more'))->render();
                
            }

            
            
            //return view('load_more_quesctions_account_my_inbox', compact('sent_questions'));
            $msg = "Question Added Successfully";

            $responseArray = ['success' => true, 'message' => $msg];
            $responseArray['data'] = $data;
            $responseArray['count'] = $count;
            $responseArray['html'] = $html;

            return response()->json($responseArray, 200);

        }catch (Exception $ex){
            dd($ex);
            $responseArray = ['success' => false];
            $responseArray['data'] = $ex;
            $responseArray['message'] = $ex->getMessage();
            return response()->json($responseArray, 201);
        }
    }

    public function deleteaccount(Request $request,$id){
        if(auth()->user()->id != $id) {
            return redirect()->back()->with('error', 'Unauthorized User');
        }
        else{
            if(auth()->user()->id == $id){
               
                //Delete product if any
                if(auth()->user()->role_id == 2){
                    //Deactive product if any
                    $up = Product::where('user_id',auth()->user()->id)->update(['status'=>0]);
                }
                
                //Update is_deleted
                $update = User::where('id',$request->id)->update(['status'=>0,'is_deleted'=>1]);
                if($update){
                    return redirect()->route('classroom.index')->with('success','Account Deleted Successfully');
                }
            }
            else{
                return redirect()->back()->with('error', 'Unauthorized User');
            }
        }
    }
    public function downloadFile($id)
    {
        if(!empty($id)){
            $productinfo = Product::where('id',Crypt::decrypt($id))->first();
            $tempDir = base_path('public/images');
            $zip = new ZipArchive;
            
            // The name of the ZIP file
            $zipFileName = $tempDir . '/'.str_replace(' ','',$productinfo->product_title).'.zip';
            if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
                $fileNames = Product::whereIn('id',json_decode($productinfo->bundleproducts))->get(); 
                foreach ($fileNames as $fileName) {
                    $contents = Storage::disk('s3')->url('products/' . $fileName->product_file);// Get the file contents from S3
                    $tempFilePath = $tempDir . '/' .  $fileName->product_file;
                    file_put_contents($tempFilePath, $contents); // Save the file locally
                    Log::info("Temp file path: " . $tempFilePath);
                    if (file_exists($tempFilePath)) {
                        $zip->addFile($tempFilePath, basename($fileName->product_file)); // Add the temporary file to the ZIP
                    } else {
                        Log::error("Failed to create temp file for: " . $fileName); // Log an error if the temp file wasn't created
                    }
                }
        
                // Close the zip file
                $zip->close();
        
                // Download the ZIP file
                return response()->download($zipFileName);
            }
        }
        else{
            
        }
    }

    public function deactivateaccount(Request $request,$id){
        if(auth()->user()->id != $request->id) {
            return redirect()->back()->with('error', 'Unauthorized User');
        }
        else{
            if(auth()->user()->id == $request->id){
               
                //Deactive product if any
                $sellerprofile = User::where('role_id',2)->where('email',auth()->user()->email)->first();
                if($sellerprofile){
                    $up = Product::where('user_id',$sellerprofile->id)->update(['status'=>0]);
                }
                
                //Update status
                $update = User::where('email',auth()->user()->email)->update(['status'=>0]);
                if($update){
                    Auth::logout();
                    return redirect()->route('classroom.index')->with('success','Account Deactivated Successfully');
                }
            }
            else{
                return redirect()->back()->with('error', 'Unauthorized User');
            }
        }
    }

    public function storeDashboardremoveselleroffer(Request $request){
        $responseArray = ['success' => false, 'message' => ''];
        $delete = SellerOfferApplied::where('userid',auth()->user()->id)->delete(); 
        if($delete){
            $responseArray['success'] = true;
            $responseArray['message'] = 'Offer Removed';
        }
        else{
            $responseArray['message'] = 'Something went wrong';   
        }
        return response()->json($responseArray, 200);
    }
}
