<?php
use \App\Http\Helper\Web;
$main_check_all = '';
$selected_checked = array();
if(isset($checked)){
	foreach($checked as $a => $v){
		if($v->products == 'Entire Store'){
			$main_check_all = 'checked';
		}
		else{
			$selected_checked = explode(',', $v->products);
		}
	}
}
?>
<input type="text" name="search_seller_products" id="sellerproducts" class="form-custom-input border mb-4 width-50" value="" placeholder="Search by Title, Custom Category, Price">
<div class="my-sales-list">
	<h5>Product Listings</h5>
</div>
<div class="table-responsive mb-4 view-table-box">
<table id="product-list-seller" class="table align-middle m-0 table-bordered">
	<thead>
	    <tr class="text-center">
	        <th width="40px">
	        	<input class="form-check-input check-all m-0" type="checkbox" name="data[product][check_all]" <?php echo $main_check_all;?> style="margin-left:0px!important;">
	        </th>
	        <th>S.no.</th>
	        <th>Title</th>
	        <th>Subject</th>
	        <th>Rating</th>
	        <th>Sold</th>
	        <th>Price</th>
	        <th>Price After Discount</th>
	        <th>License price</th>
	        <th>License Price After Discount</th>
	    </tr> 
	</thead>
	<tbody>
		@foreach($product_list as $key => $lst)
		<tr class="filter-main {{$lst->product_title.' '.$lst->custom_category.' '.$lst->single_license.' '.(int)$lst->single_license - (int)($lst->single_license*$discount/100).' '.$lst->multiple_license.' '.(int)$lst->multiple_license - (int)($lst->single_license*$discount/100)}}">
			<td width="40px"><input class="form-check-input single-list m-0" style="margin-left:0px!important;" type="checkbox" name="data[product][productids][]" value="{{$lst->id}}" {{$main_check_all}} <?php if(in_array($lst->id, $selected_checked)){ echo "checked";}?>></td>
			<td>{{$key+1}}</td>
			<td>{{$lst->product_title}}</td>
			<td>
				<?php
                    $subjectArea = DB::table('crc_subject_details')->where('id', $lst->subject_area)->first();
                    echo ($subjectArea != null) ? $subjectArea->name : 'N/A';
                ?>
            </td>
			<td>{{Web::getProductRating($lst->id)}}</td>
			<td>{{DB::table('crc_order_items')->where('product_id',$lst->id)->where('status',1)->count();}}</td>
			<td>${{$lst->single_license}}</td>
			<td>${{(float)$lst->single_license - ((float)$lst->single_license*$discount/100)}}</td>
			<td>{{(!empty($lst->multiple_license) && $lst->multiple_license != 0)?'$'.$lst->multiple_license:'-'}}</td>
			<td>{{(!empty($lst->multiple_license) && $lst->multiple_license != 0)?'$'.((float)$lst->multiple_license - ((float)$lst->single_license*$discount/100)):'-'}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>
<button type="submit" class="btn text-uppercase btn-hover" id="get-final-submit">Next</button>
<a class="btn text-uppercase btn-hover" href="{{route('storeDashboard.HostAsale')}}">cancel</button>