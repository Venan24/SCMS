<?php
include('../session.php');

   //Broj artikala, korisnika isl.
   $result_customers = $db->query("SELECT customer_id FROM customers_list");
   $length_customers = mysqli_num_rows($result_customers);

   $result_categories = $db->query("SELECT category_id FROM categories_list WHERE category_active=1");
   $length_categories = mysqli_num_rows($result_categories);

   $result_categories_inactive = $db->query("SELECT category_id FROM categories_list WHERE category_active=0");
   $length_categories_inactive = mysqli_num_rows($result_categories_inactive);

   $result_products = $db->query("SELECT product_id FROM products_list");
   $length_products = mysqli_num_rows($result_products);
   
   $last_article_q = $db->query("SELECT products_list.product_id, products_list.product_name, products_list.product_model, categories_list.category_name, products_list.product_details, products_list.product_quantity, products_list.product_photo
                                FROM products_list
                                INNER JOIN categories_list ON products_list.product_category=categories_list.category_id 
                                ORDER BY product_id DESC LIMIT 1");
   $last_article = mysqli_fetch_assoc($last_article_q);
   
   $largest_stock_item_q = $db->query("SELECT products_list.product_id, products_list.product_name, products_list.product_model, categories_list.category_name, products_list.product_details, products_list.product_quantity, products_list.product_photo
                                FROM products_list
                                INNER JOIN categories_list ON products_list.product_category=categories_list.category_id
                                ORDER BY product_quantity DESC LIMIT 1");
   $largest_stock_item = mysqli_fetch_assoc($largest_stock_item_q);
   
   $smallest_stock_item_q = $db->query("SELECT products_list.product_id, products_list.product_name, products_list.product_model, categories_list.category_name, products_list.product_details, products_list.product_quantity, products_list.product_photo
                                FROM products_list
                                INNER JOIN categories_list ON products_list.product_category=categories_list.category_id
                                ORDER BY product_quantity ASC LIMIT 1");
   $smallest_stock_item = mysqli_fetch_assoc($smallest_stock_item_q);
   
   
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sales and Company Management System">
    <meta name="author" content="Venan Osmic">

    <title>SCMS - Dashboard</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- featherlight for image fadeing -->
    <link href="//cdn.rawgit.com/noelboss/featherlight/1.7.11/release/featherlight.min.css" type="text/css" rel="stylesheet" />

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
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                 <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-credit-card fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">SOON...</div>
                                    <div>Issued Invoices</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Invoices</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>               
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user-circle fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $length_customers; ?></div>
                                    <div>Active Customers</div>
                                </div>
                            </div>
                        </div>
                        <a href="manage_customers.php">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Customers</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-bag fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $length_products; ?></div>
                                    <div>Active Products</div>
                                </div>
                            </div>
                        </div>
                        <a href="manage_products.php">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Products</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-list-ul fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $length_categories."(<span style='text-decoration:line-through;'>".$length_categories_inactive."</span>)" ?></div>
                                    <div>Active Categories</div>
                                </div>
                            </div>
                        </div>
                        <a href="manage_categories.php">
                            <div class="panel-footer">
                                <span class="pull-left">Manage Categories</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Articles Quick Board</h1>
                </div>
                
                <div id="mojpanel" class="col-lg-4">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            Last Added Article
                        </div>
                        <div class="panel-body">
                        	<img data-featherlight="../articles/<?php echo $last_article["product_photo"];?>" src="../articles/<?php echo $last_article["product_photo"];?>" class="img-responsive center-block" style="width:200px;"/>
                            <p><strong>Name: </strong><?php echo $last_article["product_name"];?></p>
                            <p><strong>Model: </strong><?php echo $last_article["product_model"];?></p>
                            <p><strong>Category: </strong><?php echo $last_article["category_name"];?></p>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="edit_product.php?product_id=<?php echo $last_article["product_id"];?>" class="btn btn-default btn-sm">
                            	<span class="glyphicon glyphicon-edit text-success"></span> Edit Product
                            </a>
                            <a href="#" id="<?php echo $last_article["product_id"];?>" class="delete_last_product btn btn-default btn-sm">
                            	<span class="glyphicon glyphicon-remove text-danger"></span> Remove Product
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div id="mojpanel2" class="col-lg-4">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            Largest Stock Quantity - <strong><?php echo $largest_stock_item["product_quantity"];?></strong>
                        </div>
                        <div class="panel-body">
                        	<img data-featherlight="../articles/<?php echo $largest_stock_item["product_photo"];?>" src="../articles/<?php echo $largest_stock_item["product_photo"];?>" class="img-responsive center-block" style="width:200px;"/>
                            <p><strong>Name: </strong><?php echo $largest_stock_item["product_name"];?></p>
                            <p><strong>Model: </strong><?php echo $largest_stock_item["product_model"];?></p>
                            <p><strong>Category: </strong><?php echo $largest_stock_item["category_name"];?></p>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="edit_product.php?product_id=<?php echo $largest_stock_item["product_id"];?>" class="btn btn-default btn-sm">
                            	<span class="glyphicon glyphicon-edit text-success"></span> Edit Product
                            </a>
                            <a href="#" id="<?php echo $largest_stock_item["product_id"];?>" class="delete_Largest_product btn btn-default btn-sm">
                            	<span class="glyphicon glyphicon-remove text-danger"></span> Remove Product
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
                <div id="mojpanel3" class="col-lg-4">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            Smallest Stock Quantity - <?php echo $smallest_stock_item["product_quantity"];?>
                        </div>
                        <div class="panel-body">
                        	<img data-featherlight="../articles/<?php echo $smallest_stock_item["product_photo"];?>" src="../articles/<?php echo $smallest_stock_item["product_photo"];?>" class="img-responsive center-block" style="width:200px;"/>
                            <p><strong>Name: </strong><?php echo $smallest_stock_item["product_name"];?></p>
                            <p><strong>Model: </strong><?php echo $smallest_stock_item["product_model"];?></p>
                            <p><strong>Category: </strong><?php echo $smallest_stock_item["category_name"];?></p>
                        </div>
                        <div class="panel-footer text-center">
                            <a href="edit_product.php?product_id=<?php echo $smallest_stock_item["product_id"];?>" class="btn btn-default btn-sm">
                            	<span class="glyphicon glyphicon-edit text-success"></span> Edit Product
                            </a>
                            <a href="#" id="<?php echo $smallest_stock_item["product_id"];?>" class="delete_Smallest_product btn btn-default btn-sm">
                            	<span class="glyphicon glyphicon-remove text-danger"></span> Remove Product
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-4 -->
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
    
    <!-- featherlight for image fadeing -->
    <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.11/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>
    
    <script>
    $('.delete_last_product').click(function(){
        
        var mojpanel = $('#mojpanel');
        var selected_id = $(this).attr('id');
        console.log(selected_id);
        
        if(confirm("Are you sure you want to delete this product?")){  
        $.ajax({
          type:"POST",
          url:"delete_product.php",
          data:"delete_this_id="+selected_id,
          success:function(){
            $(mojpanel).fadeOut(300, function(){
            $(mojpanel).remove();
            window.location.reload(true);
            });
          }
        })
      }
      
      });

    $('.delete_Largest_product').click(function(){
        
        var mojpanel2 = $('#mojpanel2');
        var selected_id = $(this).attr('id');
        console.log(selected_id);
        
        if(confirm("Are you sure you want to delete this product?")){  
        $.ajax({
          type:"POST",
          url:"delete_product.php",
          data:"delete_this_id="+selected_id,
          success:function(){
            $(mojpanel2).fadeOut(300, function(){
            $(mojpanel2).remove();
            window.location.reload(true);
            });
          }
        })
      }
      
      });

    $('.delete_Smallest_product3').click(function(){
        
        var mojpanel3 = $('#mojpanel3');
        var selected_id = $(this).attr('id');
        console.log(selected_id);
        
        if(confirm("Are you sure you want to delete this product?")){  
        $.ajax({
          type:"POST",
          url:"delete_product.php",
          data:"delete_this_id="+selected_id,
          success:function(){
            $(mojpanel3).fadeOut(300, function(){
            $(mojpanel3).remove();
            window.location.reload(true);
            });
          }
        })
      }
      
      });
    </script>

</body>

</html>
