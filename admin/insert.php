<?php
    require('../config/db.php');
    require('../config/config.php');

//     //GET ID
// $id= mysqli_real_escape_string($conn, $_GET['id']);

//     //Create Query
// $query ='SELECT * FROM people WHERE id='.$id;

//     //GET Result
// $resule=mysqli_query($conn,$query);

//     //Fetch data
// $people=mysqli_fetch_all($result); //get all data
// $person=mysqli_fetch_assoc($result); //get 1 

//     //Free Result
// mysqli_free_result($result);

//     //Close Connection
// mysqli_close($conn);

    if(isset($_POST['submit']))
    {
        $name= mysqli_real_escape_string($conn,$_POST['name']);
        $price=mysqli_real_escape_string($conn,$_POST['price']);
        $description=mysqli_real_escape_string($conn,$_POST['description']);

        
        $insert_query="INSERT INTO product(product_name,price,description) VALUES ('$name',$price,'$description')";

        if(mysqli_query($conn,$insert_query))
        {
            header('Location: '.ROOT_URL.'admin/insert.php');
        }
        else
        {
            echo 'ERROR: '.mysqli_error($conn);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Insert Contact</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require('sidebar.php');?>
            <div class="col-lg-10 col-md-8">
            <h2>Add Product</h2>
            <form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">
                <div class="form-row">
                    <div class="col-6">
                        <input type="text" name="name" class="form-control" placeholder="Product name">
                    </div>
                    <div class="col-6">

                        <input type="text" name="price" class="form-control" placeholder="Price">
                    </div>
                </div>
                <div class="form-group">
                    <label for="messageform">Message</label>
                    <textarea class="form-control" name="description" id="messageform" rows="3"></textarea>
                </div>

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