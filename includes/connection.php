<?php
$host = "localhost";
$port = "5432"; // Default PostgreSQL port
$dbname = "eam_db";
$user = "DioRose";

// Create a connection to PostgreSQL
$connection = pg_connect("host=$host port=$port dbname=$dbname user=$user");

// Check if the connection is successful
if (!$connection) {
	die("Connection terminated");
}
