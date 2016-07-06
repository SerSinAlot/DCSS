<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername="192.168.206.159";
$username="dcuser";
$password="Passw0rd";
$dbname="DCSS";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
die("Yhteys epäonnistui: " . mysqli_connect_error());
}
echo "Yhteys onnistui";

$sql = sprintf("SELECT * FROM Tiketit",
$etunimi = mysqli_real_escape_string('etunimi'),
$sukunimi = mysqli_real_escape_string('sukunimi'),
mysqli_real_escape_string($luokka),
mysqli_real_escape_string($email),
mysqli_real_escape_string($puhnro),
mysqli_real_escape_string($otsikko),
mysqli_real_escape_string($viesti),
mysqli_real_escape_string($tag),
mysqli_real_escape_string($pvm),
mysqli_real_escape_string($tekija));

$retval = mysqli_query($sql);

if(! $retval ) {
$message = 'Invalid query: ' . mysql.error() . "\n";
$message .= 'Whole query: ' . $query;
die($message);
}

while($row = mysqli_fetch_assoc($retval)){
echo $row['etunimi'];
echo $row['sukunimi'];
echo $row['luokka'];
}

echo "Dattaa tulloo";

vardump ($sql);

mysqli_close($conn);

?>
