<?php //error_reporting(E_ALL & ~E_NOTICE);error_reporting ( E_ERROR );
$SERvervidor="localhost";
$SERusuario="root";
$SERclave="";
$SERdata="andredb";
global $connection;
$connection = mysqli_connect("$SERvervidor","$SERusuario","$SERclave","$SERdata");

