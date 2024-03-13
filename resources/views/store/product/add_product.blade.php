@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<?php
?>
<!--Add Product Starts Here-->  
<section class="inner_page">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="inner_page_title">
                    <h1>Add Product To Your Store</h1>
                </div>
            </div>
            <div class="col-md-4">
                <div class="store-dashboard my-md-0 my-3">
                    <a href="{{route('storeDashboard.productDashboard')}}">
                        <img src="{{asset('images/store-icon.png')}}" class="img-fluid me-1 my-1"> Product Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="add_product_section">
    <div class="container">
        <!--Form Section Starts Here-->
        <form class=" g-3 pt-2 pb-5 " action="{{route('storeDashboard.addProduct.post')}}" name="addProductForm" id="addProductForm" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="inputProduct-title" class="form-label fw-bold float-start">Product Title</label>
                        </div>
                        <div class="col-md-9 col-12">
                            <input type="text" class="form-control bg-light" name="product_title" id="inputProduct-title" value="{{old('product_title')}}" placeholder="Name your product">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="textareaDescription" class="form-label fw-bold float-start">Description</label>
                        </div>
                        <div class="col-md-9 col-12">
                            <textarea class="form-control bg-light" name="description" id="textareaDescription" rows="3" placeholder="Describe your product and its benefits for other educators.">{{old('description')}}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="language" class="form-label fw-bold d-flex float-start">Language</label>
                        </div>
                        <div class="col-md-9 col-12" id="language-div">
                            <select class="form-select select2 bg-light" name="language" id="language">
                                <option value="" selected disabled>Select Language</option>
                                <?php
                                $languageArr = (new App\Http\Helper\ClassroomCopyHelper())->getLanguages();
                                ?>
                                @foreach($languageArr as $lang)
                                <option value="{{$lang->id}}" {{ old('language') == $lang->id? 'selected':'' }}>{{$lang->language}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div> 
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="language" class="form-label fw-bold d-flex float-start">Resource Type</label>
                        </div>
                        <div class="col-md-9 col-12" id="resource_type-div">
                            <select class="form-select select2 bg-light" name="resource_type[]" id="resource_type" multiple data-placeholder="Select Resource Type">
                                <option value="" disabled>Select Resource Type</option>
                                <?php
                                $resourceArr = (new App\Http\Helper\ClassroomCopyHelper())->getResourceTypes();
                                ?>
                                @foreach($resourceArr as $resource)
                                <option value="{{$resource->id}}" {{ old('resource_type') == $resource->id? 'selected':'' }}>{{$resource->name}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div> 
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="inputProduct" class="form-labe fw-bold d-flex flex-column float-start mb-0">Product Type
                                <a href="#" class="text-muted fs-6 fw-normal mb-0" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Supported File Types</a></label>
                        </div>
                        <div class="col-md-9 col-12" id="product_type-div">
                            <select class="form-select select2 bg-light" name="product_type" id="product_type">
                                <option value="" selected disabled>Select Product type</option>
                                <?php
                                $productFileTypeArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductType();
                                ?>
                                @foreach($productFileTypeArr as $productFileType)
                                <option value="{{$productFileType}}" {{ old('product_type') == $productFileType? 'selected':'' }}>{{$productFileType}}</option>
                                @endforeach
                            </select>
                        </div> 
                    </div> 
                </div> 
                <!--id="inputProduct"--> 
                    <!--                        <select class="form-select bg-light w-50" name="product_type" id="product_type">
                    <option value="" selected disabled>-Select Product type-</option>
                    <option value="Product Type 1" {{ old('product_type') == "Product Type 1"? 'selected':'' }}>Product Type 1</option>
                    <option value="Product Type 2" {{ old('product_type') == "Product Type 2"? 'selected':'' }} >Product Type 2</option>
                    <option value="Product Type 3" {{ old('product_type') == "Product Type 3"? 'selected':'' }} >Product Type 3</option>
                </select>-->
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Supported File Types</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5>Product File <span class="fs-6 text-muted">Up to 200 MB</span></h5>
                            <p>.doc, .docx, .xls, .xlsx, .ppt, .pptx,.txt, .rtf, .ps, .eps, .prn, .bmp, .jpeg, .gif, .tiff, .png, .pcx, .rle, .dib,.html, .wpd, .odt, .odp, .ods, .odg, .odf, .sxw, .sxi, .sxc, .sxd, .stw, .psd, .ai, .indd, .u3d, .prc,
                                .dwg, .dwt, .dxf, .dwf, .dst, .xps, .mpp,.vsd
                            </p>
                            <h5>Preview <span class="fs-6 text-muted">Up to 15 MB</span></h5>
                            <p>.pdf, .bmp, .gif, .jpg, .jpeg, .png, .ttf, .txt</p>
                            <h5>Video Preview <span class="fs-6 text-muted">Up to 500 MB</span></h5>
                            <p>.mp4, .mov, .wmv, .avi, .avchd, .flv, .f4V, .swf, .mkv, .mpeg-2</p>
                            <h5>Thumbnails <span class="fs-6 text-muted">Up to 5 MB</span></h5>
                            <p>.bmp, .gif, .jpg, .jpeg, .png, .ttf, .txt</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Done</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="selectLevel" class="form-label fw-bold float-start">Year Level</label>
                        </div>
                        <div class="col-md-9 col-12" id="year_level-div">
                            <select class="form-select bg-light select2" multiple name="year_level[]" id="year_level" data-placeholder="Select Up to Four Year Levels or ‘Non-Specific Grade’">
                                <option value="" disabled>Select Up to Four Year Levels or ‘Non-Specific Grade’</option>
                                <?php
                                $levelArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductLevel();
                                ?>
                                @foreach($levelArr as $level)
                                <option value="{{$level->id}}" {{ old('year_level') == $level->id ? 'selected' : '' }} >{{$level->grade}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row ">
                        <?php
                        $subjectAreaArr = (new App\Http\Helper\ClassroomCopyHelper())->getProductSubjectArea();
                        ?>
                        <div class="col-md-2 col-12">
                            <label for="selectStandards" class="form-label fw-bold float-start mt-0 mt-md-3">Subject Area</label>
                        </div>
                        <div class="col-md-9 col-12 " id="subject_area-div">
                            <select class="form-select select2 bg-light" name="subject_area" id="subject_area">
                                <option value="" selected disabled>Please select subject area</option>
                                @foreach($subjectAreaArr as $SA)
                                <option value="{{$SA->id}}">{{$SA->name}}</option>
                                @endforeach
                            </select>
                            <select class="form-select select2 bg-light" name="subject_sub_area" id="subject_sub_area">
                                <option value="" selected disabled>Please select subject sub area</option>
                            </select>
                            <select class="form-select select2 bg-light" name="subject_sub_sub_area" id="subject_sub_sub_area">
                                <option value="" selected disabled>Please select subject sub area</option>
                            </select>


                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="selectCategory" class="form-label fw-bold float-start">Custom Category</label>
                        </div>
                        <div class="col-md-9 col-12">
                            <input type="text" class="form-control bg-light" name="custom_category" id="custom_category" value="{{old('custom_category')}}" placeholder="Enter custom category">
<!--                                <select class="form-select bg-light select2" name="custom_category" id="custom_category" placeholder="TBA">
                                <option value="" selected disabled>-Please select custom category- </option>
                                <option value="TCA" {{-- old('custom_category') == "Custom category 1"? 'selected':'' --}} >TCA</option>
                                <option value="ACA" {{-- old('custom_category') == "Custom category 2"? 'selected':'' --}} >ACA</option>
                                <option value="DCA" {{-- old('custom_category') == "Custom category 3"? 'selected':'' --}} >DCA</option>
                                <option value="ADC" {{-- old('custom_category') == "Custom category 4"? 'selected':'' --}} >ADC</option>
                              </select>-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="selectStandards" class="form-label fw-bold float-start">Standards / Outcomes</label>
                        </div>
                        <div class="col-md-9 col-12" id="outcome_country-div">
                            <div class="row" > 
                                <div class="col-md-6">
                                    <select id="outcome_country" name="outcome_country" class="noValue form-select country bg-light  me-2 float-start" placeholder="Select Country">
                                        <option value="" selected> Select Country </option>
                                    </select>
                                </div>
                                <div class="col-md-6 list-standards">
                                    <input type="text" class="form-control bg-light float-start" id="standard_outcome" name="standard_outcome" value="{{ old('standard_outcome') }}" placeholder="List standards / outcome codes">
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="selectTeachingDuration" class="form-label fw-bold float-start">Teaching Duration:</label>
                        </div>
                        <div class="col-md-9 col-12" id="teaching_duration-div">
                            <select class="form-select bg-light select2" placeholder="Select Duration" name="teaching_duration" id="teaching_duration">
                                <option value="" selected disabled>Please select teaching duration</option>
                                <?php
                                $teachingDurationArr = (new \App\Http\Helper\ClassroomCopyHelper)->getTimeDuration();
                                ?>
                                @foreach($teachingDurationArr as $teachingDuration)
                                <option value="{{$teachingDuration}}" {{ old('teaching_duration') == $teachingDuration? 'selected':'' }} >{{$teachingDuration}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="selectPages " class="form-label fw-bold float-start">No. of Pages /Slides:</label>
                        </div>
                        <div class="col-md-9 col-12">
                            <input type="text" class="form-control bg-light" name="no_of_pages_slides" id="no_of_pages_slides" value="{{old('no_of_pages_slides')}}" placeholder="Enter no. of pages / slides">
<!--                                <select class="form-select bg-light no-of-pages select2" name="no_of_pages_slides" id="no_of_pages_slides" placeholder="Total Pages or Slides ">
                                <option value="" selected disabled> Total Pages or Slides  </option>
                                <option value="10" {{-- old('no_of_pages_slides') == "10"? 'selected':'' --}} >10</option>
                                <option value="20" {{-- old('no_of_pages_slides') == "20"? 'selected':'' --}} >20</option>
                                <option value="25" {{-- old('no_of_pages_slides') == "25"? 'selected':'' --}} >25</option>
                                <option value="35" {{-- old('no_of_pages_slides') == "35"? 'selected':'' --}} >35</option>
                            </select>-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="selectAnswerkey" class="form-label fw-bold float-start">Answer Key:</label>
                        </div>
                        <div class="col-md-9 col-12" id="answer_key-div">
                            <select class="form-select bg-light pages-or-slides noValue" name="answer_key" id="answer_key" placeholder="Answer key">
                                <option value="" selected disabled> Does this resource require an answer key ?  </option>
                                <option value="yes" {{ old('answer_key') == "yes"? 'selected':'' }} >Yes</option>
                                <option value="no" {{ old('answer_key') == "no"? 'selected':'' }} >No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="pricing " class="form-label float-start"><h1 class="text-uppercase head">Pricing:</h1></label>
                        </div>
                        <div class="col-md-9 col-12">
                            <label class="form-label view-pricing float-start"><a href="javascript:void(0)" class="text-upperxase text-dark ">View Pricing Guide</a></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="License " class="form-label fw-bold float-start">License:</label>
                        </div>
                        <div class="col-md-9 col-12">
                            <div class=" form-check-inline ps-0">
                                <input type="radio" name="is_paid_or_free" id="is_paid_or_free" value="paid" onclick="show1();" />
                                <label class="form-check-label" for="flexRadioDefault">Paid</label>
                            </div>
                            <div class=" form-check-inline ps-0" id="isPaidOrFreeValidation">
                                <input type="radio" name="is_paid_or_free"id="is_paid_or_free" value="free" onclick="show2();" />
                                <label class="form-check-label " for="flexRadioDefault1">
                                    Free
                                </label>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div id="div1"class="hidden mb-3">
                <div class="row align-items-center" >
                    <div class="col-md-2">
                         <label for="inputLicense" class="form-label fw-bold">Single License:</label>
                    </div>
                   <div class="col-md-9 col-12">
                       <div class="row mb-3 align-items-center">
                           <div class="col-12 col-md-5">
                                <div class="input-group d-block bg-newGray">
                                    <div class="row ms-0">
                                        <div class="col-3 lic-paid">
                                            <span>AUD $</span>
                                        </div>
                                        <div class="col-9 ps-0">
                                            <input type="text" class="form-control bg-light border-r-left-0" name="single_license" id="inputLicense "  pattern="^\d*(\.\d{0,2})?$" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 46 && event.charCode <= 57">
                                        </div>
                                    </div>
                                    <!--<div class="input-group-prepend">-->
                                    <!--    <span class="input-group-text" id="basic-addon1">AUD $</span>-->
                                    <!--</div>-->
                                    
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                 <label for="multipleLicense" class="form-label fw-bold multiple-license">Multiple License:</label>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-group d-block  bg-newGray">
                                    <!--<div class="input-group-prepend">-->
                                    <!--    <span class="input-group-text" id="basic-addon1">AUD $</span>-->
                                    <!--</div>-->
                                    <div class="row ms-0">
                                        <div class="col-3 lic-paid">
                                            <span>AUD $</span>
                                        </div>
                                        <div class="col-9 ps-0">
                                            <input type="text" class="form-control license bg-light border-r-left-0 w-100" name="multiple_license"  id="multipleLicense"  pattern="^\d*(\.\d{0,2})?$" onkeypress="return (event.charCode == 8 || event.charCode == 0) ? null : event.charCode >= 46 && event.charCode <= 57">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                       </div>
                   </div>
                    
                   
                    
                </div>
           </div>
           <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row align-items-center">
                        <div class="col-md-2 col-12">
                            <label for="inputTaxcode" class="form-label fw-bold float-start">Tax Code:</label>
                        </div>
                        <div class="col-md-9 col-12">
                            <input type="text" class="form-control bg-light" id="tax_code" name="tax_code" value="{{ old('tax_code') }}" placeholder="TBA ">
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="col-12 col-sm-12 col-md-12 col-lg-12">-->
            <!--    <label for="inputTaxcode " class="form-label w-25 fw-bold float-start">Tax Code:</label>-->
            <!--    <input type="text" class="form-control bg-light w-75" id="tax_code" name="tax_code" value="{{ old('tax_code') }}" placeholder="TBA ">-->
            <!--</div>-->


            <div class="row ">
                <label for="upload-files " class="form-label col-12 col-sm-12 col-md-12 col-lg-12 float-start"><h1 class="text-uppercase head mb-3">Upload Files:</h1></label>
            </div>

            <div class="row mb-3">
                <div class=" col-12 col-sm-12 col-md-2">
                     <p class="text-muted text-wrap">Select File:<br> Up to 50 MB</p>
                </div>
               <div class="col-12 col-sm-12 col-md-9">
                <!--<p class="blue fw-bold text-center drag-drop-box p-2">Drag and Drop Here</p>-->
                <div class="profile-txt" style="" id="productFileValidation">
                    <div class="drop-zone drop-height">
                        <h4 class="drop-zone__prompt">Select or Drag and Drop Here
<!--                                <small>Select file or <br>
                            drag and drop<br>
                            Up to 2 MB</small>-->
                        </h4>
                        <!--                            <h4 class="drop-zone__prompt">Banner Image 
                                                        <small>Select file or <br>
                                                        drag and drop<br>
                                                        Up to 2 MB</small></h4>-->
                        <input type="file" name="product_file" class="drop-zone__input" id="dragDropZoneFile">
                    </div>
                </div>
                <!--<span class="error text-danger error_msg">Enter your product title</span>-->
            </div>
            </div>
            <!--<div class="col-12 col-sm-12 col-md-2 col-lg-2">-->
                <!--<input class="custom-file-input text-uppercase" type="file" name="product_file" id="formFile">-->


            <!--</div>-->
            <!--                <div class="col-12 col-sm-12 col-md-1 col-lg-1 text-center">
                                <div class="fw-bold or"> or </div>
                            </div>-->
            <!--                <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                                <p class="blue fw-bold text-center drag-drop-box p-2">Drag and Drop Here</p>
                            </div>-->
            

            <div class="row mb-4">
                <div class="col-12 col-sm-12 col-md-2 ">
                    <label for="thumbnails" class="form-label fw-bold">Thumbnails:</label>
                </div>
                <div class="col-12 col-sm-12 col-md-9 radio-buttons">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="thumbnail_choice" id="thumbnail_choice1" value="auto">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Auto generate thumbnails
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="thumbnail_choice" id="thumbnail_choice2" value="manual" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Upload my own thumbnails
                        </label>
                    </div>
                </div>
            </div>

            <div class=" py-4 mb-3 position-relative">
                <div class="loading-product" style="display: none;">
                    <img src="{{url('/images/loading.gif')}}" class="img-fluid" alt="icon">
                </div>
                <div class="row gx-3 gx-sm-4" >
                    <div class=" col-sm-12 col-md-3 col-lg-3 text-center mb-2 ">
                        <!--<div class="card drag-drop-box h-100 px-2 py-2 ">
                            <div class="card-body "><p class="blue fw-bold ">Main Image</p>
                                <p class="text-muted text-wrap ">Select file <br>or drag and drop <br>Up to 2 MB</p>
                            </div>
                        </div>-->
                        <input type="hidden" name="auto_main_image">
                        <div class="profile-txt " id="mainImageValidation">
                            <div class="drop-zone">
                                <h4 class="drop-zone__prompt">Main Image 
                                    <small>Select file or <br>
                                        drag and drop<br>
                                        Up to 5 MB</small></h4>
                                <input type="file" name="main_image" class="drop-zone__input d1">
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3 text-center mb-2 ">
                        <!--                            <div class="card drag-drop-box h-100 px-2 py-2 ">
                                                        <div class="card-body "><p class="blue fw-bold ">Image (Optional)</p>
                                                            <p class="text-muted text-wrap ">Select file <br>or drag and drop <br>Up to 2 MB</p>
                                                        </div>
                                                    </div>-->
                        <div class="profile-txt ">
                            <div class="drop-zone">
                                <h4 class="drop-zone__prompt">Image (Optional) 
                                    <small>Select file or <br>
                                        drag and drop<br>
                                        Up to 5 MB</small></h4>
                                <input type="file" name="product_image[]" class="drop-zone__input d2">
                            </div>
                        </div>

                    </div>
                    <div class=" col-sm-12 col-md-3 col-lg-3 text-center mb-2 ">
                        <!--                            <div class="card drag-drop-box h-100 px-2 py-2 ">
                                                        <div class="card-body "><p class="blue fw-bold ">Image (Optional)</p>
                                                            <p class="text-muted text-wrap ">Select file <br>or drag and drop <br>Up to 2 MB</p>
                                                        </div>
                                                    </div>-->
                        <div class="profile-txt ">
                            <div class="drop-zone">
                                <h4 class="drop-zone__prompt">Image (Optional) 
                                    <small>Select file or <br>
                                        drag and drop<br>
                                        Up to 5 MB</small></h4>
                                <input type="file" name="product_image[]" class="drop-zone__input d3">
                            </div>
                        </div>

                    </div>
                    <div class=" col-sm-12 col-md-3 col-lg-3 text-center mb-2 ">
                        <!--                            <div class="card drag-drop-box h-100 px-2 py-2 ">
                                                        <div class="card-body "><p class="blue fw-bold ">Image (Optional)</p>
                                                            <p class="text-muted text-wrap ">Select file <br>or drag and drop <br>Up to 2 MB</p>
                                                        </div>
                                                    </div>-->
                        <div class="profile-txt ">
                            <div class="drop-zone">
                                <h4 class="drop-zone__prompt">Image (Optional) 
                                    <small>Select file or <br>
                                        drag and drop<br>
                                        Up to 5 MB</small></h4>
                                <input type="file" name="product_image[]" class="drop-zone__input d4">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                <label for="upload-files " class="form-label "><h1 class="text-uppercase head mb-3">Upload Files:</h1></label>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                <div class="mb-3 form-check">
                    <input class="form-check-input my-2" type="checkbox" name="terms_and_conditions" id="flexCheckDefault">
                    <label class="form-check-label pt-1" for="flexCheckDefault"  id="termsAndConditionsLabel">
                        By uploading the above product, I attest that I have read and agree to the Classroom Copy <a href="{{url('/web/terms_policy')}}">Terms 
                        and Conditions</a> and <a href="{{url('/web/intellectual_property')}}">Intellectual Property Policy</a> and that the product does not infringe the 
                        copyrights, trademark rights, or any other rights of any third party.
                    </label>
                </div>


                <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <button type="submit " class="btn bg-blue btn-hover text-white text-uppercase my-5 p-3 px-5" id="addProductSubmitBtn">Submit</button>
                </div>

            </div>
            </div>
            
        </form>
        <!--Form Section Ends Here-->
    </div>
</section>
<!--Add Product Starts Here-->
@endsection
@push('script')
<script>
    var validate = function (e) {
        var t = e.value;
        e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
    }
    $(document).on('keydown', 'input[pattern]', function (e) {
        var input = $(this);
        var oldVal = input.val();
        var regex = new RegExp(input.attr('pattern'), 'g');

        setTimeout(function () {
            var newVal = input.val();
            if (!regex.test(newVal)) {
                input.val(oldVal);
            }
        }, 1);
    });
</script>
<script>
    function show1() {
        document.getElementById('div1').style.display = 'block';
    }
    function show2() {
        $('input[name="single_license"]').val('');
        $('input[name="multiple_license"]').val('');
        document.getElementById('div1').style.display = 'none';
    }
</script>
<script>
    $(document).ready(function () {

        $("form input[name='product_file']").on('change',function(e){

            if($("input[name='product_file']").get(0).files.length == 1){
                e.preventDefault();
                $(".drop-zone__input.d1,.drop-zone__input.d2,.drop-zone__input.d3,.drop-zone__input.d4").next(".drop-zone__thumb").remove();
                if($(".drop-zone__input.d1").prev("h4.drop-zone__prompt").length == 0){
                     $('<h4 class="drop-zone__prompt">Main Image<small>Select file or <br>drag and drop<br>Up to 5 MB</small></h4>').insertBefore('.drop-zone__input.d1');
                }
                if($(".drop-zone__input.d2").prev("h4.drop-zone__prompt").length == 0){
                    $('<h4 class="drop-zone__prompt">Image (Optional)<small>Select file or <br>drag and drop<br>Up to 5 MB</small></h4>').insertBefore('.drop-zone__input.d2');
                }
                if($(".drop-zone__input.d3").prev("h4.drop-zone__prompt").length == 0){
                     $('<h4 class="drop-zone__prompt">Image (Optional)<small>Select file or <br>drag and drop<br>Up to 5 MB</small></h4>').insertBefore('.drop-zone__input.d3');
                }
                
                if($(".drop-zone__input.d4").prev("h4.drop-zone__prompt").length == 0){
                    $('<h4 class="drop-zone__prompt">Image (Optional)<small>Select file or <br>drag and drop<br>Up to 5 MB</small></h4>').insertBefore('.drop-zone__input.d4');
                }
                $("form input[name='auto_main_image'").val('');
                if($('form input[name="thumbnail_choice"]:checked').val() === 'manual'){
                    return false;
                }
                $(".loading-product").show();
                var fd = new FormData($('#addProductForm')[0]);
                $.ajax({
                    url: "{{route('auto.generatethumbnail')}}",
                    type: 'POST',
                    data: fd,
                    cache: false,
                    mimeType: "multipart/form-data",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                }).done(function (response, status, xhr) {
                    $(".loading-product").hide();
                    if(response.success == true){
                        if(response.data.length > 0){
                            $("form input[name='auto_main_image'").val(1);
                            $.each(response.data, function (index, item) {
                                $(".drop-zone__input.d"+(index+1)).prev("h4.drop-zone__prompt").remove();
                                $(".drop-zone__input.d"+(index+1)).after('<div class="drop-zone__thumb" data-label="'+item+'" style="background-image:url('+item+');"></div>')
                            });  
                        }
                    }
                    if(response.success == false){
                         swal.fire(response.message, "Please try again", "error");
                    }
                }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                    $(".loading-product").hide();
                    if (xhr.status == 419 && xhr.statusText == "unknown status") {
                        swal.fire("Unauthorized! Session expired", "Please login again", "error");
                    } else {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            swal.fire(xhr.responseJSON.message, "Please try again", "error");
                        } else {
                            swal.fire('Unable to process your request', "Please try again", "error");
                        }
                    }
                });
            }
        });

        $("form input[type='radio'][name='thumbnail_choice']").on('change',function(e){ 
            e.preventDefault();
            console.log($('form input[name="thumbnail_choice"]:checked').val());
            $(".drop-zone__input.d1,.drop-zone__input.d2,.drop-zone__input.d3,.drop-zone__input.d4").next(".drop-zone__thumb").remove();
            if($(".drop-zone__input.d1").prev("h4.drop-zone__prompt").length == 0){
                 $('<h4 class="drop-zone__prompt">Main Image<small>Select file or <br>drag and drop<br>Up to 5 MB</small></h4>').insertBefore('.drop-zone__input.d1');
            }
            if($(".drop-zone__input.d2").prev("h4.drop-zone__prompt").length == 0){
                $('<h4 class="drop-zone__prompt">Image (Optional)<small>Select file or <br>drag and drop<br>Up to 5 MB</small></h4>').insertBefore('.drop-zone__input.d2');
            }
            if($(".drop-zone__input.d3").prev("h4.drop-zone__prompt").length == 0){
                 $('<h4 class="drop-zone__prompt">Image (Optional)<small>Select file or <br>drag and drop<br>Up to 5 MB</small></h4>').insertBefore('.drop-zone__input.d3');
            }
            
            if($(".drop-zone__input.d4").prev("h4.drop-zone__prompt").length == 0){
                $('<h4 class="drop-zone__prompt">Image (Optional)<small>Select file or <br>drag and drop<br>Up to 5 MB</small></h4>').insertBefore('.drop-zone__input.d4');
            }
            $("form input[name='auto_main_image']").val('');
            if($('form input[name="thumbnail_choice"]:checked').val() === 'manual' || !$("form input[name='product_file']").val()){
                return false;
            }
            $(".loading-product").show();
            var fd = new FormData($('#addProductForm')[0]);
            $.ajax({
                url: "{{route('auto.generatethumbnail')}}",
                type: 'POST',
                data: fd,
                cache: false,
                mimeType: "multipart/form-data",
                dataType: 'json',
                processData: false,
                contentType: false,
            }).done(function (response, status, xhr) {
                $(".loading-product").hide();
                if(response.success == true){
                    if(response.data.length > 0){
                        $("form input[name='auto_main_image'").val(1);
                        $.each(response.data, function (index, item) {
                            $(".drop-zone__input.d"+(index+1)).prev("h4.drop-zone__prompt").remove();
                            $(".drop-zone__input.d"+(index+1)).after('<div class="drop-zone__thumb" data-label="'+item+'" style="background-image:url('+item+');"></div>')
                        });  
                    }
                }
                if(response.success == false){
                     swal.fire(response.message, "Please try again", "error");
                }
            }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
                $(".loading-product").hide();
                if (xhr.status == 419 && xhr.statusText == "unknown status") {
                    swal.fire("Unauthorized! Session expired", "Please login again", "error");
                } else {
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        swal.fire(xhr.responseJSON.message, "Please try again", "error");
                    } else {
                        swal.fire('Unable to process your request', "Please try again", "error");
                    }
                }
            });
        });

        $.ajax({
            url: "{{route('get.allCountries.list')}}",
            type: "POST",
            data: {},
            dataType: "json",
            beforeSend: function (xhr) {}
        }).always(function () {
        }).done(function (response, status, xhr) {
            if (response.success === true) {
                var country_select = $("#addProductForm").find("select[name='outcome_country']");
                $.each(response.data.countries, function (index, item) {
                    country_select.append(new Option(item.name + ' - ' + item.sortname, item.id));
                });
            }

        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {

        });
    });

    $(".select2").select2({
        theme: "bootstrap-5",
    });

    //get subject sub area on subject area basis
    var isSubjectSubAreaAvailable = 0;
    var subject_area = $("#subject_area :selected").val();
    var selected_subject_sub_area = "{{ old('subject_sub_area') }}"
    $.ajax({
        url: "{{route('storeDashboard.getSubjectSubArea')}}",
        type: 'POST',
        data: {'subject_area': subject_area, '_token': "{{ csrf_token() }}"},
    }).done(function (response, status, xhr) {
        if (response.data.length > 0) {
            isSubjectSubAreaAvailable = 1;
            $('#subject_sub_area').html('');
            var html = '<option value="" selected disabled>Please select subject sub area</option>';
            for (var i = 0; i <= response.data.length - 1; i++) {
                if (selected_subject_sub_area == response.data[i]['key'])
                    html += '<option value="' + response.data[i]['key'] + '" selected="">' + response.data[i]['value'] + '</option>';
                else
                    html += '<option value="' + response.data[i]['key'] + '">' + response.data[i]['value'] + '</option>';
            }
            $('#subject_sub_area').html(html);
        } else {
            isSubjectSubAreaAvailable = 0;
            $('#subject_sub_area').html('<option value="" selected disabled>Please select subject sub area</option>');
        }
    }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
        if (xhr.status == 419 && xhr.statusText == "unknown status") {
            swal.fire("Unauthorized! Session expired", "Please login again", "error");
        } else {
            if (xhr.responseJSON && xhr.responseJSON.message) {
                swal.fire(xhr.responseJSON.message, "Please try again", "error");
            } else {
                swal.fire('Unable to process your request', "Please try again", "error");
            }
        }
    });
    
    $("#subject_area").change(function () {
        var subject_area = $(this).val();
        $.ajax({
            url: "{{route('storeDashboard.getSubjectSubArea')}}",
            type: 'POST',
            data: {'subject_area': subject_area, '_token': "{{ csrf_token() }}"},
        }).done(function (response, status, xhr) {
            if (response.data.length > 0) {
                isSubjectSubAreaAvailable = 1;
                $('#subject_sub_area').html('');
                var html = '<option value="" selected disabled>Please select subject sub area</option>';
                for (var i = 0; i <= response.data.length - 1; i++) {
                    html += '<option value="' + response.data[i]['id'] + '">' + response.data[i]['name'] + '</option>';
                }
                $('#subject_sub_area').html(html);
                $('#subject_sub_sub_area').html('<option value="" selected disabled>Please select subject sub area</option>');
            } else {
                isSubjectSubAreaAvailable = 0;
                $('#subject_sub_area').html('<option value="" selected disabled>Please select subject sub area</option>');
                $('#subject_sub_sub_area').html('<option value="" selected disabled>Please select subject sub area</option>');
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    swal.fire(xhr.responseJSON.message, "Please try again", "error");
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                }
            }
        });
    });

    $("#subject_sub_area").change(function () {
        var subject_sub_area = $(this).val();
        $.ajax({
            url: "{{route('storeDashboard.getSubjectSubSubArea')}}",
            type: 'POST',
            data: {'subject_sub_area': subject_sub_area, '_token': "{{ csrf_token() }}"},
        }).done(function (response, status, xhr) {
            if (response.data.length > 0) {
                isSubjectSubAreaAvailable = 1;
                $('#subject_sub_sub_area').html('');
                var html = '<option value="" selected disabled>Please select subject sub area</option>';
                for (var i = 0; i <= response.data.length - 1; i++) {
                    html += '<option value="' + response.data[i]['id'] + '">' + response.data[i]['name'] + '</option>';
                }
                $('#subject_sub_sub_area').html(html);
            } else {
                isSubjectSubAreaAvailable = 0;
                $('#subject_sub_sub_area').html('<option value="" selected disabled>Please select subject sub area</option>');
            }
        }).fail(function (xhr, ajaxOptions, responseJSON, thrownError) {
            if (xhr.status == 419 && xhr.statusText == "unknown status") {
                swal.fire("Unauthorized! Session expired", "Please login again", "error");
            } else {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    swal.fire(xhr.responseJSON.message, "Please try again", "error");
                } else {
                    swal.fire('Unable to process your request', "Please try again", "error");
                }
            }
        });
    });

    $("input[name='product_file']").change(function (e) {
        if(e.key === 'undefined'){
            var val = $(this).val();
            //        console.log(val);

            //        if (!val.match(/(?:doc|docx|xls|xlsx|ppt|pptx|xt|rtf|ps|eps|prn|bmp|jpeg|jpg|gif|tiff|png|pcx|rle|dib|tml|wpd|odt|odp|ods|pdf|odg|odf|sxw|sxi|sxc|sxd|stw|psd|ai|indd|u3d|prc|dwg|dwt|dxf|dwf|dst|xps|mpp|sd)$/)) {
            if (!val.match(/(?:rm|bnk|doc|dot|exe|flv|fpl|htm|ink|key|knt|mp3|ods|pdf|pps|ppt|pub|ram|rtf|swf|txt|wpd|xls|xlt|zip|pptx|docx|epub|html|ppsx|pptx|tiff|xltx|xlsx|flipchart|notebook|avi|mov|m4a|m4v|mp4|mv4|mpeg|mpg|mkv|wmv|bmp|gif|jpg|jpeg|png|tiff|tif)$/)) {
                // inputted file path is not an image of one of the above types:
                //            $("#dragDropZoneFile").after('.drop-zone__thumb').remove();
                Swal.fire({
                    title: 'Oops...',
                    text: 'The selected file is invalid!',
                    icon: 'error',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    timer: 3000
                });
                return false;
            }
        }
    });
    /*
    $("input[name='main_image']").change(function () {
        var val = $(this).val();

        //        if (!val.match(/(?:doc|docx|xls|xlsx|ppt|pptx|xt|rtf|ps|eps|prn|bmp|jpeg|jpg|gif|tiff|png|pcx|rle|dib|tml|wpd|odt|odp|ods|pdf|odg|odf|sxw|sxi|sxc|sxd|stw|psd|ai|indd|u3d|prc|dwg|dwt|dxf|dwf|dst|xps|mpp|sd)$/)) {
        if (!val.match(/(?:bmp|gif|jpg|jpeg|png)$/)) {
            // inputted file path is not an image of one of the above types:
            //            $("#dragDropZoneFile").after('.drop-zone__thumb').remove();
            Swal.fire({
                title: 'Oops...',
                text: 'The selected file of main image is invalid. Please select image file!',
                icon: 'error',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 3000
            });
            return false;
        }


    });
    
    $("input[name='product_image[]']").change(function () {
        var val = $(this).val();

        //        if (!val.match(/(?:doc|docx|xls|xlsx|ppt|pptx|xt|rtf|ps|eps|prn|bmp|jpeg|jpg|gif|tiff|png|pcx|rle|dib|tml|wpd|odt|odp|ods|pdf|odg|odf|sxw|sxi|sxc|sxd|stw|psd|ai|indd|u3d|prc|dwg|dwt|dxf|dwf|dst|xps|mpp|sd)$/)) {
        if (!val.match(/(?:bmp|gif|jpg|jpeg|png)$/)) {
            // inputted file path is not an image of one of the above types:
            //            $("#dragDropZoneFile").after('.drop-zone__thumb').remove();
            Swal.fire({
                title: 'Oops...',
                text: 'The selected file of main image is invalid. Please select image file!',
                icon: 'error',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 3000
            });
            return false;
        }


    });
    */
</script>
<script>
    $("form[name='addProductForm']").submit(function (event) {
        //    event.preventDefault();
        var addProductForm = $("form[name='addProductForm']");

        var product_title = addProductForm.find("input[name='product_title']").val();
        var product_type = addProductForm.find("#product_type :selected").val();
        var language = addProductForm.find("#language :selected").val();
        var resource_type = addProductForm.find("#resource_type :selected").val();
        var description = addProductForm.find("textarea[name=description]").val();
        var year_level = addProductForm.find("#year_level :selected").val();
        var subject_area = addProductForm.find("#subject_area :selected").val();
        var subject_sub_area = addProductForm.find("#subject_sub_area :selected").val();
        var custom_category = addProductForm.find("input[name='custom_category']").val();
        var outcome_country = addProductForm.find("#outcome_country :selected").val();
        var standard_outcome = addProductForm.find("input[name='standard_outcome']").val();
        var teaching_duration = addProductForm.find("#teaching_duration :selected").val();
        var no_of_pages_slides = addProductForm.find("input[name='no_of_pages_slides']").val();
        var answer_key = addProductForm.find("#answer_key :selected").val();
        var is_paid_or_free = addProductForm.find('input[name="is_paid_or_free"]:checked').val();
        var single_license = addProductForm.find("input[name='single_license']").val();
        var multiple_license = addProductForm.find("input[name='multiple_license']").val();
        //    var is_paid_or_free         =   addProductForm.find('input[name="is_paid_or_free"]:checked').val() == 'on';
        var product_file = addProductForm.find('input[name="product_file"]').val();
        var main_image = addProductForm.find('input[name="main_image"]').val();
        var terms_and_conditions = addProductForm.find("input[name='terms_and_conditions']").prop('checked');
        var thubnail_choice = addProductForm.find("input[name='thumbnail_choice']:checked").val();

        $("#addProductForm .error_msg").remove();
        $('input[name=is_paid_or_free]').css('box-shadow', '0 0 0 0');

        if (product_title == "") {
            addProductForm.find("input[name='product_title']").focus().select();
            addProductForm.find("input[name='product_title']").after('<span class="error text-danger error_msg">Enter your product title</span>');
            return false;
        }
        if (description == "") {
            addProductForm.find("textarea[name=description]").focus().select();
            addProductForm.find("textarea[name=description]").after('<span class="error text-danger error_msg">Enter product description</span>');
            return false;
        }
        if (language == "") {
            addProductForm.find("#language").focus().select();
            addProductForm.find("#language-div").append('<span class="error text-danger error_msg pt-0">Please Select Language</span>');
            return false;
        }
        if (resource_type == "" || typeof resource_type === 'undefined') {
            addProductForm.find("#resource_type").focus().select();
            addProductForm.find("#resource_type-div").append('<span class="error text-danger error_msg">Please Select Resource Type</span>');
            return false;
        }
        if (product_type == "") {
            addProductForm.find("#product_type").focus().select();
            addProductForm.find("#product_type-div").append('<span class="error text-danger error_msg">Please Select Product type</span>');
            return false;
        }

        if (year_level == "" || typeof year_level === 'undefined') {
            addProductForm.find("#year_level").focus().select();
            addProductForm.find("#year_level-div").append('<span class="error text-danger error_msg">Select year level</span>');
            return false;
        }
        if (subject_area == "") {
         addProductForm.find("#subject_area").focus().select();
         addProductForm.find("#subject_area-div").append('<span class="error text-danger error_msg">Select subject area</span>');
         return false;
         }
         /*if (isSubjectSubAreaAvailable == 1) {
         if (subject_sub_area == "") {
         addProductForm.find("#subject_sub_area").focus().select();
         addProductForm.find("#subject_sub_area").after('<span class="error text-danger error_msg">Select subject area</span>');
         return false;
         }
         }*/
        // if(outcome_country == ""){
        //     addProductForm.find("#outcome_country").focus().select();
        //     addProductForm.find("#outcome_country-div").append('<span class="error text-danger error_msg">Select outcome country</span>');
        //     return false; 
        // } 

        // if(standard_outcome == ""){
        //     addProductForm.find("#standard_outcome").focus().select();
        //     addProductForm.find("#standard_outcome").after('<span class="error text-danger error_msg">Enter standard outcome</span>');
        //     return false; 
        // }    

        if (teaching_duration == "") {
            addProductForm.find("#teaching_duration").focus().select();
            addProductForm.find("#teaching_duration-div").append('<span class="error text-danger error_msg">Select teaching duration</span>');
            return false;
        }
        if (no_of_pages_slides == "") {
            addProductForm.find("#no_of_pages_slides").focus().select();
            addProductForm.find("#no_of_pages_slides").after('<span class="error text-danger error_msg">Select no. of pages slides</span>');
            return false;
        }
        if (answer_key == "") {
            addProductForm.find("#answer_key").focus().select();
            addProductForm.find("#answer_key-div").append('<span class="error text-danger error_msg">Select answer key</span>');
            return false;
        }
        if (typeof is_paid_or_free === 'undefined') {
            $('input[name=is_paid_or_free]').css('box-shadow', '0 0 2px 0 red');
            addProductForm.find('input[name="is_paid_or_free"]').focus().select();
            addProductForm.find("#isPaidOrFreeValidation").after('<span class="error text-danger error_msg"></br>Please select license</span>');
            return false;
        }
        if (is_paid_or_free == 'paid') {
            if (single_license == "") {
                addProductForm.find("input[name='single_license']").focus().select();
                addProductForm.find("input[name='single_license']").after('<span class="error text-danger error_msg">Enter single license </span>');
                return false;
            }
            // if (multiple_license == "") {
            //     addProductForm.find("input[name='multiple_license']").focus().select();
            //     addProductForm.find("input[name='multiple_license']").after('<span class="error text-danger error_msg">Enter multiple license </span>');
            //     return false;
            // }
        }

        if (product_file == '') {
            //        addProductForm.find('input[name="product_file"]').focus().select();
            var target = $('#productFileValidation');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1100);
            }
            addProductForm.find("#productFileValidation").after('<small class="text-danger error_msg">Please select product file</small>');
            return false;
        }
        if ((main_image == '' && thubnail_choice == 'manual') || (thubnail_choice == 'auto' && $("form input[name='auto_main_image']").val() == '' && main_image == '' )) {
            //        addProductForm.find('input[name="product_file"]').focus().select();
            var target = $('#mainImageValidation');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top
                }, 1000);
            }
            addProductForm.find("#mainImageValidation").after('<small class="text-danger error_msg">Please select main image of product</small>');
            return false;
        }
        //    if(is_paid_or_free === false){
        //        addProductForm.find("#is_paid_or_free").focus().select();
        //        addProductForm.find("#is_paid_or_free").after('<span class="error text-danger error_msg">Please Select license</span>');
        //        return false;
        //    }
        //    if(is_paid_or_free !== 'paid' || 'free'){
        //        addProductForm.find("#is_paid_or_free").focus().select();
        //        addProductForm.find("#is_paid_or_free").after('<span class="error text-danger error_msg">Please Select license</span>');
        //        return false;
        //    }


        let fileName, fileExtension;
        fileName = product_file;
        fileExtension = fileName.substr((fileName.lastIndexOf('.') + 1));
        if (product_type !== fileExtension) {
            Swal.fire({
                title: 'Oops...',
                text: 'The selected product type and selected product file wast not matched!',
                icon: 'error',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 3000
            });
            return false;
        }

        if (terms_and_conditions == false) {
            addProductForm.find("input[name='terms_and_conditions']").focus().select();
            addProductForm.find("#termsAndConditionsLabel").after('</br><small class="text-danger error_msg">Please accept our (Terms and Conditions , Privacy Policy , Intellectual Property Policy and Sellers Agreement)</small>');
            return false;
        }

    });
    // jQuery(function($){
    //     $('#select2-subject_sub_area-container').text('Please select subject area');
    // });        

</script>
<link rel="stylesheet" href="https://semantic-ui.com/dist/semantic.min.css">
<script src="https://semantic-ui.com/dist/semantic.min.js"></script>
@endpush