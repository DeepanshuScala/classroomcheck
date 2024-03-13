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
			<table border="0" cellpadding="15" cellspacing="0" style="width: 100%;padding-top: 50px;padding-left: 10px;">
				<tr align="center">
					<td>
						<p  style="font-family: Arial; font-size: 16px; font-weight:700;">A little something for you from <span style="color:#306eba;">{{$sendername}}</span>.</p>
					</td>
				</tr>
                <tr align="center">
                    <td style="display: inline-block; width:400px; height:232px; background-image: url('{{asset("images/gift-box.png")}}'); background-repeat: no-repeat;padding-left: 0; padding-right: 0;">
                        <p style="font-size: 30px; text-align: right; padding-right: 24px; margin-top: 10px;">${{$amount}}</p>
                        <p style="background-color: #c00000; color: #fff; width: 379px; margin-right: 4px;font-family: Arial;font-size: 14px;line-height: 20px; margin-top: 12%;">Code: {{ $giftCode }}</p>
                    </td>
                </tr>
                <tr align="center">
                    <td>
                        <p style="font-family: Arial;font-size: 16px; margin-top: 0px;"><strong>"{{ $content }}"<br>{{$sendername}}</strong></p>
                        <p style="font-family: Arial;font-size: 16px; margin-top: 30px; margin-bottom: 30px; color:#242424;">Simply enter your gift card code in the “Use Gift Card” area at checkout.</p>
                        <a href="{{url('/')}}" style="display: inline-block; background-color: #306eba; color: #fff !important; padding: 8px 16px; text-decoration: none; font-size: 16px; border-radius: 30px;">Shop Now</a>
                    </td>
                </tr>
                <tr align="left">
                    <td>
                        <ul style="margin-bottom: 0px;">
                            <li style="font-family: Arial;font-size: 16px;color:#242424; padding-bottom: 5px;">Card balance remains on the card and is not applied as a credit to your account.</li>
                            <li style="font-family: Arial;font-size: 16px;color:#242424;">Discount codes cannot be applied to gift card purchases.</li>
                        </ul>
                    </td>
                </tr>
                <tr>
					<td style="padding: 30px 15px 20px;">
					<table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
						<tr>
						<td align="center" style="padding-top: 10px;padding-bottom: 10px;font-family: Arial;font-size: 16px;color:#242424;">Team Classroom Copy</td>
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