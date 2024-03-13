@extends('layouts.master')
@section('title', $title = $data['title'] ?? 'Classroom Copy')
@section('content')
<!--Preferred Seller Section  Starts Here-->
<section class="preferred-seller-section1 py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-sm-12 col-lg-8">
                <h1 class="text-uppercase">Gift Cards</h1>
            </div>
            <div class="col-12 col-sm-12 col-lg-4 pt-5">
                <div class="text-end pb-5">
                    <a href="{{route('account.dashboard')}}" class="blue acc-dashboard">
                        <img src="{{asset('images/icon-1.png')}}" class="img-fluid me-2 my-1" alt=" "> 
                        Account Dashboard
                    </a>
                </div>
            </div>
        </div>
        <h5 class="bg-blue text-uppercase text-center text-white p-3 mb-0"> Gift Cards </h5>
        <div class="view-table-box table-responsive rating-review-tb">
        <table class="table" cellspacing="0">
            <thead>
                <tr align="center">
                    <th scope="col">S.No.</th>
                    <th scope="col">Gift Code</th>
                    <th scope="col">Invoice Number</th>
                    <th scope="col">Remaining Balance</th>
                </tr>
            </thead>
            <tbody>
                 <?php
                if (!is_null($data['cards'])) {
                    foreach ($data['cards'] as $key => $crd) {
                        ?>
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$crd->gift_code}}</td>
                            <td>
                                @php
                                    if(count($crd->orders)>0){
                                        foreach($crd->orders as $ordr){
                                            echo $ordr->order_number."<br>";
                                        }
                                    }

                                @endphp
                            </td>
                            <td>${{number_format((float) ($crd->remaining_amount), 2, '.', '')}}</td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4" class="text-center">You do not have any Gift cards.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
</section>

<!--Preferred Seller Section  Ends Here-->
@endsection
@push('script')
<script>
</script>
@endpush