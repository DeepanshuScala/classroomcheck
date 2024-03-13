@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Suggest A Resource resource Section Starts Here-->
<section class="gift_card_section suggest_resource pb-5">
    <div class="container">

        <div class="row flex-lg-row-reverse align-items-start g-4">
            <div class="col-12 col-sm-12 col-lg-6 pt-5">
                <div class="text-end pb-5">
                    <a href="{{ URL('dashboard/account') }}" class="blue acc-dashboard">
                        <img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1" alt="">Account Dashboard
                    </a>
                </div>
                <img src="{{asset('images/suggest-a-resource.jpg')}}" class="d-block mx-lg-auto img-fluid mb-3" alt="suggest-a-resource">

            </div>

            <div class="col-lg-6 col-sm-12 my-0 py-4">
                <h1 class="text-uppercase pt-5">
                    Suggest a Resource
                </h1>

                <p class="pb-3 ">Tell us what you would like to see more of.</p>

                <form class="pb-5" action="" method="post" name="suggestResourceForm" id="suggestResourceForm">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">Name:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control bg-light" id="name" name="name" placeholder="Name" required="" value="{{ old('name') }}">
                        </div>
                    </div>

                    <div class=" row mb-3">
                        <label for="email" class="col-sm-3 col-form-label">Email Address :</label>
                        <div class="col-sm-9">
                            <input type="email " class="form-control bg-light" id="email" name="email" placeholder="Email" required="" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="grade_id" class="col-sm-3 col-form-label">Grade:</label>
                        <div class="col-sm-9 ">
                            <select id="grade_id" class="form-select bg-light" name="grade_id" required="">
                                <option selected value="" disabled="">Select Grade</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="subject_id" class="col-sm-3 col-form-label">Subject:</label>
                        <div class="col-sm-9 ">
                            <select id="subject_id" name="subject_id" class="form-select bg-light" required="">
                                <option selected value="" disabled="">Select Subject</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 ">
                        <label for="resource_id" class="col-sm-3 col-form-label">Resource Type:</label>
                        <div class="col-sm-9 ">
                            <select id="resource_id" name="resource_id" class="form-select bg-light" required="">
                                <option selected value="" disabled="">Select Resource</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="description" class="col-sm-3 col-form-label">Description:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control bg-light" id="description" rows="3" placeholder="Description" name="description">{{ old('description') }}</textarea>
                            <div class="text-end blue character py-2">500 Character Max.</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="other_description" class="col-sm-3 col-form-label ">Other:</label>
                        <div class="col-sm-9">
                            <textarea class="form-control bg-light" id="other_description" name="other_description" rows="3" placeholder="Other">{{ old('other_description') }}</textarea>
                            <div class="text-end blue character py-2">500 Character Max.</div>
                        </div>
                    </div>

                    <input type="submit" class="btn bg-blue text-white float-end submit-btn text-uppercase" id="suggestResourceBtn" name="suggestResourceBtn" value="Submit">
                </form>
            </div>
        </div>
    </div>
</section>
<!--Suggest A Resource Ends Section Ends Here-->
@endsection