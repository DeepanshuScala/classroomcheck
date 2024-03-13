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
				.uM2yb{
					background-color: transparent !important;
					color:transparent !important;
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
						<p style="font-family: Arial;font-size: 18px;color:#306eba;text-transform: uppercase;">{{!$new?"YOU'VE UPDATED YOUR STORE":'CONGRATULATIONS ON YOUR NEW STORE'}}</p>
						<p style="font-family:Arial; font-size:16px; color:#242424; text-align:left;margin-bottom:0;">{{!$new?'Congratulations on your new store details. Please find below your new store details.':"We are thrilled to welcome you to Classroom Copy and appreciate you taking the time set up your online store."}}</p>
						
					</td>
				</tr>
				<tr>
					<td>
						<div style="background-color: #4f88ce; padding:10px 10px;">
                            <table>
                                <tr>
                                    <td style="width:25%;font-family:Arial; font-size:16px; line-height:18px; color:#fff;padding-right: 30px;">
                                        Store Name:
                                    </td>
                                    <td style="width:75%;font-family:Arial; font-size:16px; line-height:18px; color:#fff;">
                                        {{ $storename }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:25%;font-family:Arial; font-size:16px; line-height:18px; color:#fff; padding-right: 20px;">
                                        Store URL:
                                    </td>
                                    <td style="width:75%;font-family:Arial; font-size:16px; line-height:18px; color:#fff;">
                                        <a href="{{ $storeurl }}" style="color:#fff !important;">{{ $storeurl }}</a>
                                    </td>
                                </tr>
                            </table>
						</div>
					</td>
				</tr>
				<tr>
                    <td align="left">
						<p style="font-family:Arial; font-size:16px; line-height:18px; color:#242424; text-align:left;margin-top: 10px;margin-bottom: 0px;">You can use this information to setup your STRIPE account and advertise your new business.</p>
                        <p style="font-family:Arial; font-size:16px; line-height:18px; color:#242424; text-align:left;">If you have any questions or feedback, please don't hesitate to reach out to our <a href="{{url('/contact-us')}}" style="text-decoration:underline;color:#000 !important;">customer support team</a></p>
                        <p style="font-family:Arial; font-size:16px; line-height:18px; color:#242424; text-align:left;">We hope you enjoy your experience on <a href="{{url('/')}}" style="color:#000 !important;">classroomcopy.com</a></p>
                        <p style="font-family:Arial; font-size:16px; line-height:18px; color:#242424; text-align:left;">Thanks again for joining us!</p>
					</td>
                </tr>
				
				<tr>
					<td style="padding: 30px 15px 20px;">
						<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
							<tr>
								<td style="padding-top: 10px;padding-bottom: 10px;font-family: Arial;font-size: 16px;color:#242424;">Team Classroom Copy</td>
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
								<td align="center" style="padding-top: 10px;padding-bottom: 10px;font-size: 14px;color:#242424;">PO Box 7005, Southport Park, Qld, Australia 4215</td>
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