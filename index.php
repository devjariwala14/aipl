<?php
include "header.php";
?>

<main id="main">

    <!-- Home Section -->
    <section class="home-section bg-gray-light-1 bg-light-alpha-90 parallax-5 parallax-mousemove-scene"
        style="background-image: url(images/full-width-images/section-bg-1.jpg)" id="home">
        <div class="container min-height-100vh d-flex align-items-center pt-100 pb-100 pt-sm-120 pb-sm-120">
            <!-- Home Section Content -->
            <div class="home-content text-start">
                <div class="row">

                    <!-- Home Section Text -->
                    <div class="col-md-6 d-flex align-items-center mb-sm-60">
                        <div>
                            <h2 class="section-caption text-color mb-30 mb-xs-10 wow fadeInUp" data-wow-duration="1.2s">
                                AIPL</h2>
                            <h1 class="hs-title-1 mb-30"><span class="wow charsAnimIn" data-splitting="chars">Building a
                                    Stronger Future Together</span>
                            </h1>
                            <p class="section-descr mb-50 wow fadeInUp" data-wow-delay="0.6s" data-wow-duration="1.2s">
                                Join us in constructing the infrastructure of tomorrow with our superior
                                steel
                                products.
                            </p>

                            <div class="local-scroll mt-n10 wow fadeInUp wch-unset" data-wow-delay="0.7s"
                                data-wow-duration="1.2s" data-wow-offset="0">
                                <a href="contact.php"
                                    class="btn btn-mod btn-large btn-round btn-hover-anim align-middle me-2 me-sm-5 mt-10"><span>Discover
                                        now</span></a>
                                <a href="https://www.youtube.com/watch?v=jTea_8Fk5Ns"
                                    class="link-hover-anim align-middle lightbox mfp-iframe mt-10"
                                    data-link-animate="y"><i class="icon-play size-13 me-1"></i> How it
                                    works?</a>
                            </div>

                        </div>
                    </div>
                    <!-- End Home Section Text -->

                    <!-- Stack Images -->
                    <div class="col-md-5 offset-md-1 d-flex align-items-center">
                        <div class="stack-images">

                            <div class="stack-images-1 parallax-mousemove" data-offset="30">
                                <div class="wow clipRightIn" data-wow-delay="1.2s" data-wow-duration="1.75s">
                                    <img src="images/AIPL/14.png" alt="Image Description">
                                </div>
                            </div>

                            <div class="stack-images-2 parallax-mousemove" data-offset="60">
                                <div class="wow clipRightIn" data-wow-delay="1.7s" data-wow-duration="1.75s">
                                    <img src="images/AIPL/12.png" alt="Image Description">
                                </div>
                            </div>

                            <div class="stack-images-3 parallax-mousemove" data-offset="90">
                                <div class="wow clipRightIn" data-wow-delay="2.2s" data-wow-duration="1.75s">
                                    <img src="images/AIPL/13.png" alt="Image Description" width="600">
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End Stack Images -->

                </div>
            </div>
            <!-- End Home Section Content -->

            <!-- Scroll Down -->
            <div class="local-scroll scroll-down-wrap-type-1 wow fadeInUp" data-wow-offset="0">
                <div class="container">
                    <a href="#about" class="scroll-down-1">
                        <div class="scroll-down-1-icon">
                            <i class="mi-arrow-down"></i>
                        </div>
                        <div class="scroll-down-1-text">Scroll Down</div>
                    </a>
                </div>
            </div>
            <!-- End Scroll Down -->

        </div>
    </section>
    <!-- End Home Section -->


    <!-- About Section -->
    <section class="page-section" id="about">
        <div class="container position-relative">

            <div class="row mb-60 mb-xs-30">

                <div class="col-md-6">
                    <h2 class="section-caption text-color mb-xs-10">Our Story</h2>
                    <h3 class="section-title mb-0"><span class="wow charsAnimIn" data-splitting="chars">From
                            Humble Beginnings to Industry Leader</span></h3>
                </div>

                <div class="col-md-5 offset-md-1 relative text-start text-md-end pt-40 pt-sm-20 local-scroll">

                    <!-- Decorative Dots -->
                    <div class="decoration-2 d-none d-md-block" data-rellax-y="" data-rellax-speed="0.7"
                        data-rellax-percentage="-0.2">
                        <img src="images/decoration-2.svg" alt="">
                    </div>
                    <!-- End Decorative Dots -->

                    <a href="about.php" class="link-hover-anim underline align-middle" data-link-animate="y">Learn
                        more about us <i class="mi-arrow-right size-18"></i></a>

                </div>

            </div>

            <div class="row wow fadeInUp" data-wow-delay="0.5s">

                <div class="col-lg-6 mb-md-60">
                    <div class="position-relative">

                        <!-- Image -->
                        <div class="position-relative overflow-hidden">
                            <!-- <video autoplay="autoplay">
                                        <source src="images/video.mp4" type="video/mp4">
                                      </video> -->
                            <img src="images/about-image.png" class="image-fullwidth relative" alt="Image Description">
                        </div>
                        <!-- End Image -->

                        <!-- Decorative Waves -->
                        <div class="decoration-1 d-none d-sm-block" data-rellax-y="" data-rellax-speed="1"
                            data-rellax-percentage="0.1">
                            <img src="images/decoration-1.svg" alt="">
                        </div>
                        <!-- End Decorative Waves -->

                    </div>
                </div>
                <?php
                $stmt = $obj->con1->prepare("SELECT * FROM `about_us` ORDER BY `id` DESC");
                $stmt->execute();
                $Resp = $stmt->get_result();
                $i = 1;
                while ($row = mysqli_fetch_array($Resp)) { ?>

                    <div class="col-lg-6 col-xl-5 offset-xl-1">
                        <h4 class="h5">Our Mission</h4>
                        <p class="text-gray">
                            <?php echo $row["vision"] ?>

                        </p>
                        <h4 class="h5">Our Vision</h4>
                        <p class="text-gray">
                            <?php echo $row["mission"] ?>
                        </p>
                    </div>
                <?php } ?>

            </div>

        </div>
    </section>
    <!-- End About Section -->


    <!-- Achievements Section -->
    <section class="page-section bg-dark-1 bg-dark-alpha-90 parallax-5 light-content"
        style="background-image: url(images/full-width-images/section-bg-2.jpg)">
        <div class="container position-relative">

            <div class="row">

                <div class="col-lg-4 mb-md-60 mb-xs-50">

                    <h2 class="section-title mb-20 wow fadeInUp">Check recent achievements.</h2>

                    <p class="section-descr mb-40 wow fadeInUp" data-wow-delay="0.1s">
                        We provide the effective ideas that grow businesses of our clients.
                    </p>

                    <div class="local-scroll wow fadeInUp" data-wow-delay="0.2s">
                        <a href="contact.php" class="btn btn-mod btn-w btn-large btn-round btn-hover-anim"><span>Request
                                Price</span></a>
                    </div>

                </div>

                <div class="col-lg-7 offset-lg-1">

                    <!-- Numbers Grid -->
                    <div class="row mt-n50 mt-xs-n30">

                        <!-- Number Item -->
                        <div class="col-sm-6 col-lg-5 mt-50 mt-xs-30 wow fadeScaleIn" data-wow-delay="0.4s">
                            <div class="number-title mb-10">
                                120k
                            </div>
                            <div class="number-descr">
                                Delivering over 120k metric tons of steel annually, meeting the demands
                                of
                                diverse industries with precision and efficiency.
                            </div>
                        </div>
                        <!-- End Number Item -->

                        <!-- Number Item -->
                        <div class="col-sm-6 col-lg-5 offset-lg-2 mt-50 mt-xs-30 wow fadeScaleIn" data-wow-delay="0.6s">
                            <div class="number-title mb-10">
                                20+
                            </div>
                            <div class="number-descr">
                                Serving clients across 20+ countries, establishing a strong
                                international
                                reputation for quality and reliability.
                            </div>
                        </div>
                        <!-- End Number Item -->

                        <!-- Number Item -->
                        <div class="col-sm-6 col-lg-5 mt-50 mt-xs-30 wow fadeScaleIn" data-wow-delay="0.8s">
                            <div class="number-title mb-10">
                                30+
                            </div>
                            <div class="number-descr">
                                Over 30+ years of experience in the steel industry, providing expertise
                                and
                                reliability to customers worldwide.
                            </div>
                        </div>
                        <!-- End Number Item -->

                        <!-- Number Item -->
                        <div class="col-sm-6 col-lg-5 offset-lg-2 mt-50 mt-xs-30 wow fadeScaleIn" data-wow-delay="1s">
                            <div class="number-title mb-10">
                                35+
                            </div>
                            <div class="number-descr">
                                there are 35+ loading hubs in the abhishekispat.
                            </div>
                        </div>
                        <!-- End Number Item -->
                    </div>
                    <!-- End Numbers Grid -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Achievements Section -->

    <!-- Divider -->
    <hr class="mt-0 mb-0">
    <!-- End Divider -->


    <!-- Call Action Section -->
    <section class="page-section">
        <div class="container position-relative">

            <!-- Decorative Waves -->
            <div class="decoration-3 d-none d-sm-block" data-rellax-y="" data-rellax-speed="-0.7"
                data-rellax-percentage="0.5">
                <img src="images/decoration-3.svg" alt="">
            </div>
            <!-- End Decorative Waves -->

            <div class="row text-center wow fadeInUp">
                <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                    <p class="section-descr mb-50 mb-sm-30">
                        Planting the seeds of growth and success. South Gujarat's premier integrated
                        plant
                        providing innovative solutions for all your needs.
                    </p>
                    <div class="local-scroll">
                        <a href="contact.php" class="btn btn-mod btn-large btn-round btn-hover-anim"><span>Contact
                                us</span></a>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Call Action Section -->

    <!-- Divider -->
    <hr class="mt-0 mb-0">
    <!-- End Divider -->


    <!-- Promo Section -->
    <section class="page-section">
        <div class="container position-relative">

            <!-- Decorative Dots -->
            <div class="decoration-4 d-none d-lg-block" data-rellax-y="" data-rellax-speed="-0.5"
                data-rellax-percentage=".7">
                <img src="images/decoration-2.svg" alt="">
            </div>
            <!-- End Decorative Dots -->

            <div class="row">

                <!-- Text -->
                <div class="col-lg-6 mb-md-60 mb-xs-30 d-flex align-items-center">
                    <div class="wow fadeInUp" data-wow-duration="1.2s" data-wow-offset="205">
                        <div class="row">
                            <div class="col-lg-10">
                                <h2 class="section-title mb-60 mb-sm-30">Steel Solutions Across
                                    Industries
                                </h2>
                            </div>
                        </div>

                        <!-- Features Grid -->
                        <div class="row alt-features-grid">

                            <!-- Features Item -->
                            <div class="col-lg-6">
                                <div class="alt-features-item">
                                    <div class="alt-features-icon">
                                        <img src="images/green-energy.png" alt="">
                                    </div>
                                    <h3 class="alt-features-title">Energy & Power</h3>
                                    <div class="alt-features-descr">
                                        Offering steel solutions for the energy sector, including oil
                                        and
                                        gas
                                        pipelines, wind turbines, and power plant components to support
                                        energy
                                        production and distribution.
                                    </div>
                                </div>
                            </div>
                            <!-- End Features Item -->

                            <!-- Features Item -->
                            <div class="col-lg-6">
                                <div class="alt-features-item">
                                    <div class="alt-features-icon">
                                        <img src="images/dump-truck.png" alt="">
                                    </div>
                                    <h3 class="alt-features-title">Construction</h3>
                                    <div class="alt-features-descr">
                                        Providing high-quality structural steel for residential,
                                        commercial,
                                        and
                                        industrial building projects, ensuring durability and safety.
                                    </div>
                                </div>
                            </div>
                            <!-- End Features Item -->

                            <!-- Features Item -->
                            <div class="col-lg-6">
                                <div class="alt-features-item">
                                    <div class="alt-features-icon">
                                        <img src="images/automation.png" alt="">
                                    </div>
                                    <h3 class="alt-features-title">Automotive</h3>
                                    <div class="alt-features-descr">
                                        Supplying steel for the manufacturing of vehicles, including
                                        body
                                        panels, engine parts, and safety components to enhance
                                        performance
                                        and
                                        safety.
                                    </div>
                                </div>
                            </div>
                            <!-- End Features Item -->

                            <!-- Features Item -->
                            <div class="col-lg-6">
                                <div class="alt-features-item">
                                    <div class="alt-features-icon">
                                        <img src="images/infrastructure.png" alt="">
                                    </div>
                                    <h3 class="alt-features-title">Infrastructure</h3>
                                    <div class="alt-features-descr">Delivering steel products for
                                        bridges,
                                        railways, highways, and other critical infrastructure projects,
                                        supporting robust and long-lasting constructions.
                                    </div>
                                </div>
                            </div>
                            <!-- End Features Item -->

                        </div>
                        <!-- End Features Grid -->

                    </div>
                </div>
                <!-- End Text -->

                <!-- Images -->
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="call-action-3-images mt-xs-0 text-end">

                        <div class="call-action-3-image-1">
                            <img src="images/image3.png" alt="Image Description" class="wow scaleOutIn"
                                data-wow-duration="1.2s" data-wow-offset="205">
                        </div>

                        <div class="call-action-3-image-2-wrap d-flex align-items-center">
                            <div class="call-action-3-image-2" data-rellax-y="" data-rellax-speed="0.85"
                                data-rellax-percentage="0.5">
                                <!-- <video width="486px" height="500px" autoplay="autoplay">
                                            <source src="images/video.mp4" type="video/mp4">
                                          </video> -->
                                <img src="images/work 2.png" alt="Image Description" class="wow scaleOutIn"
                                    data-wow-duration="1.2s">
                            </div>
                        </div>

                    </div>
                </div>
                <!-- End Images -->

            </div>

        </div>
    </section>
    <!-- End Promo Section -->

    <!-- Divider -->
    <hr class="mt-0 mb-0">
    <!-- End Divider -->

</main>
<?php
include "footer.php";
?>