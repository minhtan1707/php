<?php
    require('config/db.php');
    require('config/config.php');
    session_start();

    if(isset($_POST['submit']))
    {
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $address=mysqli_real_escape_string($conn,$_POST['address']);
        $phone=mysqli_real_escape_string($conn,$_POST['phone']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        
        $insert_query="INSERT INTO product_order(customer_name,customer_address,phone,email) VALUES ('$name','$address','$phone','$email')";
        
        if($conn->query($insert_query) === TRUE)
        {
            $last_id = $conn->insert_id;
            print_r($last_id); 
            echo '<br>';
            foreach($_SESSION['cart'] as $item)
            {
                if($item['id']!=""){
                $id = $item['id'];
                $order_id = $last_id;
                $quantity = $item['quantity'];
                $price = $item['price'];
                $insert="INSERT INTO order_detail(order_id, product_id,quantity,price) VALUES ($order_id,$id,$quantity,$price)";
                $conn->query($insert);
                
                }
            }
            session_destroy();
            header('Location: '.ROOT_URL.'thankyou.php');
        }
        else
        {
            echo 'ERROR: '.mysqli_error($conn);
        }
    }
   
   
// echo $q;
            
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body>
<div class="container-fluid">
    <?php require('navbar_user.php');?></div>
    <div class="container" style="max-width:940px;">
        
        <h1>Cart</h1>
        <?php foreach($_SESSION['cart'] as $product):?>
            <ul class=list-group>
                <li class=list-group-item>
                    <div class="row">
                        <div class="col-2">
                            <img class="img-fluid" src="<?php echo 'images/profile'.$product['id'].'.jpg';?>" alt="">
                        </div>
                        
                        <?php   
                        if($product['id']!="")
                        {   
                            echo "<div class='col-6'>";
                            echo 'Product name: '.$product['product_name'].'<br>';        
                            echo 'Price: '.$product['price'].'$'.'<br>';
                            echo 'Description: '.$product['description'].'<br>';
                            echo 'Quantity: '.$product['quantity'].'<br>';
                            $sub_total=$product['price']*$product['quantity'];
                            $total+=$sub_total;
                            echo 'Price: '.$sub_total.'$';
                            echo '</div>';
                            
                        }
                        ?>
                                
                    </div>
                </li>
            </ul>   
        <?php endforeach?>
        <p class="text-right mr-3 mt-4">Total: <?php echo $total;?>$</p>
        <h3>Customer detail for payment</h3>
        <form method="POST" action="<?php $_SERVER['PHP_SELF'];?>"> 
        <div class="form-group">
                <label for="nameform">Name</label>
                <input type="text" class="form-control" name="name" id="nameform" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="addressform">Address</label>
                <input type="text" class="form-control" name="address" id="addressform" placeholder="Address">
            </div>
            <div class="form-group">
                <label for="phoneform">Phone Number</label>
                <input type="text" class="form-control" name="phone" id="phoneform" placeholder="Phone">
            </div>
            <div class="form-group">
                <label for="emailform">Email</label>
                <input type="text" class="form-control" name="email" id="emailform" placeholder="Email">
            </div>
           
           
            

            <button class="btn btn-primary mb-5" type="submit" name=submit value=submit>Make Payment</button>
        </form>
    </div>
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>