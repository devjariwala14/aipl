<?php
include "header.php";

if (isset($_COOKIE['edit_id'])) {
  $mode = 'edit';
  $editId = $_COOKIE['edit_id'];
  $stmt = $obj->con1->prepare("SELECT * FROM `product` where id=?");
  $stmt->bind_param('i', $editId);
  $stmt->execute();
  $data = $stmt->get_result()->fetch_assoc();
  $stmt->close();
}

if (isset($_COOKIE['view_id'])) {
  $mode = 'view';
  $viewId = $_COOKIE['view_id'];
  $stmt = $obj->con1->prepare("SELECT * FROM `product` where id=?");
  $stmt->bind_param('i', $viewId);
  $stmt->execute();
  $data = $stmt->get_result()->fetch_assoc();
  $stmt->close();
}

if (isset($_REQUEST["save"])) {
    $name = $_REQUEST["name"];
    $category = $_REQUEST["category"]; // Retrieve the selected category
    $desc = $_REQUEST["desc"];
    $application = $_REQUEST["application"];
    $specification = $_REQUEST["specification"];
    $chemical_comp = $_REQUEST["chemical_comp"];
    $mech_prop = $_REQUEST["mech_prop"];
    $status = $_REQUEST["status"];
    $image = $_FILES['image']['name'];
    $image = str_replace(' ', '_', $image);
    $image_path = $_FILES['image']['tmp_name'];
    $icon = $_FILES['icon']['name'];
    $icon = str_replace(' ', '_', $icon);
    $icon_path = $_FILES['icon']['tmp_name'];
 

    // Handle the first image
    if ($image != "") {
        if (file_exists("images/product/" . $image)) {
            $i = 0;
            $PicFileName = $image;
            $Arr1 = explode('.', $PicFileName);

            $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/product/" . $PicFileName)) {
                $i++;
                $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            }
        } else {
            $PicFileName = $image;
        }
    }

    // Handle the second image
    if ($icon != "") {
        if (file_exists("images/icon/" . $icon)) {
            $i = 0;
            $PicFileName2 = $icon;
            $Arr1 = explode('.', $PicFileName2);

            $PicFileName2 = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/icon/" . $PicFileName2)) {
                $i++;
                $PicFileName2 = $Arr1[0] . $i . "." . $Arr1[1];
            }
        } else {
            $PicFileName2 = $icon;
        }
    }

    try {
        echo"INSERT INTO `product` ( `name`,`category`, `icon`, `image`, `description`, `application`, `specification`, `chemical_comp`, `mech_prop`, `status`) VALUES (".$name.", ".$category.", ".$PicFileName2.", ".$PicFileName.",". $desc.", ".$application.", ".$specification.", ".$chemical_comp.",". $mech_prop.",". $status.")";
        $stmt = $obj->con1->prepare("INSERT INTO `product` ( `name`,`category`, `icon`, `image`, `description`, `application`, `specification`, `chemical_comp`, `mech_prop`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $name, $category, $PicFileName2, $PicFileName, $desc, $application, $specification, $chemical_comp, $mech_prop, $status);
        $Resp = $stmt->execute();
        if (!$Resp) {
            throw new Exception("Problem in adding! " . strtok($obj->con1->error, "("));
        }
        $stmt->close();
    } catch (\Exception $e) {
        setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
    }

    if ($Resp) {
        move_uploaded_file($image_path, "images/product/" . $PicFileName);
        move_uploaded_file($icon_path, "images/icon/" . $PicFileName2);
        setcookie("msg", "data", time() + 3600, "/");
        header("location:product.php");
    } else {
        setcookie("msg", "fail", time() + 3600, "/");
        header("location:product.php");
    }
}

if (isset($_REQUEST['update'])) {
    $id = $_COOKIE['edit_id'];
    $name = $_REQUEST["name"];
    $category = $_REQUEST["category"];
    $desc = $_REQUEST["desc"];
    $application = $_REQUEST["application"];
    $specification = $_REQUEST["specification"];
    $chemical_comp = $_REQUEST["chemical_comp"];
    $mech_prop = $_REQUEST["mech_prop"];
    $status = $_REQUEST["status"];
    
    $image = $_FILES['image']['name'];
    $image_path = $_FILES['image']['tmp_name'];
    $old_img1 = $_REQUEST['old_img_1'];  // First image

    $icon = $_FILES['icon']['name'];
    $icon_path = $_FILES['icon']['tmp_name'];
    $old_img2 = $_REQUEST['old_img_2'];  // Second image

    if (!empty($image)) {
        $image = str_replace(' ', '_', $image);
        $PicFileName = $image;
        if (file_exists("images/product/" . $image)) {
            $i = 0;
            $file_info = pathinfo($image);
            $PicFileName = $file_info['filename'] . $i . '.' . $file_info['extension'];
            
            while (file_exists("images/product/" . $PicFileName)) {
                $i++;
                $PicFileName = $file_info['filename'] . $i . '.' . $file_info['extension'];
            }
        }
        
        if (file_exists("images/product/" . $old_img1)) {
            unlink("images/product/" . $old_img1);
        }
        
        move_uploaded_file($image_path, "images/product/" . $PicFileName);
    } else {
        $PicFileName = $old_img1;
    }


    if (!empty($icon)) {
        $icon = str_replace(' ', '_', $icon);
        $PicFileName2 = $icon;
        if (file_exists("images/icon/" . $icon)) {
            $i = 0;
            $file_info2 = pathinfo($icon);
            $PicFileName2 = $file_info2['filename'] . $i . '.' . $file_info2['extension'];
            
            while (file_exists("images/icon/" . $PicFileName2)) {
                $i++;
                $PicFileName2 = $file_info2['filename'] . $i . '.' . $file_info2['extension'];
            }
        }
        
        if (file_exists("images/icon/" . $old_img2)) {
            unlink("images/icon/" . $old_img2);
        }
        move_uploaded_file($icon_path, "images/icon/" . $PicFileName2);
    } else {
        $PicFileName2 = $old_img2; 
    }
    try {
        $stmt = $obj->con1->prepare("UPDATE `product` SET `category`=?, `name`=?, `icon`=?, `image`=?, `description`=?, `application`=?, `specification`=?, `chemical_comp`=?, `mech_prop`=?, `status`=? WHERE `id`=?");
        $stmt->bind_param("ssssssssssi", $category, $name, $icon,  $image , $desc, $application, $specification, $chemical_comp, $mech_prop, $status, $id);
        $Resp = $stmt->execute();
        $stmt->close();
        
        if (!$Resp) {
            throw new Exception("Problem in updating! " . strtok($obj->con1->error, "("));
        }
    } catch (\Exception $e) {
        setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
    }
    
    if ($Resp) {
        setcookie("edit_id", "", time() - 3600, "/");
        setcookie("msg", "update", time() + 3600, "/");
        header("location:product.php");
    } else {
        setcookie("msg", "fail", time() + 3600, "/");
        header("location:product.php");
    }
}

?>

<div class="pagetitle">
    <h1>Products</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Products</li>
            <li class="breadcrumb-item active">
                <?php echo (isset($mode)) ? (($mode == 'view') ? 'View' : 'Edit') : 'Add' ?> Info</li>
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
                            <label class="col-sm-2 col-form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required
                                value="<?= (isset($mode)) ? $data['name'] : '' ?>"
                                <?= isset($mode) && $mode == 'view' ? 'readonly' : '' ?> />
                        </div>
                        <div class="col-md-12">
                            <label for="category" class="form-label">Product Category</label>
                            <select id="inputMenu" class="form-select" name="category">
                                <option selected>Choose Menu</option>
                                <?php
                                $stmt_list = $obj->con1->prepare("SELECT * FROM `product_category` WHERE `status`= 'Enable'");
                                $stmt_list->execute();
                                $result = $stmt_list->get_result();
                                $stmt_list->close();

                                while ($state = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $state["id"]?>"
                                    <?php echo isset($mode) && $data['category'] == $state["id"] ? 'selected' : '' ?>>
                                    <?php echo $state["category"]?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <!-- img 1 -->
                        <div class="col-md-12" <?php echo (isset($mode) && $mode == 'view') ? 'hidden' : '' ?>>
                            <label for="inputNumber" class="col-sm-2 col-form-label">Icon</label>
                            <input class="form-control" type="file" id="icon" name="icon" data_btn_text="Browse"
                                onchange="readURLForImage(this , 1)" />
                        </div>

                        <div>
                            <label class="font-bold text-primary mt-2  mb-3"
                                style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>">Preview</label>
                            <img src="<?php echo (isset($mode)) ? 'images/icon/' . $data["icon"] : '' ?>"
                                name="PreviewImage_1" id="PreviewImage_1" height="300" width="400"
                                style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>"
                                class="object-cover shadow rounded  mt-3  mb-3">
                            <div id="imgdiv_1" style="color:red"></div>
                            <input type="hidden" name="old_img_1" id="old_img_1"
                                value="<?php echo (isset($mode) && $mode == 'edit') ? $data["icon"] : '' ?>" />
                        </div>

                        <!-- img 2 -->
                        <div class="col-md-12" <?php echo (isset($mode) && $mode == 'view') ? 'hidden' : '' ?>>
                            <label for="inputNumber" class="col-sm-2 col-form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image" data_btn_text="Browse"
                                onchange="readURLForImage(this , 2)" />

                        </div>
                        <div>
                            <h4 class="font-bold text-primary mt-2 mb-3"
                                style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>">Preview</h4>
                            <img src="<?php echo (isset($mode)) ? 'images/product/' . $data["image"] : '' ?>"
                                name="PreviewImage_2" id="PreviewImage_2" height="300" width="400"
                                style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>"
                                class="object-cover shadow rounded  mt-3  mb-3">
                            <div id="imgdiv_2" style="color:red"></div>
                            <input type="hidden" name="old_img_2" id="old_img_2"
                                value="<?php echo (isset($mode) && $mode == 'edit') ? $data["image"] : '' ?>" />
                        </div>


                        <div class="mb-3">
                            <label class="form-label d-block" for="basic-default-fullname">Status</label>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="status" id="Enable" value="Enable"
                                    <?php echo isset($mode) && $data['status'] == 'Enable' ? 'checked' : '' ?>
                                    <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?> required checked>
                                <label class="form-check-label" for="inlineRadio1">Enable</label>
                            </div>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="status" id="Disable" value="Disable"
                                    <?php echo isset($mode) && $data['status'] == 'Disable' ? 'checked' : '' ?>
                                    <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?> required>
                                <label class="form-check-label" for="inlineRadio1">Disable</label>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Description</label>
                            <textarea class="tinymce-editor" name="desc" id="desc"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['description'] : '' ?></textarea>
                        </div>
                        <!-- Application -->
                        <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Application</label>
                            <textarea class="tinymce-editor" name="application" id="application"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['application'] : '' ?></textarea>
                        </div>
                        <!-- Specification -->
                        <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Specification</label>
                            <textarea class="tinymce-editor" name="specification" id="specification"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['specification'] : '' ?></textarea>
                        </div>
                        <!-- Chemical composition -->
                        <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Chemical composition</label>
                            <textarea class="tinymce-editor" name="chemical_comp" id="chemical_comp"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['chemical_comp'] : '' ?></textarea>
                        </div>
                        <!-- Mechanical Properties -->
                        <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Mechanical Properties</label>
                            <textarea class="tinymce-editor" name="mech_prop" id="mech_prop"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['mech_prop'] : '' ?></textarea>
                        </div>

                        <div class="text-left mt-4">
                            <button type="submit"
                                name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
                                class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                            </button>
                            <button type="button" class="btn btn-danger"
                                onclick="window.location='product.php'">Close</button>
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
        window.location = "product.php";
    }

    function readURLForImage(input, n) {
        if (input.files && input.files[0]) {
            var filename = input.files.item(0).name;
            var reader = new FileReader();
            var extn = filename.split(".");

            if (['jpg', 'jpeg', 'png', 'bmp'].includes(extn[1].toLowerCase())) {
                reader.onload = function(e) {
                    $('#PreviewImage_' + n).attr('src', e.target.result);
                    document.getElementById('PreviewImage_' + n).style.display = "block";
                };
                reader.readAsDataURL(input.files[0]);
                $('#imgdiv_' + n).html("");
                document.getElementById('save').disabled = false;
            } else {
                $('#imgdiv_' + n).html("Please select an image file (jpg, jpeg, png, bmp)");
                document.getElementById('save').disabled = true;
            }
        }
    }
    </script>
    <?php include "footer.php"; ?>