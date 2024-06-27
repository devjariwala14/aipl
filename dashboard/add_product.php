<?php
    include "header.php" ; 

if (isset($_COOKIE['edit_id'])) { $mode='edit' ; $editId=$_COOKIE['edit_id'];
    $stmt=$obj->con1->prepare("SELECT * FROM `product` WHERE id=?");
    $stmt->bind_param('i', $editId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

    if (isset($_COOKIE['view_id'])) {
    $mode = 'view';
    $viewId = $_COOKIE['view_id'];
    $stmt = $obj->con1->prepare("SELECT * FROM `product` WHERE id=?");
    $stmt->bind_param('i', $viewId);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    }

    if (isset($_REQUEST["save"])) {
        $category = $_REQUEST["category"];
        $pname = $_REQUEST['name'];
        $status = $_REQUEST["radio"];
        
        try {
            echo"INSERT INTO `product`(`cat_id`, `name`,`status`) VALUES (".$category.",".$pname.",".$status.")";
            $stmt = $obj->con1->prepare("INSERT INTO `product`(`cat_id`, `name`,`status`) VALUES (?,?,?)");
            $stmt->bind_param("iss",$category, $pname, $status);
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
                header("location:product.php");
            } else {
                    setcookie("msg", "fail", time() + 3600, "/");
                    header("location:product.php");
                }
            }
            
            if (isset($_REQUEST["update"])) {
                $e_id = $_COOKIE['edit_id'];
                $category = $_REQUEST["category"];
                $pname = $_REQUEST['name'];
                $status = $_REQUEST["radio"];
                        
                try {
                    $stmt = $obj->con1->prepare("UPDATE `product` SET `cat_id`=?,`name`=?,`status`=? WHERE `id`=?");
                    $stmt->bind_param("issi",$category, $pname, $status, $e_id);
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
    <h1>Product</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">Product</li>
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
                            <label for="category" class="col-sm-2 col-form-label">Product Category</label>
                            <select class="form-select text-black" name="category" id="category" <?php echo isset($mode) && $mode=='view'?'disabled':'' ?> onchange="get_product_name(this.value)" required>
                                <option value="">Select Product Category</option>
                                <?php
                                $stmt = $obj->con1->prepare("SELECT * FROM product_category where status='Enable'");
                                $stmt->execute();
                                $Resp = $stmt->get_result();
                                $stmt->close();

                                while ($result = mysqli_fetch_array($Resp)) {
                                ?>
                                    <option value="<?php echo $result["id"]; ?>" <?php echo (isset($mode) && $data["cat_id"]==$result["id"])?"selected":""; ?>>
                                        <?php echo $result["category"]; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                            <div class="col-md-12">
                                <label for="pname" class="col-sm-2 col-form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo (isset($mode)) ? $data['name'] : '' ?>"
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
                            <button type="button" class="btn btn-danger" onclick="window.location='product.php'">
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
    window.location = "product.php";
}
</script>
<?php
        include "footer.php";
        ?>