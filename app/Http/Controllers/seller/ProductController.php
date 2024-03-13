<?php

namespace App\Http\Controllers\seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Product,
    ProductImage,
    Store,
    GradeLevels,
    Follower,
    RateReviews,
    temporaryimages,
    ReviewReply
};
use Illuminate\Support\Facades\{
    Auth,
    Hash,
    DB,
    Mail,
    Storage,
    Redirect,
    Crypt
};
use Symfony\Component\Process\Process;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Session;
use Exception;
use Validator;
use App\Traits\{
    FileProcessing
};
use \App\Http\Helper\ClassroomCopyHelper;
use Illuminate\App\Jobs;
use Artisan;
use \App\Http\Helper\Web;
use Imagick;
use Illuminate\Support\Facades\File; 
use NcJoes\OfficeConverter\OfficeConverter;

class ProductController extends Controller {

    /** + 
     * used to show product dashboard page
     * @return type
     */
    public $itemPerPage = 4;
    public function storeDashProductDashboard() {
        if (auth()->user()->process_completion != 3) {
            return Redirect::to(route('become.a.seller'));
        }
        $data = [];
        $data['title'] = 'Product Dashboard';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Product Dashboard';

        return view('store.product.store_dashboard_product_dashboard', compact('data'));
    }

    /** + 
     * used to show products of seller
     * @param Request $request - request type get
     * @return type
     */
    public function index(Request $request) {
        if (auth()->user()->process_completion != 3) {
            return Redirect::to(route('become.a.seller'));
        }
        $data = [];
        $data['title'] = 'Products';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Product Dashboard';
        $data['breadcrumb2_link'] = route('storeDashboard.productDashboard');
        $data['breadcrumb3'] = 'Products';
        $result = Product::where([['is_deleted', '=', 0], ['user_id', '=', auth()->user()->id]])->get();
        if (count($result) > 0) {
            foreach ($result as $key => $row) {
                $result[$key]['_id'] = Crypt::encrypt($row['id']);
                $result[$key]['main_image'] = url('storage/uploads/products/' . $row['main_image']);
            }
        }
        $data['result'] = $result;
        //dd($data['result']);

        return view('store.product.product_list', compact('data'));
    }

    /** + 
     * used to show rating review list
     * @return type
     */
    public function ratingreviewlist(){
        $data = [];
        $data['title'] = 'Rating / Reviews';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Product Dashboard';
        $data['breadcrumb2_link'] = route('storeDashboard.productDashboard');
        $data['breadcrumb3'] = 'rating/reviews';
        $prodids = [];
        $getprods = Product::where('user_id',auth()->user()->id)->where('is_deleted',0)->where('status',1)->get();
        if(count($getprods) > 0 ){
            foreach($getprods as $prdct){
                $prodids[] = $prdct->id;
            }
        }

        $result = RateReviews::where('type',1)->whereIn('product_id',$prodids)->orderby('created_at','DESC')->get();
        $data['result'] = $result;
        //dd($data['result']);

        return view('store.product.rating_review', compact('data'));
    }

    public function getreviewstorePaginate(Request $request){
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $productsQuery = $this->storeReview_query($request);
                $productsData = $this->storeReview_pagination_data($request, $productsQuery);
                return $productsData;
            } else {
                throw new Exception("Invalid Method");
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $responseArray['message'] = $message;
        }
        return response()->json($responseArray, 201);
    }

    public function storeReview_query($request) {

        $prodids = [];
        $getprods = Product::where('user_id',auth()->user()->id)->where('is_deleted',0)->where('status',1)->get();
        if(count($getprods) > 0 ){
            foreach($getprods as $prdct){
                $prodids[] = $prdct->id;
            }
        }

        $reviewQuery =  RateReviews::where('type',1)->whereIn('product_id',$prodids);

        return $reviewQuery->orderBy('created_at','DESC');
    }

    public function storeReview_pagination_data($request, $productsQuery) {
        $per_page = $request->get('per_page', 10);
        $products = $productsQuery->paginate($per_page);
        $products->getCollection()->transform([$this, 'storeReview_data']);
        return $products;
    }

    public function storeReview_data($product) {

        $imglink = url('images/profile.png');
        if(!is_null($product->user->image)){ 
            if(!empty($product->user->image)){
                $imglink = (new \App\Http\Helper\Web)->userDetail(@$product->user->id,'image');
            }
        }
        $data = [
            'product_link'  => url('/product-description/'.Crypt::encrypt($product->product->id)),
            'product_title' => $product->product->product_title,
            'username' => $product->user->first_name .' '.substr($product->user->surname,0,1).'.',
            'userimg' => $imglink,
            'ratingdate' => date('F d, Y',strtotime($product->updated_at)),
            'rating' => $product->rating,
            'ratingleft' => 5 - $product->rating,
            'review' => $product->review,
        ];
        
        return $data;
    }

    /** + 
     * used to show add product page
     * @return type
     */
    public function storeDashAddProduct() {
        if (auth()->user()->process_completion != 3) {
            return Redirect::to(route('become.a.seller'));
        }
        $data = [];
        $data['title'] = 'Add Product';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Product Dashboard';
        $data['breadcrumb2_link'] = route('storeDashboard.productDashboard');
        $data['breadcrumb3'] = 'Add Product';

        return view('store.product.add_product', compact('data'));
    }

    /** + 
     * used to add product
     * @param Request $request - request type post
     * @return type
     */
    public function addProductPost(Request $request) {
        DB::beginTransaction();
        try {
            $store_id = 0;
            if (auth()->user()->process_completion != 3) {
                return redirect()->back()->with('error', "Please complete payment system to add product")->withInput();
            } else {
                $storeRes = Store::where('user_id', auth()->user()->id)->first();
                $store_id = ($storeRes != null) ? $storeRes->id : 0;
            }
            $validation = Validator::make($request->all(), Product::$addProductValidation, Product::$addProductCustomMessage);
            if ($validation->fails()) {
                setcookie('error', $validation->errors()->first(), time() + (86400 * 30), "/");
               
                return redirect()->back()->with('error', $validation->errors()->first())->withInput();
            }
            //Level:
            //$levelArr = ClassroomCopyHelper::getProductLevel();
            $productFileTypeArr = ClassroomCopyHelper::getProductType();
            foreach ($request->year_level as $yearLevel) {
                $gradeArr = GradeLevels::where('status', 1)->where('id', $yearLevel)->first();
                /* if (!in_array($yearLevel, $levelArr)) {
                  } */
                if ($gradeArr == null) {
                    setcookie('error', 'Selected level invalid.Please select valid level!', time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', 'Selected level invalid.Please select valid level!')->withInput();
                }
            }

            if ($request->hasFile('product_image')) {
                $accepted = array('pg','png','jpeg','gif','tif','tiff','bmp','jpg');
                foreach ($request->file('product_image') as $file) {
                    if (!in_array($file->getClientOriginalExtension(), $accepted)) {
                        setcookie('error', 'Product images must be type of image only', time() + (86400 * 30), "/");
                        return redirect()->back()->with('error', 'Product images must be type of image only')->withInput();
                    }
                }
            }
            //Product file type validation:
            if ($request->hasfile('product_file')) {
                
                $file = $request->file('product_file');
                $fileType = $file->getClientOriginalExtension();
                if ($request->product_type !== $fileType) {
                    setcookie('error', 'Selected file type was invalid!', time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', 'Selected file type was invalid!')->withInput();
                }

                if (!in_array($fileType, $productFileTypeArr)) {
                    setcookie('error', 'Selected file type was invalid!', time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', 'Selected file type was invalid!')->withInput();
                }
            }

            $user = auth()->user();
            $uploaded_image['main_image'] = null;
            $uploaded_image['product_image'] = null;
            $uploaded_image['product_file'] = null;
            
            $save_product_file  = temporaryimages::where('user_id',auth()->user()->id)->where('type',4)->orderby('id','DESC')->first();
            if($save_product_file){
                $old_path = base_path('public/storage/uploads/products/'.$save_product_file->image);
                Storage::disk('s3')->put('products/' . $save_product_file->image, fopen($old_path, 'r+'));
                $uploaded_image['product_file'] = $save_product_file->image;
            }
            elseif($request->hasfile('product_file')) {
                $file = $request->file('product_file');
                $path = 'products';
                $name = str_replace(' ','',$request->product_title) . $user->id . rand(1, 99) . '_product_file' . '.' . $file->getClientOriginalExtension();
                $uploaded_image['product_file'] = $name;
                $fname = $name; 
                $file->storeAs($path, $name, 's3');
            }

            if ($request->hasfile('main_image')) {
                $file = $request->file('main_image');
                $path = 'products';
                $name = time() . date('YmdHis') . $user->id . rand(1, 9999) . '_main-image' . '.' . $file->getClientOriginalExtension();
                $uploaded_image['main_image'] = $name;
                $file->storeAs($path, $name, 's3');
            }elseif($request->thumbnail_choice == 'auto'){
                $auto_generate_main_img  = temporaryimages::where('user_id',auth()->user()->id)->where('type',0)->orderby('id','DESC')->first();
                if($auto_generate_main_img){
                    $old_path = base_path('public/storage/uploads/temporary/'.$auto_generate_main_img->image);
                    Storage::disk('s3')->put('products/' . $auto_generate_main_img->image, fopen($old_path, 'r+'));
                    $uploaded_image['main_image'] = $auto_generate_main_img->image;
                }
            }
            
            $saveData = [
                'user_id' => $user->id,
                'store_id' => $store_id,
                'product_title' => $request->product_title,
                'description' => $request->description,
                'product_type' => $request->product_type,
                'language' => (int) $request->language,
                'resource_type' => implode(',', $request->resource_type),
                'year_level' => implode(', ', $request->year_level),
                'subject_area' => (int) $request->subject_area,
                'subject_sub_area' => $request->subject_sub_area,
                'subject_sub_sub_area' => $request->subject_sub_sub_area,
                'custom_category' => $request->custom_category,
                'outcome_country' => (int) $request->outcome_country,
                'standard_outcome' => $request->standard_outcome,
                'teaching_duration' => $request->teaching_duration,
                'no_of_pages_slides' => $request->no_of_pages_slides ? $request->no_of_pages_slides : '',
                'answer_key' => $request->answer_key ? $request->answer_key : '',
                'is_paid_or_free' => $request->is_paid_or_free,
                'single_license' => $request->single_license ? $request->single_license : 0,
                'multiple_license' => $request->multiple_license ? $request->multiple_license : '',
                'tax_code' => $request->tax_code ? $request->tax_code : '',
                'terms_and_conditions' => ($request->terms_and_conditions == "on") ? 1 : 0,
                'main_image' => $uploaded_image['main_image'],
                'product_file' => $uploaded_image['product_file'],
            ];

            /*
                We will use it when doing thumbnail work
                if (request()->has('pdf')) {
                  $pdfuploaded = request()->file('pdf');
                  $pdfname = $request->book_name . time() . '.' . $pdfuploaded->getClientOriginalExtension();
                  $pdfpath = public_path('/uploads/pdf');
                  $pdfuploaded->move($pdfpath, $pdfname);
                  $book->book_file = '/uploads/pdf/' . $pdfname;
                  $pdf = $book->book_file;

                  $pdfO = new Spatie\PdfToImage\Pdf($pdfpath . '/' . $pdfname);
                  $thumbnailPath = public_path('/uploads/thumbnails');
                  $thumbnail = $pdfO->setPage(1)
                    ->setOutputFormat('png')
                    ->saveImage($thumbnailPath . '/' . 'YourFileName.png');
                  // This is where you save the cover path to your database.
                }
            */

            $productCreate = Product::create($saveData);
            if ($productCreate) {
                if ($request->hasFile('product_image')) {
                    foreach ($request->file('product_image') as $file) {
                        $path = 'products';
                        $name = time() . date('YmdHis') . $user->id . rand(1, 9999) . '_product-image' . '.' . $file->getClientOriginalExtension();
                        $uploaded_image['product_image'] = $name;
                        ProductImage::create(['product_id' => $productCreate->id, 'user_id' => $user->id, 'image' => $uploaded_image['product_image']]);
                        $file->storeAs($path, $name, 's3');
                    }
                }
                elseif($request->thumbnail_choice == 'auto'){
                    $auto_generate_product_images  = temporaryimages::where('user_id',auth()->user()->id)->whereIn('type',[1,2,3])->orderby('id','DESC')->get();
                    if($auto_generate_product_images){
                        foreach ($auto_generate_product_images as $agpi) {
                            $old_path = base_path('public/storage/uploads/temporary/'.$agpi->image);
                            Storage::disk('s3')->put('products/' . $agpi->image, fopen($old_path, 'r+'));
                            $uploaded_image['product_image'] = $agpi->image;
                            ProductImage::create(['product_id' => $productCreate->id, 'user_id' => $user->id, 'image' => $uploaded_image['product_image']]);
                        }
                    } 
                }
                DB::commit();
                $store = Store::where('user_id',$user->id)->first();
                $storename = $store->store_name;
                $storelink = url('/seller-profile/'.base64_encode($user->id.' classroom'));
                $productlink = url('/product-description/'.Crypt::encrypt($productCreate->id));
                //Send email of new product created to buyer
                $mail_data = [
                    'subject' => 'NEW PRODUCT FROM YOUR FAVOURITE SELLER',
                    'data' => '<a href="'.$storelink.'">'.$storename.'</a> just added new product.<br>Why not check it out <a href="'.$productlink.'">now</a>!',
                    'sellerid'=>auth()->user()->id,
                ];
                
                $job = (new \App\Jobs\SendbuyersEmail($mail_data))
                        ->delay(now()->addSeconds(2)); 
                dispatch($job);
                
                //Delete temporary images and file
                $old_enteries = temporaryimages::where('user_id',auth()->user()->id)->get();
                if(count($old_enteries) > 0){
                    foreach($old_enteries as $oldent){
                        if($oldent->type == 4){
                            $files = Storage::files(base_path('public/uploads/products/'));
                            $ar = explode('.',$oldent->image);
                            foreach ($files as $file) {
                                if (strpos($file, $ar[0]) !== false) {
                                    Storage::delete($file);
                                }
                            }
                            //File::delete(base_path('public/storage/uploads/products/'.$oldent->image));
                        }
                        else{
                            File::delete(base_path('public/storage/uploads/temporary/'.$oldent->image));
                        }
                    }
                }
                temporaryimages::where('user_id',auth()->user()->id)->delete();

                //return redirect()->back()->with('success', 'Product Created Successfully.');
                return Redirect::to(route('storeDashboard.productDashboard'))->with('success', 'Product Created Successfully.');
            } else {
                if ($request->hasfile('main_image')) {
                    $path = 'products';
                    Storage::disk('s3')->delete($path . '/' . $uploaded_image['main_image']);
                }
                setcookie('error', 'Error occured while creating product!', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Error occured while creating product!')->withInput();
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            DB::rollBack();
            setcookie('error', $message, time() + (86400 * 30), "/");
            return redirect()->back()->with('error', $message)->withInput();
        }
    }

    public function storeDashAddBundleProduct() {
        if (auth()->user()->process_completion != 3) {
            return Redirect::to(route('become.a.seller'));
        }
        $data = [];
        $data['title'] = 'Add Bundle Product';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Product Dashboard';
        $data['breadcrumb2_link'] = route('storeDashboard.productDashboard');
        $data['breadcrumb3'] = 'Add Bundle Product';

        return view('store.product.add_bundle_product', compact('data'));
    }

    /** + 
     * used to add product
     * @param Request $request - request type post
     * @return type
     */
    public function storeDashAddBundleProductPost(Request $request) {
        DB::beginTransaction();
        try {
            $store_id = 0;
            if (auth()->user()->process_completion != 3) {
                return redirect()->back()->with('error', "Please complete payment system to add product")->withInput();
            } else {
                $storeRes = Store::where('user_id', auth()->user()->id)->first();
                $store_id = ($storeRes != null) ? $storeRes->id : 0;
            }
            $validation = Validator::make($request->all(), Product::$addProductValidation, Product::$addProductCustomMessage);
            if ($validation->fails()) {
                setcookie('error', $validation->errors()->first(), time() + (86400 * 30), "/");
               
                return redirect()->back()->with('error', $validation->errors()->first())->withInput();
            }
            //Level:
            //$levelArr = ClassroomCopyHelper::getProductLevel();
            $productFileTypeArr = ClassroomCopyHelper::getProductType();
            foreach ($request->year_level as $yearLevel) {
                $gradeArr = GradeLevels::where('status', 1)->where('id', $yearLevel)->first();
                /* if (!in_array($yearLevel, $levelArr)) {
                  } */
                if ($gradeArr == null) {
                    setcookie('error', 'Selected level invalid.Please select valid level!', time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', 'Selected level invalid.Please select valid level!')->withInput();
                }
            }

            if ($request->hasFile('product_image')) {
                $accepted = array('pg','png','jpeg','gif','tif','tiff','bmp','jpg');
                foreach ($request->file('product_image') as $file) {
                    if (!in_array($file->getClientOriginalExtension(), $accepted)) {
                        setcookie('error', 'Product images must be type of image only', time() + (86400 * 30), "/");
                        return redirect()->back()->with('error', 'Product images must be type of image only')->withInput();
                    }
                }
            }
            //Product file type validation:
            if ($request->hasfile('product_file')) {
                
                $file = $request->file('product_file');
                $fileType = $file->getClientOriginalExtension();
                if ($request->product_type !== $fileType) {
                    setcookie('error', 'Selected file type was invalid!', time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', 'Selected file type was invalid!')->withInput();
                }

                if (!in_array($fileType, $productFileTypeArr)) {
                    setcookie('error', 'Selected file type was invalid!', time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', 'Selected file type was invalid!')->withInput();
                }
            }

            $user = auth()->user();
            $uploaded_image['main_image'] = null;
            $uploaded_image['product_image'] = null;
            $uploaded_image['product_file'] = null;
            
            $save_product_file  = temporaryimages::where('user_id',auth()->user()->id)->where('type',4)->orderby('id','DESC')->first();
            if($save_product_file){
                $old_path = base_path('public/storage/uploads/products/'.$save_product_file->image);
                Storage::disk('s3')->put('products/' . $save_product_file->image, fopen($old_path, 'r+'));
                $uploaded_image['product_file'] = $save_product_file->image;
            }
            elseif($request->hasfile('product_file')) {
                $file = $request->file('product_file');
                $path = 'products';
                $name = str_replace(' ','',$request->product_title) . $user->id . rand(1, 99) . '_product_file' . '.' . $file->getClientOriginalExtension();
                $uploaded_image['product_file'] = $name;
                $fname = $name; 
                $file->storeAs($path, $name, 's3');
            }

            if ($request->hasfile('main_image')) {
                $file = $request->file('main_image');
                $path = 'products';
                $name = time() . date('YmdHis') . $user->id . rand(1, 9999) . '_main-image' . '.' . $file->getClientOriginalExtension();
                $uploaded_image['main_image'] = $name;
                $file->storeAs($path, $name, 's3');
            }elseif($request->thumbnail_choice == 'auto'){
                $auto_generate_main_img  = temporaryimages::where('user_id',auth()->user()->id)->where('type',0)->orderby('id','DESC')->first();
                if($auto_generate_main_img){
                    $old_path = base_path('public/storage/uploads/temporary/'.$auto_generate_main_img->image);
                    Storage::disk('s3')->put('products/' . $auto_generate_main_img->image, fopen($old_path, 'r+'));
                    $uploaded_image['main_image'] = $auto_generate_main_img->image;
                }
            }
            
            $saveData = [
                'user_id' => $user->id,
                'store_id' => $store_id,
                'product_title' => $request->product_title,
                'description' => $request->description,
                'product_type' => $request->product_type,
                'language' => (int) $request->language,
                'resource_type' => implode(',', $request->resource_type),
                'year_level' => implode(', ', $request->year_level),
                'subject_area' => (int) $request->subject_area,
                'subject_sub_area' => $request->subject_sub_area,
                'subject_sub_sub_area' => $request->subject_sub_sub_area,
                'custom_category' => $request->custom_category,
                'outcome_country' => (int) $request->outcome_country,
                'standard_outcome' => $request->standard_outcome,
                'teaching_duration' => $request->teaching_duration,
                'no_of_pages_slides' => $request->no_of_pages_slides ? $request->no_of_pages_slides : '',
                'answer_key' => $request->answer_key ? $request->answer_key : '',
                'is_paid_or_free' => $request->is_paid_or_free,
                'single_license' => $request->single_license ? $request->single_license : 0,
                'multiple_license' => $request->multiple_license ? $request->multiple_license : '',
                'tax_code' => $request->tax_code ? $request->tax_code : '',
                'terms_and_conditions' => ($request->terms_and_conditions == "on") ? 1 : 0,
                'main_image' => $uploaded_image['main_image'],
                'product_file' => $uploaded_image['product_file'],
                'type'=>'bundle',
                'bundleproducts'=>json_encode($request->products),
            ];

            /*
                We will use it when doing thumbnail work
                if (request()->has('pdf')) {
                  $pdfuploaded = request()->file('pdf');
                  $pdfname = $request->book_name . time() . '.' . $pdfuploaded->getClientOriginalExtension();
                  $pdfpath = public_path('/uploads/pdf');
                  $pdfuploaded->move($pdfpath, $pdfname);
                  $book->book_file = '/uploads/pdf/' . $pdfname;
                  $pdf = $book->book_file;

                  $pdfO = new Spatie\PdfToImage\Pdf($pdfpath . '/' . $pdfname);
                  $thumbnailPath = public_path('/uploads/thumbnails');
                  $thumbnail = $pdfO->setPage(1)
                    ->setOutputFormat('png')
                    ->saveImage($thumbnailPath . '/' . 'YourFileName.png');
                  // This is where you save the cover path to your database.
                }
            */

            $productCreate = Product::create($saveData);
            if ($productCreate) {
                if ($request->hasFile('product_image')) {
                    foreach ($request->file('product_image') as $file) {
                        $path = 'products';
                        $name = time() . date('YmdHis') . $user->id . rand(1, 9999) . '_product-image' . '.' . $file->getClientOriginalExtension();
                        $uploaded_image['product_image'] = $name;
                        ProductImage::create(['product_id' => $productCreate->id, 'user_id' => $user->id, 'image' => $uploaded_image['product_image']]);
                        $file->storeAs($path, $name, 's3');
                    }
                }
                elseif($request->thumbnail_choice == 'auto'){
                    $auto_generate_product_images  = temporaryimages::where('user_id',auth()->user()->id)->whereIn('type',[1,2,3])->orderby('id','DESC')->get();
                    if($auto_generate_product_images){
                        foreach ($auto_generate_product_images as $agpi) {
                            $old_path = base_path('public/storage/uploads/temporary/'.$agpi->image);
                            Storage::disk('s3')->put('products/' . $agpi->image, fopen($old_path, 'r+'));
                            $uploaded_image['product_image'] = $agpi->image;
                            ProductImage::create(['product_id' => $productCreate->id, 'user_id' => $user->id, 'image' => $uploaded_image['product_image']]);
                        }
                    } 
                }
                DB::commit();
                $store = Store::where('user_id',$user->id)->first();
                $storename = $store->store_name;
                $storelink = url('/seller-profile/'.base64_encode($user->id.' classroom'));
                $productlink = url('/product-description/'.Crypt::encrypt($productCreate->id));
                //Send email of new product created to buyer
                $mail_data = [
                    'subject' => 'NEW PRODUCT FROM YOUR FAVOURITE SELLER',
                    'data' => '<a href="'.$storelink.'">'.$storename.'</a> just added new product.<br>Why not check it out <a href="'.$productlink.'">now</a>!',
                    'sellerid'=>auth()->user()->id,
                ];
                
                $job = (new \App\Jobs\SendbuyersEmail($mail_data))
                        ->delay(now()->addSeconds(2)); 
                dispatch($job);
                
                //Delete temporary images and file
                $old_enteries = temporaryimages::where('user_id',auth()->user()->id)->get();
                if(count($old_enteries) > 0){
                    foreach($old_enteries as $oldent){
                        if($oldent->type == 4){
                            $files = Storage::files(base_path('public/uploads/products/'));
                            $ar = explode('.',$oldent->image);
                            foreach ($files as $file) {
                                if (strpos($file, $ar[0]) !== false) {
                                    Storage::delete($file);
                                }
                            }
                            //File::delete(base_path('public/storage/uploads/products/'.$oldent->image));
                        }
                        else{
                            File::delete(base_path('public/storage/uploads/temporary/'.$oldent->image));
                        }
                    }
                }
                temporaryimages::where('user_id',auth()->user()->id)->delete();

                //return redirect()->back()->with('success', 'Product Created Successfully.');
                return Redirect::to(route('storeDashboard.productDashboard'))->with('success', 'Product Created Successfully.');
            } else {
                if ($request->hasfile('main_image')) {
                    $path = 'products';
                    Storage::disk('s3')->delete($path . '/' . $uploaded_image['main_image']);
                }
                setcookie('error', 'Error occured while creating product!', time() + (86400 * 30), "/");
                return redirect()->back()->with('error', 'Error occured while creating product!')->withInput();
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            DB::rollBack();
            setcookie('error', $message, time() + (86400 * 30), "/");
            return redirect()->back()->with('error', $message)->withInput();
        }
    }

    public function autogeneratethumbnail(Request $request){

        $responseArray = ['success' => false, 'message' =>'' ,'data' => []];
        $validation = Validator::make($request->all(),['product_file' =>'required|max:51270'],['product_file.required'=>'Product file is required','product_file.max'=>'Product file must be less than 50mb']);
        if ($validation->fails()) {
            $responseArray['message'] = $validation->errors()->first();
            return response()->json($responseArray, 200);
        }

        $images = [];
        try{
            $old_enteries = temporaryimages::where('user_id',auth()->user()->id)->get();
            if(count($old_enteries) > 0){
                //$files = Storage::files(base_path('public/storage/uploads/products/'));
                foreach($old_enteries as $oldent){
                    if($oldent->type == 4){
                        // foreach ($files as $file) {
                        //     if (strpos($file, 'some_words') !== false) {
                        //         Storage::delete($file);
                        //     }
                        // }
                        File::delete(base_path('public/storage/uploads/products/'.$oldent->image));
                    }
                    else{
                        File::delete(base_path('public/storage/uploads/temporary/'.$oldent->image));
                    }
                }
            }
            temporaryimages::where('user_id',auth()->user()->id)->delete();
            $user = auth()->user();
            $file = $request->file('product_file');
            $path = 'public/uploads/products';
            
            $tname = str_replace(' ','',$request->product_title) . $user->id . rand(1, 99) . '_product_file';
            $name = $tname. '.' . $file->getClientOriginalExtension();
            

            //Save file in database 
            temporaryimages::create([
                            'user_id' => auth()->user()->id,
                            'type' => 4,
                            'image' =>$name,
                        ]);
            $uploaded_image['product_file'] = $name;
            $fname = $name;
            $accepted = ['pdf','docx','jpg','jpeg','png','doc','ppt','pptx'];
            if(in_array($file->getClientOriginalExtension(),$accepted)){

                //photo
                $photo_arr = ['jpg','jpeg','png'];
                //doc/pdf
                $else_arr = ['pdf','doc','docx','ppt','pptx'];
                if(in_array($file->getClientOriginalExtension(),$photo_arr)){
                    $path = 'public/uploads/temporary';
                    $file->storeAs($path, $name);
                    temporaryimages::create([
                        'user_id' => auth()->user()->id,
                        'type' => 0,
                        'image' =>$name,
                    ]);
                    $images[] = url('storage/uploads/temporary/'.$name);
                    $responseArray['success'] = true;
                    $responseArray['message'] = 'Created';
                    $responseArray['data'] = $images;
                }
                elseif(in_array($file->getClientOriginalExtension(),$else_arr)){
                    $file->storeAs($path, $name);
                    if($file->getClientOriginalExtension() == 'docx' ||$file->getClientOriginalExtension() == 'doc'){
                        $domPdfPath = base_path('vendor/dompdf/dompdf');
                        \PhpOffice\PhpWord\Settings::setCompatibility(false);
                        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF'); 
                        if($file->getClientOriginalExtension() == 'docx' ){
                            try{
                                $Content = \PhpOffice\PhpWord\IOFactory::load(public_path('storage/uploads/products/'.$fname));
                                $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
                                $PDFWriter->save(public_path('storage/uploads/products/'.$tname.'.pdf'));
                            }catch(Exception $e){
                                $responseArray['message'] = 'Some issue in generating thumbnails. Please upload them manually';
                                 return $responseArray;
                            }
                        }
                        else{
                            try{
                                $converter = new OfficeConverter(public_path('storage/uploads/products/'.$fname));
                                $converter->convertTo($tname.'.pdf');
                            }
                            catch(Exception $e){
                                 $responseArray['message'] = 'Some issue in generating thumbnails. Please upload them manually';
                                 return $responseArray;
                            }
                            // $Content = \PhpOffice\PhpWord\IOFactory::load(public_path('storage/uploads/products/'.$fname),'MsDoc'); 
                        } 
                        
                        $fname =  $tname.'.pdf';
                    }
                    elseif($file->getClientOriginalExtension() == 'ppt' || $file->getClientOriginalExtension() == 'pptx'){
                        try{
                            // $process = new Process(['HOME="'.getCWD().'" && export HOME && unoconv -f pdf '.public_path('storage/uploads/products/'.$fname).' 2>&1']);
                            // $process->run();
                            shell_exec('HOME="'.getCWD().'" && export HOME && unoconv -f pdf '.public_path('storage/uploads/products/'.$fname).' 2>&1');
                        }catch(Exception $e){
                             $responseArray['message'] = 'Some issue in generating thumbnails. Please upload them manually';
                                 return $responseArray;
                        }               
                    }
                    $img = new Imagick();
                    for ($i = 0; $i < 4; $i++) {
                        try {
                            $img->readImage(base_path('public/storage/uploads/products/'.$tname.'.pdf['.$i.']'));
                        } catch (Exception $e) {
                            // echo "<pre>";
                            // print_r($tname);
                            // print_r($e);
                            // echo "</pre>";
                            
                        }
                    }

                   
                    // Set image resolution
                    $num_pages = $img->getNumberImages();
                    
                    // Compress Image Quality
                    
                    
                    // Convert PDF pages to images
                    for($i = 0;$i < $num_pages; $i++) {         
                        temporaryimages::create([
                            'user_id' => auth()->user()->id,
                            'type' => $i,
                            'image' =>$fname.'-'.$i.'.jpg',
                        ]);
                        // Set iterator postion
                        $img->setIteratorIndex($i);
                        $img->setImageBackgroundColor('white');
                        $img->setResolution(2000,2000);
                        $img->setImageCompressionQuality(100);
                        // Set image format
                        $img->setImageFormat('jpeg');

                        // Write Images to temp 'upload' folder     
                        $img->writeImage(base_path('public/storage/uploads/temporary/'.$fname.'-'.$i.'.jpg'));
                        $images[] = url('storage/uploads/temporary/'.$fname.'-'.$i.'.jpg');
                    }
                    $responseArray['success'] = true;
                    $responseArray['message'] = 'Created';
                    $responseArray['data'] = $images;  
                }
            }
            else{
                $responseArray['message'] = 'AutoThubmnail Cannot be Created for these extension.Plese upload thumbnails manually.';
            }   
        }catch (Exception $ex){
            $responseArray['message'] = $ex->getMessage();
            DB::rollBack();
        //     setcookie('error', $message, time() + (86400 * 30), "/");
        //     return redirect()->back()->with('error', $message)->withInput();
        }
        return response()->json($responseArray, 200);
    }
    
    /** + 
     * used to get subject sub area
     * @param Request $request - request type post
     * @return type
     */
    public function getSubjectSubArea(Request $request) {
        $responseArray = ['success' => false, 'data' => []];
        $subject_area = $request->subject_area;

        $getSubArea = ClassroomCopyHelper::getProductSubjectSubArea($subject_area);
        $responseArray['data'] = $getSubArea;
        $responseArray['success'] = true;

        return response()->json($responseArray, 200);
    }

    public function getSubjectSubSubArea(Request $request) {
        $responseArray = ['success' => false, 'data' => []];
        $subject_sub_area = $request->subject_sub_area;

        $getSubArea = ClassroomCopyHelper::getProductSubjectSubArea($subject_sub_area);
        $responseArray['data'] = $getSubArea;
        $responseArray['success'] = true;

        return response()->json($responseArray, 200);
    }

    /** + 
     * used to update product
     * @param Request $request - request type get/post
     * @param type $product_id - id of 
     * @return type
     */
    public function updateProduct(Request $request, $product_id) {
        if (auth()->user()->process_completion != 3) {
            return Redirect::to(route('become.a.seller'));
        }
        $prodRes = Product::where([['id', '=', $product_id], ['is_deleted', '=', 0], ['user_id', '=', auth()->user()->id]])->first();
        if ($prodRes == null) {
            return Redirect::to(URL('/store-dashboard/product-list'))->with('error', "Product not valid");
        }
        if ($request->isMethod('post')) {
            //DB::beginTransaction();
            try {
                $store_id = 0;
                if (auth()->user()->process_completion != 3) {
                   // setcookie('error', 'Please complete payment system to update product', time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', "Please complete payment system to update product")->withInput();
                } else {
                    $storeRes = Store::where('user_id', auth()->user()->id)->first();
                    $store_id = ($storeRes != null) ? $storeRes->id : 0;
                }
                $validation = Validator::make($request->all(), Product::$updateProductValidation, Product::$addProductCustomMessage);
                if ($validation->fails()) {
                    //setcookie('error', $validation->errors()->first(), time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', $validation->errors()->first())->withInput();
                }
                //Level:
                $productFileTypeArr = ClassroomCopyHelper::getProductType();
                foreach ($request->year_level as $yearLevel) {
                    $gradeArr = GradeLevels::where('status', 1)->where('id', $yearLevel)->first();
                    if ($gradeArr == null) {
                        //setcookie('error', 'Selected level invalid.Please select valid level!', time() + (86400 * 30), "/");
                        return redirect()->back()->with('error', 'Selected level invalid.Please select valid level!')->withInput();
                    }
                }

                if ($request->hasFile('product_image')) {
                    $accepted = array('pg','png','jpeg','gif','tif','tiff','bmp','jpg');
                    foreach ($request->file('product_image') as $file) {
                        if (!in_array($file->getClientOriginalExtension(), $accepted)) {
                            //setcookie('error', 'Product images must be type of image only', time() + (86400 * 30), "/");
                            return redirect()->back()->with('error', 'Product images must be type of image only')->withInput();
                        }
                    }
                }
                //Product file type validation:
                if ($request->hasfile('product_file')) {
                    $file = $request->file('product_file');
                    $fileType = $file->getClientOriginalExtension();

                    if ($request->product_type !== $fileType) {
                        //setcookie('error', 'Selected file type was invalid!', time() + (86400 * 30), "/");
                        return redirect()->back()->with('error', 'Selected file type was invalid!')->withInput();
                    }

                    if (!in_array($fileType, $productFileTypeArr)) {
                        //setcookie('error', 'Selected file type was invalid!', time() + (86400 * 30), "/");
                        return redirect()->back()->with('error', 'Selected file type was invalid!')->withInput();
                    }
                }//check if type changed and file uploaded
                elseif($request->product_type != $prodRes->product_type){
                    return redirect()->back()->with('error', 'Please upload product file!')->withInput();
                }

                $user = auth()->user();
                $uploaded_image['main_image'] = $prodRes->main_image;
                $uploaded_image['product_image'] = null;
                $uploaded_image['product_file'] = $prodRes->product_file;
                if ($request->hasfile('main_image')) {
                    $file = $request->file('main_image');
                    $path = 'products';
                    $name = time() . date('YmdHis') . $user->id . rand(1, 9999) . '_main-image' . '.' . $file->getClientOriginalExtension();
                    $uploaded_image['main_image'] = $name;
                    $file->storeAs($path, $name, 's3');

                    //delete previous file
                    $fileExistCheckmain = Storage::disk('s3')->exists('products/'.$prodRes->main_image);
                    if ($fileExistCheckmain) {
                        Storage::disk('s3')->delete('products/' .$prodRes->main_image);
                    }

                }
                elseif($request->thumbnail_choice == 'auto'){
                    $auto_generate_main_img  = temporaryimages::where('user_id',auth()->user()->id)->where('type',0)->orderby('id','DESC')->first();
                    if($auto_generate_main_img){
                        $old_path = base_path('public/storage/uploads/temporary/'.$auto_generate_main_img->image);
                        Storage::disk('s3')->put('products/' . $auto_generate_main_img->image, fopen($old_path, 'r+'));
                        // $old_path = base_path('public/storage/uploads/temporary/'.$auto_generate_main_img->image);
                        // $new_path = base_path('public/storage/uploads/products/'.$auto_generate_main_img->image);
                        // File::move($old_path, $new_path);
                        $uploaded_image['main_image'] = $auto_generate_main_img->image;

                        //delete previous file
                        $fileExistCheckmain = Storage::disk('s3')->exists('products/'.$prodRes->main_image);
                        if ($fileExistCheckmain) {
                            Storage::disk('s3')->delete('products/' .$prodRes->main_image);
                        }
                    }
                }

                if ($request->hasfile('product_file')) {
                    $file = $request->file('product_file');
                    $path = 'products';
                    $name =  str_replace(' ','',$request->product_title) . $user->id . rand(1, 99) . '_product_file' . '.' . $file->getClientOriginalExtension();
                    $uploaded_image['product_file'] = $name;
                    $file->storeAs($path, $name, 's3');

                    //delete old file
                    $fileExistCheck = Storage::disk('s3')->exists('products/'.$prodRes->product_file);
                    if ($fileExistCheck) {
                        Storage::disk('s3')->delete('products/' .$prodRes->product_file);
                    }
                }
                $saveData = [
                    'user_id' => $user->id,
                    'store_id' => $store_id,
                    'product_title' => $request->product_title,
                    'description' => $request->description,
                    'product_type' => $request->product_type,
                    'language' => (int) $request->language,
                    'resource_type' => implode(',', $request->resource_type),
                    'year_level' => implode(', ', $request->year_level),
                    'subject_area' => (int) $request->subject_area,
                    'subject_sub_area' => $request->subject_sub_area,
                    'subject_sub_sub_area' => $request->subject_sub_sub_area,
                    'custom_category' => $request->custom_category,
                    'outcome_country' => (int) $request->outcome_country,
                    'standard_outcome' => $request->standard_outcome,
                    'teaching_duration' => $request->teaching_duration,
                    'no_of_pages_slides' => $request->no_of_pages_slides ? $request->no_of_pages_slides : '',
                    'answer_key' => $request->answer_key ? $request->answer_key : '',
                    'is_paid_or_free' => $request->is_paid_or_free,
                    'single_license' => $request->single_license ? $request->single_license : 0,
                    'multiple_license' => $request->multiple_license ? $request->multiple_license : 0,
                    'tax_code' => $request->tax_code ? $request->tax_code : '',
                    'terms_and_conditions' => ($request->terms_and_conditions == "on") ? 1 : 0,
                    'main_image' => $uploaded_image['main_image'],
                    'product_file' => $uploaded_image['product_file'],
                ];
                /*NOT USED NOW JUST KEPT IT
                We will use it when doing thumbnail work
                if ($request->hasfile('product_file')) {

                  $pdfuploaded = $request->file('product_file');
                  $pdfname = $request->book_name . time() . '.' . $pdfuploaded->getClientOriginalExtension();
                  $pdfpath = public_path('/uploads/pdf');
                  $pdfuploaded->move($pdfpath, $pdfname);
                  $book = '/uploads/pdf/' . $pdfname;
                  $pdf = $book;

                  $pdfO = new Pdf($pdfpath . '/' . $pdfname);
                  $thumbnailPath = public_path('/uploads/thumbnails');
                  $thumbnail = $pdfO->setPage(1)
                    ->setOutputFormat('png')
                    ->saveImage($thumbnailPath . '/' . 'YourFileName.png');
                  // This is where you save the cover path to your database.
                }
                */
                Product::where('id', $product_id)->update($saveData);
                if ($request->hasFile('product_image')) {
                    //delete old file
                    $oldproductimages = ProductImage::where('user_id',$user->id)->where('product_id',$product_id)->get();
                    if(count($oldproductimages)>0){
                        foreach($oldproductimages as $opi){
                            $fileExistCheck = Storage::disk('s3')->exists('products/'.$opi->image);
                            if ($fileExistCheck) {
                                Storage::disk('s3')->delete('products/' .$opi->image);
                            } 
                        }
                    }
                    ProductImage::where('user_id',$user->id)->where('product_id',$product_id)->delete();
                    //delete old file

                    foreach ($request->file('product_image') as $file) {
                        $path = 'products';
                        $name = time() . date('YmdHis') . $user->id . rand(1, 9999) . '_product-image' . '.' . $file->getClientOriginalExtension();
                        $uploaded_image['product_image'] = $name;
                        ProductImage::create(['product_id' => $product_id, 'user_id' => $user->id, 'image' => $uploaded_image['product_image']]);
                        $file->storeAs($path, $name, 's3');
                    }
                }
                elseif($request->thumbnail_choice == 'auto'){
                    $auto_generate_product_images  = temporaryimages::where('user_id',auth()->user()->id)->whereIn('type',[1,2,3])->orderby('id','DESC')->get();
                    if($auto_generate_product_images){
                        
                        //delete old file
                        $oldproductimages = ProductImage::where('user_id',$user->id)->where('product_id',$product_id)->get();
                        if(count($oldproductimages)>0){
                            foreach($oldproductimages as $opi){
                                $fileExistCheck = Storage::disk('s3')->exists('products/'.$opi->image);
                                if ($fileExistCheck) {
                                    Storage::disk('s3')->delete('products/' .$opi->image);
                                } 
                            }
                        }
                        ProductImage::where('user_id',$user->id)->where('product_id',$product_id)->delete();
                        //delete old file

                        foreach ($auto_generate_product_images as $agpi) {
                            $old_path = base_path('public/storage/uploads/temporary/'.$agpi->image);
                            Storage::disk('s3')->put('products/' . $agpi->image, fopen($old_path, 'r+'));
                            
                            // $old_path = base_path('public/storage/uploads/temporary/'.$agpi->image);
                            // $new_path = base_path('public/storage/uploads/products/'.$agpi->image);
                            // File::move($old_path, $new_path);
                            
                            $uploaded_image['product_image'] = $agpi->image;
                            ProductImage::create(['product_id' => $product_id, 'user_id' => $user->id, 'image' => $uploaded_image['product_image']]);
                        }
                    } 
                }
                DB::commit();
                return Redirect::to(route('storeDashboard.productDashboard'))->with('success', 'Product Updated Successfully.');
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                DB::rollBack();
                //setcookie('error', $message, time() + (86400 * 30), "/");
                return redirect()->back()->with('error', $message)->withInput();
            }
        } else {
            $data = [];
            $data['title'] = 'Update Product';
            $data['home'] = 'Home';
            $data['breadcrumb1'] = 'Store Dashboard';
            $data['breadcrumb1_link'] = route('store.dashboard');
            $data['breadcrumb2'] = 'Product Dashboard';
            $data['breadcrumb2_link'] = route('storeDashboard.productDashboard');
            $data['breadcrumb3'] = 'Update Product';
            $data['prodRes'] = $prodRes;

            return view('store.product.update_product', compact('data'));
        }
    }

    /** + 
     * used to update product
     * @param Request $request - request type get/post
     * @param type $product_id - id of 
     * @return type
     */
    public function updateBundleProduct(Request $request, $product_id) {
        if (auth()->user()->process_completion != 3) {
            return Redirect::to(route('become.a.seller'));
        }
        $prodRes = Product::where([['id', '=', $product_id], ['is_deleted', '=', 0], ['user_id', '=', auth()->user()->id]])->first();
        if ($prodRes == null) {
            return Redirect::to(URL('/store-dashboard/product-list'))->with('error', "Product not valid");
        }
        if ($request->isMethod('post')) {
            //DB::beginTransaction();
            try {
                $store_id = 0;
                if (auth()->user()->process_completion != 3) {
                   // setcookie('error', 'Please complete payment system to update product', time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', "Please complete payment system to update product")->withInput();
                } else {
                    $storeRes = Store::where('user_id', auth()->user()->id)->first();
                    $store_id = ($storeRes != null) ? $storeRes->id : 0;
                }
                $validation = Validator::make($request->all(), Product::$updateProductValidation, Product::$addProductCustomMessage);
                if ($validation->fails()) {
                    //setcookie('error', $validation->errors()->first(), time() + (86400 * 30), "/");
                    return redirect()->back()->with('error', $validation->errors()->first())->withInput();
                }
                //Level:
                $productFileTypeArr = ClassroomCopyHelper::getProductType();
                foreach ($request->year_level as $yearLevel) {
                    $gradeArr = GradeLevels::where('status', 1)->where('id', $yearLevel)->first();
                    if ($gradeArr == null) {
                        //setcookie('error', 'Selected level invalid.Please select valid level!', time() + (86400 * 30), "/");
                        return redirect()->back()->with('error', 'Selected level invalid.Please select valid level!')->withInput();
                    }
                }

                if ($request->hasFile('product_image')) {
                    $accepted = array('pg','png','jpeg','gif','tif','tiff','bmp','jpg');
                    foreach ($request->file('product_image') as $file) {
                        if (!in_array($file->getClientOriginalExtension(), $accepted)) {
                            //setcookie('error', 'Product images must be type of image only', time() + (86400 * 30), "/");
                            return redirect()->back()->with('error', 'Product images must be type of image only')->withInput();
                        }
                    }
                }
                //Product file type validation:
                if ($request->hasfile('product_file')) {
                    $file = $request->file('product_file');
                    $fileType = $file->getClientOriginalExtension();

                    if ($request->product_type !== $fileType) {
                        //setcookie('error', 'Selected file type was invalid!', time() + (86400 * 30), "/");
                        return redirect()->back()->with('error', 'Selected file type was invalid!')->withInput();
                    }

                    if (!in_array($fileType, $productFileTypeArr)) {
                        //setcookie('error', 'Selected file type was invalid!', time() + (86400 * 30), "/");
                        return redirect()->back()->with('error', 'Selected file type was invalid!')->withInput();
                    }
                }//check if type changed and file uploaded
                elseif($request->product_type != $prodRes->product_type){
                    return redirect()->back()->with('error', 'Please upload product file!')->withInput();
                }

                $user = auth()->user();
                $uploaded_image['main_image'] = $prodRes->main_image;
                $uploaded_image['product_image'] = null;
                $uploaded_image['product_file'] = $prodRes->product_file;
                if ($request->hasfile('main_image')) {
                    $file = $request->file('main_image');
                    $path = 'products';
                    $name = time() . date('YmdHis') . $user->id . rand(1, 9999) . '_main-image' . '.' . $file->getClientOriginalExtension();
                    $uploaded_image['main_image'] = $name;
                    $file->storeAs($path, $name, 's3');

                    //delete previous file
                    $fileExistCheckmain = Storage::disk('s3')->exists('products/'.$prodRes->main_image);
                    if ($fileExistCheckmain) {
                        Storage::disk('s3')->delete('products/' .$prodRes->main_image);
                    }

                }
                elseif($request->thumbnail_choice == 'auto'){
                    $auto_generate_main_img  = temporaryimages::where('user_id',auth()->user()->id)->where('type',0)->orderby('id','DESC')->first();
                    if($auto_generate_main_img){
                        $old_path = base_path('public/storage/uploads/temporary/'.$auto_generate_main_img->image);
                        Storage::disk('s3')->put('products/' . $auto_generate_main_img->image, fopen($old_path, 'r+'));
                        // $old_path = base_path('public/storage/uploads/temporary/'.$auto_generate_main_img->image);
                        // $new_path = base_path('public/storage/uploads/products/'.$auto_generate_main_img->image);
                        // File::move($old_path, $new_path);
                        $uploaded_image['main_image'] = $auto_generate_main_img->image;

                        //delete previous file
                        $fileExistCheckmain = Storage::disk('s3')->exists('products/'.$prodRes->main_image);
                        if ($fileExistCheckmain) {
                            Storage::disk('s3')->delete('products/' .$prodRes->main_image);
                        }
                    }
                }

                if ($request->hasfile('product_file')) {
                    $file = $request->file('product_file');
                    $path = 'products';
                    $name =  str_replace(' ','',$request->product_title) . $user->id . rand(1, 99) . '_product_file' . '.' . $file->getClientOriginalExtension();
                    $uploaded_image['product_file'] = $name;
                    $file->storeAs($path, $name, 's3');

                    //delete old file
                    $fileExistCheck = Storage::disk('s3')->exists('products/'.$prodRes->product_file);
                    if ($fileExistCheck) {
                        Storage::disk('s3')->delete('products/' .$prodRes->product_file);
                    }
                }
                $saveData = [
                    'user_id' => $user->id,
                    'store_id' => $store_id,
                    'product_title' => $request->product_title,
                    'description' => $request->description,
                    'product_type' => $request->product_type,
                    'language' => (int) $request->language,
                    'resource_type' => implode(',', $request->resource_type),
                    'year_level' => implode(', ', $request->year_level),
                    'subject_area' => (int) $request->subject_area,
                    'subject_sub_area' => $request->subject_sub_area,
                    'subject_sub_sub_area' => $request->subject_sub_sub_area,
                    'custom_category' => $request->custom_category,
                    'outcome_country' => (int) $request->outcome_country,
                    'standard_outcome' => $request->standard_outcome,
                    'teaching_duration' => $request->teaching_duration,
                    'no_of_pages_slides' => $request->no_of_pages_slides ? $request->no_of_pages_slides : '',
                    'answer_key' => $request->answer_key ? $request->answer_key : '',
                    'is_paid_or_free' => $request->is_paid_or_free,
                    'single_license' => $request->single_license ? $request->single_license : 0,
                    'multiple_license' => $request->multiple_license ? $request->multiple_license : 0,
                    'tax_code' => $request->tax_code ? $request->tax_code : '',
                    'terms_and_conditions' => ($request->terms_and_conditions == "on") ? 1 : 0,
                    'main_image' => $uploaded_image['main_image'],
                    'product_file' => $uploaded_image['product_file'],
                    'bundleproducts'=>json_encode($request->products),
                ];
                /*NOT USED NOW JUST KEPT IT
                We will use it when doing thumbnail work
                if ($request->hasfile('product_file')) {

                  $pdfuploaded = $request->file('product_file');
                  $pdfname = $request->book_name . time() . '.' . $pdfuploaded->getClientOriginalExtension();
                  $pdfpath = public_path('/uploads/pdf');
                  $pdfuploaded->move($pdfpath, $pdfname);
                  $book = '/uploads/pdf/' . $pdfname;
                  $pdf = $book;

                  $pdfO = new Pdf($pdfpath . '/' . $pdfname);
                  $thumbnailPath = public_path('/uploads/thumbnails');
                  $thumbnail = $pdfO->setPage(1)
                    ->setOutputFormat('png')
                    ->saveImage($thumbnailPath . '/' . 'YourFileName.png');
                  // This is where you save the cover path to your database.
                }
                */
                Product::where('id', $product_id)->update($saveData);
                if ($request->hasFile('product_image')) {
                    //delete old file
                    $oldproductimages = ProductImage::where('user_id',$user->id)->where('product_id',$product_id)->get();
                    if(count($oldproductimages)>0){
                        foreach($oldproductimages as $opi){
                            $fileExistCheck = Storage::disk('s3')->exists('products/'.$opi->image);
                            if ($fileExistCheck) {
                                Storage::disk('s3')->delete('products/' .$opi->image);
                            } 
                        }
                    }
                    ProductImage::where('user_id',$user->id)->where('product_id',$product_id)->delete();
                    //delete old file

                    foreach ($request->file('product_image') as $file) {
                        $path = 'products';
                        $name = time() . date('YmdHis') . $user->id . rand(1, 9999) . '_product-image' . '.' . $file->getClientOriginalExtension();
                        $uploaded_image['product_image'] = $name;
                        ProductImage::create(['product_id' => $product_id, 'user_id' => $user->id, 'image' => $uploaded_image['product_image']]);
                        $file->storeAs($path, $name, 's3');
                    }
                }
                elseif($request->thumbnail_choice == 'auto'){
                    $auto_generate_product_images  = temporaryimages::where('user_id',auth()->user()->id)->whereIn('type',[1,2,3])->orderby('id','DESC')->get();
                    if($auto_generate_product_images){
                        
                        //delete old file
                        $oldproductimages = ProductImage::where('user_id',$user->id)->where('product_id',$product_id)->get();
                        if(count($oldproductimages)>0){
                            foreach($oldproductimages as $opi){
                                $fileExistCheck = Storage::disk('s3')->exists('products/'.$opi->image);
                                if ($fileExistCheck) {
                                    Storage::disk('s3')->delete('products/' .$opi->image);
                                } 
                            }
                        }
                        ProductImage::where('user_id',$user->id)->where('product_id',$product_id)->delete();
                        //delete old file

                        foreach ($auto_generate_product_images as $agpi) {
                            $old_path = base_path('public/storage/uploads/temporary/'.$agpi->image);
                            Storage::disk('s3')->put('products/' . $agpi->image, fopen($old_path, 'r+'));
                            
                            // $old_path = base_path('public/storage/uploads/temporary/'.$agpi->image);
                            // $new_path = base_path('public/storage/uploads/products/'.$agpi->image);
                            // File::move($old_path, $new_path);
                            
                            $uploaded_image['product_image'] = $agpi->image;
                            ProductImage::create(['product_id' => $product_id, 'user_id' => $user->id, 'image' => $uploaded_image['product_image']]);
                        }
                    } 
                }
                DB::commit();
                return Redirect::to(route('storeDashboard.productDashboard'))->with('success', 'Product Updated Successfully.');
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                DB::rollBack();
                //setcookie('error', $message, time() + (86400 * 30), "/");
                return redirect()->back()->with('error', $message)->withInput();
            }
        } else {
            $data = [];
            $data['title'] = 'Update Bundle Product';
            $data['home'] = 'Home';
            $data['breadcrumb1'] = 'Store Dashboard';
            $data['breadcrumb1_link'] = route('store.dashboard');
            $data['breadcrumb2'] = 'Product Dashboard';
            $data['breadcrumb2_link'] = route('storeDashboard.productDashboard');
            $data['breadcrumb3'] = 'Update Bundle Product';
            $data['prodRes'] = $prodRes;

            return view('store.product.update_bundle_product', compact('data'));
        }
    }

    /** +
     * used to get details of product
     * @param Request $request - request type get
     * @param type $id - id of product
     * @return type
     */
    public function productDescription(Request $request, $product_id) {
        $product_id = Crypt::decrypt($product_id);
        $_id = $product_id;
        $product = Product::with(['productSubjectArea', 'productOutcomeCountry'])
                        ->where([['id', '=', $product_id], ['is_deleted', '=', 0], ['user_id', '=', auth()->user()->id]])->first();
        if ($product == null) {
            return Redirect::to(URL('/store-dashboard/product-list'))->with('error', "Product not valid");
        }
        //get grade levels
        $gradeLevelArr = [];
        $gradeLevel = GradeLevels::whereIn('id', explode(', ', $product->year_level))->get();
        foreach ($gradeLevel as $grade) {
            $gradeLevelArr[] = $grade['grade'];
        }
        $product->gradeLevelStr = implode(',', $gradeLevelArr);

        $data = [];
        $data['title'] = 'Product Description';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'My Product';
        $data['breadcrumb2_link'] = route('store.products');
        $data['breadcrumb3'] = 'Product Dashboard';
        $data['breadcrumb4'] = 'Product Description';

        $productImages = ProductImage::where('product_id', $product_id)->get();

        $allreview = Web::getSellerProductsReviews(auth()->user()->id);
        foreach ($allreview as $key => $value) {
            if($value->product_id != $product_id){
                unset($allreview[$key]);
                continue;
            }
            # code...
            //echo $value->seller_user_id;
            $user = User::find($value->user_id);
            $reply = ReviewReply::where('review_id',$value->id)->first();
            $allreview[$key]->reply = false;
            $allreview[$key]->reply_text = "";
            if(!empty($reply)){
                $allreview[$key]->reply_text = $reply->reply;
                $allreview[$key]->reply = true;
            }
            $allreview[$key]->reviewer_user_name = @$user->first_name." ".@$user->surname;


            if(isset($user->default_image)){
                $allreview[$key]->reviewer_user_image = (new \App\Http\Helper\Web)->userDetail(@$user->id,'image');
            }else{
                $allreview[$key]->reviewer_user_image = asset('images/book-img.png');
            }
        }
        return view('store.product.product_description', compact('data', 'product', 'productImages', '_id','allreview'));
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

    public function changeproductstatus(Request $request){
        $responseArray = ['success' => false, 'message' => 'no data found'];
        $buyers_list = array();
        if(isset($request->status)){
            $status = ($request->status) == 1 ? 0 : 1;
            $ms = $status == 1?'Activated':'Deactivated';
            Product::where('id', $request->product_id)->update(['status'=>$status]);
            $buyers_list = Follower::where('followed_to',auth()->user()->id)->count();
            if(!empty($buyers_list)){
                $mail_data = [
                    'subject' => 'Product status changed',
                    'data' => 'Product '.$ms,
                    'sellerid'=>auth()->user()->id,
                ];
                
                $job = (new \App\Jobs\SendbuyersEmail($mail_data))
                        ->delay(now()->addSeconds(2)); 
                dispatch($job);
                
            }
            $responseArray['data'] = $status;
            $responseArray['data1'] = $buyers_list;
            $responseArray['success'] = true;
            $responseArray['message'] = 'Status Updated';
        }
        return response()->json($responseArray, 201);
    }

    public function getstoreProductPaginate(Request $request) {//return $request->toArray();
        $responseArray = ['success' => false, 'message' => ''];
        try {
            if ($request->isMethod('post')) {
                $validation = Validator::make($request->all(), []);
                if ($validation->fails()) {
                    $responseArray['message'] = $validation->errors()->first();
                } else {
                    $productsQuery = $this->storeProduct_query($request);
                    $productsData = $this->storeProduct_pagination_data($request, $productsQuery);
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

    public function storeProduct_query($request) {
        $search_keyword = $request->get('search-text', null);
        $sortby = $request->get('sortby',null);

        ///fs_product_subject
        $productsQuery = Product::where([['is_deleted','=', 0],['user_id','=',auth()->user()->id]])->with('productImages');

        if (!empty($search_keyword)) {
            $productsQuery->where(function ($query) use ($search_keyword) {
                $query->where("product_title", 'LIKE', '%' . $search_keyword . '%');
            });
        }

        if(!empty($sortby)){
            switch ($sortby):
                case 'mrp':
                    return $productsQuery->orderBy('created_at','DESC');
                    break;
                case 'mru':
                    return $productsQuery->orderBy('updated_at','DESC');
                    break;
                case 'featured':
                    return $productsQuery->withCount(['FeatureList as featured' => function   ($query)  {
                                $query->selectRaw('COALESCE(product_id)');
                            }])->orderByDesc('featured');
                    break;
                case 'az':
                    return $productsQuery->orderBy('product_title','ASC');
                    break;
                case 'za':
                    return $productsQuery->orderBy('product_title','DESC');
                    break;
            endswitch;
        }
        return $productsQuery->orderBy('id','ASC');
    }

    public function storeProduct_pagination_data($request, $productsQuery) {
        $per_page = $request->get('per_page', $this->itemPerPage);
        //        $per_page           =   4;
        $products = $productsQuery->paginate($per_page);
        $products->getCollection()->transform([$this, 'storeProduct_data']);
        return $products;
    }

    public function storeProduct_data($product) {
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
            'single_license' => number_format((float)$price, 2, '.', ''),
            'actual_single_license' => $product->single_license,
            'multiple_license' => $product->multiple_license,
            'is_paid_or_free' => $product->is_paid_or_free,
            'main_image' => Storage::disk('s3')->url('products/' . $product->main_image),
            'description' => $product->description,
            'auth_user' => '',
            'rating' => '',
            'status' => $product->status,
            'editurl' => (empty($product->type) ||$product->type == 'single')?url('store-dashboard/update-product/'.$product->id):url('store-dashboard/update-bundle-product/'.$product->id),
            'updated_date' => date('d/m/Y',strtotime($product->updated_at)),
            'is_sale' => $is_sale,
            'storeurl' => URL('/store-dashboard/product-details').'/'.Crypt::encrypt($product->id), 
        ];
        
        return $data;
    }
}