<?php
$password = 'admin';
$hashed_password = '$2y$10$3cEWS0jq8jEbkhHvUDNaEO3Qbmich4Ci.2fdRN3C9vePQZeyLAtqa';
if (password_verify($password, $hashed_password)) {
    echo "Password is valid!";
} else {
    echo "Invalid password.";
}
?>