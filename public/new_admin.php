<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php require_once("../includes/validation_functions.php"); ?> <!--Include validation functions-->
<?php 

    if (isset($_POST["submit"])) {
        //Form was submitted

        //Retrieve form data
        $errors = [];
        $username = mysql_prep($_POST["username"]);
        $password = mysql_prep($_POST["password"]);

        $required_fields = array("username", "password");
        validate_presences($required_fields);

        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            redirect_to("new_admin.php");
        }
        //Make the query
        $query  = "INSERT INTO admins (";
        $query .= "username, hashed_password";
        $query .= ") VALUES (";
        $query .= "'{$username}', '{$password}'";
        $query .= ")";
        
        //Check if query succeeded
        $result = mysqli_query($connection, $query);

        if ($result) {
            //success
            $_SESSION["message"] = "Admin created.";
            redirect_to("manage_admins.php");
        } else {
            //failure
            $_SESSION["message"] = "Admin creation failed.";
            redirect_to("new_admin.php");
        }
    } else {
        //This is probably a GET request
    }
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<nav id="navigation" class="group">
    <br />
    <a href="manage_admins.php">&laquo; Admins</a>
</nav>
<main id = "page">
    <article>
        <?php echo message(); ?>
        <?php $errors = errors(); ?>
        <?php echo form_errors($errors); ?>
        <h2>New Admin</h2>
        <form action="new_admin.php" method="post">
            <label for="username">Username: </label>
            <input name="username" id="username" type="text">
            <label for="password">Password: </label>
            <input name="password" id="password" type="password">
            <input type="submit" name="submit" id="submit" value="Submit">
        </form>
        </br>
        <a href="manage_admins.php">Cancel</a>
    </article>
</main>

<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->
