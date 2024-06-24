<?php
include "header.php";
?>
<?php
$stmt = $obj->con1->prepare("SELECT * FROM `product`ORDER BY `id` DESC");
$stmt->execute();
$Resp = $stmt->get_result();
$i = 1;
while ($row = mysqli_fetch_array($Resp)) { ?>

    <main id="main">
        <!-- Header Section -->
        <section class="page-section bg-gray-light-1 bg-light-alpha-90 parallax-5"
            style="background-image: url(images/full-width-images/section-bg-1.jpg)" id="home">
            <div class="container position-relative pt-30 pt-sm-50">
                <!-- Section Content -->
                <div class="text-center">
                    <div class="row">
                        <!-- Page Title -->
                        <div class="col-md-8 offset-md-2">
                            <h1 class="hs-title-1 mb-20">
                                <span class="wow charsAnimIn" data-splitting="chars">
                                    <?php echo $row["name"]; ?>
                                </span>
                            </h1>
                        </div>
                        <!-- End Page Title -->
                    </div>
                </div>
                <!-- End Section Content -->

            </div>
        </section>
        <!-- End Header Section -->


        <!-- Section -->
        <section class="page-section">
            <div class="container relative">
                <div class="row justify-content-center">
                    <!-- Content -->
                    <div class="col-lg-12">
                        <!-- Post -->
                        <div class="blog-item">
                            <div class="blog-item-body">

                                <!-- Media Gallery -->
                                <div class="blog-media mb-40 mb-xs-30">
                                    <img src="dashboard/images/product/<?php echo $row["image"]; ?>"
                                        alt="Image Description">
                                </div>
                            </div>
                            <p>
                                <?php echo $row["description"]; ?>
                            </p>

                            <!-- TABS -->
                            <!-- Nav Tabs -->
                            <div class="text-center mb-40 mb-xxs-30">
                                <ul class="nav nav-tabs tpl-tabs animate" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#item-1" aria-controls="item-1" class="nav-link active"
                                            data-bs-toggle="tab" role="tab" aria-selected="true">Applications</a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a href="#item-2" aria-controls="item-2" class="nav-link" data-bs-toggle="tab"
                                            role="tab" aria-selected="false">Specifications</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#item-3" aria-controls="item-3" class="nav-link" data-bs-toggle="tab"
                                            role="tab" aria-selected="false">Chemical
                                            Composition</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#item-4" aria-controls="item-4" class="nav-link" data-bs-toggle="tab"
                                            role="tab" aria-selected="false">Mechanical
                                            Properties</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- End Nav Tabs -->

                            <!-- Tab panes -->
                            <div class="tab-content tpl-minimal-tabs-cont">
                                <div class="tab-pane active show" id="item-1" role="tabpanel">
                                    <div class="applications">
                                        <?php echo $row["application"]; ?>
                                    </div>
                                </div>

                                <div class="tab-pane fade " id="item-2" role="tabpanel">
                                    <?php echo $row["specification"]; ?>
                                </div>
                                <div class="tab-pane fade " id="item-3" role="tabpanel">
                                    <?php echo $row["chemical_comp"]; ?>
                                </div>
                                <div class="tab-pane fade " id="item-4" role="tabpanel">
                                    <?php echo $row["mech_prop"]; ?>
                                </div>
                            </div>
                        </div>
                        <!-- End Tab panes -->
                        <!-- TABS OVER -->
                    </div>

                </div>
                <!-- End Post -->
            </div>

            </div>
        </section>
        <!-- End Section -->
    </main>
<?php } ?>
<?php
include "footer.php";
?>