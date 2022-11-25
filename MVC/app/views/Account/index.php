<?php require APPROOT . '/views/includes/header.php'; ?>

 <div class="row mb-5">
                <div class="col">
                    <h2 class="text-center">MY ACCOUNT</h2>
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6 col-xl-4">
                            <div class="card mb-5">
                                <div class="card-body d-flex flex-column align-items-center">
                                    <form class="text-center" method="post">
                                        <div class="mb-3"><label class="form-label fs-4 fw-semibold d-flex justify-content-start">Name:</label><input class="form-control-plaintext" type="text" value="John Doe" readonly=""></div>
                                        <div class="mb-3"><label class="form-label fs-4 fw-semibold d-flex justify-content-start">Email:</label><input class="form-control-plaintext" type="text" value="johndoe@gmail.com" readonly=""></div>
                                        <div class="mb-3"><label class="form-label fs-4 fw-semibold d-flex justify-content-start">Username:</label><input class="form-control-plaintext" type="text" value="its_johndoe" readonly=""></div>
                                        <div class="mb-3"></div>
                                        <div class="mb-3"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require APPROOT . '/views/includes/footer.php'; ?>
