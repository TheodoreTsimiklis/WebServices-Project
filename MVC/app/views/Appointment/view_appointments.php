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
                                                <th>DateTime</th>
                                                <th></th>
                                                <th></th>
                                                <!-- <th class="text-center"></th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php 
                                            $arr = json_decode($data, true);
                                            foreach ($arr as $item) {
                                                echo '<tr>';
                                                echo '<td>'.$item['appointment_ID'].'</td>';
                                                echo '<td>'.$item['hospital_name'].'</td>';
                                                echo '<td>'.$item['hospital_street']. ', '. $item['city'] . ', ' . $item['province'] . ' ' . $item['postal_code'] .  '</td>';
                                                echo '<td>'.$item['date_time'].'</td>';
                                                echo '<td>
                                                        <a href="' .URLROOT . '/Appointment/getAppointment/'.$item['appointment_ID'].'">
                                                            <button class="btn btn-warning" type="submit" name="updateSubmit" style="margin-right: 8px;">Update</button>
                                                        </a>
                                                     </td>';
                                                echo    '<td>
                                                        <a style="text-decoration: none" href="' .URLROOT . '/Appointment/deleteAppointment/'.$item['appointment_ID'].'">
                                                            <button class="btn btn-danger" type="submit" name="deleteSubmit" style="margin-right: 8px;">Cancel</button>
                                                        </a>
                                                    </td>';
                                                echo '</tr>';
                                                
                                            }
                                            // }
                                            ?>                                           
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
