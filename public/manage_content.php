<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<?php find_selected_page(); ?> <!--This finds what we are editing-->
<nav id = "navigation" class = "group">
    <br />
    <a href="admins.php">&laquo; Main Menu<br /></a>
   <?php
      //Navigation takes 2 parameters and returns the list of pages and subjects
      echo navigation($current_subject, $current_page); ?> <!--Populates the left nav bar-->
  <br />
  <a href = "new_subject.php">+ Add a Subject</a>
</nav>
<main id = "page">
   <article>
      <?php echo message(); ?>

     <!--Displays selected subject to edit-->
      <?php if ($current_subject) {?>
      <h2>Manage Subject</h2>
        Menu name: <?php echo htmlentities($current_subject["menu_name"]);  ?><br />
        Position: <?php echo $current_subject["position"];?><br />
        Visible: <?php echo $current_subject["visible"] == 1 ? "yes" : "no";?><br />
        <br />
        <a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>">Edit Subject</a>

    <!--Displays selected page to edit-->
      <?php } elseif ($current_page) { ?>
      <h2>Manage Page</h2>
        Page Name: <?php echo htmlentities($current_page["menu_name"]); ?><br />
        Position: <?php echo $current_page["position"];?><br />
        Visible: <?php echo ($current_page["visible"] == 1 ? "yes" : "no");?><br />
        Content:<br />
        <div class="view-content">
            <?php echo htmlentities($current_page["content"]); ?> 
        </div>
        <br />
        <a href="edit_page.php?page=<?php echo htmlentities($current_page["id"]); ?>">Edit Page</a>

      <?php } else { ?>
        Please select a subject or a page.
      <?php } ?>

   </article>
</main>
<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->


