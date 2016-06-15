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
		while (preg_match("/^if:/", "", $row[0])
		
		// check if it's a = or != test
		$comparison = "equal";
		$parts = array(;
		if (preg_match("/!=!", $condition))
		{
			$parts = explode("!=", $condition);
			$comparison = "not_equal";
		}
		else
			$parts = explode("=", $condition);
		
		$field_to_check = $parts[0];
		$value_to_check = $parts[1];
		
		// if the VALUE is NOT the same, we don't need to validate this field. Return.
		if ($comparison == "equal" && $fields[$field_to_check] != $value_to_check)
		{
			$satisfies_if_conditions = false;
			break;
		}
		else if ($comparison == "not equal" && $fields[$field_to_check] == $value_to_check)
		{
			$satisfies_if_conditions = false;
			break;
		}
		else
			array_shift($row);	// remove this if-condition from line, and continue validating line
	}
	
	if (!$satisfies_if_conditions)
		continue;
	
	$requirement = $ row[0];
	$field_name = $row[1];
	
	// depending on validation test, store strings for later use
	if (count($row) == 6)
	{
      $field_name2   = $row[2];
      $field_name3   = $row[3];
      $date_flag     = $row[4];
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


    // if the requirement is "length=...", rename requirement to "length" for switch statement
    if (preg_match("/^length/", $requirement))
    {
      $length_requirements = $requirement;
      $requirement         = "length";
    }

    // if the requirement is "range=...", rename requirement to "range" for switch statement
    if (preg_match("/^range/", $requirement))
    {
      $range_requirements = $requirement;
      $requirement        = "range";
    }


    // now, validate whatever is required of the field
    switch ($requirement)
    {
      case "required":
        if (!isset($fields[$field_name]) || $fields[$field_name] == "")
          $errors[] = $error_message;
        break;

      case "digits_only":       
        if (isset($fields[$field_name]) && preg_match("/\D/", $fields[$field_name]))
          $errors[] = $error_message;
        break;

      case "letters_only": 
        if (isset($fields[$field_name]) && preg_match("/[^a-zA-Z]/", $fields[$field_name]))
          $errors[] = $error_message;
        break;

      // doesn't fail if field is empty
      case "valid_email":
				$regexp="/^[a-z0-9]+([_+\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";    
        if (isset($fields[$field_name]) && !empty($fields[$field_name]) && !preg_match($regexp, $fields[$field_name]))
          $errors[] = $error_message;
        break;

      case "length":
        $comparison_rule = "";
        $rule_string     = "";

        if      (preg_match("/length=/", $length_requirements))
        {
          $comparison_rule = "equal";
          $rule_string = preg_replace("/length=/", "", $length_requirements);
        }
        else if (preg_match("/length>=/", $length_requirements))
        {
          $comparison_rule = "greater_than_or_equal";
          $rule_string = preg_replace("/length>=/", "", $length_requirements);
        }
        else if (preg_match("/length<=/", $length_requirements))
        {
          $comparison_rule = "less_than_or_equal";
          $rule_string = preg_replace("/length<=/", "", $length_requirements);
        }
        else if (preg_match("/length>/", $length_requirements))
        {
          $comparison_rule = "greater_than";
          $rule_string = preg_replace("/length>/", "", $length_requirements);
        }
        else if (preg_match("/length</", $length_requirements))
        {
          $comparison_rule = "less_than";
          $rule_string = preg_replace("/length</", "", $length_requirements);
        }

        switch ($comparison_rule)
        {
          case "greater_than_or_equal":
            if (!(strlen($fields[$field_name]) >= $rule_string))
              $errors[] = $error_message;
            break;
          case "less_than_or_equal":
            if (!(strlen($fields[$field_name]) <= $rule_string))
              $errors[] = $error_message;
            break;
          case "greater_than":
            if (!(strlen($fields[$field_name]) > $rule_string))
              $errors[] = $error_message;
            break;
          case "less_than":
            if (!(strlen($fields[$field_name]) < $rule_string))
              $errors[] = $error_message;
            break;
          case "equal":
            // if the user supplied two length fields, make sure the field is within that range
            if (preg_match("/-/", $rule_string))
            {
              list($start, $end) = explode("-", $rule_string);
              if (strlen($fields[$field_name]) < $start || strlen($fields[$field_name]) > $end)
                $errors[] = $error_message;
            }
            // otherwise, check it's EXACTLY the size the user specified 
            else
            {
              if (strlen($fields[$field_name]) != $rule_string)
                $errors[] = $error_message;
            }     
            break;       
        }
        break;

      case "range":
        $comparison_rule = "";
        $rule_string     = "";

        if      (preg_match("/range=/", $range_requirements))
        {
          $comparison_rule = "equal";
          $rule_string = preg_replace("/range=/", "", $range_requirements);
        }
        else if (preg_match("/range>=/", $range_requirements))
        {
          $comparison_rule = "greater_than_or_equal";
          $rule_string = preg_replace("/range>=/", "", $range_requirements);
        }
        else if (preg_match("/range<=/", $range_requirements))
        {
          $comparison_rule = "less_than_or_equal";
          $rule_string = preg_replace("/range<=/", "", $range_requirements);
        }
        else if (preg_match("/range>/", $range_requirements))
        {
          $comparison_rule = "greater_than";
          $rule_string = preg_replace("/range>/", "", $range_requirements);
        }
        else if (preg_match("/range</", $range_requirements))
        {
          $comparison_rule = "less_than";
          $rule_string = preg_replace("/range</", "", $range_requirements);
        }
        
        switch ($comparison_rule)
        {
          case "greater_than":
            if (!($fields[$field_name] > $rule_string))
              $errors[] = $error_message;
            break;
          case "less_than":
            if (!($fields[$field_name] < $rule_string))
              $errors[] = $error_message;
            break;
          case "greater_than_or_equal":
            if (!($fields[$field_name] >= $rule_string))
              $errors[] = $error_message;
            break;
          case "less_than_or_equal":
            if (!($fields[$field_name] <= $rule_string))
              $errors[] = $error_message;
            break;
          case "equal":
            list($start, $end) = explode("-", $rule_string);

            if (($fields[$field_name] < $start) || ($fields[$field_name] > $end))
              $errors[] = $error_message;
            break;
        }
        break;
        
      case "same_as":
        if ($fields[$field_name] != $fields[$field_name2])
          $errors[] = $error_message;
        break;
	}
  }
  
  return $errors;
}
?>
