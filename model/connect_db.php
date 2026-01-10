<?php

$hostname = 'localhost'; // default host is localhost in xampp
$username = 'root'; // default username is root in xampp
$password = ''; // default password is empty in xampp
$database = 'lu_clubs_db'; // database name

// Create a connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check the connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

 echo "Connected to the database successfully";
 
 $name = "Md. Shazadur Rahman";
 $email = "cse_1932020013@lus.ac.bd";


 $insertSql = "INSERT INTO user (name, email) VALUES ('$name', '$email')"; 

 if ($conn->query($insertSql) === TRUE) {
     echo "New record created successfully";
    } 
     
    else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    
    }
 

// // all user
// $user = "SELECT * FROM users";
// $result = $conn->query($user);