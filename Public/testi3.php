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
	$rules[] = "required,etunimi,Syötä etunimi.";
	$rules[] = "letters_only,etunimi,Vain kirjaimia nimessä.";
	$rules[] = "required,sukunimi,Syötä sukunimi.";
	$rules[] = "letters_only,sukunimi,Vain kirjaimia nimessä.";
	$rules[] = "required,luokka,Syötä luokkatunnus.";
	$rules[] = "letters_digits_only,luokka,Vain kirjaimia ja numeroita luokkatunnuksessa.";
	$rules[] = "required,email, Syötä sähköpostiosoite.";
	$rules[] = "valid_email,email,Syötä @kamk.fi sähköpostiosoite.";
	$rules[] = "digits_only,puhelin,Syötä puhelinnumero ilman erikoismerkkejä.";
	$rules[] = "required,otsikko,Anna viestillesi otsikko.";
	$rules[] = "letters_digits_only,otsikko,Vain kirjaimia ja numeroita otsikossa.";
	$rules[] = "required,viesti,Kerro meille huolesi viestikenttään.";
	
	$rules[] = "required,tag,Valitse pyyntöösi sopiva tag.";
	
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

$servername="192.168.206.159";
$username="webuser";
$password="Passw0rd";
$dbname="DCSS";

/*Muodosta yhteys*/
$yhteys = mysqli_connect($servername, $username, $password, $dbname);

/*Testaa yhteys*/
if (!$yhteys) {
	die("Yhteys epäonnistui: " . mysqli_connect_error());
}
echo "Yhteys onnistui. ";

$sql="INSERT INTO `Tiketit`(`Etunimi`, `Sukunimi`, `Luokka`, `Email`, `PuhNro`, `Otsikko`, `Viesti`, `Tag`)
VALUES ('$etunimi', '$sukunimi', '$luokka', '$email', '$puhelin', '$otsikko', '$viesti', '$tag')";
if(mysqli_query($yhteys, $sql)) {
	echo "Tiedot tallennettu onnistuneesti.";
} else {
		echo "Virhe: tietojen tallennus epäonnistui." .
		mysqli_error($yhteys);
}

mysqli_close($yhteys);
}
}

if(!isset($fields["etunimi"])) $fields["etunimi"] = "";
if(!isset($fields["sukunimi"])) $fields["sukunimi"] = "";
if(!isset($fields["luokka"])) $fields["luokka"] = "";
if(!isset($fields["email"])) $fields["email"] = "";
if(!isset($fields["puhelin"])) $fields["puhelin"] = "";
if(!isset($fields["otsikko"])) $fields["otsikko"] = "";
if(!isset($fields["viesti"])) $fields["viesti"] = "";
if(!isset($fields["tag"])) $fields["tag"] = "";

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
	echo "<div class='error' style='width:100%;'>Korjaa väärin syötetyt tiedot:\n<ul>";
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
	<td>Ryhmä:<span class="error"> *</span></td>
	  <td><input type="text" name="luokka" value="<?=$fields['luokka']?>" placeholder="Ryhmätunnus" /></td>
	</tr>
	<tr>
	<td>Email:<span class="error"> *</span></td>
	  <td><input type="text" name="email" value="<?=$fields['email']?>" placeholder="Email" /></td>
	</tr>
	<tr>
	<td>Puhelin:</td>
	  <td><input type="text" name="puhelin" value="<?=$fields['puhelin']?>" placeholder="0102345678" /></td>
	</tr>
	<tr>
	<td>Otsikko:<span class="error"> *</span></td>
	  <td><input type="text" name="otsikko" value="<?=$fields['otsikko']?>" placeholder="Otsikko" /></td>
	</tr>
	<tr>
	<td>Viesti:<span class="error"> *</span></td>
	  <td><textarea name="viesti" rows="5" cols="40" maxlength="200" placeholder="Lyhyt kuvaus tehtävästä (max 200 merkkiä)" /><?php if(isset($_POST['viesti'])) {echo $_POST['viesti'];} ?></textarea></td>
	</tr>
	<tr>
	<td>Tag:<span class="error"> *</span></td>
	  <td>
	    <input type="radio" name="tag" value="peliserveri" <?php if($fields['tag'] == 'peliserveri') echo 'checked'; ?> />Peliserveri
	      <input type="radio" name="tag" value="nettisivu" <?php if($fields['tag'] == 'nettisivu') echo 'checked'; ?> />Nettisivu
	  </td>
	</tr>
	</table>

	<p><input type="submit" name="submit" value="Lähetä" /></p>
    </td>
  </tr>
</table>  
</form>
</body>
</html>
