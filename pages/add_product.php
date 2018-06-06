<?php
include ('../session.php');
$greskica = "";
$uspjesnoDodan = "";
$categorydata = $db->query("SELECT category_id, category_name FROM categories_list WHERE category_active=1");
$productdata = $db->query("SELECT product_id, product_name, product_model, product_quantity FROM products_list");
$dozvoljeneExtenzije = array(
    "jpg",
    "jpeg",
    "gif",
    "png",
    "JPG"
);
$izabranaExtenzija = @end(explode(".", $_FILES["file"]["name"]));

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if ($_FILES["file"]["size"] > 0) {
    
    if (isset($_POST['letsgo'])) {
        if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 4194304) && in_array($izabranaExtenzija, $dozvoljeneExtenzije)) {
            if ($_FILES["file"]["error"] > 0) {
                $greskica = "<div class='alert alert-danger'>" . $_FILES["file"]["error"] . "</div>";
            } else {
                    $pic  = $_FILES["file"]["name"];
                    $conv = explode(".", $pic);
                    $ext  = $conv['1'];
                    $randomValue = rand();
                    $randomValue2 = rand();
                    $randomValue3 = rand();
                    move_uploaded_file($_FILES["file"]["tmp_name"], "../articles/".$randomValue."-".$randomValue2."-".$randomValue3."." . $ext);
                    $productphoto = $randomValue."-".$randomValue2."-".$randomValue3."." . $ext;
            }
        } else {
            $greskica = "<div class='alert alert-danger'>File must be Image type with size < 4MB</div>";
        }
    }  
    }else{
        $productphoto = "nophoto.png";
    }
    
    if ($greskica == "") {
        $productname = mysqli_real_escape_string($db, $_POST['product_name']);
        $productmodel = mysqli_real_escape_string($db, $_POST['product_model']);
        $productcategory = mysqli_real_escape_string($db, $_POST['product_category']);
        $productdetails = htmlentities($_POST['product_details']);
        $productquantity = mysqli_real_escape_string($db, $_POST['product_quantity']);
        
        $stmt_remove_product_by_id = $db->prepare("INSERT INTO products_list (product_name, product_model, product_category, product_details, product_quantity, product_photo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_remove_product_by_id->bind_param('ssisis', $productname, $productmodel, $productcategory, $productdetails, $productquantity, $productphoto);
        
        if ($stmt_remove_product_by_id->execute()) {
            $uspjesnoDodan = "<div class='alert alert-success'>Product added successfully</div>";
            $stmt_remove_product_by_id->close();
        } else {
            $error = $stmt_remove_product_by_id->error;
            $greskica = "<div class='alert alert-danger'>".$error."</div>";
            $stmt_remove_product_by_id->close();
        }
    }
$db->close();
}
?>

<!DOCTYPE html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SCMS - Add Product</title>

    <!-- Latest compiled and minified Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                    <h1 class="page-header">Add New Product / Upadte Existing</h1>
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
                                    <div class="alert alert-info text-center">
                                        <strong>CREATE NEW PRODUCT</strong>
                                    </div>
                                    <form role="form" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Product Name:</label>
                                            <input id="autocomplete" autocomplete="off" class="form-control" placeholder="Enter Product name" name="product_name" type="text" required 
                                            data-fv-notempty-message="Product Name is required field" >
                                        </div>
                                        <div class="form-group">
                                            <label>Product Model:</label>
                                            <input class="form-control" placeholder="Enter Product Model" name="product_model" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label>Select Category:</label>
                                            <select class="selectpicker form-control" name="product_category" data-live-search="true" required 
                                            data-fv-notempty-message="Product Category is required field" >
                                                <?php 
                                                    while ($row = mysqli_fetch_array($categorydata, MYSQLI_ASSOC)) {
                                                    echo '<option value="'.$row['category_id'].'" >'.$row['category_name'].'</option>';
                                                    }

                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                        	<label>Details</label>
                                        	<textarea class="form-control" id="textEditor" name="product_details"></textarea>
                                        	
                                        </div>
                                        <div class="form-group">
                                            <label>Product Quantity:</label>
                                            <input class="form-control" placeholder="Enter Quantity" name="product_quantity" type="number">
                                        </div>
                                        <div class="form-group">
                                            <label>Upload product photo:</label>
                                            <input type="file" name="file" />
                                        </div>
                                        <button type="submit" name="letsgo" class="btn btn-success">Add New Product</button>
                                        <button type="reset" class="btn btn-danger">Reset Entered Data</button>
                                    </form>
                                    <br>
                                    <?php
                                        echo $uspjesnoDodan;
                                        echo $greskica;
                                    ?>
                                </div>
                                <!-- /.col-lg-6 (nested) -->


                                <div class="col-lg-6">
                                    <div class="alert alert-warning text-center">
                                        <strong>UPDATE EXISTING PRODUCT QUANTITY</strong>
                                    </div>
                                    <form role="form" action="" method="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Select Product you want to update quantity:</label>
                                            <select id="productselector" class="selectpicker form-control" name="product_update" data-live-search="true" required 
                                            data-fv-notempty-message="Product Category is required field" >
                                            <option selected="true" disabled="disabled">--- SELECT PRODUCT ---</option>    
                                                <?php 
                                                    while ($prodrow = mysqli_fetch_array($productdata, MYSQLI_ASSOC)) {
                                                    echo '<option value="'.$prodrow['product_id'].'">'.$prodrow['product_name'].' - '.$prodrow['product_model'].'</option>';
                                                    }
                                                ?>
                                            </select>

                                        </div>
                                        <div class="form-group form-inline">
                                            <label>Werehouse Quantity:</label>
                                            <div style="display:inline-block;" id="resultData" class="alert alert-danger">
                                            <strong>You need to choose product to load it's quantity</strong>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="disabledSelect">Enter New Quantity:</label>
                                            <input class="form-control" id="MydisabledInput" type="number" placeholder="Select Product First" disabled>
                                        </div>
                                        <button id="updateQuantity" name="updateQuantity" class="btn btn-success">Update Quantity</button>
                                        <button type="reset" class="btn btn-danger">Reset Entered Data</button>
                                    </form>
                                </div>

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

    <!-- Latest compiled and minified Bootstrap Select JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- trumbowyg JavaScript -->
    <script src="../vendor/trumbowyg/dist/trumbowyg.min.js"></script>

	<!-- Autocomplete -->    
    <script type="text/javascript" src="../dist/js/typeahead.js"></script>

    <script>
    $(document).ready(function() {
        
        $("select#productselector").change(function(){
            var MyValue = $('#productselector option:selected').val();  
            $.ajax({
                url: 'getquantity.php',
                data: {MyValue},
                type: 'POST',
                dataType:'JSON',
                success: function(data) {
                    $('#resultData').html(data);
                    $('#MydisabledInput').prop( "disabled", false );
                    $("#MydisabledInput").attr("placeholder", "Enter New Werehouse Quantity");
                }
            });
        });
    });

    //Enable NewQuantity input after product is selected andd pass the entered data to PHP
    $("#updateQuantity").click(function(){
        var MyValue = $('#productselector option:selected').val();  
        var MyNewValue = $('#MydisabledInput').val();
        
        if (MyNewValue.length > 0){
            $.ajax({

                url: 'setquantity.php',
                data: {MyValue, MyNewValue},
                type: 'POST',
                dataType:'HTML',

                success: function(data) {
                     alert(data);
                     $('#MydisabledInput').prop( "disabled", true );
                }

            });
        }else{
            alert('You did not choose any products!');
        }          

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