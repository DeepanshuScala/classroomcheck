<?php
use \App\Http\Helper\Web;
?>
<div class="details-products-final row mx-1">
	<div class="col">
		<span class="fw-bold">Discount: </span>
		{{$discount}}%
	</div>

	<div class="col">
		<span class="fw-bold">Start Date: </span>
		{{date('m-d-Y',strtotime($start_date))}}
	</div>

	<div class="col">
		<span class="fw-bold">End Date: </span>
		{{date('m-d-Y',strtotime($end_date))}}
	</div>

	<div class="col">
		<span class="fw-bold">Product Selected: </span>
		{{count($product_list)}}
	</div>
</div>
<div class="my-sales-list mt-4">
	<h5>Product Listings</h5>
</div>
<div class="table-responsive mb-4  view-table-box">
<table id="product-list-seller" class="table align-middle m-0 table-bordered">
	<thead>
	    <tr class="text-center">
	        <th>S.no.</th>
	        <th>Title</th>
	        <th>Custom Category</th>
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
			<tr>
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
<button type="submit" class="btn text-uppercase btn-hover" id="final-submit">Submit</button>
<button type="submit" class="btn text-uppercase btn-hover" id="go-to-second">Back</button>
<a class="btn text-uppercase btn-hover" href="{{route('storeDashboard.HostAsale')}}">Cancel</button>