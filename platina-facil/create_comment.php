<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $game_id = $_POST["game_id"];
    $username = $_SESSION["username"];
    $comment = trim($_POST["comment"]);

    if (!empty($comment)) {
        $query = "INSERT INTO comments (game_id, username, comment, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "iss", $game_id, $username, $comment);
        mysqli_stmt_execute($stmt);
    }
}

header("Location: game.php?id=" . $game_id);
exit;
