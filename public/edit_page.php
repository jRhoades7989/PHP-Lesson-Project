<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php require_once("../includes/validation_functions.php"); ?> <!--Include validation functions-->
<?php find_selected_page(); ?> <!--This finds what we are editing-->

<?php 
    if (isset($_POST["submit"])) {
        //Form was submitted

        //Retrieve form data

        $required_fields = array("menu_name", "position", "visible", "content");
        validate_presences($required_fields);

        $fields_with_max_lengths = array("menu_name"=>30);
        validate_max_lengths($fields_with_max_lengths);



        if(empty($errors)) {
        
            //Perform update

            $id = $current_page["id"];
            $menu_name = mysql_prep($_POST["menu_name"]);
            $position = (int) $_POST["position"];
            $visible = (int) $_POST["visible"];
            $content = mysql_prep($_POST["content"]);

            $query  = "UPDATE pages SET";
            $query .= " menu_name = '{$menu_name}',";
            $query .= " position = {$position},";
            $query .= " content = '{$content}',";
            $query .= " visible = {$visible}";
            $query .= " WHERE id = {$id}";
            $query .= " LIMIT 1";
            
            //Check if query succeeded
            $result = mysqli_query($connection, $query);

            if ($result && mysqli_affected_rows($connection) >= 0) {
                //success
                $_SESSION["message"] = "Edited Succesfully.";
                $id = htmlentities($id);
                redirect_to("manage_content.php?page={$id}");
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
    if (!$current_page) {
        //page ID was missing or invalid or
        //page couldn't be found in the database
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
            <h2>Edit Page: <?php echo htmlentities($current_page["menu_name"]); ?></h2>

            <!--This is a form to edit a page-->
            <form action = "edit_page.php?page=<?php echo urlencode($current_page["id"]);?>" method = "post">

                <!--Sets the name of the current page-->
                <label for = "menu_name">Menu name:</label>
                <input id = "menu_name" type = "text" name = "menu_name" value = "<?php echo htmlentities($current_page["menu_name"]); ?>"/>

                <!--Sets position of current page-->
                <label for = "position">Position:</label>
                <select id = "position" name = "position">
                    <?php 
                        $page_set = find_pages_for_subject($current_page["subject_id"]);
                        $page_count = mysqli_num_rows($page_set);
                        for($count = 1; $count <= $page_count; $count++) {
                            echo "<option value = \"{$count}\"";
                            if ($current_page["position"] == $count) {
                                echo "selected";
                            }
                            echo ">{$count}</option>";
                        }
                    ?>
                </select>

                <!--Sets the visibility of the current page-->
                <p>Visible: 
                    <input type = "radio" name = "visible" value = "0" <?php if ($current_page["visible"] == 0) {echo "checked";} ?>/> No
                    &nbsp;
                    <input type = "radio" name = "visible" value = "1" <?php if ($current_page["visible"] == 1) {echo "checked";} ?>/> Yes
                </p>
                </br>
                <textarea name = "content">
                    <?php echo htmlentities($current_page["content"]); ?>
                </textarea>
                    

                <!--Submits form-->
                <input type = "submit" name = "submit" value = "Edit Page" />
            </form>

            <br />
            <a href = "manage_content.php">Cancel</a>
            &nbsp;
            &nbsp;
            <a href = "delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure?')">Delete page</a>

        </article>
    </main>

<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->
