<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php $layout_context = "public" ?>
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<?php find_selected_page(); ?> <!--This finds what we are editing-->
<nav id = "navigation" class = "group">
    <br />
   <?php
      //Navigation takes 2 parameters and returns the list of pages and subjects
      echo public_navigation($current_subject, $current_page); ?> <!--Populates the left nav bar-->
  <br />
</nav>
<main id = "page">
   <article>

     <!--Displays selected subject to edit-->
      <?php if ($current_subject) {?>
      <h2>Manage Subject: <?php echo htmlentities($current_subject["menu_name"]);  ?></h2>
    
    <!--Displays selected page to edit-->
      <?php } elseif ($current_page) { ?>
            <?php echo htmlentities($current_page["content"]); ?> 

      <?php } else { ?>
        Please select a subject or a page.
      <?php } ?>

   </article>
</main>
<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->




      <script src = "scripts.js"></script>
   </body>
</html>
