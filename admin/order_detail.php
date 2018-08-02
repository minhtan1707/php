<?php
    require('../config/db.php');
    require('../config/config.php');

    $id=$_GET['id'];

    //Create Query
$query1 ='SELECT * FROM product_order WHERE id='.$id;

    //GET Result
$result1=mysqli_query($conn,$query1);

    //Fetch data
$order=mysqli_fetch_assoc($result1); 

$query2 ="SELECT d.*,od.* FROM `order_detail` od left JOIN product d on od.product_id=d.id WHERE od.order_id=$id;";
$result2=mysqli_query($conn,$query2);
$orders_detail=mysqli_fetch_all($result2, MYSQLI_ASSOC); //get all data
mysqli_free_result($result2);
mysqli_close($conn);

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <div class="container-fluid">         
        <div class="row">
        <?php require('sidebar.php');?>
            <div class="col-lg-10 col-md-8">
                <h3 class="font-weight-bold mb-3">Order <?php echo $id;?> </h3>
            


                <div class="row mb-1">
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
                        echo '<br>Order date: '.$order['date_created'];
                        echo '</form>';
                        ?>
                    </div> 
                </div>

                <table class="table">
                <thead>
                <tr>
                <th scope="col">Product ID</th>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                </tr>
                <?php
                    foreach ($orders_detail as $order_detail)
                       {
                        echo '</thead>';
                        echo '<tbody>';
                        echo    '<tr>';
                        echo    '<th scope="row">'.$order_detail['product_id'].'</th>';
                        echo    '<td>'.$order_detail['product_name'].'</td>';
                        echo    '<td>'.$order_detail['quantity'].'</td>';
                        echo    '<td>'.$order_detail['price'].'$</td>';
                        echo    '</tr>';
                        echo '</tbody>';                  
                       }
                
                ?>   
                
                </table>


                <?php
                // Display the paging information
               // echo '<div id="paging" class="d-flex justify-content-center my-1"><p>', $prevlink, ' Page ', $page, ' of ', $pages ,' ', $nextlink,' </p></div>';
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