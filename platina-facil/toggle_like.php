<?php
require 'db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION["user_id"]) || !isset($_POST["guide_id"])) {
    echo json_encode(["error" => "Requisição inválida."]);
    exit;
}

$user_id = $_SESSION["user_id"];
$guide_id = intval($_POST["guide_id"]);

// Verifica se o like já existe
$check_query = "SELECT * FROM guide_likes WHERE user_id = ? AND guide_id = ?";
$stmt = mysqli_prepare($conn, $check_query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $guide_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_fetch_assoc($result)) {
    // Já curtiu, então remove
    $delete_query = "DELETE FROM guide_likes WHERE user_id = ? AND guide_id = ?";
    $del_stmt = mysqli_prepare($conn, $delete_query);
    mysqli_stmt_bind_param($del_stmt, "ii", $user_id, $guide_id);
    mysqli_stmt_execute($del_stmt);
    $liked = false;
} else {
    // Não curtiu ainda, então insere
    $insert_query = "INSERT INTO guide_likes (user_id, guide_id) VALUES (?, ?)";
    $ins_stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($ins_stmt, "ii", $user_id, $guide_id);
    mysqli_stmt_execute($ins_stmt);
    $liked = true;
}

// Conta total de curtidas atualizadas
$count_query = "SELECT COUNT(*) as total FROM guide_likes WHERE guide_id = ?";
$count_stmt = mysqli_prepare($conn, $count_query);
mysqli_stmt_bind_param($count_stmt, "i", $guide_id);
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total = mysqli_fetch_assoc($count_result)['total'];

echo json_encode([
    "liked" => $liked,
    "total" => $total
]);
