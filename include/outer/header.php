<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="css/icons.css" rel="stylesheet">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="css/materialize.min.css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>
  <body class="" style="background-image: url(src/img/login_bg.jpg); background-repeat: no-repeat; background-size: cover ; background-position: center; ">    
<?php
session_start();
if(isset($_SESSION['id']))
{
    header("LOCATION:dashboard");
}
    require_once('include/Constants.php');

?>
