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

        <script>

            function test(pid) {
                //   alert("hi!");
                document.cookie = "product_id=" + pid;

                window.location = "htsp.php";
            }

        </script>
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
                        <!-- Item With Sub -->
                        <li>
                            <a href="#" class="mn-has-sub">Products <i class="mi-chevron-down"></i></a>
                            <?php
                            $stmt = $obj->con1->prepare("SELECT `id`,`category` FROM `product_category` WHERE `status`='Enable' ORDER BY `id` DESC");
                            $stmt->execute();
                            $Resp = $stmt->get_result();
                            $i = 1;
                            $stmt->close();
                            // echo $row['category'];
                            ?>
                            <!-- Sub -->
                            <ul class="mn-sub">
                                <?php while ($row = mysqli_fetch_array($Resp)) {
                                    $stmt_sub = $obj->con1->prepare("SELECT * FROM `product` WHERE `cat_id`=? AND `status`='Enable'");
                                    $stmt_sub->bind_param('i', $row['id']);
                                    $stmt_sub->execute();
                                    $Resp_sub = $stmt_sub->get_result();
                                    $i = 1;
                                    $stmt_sub->close();
                                    ?>
                                    <li>
                                        <a href="#" class="mn-has-sub"><?php echo $row['category'] ?><i
                                                class="mi-chevron-right right"></i></a>
                                        <ul class="mn-sub">
                                            <?php while ($row_sub = mysqli_fetch_array($Resp_sub)) { ?>
                                                <li>


                                                    <a
                                                        href="javascript:test('<?= $row_sub['id'] ?>')"><?= $row_sub['name'] ?></a>
                                                </li>
                                            </ul>
                                        </li>
                                        <?php
                                            }
                                        $i++;
                                    }
                                ?>
                                <!-- 
                                    <li>
                                        <a href="#" class="mn-has-sub">Steel & Bars <i
                                                class="mi-chevron-right right"></i></a>

                                        <ul class="mn-sub">
                                            <li>
                                                <a href="main-portfolio-wide-2col.html" target="_blank">2 Columns</a>
                                            </li>
                                            <li>
                                                <a href="main-portfolio-wide-3col.html" target="_blank">3 Columns</a>
                                            </li>
                                            <li>
                                                <a href="main-portfolio-wide-4col.html" target="_blank">4 Columns</a>
                                            </li>
                                        </ul>
                                    </li> -->
                            </ul>
                            <!-- End Sub -->
                        </li>
                        <!-- End Item With Sub -->
                        <!-- <li><a href="service.php">Services</a></li> -->
                        <li><a href="contact.php">Contact</a></li>
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