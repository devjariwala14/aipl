<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
//error_reporting(E_ALL);

include("db_connect.php");
$obj=new DB_Connect();

if(isset($_REQUEST['action']))
{
    if($_REQUEST['action']=="get_product_name")
	{	
		$html="";

		$product_cat_id=$_REQUEST["product_cat_id"];

		$stmt_product = $obj->con1->prepare("SELECT * from `product` where `cat_id`=? AND `status`='Enable'");
        $stmt_product->bind_param("i",$product_cat_id);
		$stmt_product->execute();
		$res = $stmt_product->get_result();
		$stmt_product->close();

		$html='<option value="">Select Product Name</option>';
		while($row=mysqli_fetch_array($res))
		{
			$html.='<option value="'.$row["id"].'">'.$row["name"].'</option>';
		}
		echo $html;
	}
}
?>
