<?php
include "header.php";
?>
<?php
$stmt = $obj->con1->prepare("SELECT * FROM `about_us` ORDER BY `id` DESC");
$stmt->execute();
$Resp = $stmt->get_result();
$i = 1;
while ($row = mysqli_fetch_array($Resp)) { ?>
    <main id="main">

        <!-- Header Section -->
        <section class="page-section pt-0 pb-0" id="home">

            <div class="page-section bg-gray-light-1 bg-light-alpha-90 parallax-5"
                style="background-image: url(images/full-width-images/section-bg-1.jpg)">
                <div class="container position-relative pt-50 pb-100 pb-sm-20">

                    <!-- Section Content -->
                    <div class="text-center">
                        <div class="row">

                            <!-- Page Title -->
                            <div class="col-md-8 offset-md-2">

                                <h2 class="section-caption-border mb-30 mb-xs-20 wow fadeInUp" data-wow-duration="1.2s">
                                    About Our Company
                                </h2>

                                <h1 class="hs-title-1 mb-30">
                                    <span class="wow charsAnimIn" data-splitting="chars"><?php echo $row["title"] ?></span>
                                </h1>

                                <div class="row">
                                    <div class="col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                                        <p class="section-descr mb-0 wow fadeInUp" data-wow-delay="0.6s"
                                            data-wow-duration="1.2s">
                                            <?php echo $row["description"] ?>
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <!-- End Page Title -->

                        </div>
                    </div>
                    <!-- End Section Content -->

                </div>
            </div>

            <div class="page-section pt-0">
                <div class="container">

                    <div class="mt-n120 mt-sm-n60 overflow-hidden">
                        <img src="dashboard/images/product/<?php echo $row["image"]; ?>" alt="Image Description"
                            class="wow scaleOutIn" data-wow-duration="1.2s" data-wow-offset="0">
                    </div>

                </div>
            </div>
        <?php } ?>

    </section>
    <!-- End Header Section -->
    <!-- Benefits Section -->
    <section class="page-section pt-0">
        <div class="container position-relative">

            <!-- Grid -->
            <div class="row">

                <!-- Text -->
                <div class="col-md-12 col-lg-3 mb-md-50">

                    <h2 class="section-caption mb-xs-10">Primary Benefits</h2>

                    <h3 class="section-title-small mb-40">Why choose AIPL?</h3>

                    <div class="section-line"></div>

                </div>
                <!-- End Text -->
                <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-sm-30">
                    <?php
                    $stmt_list = $obj->con1->prepare("SELECT * FROM `primary_benifits` ORDER BY `id` DESC;");
                    $stmt_list->execute();
                    $result = $stmt_list->get_result();
                    $stmt_list->close();
                    $i = 1;
                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <!-- Feature Item -->

                        <div class="alt-features-item border-left mt-0">
                            <div class="alt-features-icon">
                                <img src="dashboard/images/primary_benifits/<?php echo $row["icon"]; ?>" class="d-block">
                            </div>
                            <h4 class="alt-features-title"><?php echo $row["title"] ?></h4>
                            <div class="alt-features-descr"><?php echo $row["content"] ?></div>
                        </div>
                        <!-- End Feature Item -->
                        <?php
                        $i++;
                        }
                    ?>
                </div>




            </div>
            <!-- End Grid -->

        </div>
    </section>
    <!-- End Benefits Section -->




    <!-- Testimonials Section -->
    <section class="page-section pt-0 pb-0">
        <div class="container position-relative">

            <div class="pt-80 pb-80 pt-sm-70 pb-sm-70 px-4 bg-gray-light-1">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 wow fadeInUp">

                        <div class="row">
                            <div class="col-md-10 offset-md-1 text-center">
                                <h2 class="section-title mb-70 mb-sm-40">AbhishekIspat is trusted by <span
                                        class="mark-decoration-1">100+</span> Compnaies.</h2>
                            </div>
                        </div>

                        <div class="testimonials-slider-1 pb-xs-80">

                            <!-- Slide Item -->
                            <div>
                                <blockquote class="mb-0">

                                    <div class="blockquote-icon" aria-hidden="true">”</div>

                                    <p>
                                        Abhishek Ispat has consistently provided us with top-quality steel
                                        products. Their attention to detail and commitment to customer
                                        service is unmatched.
                                    </p>

                                    <div class="section-line mt-40"></div>

                                    <footer class="ts1-author mt-20 clearfix">
                                        <div class="ts1-author-img float-start">
                                            <img class="rounded-circle" width="44" height="44" src="images/ts1-user.jpg"
                                                alt="Image description is here">
                                        </div>
                                        <div>Rajesh Sharma<div class="small">Global Constructions Ltd.</div>
                                        </div>
                                    </footer>

                                </blockquote>
                            </div>
                            <!-- End Slide Item -->

                            <!-- Slide Item -->
                            <div>
                                <blockquote class="mb-0">

                                    <div class="blockquote-icon" aria-hidden="true">”</div>

                                    <p>
                                        AIPL's innovative approach to steel manufacturing has helped us stay
                                        ahead in the industry. Their products are always up to our high
                                        standards.
                                    </p>

                                    <div class="section-line mt-40"></div>

                                    <footer class="ts1-author mt-20 clearfix">
                                        <div class="ts1-author-img float-start">
                                            <img class="rounded-circle" width="44" height="44" src="images/ts1-user.jpg"
                                                alt="Image description is here">
                                        </div>
                                        <div>
                                            Subham Sinha
                                            <div class="small">
                                                Metro Builders Inc.
                                            </div>
                                        </div>
                                    </footer>

                                </blockquote>
                            </div>
                            <!-- End Slide Item -->

                            <!-- Slide Item -->
                            <div>
                                <blockquote class="mb-0">

                                    <div class="blockquote-icon" aria-hidden="true">”</div>

                                    <p>
                                        Working with Abhishek Ispat has been a great experience. Their team
                                        is professional, and their products are of the highest quality."
                                    </p>

                                    <div class="section-line mt-40"></div>

                                    <footer class="ts1-author mt-20 clearfix">
                                        <div class="ts1-author-img float-start">
                                            <img class="rounded-circle" width="44" height="44" src="images/ts1-user.jpg"
                                                alt="Image description is here">
                                        </div>
                                        <div>
                                            Ravi Dube
                                            <div class="small">
                                                Universal Manufacturing
                                            </div>
                                        </div>
                                    </footer>

                                </blockquote>
                            </div>
                            <!-- End Slide Item -->

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Testimonials Section -->

    <!-- Call Action Section -->
    <section class="page-section">
        <div class="container position-relative">
            <div class="row">

                <!-- Images -->
                <div class="col-lg-7 d-flex align-items-center mb-md-60 mb-xs-30">
                    <div class="call-action-2-images">

                        <!-- <div class="call-action-2-image-1" data-rellax-y="" data-rellax-speed="0.5" data-rellax-percentage="0.7">
                                            <img src="images/about-1.png" alt="Image Description" class="wow scaleOutIn" data-wow-duration="1.2s" data-wow-offset="255">
                                        </div>
                                         -->
                        <div class="call-action-2-image-2" style="border-radius: 5px;">
                            <img src="images/about-2.png" alt="Image Description" class="wow scaleOutIn"
                                data-wow-duration="1.2s" data-wow-offset="134">
                        </div>

                        <div class="call-action-2-image-3" data-rellax-y="" data-rellax-speed="-0.5"
                            data-rellax-percentage="0.5" style="border-radius: 5px;">
                            <img src="images/2.png" alt="Image Description" class="wow scaleOutIn"
                                data-wow-duration="1.2s" data-wow-offset="0">
                        </div>

                    </div>
                </div>
                <!-- End Images -->

                <!-- Text -->
                <div class="col-lg-5 d-flex align-items-center">
                    <div class="wow fadeInUp" data-wow-duration="1.2s" data-wow-offset="255">

                        <h2 class="section-title mb-50 mb-sm-20">How we work?</h2>

                        <div class="call-action-2-text mb-50 mb-sm-40">

                            <!-- Accordion -->
                            <dl class="accordion">
                                <dt>
                                    <a href="#">01. Client Consultation</a>
                                </dt>
                                <dd class="text-gray">
                                    We begin by understanding your specific needs and requirements through
                                    detailed consultations, ensuring that we can deliver tailored steel
                                    solutions.
                                </dd>
                                <dt>
                                    <a href="#">02. Customized Solutions</a>
                                </dt>
                                <dd class="text-gray">
                                    Based on our consultation, we provide customized steel products and
                                    services that meet your exact specifications and project requirements.
                                </dd>
                                <dt>
                                    <a href="#">03. State-of-the-Art Manufacturing</a>
                                </dt>
                                <dd class="text-gray">
                                    Our manufacturing facilities are equipped with the latest technology and
                                    machinery, allowing us to produce high-quality steel products
                                    efficiently and consistently.
                                </dd>
                                <dt>
                                    <a href="#">04. Quality Assurance</a>
                                </dt>
                                <dd class="text-gray">
                                    We adhere to stringent quality control measures at every stage of the
                                    production process, ensuring that our products meet the highest
                                    standards of quality and durability.
                                </dd>
                                <!-- <dt>
                                                    <a href="#">05. Sustainable Practices</a>
                                                </dt>
                                                <dd class="text-gray">
                                                    We implement eco-friendly manufacturing processes and strive to minimize our environmental impact through sustainable practices and resource management.
                                                </dd> -->
                            </dl>
                            <!-- End Accordion -->

                        </div>

                        <div class="local-scroll">
                            <a href="contact.php" class="btn btn-mod btn-large btn-round btn-hover-anim"><span>Start
                                    a
                                    Project</span></a>
                        </div>

                    </div>
                </div>
                <!-- End Text -->

            </div>
        </div>
    </section>
    <!-- End Call Action Section -->


    <!-- Divider -->
    <hr class="mt-0 mb-0">
    <!-- End Divider -->
</main>
<?php
include "footer.php";
?>