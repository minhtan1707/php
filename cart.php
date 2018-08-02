<?php
    require('config/db.php');
    require('config/config.php');
    session_start();
    // sort($_SESSION['cart']);
    // echo '<br>';
    // print_r($_SESSION['cart']);
    // echo '<br>';
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
                <div class="col-3">
                    <img class="img-fluid" src="<?php echo 'images/profile'.$product['id'].'.jpg';?>" alt="">
                </div>
                
                <?php   
                if($product['id']!=""): ?>
                
                    <div class='col-6'>
                    Product name: <?php echo $product['product_name'];?><br>    
                    Price: <?php echo $product['price'];?>$<br>
                    Description: <?php echo $product['description'];?><br>
                    </div>
                    <div class="col-3">
                        <form method=get class='update-quantity-form' action=update_quantity.php>                           
                            <div class='input-group'>
                                <input type=hidden name=id value=<?php echo $product['id'];?> />
                                <input type='number' name='quantity' value=<?php echo $product['quantity'];?> class='form-control cart-quantity' min='1' >
                                    <span class='input-group-btn'>
                                        <button class='btn btn-default ml-1 update-quantity' type='submit'>Update</button>
                                    </span>
                            </div>
                            <div class=mt-2>
                                <?php
                                $sub_total=$product['price']*$product['quantity'];
                                $total+=$sub_total;
                                echo $sub_total.'$';
                                ?>
                            </div>
                        </form>
                        <a href=remove_from_cart.php?id=<?php echo $product['id']?> class='btn btn-primary mt-5'>
                            Delete
                        </a><br>                  
                    </div> 
                
                <?php endif ?>
                        
            </div>
        </li>
    </ul>   
    <?php endforeach?>
    <p class="text-right mr-3 mt-4">Total: <?php echo $total;?>$</p>
    <div class="d-flex justify-content-end">
    <a href=checkout.php class="btn btn-primary">Check Out</a>
            </div>
    </div>
    <script src="js/jquery-3.2.1.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

    