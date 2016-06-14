<?php

$link = mysqli_connect("192.168.206.159", "webuser", "Passw0rd", "DCSS");

if($link === false) {
  die("Error: could not connect. " . mysqli_connect_error());
}

$elokuva = mysqli_real_escape_string($link, $_POST['elokuva']);

$sql = "INSERT INTO Elokuvat (Elokuva) Values ('$elokuva')";
if(mysqli_query($link, $sql)) {
  echo "Records added succesfully.";
} else {
  echo "Error: Could not execute $sql. " . mysqli_error($link);
}
}
  
mysqli_close($link);
  ?>
