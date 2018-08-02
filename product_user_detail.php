<?php
    require('config/db.php');
    require('config/config.php');

    if(isset($_POST['delete']))
    {
        $delete_id = mysqli_real_escape_string($conn,$_POST['delete_id']);

        
    $delete_query="DELETE FROM product WHERE id={$delete_id}";

        if(mysqli_query($conn,$delete_query))
        {
            header('Location: '.ROOT_URL.'contactlist.php');
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
// $people=mysqli_fetch_all($result, MYSQLI_ASSOC); //get all data
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
    <title>Contact Detail</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container" style="max-width:940px;">
    <?php require('navbar_user.php');?>
    <h2>Contact detail</h2>
        <div class="row mt-3">
            
            <div class="col-3">
            <img class="img-fluid" src="<?php echo 'images/profile'.$product['id'].'.jpg';?>"></div>
            <div class="col-6">
            <h5><?php echo 'Name: '.$product['product_name'];?></h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo 'Price: '.$product['price'].'$';?></h6>
            <p class="card-text"><?php echo $product['description'];?></p> </div>
            <div class="col-3">
                        
            </div>

            
            

        </div>
    </div>
  <script src="js/jquery-3.2.1.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>