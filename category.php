<?php
include "header.php";

if (isset($_COOKIE['category'])) {
    $category = $_COOKIE['category'];
    $stmt = $obj->con1->prepare("SELECT p.*, pc.category FROM `product` p JOIN `product_category` pc ON p.category = pc.id  WHERE p.category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $Resp = $stmt->get_result();
    $firstRow = $Resp->fetch_assoc();
    $category_name = $firstRow['category'];
    ?>

    <!-- Services Section -->
    <section class="page-section pt-0" id="services">
        <div class="page-section bg-dark-1 bg-dark-alpha-70 light-content parallax-7 pb-140"
            style="background-image: url(images/demo-elegant/section-bg-3.jpg)">
            <div class="container position-relative">
                <div class="row mb-70 mb-sm-50">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3 text-center">
                        <h2 class="section-title mb-30 mb-sm-20">Category: <?php echo $category_name; ?></h2> 
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-n140 position-relative z-index-1">
            <div class="row mb-n30">
                <?php
                $Resp->data_seek(0); 
                while ($row = $Resp->fetch_assoc()) {
                    ?>
                    <!-- Services Item -->
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-30">
                        <div class="services-3-item round text-center">
                            <a href="javascript:void(0);"  onclick="setProduct(<?php echo $row['id']; ?>)">
                                <div class="wow fadeInUpShort animated" data-wow-offset="50"
                                    style="visibility: visible; animation-name: fadeInUpShort;">

                                    <div class="services-3-icon">
                                        <img src="dashboard/images/product/<?php echo $row["icon"]; ?>" alt="Product Icon">
                                    </div>

                                    <h3 class="services-3-title">
                                        <?php echo $row["name"]; ?>
                                    </h3>

                                    <div class="services-3-text">
                                        <?php echo $row["description"]; ?>
                                    </div>

                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- End Services Item -->
                    <?php
                }
                ?>
            </div>
        </div>
    </section>
    <!-- End Services Section -->
    

 <script>
function setProduct(productId) {
    document.cookie = "product=" + productId + "; path=/";
    window.location.href = "product.php";
}
</script>

    <?php
} else {
    echo "<h2>No category selected.</h2>";
}

include "footer.php";
?>
