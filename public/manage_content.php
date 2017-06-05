<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); ?>
<nav id = "navigation">
   <?php
      //Navigation takes 2 parameters and returns the list of pages and subjects
      echo navigation($current_subject, $current_page); ?>
</nav>
<main id = "page">
   <article>

      <?php if ($current_subject) {?>
      <h2>Manage Subject</h2>
        Menu name: <?php echo $current_subject["menu_name"];  ?><br />

      <?php } elseif ($current_page) { ?>
      <h2>Manage Page</h2>
        Page Name: <?php echo $current_page["menu_name"]; ?>

      <?php } else { ?>
        Please select a subject or a page.
      <?php } ?>

   </article>
</main>
<?php include("../includes/layouts/footer.php"); ?>


