<?php
$errors = array();
$fields = array();
$success_message = "";

if (isset($_POST['submit']))
{
	// import validation lib
	require_once("validation.php");
	
	$rules = array(); // stores validation rules
	
	// form fields
	$rules[] = "required,etunimi,Enter first name.";
	$rules[] = "letters_only,etunimi,Only letters in first name.";
	$rules[] = "required,sukunimi,Enter last name.";
	$rules[] = "letters_only,sukunimi,Only letters in last name.";
	$rules[] = "required,luokka,Enter class code.";
	$rules[] = "letters_digits_only,luokka,Only letters and numbers in class code.";
	$rules[] = "required,email, Enter email.";
	$rules[] = "valid_email,email,Enter a valid @kamk.fi email address.";
	$rules[] = "digits_only,puhelin,Only numbers in phone number.";
	$rules[] = "required,otsikko,Give an appropriate heading for your request.";
	$rules[] = "letters_digits_only,otsikko,Only letters and numbers in heading.";
	$rules[] = "required,viesti,Tell us your troubles in the message field.";
	$rules[] = "textbox,viesti,Only letters, numbers and approved special characters in the message field.";	
	$rules[] = "required,tag,Choose an appropriate tag for your request.";
	$rules[] = "captcha,captcha,Are you by any chance a robot?";
	
	$errors = validateFields($_POST, $rules);
	
	//if errors, repopulate fields
	if (!empty($errors))
	{
		$fields = $_POST;
	}
	
	// no errors!
	else
	{
		$message = "Your request has been sent successfully.";
		
$servername="192.168.206.159";
$username="webuser";
$password="Passw0rd";
$dbname="DCSS";

/*Muodosta yhteys*/
$yhteys = mysqli_connect($servername, $username, $password, $dbname);

/*Testaa yhteys*/
if (!$yhteys) {
	die("Connection failed: " . mysqli_connect_error());
}
echo "Connection successful. ";

$etunimi=mysqli_real_escape_string($yhteys, $_POST['etunimi']);
$sukunimi=mysqli_real_escape_string($yhteys, $_POST['sukunimi']);
$luokka=mysqli_real_escape_string($yhteys, $_POST['luokka']);
$email=mysqli_real_escape_string($yhteys, $_POST['email']);
$puhelin=mysqli_real_escape_string($yhteys, $_POST['puhelin']);
$otsikko=mysqli_real_escape_string($yhteys, $_POST['otsikko']);
$viesti=mysqli_real_escape_string($yhteys, $_POST['viesti']);
$tag=mysqli_real_escape_string($yhteys, $_POST['tag']);

$sql="INSERT INTO `Tiketit`(`Etunimi`, `Sukunimi`, `Luokka`, `Email`, `PuhNro`, `Otsikko`, `Viesti`, `Tag`)
VALUES ('$etunimi', '$sukunimi', '$luokka', '$email', '$puhelin', '$otsikko', '$viesti', '$tag')";

if(mysqli_query($yhteys, $sql)) 
{
	$success = "Your request has been sent successfully.";
	echo $success;
} 
else 
{
	echo "Error: you already have an open ticket in our system.";
	$fields = $_POST;
}

mysqli_close($yhteys);
}
$subject = 'Thank you for contacting us!';
$message = 'This is an automated response. Please do not send any email to this address. Thank you!

Our capable and enthusiastic community will handle your request as soon as we can. Remember that we can not fulfill all your hopes and dreams :)

Best regards
Data center students';

//mail($email, $subject, $message);
}

if(!isset($fields["etunimi"])) $fields["etunimi"] = "";
if(!isset($fields["sukunimi"])) $fields["sukunimi"] = "";
if(!isset($fields["luokka"])) $fields["luokka"] = "";
if(!isset($fields["email"])) $fields["email"] = "";
if(!isset($fields["puhelin"])) $fields["puhelin"] = "";
if(!isset($fields["otsikko"])) $fields["otsikko"] = "";
if(!isset($fields["viesti"])) $fields["viesti"] = "";
if(!isset($fields["tag"])) $fields["tag"] = "";

function dcssen($data)
{
	$data=trim($data);
	$data=stripcslashes($data);
	$data=htmlspecialchars($data);
	return $data;
}
?>

<!DOCTYPE HTML>
<html>
  <head>
   <meta content="text/html; charset=utf-8"></meta>
   <link rel="stylesheet" type="text/css" href="style.css">
    <title>DCSS</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
<body>

<table cellspacing="0" width="600" align="center">
<tr>
  <td>
<a class="link" href="dcss.php">Suomeksi</a>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" accept-charset="utf-8">

    <p class="title"><font size="20">Data Center Support System</font></p>
    <p>Welcome to our support system. Fill in at least the required fields and send your request to us. Please remember that we won't do any assignments which are meant for KamIT. Thank you!</p>
    <p class="error">* required field.</p>

<br />

<?php

//if $errors is not empty, loop through and display each
if (!empty($errors))
{
	echo "<div class='error' style='width:100%;'>Please revise the incorrectly entered information:\n<ul>";
	foreach ($errors as $error)
	   echo "<li>$error</li>\n";		
	 echo "</ul></div>";
}

if (!empty($message))
{
	echo "<div class='notify'>$success_message</div>";
}
?>

	<table class="demotable">
	<tr>
	<td>First name:<span class="error"> *</span></td>
	  <td><input type="text" name="etunimi" value="<?=$fields['etunimi']?>" placeholder="First name" /></td>
	</tr>
	<tr>
	<td>Last name:<span class="error"> *</span>&nbsp;&nbsp;</td>
	  <td><input type="text" name="sukunimi" value="<?=$fields['sukunimi']?>" placeholder="Last name" /></td>
	</tr>
	<tr>
	<td>Class code:<span class="error"> *</span></td>
	  <td><input type="text" name="luokka" value="<?=$fields['luokka']?>" placeholder="Class code" /></td>
	</tr>
	<tr>
	<td>Email:<span class="error"> *</span></td>
	  <td><input type="text" name="email" value="<?=$fields['email']?>" placeholder="Email" /></td>
	</tr>
	<tr>
	<td>Phone number:</td>
	  <td><input type="text" name="puhelin" value="<?=$fields['puhelin']?>" placeholder="0102345678" /></td>
	</tr>
	<tr>
	<td>Heading:<span class="error"> *</span></td>
	  <td><input type="text" name="otsikko" value="<?=$fields['otsikko']?>" placeholder="Heading" /></td>
	</tr>
	<tr>
	<td>Message:<span class="error"> *</span></td>
	  <td><textarea name="viesti" rows="5" cols="40" maxlength="200" placeholder="A short description of the assignment (max 200 characters). Approved special characters -.,!?€&*+." /><?php if(isset($_POST['viesti'])) {if(!isset($success)){echo $_POST['viesti'];}} ?></textarea></td>
	</tr>
	<tr>
	<td>Tag:<span class="error"> *</span></td>
	  <td>
	    <input type="radio" name="tag" value="peliserveri" <?php if($fields['tag'] == 'peliserveri') echo 'checked'; ?> />Game server
	    <input type="radio" name="tag" value="nettisivu" <?php if($fields['tag'] == 'nettisivu') echo 'checked'; ?> />Website
	    <input type="radio" name="tag" value="muu" <?php if($fields['tag'] == 'muu') echo 'checked'; ?> />Other
	  </td>
	</tr>
	<tr>
	<td>
	  <td>
	    <div name="captcha" class="g-recaptcha" data-sitekey="6Le7SyQTAAAAAPjLB_AKZ94yjsNqIEIoTBWhsGkO"></div>
	  </td>
	</td>
	</tr>
	</table>

	<p><input type="submit" name="submit" value="Submit" /></p>
    </td>
  </tr>
</table>  
</form>
</body>
</html>
