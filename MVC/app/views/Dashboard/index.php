<?php require APPROOT . '/views/includes/header.php';  ?>

 <h1 class="d-flex justify-content-center">Hello, <?php echo $_SESSION['name']?></h1>
            <div class="row mb-5">
                <div class="col">
                    <div></div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <section class="position-relative py-4 py-xl-5">
                        <div class="container">
                            <div class="d-flex justify-content-center"><button class="btn btn-danger btn-lg text-uppercase align-self-center" type="button" value="Next" onclick="window.location.href='<?php echo URLROOT; ?>/Account/index'" style="margin-bottom: 24px;" name="myAccount">My Account</button></div>
                            <div class="d-flex justify-content-center"><button class="btn btn-danger btn-lg text-uppercase align-self-center" type="button" value="Next" onclick="window.location.href='<?php echo URLROOT; ?>/Appointment/index'"style="margin-bottom: 24px;">Book Appointment</button></div>
                            <div class="d-flex justify-content-center"><button class="btn btn-danger btn-lg text-uppercase align-self-center" type="button" value="Next" onclick="window.location.href='<?php echo URLROOT; ?>/Appointment/view_appointments'">My Appointments</button></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
<?php require APPROOT . '/views/includes/footer.php';  ?>
