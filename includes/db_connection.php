<?php
//1. Create a database connection
   define("DB_SERVER", "localhost");
   define("DB_USER", "widget_cms");
   define("DB_PASS", "RkstrJ0oce");
   define("DB_NAME", "widget_corp");
   $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
   //Test if connection occurred and display error if not
   if(mysqli_connect_errno()) {
      die("Database connection failed: " .
         mysqli_connect_error() .
         " (" . mysqli_connect_errno() . ")"
      );
   }
?>

