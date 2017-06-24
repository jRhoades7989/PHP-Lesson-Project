<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php require_once("../includes/validation_functions.php"); ?> <!--Include validation functions-->
<?php find_selected_page(); ?> <!--This finds what we are editing-->

<?php 
    if (isset($_POST["submit"])) {
        //Form was submitted

        //Retrieve form data

        $required_fields = array("menu_name", "position", "visible");
        validate_presences($required_fields);

        $fields_with_max_lengths = array("menu_name"=>30);
        validate_max_lengths($fields_with_max_lengths);



        if(empty($errors)) {
        
            //Perform update

            $id = $current_subject["id"];
            $menu_name = mysql_prep($_POST["menu_name"]);
            $position = (int) $_POST["position"];
            $visible = (int) $_POST["visible"];

            $query  = "UPDATE subjects SET";
            $query .= " menu_name = '{$menu_name}',";
            $query .= " position = {$position},";
            $query .= " visible = {$visible}";
            $query .= " WHERE id = {$id}";
            $query .= " LIMIT 1";
            
            //Check if query succeeded
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_affected_rows($connection) == 1) {
                //success
                $_SESSION["message"] = "Edited Succesfully.";
                redirect_to("manage_content.php");
            } else {
                //failure
                $message = "Edit failed.";
            }
        }
    } else {
        //This is probably a GET request
    } //end: if (isset($_POST["submit"]))
?>
<?php 
    if (!$current_subject) {
        //subject ID was missing or invalid or
        //subject couldn't be found in the database
        redirect_to("manage_content.php");
    }
?>
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<nav id = "navigation">
    <?php
        //Navigation takes 2 parameters and returns the list of pages and subjects
        echo navigation($current_subject, $current_page); ?> <!--Populates the left nav bar-->
    </nav>
    <main id = "page">
        <article>
            <?php 
                if(!empty($message)) { 
                    echo "<div class=\"message\">" . htmlentities($message) . "</div>";
                }
            ?>
            <?php echo form_errors($errors); ?>
            <h2>Edit Subject: <?php echo htmlentities($current_subject["menu_name"]); ?></h2>

            <!--This is a form to edit a subject-->
            <form action = "edit_subject.php?subject=<?php echo urlencode($current_subject["id"]);?>" method = "post">

                <!--Sets the name of the current subject-->
                <label for = "menu_name">Menu name:</label>
                <input id = "menu_name" type = "text" name = "menu_name" value = "<?php echo htmlentities($current_subject["menu_name"]); ?>"/>

                <!--Sets position of current subject-->
                <label for = "position">Position:</label>
                <select id = "position" name = "position">
                    <?php 
                        $subject_set = find_all_subjects();
                        $subject_count = mysqli_num_rows($subject_set);
                        for($count = 1; $count <= $subject_count; $count++) {
                            echo "<option value = \"{$count}\"";
                            if ($current_subject["position"] == $count) {
                                echo "selected";
                            }
                            echo ">{$count}</option>";
                        }
                    ?>
                </select>

                <!--Sets the visibility of the current subject-->
                <p>Visible: 
                    <input type = "radio" name = "visible" value = "0" <?php if ($current_subject["visible"] == 0) {echo "checked";} ?>/> No
                    &nbsp;
                    <input type = "radio" name = "visible" value = "1" <?php if ($current_subject["visible"] == 1) {echo "checked";} ?>/> Yes
                </p>

                <!--Submits form-->
                <input type = "submit" name = "submit" value = "Edit Subject" />
            </form>

            <br />
            <a href = "manage_content.php">Cancel</a>
            &nbsp;
            &nbsp;
            <a href = "delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure?')">Delete subject</a>

        </article>
    </main>
<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->


