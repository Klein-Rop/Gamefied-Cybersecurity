<?php

$host = "localhost";
$dbname = "mydb";
$username = "projects";
$password = "#Klein8960";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

return $mysqli;