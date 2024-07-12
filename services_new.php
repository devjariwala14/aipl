<?php
include "header.php";

?>

<main id="main">
    <!-- Home Section -->
    <section class="page-section pt-90 pb-90 pb-xs-40 bg-dark-alpha-50 parallax-5 light-content"
        style="background-image: url(images/demo-modern/section-bg-4.jpg)" id="home">
        <div class="container position-relative">
            <span class="col-10 col-sm-9"><br><br><br></span>
            <div class="row">
                <div class="col-10 col-sm-9">
                    <h1 class="hs-title-5 font-alt overflow-hidden mb-0">
                        <span class="d-block text-end wow fadeRotateIn">
                            Services
                        </span>
                    </h1>
                </div>
            </div>

        </div>

    </section>
    <!-- End Home Section -->
    <!-- Services Section -->

    <section class="page-section bg-light-1 dark-content" id="services">
        <?php
        $stmt = $obj->con1->prepare("SELECT * FROM `services` ORDER BY `id` DESC");
        $stmt->execute();
        $Resp = $stmt->get_result();
        $i = 1;
        while ($row = mysqli_fetch_array($Resp)) { ?>
            <div class="container">

                <div class="row mb-100 mb-md-60">

                    <div class="col-lg-8 mb-md-50">
                        <div class="section-descr-extralarge wow linesAnimIn" data-wow-offset="0" data-splitting="lines">
                            <h2 class="section-title-inline-1"><?php echo $row["title"] ?></h2>
                            <?php echo $row["description"] ?>
                        </div>
                    </div>

                    <div class="col-lg-4 wow fadeInUp" data-offset="0">
                        <img src="dashboard/images/services/<?php echo $row["image"]; ?>" alt="Image Description"
                            sizes="auto">
                    </div>

                </div>
            </div>
            <?php $i++;
            }
        ?>
    </section>


</main>

<!-- Footer -->
<?php
include "footer.php";
?>