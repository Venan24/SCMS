<?php
include('../session.php');

if (isset($_GET['product_id'])){
    $selected_product_id = $_GET['product_id'];
}else{
    $selected_product_id = NULL;
}

if (!is_null($selected_product_id) || $selected_product_id != ""){

$greskica = "";
$uspjesno = "";
$categorydata = $db->query("SELECT category_id, category_name FROM categories_list WHERE category_active=1");

$stmt_get_product_info = $db->prepare("SELECT * FROM products_list WHERE product_id = ?");
$stmt_get_product_info->bind_param('i', $selected_product_id);
if ($stmt_get_product_info->execute()) {
    $stmt_get_product_info->bind_result($product_id, $product_category, $product_name, $product_model, $product_details, $product_quantity, $product_photo);
    $stmt_get_product_info->store_result();
    $stmt_get_product_info->fetch();
    $stmt_get_product_info->close();
    
    if (is_null($product_name) || $product_name == ""){
        header("Location: hax.php");
    }
}


$dozvoljeneExtenzije = array(
    "jpg",
    "jpeg",
    "gif",
    "png",
    "JPG"
);
$izabranaExtenzija   = @end(explode(".", $_FILES["file"]["name"]));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name    = mysqli_real_escape_string($db, $_POST['prodname']);
    $product_model = mysqli_real_escape_string($db,$_POST['prodmodel']);
    $product_category   = mysqli_real_escape_string($db, $_POST['prodcategory']);
    $product_details   = htmlentities($_POST['proddetails']);
    $product_quantity   = mysqli_real_escape_string($db, $_POST['prodquantity']);
    
    if ($_FILES["file"]["size"] > 0) {
        
        if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 2097152) && in_array($izabranaExtenzija, $dozvoljeneExtenzije)) {
            if ($_FILES["file"]["error"] > 0) {
                $greskica = "<div class='alert alert-danger'>Return Code: " . $_FILES["file"]["error"] . " </div>";
            } else {
                    $pic  = $_FILES["file"]["name"];
                    $conv = explode(".", $pic);
                    $ext  = $conv['1'];
                    $randomValue = rand();
                    $randomValue2 = rand();
                    $randomValue3 = rand();
                    move_uploaded_file($_FILES["file"]["tmp_name"], "../articles/".$randomValue."-".$randomValue2."-".$randomValue3.".".$ext);
                    $product_photo = $product_name."-".$randomValue."-".$randomValue2."-".$randomValue3.".".$ext;
                    $stmt_all_product_data = $db->prepare("UPDATE products_list SET product_category = ? , product_name = ? , product_model = ? , product_details = ?, product_quantity = ?, product_photo = ? WHERE product_id = ?");
                    $stmt_all_product_data->bind_param('isssisi', $product_category, $product_name, $product_model, $product_details, $product_quantity, $product_photo, $selected_product_id);
                    if ($stmt_all_product_data->execute()) {
                        $uspjesno = "<div class='alert alert-success'>Data successully updated. Auto-Refresh in 2 seconds.</div>";
                        $stmt_all_product_data->close();
                        header('Refresh: 2; url="edit_product.php?product_id='.$selected_product_id.'" ');
                    }
            }
        } else {
            $greskica = "<div class='alert alert-danger'>File Size Limit Crossed 2MB Use Picture Size less than 1MB</div>";
        }
    } else {
        $update_product_data_nophoto = $db->prepare("UPDATE products_list SET product_category = ? , product_name = ? , product_model = ? , product_details = ?, product_quantity = ? WHERE product_id = ?");
        $update_product_data_nophoto->bind_param('isssii', $product_category, $product_name, $product_model, $product_details, $product_quantity, $selected_product_id);
        if ($update_product_data_nophoto->execute()) {
            $uspjesno = "<div class='alert alert-success'>Data successully updated. Auto-Refresh in 2 seconds.</div>";
            $update_product_data_nophoto->close();
            header('Refresh: 2; url="edit_product.php?product_id='.$selected_product_id.'" ');
        }
    }
    
}

}else{
    header("Location: hax.php");
}
$db->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sales and Company Management System">
    <meta name="author" content="Venan Osmic">

    <title>SCMS - Edit Product</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- featherlight for image fade -->
    <link href="//cdn.rawgit.com/noelboss/featherlight/1.7.11/release/featherlight.min.css" type="text/css" rel="stylesheet" />
    
	<!-- TextEditor trumbowyg -->
	<link rel="stylesheet" href="../vendor/trumbowyg/dist/ui/trumbowyg.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include 'navigation.php' ?>
        <!-- Navigation -->

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Edit Product - <?php echo $product_name." ".$product_model ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Product Photo:</label>
                                            <img data-featherlight="../articles/<?php echo $product_photo ?>" src="../articles/<?php echo $product_photo ?>" style="width: 100px; height: auto;"/>               
                                        </div>
                                        <div class="form-group">
                                            <label>New Photo:</label>
                                            <input type="file" name="file" />
                                        </div>
                                        <div class="form-group">
                                            <label>Product Name:</label>
                                            <input type="text" id="autocomplete" autocomplete="off" class="form-control" name="prodname" value="<?php echo $product_name ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Product Model:</label>
                                            <input type="text" class="form-control" name="prodmodel" value="<?php echo $product_model ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Select Category:</label>
                                            <select id="CatSelect" class="selectpicker form-control" name="prodcategory" data-live-search="true" required 
                                            data-fv-notempty-message="Product Category is required field" >
                                                <?php 
                                                    while ($row = mysqli_fetch_array($categorydata, MYSQLI_ASSOC)) {
                                                    echo '<option value="'.$row['category_id'].'" >'.$row['category_name'].'</option>';
                                                    }

                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Details:</label>
                                            <textarea class="form-control" id="textEditor" name="proddetails"><?php echo $product_details ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Quantity:</label>
                                            <input type="text" class="form-control" name="prodquantity" value="<?php echo $product_quantity ?>">
                                        </div>
                                        <button type="submit" class="btn btn-success">Update Product</button>
                                        <button type="reset" class="btn btn-danger">Reset Entered Data</button>
                                    </form>
                                    <br>
                                    <?php
                                        echo $uspjesno;
                                        echo $greskica;
                                    ?>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- featherlight for image fade -->
    <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.11/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
    
    <!-- trumbowyg JavaScript -->
    <script src="../vendor/trumbowyg/dist/trumbowyg.min.js"></script>
    
	<!-- Autocomplete -->    
    <script type="text/javascript" src="../dist/js/typeahead.js"></script>
 
    <script>
    $(document).ready(function () {
    $(function() {
    	var temp = "<?php echo $product_category ?>"; 
        $("#CatSelect").val(temp);
    });
    });

    $('#textEditor').trumbowyg({
    	btns:[['formatting'],['strong', 'em', 'del'], ['link'],['removeformat']],
        autogrow: true
    });

    $('#autocomplete').typeahead({
        source: function (query, result) {
            $.ajax({
                url: "autocomplete.php",
				data: 'query=' + query,            
                dataType: "json",
                type: "POST",
                success: function (data) {
					result($.map(data, function (item) {
						return item;
                    }));
                }
            });
        }
    });
    </script>

</body>

</html>