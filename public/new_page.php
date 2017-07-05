<?php require_once("../includes/sessions.php"); ?> <!--Initiate session-->
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
        $content = mysql_prep($_POST["content"]);
        $current_subject_id = current_subject_id();

        $required_fields = array("menu_name", "position", "visible", "content");
        validate_presences($required_fields);

        $fields_with_max_lengths = array("menu_name" => 30);
        validate_max_lengths($fields_with_max_lengths);

        if(!empty($errors)) {
            $_SESSION["errors"] = $errors;
            redirect_to("new_page.php?subject={$current_subject_id}");
        }
        //Make the query
        $query  = "INSERT INTO pages (";
        $query .= " subject_id, menu_name, position, visible, content";
        $query .= ") VALUES (";
        $query .= "{$current_subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'";
        $query .= ")";
        
        //Check if query succeeded
        $result = mysqli_query($connection, $query);

        if ($result) {
            //success
            $_SESSION["message"] = "Page created.";

            //query for new page id
            $page_query  = "SELECT id FROM pages WHERE ";
            $page_query .= "subject_id={$current_subject_id} ";
            $page_query .= "ORDER BY id DESC LIMIT 1";

            $page_result = mysqli_query($connection, $page_query);
            
            if($page_result) {
                $new_page = mysqli_fetch_assoc($page_result);
                $new_page_id = urlencode($new_page["id"]);
                redirect_to("manage_content.php?page={$new_page_id}");
            } else {
                $_SESSION["message"] = "Something went wonky. Try again?";
                redirect_to("new_page.php?subject={$current_subject_id}");
            }
        } else {
            //failure
            $_SESSION["message"] = "Page creation failed.";
            redirect_to("new_page.php?subject={$current_subject_id}");
        }
    } else {
        //This is probably a GET request
    }
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?> <!--Page Header-->
<?php find_selected_page(); ?> <!--This finds what we are editing-->
<nav id = "navigation">
    <?php
        //Navigation takes 2 parameters and returns the list of pages and pages
        echo navigation($current_subject, $current_page); ?> <!--Populates the left nav bar-->
    </nav>
    <main id = "page">
        <article>
            <?php 
                $current_subject_id = $current_subject["id"];
                $_SESSION["subject_id"] = $current_subject_id ?>
            <?php echo message(); ?>
            <?php $errors = errors(); ?>
            <?php echo form_errors($errors); ?>
            <h2>Create Page</h2>
            <!--This is a form to create a new page-->
            <form action = "new_page.php?subject=<?php echo $current_subject_id;?>" method = "post">
                <!--Sets the name of the new page-->
                <label for = "menu_name">Menu name:</label>
                <input id = "menu_name" type = "text" name = "menu_name" />
                <label for = "position">Position:</label>
                <select id = "position" name = "position">
                    <?php 
                        $page_set = find_pages_for_subject($current_subject["id"]);
                        $page_count = mysqli_num_rows($page_set);
                        for($count = 1; $count <= ($page_count + 1); $count++) {
                            echo "<option value = \"{$count}\">{$count}</option>";
                        }
                    ?>
                </select>
                <p>Visible: <!--Sets the visibility of the new page-->
                    <input type = "radio" name = "visible" value = "0" /> No
                    &nbsp;
                    <input type = "radio" name = "visible" value = "1" /> Yes
                </p>
                <label for = "content">Content</label>
                <textarea name = "content" id = "content">
                </textarea>
                <input type = "submit" name = "submit" value = "Create Page" />
            </form>

            <br />
            <a href = "manage_content.php?subject=<?php echo $current_subject_id;?>">Cancel</a>

        </article>
    </main>
<?php include("../includes/layouts/footer.php"); ?> <!--Page Footer-->
