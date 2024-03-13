<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8 Content-Type: image/png">
            <title>Classroom Copy</title>
            <style type="text/css">
                @charset "utf-8";
                #footerDiv{
                }
                .dataDiv{
                }
				a{
					color:#306eba !important;
				}
            </style>
    </head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" width="650" style="margin: auto; border: 1px solid #ddd; font-family: Arial;">
		<tr>
			<td>
				<table border="0" cellpadding="15" cellspacing="0" bgcolor="ffffff" style="width: 100%;">
					<tr>
						<td style="padding-top: 0px; padding-bottom: 20px;padding-left:0px;padding-right:0px;text-align:center;position: relative !important;">
							<div style="width:100%;height:50px;background-color: #306eba;">
								<a href="{{url('/')}}" target="_blank"  style="text-decoration: none;">
									<img src="{{asset('images/logo.png')}}" width="250px" style="padding-top:5px;">
								</a>
							</div>
						</td>
					</tr>
				</table>
				<table border="0" cellpadding="15" cellspacing="0" style="width: 100%;padding-top: 50px;">
					<tr>
						<td align="center">
							<p style="font-family: Arial;font-size: 18px;color:#306eba;text-transform: uppercase; text-align: center;">THANKYOU FOR YOUR PURCHASE</p>
							<p style="font-family: Arial;font-size: 16px;color:#242424;line-height: 24px;text-align: center;">Your purchase can be downloaded now <br>
								or accessed any time through <a href="{{url('account-dashboard/my-purchase-history')}}" style="color: #000;text-decoration:none;"><b>My Purchase History</b></a></p>
						</td>
					</tr>
					@foreach($products as $pr)
					<tr>
						<td align="left">
							<table style="width:100%;">
								<tr valign="top">
									<td style="width: 25%;">
										<img src="{{$pr['image']}}" alt="" style="max-width: 100%;">
									</td>
									<td style="width: 40%;padding-left: 20px;">
										<p style="font-size: 14px;font-family: Arial;color:#b3b3b3;text-align: left;margin-bottom: 5px;">Resource #{{$pr['id']}}</p>
										<p style="font-size: 14px;font-family: Arial;font-weight:600;text-align: left;margin-bottom: 5px;">{{$pr['name']}}</p>
										<p style="font-size: 14px;font-family: Arial;color:#b3b3b3;;text-align: left;margin-top: 5px;">By {{$pr['seller']}}</p>
										<p style="font-size: 14px;font-family: Arial;font-weight:600;text-align:left;margin-top: 0px;">Total: ${{$pr['amount']}}</p>
									</td>
									<td style="width: 35%;">
										@if($pr['name']!='Gift Card')
											<p style="font-family: Arial;font-size: 16px;text-align:right; ">
												<a href="{{url('/account-dashboard/my-purchase-history')}}" style="background-color: #306eba;border-color: #0a53be;border:1px solid;padding: 0.9rem 1.5rem;color: #fff!important;border-radius: 0.6rem;margin-right: 0.5rem!important;margin-left: 0.5rem!important;line-height: 1.5;text-decoration: none;">Download Now</a>
											</p>
										@endif
									</td>
								</tr>
							</table>
						</td>
					</tr>
					@endforeach
					<tr>
						<td>
							<hr>
						</td>
					</tr>
					<tr>
						<td align="center">
							<div style="width:68%;border:7px solid #75a9e9;border-radius: 5px;padding: 10px;">
								<p style="font-family: Arial;text-align: left;margin-top: 0px; margin-bottom:0;"><strong>ORDER #{{$orderid}}</strong></p>
								<table style="width:100%;">
									<tr>
										<td style="width:50%;">
											<p style="font-family: Arial;margin-bottom: 0px;text-align: left;text-transform: uppercase;color:#000;"><strong>BILLED TO:</strong></p>
											<p style="font-family: Arial;text-align: left;line-height: 18px;color: #7b7a7a;margin-top: 5px;">{{$payee_name}} <br>{{$buyeraddress}}</p>
										</td>
										<td style="width:50%;">
											<p style="font-family: Arial;margin-bottom: 0px;text-align: right;text-transform: uppercase;color:#000;"><strong>PAYMENT METHOD:</strong></p>
											<p style="font-family: Arial;text-align: right;line-height: 18px;color: #7b7a7a;margin-top: 5px;">{{$buyerpaymethod}}</p>
										</td>
									</tr>
								</table>
								
								<div style="padding-bottom:6px;">
									<hr>
								</div>

								<table style="width:100%;">
									<tr style="padding-bottom:2px;">
										<td style="width:50%;">
											<p style="font-family: Arial;text-align:left;text-transform: uppercase;color:#000;margin-bottom:0;"><strong>Subtotal:</strong></p>
										</td>
										<td style="width:50%;">
											<p style="font-family: Arial;text-align:right;margin-bottom:0;"><strong>${{$total}}</strong></p>
										</td>
									</tr>
								@if(!empty($couponcode))
									<tr style="padding-bottom:2px;">
										<td style="width:50%;">
											<p style="font-family: Arial;text-align:left;text-transform: uppercase;margin-bottom:0;"><strong>{{$coupon_type == 1?'Gift Card':'Promotional Coupon'}}:</strong></p>
										</td>
										<td style="width:50%;">
											<p style="font-family: Arial;text-align:right;margin-bottom:0;"><strong>-${{$discount}}</strong></p>
										</td>
									</tr>
								@endif
								@php
									$buyertax = 0;
								@endphp
								@if(!empty($buyer_tax))
									@php
										$buyertax = $buyer_tax;
									@endphp
									<tr style="padding-bottom:2px;">
										<td style="width:50%;">
											<p style="font-family: Arial;text-align:left;text-transform: uppercase;margin-bottom:0;"><strong>Tax:</strong></p>
										</td>
										<td style="width:50%;">
											<p style="font-family: Arial;text-align:right;margin-bottom:0;"><strong>${{number_format((float)$buyer_tax, 2, '.', '')}}</strong></p>
										</td>
									</tr>
								@endif
									<tr style="padding-bottom:2px;">
										<td style="width:50%;">
											<p style="font-family: Arial;text-align:left;text-transform: uppercase;margin-bottom:0;"><strong>Total:</strong></p>
										</td>
										<td style="width:50%;">
											<p style="font-family: Arial;text-align:right;margin-bottom:0;"><strong>${{number_format((float)$paid+$buyertax, 2, '.', '')}}</strong></p>
										</td>
									</tr>
								</table>

								<div style="clear:both;padding-top:6px;padding-bottom:6px;">
									<hr>
								</div>
								<div style="">
									<p style="font-family: Arial;font-size:14px;text-align:right;margin-bottom:0;">
										<a href="{{$invoiceurl}}" style="font-size:14px;color: #306eba">View Your Receipt</a>
									</p>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td style="padding: 30px 15px 20px;">
							<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
								<!-- <tr>
									<td align="center" style="padding-top: 10px;padding-bottom: 10px;font-family: Arial;font-size: 16px;color:#242424;">Team Classroom Copy</td>
								</tr> -->
								<tr>
									<td><hr></td>
								</tr>
								<tr>
									<td align="center">
										<a href="{{url('/')}}" target="_blank"  style="text-decoration: none;">
											<img src="{{asset('images/logo.png')}}" width="150" style="margin-top: 10px;">
										</a>
									</td>
								</tr>
								
								<tr>
									<td align="center" style="padding-top: 10px;padding-bottom: 10px;font-size: 14px;">PO Box 7005, Southport Park, Qld, Australia 4215</td>
								</tr>
								<tr>
									<td align="center">
										<a href="https://www.facebook.com/ClassroomCopy" target="_blank"  style="text-decoration: none;padding-left:5px;padding-right: 5px;">
											<img src="{{asset('images/emailer-facebook.png')}}" alt="facebook" width="24" height="24">
										</a>
										<a href="https://www.instagram.com/classroomcopy/ " target="_blank" style="text-decoration: none;padding-left:5px;padding-right: 5px;">
											<img src="{{asset('images/emailer-instagram.png')}}" alt="facebook" width="24" height="24">
										</a>
										<a href="https://www.linkedin.com/company/classroom-copy" target="_blank" style="text-decoration: none;padding-left:5px;padding-right: 5px;">
											<img src="{{asset('images/emailer-linkedin.png')}}" alt="facebook" width="24" height="24">
										</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>       
</body>
</html>