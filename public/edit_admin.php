<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php require_once("../includes/validation_functions.php"); ?> <!--Include validation functions-->
<?php 
    if (isset($_POST["submit"])) {
        //Form was submitted

        //Retrieve form data

        $required_fields = array("username");
        validate_presences($required_fields);

        if(empty($errors)) {
        
            //Perform update
            $password = $_POST["password"];
            $username = $_POST["username"];
            $id = admin_id();

            $query  = "UPDATE admins SET";
            $query .= " username = '{$username}'";
            if(isset($password)) {
                $query .= ", hashed_password = '{$password}'";
            }
            $query .= " WHERE id = {$id}";
            $query .= " LIMIT 1";
            
            //Check if query succeeded
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_affected_rows($connection) >= 0) {
                //success
                $_SESSION["message"] = "Edited Succesfully.";
                $id = urlencode($id);
                redirect_to("manage_admins.php");
            } else {
                //failure
                $message = "Edit failed. ";
                $message .= $password . ", " . $username . ", " . $id;

            }
        }
    } else {
        //This is probably a GET request
    } //end: if (isset($_POST["submit"]))
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->

<nav id = "navigation">
    <br />
    <a href="manage_admins.php">&laquo; Admins</a>
</nav>
    <main id = "page">
        <article>
            <?php 
                if(!empty($message)) { 
                    echo "<div class=\"message\">" . htmlentities($message) . "</div>";
                }
            ?>
            <?php echo form_errors($errors); ?>
            <h2>Edit Admin: <?php 
                if(isset($_GET["id"])) {
                    $_SESSION["admin_id"] = $_GET["id"];
                    $id = $_GET["id"];
                };
                $current_admin = find_admin_by_id($id); 
                echo htmlentities($current_admin["username"]); 
            ?></h2>
            

            <!--This is a form to edit a page-->
            <form action = "edit_admin.php" method = "post">

                <!--Sets the name of the current page-->
                <label for = "uername">Username: </label>
                <input id = "username" type = "text" name = "username" value = "<?php echo htmlentities($current_admin["username"]); ?>"/>

                <!--Sets a new password. optional-->
                <label for = "password">Password: </label>
                <input id = "password" type = "text" name = "password" value = "<?php echo htmlentities($current_admin["hashed_password"]); ?>"/>

                <!--Submits form-->
                <input type = "submit" name = "submit" value = "Edit Page" />
            </form>

            <br />
            <a href = "manage_admins.php">Cancel</a>
        </article>
    </main>

<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->
