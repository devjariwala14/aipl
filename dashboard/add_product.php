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
  $status = $_REQUEST["status"];

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

  $icon = $_FILES['icon']['name'];
  $icon = str_replace(' ', '_', $icon);
  $temp_icon_path = $_FILES['icon']['tmp_name'];

  if ($icon != "") {
    if (file_exists("images/icon/" . $icon)) {
      $i = 0;
      $PicFileName1 = $icon;
      $Arr1 = explode('.', $PicFileName1);

      $PicFileName1 = $Arr1[0] . $i . "." . $Arr1[1];
      while (file_exists("images/icon/" . $PicFileName1)) {
        $i++;
        $PicFileName1 = $Arr1[0] . $i . "." . $Arr1[1];
      }
    } else {
      $PicFileName1 = $icon;
    }
  }

  try {
    $stmt = $obj->con1->prepare("INSERT INTO `product`(`name`, `icon`, `image`, `description`, `application`, `specification`, `chemical_comp`, `mech_prop`, `status`) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $name, $PicFileName1, $PicFileName, $desc, $application, $specification, $chemical_comp, $mech_prop, $status);
    $Resp = $stmt->execute();
    if (!$Resp) {
      throw new Exception("Problem in adding! " . strtok($obj->con1->error, "("));
    }
    $stmt->close();
  } catch (\Exception $e) {
    setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
  }

  if ($Resp) {
    move_uploaded_file($temp_img_path, "images/product/" . $PicFileName);
    move_uploaded_file($temp_icon_path, "images/icon/" . $PicFileName1);
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
  $status = $_REQUEST["status"];

  $img_path = $_FILES['img_path']['name'] ? $_FILES['img_path']['name'] : $_REQUEST['old_img'];
  $temp_img_path = $_FILES['img_path']['tmp_name'];
  $icon = $_FILES['icon']['name'] ? $_FILES['icon']['name'] : $_REQUEST['old_icon'];
  $temp_icon_path = $_FILES['icon']['tmp_name'];

  if ($img_path != $_REQUEST['old_img']) {
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
    if ($_REQUEST['old_img'] != '') {
      unlink("images/product/" . $_REQUEST['old_img']);
    }
    move_uploaded_file($temp_img_path, "images/product/" . $PicFileName);
  } else {
    $PicFileName = $_REQUEST['old_img'];
  }

  if ($icon != $_REQUEST['old_icon']) {
    if (file_exists("images/icon/" . $icon)) {
      $i = 0;
      $PicFileName1 = $icon;
      $Arr1 = explode('.', $PicFileName1);

      $PicFileName1 = $Arr1[0] . $i . "." . $Arr1[1];
      while (file_exists("images/icon/" . $PicFileName1)) {
        $i++;
        $PicFileName1 = $Arr1[0] . $i . "." . $Arr1[1];
      }
    } else {
      $PicFileName1 = $icon;
    }
    if ($_REQUEST['old_icon'] != '') {
      unlink("images/icon/" . $_REQUEST['old_icon']);
    }
    move_uploaded_file($temp_icon_path, "images/icon/" . $PicFileName1);
  } else {
    $PicFileName1 = $_REQUEST['old_icon'];
  }

  try {
    $stmt = $obj->con1->prepare("UPDATE `product` SET `name`=?, `icon`=?, `image`=?, `description`=?, `application`=?, `specification`=?, `chemical_comp`=?, `mech_prop`=?, `status`=? WHERE `id`=?");
    $stmt->bind_param("sssssssssi", $name, $PicFileName1, $PicFileName, $desc, $application, $specification, $chemical_comp, $mech_prop, $status, $id);
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
    header("location:product.php");
  } else {
    setcookie("msg", "fail", time() + 3600, "/");
    header("location:product.php");
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
                        <div class="col-md-12" <?php echo (isset($mode) && $mode == 'view') ? 'hidden' : '' ?>>
    <label for="inputNumber" class="col-sm-2 col-form-label">Icon</label>
    <input class="form-control" type="file" id="icon" name="icon"
        onchange="readURL(this, 'PreviewImage1')" />
</div>
<div>
    <label class="font-bold text-primary mt-2  mb-3"
        style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>">Preview</label>
    <img src="<?php echo (isset($mode)) ? 'images/icon/' . $data['icon'] : '' ?>"
        name="PreviewImage1" id="PreviewImage1" height="300"
        style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>"
        class="object-cover shadow rounded">
    <div id="imgdiv1" style="color:red"></div>
    <input type="hidden" name="old_img" id="old_img"
        value="<?php echo (isset($mode) && $mode == 'edit') ? $data['icon'] : '' ?>" />
</div>

<!-- Image -->
<div class="col-md-12" <?php echo (isset($mode) && $mode == 'view') ? 'hidden' : '' ?>>
    <label for="inputNumber" class="col-sm-2 col-form-label">Image</label>
    <input class="form-control" type="file" id="img_path" name="img_path"
        onchange="readURL(this, 'PreviewImage2')" />
</div>
<div>
    <label class="font-bold text-primary mt-2  mb-3"
        style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>">Preview</label>
    <img src="<?php echo (isset($mode)) ? 'images/product/' . $data['image'] : '' ?>"
        name="PreviewImage2" id="PreviewImage2" height="300"
        style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>"
        class="object-cover shadow rounded">
    <div id="imgdiv2" style="color:red"></div>
    <input type="hidden" name="old_img" id="old_img"
        value="<?php echo (isset($mode) && $mode == 'edit') ? $data['image'] : '' ?>" />
</div>

<div class="mb-3">
    <label class="form-label d-block" for="basic-default-fullname">Status</label>
    <div class="form-check form-check-inline mt-3">
        <input class="form-check-input" type="radio" name="status" id="Enable" value="Enable" <?php echo isset($mode) && $data['status'] == 'Enable' ? 'checked' : '' ?> <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?> required checked>
        <label class="form-check-label" for="inlineRadio1">Enable</label>
    </div>
    <div class="form-check form-check-inline mt-3">
        <input class="form-check-input" type="radio" name="status" id="Disable" value="Disable" <?php echo isset($mode) && $data['status'] == 'Disable' ? 'checked' : '' ?> <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?> required>
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
    <button type="submit" name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
        class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
    </button>
    <button type="button" class="btn btn-danger" onclick="window.location='product.php'">Close</button>
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

        if (["jpg", "jpeg", "png", "bmp", "svg"].includes(extn[1].toLowerCase())) {
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
<?php include "footer.php"; ?>
