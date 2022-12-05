<?php require APPROOT . '/views/includes/header.php';  ?>
<h1 class="d-flex justify-content-center">Update Appointment</h1>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <section class="position-relative py-4 py-xl-5">
                        <div class="container">
                            <div class="d-flex justify-content-center" style="border-color: rgb(194,218,242);">
                                <form method="POST" enctype="multipart/form-data">
                                    <label class="form-label fs-3 fw-bold">Hospital:</label>
                                    <p class="fs-4">Address Information</p>
                                    <label class="form-label fs-3 fw-bold" style="margin-top: 11px;">Date and Time:</label>
                                    <input class="border-1 form-control form-control-lg" type="datetime-local" name="datetime" id="datetime">
                                    <div class="d-flex justify-content-center" style="margin-top: -42px;">
                                        <button class="btn btn-danger fs-3" type="submit"  name="submit" style="padding-top: 6px;margin-top: 83px;">Update Appointment</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
<?php require APPROOT . '/views/includes/footer.php';  ?>
