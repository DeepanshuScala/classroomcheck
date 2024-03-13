<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>-->
<?php
$selleroffer = DB::Table('seller_offer')->first();
?>
<div class="modal fade coupon-code" id="couponOffersModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title coupon-title" id="staticBackdropLabel">Coupon & Offers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        @if(!empty($selleroffer) && $selleroffer->is_active)
                            <div class="coupon-code-area">
                                <h2>100% on your sale</h2>
                                <ul class="offer-list my-4">
                                    <li>Start your Classroom Copy online store today to receive 100% on your store sales for 12 months</li>
                                    <li>This offer is for a limited time only and applies to new accounts/stores only</li>
                                    <li>The advertised 100% on all sales excludes third-party transaction fees and taxes</li>
                                </ul>
                                <div class="copy-code">
                                    <input type="text" name="couponcode" id="couponcode" value="sb26dg3663dg">
                                    <span class="copycode" onclick="copyCode();">Copy Seller Offer</span>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12 col-12">
                                <div class="shadow-lg p-3 mb-5 bg-body rounded">
                                    <div class="icon text-danger text-center">
                                        <i class="fas fa-gift"></i>
                                    </div>
                                    <div class="notice">
                                        <h5 class="text-center">No Coupons & offers Available</h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script type="text/javascript">
    function copyCode() {
        document.getElementById('couponcode').select();
        document.execCommand('copy');
        Swal.fire({title :"Coupon copied to clipboard",timer: 2000});
    }
</script>
@endpush

