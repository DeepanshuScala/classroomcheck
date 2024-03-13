<!-- <style>
    .fa-star:hover {
        color: #e2334c !important;
    }
i.fa{
    color:#ccc!important;
}
    .fa-star.selected {
        color: #FF912C !important;
    }
</style> -->
<div class="modal fade" id="reportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center" id="error_message">
                    <h3 class="modal-title text-black mb-3" id="staticBackdropLabel">Report a issue</h3>
                </div>
                <div class="">
                    <form class="" action="" method="post" name="reportissue" id="reportissue">
                        @csrf
                        <div class="my-2">
                        <input type="text" name="subject" class="form-control" placeholder="Subject" required>   
                        </div>
                        <div class="my-2">
                            <textarea class="form-control" name="issue" id="issue" cols="20" rows="5" required="" placeholder="Write issue" maxlength="350"></textarea>
                        </div>
                        </br>
                        <div class="my-2 text-center float-start">
                            <input type="hidden" name="seller_id" id="seller_id">
                            <input type="hidden" name="order_id" id="order_id">
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="submit" class="btn btn-primary bg-blue btn-lg btn-hover px-4 " id="reportSubBtn" value="Submit" />
                        </div>
                        <button type="button" class="mt-2 btn btn-primary bg-blue btn-lg btn-hover btn-round ms-3" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>