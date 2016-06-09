<?php
$servername="192.168.206.159";
$username="webuser@192.168.206.150";
$password="Passw0rd";
$dbname="DCSS";

/*Muodosta yhteys*/
$yhteys = new mysqli_connect($servername, $username, $password, $dbname);

/*Testaa yhteys*/
if ($yhteys === false) {
die("Yhteys epäonnistui: " . mysqli_connect_error());
}
echo "Yhteys onnistui";

$etunimi=mysqli_real_escape_string($yhteys, $_POST['Etunimi']);
$sukunimi=mysqli_real_escape_string($yhteys, $_POST['Sukunimi']);
$ryhmä=mysqli_real_escape_string($yhteys, $_POST['Ryhmä']);
$sähköposti=mysqli_real_escape_string($yhteys, $_POST['Email']);
$puhelin=mysqli_real_escape_string($yhteys, $_POST['PuhNro']);
$otsikko=mysqli_real_escape_string($yhteys, $_POST['Otsikko']);
$viesti=mysqli_real_escape_string($yhteys, $_POST['Viesti']);
$tag=mysqli_real_escape_string($yhteys, $_POST['Tag']);

$sql="INSERT INTO `Tiketit`(`Etunimi`, `Sukunimi`, `Ryhmä`, `Email`, `PuhNro`, `Otsikko`, `Viesti`, `Tag`)
VALUES ('$etunimi', '$sukunimi', '$ryhmä', '$sähköposti', '$puhelin', '$otsikko', '$viesti', '$tag')"
if(mysqli-query($yhteys, $sql)) {
	echo "Tiedot tallennettu onnistuneesti.";
} else {
		echo "Virhe: tietojen tallennus epäonnistui." .
		mysqli_error($yhteys);
}

mysqli_close($yhteys);
?>
