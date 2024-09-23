<?php
include "db_connect.php";
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
        <link href="dashboard/assets/img/aipl_favi.png" rel="icon">
        <link href="dashboard/assets/img/AIPL_Logo.png" rel="apple-touch-icon">

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

        <script type="text/javascript">
            function createCookie(name, value, days) {
                var expires;
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toGMTString();
                } else {
                    expires = "";
                }
                document.cookie = name + "=" + value + expires + "; path=/";
            }

            function readCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i];
                    while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            function eraseCookie(name) {
                createCookie(name, "", -1);
            }

            function redirect_product(pid) {
                createCookie("pro_id", pid, 1);
                window.location = "product.php";
            }

            function redirect_services(id) {
                createCookie("id", id, 1);
                window.location = "services.php";
            }
        </script>
    </head>

    <body class="appear-animate">

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
            <nav class="main-nav bg-white stick-fixed wow-menubar">
                <div class="main-nav-sub full-wrapper">
                    <div class="nav-logo-wrap local-scroll">
                        <a href="index.php" class="logo">
                            <img src="images/AIPL Logo.png" alt="Your Company Logo" width="105" >
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
                            <li>
                                <a href="#" class="mn-has-sub">Product <i class="mi-chevron-down"></i></a>
                                <!-- Sub Megamenu -->
                                <ul class="mn-sub mn-has-multi">
                                    <li class="mn-sub-multi">
                                        <ul>
                                            <?php
                                            $stmt = $obj->con1->prepare("SELECT * FROM `product` WHERE LOWER(status)='enable'");
                                            $stmt->execute();
                                            $prod_res = $stmt->get_result();
                                            $stmt->close();
                                            while ($products = mysqli_fetch_array($prod_res)) {
                                                ?>
                                                <li>
                                                    <a
                                                        href="javascript:redirect_product(<?php echo $products["id"] ?>)"><?php echo $products["name"] ?></a>
                                                </li>
                                                <?php
                                                }
                                            ?>
                                        </ul>
                                    </li>
                                </ul>
                                <!-- End Sub Megamenu -->
                            </li>
                            <!-- Item With Sub -->
                            <li>
                                <a href="#" class="mn-has-sub">Services <i class="mi-chevron-down"></i></a>
                                <!-- Sub Megamenu -->
                                <ul class="mn-sub mn-has-multi">
                                    <li class="mn-sub-multi">
                                        <ul>
                                            <?php
                                            $stmt = $obj->con1->prepare("SELECT * FROM `services` WHERE LOWER(status)='enable'");
                                            $stmt->execute();
                                            $serv_res = $stmt->get_result();
                                            $stmt->close();
                                            while ($services = mysqli_fetch_array($serv_res)) {
                                                ?>
                                                <li>
                                                    <a
                                                        href="javascript:redirect_services(<?php echo $services["id"] ?>)"><?php echo $services["service_name"] ?></a>
                                                </li>
                                                <?php
                                                }
                                            ?>
                                        </ul>
                                    </li>
                                </ul>
                                <!-- End Sub Megamenu -->
                            </li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                    <!-- End Main Menu -->
                </div>
            </nav>
            <!-- End Navigation Panel -->

        </div>
        <!-- End Page Wrap -->

    </body>

</html>