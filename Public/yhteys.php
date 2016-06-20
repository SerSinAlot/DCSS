<?php
$servername="192.168.206.159";
$username="webuser";
$password="Passw0rd";
$dbname="DCSS";

var_dump($_POST);

foreach ($_POST as $param_name => $param_val){
	echo nl2br ("Param: $param_name; Value: $param_val \n");
}

/*Muodosta yhteys*/
$yhteys = mysqli_connect($servername, $username, $password, $dbname);

/*Testaa yhteys*/
if (!$yhteys) {
	die("Yhteys epäonnistui: " . mysqli_connect_error());
}
echo "Yhteys onnistui. ";



$sql="INSERT INTO Tiketit(`Etunimi`, `Sukunimi`, Luokka, `Email`, PuhNro, `Otsikko`, `Viesti`, Tag)
VALUES ('$etunimi', '$sukunimi', '$luokka', '$email', '$puhelin', '$otsikko', '$viesti', '$tag')";
if(mysqli_query($yhteys, $sql)) {
	echo "Tiedot tallennettu onnistuneesti.";
} else {
		echo "Virhe: tietojen tallennus epäonnistui. " .
		mysqli_error($yhteys);
}

mysqli_close($yhteys);

var_dump($_POST);
?>
