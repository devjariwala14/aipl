<?php
include "header.php";
?>

<main id="main">

    <!-- Home Section -->
    <section class="page-section bg-gradient-gray-light-1 bg-scroll overflow-hidden">

        <!-- Background Shape -->
        <div class="bg-shape-1 wow fadeIn">
            <img src="images/demo-fancy/bg-shape-1.svg" alt="" />
        </div>
        <!-- End Background Shape -->

        <div class="container position-relative pt-10 pt-sm-40 text-center">

            <div class="row">
                <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">

                    <h1 class="hs-title-10 mb-10">
                        <span class="wow charsAnimIn" data-splitting="chars">
                            Our <span class="mark-decoration-3-wrap">Services<b data-wow-delay="0.5s"></b></span>
                        </span>
                    </h1>

                    <p class="section-descr mb-0 wow fadeIn" data-wow-delay="0.2s">Web design that leaves an impression.
                    </p>

                </div>
            </div>

        </div>

    </section>
    <!-- End Home Section -->


    <!-- Services Section -->
    <section class="page-section" id="services">
        <div class="container position-relative">

            <!-- Services Grid -->
            <?php
            $stmt = $obj->con1->prepare("SELECT * FROM `services` ORDER BY `id` DESC");
            $stmt->execute();
            $Resp = $stmt->get_result();
            $i = 1;
            while ($row = mysqli_fetch_array($Resp)) { ?>
                <div class="row services-5-grid">

                    <!-- Services Item -->
                    <div class="col-md-12 d-flex align-items-stretch">
                        <div class="services-5-item d-flex align-items-stretch text-center text-xl-start">
                            <div class="d-xl-flex wow fadeInUpShort" data-wow-offset="0">
                                <div class="services-5-image mb-lg-20 me-xl-4">
                                    <img src="dashboard/images/services/<?php echo $row["image"]; ?>"
                                        alt="Image Description" sizes="auto">
                                </div>
                                <div class="services-5-body d-flex align-items-center">
                                    <div class="w-100">
                                        <h4 class="services-5-title"><?php echo $row["title"] ?></h4>
                                        <p class="services-5-text mb-0">
                                            <?php echo $row["description"] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>












                    <!-- <div class="col-md-6 d-flex align-items-stretch">
                        <div class="services-5-item d-flex align-items-stretch text-center text-xl-start">
                            <div class="d-xl-flex wow fadeInUpShort" data-wow-offset="0">
                                <div class="services-5-image mb-lg-20 me-xl-4">
                                    <img src="dashboard/images/services/<?php echo $row["image"]; ?>"
                                        alt="Image Description">
                                </div>
                                <div class="services-5-body d-flex align-items-center">
                                    <div class="w-100">
                                        <h4 class="services-5-title"><?php echo $row["title"] ?></h4>
                                        <p class="services-5-text mb-0">
                                            <?php echo $row["description"] ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- End Services Item -->



                </div>
                <!-- End Services Grid -->

                <?php $i++;
                }
            ?>
        </div>
    </section>
    <!-- End Services Section -->


    <!-- Divider -->
    <hr class="mt-0 mb-0" />
    <!-- End Divider -->


    <!-- Pricing Section -->

</main>
<?php
include "footer.php";
?>