<!DOCTYPE HTML>
<html>
  <head>
  <link rel="stylesheet" type="text/css" href="style.css">
    <title>DCSS</title>
  </head>
<body>

<?php
$errors = array();
$fields = array();
success_message = "";

if (isset($_POST['submit']))
{
	// import validation lib
	require_once("validation.php");
	
	$rules = array(); // stores validation rules
	
	// form fields
	$rules[] = "required,etunumi,This field is required.";
	$rules[] = "required,sukunimi,This field is required";
	$rules[] = "valid_email,email,This field is required";
	$rules[] = "required,otsikko,This field is required";
	$rules[] = "required,viesti,This field is required";
	
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
		header("Location: thanks.php");
	}
}
?>

<h1>Data Center Support System</h1>
<p1>Hei, kun metsään huutaa, niin DC vastaa.</p1><br><br>
<p2><span class="error">* pakollinen kenttä.</span></p2><br><br>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
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
	<span class="error">* <?php echo $luokkaErr;?></span>
	</div><br>
    	<label class="otsikko">Sähköposti:</label>
	<div class="kenttä">
	<input type="text" name="sähköposti" placeholder="nimi@kamk.fi">
	<span class="error">* <?php echo $emailErr;?></span>
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
	<textarea name="viesti" rows="5" cols="40" maxlength="200" placeholder="Lyhyt kuvaus tehtävästä (max 200 merkkiä)"></textarea>
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
