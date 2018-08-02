<?php
    require('../config/db.php');
    require('../config/config.php');

    if(isset($_POST['submit']))
    {
        $update_id = mysqli_real_escape_string($conn,$_POST['update_id']);
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $price=mysqli_real_escape_string($conn,$_POST['price']);
        $description=mysqli_real_escape_string($conn,$_POST['description']);
        
        $insert_query="UPDATE product SET
                        product_name='$name',
                        price='$price',
                        description='$description'
                        WHERE id ={$update_id}";

        if(mysqli_query($conn,$insert_query))
        {
            header('Location: '.ROOT_URL.'admin/productlist.php');
        }
        else
        {
            echo 'ERROR: '. mysqli_error($conn);
        }
    }

        //GET ID
$id= mysqli_real_escape_string($conn, $_GET['id']);

    //Create Query
$query ='SELECT * FROM product WHERE id='.$id;

    //GET Result
$result=mysqli_query($conn,$query);

    //Fetch data
// $people=mysqli_fetch_all($result); //get all data
$product=mysqli_fetch_assoc($result); //get 1 

    //Free Result
mysqli_free_result($result);

    //Close Connection
mysqli_close($conn);
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Edit Contact</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            
                <?php require('sidebar.php');?>
            
            <div class="col-lg-10 col-md-8">
                <h2>Edit Contact</h2>
                <form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">

                    <div class="form-group">
                        <label for="productname">Name:
                            <?php echo $product['product_name'];?>
                        </label>
                        <input type="text" class="form-control" name="name" id="productname" placeholder="Product Name" value="<?php echo $product['product_name'];?>">
                    </div>
                    <div class="form-group">
                        <label for="priceform">Price:
                            <?php echo $product['price'];?>$
                        </label>
                        <input type="text" class="form-control" name="price" id="priceform" placeholder="price" value="<?php echo $product['price'];?>$">
                    </div>
                    <div class="form-group">
                        <label for="descriptionform">Description</label>
                        <textarea class="form-control" name="description" id="descriptionform" rows="3"><?php echo $product['description'];?></textarea>
                    </div>
                    <input type=hidden name="update_id" value="<?php echo $product['id'];?>">
                    <button class="btn btn-primary" type="submit" name=submit value=submit>Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.2.1.slim.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>