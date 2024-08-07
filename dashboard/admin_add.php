<?php include "header.php" ; 

if (isset($_COOKIE['edit_id'])) { $mode='edit' ; $editId=$_COOKIE['edit_id'];
    $stmt=$obj->con1->prepare("SELECT * FROM `admin` WHERE id=?");
    $stmt->bind_param('i', $editId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

    if (isset($_COOKIE['view_id'])) {
    $mode = 'view';
    $viewId = $_COOKIE['view_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `admin` WHERE id=?");
    $stmt->bind_param('i', $viewId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

    if (isset($_REQUEST["save"])) {
    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    $icon = $_FILES['icon']['name'];
    $icon = str_replace(' ', '_', $icon);
    $primary_benifits_img_path = $_FILES['icon']['tmp_name'];


    if ($icon != "") {
    if (file_exists("images/admin/" . $icon)) {
    $i = 0;
    $PicFileName = $icon;
    $Arr1 = explode('.', $PicFileName);
    $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
    while (file_exists("images/admin/" . $PicFileName)) {
    $i++;
    $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
    }
    } else {
    $PicFileName = $icon;
    }
    }

    try {
        
    $stmt = $obj->con1->prepare("INSERT INTO `admin`(`username`,`password`) VALUES (?,?)");
    $stmt->bind_param("ss", $username ,$password);
    $Resp = $stmt->execute();
    if (!$Resp) {
    throw new Exception("Problem in adding! " . strtok($obj->con1->error, "("));
    }
    $stmt->close();
    } catch (Exception $e) {
    setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
    }

    if ($Resp) {
    move_uploaded_file($primary_benifits_img_path, "images/admin/" . $PicFileName);
    setcookie("msg", "data", time() + 3600, "/");
    header("location:admin.php");
    } else {
    setcookie("msg", "fail", time() + 3600, "/");
    header("location:admin.php");
    }
    }

    if (isset($_REQUEST["update"])) {
    $id = $_COOKIE['edit_id'];

    $username = $_REQUEST["username"];
    $password = $_REQUEST["password"];
    $icon = $_FILES['icon']['name'];
    $icon = str_replace(' ', '_', $icon);
    $primary_benifits_img_path = $_FILES['icon']['tmp_name'];
    $old_img = $_REQUEST['old_img'];


    if ($icon != "") {
    if (file_exists("images/admin/" . $icon)) {
    $i = 0;
    $PicFileName = $icon;
    $Arr1 = explode('.', $PicFileName);
    $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
    while (file_exists("images/admin/" . $PicFileName)) {
    $i++;
    $PicFileName = $Arr1[0] . $i . "." . $Arr1[1];
    }
    } else {
    $PicFileName = $icon;
    }
    if (file_exists("images/admin/" . $old_img)) {
    unlink("images/admin/" . $old_img);
    }
    move_uploaded_file($primary_benifits_img_path, "images/admin/" . $PicFileName);
    } else {
    $PicFileName = $old_img;
    }

    try {
        echo"UPDATE `admin` SET `username`=".$username.",`password`=".$password." WHERE `id`=".$id."";
    $stmt = $obj->con1->prepare("UPDATE `admin` SET `username`=?,`password`=? WHERE `id`=?");
    $stmt->bind_param("ssi",$username , $password, $id);
    $Resp = $stmt->execute();
    if (!$Resp) {
    throw new Exception("Problem in updating! " . strtok($obj->con1->error, "("));
    }
    $stmt->close();
    } catch (Exception $e) {
    setcookie("sql_error", urlencode($e->getMessage()), time() + 3600, "/");
    }

    if ($Resp) {
    setcookie("edit_id", "", time() - 3600, "/");
    setcookie("msg", "update", time() + 3600, "/");
    header("location:admin.php");
    } else {
    setcookie("msg", "fail", time() + 3600, "/");
    header("location:admin.php");
    }
    }
    ?>
    <div class="pagetitle">
        <h1>Admin</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item">Admin</li>
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
                            <div class="row pt-3">
                            <div class="col-md-12">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="<?php echo (isset($mode)) ? $data['username'] : '' ?>"
                                    <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?>>
                            </div>
                        </div>

                        <div class="col-md-12">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" class="form-control" id="password" name="password"
                                    value="<?php echo (isset($mode)) ? $data['password'] : '' ?>"
                                    <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?>>
                            </div>

                            <div class="text-left mt-4">
                <button type="submit" name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
                    class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                </button>
                <button type="button" class="btn btn-danger" onclick="window.location='admin.php'">
                    Close</button>
            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script type="text/javascript">
        
    function go_back() {
        eraseCookie("edit_id");
        eraseCookie("view_id");
        window.location = "admin.php";
    }

    function readURL(input, preview) {
        if (input.files && input.files[0]) {
            var filename = input.files.item(0).name;
            var reader = new FileReader();
            var extn = filename.split(".");

            if (["jpg", "jpeg", "png", "bmp"].includes(extn[1].toLowerCase())) {
                reader.onload = function(e) {
                    document.getElementById(preview).src = e.target.result;
                    document.getElementById(preview).style.display = "block";
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