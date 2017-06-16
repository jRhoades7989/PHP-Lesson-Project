<?php
// This function redirects the page to a new location
   function redirect_to($new_location) {
        header("Location: " . $new_location); 
        exit;
   }

    function mysql_prep($string) {
        global $connection;
        
        $escaped_string = mysqli_real_escape_string($connection, $string); 
        return $escaped_string;
    }
// Set a default form value
   function default_form_val($value) {
           isset($_POST[$value]) ? $value = $_POST[$value] : $value = "";
           return $value;
   }


   
   //DISPLAY CONNECTION ERRORS
   function confirm_query($result_set) {
      if (!$result_set) {
         die("Database query failed");
      }
   }

   //+++++++++++++++++++++++++DB QUERIES+++++++++++++++++++++++++++++++++++//
   //
   //QUERY SUBJECTS AND RETURN THEM AS AN ARRAY
   function find_all_subjects() {
        global $connection;
        $query = "select * ";
        $query .= "from subjects ";
        $query .= "where visible=1 ";
        $query .= "order by position asc";
        $subject_set = mysqli_query($connection, $query);
        confirm_query($subject_set);
        return $subject_set;
   }
    
    //QUERY PAGES AND RETURN THEM AS AN ARRAY
   function find_pages_for_subject($subject_id) {
        global $connection;
        $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE visible=1 ";
        $query .= "AND subject_id = {$safe_subject_id} ";
        $query .= "ORDER BY position ASC";
        $page_set= mysqli_query($connection, $query);
        confirm_query($page_set);
        return $page_set;
   } 


   //==========================DISPLAY ERRORS===============================//
   //
   //DISPLAY INPUT FORM ERRORS
   function form_errors($errors=[]) {
        $output = "";
        if(!empty($errors)) {
            $output .= "<div class = \"error\">";
            $output .= "Please fix the following errors: ";
            $output .= "<ul>";
            foreach ($errors as $key => $error) {
               $output .= "<li>{$error}</li>";
        }
            $output .= "</ul>";
            $output .= "</div>";
      }
      return $output;
   }
    //===============================Navigation===============================//
   //Make the selected page/subject bold in the navbar
   //Navigation takes 2 parameters and returns the list of pages and subjects

   function navigation($subject_array, $page_array) {
      $output = "<ul class = \"subjects\">"; //Starts an unordered list for subjects/pages

      $subject_set = find_all_subjects(); //Returns all subjects in an array

    //This loop runs while there are still subjects in the $subject_set array
    //It will return a list item for each subject
      while($subject = mysqli_fetch_assoc($subject_set)) {  
         $output .= "<li";
         if ($subject_array && $subject["id"] == $subject_array["id"]) {
         $output .= " class = \"selected\"";
         }
         $output .= " >"; 
         $output .= "<a href = \"manage_content.php?subject=";
         $output .= urlencode($subject["id"]);
         $output .= "\" >";
         $output .= $subject["menu_name"]; 
         $output .= "</a>";

         $page_set = find_pages_for_subject($subject["id"]); 
         $output .= "<ul class = \"pages\">";

         //This loop runs while there are still pages in the $page_set array
         //It will return a sublist of pages for each subject
         while($page = mysqli_fetch_assoc($page_set)) {
            $output .= "<li";
            if ($page_array && $page["id"] == $page_array["id"]) {
               $output .= " class = \"selected\"";
         }
            $output .= " >"; 
            $output .= "<a href = \"manage_content.php?page=";
            $output .= urlencode($page["id"]);
            $output .= "\" >";
            $output .= $page["menu_name"];
            $output .= "</a></li>";
         }
         $output .= "</ul>";
         mysqli_free_result($page_set); //Lets go of an uneeded variable 
         $output .= "</li>";
         }
      $output .= "</ul>";
      return $output; //Returns the completed list of subjects and pages
                        //with the currently selected page/subject in bold
   }


    //If there is a selected subject, this will return the subject name
   function find_subject_by_id($subject_id) {
        global $connection;
      
        $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
        $query = "SELECT * ";
        $query .= "FROM subjects ";
        $query .= "WHERE id = {$safe_subject_id} ";
        $query .= "LIMIT 1 ";
        $subject_set= mysqli_query($connection, $query);
        confirm_query($subject_set);  //Makes sure there's not an issue with the query
        //This if statement either returns the selected subject, or null if there is none
        if($subject = mysqli_fetch_assoc($subject_set)) { 
            return $subject;
            } else {
            return null;
        }
   }

    //If there is a selected page, this will return the page name
    function find_page_by_id($page_id) {
        global $connection;
      
        $safe_page_id = mysqli_real_escape_string($connection, $page_id);
        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE id = {$safe_page_id} ";
        $query .= "LIMIT 1 ";
        $page_set = mysqli_query($connection, $query);
        confirm_query($page_set);
        //This if statement either returns the selected page, or null if there is none
        if($page = mysqli_fetch_assoc($page_set)) {
            return $page;
            } else {
            return null;
        }
   }
   

    //This will set what the current item is, and whether or not it's a page or a subject 
    function find_selected_page () {
        global $current_subject;
        global $current_page;

        //This if statement will return subject and null if subject is set
        if (isset($_GET["subject"])) {
            $current_subject = find_subject_by_id($_GET["subject"]);
            $current_page = null;
        
        //This option will return page and null if page is set
        } elseif (isset($_GET["page"])) {
            $current_page = find_page_by_id($_GET["page"]);

        //If neither are set, This option will retunr null and null
        } else {
            $current_subject = null;
            $current_page = null;
        }
    }
?>


