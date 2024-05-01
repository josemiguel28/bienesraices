<?php 

require 'includes/app.php';

$db = conectarDB();

$usuario = 'miguel@gmail.com';
$password = '12345';

$passwordHash = password_hash($password,PASSWORD_DEFAULT);


$query = "INSERT INTO usuarios (usuario, password) VALUES ('$usuario', '$passwordHash') ";


mysqli_query($db, $query);

