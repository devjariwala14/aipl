<?php
include "header.php";

if (isset($_COOKIE['edit_id'])) {
    $mode = 'edit';
    $editId = $_COOKIE['edit_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `product_category` WHERE id=?");
    $stmt->bind_param('i', $editId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

if (isset($_COOKIE['view_id'])) {
    $mode = 'view';
    $viewId = $_COOKIE['view_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `product_category` WHERE id=?");
    $stmt->bind_param('i', $viewId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

if (isset($_REQUEST["save"])) {
    $category = $_REQUEST["category"];
    $status = $_REQUEST["status"];
    // $img_path = $_FILES["image"]["name"];

    // if ($img_path != "") {
    //     // Handle file name generation and upload
    //     if (file_exists("images/product_category/" . $img_path)) {
    //         $i = 0;
    //         $Arr1 = explode('.', $img_path);
    //         $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
    //         while (file_exists("images/product_category/" . $PicFileName)) {
    //             $i++;
    //             $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
    //             }
    //         } else {
    //         $PicFileName = $img_path;
    //         }
    //     move_uploaded_file($temp_img_path, "images/product_category/" . $PicFileName);
    //     } else {
    //     $PicFileName = $_REQUEST['old_img']; // Use old image if no new image is uploaded
    //     }

    $image = $_FILES['img_path']['name'];
    $image = str_replace(' ', '_', $image);
    $temp_icon_path = $_FILES['img_path']['tmp_name'];

    if ($image != "") {
        if (file_exists("images/product_category/" . $image)) {
            $i = 0;
            $Arr1 = explode('.', $image);
            $PicFileName1 = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/product_category/" . $PicFileName1)) {
                $i++;
                $PicFileName1 = $Arr1[0] . $i . "." . $Arr1[1];
                }
            } else {
            $PicFileName1 = $image;
            }
        move_uploaded_file($temp_icon_path, "images/product_category/" . $PicFileName1);
        } else {
        $PicFileName1 = $_REQUEST['old_icon']; // Use old icon if no new icon is uploaded
        }
    try {

        $stmt = $obj->con1->prepare("INSERT INTO `product_category`(`category`, `image`, `status`) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $category, $PicFileName1, $status);
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


    $img_path = $_FILES['img_path']['name'] ? $_FILES['img_path']['name'] : $_REQUEST['old_img'];
    $temp_img_path = $_FILES['img_path']['tmp_name'];
    $image = $_FILES['image']['name'] ? $_FILES['image']['name'] : $_REQUEST['old_icon'];
    $temp_icon_path = $_FILES['image']['tmp_name'];

    if ($img_path != $_REQUEST['old_img']) {
        if (file_exists("images/product_category/" . $img_path)) {
            $i = 0;
            $PicFileName = $img_path;
            $Arr1 = explode('.', $PicFileName);

            $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/product_category/" . $PicFileName)) {
                $i++;
                $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
                }
            } else {
            $PicFileName = $img_path;
            }
        if ($_REQUEST['old_img'] != '') {
            unlink("images/product_category/" . $_REQUEST['old_img']);
            }
        move_uploaded_file($temp_img_path, "images/product_category/" . $PicFileName);
        } else {
        $PicFileName = $_REQUEST['old_img'];
        }

    if ($image != $_REQUEST['old_icon']) {
        if (file_exists("images/product_category/" . $image)) {
            $i = 0;
            $PicFileName1 = $image;
            $Arr1 = explode('.', $PicFileName1);

            $PicFileName1 = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/product_category/" . $PicFileName1)) {
                $i++;
                $PicFileName1 = $Arr1[0] . $i . "." . $Arr1[1];
                }
            } else {
            $PicFileName1 = $image;
            }
        if ($_REQUEST['old_icon'] != '') {
            unlink("images/product_category/" . $_REQUEST['old_icon']);
            }
        move_uploaded_file($temp_icon_path, "images/product_category/" . $PicFileName1);
        } else {
        $PicFileName1 = $_REQUEST['old_icon'];
        }


    try {
        $stmt = $obj->con1->prepare("UPDATE `product_category` SET `category`=?, `image`=?, `status`=? WHERE `id`=?");
        $stmt->bind_param("sssi", $category, $PicFileName, $status, $id);
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

<!-- The HTML and JavaScript code remains the same -->

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
                        <div class="col-md-12" <?php echo (isset($mode) && $mode == 'view') ? 'hidden' : '' ?>>
                            <label for="inputNumber" class="col-sm-2 col-form-label">Image</label>
                            <input class="form-control" type="file" id="img_path" name="img_path"
                                onchange="readURL(this, 'PreviewImage')" />
                        </div>
                        <div>
                            <label class="font-bold text-primary mt-2  mb-3"
                                style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>">Preview</label>
                            <img src="<?php echo (isset($mode)) ? 'images/product_category/' . $data['image'] : '' ?>"
                                name="PreviewImage" id="PreviewImage" height="300"
                                style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>"
                                class="object-cover shadow rounded">
                            <div id="imgdiv2" style="color:red"></div>
                            <input type="hidden" name="old_img" id="old_img"
                                value="<?php echo (isset($mode) && $mode == 'edit') ? $data['image'] : '' ?>" />
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