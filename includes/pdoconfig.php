<?php
$dbuser="vera.anthonio";
$dbpass="Varriepas3!";
$host="localhost";
$db="webtech_fall2024_vera_anthonio";
try
{
 $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
 $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
 $e->getMessage();
}
?>