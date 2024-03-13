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
        <!--Intellectual Property Section Starts Here-->
    <section class="intellectual-property-section py-5">
        <div class="container">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <h1 class="text-uppercase pt-0 pb-3">Intellectual Property</h1>
                <h5>INTELLECTUAL PROPERTY FOR RIGHTS OWNERS</h5><br>
                <p>Note: The following information does not contain legal advice. You should consult a lawyer if you have specific questions about your IP rights or the IP rights of others.
                </p>
                <p>Classroom Copy is dedicated to ensuring that goods do not violate or infringe a Rights Owner's intellectual property (IP).
                </p>
                <p>To learn more about intellectual property rights, please contact your local intellectual property office or attorney.</p><br>

                <h5>MAIN TYPES OF INTELLECTUAL PROPERTY</h5><br>
                <h5>A. TRADEMARK</h5>
                <p>A trademark is a word, symbol, or design (such as a stylized brand name or logo) that a company uses to identify its goods or services and to distinguish them from other companies' goods and services. Generally, trademark laws exist to
                    prevent customer confusion about the source of goods or services. A trademark owner usually protects a trademark by registering it with a country-specific trademark office. In some cases, a person or company might have trademark rights
                    based on only the use of a mark in commerce, even though the mark was never registered with a country-specific trademark office. Those rights are known as "common law" trademark rights and can be more limited. </p>
                <p>Seller-Level: If you believe a particular offer from a Seller is listing a product that infringes your trademark, then you may report that offer as infringing. However, the product detail page and Standard Identification Number may remain
                    live until issue conclusion. </p>
                <p> Product Detail Page: If your trademark is being used on the product detail page, but the product being sold is not your product, you may report use of the trademark on the product detail page as infringing. When we collect Personal Information,
                    we will, where appropriate and where possible, explain to you why we are collecting the information and how we plan to use it.</p><br>

                <h5>B. COPYRIGHT</h5>
                <p>A copyright protects original works of authorship, such as videos, movies, songs, books, musicals, video games, paintings, etc. Generally, copyright law is meant to incentivize the creation of original works of authorship for the benefit
                    of the public. To receive copyright protection, a work of authorship must be created by an author and must have some amount of creativity. If someone is the author of an original work, then they typically own the copyright in that
                    work. In some countries, a copyright owner can protect its copyrighted material by registering the material with a country-specific copyright office. You can generally use your own copyrighted images on product detail pages to sell
                    a product; however, you should not take images from other sources and add them to product detail pages without the Rights Owner's permission.
                </p>
                <p>Note: When you add your copyrighted image or copyrighted text to a product detail page, you grant Classroom Copy a license to use the material. Other sellers can list their identical products for sale on pages to which you have added your
                    copyrighted images or text, even if you no longer sell that product. </p>
                <p>Example: The owner of a Classroom Copy Store used photos of Place Value Cards and owns the copyright of these images. If a seller were to copy these images to sell their product on another product detail page, that seller could be violating
                    the Rights Owner's copyright of the Place Value Cards images.
                </p>
                <p><b>Seller-Level:</b> If you believe a particular offer from a Seller listing a product infringes your copyright, then you may report that offer as infringing. However, expect the product detail page to remain live until the matter is concluded.
                    It is also helpful to provide a test buy with a valid Order ID to support your report.

                </p>
                <p><b>Image or Text:</b> If your copyrighted image is used on a product detail page without your permission, then you may report the image as infringing. However, expect the product detail page to remain live until the matter is concluded.
                </p><br>
                <h5>C. RIGHT OF PUBLICITY</h5>
                <p>The right of publicity, often called personality rights, is the right of an individual to control the commercial use of his or her name, image, likeness, or other unequivocal aspects of one's identity. You cannot post content that infringes
                    on a person’s right of publicity nor force or otherwise coerce a person without amicable agreement to allow use of their rights of publicity. </p>
                <p>If you are claiming a right to publicity, you must specifically claim your right and provide evidence to support your claim for us to complete our investigation.
                </p>


            </div>
            
             <div class="text-center col-12 "><button type="button " class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover view-more ">View More </div>

        </div>  
    </section>
<!--Intellectual Property Section Ends Here-->
@endsection


