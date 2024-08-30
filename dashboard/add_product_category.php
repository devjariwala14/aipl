<?php
include "header.php";

if (isset($_COOKIE['edit_id'])) {
    $mode = 'edit';
    $editId = $_COOKIE['edit_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `product_category` where id=?");
    $stmt->bind_param('i', $editId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

if (isset($_COOKIE['view_id'])) {
    $mode = 'view';
    $viewId = $_COOKIE['view_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `product_category` where id=?");
    $stmt->bind_param('i', $viewId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

if (isset($_REQUEST["save"])) {
    $category = $_REQUEST["category"];
    $status = $_REQUEST["status"];
    try {
        $stmt = $obj->con1->prepare("INSERT INTO `product_category`(`category`,`status`) VALUES (?,?)");
        $stmt->bind_param("ss", $category, $status);
        $Resp = $stmt->execute();
        if (!$Resp) {
            throw new Exception("Problem in adding! " . strtok($obj->con1->error, "("));
            }
        $stmt->close();
        } catch (\Exception $e) {
        setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
        }

    if ($Resp) {
        setcookie("msg", "data", time() + 3600, "/");
        header("location:product_category.php");
        } else {
        setcookie("msg", "fail", time() + 3600, "/");
        header("location:product_category.php");
        }
    }

if (isset($_REQUEST["update"])) {
    $id = $_COOKIE['edit_id'];
    $category = $_REQUEST["category"];
    $status = $_REQUEST["status"];
    try {
        $stmt = $obj->con1->prepare("UPDATE `product_category` SET `category`=?, `status`=? WHERE `id`=?");
        $stmt->bind_param("ssi", $category, $status, $id);
        $Resp = $stmt->execute();

        if (!$Resp) {
            throw new Exception("Problem in updating! " . strtok($obj->con1->error, "("));
            }
        $stmt->close();
        } catch (\Exception $e) {
        setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
        }

    if ($Resp) {
        setcookie("msg", "data", time() + 3600, "/");
        header("location:product_category.php");
        } else {
        setcookie("msg", "fail", time() + 3600, "/");
        header("location:product_category.php");
        }
    }
?>

<!-- The HTML code remains the same -->





<div class="pagetitle">
    <h1>Products</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Products</li>
            <li class="breadcrumb-item active">
                <?php echo (isset($mode)) ? (($mode == 'view') ? 'View' : 'Edit') : 'Add' ?> Info
            </li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body mt-3">
                    <!-- General Form Elements -->
                    <form method="post" enctype="multipart/form-data">
                        <!-- Name -->
                        <div class="col-md-12">
                            <label class="col-sm-2 col-form-label">Category Name</label>
                            <input type="text" id="category" name="category" class="form-control" required
                                value="<?= (isset($mode)) ? $data['category'] : '' ?>" <?= isset($mode) && $mode == 'view' ? 'readonly' : '' ?> />

                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block" for="basic-default-fullname">Status</label>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="status" id="Enable" value="Enable"
                                    <?php echo isset($mode) && $data['status'] == 'Enable' ? 'checked' : '' ?> <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?> required checked>
                                <label class="form-check-label" for="inlineRadio1">Enable</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="status" id="Disable" value="Disable"
                                    <?php echo isset($mode) && $data['status'] == 'Disable' ? 'checked' : '' ?> <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?> required>
                                <label class="form-check-label" for="inlineRadio1">Disable</label>
                            </div>
                        </div>

                        <div class="text-left mt-4">
                            <button type="submit"
                                name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
                                class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                            </button>
                            <button type="button" class="btn btn-danger"
                                onclick="window.location='product_category.php'">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function go_back() {
            eraseCookie("edit_id");
            eraseCookie("view_id");
            window.location = "product_category.php";
        }

        function readURL(input, PreviewImage) {
            if (input.files && input.files[0]) {
                var filename = input.files.item(0).name;
                var reader = new FileReader();
                var extn = filename.split(".");

                if (["jpg", "jpeg", "png", "bmp", "svg"].includes(extn[1].toLowerCase())) {
                    reader.onload = function (e) {
                        document.getElementById(PreviewImage).src = e.target.result;
                        document.getElementById(PreviewImage).style.display = "block";
                    };
                    reader.readAsDataURL(input.files[0]);
                    document.getElementById('imgdiv').innerHTML = "";
                    document.getElementById('save').disabled = false;
                } else {
                    document.getElementById('imgdiv').innerHTML = "Please Select Image Only";
                    document.getElementById('save').disabled = true;
                }
            }
        }
    </script>
    <?php include "footer.php"; ?>