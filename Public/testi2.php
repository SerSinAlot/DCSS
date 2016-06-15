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
	$rules[] = "required,etunimi,This field is required.";
	$rules[] = "required,sukunimi,This field is required";
	$rules[] = "valid_email,email,This field is required";
	$rules[] = "required,otsikko,This field is required";
	$rules[] = "required,viesti,This field is required";
	$rules[] = "required,tag,This field is required";
	
	$errors = validateFields($_POST, $rules);
	
	//if errors, repopulate fields
	if (!empty($errors))
	{
		$fields = $_POST;
	}
	
	// no errors! redirect to yhteys.php
	else
	{
		$message = "Tiedot syötetty onnistuneesti";
		header("Location: yhteys.php");
	}
}
?>

<!DOCTYPE HTML>
<html>
  <head>
  <link rel="stylesheet" type="text/css" href="style.css">
    <title>DCSS</title>
  </head>
<body>

<table cellspacing="0" width="600" align="center">
<tr>
  <td>

    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">

    <p class="title"><font size="20">Data Center Support System</font></p>
    <p>Hei, kun metsään huutaa, niin DC vastaa.</p>
    <p class="error">* pakollinen kenttä.</p>

<br />

<?php

//if $errors is not empty, loop through and display each
if (!empty($errors))
{
	echo "<div class'error' style='width:100%;'>Korjaa väärin syötetyt tiedot:\n<ul>";
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
	<td>Etunimi:<span class="error"> *</span></td>
	  <td><input type="text" name="etunimi" value="<?=$fields['etunimi']?>" placeholder="Etunimi" /></td>
	</tr>
	<tr>
	<td>Sukunimi:<span class="error"> *</span></td>
	  <td><input type="text" name="sukunimi" value="<?=$fields['sukunimi']?>" placeholder="Sukunimi" /></td>
	</tr>
	<tr>
	<td>Email:<span class="error"> *</span></td>
	  <td><input type="text" name="email" value="<?=$fields['email']?>" placeholder="Email" /></td>
	</tr>
	<tr>
	<td>Puhelin:</td>
	  <td><span> </span><input type="text" name="puhelin" value="<?=$fields['puhelin']?>" placeholder="0102345678" /></td>
	</tr>
	<tr>
	<td>Otsikko:<span class="error"> *</span></td>
	  <td><input type="text" name="otsikko" value="<?=$fields['otsikko']?>" placeholder="Otsikko" /></td>
	</tr>
	<tr>
	<td>Viesti:<span class="error"> *</span></td>
	  <td><textarea name="viesti" rows="5" cols="40" maxlength="200" value="<?=$fields['viesti']?>" placeholder="Lyhyt kuvaus tehtävästä (max 200 merkkiä)" /></textarea></td>
	</tr>
	<tr>
	<td>Tag:<span class="error"> *</span></td>
	  <td>
	    <input type="radio" name="tag" value="<?php if($fields['tag'] == 'peliserveri') echo 'checked'; ?>" />Peliserveri
	      <input type="radio" name="tag" value="<?php if($fields['tag'] == 'nettisivu') echo 'checked'; ?>" />Nettisivu
	  </td>
	</table>

	<p><input type="submit" name="submit" value="Lähetä" /></p>
    </td>
  </tr>
</table>  
</form>
</body>
</html>
