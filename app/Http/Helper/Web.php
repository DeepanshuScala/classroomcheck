<?php

namespace App\Http\Helper;

use Mail;
use Carbon\Carbon;
use DB;
use App\Models\{
    User,
    SubjectDetails,
    RateReviews,
    hostsale,
    Product,
    Store,
    ReviewReply,
    Questions,
    FeatureList,
    SellerOffer,
    SellerOfferApplied
};
use Illuminate\Support\Facades\{
    Storage,
};

class Web {

    /** + 
     * used to get total number of buyers
     * @return type
     */
    public static function getBuyersTotalCount() {
        $count = User::where('role_id', 1)->count();
        return $count;
    }

    /** + 
     * used to get total number of sellers
     * @return type
     */
    public static function getSellersTotalCount() {
        $count = User::where('process_completion',3)->where('role_id', 2)->count();
        return $count;
    }

    /** + 
     * used to generate random number 
     * @param type $digitLength - length of random number
     * @return type
     */
    public static function getRandomNumber($digitLength = 7) {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $digitLength; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        return $result;
    }

    /** + 
     * used to convert count to k,m,b etc
     * @param type $num - count
     * @return string
     */
    public static function thousandsCurrencyFormat($num) {
        if ($num > 1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];

            return $x_display;
        }

        return $num;
    }

    /** + 
     * used to generate alpha numeric number 
     * @param type $digitLength - length of random number
     * @return type
     */
    public static function getAlphaNumericNumber($digitLength = 8) {
        $generator = "ABCDEabcdefg7890lmFGHIJKhijkLMNOPQRSTnUVWXY456Zpqrstuvwxyz123";
        $result = "";
        for ($i = 1; $i <= $digitLength; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }

        return $result;
    }

    /** +
     * used to get sub subject
     * @param type $parent_id - parent id of subject
     * @param type $spacing
     * @param type $tree_array
     * @return type
     */
    public static function getSubjectTreeArray($parent_id = 0, $spacing = '', $tree_array = array()) {
        $categories = SubjectDetails::select('id', 'name', 'parent_id')
                        ->where('parent_id', $parent_id)
                        ->where('is_deleted', 0)->where('status', 1)->orderBy('parent_id')->get();
        foreach ($categories as $item) {
            $tree_array[] = ['id' => $item->id, 'name' => $spacing . $item->name, 'parent_id' => $item->parent_id];
            $tree_array = self::getSubjectTreeArray($item->id, $spacing . '--', $tree_array);
        }
        return $tree_array;
    }

    /** + 
     * used to get all subject tree
     * @return type
     */
    public static function getAllSubjectTree() {
        $spacing = '';
        $subjectArr = array();
        $categories = SubjectDetails::where('parent_id', '=', 0)->where('is_deleted', 0)->where('status', 1)->orderBy('parent_id')->get();
        foreach ($categories as $item) {
            $subjectArr[] = ['id' => $item->id, 'name' => $spacing . $item->name, 'parent_id' => $item->parent_id];
            $subjectArr = self::getSubjectTreeArray($item->id, $spacing . '--', $subjectArr);
        }
        return $subjectArr;
    }

    /** + 
     * used to get average rating of product by product id
     * @param type $product_id - id of product
     * @return type
     */
    public static function getProductRating($product_id = 0) {
        $avgRating = 0;
        $reviewsResult = RateReviews::where([['type', '=', 1], ['product_id', '=', $product_id]])->get();
        if (count($reviewsResult) > 0) {
            $avgRating = $reviewsResult->avg('rating');
        }
        return round($avgRating,2);
    }

    /** + 
     * used to get reviews of products
     * @param type $product_id - id of product
     * @return type
     */
    public static function getProductReviews($product_id = 0) {
        $reviews = RateReviews::join('users', function ($join) {
                    $join->on('crc_rate_review.user_id', '=', 'users.id');
                })->where([['crc_rate_review.type', '=', 1], ['crc_rate_review.product_id', '=', $product_id]])
                ->select('crc_rate_review.*', 'users.first_name', 'users.surname','users.image','users.role_id')
                ->get();
        foreach ($reviews as $key => $value) {
            # code...
            $replay = ReviewReply::where('review_id',$value->id)->first();
            $reviews[$key]->replay = false;
            if(!empty($replay)){
                $reviews[$key]->replay = true;
            }
        }
        return $reviews;
    }

    /** + 
     * used to get reviews of seller
     * @param type $seller_id - id of seller
     * @return type
     */
    public static function getSellerReviews($seller_id = 0 , $orderby = 'created_at') {
        $reviews = RateReviews::join('users', function ($join) {
                    $join->on('crc_rate_review.user_id', '=', 'users.id');
                })->where([['crc_rate_review.type', '=', 2], ['crc_rate_review.seller_id', '=', $seller_id]])
                ->select('crc_rate_review.*', 'users.first_name', 'users.surname', 'users.role_id')
                ->orderBy($orderby,'DESC')
                ->get();

        return $reviews;
    }

    public static function getsingleprice($prodid,$user_id,$price, $is_sale = 0){
        $hsalec = hostsale::where('user_id',$user_id)->get();
        $prod = Product::select(['is_paid_or_free'])->where('id',$prodid)->first();
        $purchasedin = '';
        if(count($hsalec) > 0){
            foreach ($hsalec as $key => $value) {
                if( strtotime(date('Y-m-d')) >= strtotime($value->start_date) && strtotime(date('Y-m-d')) <= strtotime($value->end_date) ){
                    if($prod->is_paid_or_free == 'paid'){
                        if($value->products == 'Entire Store'){
                            $price = $price - ($price * ($value->discount/100));
                            $is_sale = 1;
                            $purchasedin = '2';
                        }
                        else{
                            $sale_prods = explode(',', $value->products);
                            if(in_array($prodid, $sale_prods)){
                                $price = $price - ($price * ($value->discount/100));
                                $is_sale = 1;
                                $purchasedin = '2';
                            }
                        }
                    } 
                }
            }
        }

        //Check if featured also 
        $featurechk = FeatureList::where('user_id',$user_id)->get();
        if(count($featurechk) > 0){
            foreach ($featurechk as $k => $v) {
                if( strtotime(date('Y-m-d')) == strtotime($v->date)){
                    if($v->product_id == $prodid){
                        if(empty($purchasedin)){
                            $purchasedin ='3';
                        }
                        else{
                            $purchasedin .=',3';
                        }
                        
                       break; 
                    } 
                }
            }
        }

        if($prod->is_paid_or_free == 'free'){
            $price = 0;
        }

        if(is_numeric( $price ) && floor( $price ) != $price){
            $price = number_format($price,2,'.','');
        }
        else{
            $price = number_format($price,2,'.','');
        }
        return array('price'=>$price,'is_sale'=>$is_sale,'purchasedin'=>$purchasedin);
    }

    /** + 
     * get Store detail
     * @param type $seller_id - id of Seller
     * @return type
     */
    public static function getTotalProductCount($seller_id = 0) {
        $totalCount = Product::where('user_id',$seller_id)->where('status',1)->where('is_deleted',0)->count();
        return $totalCount;
    }


    /** + 
     * For total count uploaded products base on seller id
     * @param type $seller_id - id of Seller
     * @return type
     */
    public static function storeDetail($seller_id = 0,$key="image") {
        $value = asset('images/book-img.png');
        $detail = Store::where('user_id',$seller_id)->first();
        if(!empty($detail)){
            if($key=="store_logo"){
                $value  = Storage::disk('s3')->url('store/'.$detail->{$key});
            }else{
                $value = $detail->{$key};
            }
        }
        return $value;
    }

     /** + 
     * get all review of total uploaded products
     * @param type $seller_id - id of seller
     * @return type
     */
    public static function getSellerProductsReviews($seller_id = 0,$orderby='created_at') {
        $reviews = RateReviews::join('crc_products', function ($join) {
                    $join->on('crc_rate_review.product_id', '=', 'crc_products.id');
                })->where('crc_products.user_id', '=', $seller_id)
                ->select('crc_rate_review.*', 'crc_products.product_title', 'crc_products.user_id as seller_user_id')
                ->orderBy($orderby,'DESC')
                ->get();

        return $reviews;
    }

    /** + 
     * get review  replay
     * @param type $review_id
     * @return type
     */
    public static function getReplayDetail($review_id = 0) {
        $replay = ReviewReply::where('review_id',$review_id)->first();
        return $replay;
    }

    /** + 
     * get  buyer(user) detail base on key 
     * @param type $seller_id - id of Seller
     * @return type
     */
    public static function userDetail($user_id = 0,$key="image") {
        $value = asset('images/book-img.png');

        $detail = User::where('id',$user_id)->first();
        if(!empty($detail)){
            if($key=="image"){
                $value = Storage::disk('s3')->url('profile_picture/'.$detail->image);
                // if($detail->default_image == 0){
                //     $value = url('storage/uploads/profile_picture/'.$detail->image);
                // }else{
                //     $value = asset('images/book-img.png');
                // }
            }else{
                $value = $detail->{$key};
            }
        }
        return $value;
    }
    
    /** + 
     * get queation base answer id
     * @param type $review_id
     * @return type
     */
    public static function getQueationDetail($question_id = 0) {
        $queation = Questions::where('parent_id',$question_id)->first();
        //print_r($queation->toarray());exit;
        return $queation;
    }

    /** + 
     * get product details base product id
     * @param type $product_id
     * @return type
     */
    public static function getProductDetail($product_id = 0, $key='product_title') {
        $product = Product::where('id',$product_id)->first();
        //print_r($queation->toarray());exit;
        $value = "";
        if(!empty($product)){
            $value = $product->{$key};
        } 
        return $value;
    }

    public function checkofferstatus(){
        $res = SellerOffer::first();
        return !empty($res)?$res->is_active:'';
    }

    public function checkifsellerundermembership($user_id,$orderdate,$salescommission){
        $chck = SellerOfferApplied::where('userid',$user_id)->first();
        if(!empty($chck)){
            $futureDate=date('Y-m-d', strtotime('+1 year', strtotime($chck->created_at)));
            if(strtotime($orderdate) < strtotime($futureDate)){
                $salescommission = 0;
            }
        }
        return $salescommission;
    }
}