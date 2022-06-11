<?php
// Local Database Connection
// $con=mysqli_connect("localhost", "root", "", "detsdb");

// Remote Database Connecion
$con=mysqli_connect("localhost", "id19087684_incomeexpenseuser", "4BJfF1nT>hUt*kJd", "id19087684_incomeexpense");
// $con=mysqli_connect("remotemysql.com", "q5xfeB8J8l", "yrM6dmI72x", "q5xfeB8J8l");

if(mysqli_connect_errno()){
echo "Connection Fail".mysqli_connect_error();
}

  ?>
