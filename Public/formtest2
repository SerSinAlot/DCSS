<?php

session_start();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<title>Contact Form</title> 
</head>

<body>

<?php

if(isset($_SESSION['formtoemail_form_errors'])) 
{

print "<div style=\"color:#ff0000\">";

foreach($_SESSION['formtoemail_form_errors'] as $form_error_value){print "<b>" . stripslashes($form_error_value) . "</b><br>";}

print "</div>";

unset($_SESSION['formtoemail_form_errors']);

}

if(isset($_SESSION['submitted_form_values'])){extract($_SESSION['submitted_form_values']);}

?>

<form action="formtoemailpro.php" method="post"> 
<table border="0" style="background:#ececec" cellspacing="5"> 
<tr><td>Name</td><td><input type="text" size="30" name="name" value="<?php if(isset($name)){print stripslashes($name);}else{print "";} ?>"></td></tr> 
<tr><td>Email</td><td><input type="text" size="30" name="email" value="<?php if(isset($email)){print stripslashes($email);}else{print "";} ?>"></td></tr> 
<tr><td valign="top">Comments</td><td><textarea name="comments" rows="6" cols="30"><?php if(isset($comments)){print stripslashes($comments);} ?></textarea></td></tr> 
<tr><td> </td><td><input type="submit" value="Send"></td></tr> 
</table> 
</form>

</body> 
</html>

<?php

if(isset($_SESSION['submitted_form_values'])){unset($_SESSION['submitted_form_values']);}

?>
