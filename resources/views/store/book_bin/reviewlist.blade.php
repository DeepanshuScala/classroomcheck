<?php
    if (count($reviewArr) > 0) {
        foreach ($reviewArr as $row) {
            $img = DB::table('users')->select('image')->where('id',$row['user_id'])->first();
            $imglink = url('images/profile.png');
            if(!is_null($img)){
                
                if(!empty($img->image)){
                    $imglink = Storage::disk('s3')->url('profile_picture/'.$img->image);
                }
            }
            $role = ($row['role_id'] == 1) ? 'Buyer' : 'Seller';
?>
    <div class="rating-list mb-5">
        <div class="profile-title d-md-flex justify-content-between">
            <?php  
            /*
            <div class="title-p">
                <h4>Figerative Language Posters</h4>
            </div>
            */?>
            <div class="date-pro">
                <p><i class="fal fa-calendar me-2"></i> {{ date('F d, Y',strtotime($row['created_at'])) }}</p>
            </div>
        </div>
        <div class="d-flex profile-img align-items-center">
            <div class="profile-img me-3">
                <img src="{{$imglink}}" alt="profile" class="img-fluid">
            </div>
            <div class="text-pro">
                <h6>{{ $row['reviewer_user_name'] }} (Buyer)</h6>
                <div class="rating-icon d-flex align-items-center">
                    <ul class="rating d-flex flex-row justify-content-start ps-0 me-2 mb-0">
                        <?php
                        for ($x = 1; $x <= $row['rating']; $x++) {
                            echo "<li><i class='fas fa-star text-yellow'></i></li>";
                        }
                        if (strpos($row['rating'], '.')) {
                            echo "<li><i class='fas fa-star-half-alt text-yellow'></i></li>";
                            $x++;
                        }
                        while ($x <= 5) {
                            echo "<li><i class='fal fa-star text-muted'></i></li>";
                            $x++;
                        }
                        ?>
                    </ul>
                    <p>{{ $row['rating'] }} Rating</p>
                </div>
            </div>
        </div>
        <div class="content-p mt-3">
            <?php if ($row['rating'] == 1) { ?>
                <p class="green-text">Poor</p>
            <?php } else if ($row['rating'] == 2) { ?>
                <p class="green-text">Average</p>
            <?php } else if ($row['rating'] == 3) { ?>
                <p class="green-text">Good</p>
            <?php } else if ($row['rating'] == 4) { ?>
                <p class="green-text">Satisfied</p>
            <?php } else if ($row['rating'] == 5) { ?>
                <p class="green-text">Very Satisfied</p>
            <?php } else { ?>
                <p class="green-text">Poor</p>
            <?php } ?>
            <div class="description">
                <p>{{ $row['review'] }}</p>
            </div>
        </div>
    </div>
        <?php
    }
}