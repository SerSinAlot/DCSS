<!DOCTYPE HTML> <html> <head>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<title>DCSS</title> </head> <body>
	<?php
	$etunimiErr = $sukunimiErr = $luokkaErr = $emailErr = $puhelinErr = $otsikkoErr = $viestiErr 
= $tagErr = "";
	$etunimi = $sukunimi = $luokka = $email = $puhelin = $otsikko = $viesti = $tag = "";
	define($errors, array (
	etunimiErr,
	$sukunimiErr,
	$luokkaErr,
	$emailErr,
	$puhelinErr,
	$otsikkoErr,
	$viestiErr,
	$tagErr
	));
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$valid = true;
		if (empty($_POST["etunimi"])) {
			$etunimiErr = "Syötä etunimi";
			$valid = false;
		}
		else {
			$etunimi = testi($_POST["etunimi"]);
			if (!preg_match("/^[a-ÖA-Ö -]*$/",$etunimi)) {
				$etunimiErr = "Vain kirjaimia, välilyöntejä tai -viivoja";
			}
		}
		if (empty($_POST["sukunimi"])) {
			$sukunimiErr = "Syötä sukunimi";
			$valid = false;
		}
		else {
			$sukunimi = testi($_POST["sukunimi"]);
			if (!preg_match("/^[a-öA-Ö -]*$/",$sukunimi)) {
				$sukunimiErr = "Vain kirjaimia, välilyöntejä tai -viivoja";
			}
		}
		if (empty($_POST["ryhmä"])) {
			$luokkaErr = "Syötä ryhmä";
			$valid = false;
		}
		else {
			$luokka = testi($_POST["ryhmä"]);
			if (!preg_match("/^[a-ÖA-Ö 0-9]*$/",$luokka)) {
				$luokka = "Vain kirjaimia";
			}
		}
		if (empty($_POST["sähköposti"])) {
			$emailErr = "Syötä sähköposti";
			$valid = false;
		}
		else {
			$email = testi($_POST["sähköposti"]);
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$email = "Syötä oikea sähköpostiosoite";
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
			$valid = false;
		}
		else {
			$otsikko = testi($_POST["otsikko"]);
			if (!preg_match("/^[a-öA-Ö0-9 -]*$/",$otsikko)) {
				$otsikkoErr = "Ei erikoismerkkejä";
			}
		}
		if (empty($_POST["viesti"])) {
			$viestiErr = "Kirjoita viesti";
			$valid = false;
		}
		else {
			$viesti = testi($_POST["viesti"]);
		}
		if (empty($_POST["tag"])) {
			$tagErr = "Valitse Tag";
			$valid = false;
		}
		else {
			$tag = testi($_POST["tag"]);
		}
		if($valid){
			header('Location: yhteys.php');
			exit();
		}
	}
	function testi($data) {
		$data=trim($data);
		$data=stripcslashes($data);
		$data=htmlspecialchars($data);
		return $data;
	}
	
	if (!empty(array($errors)))
	{
		echo "<div class='error'>Korjaa seuraavat virheet:\n<ul>";
		foreach ($errors)
		echo "<li>$errors</li>\n";
		
	echo "</ul></div>";
	}
    ?>
	<h1>Data Center Support System</h1>
	<p1>Hei, kun metsään huutaa, niin DC vastaa.</p1>
	<br />
	<br />
	<p2>
		<span class="error">* pakollinen kenttä.</span>
	</p2>
	<br />
	<br />
	<form method="post" action="<?php echo htmlspecialchars($_SERVER['yhteys.php']);?>">
		<label class="otsikko">Etunimi:</label>
		<div class="kenttä">
			<input type="text" name="etunimi" placeholder="Etunimi" />
			<span class="error">
				* <?php echo $etunimiErr;?>
			</span>
		</div>
		<br />
		<label class="otsikko">Sukunimi:</label>
		<div class="kenttä">
			<input type="text" name="sukunimi" placeholder="Sukunimi" />
			<span class="error">
				* <?php echo $sukunimiErr;?>
			</span>
		</div>
		<br />
		<label class="otsikko">Ryhmä:</label>
		<div class="kenttä">
			<input type="text" name="ryhmä" placeholder="Ryhmätunnus" />
			<span class="error">
				* <?php echo $luokkaErr;?>
			</span>
		</div>
		<br />
		<label class="otsikko">Sähköposti:</label>
		<div class="kenttä">
			<input type="text" name="sähköposti" placeholder="nimi@kamk.fi" />
			<span class="error">
				* <?php echo $emailErr;?>
			</span>
		</div>
		<br />
		<label class="otsikko">Puhelin:</label>
		<div class="kenttä">
			<input type="text" name="puhelin" placeholder="0102345678" />
		</div>
		<br />
		<label class="otsikko">Otsikko:</label>
		<div class="kenttä">
			<input type="text" name="otsikko" placeholder="Otsikko" />
			<span class="error">
				* <?php echo $otsikkoErr;?>
			</span>
		</div>
		<br />
		<label class="otsikko">Viesti:</label>
		<div class="kenttä">
			<textarea name="viesti" rows="5" cols="40" maxlength="200" 
placeholder="Lyhyt kuvaus tehtävästä (max 200 merkkiä)"></textarea>
			<span class="error">
				* <?php echo $viestiErr;?>
			</span>
		</div>
		<br />
		Tag:
		<input type="radio" name="tag" value="peliserveri" />Peliserveri
		<input type="radio" name="tag" value="nettisivu" />Nettisivu
		<span class="error">
			* <?php echo $tagErr;?>
		</span>
		<br />
		<br />
		<input type="submit" value="Lähetä" />
	</form> </body> </html>
