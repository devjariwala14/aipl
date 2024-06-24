<?php
include "header.php";

if (isset($_COOKIE['edit_id'])) {
    $mode = 'edit';
    $editId = $_COOKIE['edit_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `about_us` WHERE id=?");
    $stmt->bind_param('i', $editId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if (isset($_COOKIE['view_id'])) {
    $mode = 'view';
    $viewId = $_COOKIE['view_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `about_us` WHERE id=?");
    $stmt->bind_param('i', $viewId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if (isset($_REQUEST['update'])) {
    $id = $_COOKIE['edit_id'];
    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];
    $vision = $_REQUEST['vision'];
    $mission = $_REQUEST['mission'];
    $image = $_FILES['image']['name'];
    $image = str_replace(' ', '_', $image);
    $a_image_path = $_FILES['image']['tmp_name'];
    $old_img = $_REQUEST['old_img'];
    $status = $_REQUEST["radio"] ?? '';

    if ($image != "") {
        if (file_exists("images/about/" . $image)) {
            $i = 0;
            $PicFileName = $image;
            $Arr1 = explode('.', $PicFileName);

            $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/about/" . $PicFileName)) {
                $i++;
                $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            }
        } else {
            $PicFileName = $image;
        }
        if (file_exists("images/about/" . $old_img)) {
            unlink("images/about/" . $old_img);
        }
        move_uploaded_file($a_image_path, "images/about/" . $PicFileName);
    } else {
        $PicFileName = $old_img;
    }

    try {
        $stmt = $obj->con1->prepare("UPDATE `about_us` SET `title`=?, `image`=?, `description`=?, `vision`=?, `mission`=? WHERE `id`=?");
        $stmt->bind_param("sssssi", $title, $PicFileName, $description, $vision, $mission, $id);
        $Resp = $stmt->execute();
        $stmt->close();
        if (!$Resp) {
            throw new Exception(
                "Problem in updating! " . strtok($obj->con1->error, "(")
            );
        }
    } catch (\Exception $e) {
        setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
    }

    if ($Resp) {
        setcookie("edit_id", "", time() - 3600, "/");
        setcookie("msg", "update", time() + 3600, "/");
        header("location:about_us.php");
    } else {
        setcookie("msg", "fail", time() + 3600, "/");
        header("location:about_us.php");
    }
}

if (isset($_REQUEST["save"])) {
    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];
    $vision = $_REQUEST['vision'];
    $mission = $_REQUEST['mission'];
    $image = $_FILES['image']['name'];
    $image = str_replace(' ', '_', $image);
    $a_image_path = $_FILES['image']['tmp_name'];

    if ($image != "") {
        if (file_exists("images/about/" . $image)) {
            $i = 0;
            $PicFileName = $image;
            $Arr1 = explode('.', $PicFileName);

            $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/about/" . $PicFileName)) {
                $i++;
                $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            }
        } else {
            $PicFileName = $image;
        }
    }

    try {
        $stmt = $obj->con1->prepare("INSERT INTO `about_us`(`title`, `image`, `description`, `vision`, `mission`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $title, $PicFileName, $description, $vision, $mission);
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
        move_uploaded_file($a_image_path, "images/about/" . $PicFileName);
        setcookie("msg", "data", time() + 3600, "/");
        header("location:about_us.php");
    } else {
        setcookie("msg", "fail", time() + 3600, "/");
        header("location:about_us.php");
    }
}
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Add Information -
            <?php echo (isset($mode)) ? (($mode == 'view') ? 'View' : 'Edit') : 'Add' ?>
        </h5>

        <!-- General Form Elements -->
        <form method="post" enctype="multipart/form-data">

            <div class="col-md-12">
                <label class="col-sm-2 col-form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" required
                    value="<?= (isset($mode)) ? $data['title'] : '' ?>" <?= isset($mode) && $mode == 'view' ? 'readonly' : '' ?> />
            </div>

            <div class="col-md-12" <?php echo (isset($mode) && $mode == 'view') ? 'hidden' : '' ?>>
                <label for="inputNumber" class="col-sm-2 col-form-label  mt-4">Image</label>
                <input class="form-control" type="file" id="image" name="image" data_btn_text="Browse"
                    onchange="readURL(this,'PreviewImage')" />
            </div>

            <div>
                <label class="font-bold text-primary mt-2  mb-3"
                    style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>">Preview</label>
                <img src="<?php echo (isset($mode)) ? 'images/about/' . $data["image"] : '' ?>" name="PreviewImage"
                    id="PreviewImage" height="300" style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>"
                    class="object-cover shadow rounded">
                <div id="imgdiv" style="color:red"></div>
                <input type="hidden" name="old_img" id="old_img"
                    value="<?php echo (isset($mode) && $mode == 'edit') ? $data["image"] : '' ?>" />
            </div>

            <div class="col-md-12">
                <label for="description" class="col-sm-2 col-form-label">Description</label>
                <textarea class="tinymce-editor" name="description" id="description" <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['description'] : '' ?></textarea>
            </div>

            <div class="col-md-12">
                <label for="vision" class="col-sm-2 col-form-label">Vision</label>
                <textarea class="tinymce-editor" name="vision" id="vision" <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['vision'] : '' ?></textarea>
            </div>

            <div class="col-md-12">
                <label for="mission" class="col-sm-2 col-form-label">Mission</label>
                <textarea class="tinymce-editor" name="mission" id="mission" <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['mission'] : '' ?></textarea>
            </div>

            <div class="text-left mt-4">
                <button type="submit" name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
                    class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                </button>
                <button type="button" class="btn btn-danger" onclick="window.location='about_us.php'">
                    Close</button>
            </div>
        </form><!-- End General Form Elements -->
    </div>
</div>
</div>
</div>
</section>
<script>
    function go_back() {
        eraseCookie("edit_id");
        eraseCookie("view_id");
        window.location = "about_us.php";
    }

    function readURL(input, preview) {
        if (input.files && input.files[0]) {
            var filename = input.files.item(0).name;

            var reader = new FileReader();
            var extn = filename.split(".");

            if (extn[1].toLowerCase() == "jpg" || extn[1].toLowerCase() == "jpeg" || extn[1].toLowerCase() == "png" || extn[
                1].toLowerCase() == "bmp") {
                reader.onload = function (e) {
                    $('#' + preview).attr('src', e.target.result);
                    document.getElementById(preview).style.display = "block";
                };

                reader.readAsDataURL(input.files[0]);
                $('#imgdiv').html("");
                document.getElementById('save').disabled = false;
            } else {
                $('#imgdiv').html("Please Select Image Only");
                document.getElementById('save').disabled = true;
            }
        }
    }
</script>
<?php
include "footer.php";
?>