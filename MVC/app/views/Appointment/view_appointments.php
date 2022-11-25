<?php require APPROOT . '/views/includes/header.php';  ?>
<h1 class="d-flex justify-content-center">My Appointments</h1>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <section class="position-relative py-4 py-xl-5">
                        <h3 class="d-flex justify-content-center">Incoming Appointments</h3>
                        <div class="container">
                            <div class="d-flex justify-content-center" style="border-color: rgb(194,218,242);">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Hospital&nbsp;</th>
                                                <th>Address</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th class="text-center">Action&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Cell 1</td>
                                                <td>Cell 2</td>
                                                <td>Cell 3</td>
                                                <td>Cell 3</td>
                                                <td>Cell 3</td>
                                                <td><button class="btn btn-warning" type="button" style="margin-right: 8px;">Update</button><button class="btn btn-danger" type="button">Cancel</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h3 class="d-flex justify-content-center">Appointment History</h3>
                            <div class="d-flex justify-content-center" style="border-color: rgb(194,218,242);">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Hospital&nbsp;</th>
                                                <th>Address</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Cell 1</td>
                                                <td>Cell 2</td>
                                                <td>Cell 3</td>
                                                <td>Cell 3</td>
                                                <td>Cell 3</td>
                                            </tr>
                                            <tr></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
<?php require APPROOT . '/views/includes/footer.php';  ?>
