@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Add Product Starts Here-->
    <section class="add_product_section">
        <div class="container">
            <h1 class="text-uppercase pt-5">
                Add Products To Your Store
            </h1>
            <!--Form Section Starts Here-->
            <form class="row g-3 pt-2 pb-5 col-md-12 d-flex flex-row" action="{{route('storeDashboard.addProduct.post')}}" name="addProductForm" id="addProductForm" method="post" enctype="multipart/form-data">
                @csrf
                <h1 class="text-uppercase pb-3">
                    Add Products
                </h1>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="inputProduct-title" class="form-label w-25 fw-bold float-start">Product Title</label>
                    <input type="text" class="form-control bg-light w-50" name="product_title" id="inputProduct-title" value="{{old('product_title')}}" placeholder="Name your product">
                    <!--<span class="error text-danger error_msg">Enter your product title</span>-->
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="textareaDescription" class="form-label w-25 fw-bold float-start">Description</label>
                    <textarea class="form-control bg-light w-50" name="description" id="textareaDescription" rows="3" placeholder="Describe your product and its benefits for other educators.">{{old('description')}}</textarea>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="inputProduct" class="form-label w-25 fw-bold d-flex flex-column float-start mb-0">Product Type
                        <a href="#" class="text-muted fs-6 fw-normal mb-0" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Supported File Types</a></label>
                        <select class="form-select select2Q bg-light w-50" name="product_type" id="product_type">
                            <option value="" selected disabled>-Select Product type-</option>
                            @php
                                $productFileTypeArr     =   ['rm', 'bnk', 'doc', 'dot', 'exe', 'flv', 'fpl', 'htm', 'ink', 'key', 'knt', 'mp3', 'ods', 'pdf', 'pps', 'ppt', 'pub', 'ram', 'rtf', 'swf', 'txt', 'wpd', 'xls', 'xlt', 'zip', 'pptx', 'docx', 'epub', 'html', 'ppsx', 'pptx', 'tiff', 'xltx', 'xlsx', 'flipchart', 'notebook', 'avi', 'mov', 'm4a', 'm4v', 'mp4', 'mv4', 'mpeg', 'mpg', 'mkv', 'wmv', 'bmp', 'gif', 'jpg', 'jpeg', 'png', 'tiff', 'tif'];
                            @endphp
                            @foreach($productFileTypeArr as $productFileType)
                                <option value="{{$productFileType}}" {{ old('product_type') == $productFileType? 'selected':'' }}>{{$productFileType}}</option>
                            @endforeach
                        </select>
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
                                <h5>Thumbnails <span class="fs-6 text-muted">Up to 2 MB</span></h5>
                                <p>.bmp, .gif, .jpg, .jpeg, .png, .ttf, .txt</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Done</button>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="selectLevel" class="form-label w-25  fw-bold float-start">Year Level</label>
                    <select class="form-select bg-light w-50" name="year_level" id="year_level" placeholder="Select Up to Four Year Levels or ‘ Non-Specific Grade’  ">
                        <option selected disabled>Select Up to Four Year Levels or ‘ Non-Specific Grade’  </option>
                        @php
                            $levelArr               =   ['Pre Prep / Pre K' ,'Prep / K' ,'1st' ,'2nd' ,'3rd' ,'4th' ,'7th' ,'8th' ,'9th' ,'10th' ,'11th' ,'12th' ,'Not Grade Specific' ,'Higher Education' ,'Adult Education' ,'Homeschool' ,'Staff'];

                        @endphp
                        @foreach($levelArr as $level)
                                <option value="{{$level}}" {{ old('year_level') == $level? 'selected':'' }} >{{$level}}</option>
                        @endforeach
                        
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="selectSubject" class="form-label w-25 fw-bold float-start">Subject Area</label>
                    <select class="form-select bg-light w-50" name="subject_area" id="subject_area" placeholder="Select at least one subject area">
                        <option selected disabled>Select at least one subject area</option>
                        <option value="Subject area 1" {{ old('subject_area') == "Subject area 1"? 'selected':'' }} >Subject area 1</option>
                        <option value="Subject area 2" {{ old('subject_area') == "Subject area 2"? 'selected':'' }} >Subject area 2</option>
                        <option value="Subject area 3" {{ old('subject_area') == "Subject area 3"? 'selected':'' }} >Subject area 3</option>
                        <option value="Subject area 4" {{ old('subject_area') == "Subject area 4"? 'selected':'' }} >Subject area 4</option>
                    </select>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="selectCategory" class="form-label w-25 fw-bold float-start">Custom Category</label>
                    <select class="form-select bg-light w-50" name="custom_category" id="custom_category" placeholder="TBA">
                        <option selected disabled>TBA</option>
                        <option value="Custom category 1" {{ old('custom_category') == "Custom category 1"? 'selected':'' }} >TCA</option>
                        <option value="Custom category 2" {{ old('custom_category') == "Custom category 2"? 'selected':'' }} >ACA</option>
                        <option value="Custom category 3" {{ old('custom_category') == "Custom category 3"? 'selected':'' }} >DCA</option>
                        <option value="Custom category 4" {{ old('custom_category') == "Custom category 4"? 'selected':'' }} >ADC</option>
                      </select>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="selectStandards" class="form-label w-25 fw-bold float-start">Standards / Outcomes</label>
                    <select id="selectStandards " class="form-select country bg-light w-25 me-2 float-start" placeholder="Select Country ">
                        <option selected> Select Country </option>
                        <option></option>
                      </select>
                    <input type="text " class="form-control bg-light w-25  pe-0 float-start" id="inputList-standards " placeholder="List standards / outcome codes separated by a comma ">
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="selectTeachingDuration" class="form-label w-25 fw-bold float-start">Teaching Duration:</label>
                    <select id="selectTeachingDuration" class="form-select bg-light w-50 " placeholder="Select Country ">
                        <option selected> N/A</option>
                        <option></option>
                      </select>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="selectPages " class="form-label w-25 fw-bold float-start">No. of Pages /Slides:</label>
                    <select class="form-select bg-light w-25 no-of-pages" name="no_of_pages_slides" id="no_of_pages_slides" placeholder="Total Pages or Slides ">
                        <option selected> Total Pages or Slides  </option>
                                <option value="10" {{ old('no_of_pages_slides') == "10"? 'selected':'' }} >10</option>
                                <option value="20" {{ old('no_of_pages_slides') == "20"? 'selected':'' }} >20</option>
                                <option value="25" {{ old('no_of_pages_slides') == "25"? 'selected':'' }} >25</option>
                                <option value="35" {{ old('no_of_pages_slides') == "35"? 'selected':'' }} >35</option>
                    </select>

                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="selectAnswerkey" class="form-label w-25 fw-bold float-start">Answer Key:</label>
                    <select class="form-select bg-light pages-or-slides w-25" name="answer_key" id="answer_key" placeholder="Answer key">
                        <option selected> Answer key ?  </option>
                        <option value="yes" {{ old('answer_key') == "yes"? 'selected':'' }} >Yes</option>
                        <option value="no" {{ old('answer_key') == "no"? 'selected':'' }} >No</option>
                      </select>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="pricing " class="form-label w-25 float-start"><h1 class="text-uppercase">Pricing:</h1></label>
                    <label class="form-label view-pricing w-25 pt-2 float-start"><a href="#" class="text-upperxase text-dark ">View Pricing Guide</a></label>
                </div>


                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="License " class="form-label w-25 fw-bold float-start">License:</label>

                    <div class=" form-check-inline ps-0">
                        <input type="radio" name="flexRadioDefault" value="paid" onclick="show1();" />
                        <label class="form-check-label" for="flexRadioDefault">Paid</label>
                    </div>
                    <div class=" form-check-inline ps-0">
                        <input type="radio" name="flexRadioDefault" value="free" onclick="show2();" />
                        <label class="form-check-label " for="flexRadioDefault1">
                          Free
                        </label>
                    </div>
                    <div class="row mx-auto">
                        <div id="div1" class="hidden p-0">

                            <label for="inputLicense " class="col-md-2 form-label pt-2  fw-bold float-start">Single License:</label>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 float-start">
                                <span>USD $</span>
                                <input type="text" class="form-control bg-light " id="inputLicense " placeholder="USD $ ">
                            </div>
                            <label for="multipleLicense " class="col-md-2 form-label pt-2 fw-bold float-start text-center multiple-license">Multiple License:</label>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4 float-start">
                                <input type="text " class="form-control license bg-light  " id="multipleLicense " placeholder="USD $ ">
                            </div>

                        </div>
                    </div>
                </div>





                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="inputTaxcode " class="form-label w-25 fw-bold float-start">Tax Code:</label>
                    <input type="text " class="form-control bg-light w-75" id="inputTaxcode " placeholder="TBA ">
                </div>


                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <label for="upload-files " class="form-label  float-start"><h1 class="text-uppercase">Upload Files:</h1></label>


                </div>

                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <p class="text-muted text-wrap">Select File:<br> Up to 200 MB</p>
                </div>
                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <!--<input class="custom-file-input text-uppercase" type="file" name="product_file" id="formFile">-->


                </div>
<!--                <div class="col-12 col-sm-12 col-md-1 col-lg-1 text-center">
                    <div class="fw-bold or"> or </div>
                </div>-->
<!--                <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                    <p class="blue fw-bold text-center drag-drop-box p-2">Drag and Drop Here</p>
                </div>-->
                <div class="col-12 col-sm-12 col-md-7 col-lg-7">
                    <!--<p class="blue fw-bold text-center drag-drop-box p-2">Drag and Drop Here</p>-->
                    <div class="profile-txt" style="">
                        <div class="drop-zone">
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
                </div>


                <div class="col-12 col-sm-12 col-md-2 col-lg-2">
                    <label for="thumbnails" class="form-label fw-bold">Thumbnails:</label>
                </div>
                <div class="col-12 col-sm-12 col-md-9 col-lg-9 radio-buttons">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Auto generate thumbnails
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Upload my own thumbnails
                        </label>
                    </div>
                </div>


                <div class="container py-4">
                    <div class="row gx-3 gx-sm-4" ">
                        <div class="col-6 col-sm-12 col-md-3 col-lg-3 text-center mb-2 ">
                            <!--<div class="card drag-drop-box h-100 px-2 py-2 ">
                                <div class="card-body "><p class="blue fw-bold ">Main Image</p>
                                    <p class="text-muted text-wrap ">Select file <br>or drag and drop <br>Up to 2 MB</p>
                                </div>
                            </div>-->
                            <div class="profile-txt ">
                                <div class="drop-zone">
                                    <h4 class="drop-zone__prompt">Main Image 
                                        <small>Select file or <br>
                                        drag and drop<br>
                                        Up to 2 MB</small></h4>
                                    <input type="file" name="main_image" class="drop-zone__input">
                                  </div>
                            </div>
                            
                        </div>
                        <div class="col-6 col-sm-12 col-md-3 col-lg-3 text-center mb-2 ">
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
                                        Up to 2 MB</small></h4>
                                    <input type="file" name="product_image[]" class="drop-zone__input">
                                  </div>
                            </div>
                            
                        </div>
                        <div class="col-6 col-sm-12 col-md-3 col-lg-3 text-center mb-2 ">
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
                                        Up to 2 MB</small></h4>
                                    <input type="file" name="product_image[]" class="drop-zone__input">
                                  </div>
                            </div>
                            
                        </div>
                        <div class="col-6 col-sm-12 col-md-3 col-lg-3 text-center mb-2 ">
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
                                        Up to 2 MB</small></h4>
                                    <input type="file" name="product_image[]" class="drop-zone__input">
                                  </div>
                            </div>
                            
                        </div>
                   
                    </div>
                   </div>
                   <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                    <label for="upload-files " class="form-label "><h1 class="text-uppercase ">Upload Files:</h1></label>
                </div>
                
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 ">
                <div class="mb-3 form-check">
                            <input class="form-check-input my-2" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label pt-1" for="flexCheckDefault">
                               By uploading the above product, I attest that I have read and agree to the Classroom Copy Terms 
                            and Conditions and Intellectual Property Policy and that the product does not infringe the 
                            copyrights, trademark rights, or any other rights of any third party.

                            </label>
                     </div>
                                  

                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center">
                        <button type="submit " class="btn bg-blue btn-hover text-white text-uppercase my-5" id="addProductSubmitBtn">Submit</button>
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
    function show1(){
        document.getElementById('div1').style.display ='block';
    }
    function show2(){
      document.getElementById('div1').style.display = 'none';
    }
</script>
<script>
$(".select2").select2({
    theme: "bootstrap-5",
});
    $("input[name='product_file']").change(function(){
        var val = $(this).val();
        console.log(val);
        
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
        
        
    });
</script>
<script>
$("form[name='addProductForm']").submit(function( event ) {
//    event.preventDefault();
    var addProductForm      =   $("form[name='addProductForm']");
    
    var product_title           =   addProductForm.find("input[name='product_title']").val();
    var product_type            =   addProductForm.find("#product_type :selected").val();
    var description             =   addProductForm.find("textarea[name=description]").val();
    
    console.log('submited...');
    console.log(product_type);
    
    $("#addProductForm .error_msg").remove();
    
    if(product_title == ""){
        addProductForm.find("input[name='product_title']").focus().select();
        addProductForm.find("input[name='product_title']").after('<span class="error text-danger error_msg">Enter your product title</span>');
        return false;
    }
    if(description == ""){
        addProductForm.find("textarea[name=description]").focus().select();
        addProductForm.find("textarea[name=description]").after('<span class="error text-danger error_msg">Enter product description</span>');
        return false;
    }
    if(product_type == ""){
        addProductForm.find("#product_type").focus().select();
        addProductForm.find("#product_type").after('<span class="error text-danger error_msg">Please Select Product type</span>');
        return false;
    }
    
    
//    var surname                 =   storeRegisterForm.find("input[name='surname']").val();
//    var image                   =   storeRegisterForm.find("input[name='image']").val();
//    var email                   =   storeRegisterForm.find("input[name='email']").val();
//    var password                =   storeRegisterForm.find("input[name='password']").val();
//    var password_confirmation   =   storeRegisterForm.find("input[name='password_confirmation']").val();
//    var address_line1           =   storeRegisterForm.find("input[name='address_line1']").val();
//    var address_line2           =   storeRegisterForm.find("input[name='address_line2']").val();
//    var city                    =   storeRegisterForm.find("input[name='city']").val();
//    var state_province_region   =   storeRegisterForm.find("input[name='state_province_region']").val();
//    var postal_code             =   storeRegisterForm.find("input[name='postal_code']").val();

//    var country                 =   storeRegisterForm.find("#country :selected").text();
//    var phone                   =   storeRegisterForm.find("input[name='phone']").val();
//    var mob_phone               =   storeRegisterForm.find("input[name='mob_phone']").val();
//    var age                     =   storeRegisterForm.find("#age :selected").val();

//    var image                   =   storeRegisterForm.find("#image");//.val();
//    var default_image           =   storeRegisterForm.find("input[name='default_image']").prop('checked');
//    var tell_us_about_you       =   storeRegisterForm.find("textarea[name=tell_us_about_you]").val();
//    var detail_additional_information =   storeRegisterForm.find("textarea[name=detail_additional_information]").val();
//    var newsletter              =   storeRegisterForm.find("input[name='newsletter']").prop('checked');
//    var classroom_contributions =   storeRegisterForm.find("input[name='classroom_contributions']").prop('checked');
//    var terms_and_conditions    =   storeRegisterForm.find("input[name='terms_and_conditions']").prop('checked');
//    console.log(tell_us_about_you);
//    return false;
//    var formData = new FormData($('#image')[0]);
//    var formData = new FormData();
//    formData.append('file', document.getElementById("image").files[0]);
//    formData.append('name', 'dogName');
//    var files = $('#image')[0].files;
//
//    if(files.length > 0){
//        var form_data = new FormData();
//        // Append data 
//        form_data.append('image',files[0]);
//        console.log(form_data);
//     }
//    var file = $('#image')[0].files;
//    var formData = new FormData(this);
//        formData.append('file', file[0]);
//        var options = { content: formData };
//        console.log(options);
//    for (var key of form_data.entries()) {
//        console.log(key[0] + ', ' + key[1]);
//    }

//    for (var key of formData.entries()) {
//            console.log(key[0] + ', ' + key[1])
//    }
//    console.log(formData);
//    return false;
//$("form[name='storeRegisterForm']").submit();
    

//    if(surname == ""){
//        storeRegisterForm.find("input[name='surname']").focus().select();
//        storeRegisterForm.find("input[name='surname']").after('<span class="error text-danger error_msg">Enter your surname</span>');
//        return false;
//    }
//    if(address_line1 == ""){
//        storeRegisterForm.find("input[name='address_line1']").focus().select();
//        storeRegisterForm.find("input[name='address_line1']").after('<span class="error text-danger error_msg">Enter your address line1</span>');
//        return false;
//    }
//    if(address_line2 == ""){
//        storeRegisterForm.find("input[name='address_line2']").focus().select();
//        storeRegisterForm.find("input[name='address_line2']").after('<span class="error text-danger error_msg">Enter your address line2</span>');
//        return false;
//    }
//    if(city == ""){
//        storeRegisterForm.find("input[name='city']").focus().select();
//        storeRegisterForm.find("input[name='city']").after('<span class="error text-danger error_msg">Enter your city</span>');
//        return false;
//    }
//    if(state_province_region == ""){
//        storeRegisterForm.find("input[name='state_province_region']").focus().select();
//        storeRegisterForm.find("input[name='state_province_region']").after('<span class="error text-danger error_msg">Enter your State / Province / Region</span>');
//        return false;
//    }
//    if(postal_code == ""){
//        storeRegisterForm.find("input[name='postal_code']").focus().select();
//        storeRegisterForm.find("input[name='postal_code']").after('<span class="error text-danger error_msg">Enter your ZIP / Postal Code</span>');
//        return false;
//    }
//    
//    if(phone == ""){
//        storeRegisterForm.find("#phone").focus().select();
//        storeRegisterForm.find("#phone").after('<span class="error text-danger error_msg">Enter your phone</span>');
//        return false;
//    }
//    if(mob_phone == ""){
//        storeRegisterForm.find("#mob_phone").focus().select();
//        storeRegisterForm.find("#mob_phone").after('<span class="error text-danger error_msg">Enter your mobile phone</span>');
//        return false;
//    }
//    if(email == ""){
//        storeRegisterForm.find("input[name='email']").focus().select();
//        storeRegisterForm.find("input[name='email']").after('<span class="error text-danger error_msg">Enter email</span>');
//        return false;
//    }
//    if(password == ""){
//        storeRegisterForm.find("input[name='password']").focus().select();
//        storeRegisterForm.find("input[name='password']").after('<span class="error text-danger error_msg">Enter password</span>');
//        return false;
//    }
//    if(password_confirmation == ""){
//        storeRegisterForm.find("input[name='password_confirmation']").focus().select();
//        storeRegisterForm.find("input[name='password_confirmation']").after('<span class="error text-danger error_msg">Enter confirm password</span>');
//        return false;
//    }
//    if(password !== password_confirmation){
//        storeRegisterForm.find("input[name='password_confirmation']").focus().select();
//        storeRegisterForm.find("input[name='password_confirmation']").after('<span class="error text-danger error_msg">Confirm password was not matched!</span>');
//        return false;
//    }
//    if(age == ""){
//        storeRegisterForm.find("#age").focus().select();
//        storeRegisterForm.find("#age").after('<span class="error text-danger error_msg">Enter your age</span>');
//        return false;
//    }
//    var profile_pic_filePath = image.val();
//    if(profile_pic_filePath == '' && default_image == false){
//        storeRegisterForm.find("input[name='image']").focus().select();
//        storeRegisterForm.find("#imageAndDefaultImage").after('<small class="text-danger error_msg">Please select image OR Use the Classroom Copy default image </small>');
//        return false;
//    }
//    if(tell_us_about_you == ""){
//        storeRegisterForm.find("textarea[name=tell_us_about_you]").focus().select();
//        storeRegisterForm.find("textarea[name=tell_us_about_you]").after('<span class="error text-danger error_msg">Enter Tell us about you</span>');
//        return false;
//    }
//    if(detail_additional_information == ""){
//        storeRegisterForm.find("#detail_additional_information").focus().select();
//        storeRegisterForm.find("textarea[name=detail_additional_information]").after('<span class="error text-danger error_msg">Enter Detail any additional information</span>');
//        return false;
//    }
//    if(newsletter == false){
//        storeRegisterForm.find("input[name='newsletter']").focus().select();
//        storeRegisterForm.find("#newsletterLabel").after('</br><small class="text-danger error_msg">Please select our newsletter</small>');
//        return false;
//    }
//    if(classroom_contributions == false){
//        storeRegisterForm.find("input[name='classroom_contributions']").focus().select();
//        storeRegisterForm.find("#classroomContributionsLabel").after('</br><small class="text-danger error_msg">Please select (Sign up to raise funds for your account through Classroom Contributions)</small>');
//        return false;
//    }
//    if(terms_and_conditions == false){
//        storeRegisterForm.find("input[name='terms_and_conditions']").focus().select();
//        storeRegisterForm.find("#termsAndConditionsLabel").after('</br><small class="text-danger error_msg">Please accep our (Terms and Conditions , Privacy Policy , Intellectual Property Policy and Sellers Agreement)</small>');
//        return false;
//    }
    
//    var url =   "{{--route('accountUser.Register.Post')--}}";
//    $.ajax(url, {
//        type: 'POST',
//        data: $("form[name='storeRegisterForm']").serializeArray(),
//        contentType: false,
//        cache: false,
//        processData:false,
//        beforeSend: function(xhr) {
////            download_div.find('a').addClass('disabled');
//        }
//    }).always(function() {
////        filter_form.find('.gotuo-submit').prop('disabled', false);
////        $('.loading').remove();
////        $('#customer_data').show();
////        download_div.find('a').removeClass('disabled');
//    }).done(function(response, status, xhr) {
//        console.log(response);
//
//    }).fail(function(xhr, ajaxOptions, responseJSON, thrownError) {
//        console.log(xhr);
////        if(xhr.status == 419 && xhr.statusText == "unknown status"){
////            swal.fire("Unauthorized! Session expired", "Please login again", "error");
////        } else {
////            if(xhr.responseJSON && xhr.responseJSON.message){
////                swal.fire(xhr.responseJSON.message, "Please try again", "error");
////            } else {
////                swal.fire('Unable to process your request', "Please try again", "error");
////            }
////        }
//    });
    
});
</script>
@endpush