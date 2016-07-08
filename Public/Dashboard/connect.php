<?php

$server = '192.168.206.15';
$user = 'dcuser';
$pass = 'Passw0rd';
$db = 'DCSS';

$conn = new mysqli($server, $user, $pass, $db);

mysqli_report(MYSQLI_REPORT_ERROR);

?>
