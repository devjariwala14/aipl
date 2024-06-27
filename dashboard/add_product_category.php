<?php
    include "header.php" ; 

if (isset($_COOKIE['edit_id'])) { $mode='edit' ; $editId=$_COOKIE['edit_id'];
    $stmt=$obj->con1->prepare("SELECT * FROM `product_category` WHERE id=?");
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
        $status = $_REQUEST["radio"];
        
        try {
            $stmt = $obj->con1->prepare("INSERT INTO `product_category`(`category`, `status`) VALUES (?,?)");
            $stmt->bind_param("ss", $category, $status);
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
                header("location:product_category.php");
            } else {
                    setcookie("msg", "fail", time() + 3600, "/");
                    header("location:product_category.php");
                }
            }
            
            if (isset($_REQUEST["update"])) {
                $e_id = $_COOKIE['edit_id'];
                $category = $_REQUEST["category"];
                $status = $_REQUEST["radio"];
                        
                try {
                    $stmt = $obj->con1->prepare("UPDATE `product_category` SET `category`=?,`status`=? WHERE `id`=?");
                    $stmt->bind_param("ssi", $category, $status, $e_id);
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
                    header("location:product_category.php");
                } else {
                    setcookie("msg", "fail", time() + 3600, "/");
                    header("location:product_category.php");
                }
            }
    ?>
<div class="pagetitle">
    <h1>Product Category</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Product Category</li>
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
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <label for="menu" class="form-label">Product Category</label>
                                <input type="text" class="form-control" id="category" name="category"
                                    value="<?php echo (isset($mode)) ? $data['category'] : '' ?>"
                                    <?php echo isset($mode) && $mode == 'view' ? 'readonly' : '' ?>>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="inputEmail5" class="form-label">Status</label> <br />
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="radio" id="radio"
                                    <?php echo isset($mode) && $data['status'] == 'Enable' ? 'checked' :'' ?>
                                    class="form-radio text-primary" value="Enable" checked required
                                    <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?> />
                                <label class="form-check-label" for="gridRadios1">Enable</label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input" type="radio" name="radio" id="radio"
                                    <?php echo isset($mode) && $data['status'] == 'Disable' ? 'checked' : '' ?>
                                    class="form-radio text-danger" value="Disable" required
                                    <?php echo isset($mode) && $mode == 'view' ? 'disabled' : '' ?> />
                                <label class="form-check-label" for="gridRadios2">Disable</label>
                            </div>
                        </div>
                        <div class="text-left mt-4">
                            <button type="submit"
                                name="<?php echo isset($mode) && $mode == 'edit' ? 'update' : 'save' ?>" id="save"
                                class="btn btn-success <?php echo isset($mode) && $mode == 'view' ? 'd-none' : '' ?>"><?php echo isset($mode) && $mode == 'edit' ? 'Update' : 'Save' ?>
                            </button>
                            <button type="button" class="btn btn-danger"
                                onclick="window.location='product_category.php'">
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
    window.location = "product_category.php";
}
</script>
<?php
        include "footer.php";
        ?>