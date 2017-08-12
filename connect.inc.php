<?php
/**************************************************
This is to connect to database

creator:- raman tehlan
Date of creation:- 04/02/2017 at 1:14am
***************************************************/

//MYSQL DETAIL AREA

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "optimus";
$table_name = "retailers_sales";

$connect = mysqli_connect($db_host , $db_user , $db_pass);

?>