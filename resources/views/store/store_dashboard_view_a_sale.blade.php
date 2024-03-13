<?php
use \App\Http\Helper\Web;
?>  
@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!-- page title start -->
<!-- no sales section start html -->
    <section class="no_sales ">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="details-products-final mx-1">
                        <div>
                            <span class="fw-bold">Discount: </span>
                            {{$data['discount']}}%
                        </div>
                        <div>
                            <span class="fw-bold">Start Date: </span>
                            {{date('m-d-Y',strtotime($data['start_date']))}}
                        </div>
                        <div>
                            <span class="fw-bold">End Date: </span>
                            {{date('m-d-Y',strtotime($data['end_date']))}}
                        </div>
                        <div>
                            <span class="fw-bold">Product Selected: </span>
                            {{count($data['products'])}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 store-dashboard my-md-0 ">
                    <a href="{{url()->previous()}}">Back to sale listing</a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-4">
                    <div class="my-sales-list">
                        <h5>Products In Your Sale</h5>
                    </div>
                    <div class="view-table-box table-responsive">
                        <table class="table align-middle mb-0 table-bordered" >
                           <tr class="text-center">
                                <th>S.no.</th>
                                <th>Title</th>
                                <th>Subject</th>
                                <th>Rating</th>
                                <th>Sold</th>
                                <th>Price</th>
                                <th>Price After Discount</th>
                                <th>License price</th>
                                <th>License Price After Discount</th>
                           </tr>
                            @foreach($data['products'] as $key => $lst)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$lst->product_title}}</td>
                                    <td>
                                        <?php
                                            $subjectArea = DB::table('crc_subject_details')->where('id', $lst->subject_area)->first();
                                            echo ($subjectArea != null) ? $subjectArea->name : 'N/A';
                                        ?>
                                    </td>
                                    <td>{{Web::getProductRating($lst->id)}}</td>
                                    <td>{{DB::table('crc_order_items')->where('product_id',$lst->id)->where('status',1)->count();}}</td>
                                    <td>${{$lst->single_license}}</td>
                                    <td>${{round($lst->single_license - ($lst->single_license*$data['discount']/100),2)}}</td>
                                    <td>${{!empty($lst->multiple_license)?round($lst->multiple_license,2):round($lst->single_license,2)}}</td>
                                    <td>${{!empty($lst->multiple_license)?round($lst->multiple_license,2):round($lst->single_license - ($lst->single_license*$data['discount']/100),2)}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <?php
                     /*
                    <div class="text-center col-12 "><button type="button " class="btn btn-primary bg-blue btn-lg px-4 my-5 me-md-2 text-uppercase btn-hover view-more ">New Sale </div>
                    */
                ?>
            </div>
        </div>
    </section>
<!-- no sales section end html -->
@endsection