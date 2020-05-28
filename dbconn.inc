<?php
$host = 'localhost';
$usr = 'nsc';
$passwd = '1234qwER$';
/* $db = 'nsc_all'; */
$db = isset($_GET['all']) ? 'nsc_all' : 'nsc';

$conn = new mysqli($host, $usr, $passwd, $db);
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: (" . $conn -> connect_errno . ") " . $conn -> connect_error;
}

$sqllimit = " limit 1000000;";
// echo $conn -> host_info . "\n";

?>
