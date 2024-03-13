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
			<table border="0" cellpadding="15" cellspacing="0" style="width: 100%;padding-top: 50px;padding-left:20px;padding-right:20px;">
				<tr>
					<td align="center">
						<p style="font-family: Arial;font-size: 18px;color:#306eba;text-transform: uppercase; ">Congratulations!</p>
						<p  style="font-family:Arial; font-size:16px; line-height:18px; color:#242424;">You sold a product through Classroom Copy. <br>
							For more information, please view <a href="{{route('storeDashboard.reports.salesReport')}}" style="color: #306eba;">My Sales Reports</a></p>
					</td>
				</tr>
				@foreach($product as $l)
					<tr>
						<td align="left">
							<table style="width:100%;">
								<tr valign="top">
									<td style="width: 25%;">
										<img src="{{$l['productimage']}}" alt="" style="max-width: 100%;">
									</td>
									<td style="width: 50%;padding-left: 20px;">
										<p style="font-family: Arial;font-size: 16px;color:#242424;font-weight:700;text-align: left;">Resource #{{$l['productid']}}</p>
										<p style="font-family: Arial;font-size: 16px;color:#242424;text-align: left;font-weight:normal;">{{$l['productname']}}</p>
									</td>
									<td style="width: 25%;">
										<p style="font-family: Arial;font-size: 16px;color:#242424;font-weight:700;text-align:right;">Total: ${{$l['totalprice']}}</p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				@endforeach
				<tr>
					<td style="padding: 30px 15px 20px;">
						<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
							<tr>
								<td align="center" style="padding-top: 10px; padding-bottom: 10px; font-family: Arial; font-size: 16px;color:#242424;">Team Classroom Copy</td>
							</tr>
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