<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
<?php require_once("../includes/db_connection.php"); ?> <!--Initiate DB connection-->
<?php require_once("../includes/functions.php"); ?> <!--Include functions-->
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<?php find_selected_page(); ?> <!--This finds what we are editing-->
<nav id = "navigation">
    <?php
        //Navigation takes 2 parameters and returns the list of pages and subjects
        echo navigation($current_subject, $current_page); 
        $_SESSION["subject_id"] = $current_subject["id"];
        ?> <!--Populates the left nav bar-->
    </nav>
    <main id = "page">
        <article>
            <?php echo message(); ?>
            <?php $errors = errors(); ?>
            <?php echo form_errors($errors); ?>
            <h2>Create Subject</h2>
            <!--This is a form to create a new subject-->
            <form action = "create_subject.php" method = "post">
                <!--Sets the name of the new subject-->
                <label for = "menu_name">Menu name:</label>
                <input id = "menu_name" type = "text" name = "menu_name" />
                <label for = "position">Position:</label>
                <select id = "position" name = "position">
                    <?php 
                        $subject_set = find_all_subjects();
                        $subject_count = mysqli_num_rows($subject_set);
                        for($count = 1; $count <= ($subject_count + 1); $count++) {
                            echo "<option value = \"{$count}\">{$count}</option>";
                        }
                    ?>
                </select>
                <p>Visible: <!--Sets the visibility of the new subject-->
                    <input type = "radio" name = "visible" value = "0" /> No
                    &nbsp;
                    <input type = "radio" name = "visible" value = "1" /> Yes
                </p>
                <input type = "submit" name = "submit" value = "Create Subject" />
            </form>

            <br />
            <a href = "manage_content.php">Cancel</a>

        </article>
    </main>
<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->


