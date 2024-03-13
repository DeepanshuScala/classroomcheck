<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    User,
    Product,
    ProductImage,
    Store,
    PromoDetails,
    hostsale,
    Order,
    OrderItem,
    FeatureList,
    ReviewReply,
    Questions,
    Sellersemaillog,
    Follower,
    SellerOffer,
    SellerOfferApplied
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
use Illuminate\Support\Str;
use Carbon\Carbon;
use Session;
use Exception;
use Validator;
use App\Traits\{
    FileProcessing
};
use \App\Http\Helper\{ClassroomCopyHelper, Web};
use DateTime;

class StoreController extends Controller {

    public function storeDashboard() {
        if (auth()->check() && auth()->user()->process_completion != 3) {
            return Redirect::to(route('become.a.seller'));
        } else {
           
            $data = [];
            $data['title'] = 'Store Dashboard';
            $data['home'] = 'Home';
            $data['breadcrumb1'] = 'Store Dashboard';
            $data['breadcrumb2'] = false;
            $data['breadcrumb3'] = false;
            $user = auth()->user();
            
            $userid = (auth()->check())?auth()->user()->id:'';
        
            $storeRes = Store::where('user_id', $userid)->first();

            $data['is_store_added'] = ($storeRes == null) ? 0 : 1;

            return view('store.store_dashboard', compact(['data', 'user']));
        }
    }

    public function storeDashboardMyInbox() {
        $data = [];
        $data['title'] = 'My Inbox';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'My Inbox';
        $data['breadcrumb3'] = false;
        $userid = auth()->user()->id;
        //echo $userid;
        $sent_questions = Questions::where('sender_id',$userid)->where('type',1)->orderBy('created_at','desc')->take(10)->skip(0)->get();
        $total_sent_question = Questions::where('sender_id',$userid)->where('type',1)->orderBy('created_at','desc')->count();
        foreach ($sent_questions as $key => $value) {
            # code...
            $question = Questions::where('receiver_id',$userid)->where('type',0)->where('id',$value->parent_id)->first();
            $sent_questions[$key]->question1 = $question;
            

        }
        //print_r($sent_questions->toarray());exit;
        $receiver_answer = Questions::where('receiver_id',$userid)->where('type',0)->orderBy('created_at','desc')->take(10)->skip(0)->get();
        $total_receiver_answer = Questions::where('receiver_id',$userid)->where('type',0)->orderBy('created_at','desc')->count();

        foreach ($receiver_answer as $key => $value) {
            # code...
            $receiver_answer[$key]->answered = false;
            $answers = Questions::where('parent_id',$value->id)->where('sender_id',$userid)->where('type',1)->first();
            if(!empty($answers)){
                $receiver_answer[$key]->answered = true;
            }
        }

        $followers = Follower::where([['followed_to','=',auth()->user()->id],['notify','=',1]])->get()->count();
        $store = Store::where('user_id',auth()->user()->id)->first();
        return view('store.store_dashboard_my_inbox', compact('data','sent_questions','total_sent_question','receiver_answer','total_receiver_answer','followers','store'));
    }

    public function storeDashboardReports() {
        $data = [];
        $data['title'] = 'Reports';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Reports';
        $data['breadcrumb3'] = false;

        return view('store.reports.store_dashboard_reports', compact('data'));
    }

    public function storeDashboardReportsSalesReport(Request $request) {
        $data = [];
        $data['title'] = 'Sales';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Reports';
        $data['breadcrumb2_link'] = route('storeDashboard.reports');
        $data['breadcrumb3'] = 'Sales';

        //Get Seller products
        $seller_prods = [];
        $get_seller_prods = Product::select(['id'])->where('user_id',auth()->user()->id)->where('is_paid_or_free','paid')->get();
        if(count($get_seller_prods)>0){
            foreach($get_seller_prods as $pro){
                $seller_prods[] = $pro->id;
            }
        }

        $sales = OrderItem::with(['product','user','order'])->whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);
        $total_sale_for_period = OrderItem::whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);

        if(isset($request['start_date']) && !empty($request['start_date'])){
            
            $from = $request['start_date']." 00:00:00";
            $to = $request['end_date']." 23:59:59";
            $sales = $sales->whereBetween('created_at', [$from, $to])->orderBy('id','DESC');
            $total_sale_for_period = $total_sale_for_period->whereBetween('created_at', [$from, $to]);
        
        }
        if(isset($request['orderid']) && !empty($request['orderid'])){
            $orderid = $request["orderid"];
            $sales = $sales->whereHas('order', function ($query) use ($orderid) {
                $query->where('order_number', 'LIKE', '%'.$orderid.'%');
            });
            $total_sale_for_period = $total_sale_for_period->whereHas('order', function ($query) use ($orderid) {
                $query->where('order_number', 'LIKE', '%'.$orderid.'%');
            });
        }
        $data['sales'] = $sales->orderBy('id','DESC')->get();
        $data['total_earnings_for_period'] = 0;
        foreach($data['sales'] as $t){
            $pr = Product::select(['user_id'])->where('id',$t->product_id)->first();
            $sellerinfo = !empty($pr)?Store::where('user_id',$pr->user_id)->first():[];
            // $transaction_charge = (!empty($t->user) && $t->user->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
            // $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');

            // $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($pr->user_id,$t->created_at,$salescommission);

            // $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');

            $data['total_earnings_for_period']  += $t->amount - $t->commission - $t->transaction_charges - $t->sales_tax;
        }
        $data['total_sale_for_period'] = $total_sale_for_period->sum('amount');
        //$data['total_earnings_for_period'] = round($data['total_sale_for_period'] - ($data['total_sale_for_period'] * .11 ),2);
        return view('store.reports.store_dashboard_reports_sales_report', compact('data'));
    }

    public function storeDashboardReportsSalesTax(Request $request) {
        $data = [];
        $data['title'] = 'Sales Tax';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Reports';
        $data['breadcrumb2_link'] = route('storeDashboard.reports');
        $data['breadcrumb3'] = 'Sales Tax';

        //Get Seller products
        $seller_prods = [];
        $get_seller_prods = Product::select(['id'])->where('user_id',auth()->user()->id)->where('is_paid_or_free','paid')->get();
        if(count($get_seller_prods)>0){
            foreach($get_seller_prods as $pro){
                $seller_prods[] = $pro->id;
            }
        }


        $sales = OrderItem::with(['product','user','order'])->whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);
        $total_sale_for_period = OrderItem::whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);

        if(isset($request['start_date']) && !empty($request['start_date'])){
            
            $from = $request['start_date']." 00:00:00";
            $to = $request['end_date']." 23:59:59";
            $sales = $sales->whereBetween('created_at', [$from, $to])->orderBy('id','DESC');
            $total_sale_for_period = $total_sale_for_period->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        
        if(isset($request['orderid']) && !empty($request['orderid'])){
            $orderid = $request["orderid"];
            $sales = $sales->whereHas('order', function ($query) use ($orderid) {
                $query->where('order_number','LIKE', '%'.$orderid.'%');
            });
            $total_sale_for_period = $total_sale_for_period->whereHas('order', function ($query) use ($orderid) {
                $query->where('order_number', 'LIKE', '%'.$orderid.'%');
            });
        }
        
        $data['sales'] = [];

        $orderid_arr = array();
        foreach($sales->orderBy('id','DESC')->get() as $k => $v){

            $sellerinfo = !empty($v->product->user_id)?Store::where('user_id',$v->product->user_id)->first():[];
            $transaction_charge = (!empty($v->user) && $v->user->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
            $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
            $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($v->product->user_id,$v->created_at,$salescommission);
            $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');

            $getorderinfo = Order::select(['order_number','created_at'])->where('id',$v->order_id)->first();
            $getuserinfo = User::select(['first_name','surname','country'])->where('id',$v->user_id)->first();

            $proinfo = Product::select(['user_id'])->where('id',$v->product_id)->first();

            $getsellerinfo = User::select(['country'])->where('id',$proinfo->user_id)->first();

            if(!in_array($v->order_id,$orderid_arr)){
                $orderid_arr[] = $v->order_id;
                $data['sales'][$v->order_id]['date'] = date('m/d/Y',strtotime($getorderinfo->created_at));
                $data['sales'][$v->order_id]['orderid'] = $getorderinfo->order_number;
                $data['sales'][$v->order_id]['customer_name'] = $getuserinfo->first_name.' '.$getuserinfo->surname;
                $data['sales'][$v->order_id]['shipped_to'] = $getuserinfo->country;
                $data['sales'][$v->order_id]['shipped_from'] = $getsellerinfo->country;
                $data['sales'][$v->order_id]['sale_amount'] = $v->amount;
                $data['sales'][$v->order_id]['sales_tax_collected'] = $v->sales_tax;
                $data['sales'][$v->order_id]['total_earnings'] = $v->amount - $v->commission - $v->transaction_charges - $v->sales_tax;
            }
            else{
                $data['sales'][$v->order_id]['sale_amount'] += $v->amount;
                $data['sales'][$v->order_id]['sales_tax_collected'] += $v->sales_tax;
                $data['sales'][$v->order_id]['total_earnings'] += $v->amount - $v->commission - $v->transaction_charges - $v->sales_tax;
            }
        }
        $data['total_earnings_for_period'] = 0;
        foreach($data['sales'] as $t){
            $data['total_earnings_for_period'] += $t['total_earnings'];
        }
        $data['total_sale_for_period'] = $total_sale_for_period->sum('amount');
        //$data['total_earnings_for_period'] = round($data['total_sale_for_period'] - ($data['total_sale_for_period'] * .11 ),2);

        return view('store.reports.store_dashboard_reports_sales_tax', compact('data'));
    }

    public function storeDashboardReportsProducts(Request $request) {
        $data = [];
        $data['title'] = 'Products';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Reports';
        $data['breadcrumb2_link'] = route('storeDashboard.reports');
        $data['breadcrumb3'] = 'Products';

        //Get Seller products
        $seller_prods = [];
        $get_seller_prods = Product::select(['id'])->where('user_id',auth()->user()->id)->where('is_paid_or_free','paid')->get();
        if(count($get_seller_prods)>0){
            foreach($get_seller_prods as $pro){
                $seller_prods[] = $pro->id;
            }
        }


        $sales = OrderItem::with(['product','user','order'])->whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);
        $total_sale_for_period = OrderItem::whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);

        if(isset($request['start_date']) && !empty($request['start_date'])){
            
            $from = $request['start_date']." 00:00:00";
            $to = $request['end_date']." 23:59:59";
            $sales = $sales->whereBetween('created_at', [$from, $to])->orderBy('id','DESC');
            $total_sale_for_period = $total_sale_for_period->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        
        if(isset($request['productname']) && !empty($request['productname'])){
            $productname = $request["productname"];
            $sales = $sales->whereHas('product', function ($query) use ($productname) {
                $query->where("product_title", 'LIKE', '%' . $productname . '%');
            });
            $total_sale_for_period = $total_sale_for_period->whereHas('product', function ($query) use ($productname) {
                $query->where("product_title", 'LIKE', '%' . $productname . '%');
            });
        }
        
        $data['sales'] = [];

        $prod_arr = array();
        foreach($sales->orderBy('id','DESC')->get() as $k => $v){

            $sellerinfo = !empty($v->product->user_id)?Store::where('user_id',$v->product->user_id)->first():[];
            $transaction_charge = (!empty($v->user) && $v->user->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
            $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
            $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($v->product->user_id,$v->created_at,$salescommission);
            $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');
            
            $getproinfo = Product::select(['product_title','created_at'])->where('id',$v->product_id)->first();
            if(!in_array($v->product_id,$prod_arr)){
                $prod_arr[] = $v->product_id;

                
                if($v->quantity >1 ){
                    $data['sales'][$v->product_id]['multiple_numberofsales'] = 1;
                }
                else{
                    $data['sales'][$v->product_id]['single_numberofsales'] = 1;
                }
                $data['sales'][$v->product_id]['product_name'] = $getproinfo->product_title;
                $data['sales'][$v->product_id]['posted'] = date('m/d/Y',strtotime($getproinfo->created_at));
                $data['sales'][$v->product_id]['rating'] = Web::getProductRating($v->product_id);
                $data['sales'][$v->product_id]['total_earnings'] = $v->amount - $v->commission - $v->transaction_charges - $v->sales_tax;
            }
            else{
                
                if($v->quantity >1 ){
                    if(!isset($data['sales'][$v->product_id]['multiple_numberofsales'])){
                        $data['sales'][$v->product_id]['multiple_numberofsales'] = 0;
                    }
                    $data['sales'][$v->product_id]['multiple_numberofsales'] += 1;
                }
                else{
                    if(!isset($data['sales'][$v->product_id]['single_numberofsales'])){
                        $data['sales'][$v->product_id]['single_numberofsales'] = 0;
                    }
                    $data['sales'][$v->product_id]['single_numberofsales'] += 1;
                }
                //$data['sales'][$v->product_id]['numberofsales'] += 1;
                $data['sales'][$v->product_id]['total_earnings'] += $v->amount - $v->commission - $v->transaction_charges - $v->sales_tax;
            }
        }
        $data['total_earnings_for_period'] = 0;
        foreach($data['sales'] as $t){
            $data['total_earnings_for_period'] += $t['total_earnings'];
        }
        $data['total_sale_for_period'] = $total_sale_for_period->sum('amount');
        //$data['total_earnings_for_period'] = round($data['total_sale_for_period'] - ($data['total_sale_for_period'] * .11 ),2);

        return view('store.reports.store_dashboard_reports_products', compact('data'));
    }

    public function storeDashboardReportsMarkets(Request $request){
        $data = [];
        $data['title'] = 'Marketing';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Reports';
        $data['breadcrumb2_link'] = route('storeDashboard.reports');
        $data['breadcrumb3'] = 'Marketing';

        //Get Seller products
        $seller_prods = [];
        $get_seller_prods = Product::select(['id'])->where('user_id',auth()->user()->id)->where('is_paid_or_free','paid')->get();
        if(count($get_seller_prods)>0){
            foreach($get_seller_prods as $pro){
                $seller_prods[] = $pro->id;
            }
        }

        //Get feature dates 
        $feature_dates = [];
        $get_feature_prods = FeatureList::whereIn('product_id',$seller_prods)->where('payment_status',1)->where('status',1)->get();
        if(count($get_feature_prods) > 0){
            foreach($get_feature_prods as $fpro){
                $feature_dates[] = $fpro->date; 
            }
        }

        

        $sales = OrderItem::with(['product','user','order'])->whereIn('product_id',$seller_prods)->where('status',1)->where('type','product')->whereRaw("find_in_set('3',purchasedon)")->whereIn(DB::raw("DATE(created_at)"),$feature_dates);
        $total_sale_for_period = OrderItem::whereIn('product_id',$seller_prods)->where('type','product')->whereRaw("find_in_set('3',purchasedon)")->whereIn(DB::raw("DATE(created_at)"),$feature_dates)->where('status',1);
    
        if(isset($request['start_date']) && !empty($request['start_date'])){
            
            $from = $request['start_date']." 00:00:00";
            $to = $request['end_date']." 23:59:59";
            $sales = $sales->whereBetween('created_at', [$from, $to])->orderBy('id','DESC');
            $total_sale_for_period = $total_sale_for_period->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        
        if(isset($request['productname']) && !empty($request['productname'])){
            $productname = $request["productname"];
            $sales = $sales->whereHas('product', function ($query) use ($productname) {
                $query->where("product_title", 'LIKE', '%' . $productname . '%');
            });
            $total_sale_for_period = $total_sale_for_period->whereHas('product', function ($query) use ($productname) {
                $query->where("product_title", 'LIKE', '%' . $productname . '%');
            });
        }
        
        $data['sales'] = [];

        $prod_arr = array();
        
        foreach($sales->orderBy('id','DESC')->get() as $k => $v){

            $sellerinfo = !empty($v->product->user_id)?Store::where('user_id',$v->product->user_id)->first():[];
            $transaction_charge = (!empty($v->user) && $v->user->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
            $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
            $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($v->product->user_id,$v->created_at,$salescommission);
            $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');

            $getproinfo = Product::select(['product_title','created_at','id','single_license','multiple_license'])->where('id',$v->product_id)->first();
            if(!in_array($v->product_id.'-'.date('m-d-Y',strtotime($v->created_at)),$prod_arr)){
                $prod_arr[] = $v->product_id.'-'.date('m-d-Y',strtotime($v->created_at));
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['numberofsales'] = $v->quantity;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['dates'] = date('m-d-Y',strtotime($v->created_at));
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['product_name'] = $getproinfo->product_title;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['product_code'] = 100000+$getproinfo->id;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['single_price'] = $getproinfo->single_license;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['multiple_price'] = $getproinfo->multiple_license;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['transaction_charge'] = $v->transaction_charges;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['sale_commision'] = $v->commission;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['sale_tax'] = $v->sales_tax;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['amount'] = $v->amount;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['total_earnings'] = $v->amount - $v->commission - $v->transaction_charges - $v->sales_tax;
            }
            else{
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['numberofsales'] += $v->quantity;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['transaction_charge'] += $v->transaction_charges;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['sale_commision'] += $v->commission;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['sale_tax'] += $v->sales_tax;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['amount'] += $v->amount;
                $data['sales'][$v->product_id.'-'.date('m-d-Y',strtotime($v->created_at))]['total_earnings'] += $v->amount - $v->commission - $v->transaction_charges - $v->sales_tax;
            }
            
        }


        $data['total_earnings_for_period'] = 0;
        foreach($data['sales'] as $t){
            $data['total_earnings_for_period'] += $t['total_earnings'];
        }

        $data['total_sale_for_period'] = $total_sale_for_period->sum('amount');
        //$data['total_earnings_for_period'] = round($data['total_sale_for_period'] - ($data['total_sale_for_period'] * .11 ) ,2);

        return view('store.reports.store_dashboard_reports_sales_by_marketing', compact('data'));
    }

    public function storeDashboardReportsSalesByCountry(Request $request) {
        $data = [];
        $data['title'] = 'Sales By Country';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Reports';
        $data['breadcrumb2_link'] = route('storeDashboard.reports');
        $data['breadcrumb3'] = 'Sales By Country';

        //Get Seller products
        $seller_prods = [];
        $get_seller_prods = Product::select(['id'])->where('user_id',auth()->user()->id)->where('is_paid_or_free','paid')->get();
        if(count($get_seller_prods)>0){
            foreach($get_seller_prods as $pro){
                $seller_prods[] = $pro->id;
            }
        }


        $sales = OrderItem::with(['product','user','order'])->whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);
        $total_sale_for_period = OrderItem::whereIn('product_id',$seller_prods)->where('type','product')->where('status',1);

        if(isset($request['start_date']) && !empty($request['start_date'])){
            
            $from = $request['start_date']." 00:00:00";
            $to = $request['end_date']." 23:59:59";
            $sales = $sales->whereBetween('created_at', [$from, $to])->orderBy('id','DESC');
            $total_sale_for_period = $total_sale_for_period->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
        }
        
        if(isset($request['country']) && !empty($request['country'])){
            $country = $request["country"];
            $sales = $sales->whereHas('user', function ($query) use ($country) {
                $query->where('country', 'LIKE', '%'.$country.'%');
            });
            $total_sale_for_period = $total_sale_for_period->whereHas('user', function ($query) use ($country) {
                $query->where('country', 'LIKE', '%'.$country.'%');
            });
        }
        
        $data['sales'] = [];
        $data['total_earnings_for_period'] = 0;
        $country_arr = array();
        foreach($sales->orderBy('id','DESC')->get() as $k => $v){

            $sellerinfo = !empty($v->product->user_id)?Store::where('user_id',$v->product->user_id)->first():[];
            $transaction_charge = (!empty($v->user) && $v->user->country != 'Aus') ?(!empty($sellerinfo->transactioncharge_other)?$sellerinfo->transactioncharge_other:env('TRANSACTION_CHARGE_OTHER')):(!empty($sellerinfo->transactioncharge_aus)?$sellerinfo->transactioncharge_aus:env('TRANSACTION_CHARGE_AUS'));
            $salescommission = !empty($sellerinfo->sale_commission)?$sellerinfo->sale_commission:env('SALE_COMMISION');
            $salescommission = (new \App\Http\Helper\Web)->checkifsellerundermembership($v->product->user_id,$v->created_at,$salescommission);
            $salestax = !empty($sellerinfo->salestax)?$sellerinfo->salestax:env('SALE_TAX');

            
            $getuserinfo = User::select(['country'])->where('id',$v->user_id)->first();
            if(!in_array($getuserinfo->country,$country_arr)){
                $country_arr[] = $getuserinfo->country;
                $data['sales'][$getuserinfo->country]['numberofsales'] = $v->quantity;
                $data['sales'][$getuserinfo->country]['sales'] = $v->amount;
                $data['sales'][$getuserinfo->country]['commission'] = $v->commission;
                $data['sales'][$getuserinfo->country]['transaction_fee'] = $v->transaction_charges;
                $data['sales'][$getuserinfo->country]['tax_collected'] = $v->sales_tax;
                $data['sales'][$getuserinfo->country]['total_earnings'] = $v->amount - $v->commission - $v->transaction_charges - $v->sales_tax;

            }
            else{
                $data['sales'][$getuserinfo->country]['numberofsales'] += $v->quantity;
                $data['sales'][$getuserinfo->country]['sales'] += $v->amount;
                $data['sales'][$getuserinfo->country]['commission'] += $v->commission;
                $data['sales'][$getuserinfo->country]['transaction_fee'] += $v->transaction_charges;
                $data['sales'][$getuserinfo->country]['tax_collected'] += $v->sales_tax;
                $data['sales'][$getuserinfo->country]['total_earnings'] += $v->amount - $v->commission - $v->transaction_charges - $v->sales_tax;
            }
           
        }
        foreach($data['sales'] as $t){
            $data['total_earnings_for_period'] += $t['total_earnings']; 
        }
        $data['total_sale_for_period'] = $total_sale_for_period->sum('amount');
        // $data['total_earnings_for_period'] = round($data['total_sale_for_period'] - ($data['total_sale_for_period'] * (.11) ),2);

        return view('store.reports.store_dashboard_reports_sales_by_country', compact('data'));
    }

    public function storeDashAboutSelling() {
        $data = [];
        $data['title'] = 'About Selling';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'About Selling';
        $data['breadcrumb3'] = false;

        return view('store.store_dashboard_about_selling', compact('data'));
    }

    public function storeProducts() {
        $data = [];
        $data['title'] = 'Store Products';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = "Store Dashboard";
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'My Store Profile';
        $data['breadcrumb3'] = false;
        $storeRes = Store::where('user_id', auth()->user()->id)->first();
        $data['store_result'] = $storeRes;
        // $data['breadcrumb1'] = $storeRes->store_name;
        $storereview = Web::getSellerReviews(auth()->user()->id);
        foreach ($storereview as $key => $value) {
            # code...
            //echo $value->seller_user_id;
            $user = User::find($value->user_id);
            $storereview[$key]->reviewer_user_name = @$user->first_name." ".@$user->surname;


            if(isset($user->default_image)){
                $storereview[$key]->reviewer_user_image = (new \App\Http\Helper\Web)->userDetail(@$user->id,'image');
            }else{
                $storereview[$key]->reviewer_user_image = asset('images/book-img.png');
            }
        }
        $allreview = Web::getSellerProductsReviews(auth()->user()->id);
        foreach ($allreview as $key => $value) {
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

        $userid = auth()->user()->id;
        //echo $userid;
        $receiver_answer = Questions::where('receiver_id',$userid)->where('type',0)->orderBy('created_at','desc')->take(10)->skip(0)->get();
        $total_receiver_answer = Questions::where('receiver_id',$userid)->where('type',0)->orderBy('created_at','desc')->count();
        foreach ($receiver_answer as $key => $value) {
            # code...
            $receiver_answer[$key]->answered = false;
            $answers = Questions::where('parent_id',$value->id)->where('sender_id',$userid)->where('type',1)->first();
            if(!empty($answers)){
                $receiver_answer[$key]->answered = true;
                $receiver_answer[$key]->answer = $answers;
            }
        }
        return view('store.book_bin.book_bin_products', compact('data','allreview','storereview','receiver_answer','total_receiver_answer'));
    }

    public function storeDashMarketingDashboard() {
        $data = [];
        $data['title'] = 'Marketing Dashboard';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Marketing Dashboard';
        $data['breadcrumb3'] = false;

        return view('store.store_dashboard_marketing_dashboard', compact('data'));
    }

    public function storeDashHostAsale($id = '') {
        $data = [];
        $data['title'] = 'Host A Sale';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Marketing Dashboard';
        $data['breadcrumb2_link'] = route('storeDashboard.marketingDashboard');
        $data['breadcrumb3'] = 'Host A Sale';
        $data['editsale'] = array();
        $data['sales'] = hostsale::where('user_id',auth()->user()->id)->where('is_deleted',0)->get();
        if(isset($id) && !empty($id)){
            try{
                $checkid = Crypt::Decrypt($id);
                $editsale = hostsale::where('id',$checkid)->get();
                if(count($editsale) > 0){
                    foreach ($editsale as $key => $value) {
                        $data['editsale']['id'] = $value->id;
                        $data['editsale']['start_date'] = $value->start_date;
                        $data['editsale']['end_date'] = $value->end_date;
                        $data['editsale']['discount'] = $value->discount;
                        $data['editsale']['products'] = $value->products;
                    }
                }  
                else{
                    return Redirect::to(route('storeDashboard.HostAsale'));
                }
            }catch (Exception $ex){
                return Redirect::to(route('storeDashboard.HostAsale'));
            }
            
        }
        return view('store.store_dashboard_host_a_sale', compact('data'));
    }

    public function storeDashAddProduct() {
        $data = [];
        $data['title'] = 'Add Products';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'My Product';
        $data['breadcrumb2_link'] = route('storeDashboard.storeSetup');
        $data['breadcrumb3'] = 'Product Dashboard';
        $data['breadcrumb4'] = 'Add Products';

        return view('store.add_product', compact('data'));
    }

    public function storeDashStoreSetup(Request $request) {
        $data = [];
        $data['title'] = 'Store Set Up';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        // $data['breadcrumb2'] = 'Become A Seller';
        // $data['breadcrumb2_link'] = route('become.a.seller');
        $data['breadcrumb2'] = 'My Store Profile';
        $data['breadcrumb3'] = false;
        $storeRes = Store::where('user_id', auth()->user()->id)->first();
        $data['store_result'] = $storeRes;
        if (auth()->user()->is_admin_relative == 2)
            $promoRes = PromoDetails::where([['promo_usage_for', '=', 1], ['type', '=', 1], ['status', '=', 1]])
                            ->orderBy('id', 'DESC')->get();
        else
            $promoRes = PromoDetails::where([['promo_usage_for', '=', 1], ['type', '=', 1], ['status', '=', 1]])
                            ->orderBy('id', 'DESC')->get();
        $data['promotions'] = $promoRes;
        if ($request->isMethod('post')) {
            try {
                $validation = Validator::make($request->all(), Store::$accountSignupValidation, Store::$accountSignupCustomMessage);
                if ($validation->fails()) {
                    $responseArray['success'] = false;
                    $responseArray['message'] = $validation->errors()->first();
                    return response()->json($responseArray, 200);
                }
                $user = auth()->user();
                $responseArray = ['success' => false, 'message' => ''];
                $store_logo = ($storeRes != null) ? $storeRes->store_logo : '';
                $store_banner = ($storeRes != null) ? $storeRes->store_banner : '';
                $store_id = $request->store_id;
                if ($request->hasfile('store_logo')) {
                    if ($store_logo != '' && $store_logo != 'default_store_logo.png'){
                        try{
                            Storage::disk('s3')->delete('store/' . $store_logo);
                        }catch(Exception $e){

                        }

                    }
                    $store_logo = '';
                    $file = $request->file('store_logo');
                    $path = 'store';
                    $name = time() . '_store_logo' . '.' . $file->getClientOriginalExtension();
                    $store_logo = $name;
                    $file->storeAs($path, $name, 's3');
                }
                if ($request->hasfile('store_banner')) {
                    if ($store_banner != '' && $store_banner != 'default_store_banner.png'){
                        try{
                            Storage::disk('s3')->delete('store/' . $store_banner);
                        }catch(Exception $e){

                        }
                    }
                    $store_banner = '';
                    $file = $request->file('store_banner');
                    $path = 'store';
                    $name = time() . '_store_banner' . '.' . $file->getClientOriginalExtension();
                    $store_banner = $name;
                    $file->storeAs($path, $name, 's3');
                }
                if ($store_id == 0) {
                    $stores = Store::create([
                                "user_id" => auth()->user()->id,
                                'store_name' => $request->store_name,
                                'store_logo' => isset($request->default_store_logo)?'default_store_logo.png':$store_logo,
                                'store_banner' => isset($request->default_store_banner)?'default_store_banner.png':$store_banner,
                                'default_store_logo' => isset($request->default_store_logo)?1:0,
                                'default_store_banner' => isset($request->default_store_banner)?1:0,
                    ]);
                    if ($stores->id > 0) {
                        $emailData = [
                            "storename" => $request->store_name,
                            "storeurl" => url('/seller-profile/'.str_replace(' ','-',$request->store_name)),
                            "subject" => 'New Store Details',
                            'email' => auth()->user()->email,
                            'new'=>1,
                        ];
                        $send_mail = Mail::send('emails/seller_storeinfo_mail', $emailData, function ($message)use ($emailData) {
                            $message->to($emailData['email']);
                            $message->cc('admin@classroomcopy.com');
                            $message->subject($emailData['subject']);
                        });
                        $user->process_completion = 2;
                        $user->save();
                        $responseArray['success'] = true;
                        $responseArray['message'] = 'Store Created Successfully';
                    } else {
                        $responseArray['success'] = false;
                        $responseArray['message'] = 'Something went wrong';
                    }
                } else {
                    Store::where('id', $store_id)->update([
                        'store_name' => $request->store_name,
                        'store_logo' => isset($request->default_store_logo)?'default_store_logo.png':$store_logo,
                        'store_banner' => isset($request->default_store_banner)?'default_store_banner.png':$store_banner,
                        'default_store_logo' => isset($request->default_store_logo)?1:0,
                        'default_store_banner' => isset($request->default_store_banner)?1:0,
                    ]);
                    $emailData = [
                        "storename" => $request->store_name,
                        "storeurl" => url('/seller-profile/'.str_replace(' ','-',$request->store_name)),
                        "subject" => 'Updated Store Details',
                        'email' => auth()->user()->email,
                        'new'=>0,
                    ];
                    $send_mail = Mail::send('emails/seller_storeinfo_mail', $emailData, function ($message)use ($emailData) {
                        $message->to($emailData['email']);
                        $message->cc('admin@classroomcopy.com');
                        $message->subject($emailData['subject']);
                    });
                    $responseArray['success'] = true;
                    $responseArray['message'] = 'Store Updated Successfully';
                }
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                $responseArray['message'] = $message;
            }
            return response()->json($responseArray, 200);
        } else {
            return view('store.store_dashboard_store_setup', compact('data'));
        }
    }

    /** + 
     * used to check store name exist or not
     * @param Request $request - request type post
     * @return type
     */
    public function checkStoreNameExist(Request $request) {
        $responseArray = ['success' => false, 'message' => ''];
        $storeName = $request->store_name;
        $storeId = $request->store_id;
        if ($storeId == 0)
            $checkStores = Store::where('store_name', $storeName)->get();
        else
            $checkStores = Store::where('store_name', $storeName)->where('id', '!=', $storeId)->get();
        if (count($checkStores) > 0) {
            $responseArray['message'] = "Store name already exist";
        } else {
            $responseArray['message'] = "";
            $responseArray['success'] = true;
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

    public function hostasale(Request $request){
        $responseArray = ['success' => false, 'message' => ''];
        $start_date = new DateTime($request->start_date);
        $end_date = new DateTime($request->end_date);
        
        if(isset($request->get_final_data)){

            $frm1data = array();
            $user_id = auth()->user()->id;
            if(empty($user_id)){
                $responseArray['message'] = 'Something Wrong ! Please refresh the page.';
                return $responseArray;
            }
            foreach($request->dateformdata as $t){
                $frm1data[$t['name']] = $t['value']; 
            }

            unset($frm1data['_token']);

            /*
                if(!empty($frm1data['editsaleid'])){
                    $checksales = hostsale::where('user_id',auth()->user()->id)->whereNotIn('id',[$frm1data['editsaleid']])->get();
                }
                else{
                    $checksales = hostsale::where('user_id',auth()->user()->id)->get();
                }
                
                if(count($checksales)){
                    foreach($checksales as $kr => $v) {

                        if( ( strtotime($v->start_date) >= strtotime($frm1data['start_date']) && strtotime($v->start_date) <= strtotime($frm1data['end_date']) ) || (strtotime($v->end_date) >= strtotime($frm1data['start_date']) && strtotime($v->end_date) <= strtotime($frm1data['end_date'])) ){
                            if( ($request->prods == 'all' && $v->products == 'Entire Store') || ($v->products != 'Entire Store' && $request->prods == 'all') ){
                                $responseArray['message'] = 'These Dates are already booked.';
                                return $responseArray;
                            }
                            elseif($v->products != 'Entire Store' && $request->prods != 'all'){
                                $a = $request->prods;
                                $b = explode(',',$v->products);
                                $c = array_intersect($a, $b);
                                if (count($c) > 0) {
                                    $responseArray['message'] = 'Some Selected product are already booked for same dates.';
                                    return $responseArray;   
                                }
                            }
                        }
                    }
                }
            */

            if($request->prods == 'all'){
                $product_list = Product::with('ratings')->where('user_id',auth()->user()->id)->where('is_deleted',0)->where('status',1)->where('is_paid_or_free','paid')->get();
            }
            else{
                $product_list = Product::with('ratings')->where('user_id',auth()->user()->id)->where('is_deleted',0)->where('status',1)->where('is_paid_or_free','paid')->whereIn('id',$request->prods)->get();
            }
            if(!empty($frm1data['editsaleid'])){
                $checkstrdate = hostsale::select(['start_date'])->where('user_id',auth()->user()->id)->where('id',$frm1data['editsaleid'])->first();
                $strtdt = $checkstrdate->start_date;
            }
            else{
                $strtdt =  $frm1data['start_date'];
            }
            $returnHTML = view('store.marketing.final_sale_date_product_list')->with(['product_list'=> $product_list,'discount'=>$frm1data['discount'],'start_date' => $strtdt,'end_date' => $frm1data['end_date']])->render();
            $responseArray['success'] = true;
            $responseArray['renderhtml'] = $returnHTML;
        }
        elseif(isset($request->prods)){
            $frm1data = array();
            $user_id = auth()->user()->id;
            if(empty($user_id)){
                $responseArray['message'] = 'Something Wrong ! Please refresh the page.';
                return $responseArray;
            }
            foreach($request->dateformdata as $t){
                $frm1data[$t['name']] = $t['value']; 
            }

            unset($frm1data['_token']);

            
            
            

            if($request->prods == 'all'){
                $appliesto = 'Entire Store';
            }
            else{
                $appliesto  = implode(',', $request->prods);
            }
            if(!empty($frm1data['editsaleid'])){
                $checkstrdate = hostsale::select(['start_date'])->where('user_id',auth()->user()->id)->where('id',$frm1data['editsaleid'])->first();
                $strtdt = $checkstrdate->start_date;
                hostsale::where("id",$frm1data['editsaleid'])->update([
                    'start_date' => $strtdt,
                    'end_date' => $frm1data['end_date'],
                    'discount' => $frm1data['discount'],
                    'products' => $appliesto,
                    'user_id' => $user_id
                ]);      
                $responseArray['message'] = "Sale Updated Successfully";      
            }
            else{
                hostsale::create([
                    'start_date' => $frm1data['start_date'],
                    'end_date' => $frm1data['end_date'],
                    'discount' => $frm1data['discount'],
                    'products' => $appliesto,
                    'user_id' => $user_id
                ]);
                $responseArray['message'] = "Sale Created Successfully";      
            }
            //storeinfo 
            $storeinfo = Store::where('user_id',$user_id)->first();
            $mldata = 'SALE from your preffered seller has been started. Go and grab the huge discount on products';
            if(!empty($storeinfo)){
                $storeurl = url('/seller-profile/'.str_replace(' ','-',$storeinfo->store_name));
                $mldata = '<a style="text-decoration: underline; font-weight:900; cursor: pointer; color: #000 !important;" href="'.$storeurl.'">'.$storeinfo->store_name.'</a> just announced they are having a <span style="color:red;">sale</span>.<br>Why not grab a bargain and enjoy the savings?<br>Start shopping <a  style="color:#000 !important; cursor: pointer;text-decoration: underline;" href="'.url('/').'">now!</a>';
            }

            //Send Alert
            if(isset($frm1data['sendalert']) && $frm1data['sendalert'] == 1){
                
                $mail_data = [
                    'subject' => 'Sale started',
                    'data' => $mldata,
                    'sellerid'=>auth()->user()->id,
                    'sell' => 1,
                ];
                
                $job = (new \App\Jobs\SendbuyersEmail($mail_data))
                        ->delay(now()->addSeconds(2)); 
                dispatch($job);
            } 

            //Send email to users Who have on offers toggle in profile 
            $mail_data = [
                    'subject' => 'Sale started',
                    'data' => $mldata,
                    'sell' => 1,
                ];
            $job = (new \App\Jobs\Sendsalenotificationtoggle($mail_data))
                        ->delay(now()->addSeconds(2)); 
                dispatch($job);
            $responseArray['success'] = true; 
        }
        else{
            if( strtotime($request->start_date) > strtotime($request->end_date) ){
                $responseArray['message'] = "End Date cannot be less than Start Date";
            }
            elseif($end_date->diff($start_date)->format("%a") >= 14){

                $responseArray['message'] = 'Sale cannot extend for more than 14 days.';
            }
            else{
                $user_id = auth()->user()->id;
                if(empty($user_id)){
                    $responseArray['message'] = 'Something Wrong ! Please refresh the page.';
                }
                else{

                    $product_list = Product::with('ratings')->where('user_id',auth()->user()->id)->where('is_deleted',0)->where('status',1)->where('is_paid_or_free','paid')->get();
                    
                    if(!empty($request->editsaleid)){
                        $checksales = hostsale::where('user_id',auth()->user()->id)->whereNotIn('id',[$request->editsaleid])->get();
                        $cur_selection = hostsale::where('id',$request->editsaleid)->get();
                        
                        $returnHTML = view('store.marketing.select_product_list')->with(['product_list'=> $product_list,'discount'=>$request->discount,'checked' => $cur_selection])->render();
                    }
                    else{
                        $checksales = hostsale::where('user_id',auth()->user()->id)->get();
                        $returnHTML = view('store.marketing.select_product_list')->with(['product_list'=> $product_list,'discount'=>$request->discount])->render();
                    }
                    
                    if(count($checksales)){
                        foreach($checksales as $kr => $v) {
                            //if($v->products == 'Entire Store'){
                                if( strtotime($v->start_date) <= strtotime($request->end_date) && strtotime($v->end_date) >= strtotime($request->start_date) ){
                                    
                                    $responseArray['message'] = 'These Dates are already booked.';
                                    return $responseArray;
                                }
                            //}
                        }
                    }
                    /*
                        $appliesto = '';
                        if($request->appliesto == 'entire-store'){
                            $appliesto = 'Entire Store';
                        }
                        if(!empty($request->editsaleid)){
                            hostsale::where("id",$request->editsaleid)->update([
                                'start_date' => $request->start_date,
                                'end_date' => $request->end_date,
                                'discount' => $request->discount,
                                'products' => $appliesto,
                                'user_id' => $user_id
                            ]);      
                            $responseArray['message'] = "Sale Updated Successfully";      
                        }
                        else{
                            hostsale::create([
                                'start_date' => $request->start_date,
                                'end_date' => $request->end_date,
                                'discount' => $request->discount,
                                'products' => $appliesto,
                                'user_id' => $user_id
                            ]);
                            $responseArray['message'] = "Sale Created Successfully";      
                        }
                        
                        //Send Alert
                        if($request->sendalert == 1){
                            $mail_data = [
                                'subject' => 'Sale started',
                                'data' => 'hi',
                                'sellerid'=>auth()->user()->id,
                            ];
                            
                            $job = (new \App\Jobs\SendbuyersEmail($mail_data))
                                    ->delay(now()->addSeconds(2)); 
                            dispatch($job);
                        }
                    */
                    $responseArray['renderhtml'] = $returnHTML;
                    $responseArray['success'] = true;
                }
                
            }   
        }
        return response()->json($responseArray, 200);
    }

    public function hostasaledelete(Request $request){
        $responseArray = ['success' => false, 'message' => ''];
        $check = hostsale::where('id',$request->saleid)->where('user_id',auth()->user()->id)->count();
        if($check > 0){
            hostsale::where('id',$request->saleid)->delete();
            $responseArray['success'] = true; 
            $responseArray['message'] = 'Sale Deleted Successfully';
        }
        return $responseArray;
    }

    public function getstoreproductlist(Request $request){
        $responseArray = ['success' => false, 'message' => ''];
        $products_list = Product::where('user_id',auth()->user()->id)->where('is_deleted',0)->where('status',1)->get();
    }

    public function getsinglesale($id){
      
        $data = [];
        $data['title'] = 'Host A Sale';
        $data['home'] = 'Home';
        $data['breadcrumb1'] = 'Store Dashboard';
        $data['breadcrumb1_link'] = route('store.dashboard');
        $data['breadcrumb2'] = 'Marketing Dashboard';
        $data['breadcrumb2_link'] = route('storeDashboard.marketingDashboard');
        $data['breadcrumb3'] = 'View A Sale';
        $data['editsale'] = array();
        if(isset($id) && !empty($id)){
            try{
                $checkid = Crypt::Decrypt($id);
                $editsale = hostsale::where('id',$checkid)->get();
                
                if(count($editsale) > 0){
                    $discount = 0;

                    $start_date = '';
                    $end_date = '';
                    foreach ($editsale as $key => $value) {
                        if($value->products == 'Entire Store'){
                            $product_list = Product::with('ratings')->where('user_id',auth()->user()->id)->where('is_deleted',0)->where('status',1)->where('is_paid_or_free','paid')->get();
                        }
                        else{

                            $product_list_arr = explode(',', $value->products);
                            
                            $product_list = Product::with('ratings')->where('user_id',auth()->user()->id)->where('is_deleted',0)->where('status',1)->where('is_paid_or_free','paid')->whereIn('id',$product_list_arr)->get();
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
        else{
            return Redirect::to(route('storeDashboard.HostAsale'));
        }
        return view('store.store_dashboard_view_a_sale', compact('data'));
    }

    public function reviewReply(Request $request){
        try{
            $msg = "Replied Successfully";
            $revie_id = $request->review_id;
            if($request->type == "Delete"){
                $msg = "Deleted Successfully";
                ReviewReply::where('review_id',$revie_id)->delete();
            }else{
                if($request->type == "Update"){
                    $msg = "Updated Successfully";
                    $ReviewReply = ReviewReply::where('review_id',$revie_id)->first();                    
                }else{
                    $ReviewReply = new ReviewReply();    
                }
                $ReviewReply->review_id = $revie_id;
                $ReviewReply->user_id = auth()->user()->id;
                $ReviewReply->reply = $request->review;
                $ReviewReply->save();
            }
            $responseArray = ['success' => true, 'message' => $msg];
            $responseArray['data'] = $request->all();
            return response()->json($responseArray, 200);

        }catch (Exception $ex){
            $responseArray = ['success' => false];
            $responseArray['message'] = $ex->getMessage();
            return response()->json($responseArray, 201);
        }
    }

    public function getreviewsorted(Request $request){
        
        if(isset($request->userid)){
            $userid = $request->userid;    
        }
        elseif(auth()->user()->id){
            $userid = auth()->user()->id;
            $user = User::find($userid);
            if ($user->process_completion != 3) {
                $responseArray = ['success' => false, 'message' => 'Please Refresh Page'];
                return $responseArray;
            }
        }   
        $allreview = Web::getSellerProductsReviews($userid,$request->orderby);
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
            if(@$user1->default_image == 0 ){
                $allreview[$key]->reviewer_user_image = url('storage/uploads/profile_picture/'.@$user1->image);
            }else{
                $allreview[$key]->reviewer_user_image = asset('images/book-img.png');
            }
        }
        $renderHtml = view('store.book_bin.reviewlist')->with(['reviewArr'=> $allreview])->render();
        $responseArray = ['success' => true, 'message' => 'data found'];
        $responseArray['data'] = $renderHtml;
        return response()->json($responseArray, 200);
    }


    public function storeProfileUpdate(Request $request){
        try{
            $msg = "Updated Successfully";
            $type = $request->type;
            $val = $request->val;





            $user  = auth()->user();




            if($type == "name"){
                $first_name = $request->first_name;
                $surname = $request->surname;
                $user->first_name = $first_name;
                $user->surname =  $surname;
                $user->save();
            }else{
                $user->{$type} = $val;
                $user->save();
            }



            $responseArray = ['success' => true, 'message' => $msg];
            $responseArray['data'] = $user;
            return response()->json($responseArray, 200);

        }catch (Exception $ex){
            $responseArray = ['success' => false];
            $responseArray['message'] = $ex->getMessage();
            return response()->json($responseArray, 201);
        }
    }

    public function sendemailtobuyers(Request $request){
        $responseArray = ['success' => false, 'message' => 'no data found'];
        if(isset($request->subject)){
            $create_log = Sellersemaillog::create([
                                                'store_user_id' => auth()->user()->id,
                                                'subject' => $request->subject,
                                                'description' => $request->description,
                                            ]);
            $mail_data = [
                'subject' => $request->subject,
                'data' => $request->description,
                'sellerid'=>auth()->user()->id,
                'storeinbox'=>1,
            ];
            
            $job = (new \App\Jobs\SendbuyersEmail($mail_data))
                ->delay(now()->addSeconds(2)); 
                dispatch($job);
            $responseArray['success'] = true;
            $responseArray['message'] = 'Email Sent Successfully';
        }
        return response()->json($responseArray, 201);
    }

    public function storeDashboardapplyselleroffer(Request $request){
        $checkoffer = SellerOffer::where('code',$request->coupon)->first();
        if(!empty($checkoffer) && $checkoffer->is_active){
            $create = SellerOfferApplied::create(['userid'=>auth()->user()->id]); 
            if($create){
                return response()->json(['success'=>true], 201); 
            }
            else{
                return response()->json(['success'=>false,'message'=>'Something went wrong'], 201);
            }
        }
        else{
            return response()->json(['success'=>false,'message'=>'Offer Not Valid'], 201);
        }
    }

}