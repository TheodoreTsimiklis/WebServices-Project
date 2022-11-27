<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Blood Donation</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Hero-Clean-Reverse-images.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Login-Form-Basic-icons.css">
</head>

<body>
    <section class="position-relative py-4 py-xl-5">
        <div class="container py-4 py-xl-5">
            <nav class="navbar navbar-light navbar-expand-md py-3" style="margin-top: -42px;--bs-body-bg: #7a6b6b;">
                <div class="container"><a class="navbar-brand d-flex align-items-center" href="<?php echo URLROOT; ?>/Home/index"><span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-droplet-fill text-danger">
                                <path d="M8 16a6 6 0 0 0 6-6c0-1.655-1.122-2.904-2.432-4.362C10.254 4.176 8.75 2.503 8 0c0 0-6 5.686-6 10a6 6 0 0 0 6 6ZM6.646 4.646l.708.708c-.29.29-1.128 1.311-1.907 2.87l-.894-.448c.82-1.641 1.717-2.753 2.093-3.13Z"></path>
                            </svg></span><span>BLOOD DONATION</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-2"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navcol-2">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item"><a class="nav-link active" href="<?php echo URLROOT; ?>/Home/index">HOME</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/About/index">ABOUT</a></li>
                            <!--<li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/Login/index">LOGIN</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/Login/signup">SIGNUP</a></li>-->
                            <!--MODIFY FOR MAKING HEADER CHANGED WHEN LOGGED IN (UNCOMMENT WHEN CODED)-->
                            <?php
                            if (isLoggedIn()) {
                                echo '<li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>Dashboard/index">DASHBOARD</a></li>'; // to fix href
                                echo '<li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>Login/logout">Logout</a></li>';// to fix href 
                            } else {
                                echo '<li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/Login/index">LOGIN</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="<?php echo URLROOT; ?>/Login/signup">SIGNUP</a></li>';
                            }
 
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>
