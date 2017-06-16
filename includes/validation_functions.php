<?php
   
   $errors = array();
  
    function field_name_as_text($fieldname) {
        $fieldname = str_replace("_", " ", $fieldname);
        $fieldname = ucfirst($fieldname);
        return $fieldname;
    }
   //======================= VALIDATION FUNCTIONS =============================//
   //
   //CHECK PRESENCE
   function has_presence($value) {           //$value is str
      return isset($value) && $value !== "";
   }

function validate_presences($required_fields)  {
    global $errors;
    foreach($required_fields as $field) {
        $value = trim($_POST[$field]);
        if (!has_presence($value)) {
            $errors[$field] = field_name_as_text($field) . " can't be blank";
        }
    }
}
   //CHECK LENGTH
   function has_max_length($value, $max) {   //$value is str, $max is num
      return strlen($value) <= $max;
   }

   function validate_max_lengths($fields_with_max_lengths) {
        global $errors;
        //Expects an associative array
        foreach($fields_with_max_lengths as $field => $max) {
            $vaule = trim($_POST[$field]);
            if (!has_max_length($value,$max)) {
                $errors[$field] = field_name_as_text($field) . " is too long";
            }
        }
   }

   function has_min_length($value, $min) {   //$value is str, $min is num
      return strlen($value) >= $min;
   }

   //CHECK SET INCLUSION
   function has_inclusion_in($value, $set) {
      return in_array($value, $set);
   }



   ?>
