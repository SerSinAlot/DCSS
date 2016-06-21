<?php
function validateFields ($fields, $rules)
{
	$errors = array();
	
	// loop through rules
	for ($i=0; $i<count($rules); $i++)
	{
		// split row into component parts 
		$row = explode(",", $rules[$i]);
		
		// while the row begins with "if:..." test the condition. If true, strip the if:..., part and 
		// continue evaluating the rest of the line. Keep repeating this while the line begins with an 
		// if-condition. If it fails any of the conditions, don't bother validating the rest of the line
		$satisfies_if_conditions = true;
		while (preg_match("/^if:/", $row[0]))
		{
		  $condition = preg_replace("/^if:/", "", $row[0]);
		  // check if it's a = or != test
		  $parts = array();
		  if (preg_match("/!=/", $condition))
		  {
			$parts = explode("!=", $condition);
		  }
		  else
			$parts = explode("=", $condition);
		
		  $field_to_check = $parts[0];
		  $value_to_check = $parts[1];
		}
	
	
		if (!$satisfies_if_conditions)
		continue;
	
		$requirement = $row[0];
		$field_name = $row[1];
	
		// depending on validation test, store strings for later use
		if (count($row) == 6)
		{
	     	  $field_name2   = $row[2];
		  $field_name3   = $row[3];
	     	  $field_name4   = $row[4];
     		  $error_message = $row[5];
		}
    		else if (count($row) == 5)     // reg_exp (WITH flags like g, i, m)
    		{
      		  $field_name2   = $row[2];
	      	  $field_name3   = $row[3];
      		  $error_message = $row[4];
    		}
    		else if (count($row) == 4)     // same_as, custom_alpha, reg_exp (without flags like g, i, m)
    		{
      		  $field_name2   = $row[2];
      		  $error_message = $row[3];
    		}
    		else
      		$error_message = $row[2];    // everything else!

    		// now, validate whatever is required of the field
    		switch ($requirement)
    		{
      		  case "required":
        	   if (!isset($fields[$field_name]) || $fields[$field_name] == "")
          	   $errors[] = $error_message;
        	   break;

      		  case "digits_only":       
        	   if (isset($fields[$field_name]) && preg_match("/[^0-9]/", $fields[$field_name]))
          	   $errors[] = $error_message;
        	   break;

      		  case "letters_only": 
        	   if (isset($fields[$field_name]) && preg_match("/[^a-zA-ZäÄöÖåÅ-]/", $fields[$field_name]))
          	   $errors[] = $error_message;
        	   break;

		  case "letters_digits_only":
		    if (isset($fields[$field_name]) && preg_match("/[^a-zA-ZäÄöÖåÅ0-9]/", $fields[$field_name]))
		    $errors[] = $error_message;
		    break;

      		  // doesn't fail if field is empty
		  case "valid_email":
		   $regexp="/^[a-z0-9]+([_+\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";    
		   if (isset($fields[$field_name]) && !empty($fields[$field_name]) && !preg_match($regexp, $fields[$field_name]))
          	   $errors[] = $error_message;
        	   break;

		  case "textbox":
		    if (isset($fields[$field_name]) && preg_match("/[^a-zA-ZäÄöÖåÅ0-9-.,!?€&*+]/", $fields[$field_name]));
		    $errors[] = $error_message;
		    break;

	       }
	}
  return $errors;
}
?>
