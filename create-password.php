<?php
// Generate bcrypt hash of the password 'admin'
$password = 'BubanjLudnica96';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
// $2y$10$3TTX3k2Y.j7JaUuP41B.Sehj./I8KKs7upP9CEqtzTwCxLGv7K.5y

// Output the query (for demonstration purposes, normally you would execute this query in your database)
echo $hashed_password;
