<?php 
    session_start();

    function message () {
        if (isset($_SESSION["message"])) {
            $output = "<div class = \"message\">";
            $output .= htmlentities($_SESSION["message"]);
            $output .= "</div>";
            
            //Clear message after use
            $_SESSION["message"] = null;

            return $output;
        }
    }

    function errors() {
        if (isset($_SESSION["errors"])) {
            $errors = ($_SESSION["errors"]);
            
            //Clear message after use
            $_SESSION["errors"] = null;

            return $errors;
        }
    }

    function new_page_id() {
        if (isset($_SESSION["new_page_id"])) {
        $new_page_id = ($_SESSION["new_page_id"]);

        $_SESSION["new_page_id"] = null;

        return $new_page_id;
        }
    }

    function current_subject_id() {
        if (isset($_SESSION["subject_id"])) {
            $current_subject_id = urlencode($_SESSION["subject_id"]);

            $_SESSION["subject_id"] = null;

            return $current_subject_id;
        }
    }

    function admin_id() {
        if(isset($_SESSION["admin_id"])) {
            $admin_id = $_SESSION["admin_id"];

            $_SESSION["admin_id"] = null;

            return $admin_id;
        }
    }
?>
