<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: index.php");
    exit;
}
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];
    $release_date = $_POST["release_date"];
    $cover_image = $_POST["cover_image"];
    $difficulty = $_POST["difficulty"];
    $average_time = $_POST["average_time"];

    $query = "INSERT INTO games (title, description, release_date, cover_image, difficulty, average_time)
          VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $title, $description, $release_date, $cover_image, $difficulty, $average_time);
    mysqli_stmt_execute($stmt);
    header("Location: admin_add_game.php?success=1");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Jogo - Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(to right, #1e1e2f, #151521);
            color: #f0f0f0;
            padding: 20px;
        }

        main {
            max-width: 700px;
            margin: auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s ease-out;
        }

        h2 {
            text-align: center;
            color: #00d4ff;
            margin-bottom: 20px;
        }

        form input, form textarea, form button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-radius: 10px;
        }

        form input, form textarea {
            background-color: #2c2c3d;
            color: #fff;
        }

        form button {
            background-color: #00d4ff;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #00aacc;
        }

        p {
            text-align: center;
            margin-top: 15px;
            color: #00ffae;
            font-weight: bold;
        }

        @keyframes fadeInUp {
            from {opacity: 0; transform: translateY(40px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .voltar {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 8px 14px;
            background: #00d4ff;
            color: #000;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .voltar:hover {
            background-color: #00aacc;
            transform: scale(1.05);
            box-shadow: 0 0 10px #00d4ff66;
        }
    </style>
</head>
<body>
<a href="index.php" class="voltar">Voltar</a>
    <main>
        <h2>Adicionar Novo Jogo</h2>
        <form method="POST">
            <input type="text" name="title" placeholder="Título do jogo" required>
            <input type="text" name="cover_image" placeholder="URL da imagem de capa">
            <input type="text" name="difficulty" placeholder="Dificuldade da platina (ex: 5/10)">
            <input type="text" name="average_time" placeholder="Tempo médio (ex: 15 Horas)">
            <input type="date" name="release_date" required>
            <textarea name="description" placeholder="Descrição do jogo"></textarea>
            <button type="submit">Salvar</button>
        </form>
        <?php if (isset($_GET['success'])) echo "<p>Jogo adicionado com sucesso!</p>"; ?>
    </main>
</body>
</html>
