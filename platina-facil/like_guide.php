<?php
session_start();
require 'db.php';

if (isset($_POST['guide_id']) && isset($_SESSION['user_id'])) {
    $guide_id = $_POST['guide_id'];
    $user_id = $_SESSION['user_id'];

    $check = mysqli_prepare($conn, "SELECT id FROM guide_likes WHERE guide_id = ? AND user_id = ?");
    mysqli_stmt_bind_param($check, "ii", $guide_id, $user_id);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) == 0) {
        $stmt = mysqli_prepare($conn, "INSERT INTO guide_likes (guide_id, user_id) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ii", $guide_id, $user_id);
        mysqli_stmt_execute($stmt);
    }
}

header("Location: guide.php?id=" . $_POST['guide_id']);
exit;
