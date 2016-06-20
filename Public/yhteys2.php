<?php
session_start();
$servername="192.168.206.159";
$username="webuser";
$password="Passw0rd";
$dbname="DCSS";

var_dump($_POST);

/*Muodosta yhteys*/
$yhteys = mysqli_connect($servername, $username, $password, $dbname);

/*Testaa yhteys*/
if (!$yhteys) {
	die("Yhteys epäonnistui: " . mysqli_connect_error());
}
echo "Yhteys onnistui. ";

foreach($_SESSION['fields'] as $row=>$id){
	$id=mysql_real_escape_string($_SESSION['ID']);
	$etunimi=mysql_real_escape_string($_SESSION['etunimi'][$row]);
	$sukunimi=mysql_real_escape_string($_SESSION['sukunimi'][$row]);
	$luokka=mysql_real_escape_string($_SESSION['luokka'][$row]);
	$email=mysql_real_escape_string($_SESSION['email'][$row]);
	$puhelin=mysql_real_escape_string($_SESSION['puhelin'][$row]);
	$otsikko=mysql_real_escape_string($_SESSION['otsikko'][$row]);
	$viesti=mysql_real_escape_string($_SESSION['viesti'][$row]);
	$tag=mysql_real_escape_string($_SESSION['tag'][$row]);
}

$sql="INSERT INTO Tiketit(`ID`,`Etunimi`, `Sukunimi`, `Luokka`, `Email`, `PuhNro`, `Otsikko`, `Viesti`, `Tag`)
VALUES ('$id', '$etunimi', '$sukunimi', '$luokka', '$email', '$puhelin', '$otsikko', '$viesti', '$tag')";
if(mysqli_query($yhteys, $sql)) {
	echo "Tiedot tallennettu onnistuneesti.";
} else {
		echo "Virhe: tietojen tallennus epäonnistui. " .
		mysqli_error($yhteys);
}

mysqli_close($yhteys);
?>
