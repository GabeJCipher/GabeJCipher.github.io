<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "platina_facil";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
}
?>
