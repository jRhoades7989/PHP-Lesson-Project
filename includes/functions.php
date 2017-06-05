<?php
// This function redirects the page to a new location
   function redirect_to($new_location) {
        header("Location: " . $new_location); 
        exit;
   }

// Set a default form value
   function default_form_val($value) {
           isset($_POST[$value]) ? $value = $_POST[$value] : $value = "";
           return $value;
   }


   //======================= VALIDATION FUNCTIONS =============================//
   //
   //CHECK PRESENCE
   function has_presence($value) {           //$value is str
      return isset($value) && $value !== "";
   }

   //CHECK LENGTH
   function has_max_length($value, $max) {   //$value is str, $max is num
      return strlen($value) <= $max;
   }

   function has_min_length($value, $min) {   //$value is str, $min is num
      return strlen($value) >= $min;
   }

   //CHECK SET INCLUSION
   function has_include_in($value, $set) {
      return in_array($value, $set);
   }

   //==========================DISPLAY ERRORS===============================//
   //
   //DISPLAY FORM ERRORS
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
   
   //DISPLAY CONNECTION ERRORS
   function confirm_query($result_set) {
      if (!$result_set) {
         die("Database query failed");
      }
   }

   //+++++++++++++++++++++++++DB QUERIES+++++++++++++++++++++++++++++++++++//
   //
   //QUERY SUBJECTS
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

    function find_selected_page () {
        global $current_subject;
        global $current_page;
        if (isset($_GET["subject"])) {
            $current_subject = find_subject_by_id($_GET["subject"]);
            $current_page = null;
        } elseif (isset($_GET["page"])) {
            $current_page = find_page_by_id($_GET["page"]);
            $current_subject = null;
        } else {
            $current_subject = null;
            $current_page = null;
        }
    }

    //===============================Navigation===============================//
   //Make the selected page/subject bold in the navbar
   //Navigation takes 2 parameters and returns the list of pages and subjects

   function navigation($subject_array, $page_array) {
      $output = "<ul class = \"subjects\">";

      $subject_set = find_all_subjects();

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
         mysqli_free_result($page_set); 
         $output .= "</li>";
         }
      $output .= "<ul>";
      return $output;
   }

   function find_subject_by_id($subject_id) {
        global $connection;
      
        $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
        $query = "SELECT * ";
        $query .= "FROM subjects ";
        $query .= "WHERE id = {$safe_subject_id} ";
        $query .= "LIMIT 1 ";
        $subject_set= mysqli_query($connection, $query);
        confirm_query($subject_set);
        if($subject = mysqli_fetch_assoc($subject_set)) {
            return $subject;
            } else {
            return null;
        }
   }

    function find_page_by_id($page_id) {
        global $connection;
      
        $safe_page_id = mysqli_real_escape_string($connection, $page_id);
        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE id = {$safe_page_id} ";
        $query .= "LIMIT 1 ";
        $page_set = mysqli_query($connection, $query);
        confirm_query($page_set);
        if($page = mysqli_fetch_assoc($page_set)) {
            return $page;
            } else {
            return null;
        }
   }
   
?>


