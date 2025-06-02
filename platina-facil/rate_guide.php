<?php
session_start();
require 'db.php';

if (isset($_POST['guide_id'], $_POST['rating']) && isset($_SESSION['user_id'])) {
    $guide_id = $_POST['guide_id'];
    $rating = max(1, min(5, intval($_POST['rating'])));
    $user_id = $_SESSION['user_id'];

    $stmt = mysqli_prepare($conn, "REPLACE INTO guide_ratings (guide_id, user_id, rating) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iii", $guide_id, $user_id, $rating);
    mysqli_stmt_execute($stmt);
}

header("Location: guide.php?id=" . $_POST['guide_id']);
exit;
