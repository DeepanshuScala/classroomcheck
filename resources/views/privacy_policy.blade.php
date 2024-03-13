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
<!--Privacy Policy Section Starts Here-->
    <section class="privacy-policy-section py-5">
        <div class="container">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="text-uppercase pt-0 pb-3">Privacy Policy </h1>
                <p>Classroom Copy Pty Ltd (also known as Classroom Copy) is committed to providing quality services to you and this policy outlines our ongoing obligations to you in respect of how we manage your Personal Information.</p>
                <p>We have adopted the Australian Privacy Principles (APPs) contained in the Privacy Act 1988 (Cth) (the Privacy Act). The NPPs govern the way in which we collect, use, disclose, store, secure and dispose of your Personal Information.
                </p>
                <p>A copy of the Australian Privacy Principles may be obtained from the website of The Office of the Australian Information Commissioner at <a href="www.aoic.gov.au" target="_blank" class="blue fw-bold"> www.aoic.gov.au</a>
                </p>

                <h1 class="text-uppercase py-3">WHAT IS PERSONAL INFORMATION AND WHY DO WE COLLECT IT?</h1>
                <p>Personal Information is information or an opinion that identifies an individual. Examples of Personal Information we collect include names, addresses, email addresses, phone, and facsimile numbers.</p>
                <p>This Personal Information is obtained in many ways including correspondence, by telephone and facsimile, by email, via our website <a href="www.classroomcopy.com" target="_blank" class="blue fw-bold">www.classroomcopy.com</a>, from cookies
                    and from third parties. We don’t guarantee website links or policy of authorised third parties.</p>
                <p>We collect your Personal Information for the primary purpose of providing our services to you, providing information to our clients and marketing. We may also use your Personal Information for secondary purposes closely related to the
                    primary purpose, in circumstances where you would reasonably expect such use or disclosure. You may unsubscribe from our mailing/marketing lists at any time by contacting us in writing or via your Account Dashboard..
                </p>
                <p>When we collect Personal Information, we will, where appropriate and where possible, explain to you why we are collecting the information and how we plan to use it.</p>

                <h1 class="text-uppercase py-3">THIRD PARTIES</h1>
                <p>Where reasonable and practical to do so, we will collect your Personal Information only from you. However, in some circumstances we may be provided with information by third parties. In such a case we will take reasonable steps to ensure
                    that you are made aware of the information provided to us by the third party.
                </p>

                <h1 class="text-uppercase py-3">DISCLOSURE OF PERSONAL INFORMATION</h1>
                <p>Where reasonable and practical to do so, we will collect your Personal Information only from you. However, in some circumstances we may be provided with information by third parties. In such a case we will take reasonable steps to ensure
                    that you are made aware of the information provided to us by the third party.
                </p>
                <ul class="ps-3">
                    <li>Third parties where you consent to the use or disclosure; and</li>
                    <li>Where required or authorised by law.
                    </li>
                </ul>

                <h1 class=" text-uppercase py-3 ">SECURITY OF PERSONAL INFORMATION</h1>
                <p>Your Personal Information is stored in a manner that reasonably protects it from misuse and loss and from unauthorized access, modification or disclosure.</p>

                <p> When your Personal Information is no longer needed for the purpose for which it was obtained, we will take reasonable steps to destroy or permanently de-identify your Personal Information. However, most of the Personal Information is or
                    will be stored in client files which will be kept by us for a minimum of 7 years.
                </p>

                <h1 class="text-uppercase py-3 ">ACCESS TO YOUR PERSONAL INFORMATION</h1>
                <p>You may access the Personal Information we hold about you and to update and/or correct it, subject to certain exceptions. If you wish to access your Personal Information, please contact us in writing. Classroom Copy Pty Ltd (also known
                    as Classroom Copy) will not charge any fee for your access request but may charge an administrative fee for providing a copy of your Personal Information. In order to protect your Personal Information, we may require identification
                    from you before releasing the requested information.
                </p>
                <h1 class="text-uppercase py-3 ">MAINTAINING THE QUALITY OF YOUR PERSONAL INFORMATION</h1>
                <p>It is an important to us that your Personal Information is up to date. We will take reasonable steps to make sure that your Personal Information is accurate, complete, and up to date. If you find that the information we have is not up
                    to date or is inaccurate, please advise us as soon as practical so we can update our records and ensure we can continue to provide quality services to you.
                </p>
                <h1 class="text-uppercase py-3 ">POLICY UPDATES</h1>
                <p>This Policy may change from time to time and is available on our website.</p>

                <h1>PRIVACY POLICY COMPLAINTS AND ENQUIRIES</h1>
                <p>If you have any queries or complaints about our Privacy Policy, please contact us at:<br> <a href="mailto:support@classroomcopy.com " class="blue fw-bold ">support@classroomcopy.com</a>
                </p>





            </div>

        </div>
    </section>

    <!--Privacy Policy Section Ends Here-->
@endsection


