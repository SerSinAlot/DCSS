<?php

$link = mysqli_connect("192.168.206.159", "webuser", "Passw0rd", "DCSS");

if($link === false) {
  die("Error: could not connect. " . mysqli_connect_error());
}

$elokuva = mysqli_real_escape_string($elokuva, $_POST['elokuva']);

$sql = "INSERT INTO Elokuvat (Elokuva) Values ('$elokuva')";
  
mysqli_close($link);
  ?>
