<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $comment_id = $_POST['comment_id'];
    $game_id = $_POST['game_id'];
    $username = $_SESSION['username'] ?? '';

    // Verifica se o comentário é do usuário logado
    $check = mysqli_prepare($conn, "SELECT * FROM comments WHERE id = ? AND username = ?");
    mysqli_stmt_bind_param($check, "is", $comment_id, $username);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);

    if (mysqli_num_rows($result) === 1) {
        $delete = mysqli_prepare($conn, "DELETE FROM comments WHERE id = ?");
        mysqli_stmt_bind_param($delete, "i", $comment_id);
        mysqli_stmt_execute($delete);
    }

    header("Location: game.php?id=" . $game_id);
    exit;
}
?>
