<?php require APPROOT . '/views/includes/header.php';  ?>
<h1 class="d-flex justify-content-center">Appointment Status</h1>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <section class="position-relative py-4 py-xl-5">
                        <div class="container">
                            <div class="d-flex justify-content-center" style="border-color: rgb(194,218,242);">
                                <p class="fs-4 border rounded-0 border-2 border-secondary">
                                <?php   ;
                                    
                                    if (!empty($data['appointment'])) {
                                        if ($data['response']['appointmentStatus']) {
                                            echo "Appointment booking for " . $data['appointment']['donor_Name'].' successful!'.'</br>';
                                            echo "Date and Time of appointment: " . date("F-d-Y h:i", strtotime($data['appointment']['date_Time'])).'</br>';
                                            echo "Appointment sent to email: " . $data['appointment']['email'].'</br>';
                                        }
                                        else {
                                            echo "Appointnment Booking failed!";
                                        }
                                    }

                                    if (!empty($data['message'])) {
                                        echo $data['message'];
                                    }
                                    
                                ?>
                                </p>
                            </div>
                            <div class="fs-5 d-flex justify-content-center" style="border-color: rgb(194,218,242);">
                                <a href="<?php echo URLROOT; ?>/appointment/view_appointments">
                                View My Appointments
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
<?php require APPROOT . '/views/includes/footer.php';  ?>
