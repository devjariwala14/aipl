<?php include "db_connect.php";
$obj = new DB_Connect();
date_default_timezone_set('Asia/Kolkata');
session_start();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <title>AIPL</title>
        <meta name="description" content="Resonance — One &amp; Multi Page Creative Template">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Favicon -->
        <link rel="icon" href="images/favicon.png" type="image/png" sizes="any">
        <link rel="icon" href="images/favicon.svg" type="image/svg+xml">

        <!-- CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/style-responsive.css">
        <link rel="stylesheet" href="css/vertical-rhythm.min.css">
        <link rel="stylesheet" href="css/magnific-popup.css">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/splitting.css">
        <link rel="stylesheet" href="css/YTPlayer.css">
        <link rel="stylesheet" href="css/demo-main/demo-main.css">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&amp;display=swap"
            rel="stylesheet">

    </head>

    <body class="appear-animate"></body>

    <!-- Page Loader -->
    <div class="page-loader">
        <div class="loader">Loading...</div>
    </div>
    <!-- End Page Loader -->

    <!-- Skip to Content -->
    <a href="#main" class="btn skip-to-content">Skip to Content</a>
    <!-- End Skip to Content -->

    <!-- Page Wrap -->
    <div class="page" id="top">

        <!-- Navigation Panel -->
        <nav class="main-nav transparent stick-fixed wow-menubar">
            <div class="main-nav-sub full-wrapper">
                <div class="nav-logo-wrap local-scroll">
                    <a href="index.php" class="logo">
                        <img src="images/AIPL Logo.png" alt="Your Company Logo" width="105" height="34">
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="mobile-nav" role="button" tabindex="0">
                    <i class="mobile-nav-icon"></i>
                    <span class="visually-hidden">Menu</span>
                </div>

                <!-- Main Menu -->
                <div class="inner-nav desktop-nav">
                    <ul class="clearlist local-scroll">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="#" class="mn-has-sub">Products <i class="mi-chevron-down"></i></a>
                            <!-- Sub Megamenu -->
                            <ul class="mn-sub mn-has-multi">
                                <li class="mn-sub-multi">
                                    <span class="mn-group-title">Steel Plates & Coils</span>
                                    <ul>
                                        <li><a href="product.php?id=1">Alloy Steel Plate</a></li>
                                        <li><a href="product.php?id=2">High Tensile Steel Plates</a></li>
                                        <li><a href="product.php?id=3">Wear Resistant Steel Plates</a></li>
                                        <li><a href="product.php?id=4">Mild Steel Plates</a></li>
                                        <li><a href="product.php?id=5">Boiler Quality Plates</a></li>
                                        <li><a href="product.php?id=6">Chequered Steel Plates</a></li>
                                        <li><a href="product.php?id=7">Carbon Steel Plate</a></li>
                                        <li><a href="product.php?id=8">Mild Carbon Steel</a></li>
                                        <li><a href="product.php?id=9">Hot Rolled Coil</a></li>
                                        <li><a href="product.php?id=10">PPGI Coils</a></li>

                                    </ul>
                                </li>
                                <li class="mn-sub-multi">
                                    <span class="mn-group-title">Steel & Bars</span>
                                    <ul>
                                        <li><a href="">Angles</a></li>
                                        <li><a href="">Beams</a></li>
                                        <li><a href="">Colums</a></li>
                                        <li><a href="">Round Bars</a></li>
                                        <li><a href="">Square Bars</a></li>
                                        <li><a href="">Pipes</a></li>
                                        <li><a href="">Tubes</a></li>
                                        <li><a href="">Crane Rails</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- End Sub Megamenu -->
                        </li>
                        <!-- <li><a href="service.php">Services</a></li> -->
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="service.php">Services</a></li>
                    </ul>

                    <ul class="items-end clearlist">

                        <!-- Languages -->
                        <li>
                            <a href="#" class="mn-has-sub opacity-1">En <i class="mi-chevron-down"></i></a>
                            <ul class="mn-sub to-left">
                                <li><a href="#">English</a></li>
                                <li><a href="#">French</a></li>
                                <li><a href="#">German</a></li>
                            </ul>
                        </li>
                        <!-- End Languages -->
                        <li><a href="contact.php" class="opacity-1 no-hover"><span class="link-hover-anim underline"
                                    data-link-animate="y">Let's work together</span></a></li>
                    </ul>
                </div>
                <!-- End Main Menu -->
            </div>
        </nav>
        <!-- End Navigation Panel -->