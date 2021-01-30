<?php
// Local Database Connection
// $con=mysqli_connect("localhost", "root", "", "detsdb");

// Remote Database Connecion
$con=mysqli_connect("remotemysql.com", "87nEz6q3uD", "DXytI56BRO", "87nEz6q3uD");

if(mysqli_connect_errno()){
echo "Connection Fail".mysqli_connect_error();
}

  ?>
