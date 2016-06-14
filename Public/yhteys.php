<?php
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
echo "Yhteys onnistui";

$etunimi=mysqli_real_escape_string($yhteys, @$_POST['etunimi']);
$sukunimi=mysqli_real_escape_string($yhteys, @$_POST['sukunimi']);
$luokka=mysqli_real_escape_string($yhteys, @$_POST['ryhmä']);
$email=mysqli_real_escape_string($yhteys, @$_POST['sähköposti']);
$puhelin=mysqli_real_escape_string($yhteys, @$_POST['puhelin']);
$otsikko=mysqli_real_escape_string($yhteys, @$_POST['otsikko']);
$viesti=mysqli_real_escape_string($yhteys, @$_POST['viesti']);
$tag=mysqli_real_escape_string($yhteys, @$_POST['tag']);

$sql="INSERT INTO `Tiketit`(`Etunimi`, `Sukunimi`, `Luokka`, `Email`, `PuhNro`, `Otsikko`, `Viesti`, `Tag`)
VALUES ('$etunimi', '$sukunimi', '$luokka', '$email', '$puhelin', '$otsikko', '$viesti', '$tag')";
if(mysqli_query($yhteys, $sql)) {
	echo "Tiedot tallennettu onnistuneesti.";
} else {
		echo "Virhe: tietojen tallennus epäonnistui." .
		mysqli_error($yhteys);
}

mysqli_close($yhteys);
?>
