<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

if (isset($_POST['guide_id'])) {
    $guide_id = $_POST['guide_id'];

    // Verifica se o guia pertence ao user
    $stmt = mysqli_prepare($conn, "SELECT user_id FROM guides WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $guide_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $guide = mysqli_fetch_assoc($result);

    if ($guide && $guide['user_id'] == $_SESSION['user_id']) {
        $delete = mysqli_prepare($conn, "DELETE FROM guides WHERE id = ?");
        mysqli_stmt_bind_param($delete, "i", $guide_id);
        mysqli_stmt_execute($delete);
    }
}

header('Location: index.php');
exit;
?>
