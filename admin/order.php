<?php
    require('../config/db.php');
    require('../config/config.php');
    if(!isset($_POST['submit']))
    {
        $order_id=$_POST['order_id'];
        $delivered=strtoupper($_POST['delivered']);
        $update_sql="UPDATE product_order SET status =".$delivered." "."WHERE id=".$order_id.";";
        mysqli_query($conn,$update_sql);
        
    }

   

        //GET ID
$id= mysqli_real_escape_string($conn, $_GET['id']);

    //Create Query
$query1 ='SELECT * FROM product_order';

    //GET Result
$result1=mysqli_query($conn,$query1);

    //Fetch data
$total=mysqli_fetch_all($result1, MYSQLI_ASSOC);

// $product=mysqli_fetch_assoc($result); //get 1 
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

$query2="SELECT * FROM product_order LIMIT $limit OFFSET $offset";
$result2=mysqli_query($conn,$query2);
$orders=mysqli_fetch_all($result2, MYSQLI_ASSOC); 

    //Free Result

mysqli_free_result($result2);


    //Free Result
mysqli_free_result($result1);

    //Close Connection
mysqli_close($conn);
// print_r($orders_detail);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact List</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/sidebar.css" rel="stylesheet">
    <link href="../css/pagination.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <div class="container-fluid">         
        <div class="row">
        <?php require('sidebar.php');?>
            <div class="col-lg-10 col-md-8">
                <h4 class="font-weight-bold mb-2">Manage Orders</h4>
                
                <?php foreach($orders as $order): ?>
                
                <a class='bg-dark text-white px-5' href="order_detail.php?id=<?php echo $order['id'];?>">Order ID:<?php echo ' '.$order['id']?> </a>
                <div class="row mb-1 border-bottom">
                    <div class="col-4">
                        
                        <?php   echo 'Customer Name: '.$order['customer_name'].'<br>';
                                echo 'Customer Address: '.$order['customer_address'];
                        ?>
                    </div> 

                    <div class="col-4">
                        <?php   echo 'Phone: '.$order['phone'].'<br>';
                                echo 'Email: '.$order['email'];
                        ?>
                    </div> 

                    <div class="col-4">
                        <?php   
                        echo 'Delivered: ';
                        
                        echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
                        echo "<input type='radio' name='delivered' value='false' ";if($order['status']==FALSE)
                        {
                            echo 'checked';
                        }
                        else
                        {
                            echo 'unchecked';
                        }echo "> No ";
                        echo "<input type='radio' name='delivered' value='true' ";if($order['status']==TRUE)
                        {
                            echo 'checked';
                        }
                        else
                        {
                            echo 'unchecked';
                        }echo "> Yes ";
                        echo '<input type=hidden name=order_id value='.$order['id'].'>';
                        echo '<input type="submit" name="Submit" value="Change Status">';
                        echo '<br>Order date: '.$order['date_created'];
                        echo '</form>';
                        ?>
                    </div> 
                </div>



                <!-- <table class="table">
                <thead>
                <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                </tr> -->
                <?php
                foreach($orders_detail as $order_detail)
                // {
                //     if($order_detail['order_id']==$order['id'])
                //     {      
                //         echo '</thead>';
                //         echo '<tbody>';
                //         echo    '<tr>';
                //         echo    '<th scope="row">'.$order_detail['product_id'].'</th>';
                //         echo    '<td>'.$order_detail['product_name'].'</td>';
                //         echo    '<td>'.$order_detail['quantity'].'</td>';
                //         echo    '<td>'.$order_detail['price'].'$</td>';
                //         echo    '</tr>';
                //         echo '</tbody>';                  
                //     }
                // }
                ?>   
                <?php endforeach;?>
                <!-- </table> -->


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