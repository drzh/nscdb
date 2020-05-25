<?php
$host = 'localhost';
$usr = 'nsc';
$passwd = '1234qwER$';
$db = 'nsc';

$conn = new mysqli($host, $usr, $passwd, $db);
if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: (" . $conn -> connect_errno . ") " . $mysqli -> connect_error;
}

$sqllimit = " limit 10000;";
// echo $conn -> host_info . "\n";

?>
