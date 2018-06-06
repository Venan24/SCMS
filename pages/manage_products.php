<?php
include('../session.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sales and Company Management System">
    <meta name="author" content="Venan Osmic">

    <title>SCMS - Manage Products</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

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
                    <h1 class="page-header">Manage Products</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Model</th>
                                        <th>Category</th>
                                        <th>Product Details</th>
                                        <th>Quantity</th>
                                        <th>Photo</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $userData = $db->query("SELECT products_list.product_id, products_list.product_name, products_list.product_model, categories_list.category_name, products_list.product_details, products_list.product_quantity, products_list.product_photo
                                        FROM products_list
                                        INNER JOIN categories_list ON products_list.product_category=categories_list.category_id");

                                    while ($row = mysqli_fetch_array($userData, MYSQLI_ASSOC)) {

                                        echo '<tr>
                                                    <td><a style="text-decoration:none; color:red;">'.$row['product_name'].'</a></td>
                                                    <td>'.$row['product_model'].'</td>
                                                    <td>'.$row['category_name'].'</td>
                                                    <td>
                                                    <center><a href="#" data-toggle="collapse" data-target="#'.$row['product_id'].'-'.$row['product_id'].'" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search text-success"></span> Show Details</a></center>
                                                    <div id="'.$row['product_id'].'-'.$row['product_id'].'" class="collapse">'.html_entity_decode($row['product_details']).'</div>
                                                    </td>
                                                    <td>'.$row['product_quantity'].'</td>
                                                    <td>
                                                    <center><a data-featherlight="image"href="../articles/'.$row['product_photo'].'" class="btn btn-default btn-sm">
                                                        <span class="fa fa-photo"></span> Show Photo 
                                                    </a></center>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="edit_product.php?product_id='.$row['product_id'].'" class="btn btn-default btn-sm">
                                                            <span class="glyphicon glyphicon-edit text-success"></span> Edit 
                                                        </a>
                                                        <a href="#" id="'.$row['product_id'].'" class="delete_product btn btn-default btn-sm">
                                                            <span class="glyphicon glyphicon-remove text-danger"></span> Remove 
                                                        </a>
                                                    </td>   
                                                </tr>';
                                    }

                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
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

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.0/js/buttons.bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.colVis.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- featherlight for image fadeing -->
    <script src="//cdn.rawgit.com/noelboss/featherlight/1.7.11/release/featherlight.min.js" type="text/javascript" charset="utf-8"></script>

    <script>
    $(document).ready(function() {
    var table = $('#dataTables').DataTable( {
            responsive: true,
            lengthChange: false,
            order: [[ 0, "asc" ]],
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4] }
                },
                {
                    extend: 'print',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4] }
                },
                {
                    extend: 'pdf',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4] }
                },
                {
                    extend: 'csv',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4] }
                },
                {
                    extend: 'excel',
                    exportOptions: { columns: [ 0, 1, 2, 3, 4] }
                }
            ],
               
    } );
 
    table.buttons().container()
        .appendTo( '#dataTables_wrapper .col-sm-6:eq(0)' );
    } );

    $('.delete_product').click(function(){
        
        var remove_table_row = this;
        var selected_id = $(this).attr('id');
        console.log(selected_id);
        
        if(confirm("Are you sure you want to delete this product?")){  
        $.ajax({
          type:"POST",
          url:"delete_product.php",
          data:"delete_this_id="+selected_id,
          success:function(){
            $(remove_table_row).closest('tr').css('background', 'tomato');
            $(remove_table_row).closest('tr').fadeOut(1000, function(){
            $(this).remove();
            });
          }
        })
      }
      
      });
    </script>

</body>

</html>
