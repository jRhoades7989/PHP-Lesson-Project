<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php $layout_context = "admin"; ?>
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php 
    if(isset($_GET["id"])) {
        $current_admin = find_admin_by_id($_GET["id"]);
        $id = $current_admin["id"];
    } else {
        $id = null;
    }
    if(isset($_POST["delete{$id}"])) {
    //Admin was deleted
        if (!$current_admin) {
            //page ID was missing or invalid or
            //page couldn't be found in the database
            redirect_to("manage_admins.php");
        }

        $query = "DELETE FROM admins WHERE id = {$current_admin["id"]} LIMIT 1";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_affected_rows($connection) == 1) {
            //success
            $_SESSION["message"] = "admin deleted.";
            redirect_to("manage_admins.php");
        } else {
            //failure
            $_SESSION["message"] = "Admin deletion failed.";
            redirect_to("manage_admins.php");
        }
    } else {
        //This is probably a GET request
    } //end: if (isset($_POST["delete"]))
?>
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<nav id="navigation" class="group">
    <br />
    <a href="admins.php">&laquo; Main Menu</a>
</nav>
<main id = "page">
   <article>
      <?php echo message(); ?>
        <h2>Manage Admins</h2>
        <table>
            <tr>
                <th>Username:</th>
                <th>Actions:</th>
            </tr>
            <?php echo display_admins(); ?>
        </table><br />
        <a href="new_admin.php">Add New Admin</a>
   </article>
</main>
<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->
