<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<?php find_selected_page(); ?> <!--This finds what we are editing-->
<nav id = "navigation">
   <?php
      //Navigation takes 2 parameters and returns the list of pages and subjects
      echo navigation($current_subject, $current_page); ?> <!--Populates the left nav bar-->
</nav>
<main id = "page">
   <article>

     <!--Displays selected subject to edit-->
      <?php if ($current_subject) {?>
      <h2>Manage Subject</h2>
        Menu name: <?php echo $current_subject["menu_name"];  ?><br />

    <!--Displays selected page to edit-->
      <?php } elseif ($current_page) { ?>
      <h2>Manage Page</h2>
        Page Name: <?php echo $current_page["menu_name"]; ?>

      <?php } else { ?>
        Please select a subject or a page.
      <?php } ?>

   </article>
</main>
<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->


