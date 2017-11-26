<?php

//db connection information
$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "qkrtmddn";
$DB_name = "hw3";

try
{
	//connect to DB
        $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
        $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
        echo $e->getMessage();
}

//when I connect to db, I always use contact class.
include_once 'contact.php';
$contact = new CONTACT($DB_con);

?>
                                         
