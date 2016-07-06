<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<table style='border: solid 1px black;'>";
echo "<tr><th>Id</th><th>Etunimi</th><th>Sukunimi</th></tr>";

class TableRows extends RecursiveIteratorIterator {
	function _construct($it) {
		parent:: _construct($it, self::LEAVES_ONLY);
	}
	
	function current() {
		return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
	}

	function beginChildren() {
		echo "<tr>";
	}

	function endChildren() {
		echo "</tr>" . "\n";
	}
}

$servername = "192.168.206.159";
$username = "dcuser";
$password = "Passw0rd";
$dbname = "DCSS";

try {
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare("SELECT ID, Etunimi, Sukunimi FROM Tiketit");
	$stmt->execute();

	$result = $stmt->setFetchMode(PDO__FETCH_ASSOC);
	foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as  $k=>$v){
		echo $v;
	}
}
catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
?>
