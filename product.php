<?php
include "db_connect.php";
$obj = new DB_Connect();
date_default_timezone_set('Asia/Kolkata');
session_start();

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 1;

// Fetch subcategories based on category_id
$stmt = $obj->con1->prepare("SELECT * FROM subcategories WHERE category_id = ?");
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();
$subcategories = [];
while ($row = $result->fetch_assoc()) {
    $subcategories[] = $row;
    }

// Function to get products by subcategory ID
function getProductsBySubcategoryId($subcategory_id)
    {
    $pdo = new PDO('mysql:host=your_host;dbname=your_db', 'username', 'password');
    $stmt = $pdo->prepare('SELECT * FROM products WHERE subcategory_id = :subcategory_id');
    $stmt->execute(['subcategory_id' => $subcategory_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

// Fetch products if subcategory_id is set in the URL
$products = [];
if (isset($_GET['subcategory_id'])) {
    $subcategory_id = intval($_GET['subcategory_id']);
    $products = getProductsBySubcategoryId($subcategory_id);
    }

include 'header.php';
?>
<main id="main">
    <section class="page-section bg-gray-light-1 bg-light-alpha-90 parallax-5"
        style="background-image: url(images/full-width-images/section-bg-1.jpg)" id="home">
        <div class="container position-relative pt-30 pt-sm-50">
            <div class="text-center">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h1 class="hs-title-1 mb-20">
                            <span class="wow charsAnimIn" data-splitting="chars">Products</span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="page-section">
        <div class="container relative">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="blog-item">
                                <div class="blog-item-body">
                                    <div class="blog-media mb-40 mb-xs-30">
                                        <img src="dashboard/images/product/<?php echo htmlspecialchars($product['image']); ?>"
                                            alt="Image Description">
                                    </div>
                                    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                                    <ul class="nav nav-tabs tpl-tabs animate" role="tablist">
                                        <?php if (!empty($product['application'])): ?>
                                            <li class="nav-item" role="presentation">
                                                <a href="#application-<?php echo $product['id']; ?>" class="nav-link"
                                                    data-bs-toggle="tab" role="tab">Applications</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (!empty($product['specification'])): ?>
                                            <li class="nav-item" role="presentation">
                                                <a href="#specification-<?php echo $product['id']; ?>" class="nav-link"
                                                    data-bs-toggle="tab" role="tab">Specifications</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (!empty($product['chemical_comp'])): ?>
                                            <li class="nav-item" role="presentation">
                                                <a href="#chemical-<?php echo $product['id']; ?>" class="nav-link"
                                                    data-bs-toggle="tab" role="tab">Chemical Composition</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if (!empty($product['mech_prop'])): ?>
                                            <li class="nav-item" role="presentation">
                                                <a href="#mechanical-<?php echo $product['id']; ?>" class="nav-link"
                                                    data-bs-toggle="tab" role="tab">Mechanical Properties</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="tab-content">
                                        <?php if (!empty($product['application'])): ?>
                                            <div id="application-<?php echo $product['id']; ?>" class="tab-pane fade"
                                                role="tabpanel">
                                                <p><?php echo htmlspecialchars($product['application']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($product['specification'])): ?>
                                            <div id="specification-<?php echo $product['id']; ?>" class="tab-pane fade"
                                                role="tabpanel">
                                                <p><?php echo htmlspecialchars($product['specification']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($product['chemical_comp'])): ?>
                                            <div id="chemical-<?php echo $product['id']; ?>" class="tab-pane fade" role="tabpanel">
                                                <p><?php echo htmlspecialchars($product['chemical_comp']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($product['mech_prop'])): ?>
                                            <div id="mechanical-<?php echo $product['id']; ?>" class="tab-pane fade"
                                                role="tabpanel">
                                                <p><?php echo htmlspecialchars($product['mech_prop']); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No products found for this subcategory.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>
</body>

</html>