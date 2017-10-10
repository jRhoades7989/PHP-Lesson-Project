<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->


<?php 
    $current_admin = find_admin_by_id($_GET["subject"], false);
    if (!$current_admin) {
        //admin ID was missing or invalid or
        //admin couldn't be found in the database
        redirect_to("manage_admins.php");
    }

    $id = $current_admin["id"];

    $pages_set = find_pages_for_subject($id);
    if (mysqli_num_rows($pages_set) > 0) {
        $_SESSION["message"] = "Cannot delete a subject with pages.";
        redirect_to("manage_content.php?subject={$id}");
    }
    
    $query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
        //success
        $_SESSION["message"] = "Subject deleted.";
        redirect_to("manage_content.php");
    } else {
        //failure
        $_SESSION["message"] = "Subject deletion failed.";
        redirect_to("manage_content.php?subject={$id}");
    }
?>

