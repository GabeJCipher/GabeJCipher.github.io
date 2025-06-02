<?php
require 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM guides WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil - Platina Fácil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?= $_SESSION["username"] ?>!</h1>
        <a href="logout.php">Sair</a>
    </header>
    <main>
        <h2>Meus Guias</h2>
        <ul>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <li><a href="guide.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a></li>
            <?php } ?>
        </ul>
    </main>
</body>
</html>
