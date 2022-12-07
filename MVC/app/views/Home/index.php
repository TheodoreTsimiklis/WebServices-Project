<?php require APPROOT . '/views/includes/header.php';  ?>
<div class="row gy-4 gy-md-0">
    <div class="col-md-6">
        <div class="p-xl-5 m-xl-5" style="padding-left: 0px;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;"><img class="rounded img-fluid w-100 fit-cover" style="min-height: 300px;" src="https://reliantmedicalgroup.org/wp-content/uploads/2020/04/GettyImages-1030773064.jpg"></div>
    </div>
    <div class="col-md-6 d-md-flex align-items-md-center">
        <div style="max-width: 350px;">
        <h2 class="text-uppercase fw-bold">Donate Blood Now.<br>Help save people who need blood transfusions</h2>
        <p class="my-3">By donating your blood, you have the opportunity to help someone in need.</p>
            <?php
            if (isLoggedIn()) {
                echo '<a class="btn btn-primary btn-lg me-2" role="button" href="' . URLROOT . '/Appointment/index">Book an Appointment</a>';
            }
            else {
                echo '<a class="btn btn-primary btn-lg me-2" role="button" href="' . URLROOT . '/Login/index">Book an Appointment</a>';
            }
            
            ?>
        </div>
    </div>
</div>
</div>
</section>
<?php require APPROOT . '/views/includes/footer.php';  ?>