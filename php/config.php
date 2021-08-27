<?php
$DB_HOST = 'localhost';
$DB_NAME = 'library';
$DB_USERNAME = 'root';
$DB_PASSWORD = '';

$conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
if (!$conn){
    die("Cannot connect to databse : \n".$conn->connect_error."\n".$conn->connect_errorno);
}