<?php
// Generate bcrypt hash of the password 'admin'
$password = 'admin';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Output the query (for demonstration purposes, normally you would execute this query in your database)
echo $hashed_password;
?>