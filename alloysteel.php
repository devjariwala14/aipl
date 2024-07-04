<?php
include "header.php";
?>

<?php
$stmt = $obj->con1->prepare("SELECT p.id, p.p_name, pd.image, pd.description, pd.application, pd.specification, pd.chemical_comp, pd.mech_prop FROM product p JOIN product_details pd ON p.id = pd.pro_id");
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
                                    <?php echo $row["p_name"]; ?>
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
                                    <img src="images/product/<?php echo $row["image"]; ?>" alt="Image Description">
                                </div>
                            </div>
                            <p>
                                <?php echo $row["description"]; ?>
                            </p>

                            <!-- TABS -->
                            <?php
                            $application = $row['application'];
                            $specification = $row['specification'];
                            $chemicalComp = $row['chemical_comp'];
                            $mechProp = $row['mech_prop'];

                            // Check if any of the columns contain data
                            if (!empty($application) || !empty($specification) || !empty($chemicalComp) || !empty($mechProp)) {
                                ?>
                                <!-- Nav Tabs -->
                                <div class="text-center mb-40 mb-xxs-30">
                                    <ul class="nav nav-tabs tpl-tabs animate" role="tablist">
                                        <?php if (!empty($application)) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a href="#item-<?php echo $i; ?>-2" aria-controls="item-<?php echo $i; ?>-2"
                                                    class="nav-link active" data-bs-toggle="tab" role="tab"
                                                    aria-selected="true">Applications</a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($specification)) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a href="#item-<?php echo $i; ?>-3" aria-controls="item-<?php echo $i; ?>-3"
                                                    class="nav-link" data-bs-toggle="tab" role="tab"
                                                    aria-selected="false">Specifications</a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($chemicalComp)) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a href="#item-<?php echo $i; ?>-4" aria-controls="item-<?php echo $i; ?>-4"
                                                    class="nav-link" data-bs-toggle="tab" role="tab" aria-selected="false">Chemical
                                                    Composition</a>
                                            </li>
                                        <?php } ?>
                                        <?php if (!empty($mechProp)) { ?>
                                            <li class="nav-item" role="presentation">
                                                <a href="#item-<?php echo $i; ?>-5" aria-controls="item-<?php echo $i; ?>-5"
                                                    class="nav-link" data-bs-toggle="tab" role="tab"
                                                    aria-selected="false">Mechanical Properties</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <!-- End Nav Tabs -->

                                <!-- Tab panes -->
                                <div class="tab-content tpl-minimal-tabs-cont">
                                    <?php if (!empty($application)) { ?>
                                        <div id="item-<?php echo $i; ?>-2" class="tab-pane fade active show" role="tabpanel">
                                            <p><?php echo $application; ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($specification)) { ?>
                                        <div id="item-<?php echo $i; ?>-3" class="tab-pane fade" role="tabpanel">
                                            <p><?php echo $specification; ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($chemicalComp)) { ?>
                                        <div id="item-<?php echo $i; ?>-4" class="tab-pane fade" role="tabpanel">
                                            <p><?php echo $chemicalComp; ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php if (!empty($mechProp)) { ?>
                                        <div id="item-<?php echo $i; ?>-5" class="tab-pane fade" role="tabpanel">
                                            <p><?php echo $mechProp; ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                                <!-- End Tab panes -->
                            <?php } ?>
                            <!-- TABS OVER -->
                        </div>
                    </div>
                    <!-- End Post -->
                </div>
            </div>
        </section>
        <!-- End Section -->
    </main>

    <?php
    $i++;
    }
?>

<?php
include "footer.php";
?>