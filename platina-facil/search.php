<?php
require 'db.php';

$search = $_GET['q'] ?? '';
$query = "SELECT * FROM games WHERE title LIKE ?";
$stmt = mysqli_prepare($conn, $query);
$search_term = "%" . $search . "%";
mysqli_stmt_bind_param($stmt, "s", $search_term);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Buscar - Platina Fácil</title>
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

        header {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeIn 1s ease-in-out;
        }

        header h1 {
            font-size: 2em;
            margin-bottom: 10px;
            color: #00d4ff;
        }

        header a {
            color: #fff;
            background-color: #00d4ff;
            padding: 8px 14px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        header a:hover {
            background-color: #00aacc;
        }

        main {
            max-width: 800px;
            margin: auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s ease-out;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 10px;
            transition: transform 0.3s, background 0.3s;
        }

        li:hover {
            transform: scale(1.02);
            background: rgba(255,255,255,0.15);
        }

        a {
            text-decoration: none;
            color: #fff;
            font-weight: 600;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        @keyframes fadeInUp {
            from {opacity: 0; transform: translateY(40px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <header>
    <img src="img/pf.png" alt="Logo Platina Fácil" style="max-width: 200px; display: block; margin: 0 auto 20px;">

        <h1>Resultado da busca por: <?= htmlspecialchars($search) ?></h1>
        <a href="index.php">Voltar</a>
    </header>
    <main>
        <ul>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <li><a href="game.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a></li>
            <?php } ?>
        </ul>
    </main>
</body>
</html>
