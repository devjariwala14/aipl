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
   $desc = $_REQUEST["desc"];
   $application = $_REQUEST["application"];
   $specification = $_REQUEST["specification"];
   $chemical_comp = $_REQUEST["chemical_comp"];
   $mech_prop = $_REQUEST["mech_prop"];
 
  $img_path = $_FILES['img_path']['name'];
  $img_path = str_replace(' ', '_', $img_path);
  $temp_img_path = $_FILES['img_path']['tmp_name'];

  if ($img_path != "") {
    if (file_exists("images/product/" . $img_path)) {
      $i = 0;
      $PicFileName = $img_path;
      $Arr1 = explode('.', $PicFileName);

      $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
      while (file_exists("images/product/" . $PicFileName)) {
        $i++;
        $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
      }
    } else {
      $PicFileName = $img_path;
    }
  }

  try {
    // echo ("INSERT INTO `product`(`name`, `image`, `description`, `application`, `specification`, `chemical_comp`, `mech_prop`) VALUES  $name, $img_path , $desc , $application , $specification , $chemical_comp , $mech_prop");
    $stmt = $obj->con1->prepare("INSERT INTO `product`(`name`, `image`, `description`, `application`, `specification`, `chemical_comp`, `mech_prop`) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $name, $img_path , $desc , $application , $specification , $chemical_comp , $mech_prop);
    $Resp = $stmt->execute();
    if (!$Resp) {
      throw new Exception(
        "Problem in adding! " . strtok($obj->con1->error, "(")
      );
    }
    $stmt->close();
  } catch (\Exception $e) {
    setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
  }

  if ($Resp) {
    move_uploaded_file($temp_img_path, "images/product/" . $PicFileName);
    setcookie("msg", "data", time() + 3600, "/");
    header("location:product.php");
  } else {
    setcookie("msg", "fail", time() + 3600, "/");
    header("location:product.php");
  }
}

if (isset($_REQUEST["update"])) {
  $id = $_COOKIE['edit_id'];
  $name = $_REQUEST["name"];
  $desc = $_REQUEST["desc"];
  $application = $_REQUEST["application"];
  $specification = $_REQUEST["specification"];
  $chemical_comp = $_REQUEST["chemical_comp"];
  $mech_prop = $_REQUEST["mech_prop"];
 

  if ($img_path != "") {
    if (file_exists("images/product/" . $img_path)) {
      $i = 0;
      $PicFileName = $img_path;
      $Arr1 = explode('.', $PicFileName);

      $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
      while (file_exists("images/product/" . $PicFileName)) {
        $i++;
        $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
      }
    } else {
      $PicFileName = $img_path;
    }
    unlink("images/product/" . $old_img);
    move_uploaded_file($temp_img_path, "images/product/" . $PicFileName);
  } else {
    $PicFileName = $old_img;
    $img_path = $old_img;
  }

  try {
    $stmt = $obj->con1->prepare("UPDATE `product` SET `name`=?,`image`=?,`description`=?,`application`=?,`specification`=?,`chemical_comp`=?,`mech_prop`=? WHERE `id`=?");

    $stmt->bind_param("sssssssi", $name, $img_path , $desc , $application , $specification , $chemical_comp , $mech_prop , $id);
    $Resp = $stmt->execute();
    if (!$Resp) {
      throw new Exception(
        "Problem in updating! " . strtok($obj->con1->error, "(")
      );
    }
    $stmt->close();
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
                             value="<?= (isset($mode)) ? $data['name'] : '' ?>" <?= isset($mode) && $mode == 'view' ? 'readonly' : '' ?> />
                        </div>

                        <!-- Image -->
                        <div class="col-md-12" <?php echo (isset($mode) && $mode == 'view') ? 'hidden' : '' ?>>
                                <label for="inputNumber" class="col-sm-2 col-form-label">Image</label>
                                <input class="form-control" type="file" id="img_path" name="img_path"
                                    onchange="readURL(this,'PreviewImage')" />
                            </div>
                            <div>
                                <label class="font-bold text-primary mt-2  mb-3"
                                    style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>">Preview</label>
                                <img src="<?php echo (isset($mode)) ? 'images/product/' . $data["image"] : '' ?>"
                                    name="PreviewImage" id="PreviewImage" height="300"
                                    style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>"
                                    class="object-cover shadow rounded">
                                <div id="imgdiv" style="color:red"></div>
                                <input type="hidden" name="old_img" id="old_img"
                                    value="<?php echo (isset($mode) && $mode == 'edit') ? $data["image"] : '' ?>" />
                            </div>

                       
                        <!-- Description --><!-- <input type="hidden" name="quill_content" id="quill_content"> -->
                        <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Description</label>
                            <textarea class="tinymce-editor" name="desc" id="desc"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['description'] : '' ?></textarea>
                       </div>
                       <!-- Application --><!-- <input type="hidden" name="quill_content" id="quill_content"> -->
                       <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Application</label>
                            <textarea class="tinymce-editor" name="application" id="application"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['application'] : '' ?></textarea>
                       </div>
                       <!-- Specification --><!-- <input type="hidden" name="quill_content" id="quill_content"> -->
                       <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Specification</label>
                            <textarea class="tinymce-editor" name="specification" id="specification"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['specification'] : '' ?></textarea>
                       </div>
                       <!-- Chemical composition --><!-- <input type="hidden" name="quill_content" id="quill_content"> -->
                       <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Chemical composition</label>
                            <textarea class="tinymce-editor" name="chemical_comp" id="chemical_comp"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['chemical_comp'] : '' ?></textarea>
                       </div>
                       <!--  Mechanical Propertiesd --><!-- <input type="hidden" name="quill_content" id="quill_content"> -->
                       <div class="col-md-12">
                            <label for="discription" class="col-sm-2 col-form-label">Mechanical Properties</label>
                            <textarea class="tinymce-editor" name="mech_prop" id="mech_prop"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['mech_prop'] : '' ?></textarea>
                       </div>

                        <div class="text-left mt-4">
                <button type="submit" name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
                    class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                </button>
                <button type="button" class="btn btn-danger" onclick="window.location='product.php'">
                    Close</button>
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
    function readURL(input, PreviewImage) {
        if (input.files && input.files[0]) {
            var filename = input.files.item(0).name;
            var reader = new FileReader();
            var extn = filename.split(".");

            if (["jpg", "jpeg", "png", "bmp"].includes(extn[1].toLowerCase())) {
                reader.onload = function(e) {
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
    <?php
include "footer.php";
?>