<!DOCTYPE HTML>
<html>
  <head>
  <link rel="stylesheet" type="text/css" href="style.css">
    <title>DCSS</title>
  </head>
<body>

<?php
$etunimiErr = $sukunimiErr = $ryhmäErr = $sähköpostiErr = $puhelinErr = $otsikkoErr = $tagErr = "";
$etunimi = $sukunimi = $ryhmä = $sähköposti = $puhelin = $otsikko = $viesti = $tag = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (empty($_POST["etunimi"])) {
	$etunimiErr = "Syötä etunimi";
	}
else {
	$etunimi = testi($_POST["etunimi"]);
	if (!preg_match("/^[a-ÖA-Ö -]*$/",$etunimi)) {
		$etunimiErr = "Vain kirjaimia, välilyöntejä tai -viivoja";
	}
}
if (empty($_POST["sukunimi"])) {
	$sukunimiErr = "Syötä sukunimi";
	}
else {
	$sukunimi = testi($_POST["sukunimi"]);
	if (!preg_match("/^[a-öA-Ö -]*$/",$sukunimi)) {
		$sukunimiErr = "Vain kirjaimia, välilyöntejä tai -viivoja";
	}
}
if (empty($_POST["ryhmä"])) {
	$ryhmäErr = "Syötä ryhmä";
}
else {
	$ryhmä = testi($_POST["ryhmä"]);
	if (!preg_match("/^[a-ÖA-Ö 0-9]*$/",$ryhmä)) {
		$ryhmä = "Vain kirjaimia";
	}
}
if (empty($_POST["sähköposti"])) {
	$sähköpostiErr = "Syötä sähköposti";
	}
else {
	$sähköposti = testi($_POST["sähköposti"]);
	if (!filter_var($sähköposti, FILTER_VALIDATE_EMAIL)) {
		$sähköposti = "Syötä oikea sähköpostiosoite";
	}
}
if (empty($_POST["puhelin"])) {
	$puhelinErr = "";
	}
else {
	$puhelin = testi($_POST["puhelin"]);
	if (!preg_match("/^[0-9 +]*$/",$puhelin)) {
		$puhelin = "Syötä oikea puhelinnumero tai jätä tyhjäksi";
	}
}
if (empty($_POST["otsikko"])) {
	$otsikkoErr = "Anna otsikko";
	}
else {
	$otsikko = testi($_POST["otsikko"]);
	if (!preg_match("/^[a-öA-Ö0-9 -]*$/",$otsikko)) {
		$otsikkoErr = "Ei erikoismerkkejä";
	}
}
if (empty($_POST["viesti"])) {
	$viestiErr = "Kirjoita viesti";
	}
else {
	$viesti = testi($_POST["viesti"]);
}
if (empty($_POST["tag"])) {
	$tagErr = "Valitse Tag";
	}
else {
	$tag = testi($_POST["tag"]);
	}
}

function testi($data) {
	$data=trim($data);
	$data=stripcslashes($data);
	$data=htmlspecialchars($data);
	return $data;
}
?>

<h1>Data Center Support System</h1>
<p1>Hei, kun metsään huutaa, niin DC vastaa.</p1><br><br>
<p2><span class="error">* pakollinen kenttä.</span></p2><br><br>

  <form method="post" action="yhteys.php">
	<label class="otsikko">Etunimi:</label>
	<div class="kenttä">
	<input type="text" name="etunimi" placeholder="Etunimi">
	<span class="error">* <?php echo $etunimiErr;?></span>
	</div><br>
	<label class="otsikko">Sukunimi:</label>
	<div class="kenttä">
	<input type="text" name="sukunimi" placeholder="Sukunimi">
	<span class="error">* <?php echo $sukunimiErr;?></span>
	</div><br>
	<label class="otsikko">Ryhmä:</label>
	<div class="kenttä">
	<input type="text" name="ryhmä" placeholder="Ryhmätunnus">
	<span class="error">* <?php echo $ryhmäErr;?></span>
	</div><br>
    	<label class="otsikko">Sähköposti:</label>
	<div class="kenttä">
	<input type="text" name="sähköposti" placeholder="nimi@kamk.fi">
	<span class="error">* <?php echo $sähköpostiErr;?></span>
	</div><br>
	<label class="otsikko">Puhelin:</label>
	<div class="kenttä">
	<input type="text" name="puhelin" placeholder="0102345678">
	</div><br>
	<label class="otsikko">Otsikko:</label>
	<div class="kenttä">
	<input type="text" name="otsikko" placeholder="Otsikko">
	<span class="error">* <?php echo $otsikkoErr;?></span>
	</div><br>
	<label class="otsikko">Viesti:</label>
	<div class="kenttä">
	<textarea name="viesti" rows="5" cols="40" placeholder="Lyhyt kuvaus tehtävästä."></textarea>
	<span class="error">* <?php echo $viestiErr;?></span>
	</div><br>
	Tag:
    	<input type="radio" name="tag" value="peliserveri">Peliserveri
    	<input type="radio" name="tag" value="nettisivu">Nettisivu
	<span class="error">* <?php echo $tagErr;?></span>
	<br><br>
    <input type="submit" value="Lähetä">
  </form>
</body>
</html>
