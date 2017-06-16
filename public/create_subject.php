<?php session_start(); ?>
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php require_once("../includes/validation_functions.php"); ?> <!--Include validation functions-->

<?php 
    if (isset($_POST["submit"])) {
        //Form was submitted

        //Retrieve form data
        $menu_name = mysql_prep($_POST["menu_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];

        $required_fields = array("menu_name", "position", "visible");
        validate_presences($required_fields);

        $fields_with_max_lengths = array("menu_name" => 30);
        validate_max_lengths($fields_with_max_lengths);



        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            redirect_to("new_subject.php");
        }
        //Make the query
        $query = "INSERT INTO subjects (";
        $query .= " menu_name, position, visible";
        $query .= ") VALUES (";
        $query .= " '{$menu_name}', {$position}, {$visible}";
        $query .= ")";
        
        //Check if query succeeded
        $result = mysqli_query($connection, $query);

        if ($result) {
            //success
            $_SESSION["message"] = "Subject created.";
            redirect_to("manage_content.php");
        } else {
            //failure
            $_SESSION["message"] = "Subject creation failed.";
            redirect_to("new_subject.php");
        }
    } else {
        //This is probably a GET request
        redirect_to("new_subject.php");
    }
?>
<?php
   //5. Close database connection
if (isset($connection)) {
   mysqli_close($connection);
}
?>
