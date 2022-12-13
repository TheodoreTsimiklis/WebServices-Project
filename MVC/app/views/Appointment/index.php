<?php require APPROOT . '/views/includes/header.php'; ?>

<h1 class="d-flex justify-content-center">Set Appointment</h1>
<div class="row d-flex justify-content-center">
    <div class="col">
        <section class="position-relative py-4 py-xl-5">
            <div class="container">
                <div class="d-flex justify-content-center" style="border-color: rgb(194,218,242);">
                
                    <form method="POST" enctype="multipart/form-data">
                       
                        <label class="form-label fs-3 fw-bold">Hospital:</label>
                        <?php
                        echo 
                        '<select name="hospital" id="hospital" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                            <option selected>Choose a hospital</option>';
                            
                            foreach ($data['hospitals'] as $item) {
                                echo '<option value='.$item['hospital_id'].'>'.$item['hospital_name'].'</option>';
                            }    
                        echo '</select>
                            <div>                 
                                <a class="btn btn-info mt-1" href="'.$data['cdn_url']['fileURL'].'" role="button" download> 
                                    Hospital Details
                                </a>
                            </div>';
                         ?>
                            <label class="form-label fs-3 fw-bold" style="margin-top: 11px;">Date and Time:</label>
                                <input class="border-1 form-control form-control-lg" type="datetime-local" name="datetime" id="datetime" required>
                            <div class="d-flex justify-content-center">
                                
                            <button class="btn btn-danger fs-3" type="submit" name="submit" style="padding-top: 6px;margin-top: 83px;">Book Appointment</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
</div>
</section>
<?php require APPROOT . '/views/includes/footer.php'; ?>