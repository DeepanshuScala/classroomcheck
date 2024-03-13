@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@if(!auth()->user())
    @section('breadcrub_section')
        <section class="breadcrumb-section bg-light-blue pt-2">
            <div class="container py-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @if(isset($data['home']) && $data['home'])
                            <li class="breadcrumb-item active"><a href="{{route('classroom.index')}}"><i class='fal fa-home-alt'></i> {{$data['home']}}</a></li>
                        @endif
                        @if(isset($data['breadcrumb1']) && $data['breadcrumb1'])
                            <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb1']}}</li>
                        @endif
                        @if(isset($data['breadcrumb2']) && $data['breadcrumb2'])
                            <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb2']}}</li>
                        @endif
                        @if(isset($data['breadcrumb3']) && $data['breadcrumb3'])
                            <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb3']}}</li>
                        @endif
                        @if(isset($data['breadcrumb4']) && $data['breadcrumb4'])
                            <li class="breadcrumb-item" aria-current="page">{{$data['breadcrumb4']}}</li>
                        @endif

                    </ol>
                </nav>
            </div>
        </section>
    @endsection('breadcrub_section')
@endif

@section('content')
    <!--Seller Agreement Section Starts Here-->
    <section class="seller-agreement-section py-5">
        <div class="container">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="text-uppercase pt-0 pb-3">Seller Agreement</h1>
                <h5>GENERAL TERMS</h5>
                <p>This Classroom Copy Seller Agreement (the "agreement") contains the terms and conditions that govern your access to and use of the Sellers Control Panel and is an agreement between you or the business you represent and Classroom Copy.
                    By registering for or using the Sellers Control Panel, you (on behalf of yourself or the business you represent) agree to be bound by the terms of this agreement, including the service terms and program policies that apply for each
                    country for which you register or elect to use a service (in each case, the "elected country").
                </p>
                <p>As used in this Agreement, "we," "us," and "Classroom Copy" means Classroom Copy Pty Ltd, and "you" means the applicant (if registering for or using a Service as an individual), or the business employing the applicant (if registering for
                    or using a Service as a business) and any of its Affiliates. If there is any conflict between these General Terms and the applicable Service Terms and Program Policies, the General Terms will govern and the applicable Service Terms
                    will prevail over the Program Policies.
                </p>

                <h5>REGISTERING TO SELL</h5>
                <p>To begin the process, you must complete the registration process for one or more of the Services. Use of the Services is limited to parties that can lawfully enter into and form contracts under applicable Law. As part of the application,
                    you must provide us with your (or your business') legal name, address, phone number and e-mail address, as well as any other information we may request. Any personal data you provide to us will be handled in accordance with Classroom
                    Copy’s Privacy Policy</p>

                <h5>PASSWORD SECURITY</h5>
                <p>Any password we provide to you may be used only during the Term to access your Classroom Copy Account (or other tools we provide, as applicable) to use the Services. You are solely responsible for maintaining the security of your password.
                    You may not disclose your password to any third party (other than third parties authorized by you to use your account in accordance with this Agreement) and are solely responsible for any use of or action taken under your password.
                    If your password is compromised, you must immediately change your password.
                </p>
                <h5>SELLER FEES AND PAYOUT RATES </h5>
                <p>Classroom Copy offers one Membership option. All members can make purchases and download free Resources from Classroom Copy. Only Sellers can upload, share, and sell Resources. The Classroom Copy Payout Rate, Fees, and features that apply
                    to Sellers are detailed below. The Payout Rates specified in the table below apply only to sales taking place on Classroom Copy. This Seller Fees and Payout Rates policy is incorporated as part of our Terms of Service. Seller Fees
                    and Payout rates are subject to change with 14 days’ notice.</p>


                <div class="payout-rates w-50 mx-auto py-5">
                    <table width="100%" class="table ">
                        <tbody>
                            <tr class="mb-2 bg-danger p-2 text-dark bg-opacity-5">
                                <th scope="row" class="blue w-50 ps-5">Membership Fee</th>
                                <td class="text-muted fw-bold w-50">FREE</td>

                            </tr>
                            <tr class="mb-2 bg-success p-2 text-dark bg-opacity-5">
                                <th scope="row" class="blue w-50 ps-5">Payout Rate</th>
                                <td class="text-muted fw-bold w-50">85% on all sales</td>

                            </tr>
                            <tr class="mb-2 bg-primary p-2 text-dark bg-opacity-5">
                                <th scope="row" class="blue w-50 ps-5">Transaction Fees</th>
                                <td class="text-muted fw-bold w-50">15 cents per transaction</td>

                                <tr class=" mb-2 bg-warning p-2 text-dark bg-opacity-5 ">
                                    <th scope="row" class="blue w-50 ps-5">Max Uploads</th>
                                    <td class="text-muted fw-bold w-50">Unlimited</td>

                                </tr>
                                <tr class="mb-2 bg-danger p-2 text-dark bg-opacity-5">
                                    <th scope="row" class="blue w-50 ps-5">File Size Upload</th>
                                    <td class="text-muted fw-bold w-50">1GB</td>

                                </tr>
                            </tr>
                            <tr class="mb-2 bg-success p-2 text-dark bg-opacity-5">
                                <th scope="row" class="blue w-50 ps-5">Video Uploads</th>
                                <td class="text-muted fw-bold w-50">Yes</td>

                            </tr>
                        </tbody>
                    </table>
                </div>


                <h5>PAYMENT PROCESSING </h5>
                <p>Classroom Copy uses the Stripe third party payment gateway for financial services on our Services. For all orders, you authorize the Classroom Copy Payment Agent (Stripe) to act as your agent for purposes of processing payments, refunds
                    and adjustments for Your Transactions, receiving and holding Sales Proceeds on your behalf, remitting Sales Proceeds to Your Bank Account, charging your Credit Card, and paying Classroom Copy and its Affiliates amounts you owe in accordance
                    with this Agreement or other agreements you may have with Classroom Copy Affiliates. When a buyer instructs us to pay you, you agree that the buyer authorizes and orders us to commit the buyer's payment (less any applicable fees or
                    other amounts we may collect under this Agreement) to you. You agree that buyers satisfy their obligations to you for Your Transactions when we receive the Sales Proceeds. We will remit funds to you in accordance with this Agreement.
                </p>
                <h5>REMITTANCE </h5>
                <p>Subject to the General Terms of this Agreement, the Classroom Copy Payments Agent will remit funds to you in accordance with the Agreement and these Transaction Processing Service Terms. The Classroom Copy Payments Agent’s obligation to
                    remit funds collected or received by it or otherwise credited to your available balance in connection with Your Transactions is in accordance with this Agreement and amounts owed to Classroom Copy and any taxes that Classroom Copy
                    automatically calculates, collects, and remits to a tax authority according to applicable law, as specified in the Tax Policies.
                </p>
                <h5>YOUR FUNDS </h5>
                <p>Your Sales Proceeds will be held in an account with the Classroom Copy Payments Agent (a "Seller Account") and will represent an unsecured claim against the Classroom Copy Payments Agent. You do you have any right or entitlement to collect
                    Sales Proceeds directly from any customer.</p>

                <div class="text-center col-12 "><button type="button " class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover ">View More </div>


            </div>

        </div>
    </section>
<!--Seller Agreement Ends Here-->
@endsection


