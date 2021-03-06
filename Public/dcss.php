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
	$rules[] = "textbox,viesti,Vain kirjaimia ja numeroita sekä sallittuja erikoismerkkejä viestikenttään.";	
	$rules[] = "required,tag,Valitse pyyntöösi sopiva tag.";
	$rules[] = "captcha,captcha,Oletko kenties robotti?";
	
	$errors = validateFields($_POST, $rules);
	
	//if errors, repopulate fields
	if (!empty($errors))
	{
		$fields = $_POST;
	}
	
	// no errors!
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
	$success = "Tiedot tallennettu onnistuneesti.";
	echo $success;
} 
else 
{
	echo "Virhe: sinun sähköpostiosoitteellasi on olemassa avoin tiketti.";
	$fields = $_POST;
}

mysqli_close($yhteys);
}
$subject = 'Kiitos yhteydenotosta!';
$message = 'Tämä on automaattinen vastausviesti, ethän lähetä sähköpostia tähän osoitteeseen. Kiitos!

Osaava ja innokas yhteisömme ottaa tehtävän hoidettavakseen, kunhan kiireiltään ehtii. Muistathan ettemme voi kaikkia toiveitanne toteuttaa :)

Terveisin
Datacenter -opiskelijat';

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

function dcss($data)
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
<a class="link" href="dcssen.php">In English</a>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" accept-charset="utf-8">

    <p class="title"><font size="20">Data Center Support System</font></p>
    <p class="titletext">Tervetuloa käyttämään tukijärjestelmäämme. Täytä ainakin pakolliset kentät ja lähetä tukipyyntösi meille. Otathan huomioon, ettemme hoida KamIT:lle kuuluvia töitä. Kiitos!</p>
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
	<td>Sukunimi:<span class="error"> *</span>&nbsp;&nbsp;</td>
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
	  <td><textarea name="viesti" rows="5" cols="40" maxlength="200" placeholder="Lyhyt kuvaus tehtävästä (max 200 merkkiä). Sallittuja erikoismerkkejä -.,!?€&*+." /><?php if(isset($_POST['viesti'])) {if(!isset($success)){echo $_POST['viesti'];}} ?></textarea></td>
	</tr>
	<tr>
	<td>Tag:<span class="error"> *</span></td>
	  <td>
	    <input type="radio" name="tag" value="peliserveri" <?php if($fields['tag'] == 'peliserveri') echo 'checked'; ?> />Peliserveri
	    <input type="radio" name="tag" value="nettisivu" <?php if($fields['tag'] == 'nettisivu') echo 'checked'; ?> />Nettisivu
	    <input type="radio" name="tag" value="muu" <?php if($fields['tag'] == 'muu') echo 'checked'; ?> />Muu
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

	<p><input type="submit" name="submit" value="Lähetä" /></p>
    </td>
  </tr>
</table>  
</form>
</body>
</html>
