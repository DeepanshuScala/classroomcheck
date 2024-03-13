<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Classroomcopy Invioce</title>
        <style>
          @page{
            margin:0px;
          }
        
          
          * {
            box-sizing: border-box;
          }

          .table-bordered td,
          .table-bordered th {
            border: 1px solid #ddd;
            word-break: break-all;
          }

          body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
            font-weight: normal;
          }
          .h4-14 h4 {
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 5px;
          }
          .img {
            margin-left: "auto";
            margin-top: "auto";
            height: 30px;
          }
          pre,
          p {
            /* width: 99%; */
            /* overflow: auto; */
            /* bpicklist: 1px solid #aaa; */
            padding: 0;
            margin: 0;
          }
          table {
            font-family: arial, sans-serif;
            width: 100%;
            border-collapse: collapse;
          }
          .hm-p p {
            text-align: left;
            padding: 1px;
            padding: 5px 4px;
          }
          td,
          th {
            text-align: left;
          }
          .table-b td,
          .table-b th {
            border: 1px solid #cfcfcf;
          }
          th {
            /* background-color: #ddd; */
          }
          .hm-p td,
          .hm-p th {
            padding: 3px 0px;
          }
          .cropped {
            float: right;
            margin-bottom: 20px;
            height: 100px; /* height of container */
            overflow: hidden;
          }
          .cropped img {
            width: 400px;
            margin: 8px 0px 0px 80px;
          }
          .main-pd-wrapper {
            box-shadow: 0 0 10px #cfcfcf;
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
          }
          .table-bordered td,
          .table-bordered th {
            border: 0px solid #cfcfcf;
            font-size: 14px;
          }
           .border th, .border td{
            border: 1px solid #cfcfcf !important;
          } 
          .border-tb td, .border-tb th{
            border: 1px solid #cfcfcf !important;
          } 
        </style>
    </head>
    <body>
    <div id="invoice">
      <table style="width: 100%; table-layout: fixed">
        <tr>
          <td>
            <table style="border: 1px solid #cfcfcf;">
              <tr>
                <td>
                  <table>
                    <tr>
                      <td style="text-align: center;padding: 0;">
                          <img src="{{asset('images/logo-invoice.png')}}" alt="logo" style="width: 100%;" />
                          <!-- <img src="https://classroomcopy.com/home/public/images/logo-invoice.png" alt="logo" style="width: 100%;" /> -->
                      </td>
                    </tr>
                  </table>
                  <table>
                    <tr>
                      <td style="padding-left:20px;padding-right:20px;padding-bottom: 50px;">
                        <table class="table table-bordered h4-14" style="width: 100%;padding-top: 10px; -fs-table-paginate: paginate;">
                          <thead style="display: table-header-group">
                              <tr valign="top" style="margin: 0;-webkit-print-color-adjust: exact;">
                                <td style="width:22%;word-break: normal;">
                                  <h3 style="margin-bottom: 5px; margin-top: 0px">Billing Information</h3>
                                  <p style="color: rgb(87, 87, 87)">{{$payee_name}}<br>{{$buyeraddress}}</p>
                                </td>
                                <td style="width: 78%;text-align: right;">
                                  <h3 style="margin-bottom: 5px; margin-top: 0px">Invoice Number</h3>
                                  <p style="color: rgb(87, 87, 87)">{{$orderid}}</p>
              
                                  <h3 style="margin-bottom: 5px; margin-top: 8px">Invoice Date</h3>
                                  <p style="color: rgb(87, 87, 87)">{{$date}}</p>
              
                                  <h3 style="margin-bottom: 5px; margin-top: 8px">Order Status</h3>
                                  <p style="color: rgb(87, 87, 87)">Paid</p>
                                </td>
                              </tr>
                          </thead>
                      </table>
                      <table  style="width: 100%;-fs-table-paginate: paginate;margin-top:0px;margin-bottom:20px;">
                        <tr>
                          <td style="padding-top:50px;">
                            <table>
                              <tr>
                                <td>
                                  <table class="table border-tb">
                                    <thead style="display: table-header-group">
                                      <tr style="background-color: #e7e6e6;-webkit-print-color-adjust:exact;">
                                          <th style="width:138px !important;padding: 10px;"><h4 style="margin:0px;">Product No.</h4></th>
                                          <th style="padding: 10px;"><h4 style="margin:0px;">Product Name</h4></th>
                                          <th style="width:100px !important;padding: 10px;text-align:right;"><h4 style="margin:0px;">Quantity</h4></th>
                                          <th style="width:100px !important;padding: 10px;text-align:right;"><h4 style="margin:0px;">Total Price</h4></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $pr)
                                            <tr>
                                                <td style="width:138px !important;padding: 10px;">{{$orderid}}</td>
                                                <td style="padding: 10px;">{{$pr['name']}}</td>
                                                <td style="width:100px !important;padding: 10px;text-align:right;">{{$pr['quantity']}} @ ${{$pr['price']}}</td>
                                                <td style="width:100px !important;padding: 10px;text-align:right;">${{$pr['amount']}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <table>
                        <tr>
                          <td>
                            <table class="hm-p table-bordered border" style="width: 40%!important; margin-left:auto;">
                              <tr>
                                  <th style="padding:10px 12px;text-align: right;border:none !important;">Sub-Total</th>
                                  <td style="vertical-align: top;text-align: right; color: #000; padding:10px 13px;">
                                    ${{$total}}
                                  </td>
                              </tr>
                              @if(!empty($couponcode))
                              <tr>
                                <th style="padding:10px 12px;text-align: right;border:none !important;">{{$coupon_type == 1?'Gift Card':'Promotional Coupon'}}</th>
                                <td style="vertical-align: top;text-align: right; color: #000;padding:10px 13px;">
                                  -${{number_format((float)$discount, 2, '.', '')}}
                                </td>
                              </tr>
                              @endif
                              @php
                              $buyertax = 0;
                              @endphp
                              @if(isset($buyer_tax) && !empty($buyer_tax))
                                @php
                                  $buyertax = $buyer_tax;
                                @endphp
                                <tr>
                                    <th style="padding:10px 12px;text-align: right;border:none !important;">Sales Tax</th>
                                    <td style="vertical-align: top;text-align: right; color: #000;padding:10px 13px;">
                                      ${{number_format((float)$buyer_tax, 2, '.', '')}}
                                    </td>
                                </tr>
                              @endif
                              <tr>
                                  <th style="padding:10px 12px;text-align: right;border:none !important;">
                                    <b>Total</b>
                                  </th>
                                  <td style="vertical-align: top;text-align: right; color: #000;padding:10px 13px;">
                                    <b>${{number_format((float)$paid+$buyertax, 2, '.', '')}} AUD</b>
                                  </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                      <table style="margin-top: 70px;">
                        <tr>
                          <td>
                            <table>
                              <tr>
                                <td><hr style="border:2px solid #ddd"></td>
                              </tr>
                              <tr>
                                <td style="text-align: center;padding-top: 10px;">
                                  <a href="{{url('/')}}" target="_blank"  style="text-decoration: none;">
                                    <img src="{{asset('images/logo.png')}}" width="150" style="margin-top: 10px;">
                                    <!-- <img src="https://classroomcopy.com/home/public/images/logo.png" width="150"> -->
                                  </a>
                                </td>
                              </tr>
                              
                              <tr>
                                <td style="font-size: 14px; font-weight: normal; text-align: center;">PO Box 7005, Southport Park, Qld, Australia 4215</td>
                              </tr>
                              <tr>
                                <td style="text-align: center;padding-top: 20px;">
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
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
    </body>
</html>