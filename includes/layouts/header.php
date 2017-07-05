<?php
    if(!isset($layout_context)) {
        $layout_context = "public";
    }
?>
<!DOCTYPE html>
<html>
   <head> <!--This header will go on all pages-->
      <title>Widget Corp <?php if ($layout_context == "admin") {echo "Admin";}  ?></title>
      <link rel = "stylesheet" type = "text/css" href = "css/styles.css" />
   </head>
   <body>
      <header id = "header">
         <h1>Widget Corp <?php if ($layout_context == "admin") {echo "Admin";}  ?></h1>
      </header>
