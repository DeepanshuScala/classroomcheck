<!-- Modal -->
<div class="modal fade" id="personalDetailsUpdateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header border-0 bg-grey">
            <h5 class="modal-title" id="modalTitleView"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="javascript:void()" method="post" name="personalDetailsUpdateForm" id="personalDetailsUpdateForm" enctype="multipart/form-data">
                @csrf
                
            
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-hover" id="personalDetailsUpdateSubmitBtn">Update</button>
        </div>
        </form>
    </div>
  </div>
</div>