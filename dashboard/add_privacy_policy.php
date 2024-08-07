<?php
    include "header.php" ; 

if (isset($_COOKIE['edit_id'])) { $mode='edit' ; $editId=$_COOKIE['edit_id'];
    $stmt=$obj->con1->prepare("SELECT * FROM `privacy_policy` WHERE id=?");
    $stmt->bind_param('i', $editId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

    if (isset($_COOKIE['view_id'])) {
    $mode = 'view';
    $viewId = $_COOKIE['view_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `privacy_policy` WHERE id=?");
    $stmt->bind_param('i', $viewId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

    if (isset($_REQUEST["save"])) {
        $details = $_REQUEST["details"];
        $date = $_REQUEST["date"];
        $time = $_REQUEST["time"];
        $date_time = $date . ' ' . $time;
        $operation = "Added";
        
        try {
            echo"INSERT INTO `privacy_policy`(`details`, `date_time`,`operation`) VALUES (".$details.", ".$date_time.",".$operation.")";
            $stmt = $obj->con1->prepare("INSERT INTO `privacy_policy`(`details`, `date_time`,`operation`) VALUES (?,?,?)");
            $stmt->bind_param("sss", $details, $date_time,$operation);
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
            
                setcookie("msg", "data", time() + 3600, "/");
                header("location:privacy_policy.php");
            } else {
                    setcookie("msg", "fail", time() + 3600, "/");
                    header("location:privacy_policy.php");
                }
            }
            
            if (isset($_REQUEST["update"])) {
                $e_id = $_COOKIE['edit_id'];
                $details = $_REQUEST["details"];
                $date = $_REQUEST["date"];
                $time = $_REQUEST["time"];
                $date_time = $date . ' ' . $time;
                $operation = "Updated";
                        
                try {
                    $stmt = $obj->con1->prepare("UPDATE `privacy_policy` SET `details`=?, `date_time`=?,`operation`=? WHERE `id`=?");
                    $stmt->bind_param("sssi",  $details, $date_time,$operation,$e_id);
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
                    header("location:privacy_policy.php");
                } else {
                    setcookie("msg", "fail", time() + 3600, "/");
                    header("location:privacy_policy.php");
                }
            }
    ?>
<div class="pagetitle">
    <h1>Privacy Policy</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Privacy Policy</li>
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
                <div class="card-body">

                    <!-- Multi Columns Form -->
                    <form class="row g-3 pt-3" method="post">

                        <div class="col-md-12">
                            <label for="details" class="col-sm-2 col-form-label">Details</label>
                            <textarea class="tinymce-editor" name="details" id="details"
                                <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?>><?php echo (isset($mode)) ? $data['details'] : '' ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="inputDate" class="col-sm-2 col-form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date"
                                value="<?php echo (isset($mode)) ? date('Y-m-d', strtotime($data['date_time'])) : '' ?>"
                                <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?>>
                        </div>
                        <div class="col-md-6">
                            <label for="inputTime" class="col-sm-2 col-form-label">Time</label>
                            <input type="time" class="form-control" id="time" name="time"
                                value="<?php echo (isset($mode)) ? date('H:i', strtotime($data['date_time'])) : '' ?>"
                                <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?>>
                        </div>

                        <div class="text-left mt-4">
                            <button type="submit"
                                name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
                                class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                            </button>
                            <button type="button" class="btn btn-danger" onclick="window.location='privacy_policy.php'">
                                Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function go_back() {
    eraseCookie("edit_id");
    eraseCookie("view_id");
    window.location = "privacy_policy.php";
}
</script>
<?php
        include "footer.php";
        ?>