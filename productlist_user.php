<?php
    require('config/db.php');
    require('config/config.php');
    session_start();

    $product_name = isset($_POST['product_name']) ? $_POST['product_name'] : "";
    $price = isset($_POST['price']) ? $_POST['price'] : "";
    $description = isset($_POST['description']) ? $_POST['description'] : "";
    $id = isset($_POST['product_id']) ? $_POST['product_id'] : "";
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    $cart_item=array(
        'id'=>$id,
        'quantity'=>$quantity,
        'product_name'=>$product_name,
        'price'=>$price,
        'description'=>$description,
    );
    if(!isset($_SESSION['id']))
    {
        $_SESSION['id']=array();
    } 

    $_SESSION['id'][$id]=$id;
    
        
    
    // print_r($_SESSION['cart']);
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
    }
    if(!in_array($product['id'],$_SESSION['id']))
    {
       
    }
    $_SESSION['cart'][$id]=$cart_item; 
    
    
    // print_r($_SESSION['cart']);
    // session_destroy();
        //GET ID
$id= mysqli_real_escape_string($conn, $_GET['id']);

    //Create Query
$query1 ='SELECT * FROM product';

    //GET Result
$result1=mysqli_query($conn,$query1);

    //Fetch data
$total=mysqli_fetch_all($result1, MYSQLI_ASSOC); //get all data
// $product=mysqli_fetch_assoc($result); //get 1 
mysqli_free_result($result1);
//total items in table
$total= count($total);
// How many items to list per page
$limit = 8;

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
    
//page



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact List</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/pagination.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container-fluid">
    <?php require('navbar_user.php');?></div>
    <div class="container" style="max-width:940px;">
    
    <h1>Contact list</h1>
        <div class="row">
            <?php foreach($products as $product): ?>
            <div class="col-3 mt-3">
                <div class="card" style="width:14rem;min-height:500px;">
                    <a href=<?php echo 'product_user_detail.php?id='.$product['id'];?>><img class="card-img-top" src="<?php echo 'images/profile'.$product['id'].'.jpg';?>"></a>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['product_name'];?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo 'Price: '.$product['price'].'$';?></h6>
                        <p class="card-text"><?php echo $product['description'];?></p>
                        <form method=post action="<?php echo $_SERVER['PHP_SELF'];?>">         
                        <input type=hidden name='product_name' value="<?php echo $product['product_name'];?>" >
                        <input type=hidden name='price' value="<?php echo $product['price'];?>" >
                        <input type=hidden name='description' value="<?php echo $product['description'];?>" >           
                        <input type=hidden name='product_id' value="<?php echo $product['id'];?>" >
                        <div class=class='mt-5'>Quantity</div>
                        <input  class='mt-0' type=number name=quantity value=1>
                        <?php  if(in_array($product['id'],$_SESSION['id']))
                        {
                            echo "<div class='m-b-10px'>This product is already in your cart.</div>";
                            echo "<a href='cart.php' class='btn btn-success w-100-pct'>";
                            echo "Update Cart";
                            echo "</a>";
                        }
                        else
                        {
                            echo "<input type=submit value='Add to cart' class='btn btn-primary mt-3'>";
                        }
                        ?>
                        </form>
                    </div>
                </div>
            </div>
            
            
             <?php endforeach;?>
             
        </div>
        <?php
            // Display the paging information
        echo '<div id="paging" class="d-flex justify-content-center my-1"><p>', $prevlink,' ', '<a class=page>',$page,'</a>',' ', $nextlink,' </p></div>';
        ?>
    </div>
  <script src="js/jquery-3.2.1.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>