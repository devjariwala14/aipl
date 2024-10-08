<?php
include "header.php";

// Check if id is set
$id = isset($_COOKIE['id']) ? intval($_COOKIE['id']) : 0;

// Prepare the SQL query based on the id
if ($id) {

    $stmt = $obj->con1->prepare("SELECT * FROM `services` WHERE `id` = ? ORDER BY `id` DESC");
    $stmt->bind_param("i", $id);
    } else {

    $stmt = $obj->con1->prepare("SELECT * FROM `services` ORDER BY `id` DESC");
    }

$stmt->execute();
$Resp = $stmt->get_result();
$i = 1;
while ($row = mysqli_fetch_array($Resp)) {
    ?>
    <main id="main">
        <!-- Home Section -->
        <section class="page-section bg-dark-1 bg-dark-alpha-80 light-content parallax-5"
            style="background-image: url(images/AIPL/2.jpg)" id="home">
            <div class="container position-relative">
                <span class="col-10 col-sm-9"><br><br><br></span>
                <div class="row">
                    <!-- <div class="col-10 col-sm-9"> -->
                    <div class="col">
                        <h1 class="hs-title-4 font-alt overflow-hidden mb-0">
                            <span class="d-block text-center wow fadeRotateIn">
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

            <div class="container">

                <div class="row mb-100 mb-md-60">

                    <div class="col-lg-8 mb-md-50">
                        <div class="section-descr-small wow linesAnimIn" data-wow-offset="0" data-splitting="lines">
                            <h2 class="section-title-inline-4"><?php echo $row["title"] ?></h2>
                            <?php echo $row["description"] ?>
                        </div>
                    </div>

                    <div class="col-lg-4 wow fadeInUp" data-offset="0">
                        <img src="dashboard/images/services/<?php echo $row["image"]; ?>" alt="Image Description"
                            height="600px" width="750px">
                    </div>

                </div>
        </section>


    </main>

    <!-- Footer -->
    <?php
    $i++;
    }
?>

<?php
include "footer.php";
?>