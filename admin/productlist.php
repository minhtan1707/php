<?php
    require('../config/db.php');
    require('../config/config.php');

    if(isset($_POST['delete']))
    {
        $delete_id = mysqli_real_escape_string($conn,$_POST['delete_id']);

        
    $delete_query="DELETE FROM product WHERE id={$delete_id}";

        if(mysqli_query($conn,$delete_query))
        {
            header('Location:productlist.php');
        }
        else
        {
            echo 'ERROR: '. mysqli_error($conn);
        }
    }

        //GET ID
$id= mysqli_real_escape_string($conn, $_GET['id']);

    //Create Query
$query1 ='SELECT * FROM product';

    //GET Result
$result1=mysqli_query($conn,$query1);

    //Fetch data
$total=mysqli_fetch_all($result1, MYSQLI_ASSOC); //get all data
// $product=mysqli_fetch_assoc($result); //get 1 
    //Free Result
    mysqli_free_result($result1);

$total= count($total);
// How many items to list per page
$limit = 6;

// How many pages will there be
$pages = ceil($total / $limit);

// What page are we currently on?
$page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
    'options' => array(
        'default'   => 1,
        'min_range' => 1,
    ),
)));

 // Calculate the offset for the query
 $offset = ($page - 1)  * $limit;

 // Some information to display to the user
 $start = $offset + 1;
 $end = min(($offset + $limit), $total);
  // The "back" link
  $prevlink = ($page > 1) ? '<a class=active href="?page=1" title="First page"><i class="fa fa-angle-double-left" style="font-size:20px"></i></a> <a class=active href="?page=' . ($page - 1) . '" title="Previous page"><i class="fa fa-angle-left" style="font-size:20px"></i></a>' : '<a class="disabled"><i class="fa fa-angle-double-left" style="font-size:20px"></i></a><a class="disabled"><i class="fa fa-angle-left" style="font-size:20px"></i></a>';

  // The "forward" link
  $nextlink = ($page < $pages) ? '<a class=active href="?page=' . ($page + 1) . '" title="Next page"><i class="fa fa-angle-right" style="font-size:20px"></i></a><a class=active href="?page=' . $pages . '" title="Last page"><i class="fa fa-angle-double-right" style="font-size:20px"></i></a>' : '<a class="disabled"><i class="fa fa-angle-right" style="font-size:20px"></i></a> <a class="disabled"><i class="fa fa-angle-double-right" style="font-size:20px"></i></a>';
 
$query2="SELECT * FROM product LIMIT $limit OFFSET $offset";
$result2=mysqli_query($conn,$query2);
$products=mysqli_fetch_all($result2, MYSQLI_ASSOC); 

    //Free Result

mysqli_free_result($result2);



    //Close Connection
mysqli_close($conn);
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product List</title>
    <link href="../css/sidebar.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/pagination.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <div class="container-fluid">         
        <div class="row">
        <?php require('sidebar.php');?>
            <div class="col-lg-10 col-md-8">
                <h1>Product list</h1>
                
                <?php foreach($products as $product): ?>
                <div class="row border">
                    <div class="col-1 my-1">
                        
                            <a href=<?php echo 'product_detail.php?id='.$product['id'];?>><img class="img-fluid" src="<?php echo '../images/profile'.$product['id'].'.jpg';?>"></a>
                    </div>         
                    <div class="col-9 my-1">
                                <p class="my-1"><?php echo $product['product_name'];?></p>
                                <p class="my-1 text-muted"><?php echo 'Price: '.$product['price'].'$';?></p>
                                <p class="my-1"><?php echo $product['description'];?></p>
                    </div>      
                    <div class="col-2 my-1">
                                <form method=post action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <a href="<?php echo 'edit.php?id='.$product['id'];?>" class="btn mt-2 btn-primary">Edit</a>
                                <input type=hidden name="delete_id" value="<?php echo $product['id'];?>">
                                <input type=submit name="delete" value=Delete class="btn mt-2 btn-danger"></a>
                                </form>
                    </div>       
                        
                    </div>                  
                <?php endforeach;?>
                
                <?php
            // Display the paging information
        echo '<div id="paging" class="d-flex justify-content-center my-1"><p>', $prevlink,' ', '<a class=page>',$page,'</a>',' ', $nextlink,' </p></div>';
        ?>
            </div>
        </div>
    </div>
  <script src="../js/jquery-3.2.1.slim.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>