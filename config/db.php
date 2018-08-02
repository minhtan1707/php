<?php

$conn= mysqli_connect('localhost:3307','root','','contact');

if(mysqli_connect_errno())
{
    echo 'Failed '. mysqli_connect_errno();
}

?>