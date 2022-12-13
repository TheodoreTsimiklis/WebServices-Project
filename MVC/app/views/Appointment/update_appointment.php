<?php require APPROOT . '/views/includes/header.php';  ?>
<h1 class="d-flex justify-content-center">Update Appointment</h1>
            <div class="row d-flex justify-content-center">
                <div class="col">
                    <section class="position-relative py-4 py-xl-5">
                        <div class="container">
                            <div class="d-flex justify-content-center" style="border-color: rgb(194,218,242);">
                                <form method="POST" enctype="multipart/form-data">
                                    <label class="form-label fs-3 fw-bold">Hospital Information:</label>
                                     <p class="fs-4">
                                        <?php 
                                        // var_dump($data);
                                        $arr = json_decode($data, true);
                                        
                                        echo $arr[0]['hospital_name'];                                        
                                        ?>
                                    </p>
                                    <p class="fs-4">
                                        <?php 
                                        $arr = json_decode($data, true);                                     
                                        echo $arr[0]['hospital_street']. ', '. $arr[0]['city'] . ', ' . $arr[0]['province'] . ' ' . $arr[0]['postal_code'];
                                        ?>
                                    </p>
                                    <label class="form-label fs-3 fw-bold" style="margin-top: 11px;">Date and Time:</label>
                                    <input class="border-1 form-control form-control-lg" type="datetime-local" name="datetime" id="datetime" required>
                                    
                                    <div class="d-flex justify-content-center" style="margin-top: -42px;">
                                        
                                        <?php 
                                        echo '<div style="margin-top: 83px;">';
                                        // echo $arr[0]['appointment_ID'];


                                        //   echo '
                                                                
                                        //                             <button class="btn btn-warning" type="submit" name="updateAppointment" style="margin-right: 8px;">
                                        //                             <a href="' .URLROOT . '/Appointment/update_appointment/'.$arr[0]['appointment_ID'].'" style="text-decoration:none">
                                        //                                 Update
                                        //                             </a></button>
                                                                
                                        //                     ';
                                    //    echo '<a href="' .URLROOT . '/Appointment/update_appointment/'.$arr[0]['appointment_ID'].'">';

                                        echo '<button class="btn btn-danger fs-3" type="submit" name="updateAppointment" >Update Appointment</button> ';
                                    //    echo '</a>';

                                        echo '</div>';
                                        ?>

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
