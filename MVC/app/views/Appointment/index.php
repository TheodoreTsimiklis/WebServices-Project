<?php require APPROOT . '/views/includes/header.php';  ?>
<h1 class="d-flex justify-content-center">Set Appointment</h1>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <section class="position-relative py-4 py-xl-5">
                        <div class="container">
                            <div class="d-flex justify-content-center" style="border-color: rgb(194,218,242);">
                                <form><label class="form-label fs-3 fw-bold">Hospital:</label>
                                    <div class="dropdown"><button class="btn btn-secondary btn-lg dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">Choose a hospital</button>
                                        <div class="dropdown-menu"><a class="dropdown-item" href="#">First Item</a><a class="dropdown-item" href="#">Second Item</a><a class="dropdown-item" href="#">Third Item</a></div>
                                    </div><label class="form-label fs-3 fw-bold" style="margin-top: 11px;">Date and Time:</label><input class="border-1 form-control form-control-lg" type="datetime-local" name="datetime">
                                    <div class="d-flex justify-content-center"><button class="btn btn-danger fs-3" type="button" style="padding-top: 6px;margin-top: 83px;">Book Appointment</button></div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
<?php require APPROOT . '/views/includes/footer.php';  ?>
