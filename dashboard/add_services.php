<?php
include "header.php";

if (isset($_COOKIE['edit_id'])) {
    $mode = 'edit';
    $editId = $_COOKIE['edit_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `services` WHERE id=?");
    $stmt->bind_param('i', $editId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

if (isset($_COOKIE['view_id'])) {
    $mode = 'view';
    $viewId = $_COOKIE['view_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `services` WHERE id=?");
    $stmt->bind_param('i', $viewId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

if (isset($_REQUEST['update'])) {
    $id = $_COOKIE['edit_id'];
    $name = $_REQUEST['name'];
    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];
    $image = $_FILES['image']['name'];
    $image = str_replace(' ', '_', $image);
    $a_image_path = $_FILES['image']['tmp_name'];
    $old_img = $_REQUEST['old_img'];


    if ($image != "") {
        if (file_exists("images/services/" . $image)) {
            $i = 0;
            $PicFileName = $image;
            $Arr1 = explode('.', $PicFileName);

            $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/services/" . $PicFileName)) {
                $i++;
                $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
                }
            } else {
            $PicFileName = $image;
            }
        if (file_exists("images/services/" . $old_img)) {
            unlink("images/services/" . $old_img);
            }
        move_uploaded_file($a_image_path, "images/services/" . $PicFileName);
        } else {
        $PicFileName = $old_img;
        }

    try {
        $stmt = $obj->con1->prepare("UPDATE `services` SET `service_name`=?,`title`=?, `image`=?, `description`=? WHERE `id`=?");
        $stmt->bind_param("ssssi", $name, $title, $PicFileName, $description, $id);
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
        header("location:services.php");
        } else {
        setcookie("msg", "fail", time() + 3600, "/");
        header("location:services.php");
        }
    }
if (isset($_REQUEST["save"])) {
    $name = $_REQUEST['name'];
    $image = $_FILES['image']['name'];
    $image = str_replace(' ', '_', $image);
    $a_image_path = $_FILES['image']['tmp_name'];
    $title = $_REQUEST['title'];
    $description = $_REQUEST['description'];

    if ($image != "") {
        if (file_exists("images/services/" . $image)) {
            $i = 0;
            $PicFileName = $image;
            $Arr1 = explode('.', $PicFileName);

            $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
            while (file_exists("images/services/" . $PicFileName)) {
                $i++;
                $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
                }
            } else {
            $PicFileName = $image;
            }
        }

    try {
        // echo"INSERT INTO `services`( `name`, `image`, `title`, `description`) VALUES ($name, $PicFileName, $title,$description)";
        $stmt = $obj->con1->prepare("INSERT INTO `services`( `service_name`, `image`, `title`, `description`) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $name, $PicFileName, $title, $description);
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
        move_uploaded_file($a_image_path, "images/services/" . $PicFileName);
        setcookie("msg", "data", time() + 3600, "/");
        header("location:services.php");
        } else {
        setcookie("msg", "fail", time() + 3600, "/");
        header("location:services.php");
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
                <label class="col-sm-2 col-form-label">Services Name</label>
                <input type="text" id="name" name="name" class="form-control" required
                    value="<?= (isset($mode)) ? $data['service_name'] : '' ?>" <?= isset($mode) && $mode == 'view' ? 'readonly' : '' ?> />
            </div>

            <div class="col-md-12" <?php echo (isset($mode) && $mode == 'view') ? 'hidden' : '' ?>>
                <label for="inputNumber" class="col-sm-2 col-form-label">Image</label>
                <input class="form-control" type="file" id="image" name="image" data_btn_text="Browse"
                    onchange="readURL(this,'PreviewImage')" />
            </div>

            <div>
                <label class="font-bold text-primary mt-2  mb-3"
                    style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>">Preview</label>
                <img src="<?php echo (isset($mode)) ? 'images/services/' . $data["image"] : '' ?>" name="PreviewImage"
                    id="PreviewImage" height="300" style="display:<?php echo (isset($mode)) ? 'block' : 'none' ?>"
                    class="object-cover shadow rounded mt-4">
                <div id="imgdiv" style="color:red"></div>
                <input type="hidden" name="old_img" id="old_img"
                    value="<?php echo (isset($mode) && $mode == 'edit') ? $data["image"] : '' ?>" />
            </div>

            <div class="col-md-12">
                <label class="col-sm-2 col-form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" required
                    value="<?= (isset($mode)) ? $data['title'] : '' ?>" <?= isset($mode) && $mode == 'view' ? 'readonly' : '' ?> />
            </div>

            <div class="col-md-12">
                <label for="discription" class="col-sm-2 col-form-label">Description</label>
                <textarea class="tinymce-editor" name="description" id="description" <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['description'] : '' ?></textarea>
            </div>

            <div class="text-left mt-4">
                <button type="submit" name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
                    class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                </button>
                <button type="button" class="btn btn-danger" onclick="window.location='services.php'">
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
        window.location = "services.php";
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