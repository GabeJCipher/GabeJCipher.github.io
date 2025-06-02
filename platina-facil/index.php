<?php
session_start();
require 'db.php';

$query = "SELECT * FROM games ORDER BY release_date DESC LIMIT 5";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Platina Fácil</title>
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
            position: relative;
            text-align: center;
            margin-bottom: 30px;
            animation: fadeIn 1s ease-in-out;
        }

        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            color: #00d4ff;
        }

        .btn-acesso {
            padding: 8px 14px;
            margin-left: 10px;
            background-color: #00d4ff;
            color: #000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-acesso:hover {
            background-color: #00aacc;
            transform: scale(1.08);
            box-shadow: 0 0 10px #00d4ff66;
        }

        .login-register {
            position: absolute;
            top: 0;
            right: 0;
            padding: 10px;
        }

        header form {
            margin-top: 10px;
        }

        input[type="text"] {
            padding: 10px;
            width: 60%;
            max-width: 400px;
            border: none;
            border-radius: 10px;
            background-color: #2c2c3d;
            color: #fff;
        }

        button {
            padding: 10px 16px;
            margin-left: 5px;
            border: none;
            border-radius: 10px;
            background-color: #00d4ff;
            color: #000;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #00aacc;
        }

        main {
            max-width: 1000px;
            margin: auto;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s ease-out;
        }

        h2 {
            color: #00d4ff;
            margin-bottom: 20px;
            text-align: center;
        }

        .game-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .game-card {
            background-color: rgba(255,255,255,0.08);
            padding: 15px;
            border-radius: 12px;
            width: 180px;
            text-align: center;
            transition: transform 0.3s, background 0.3s;
        }

        .game-card:hover {
            transform: scale(1.05);
            background-color: rgba(255,255,255,0.12);
        }

        .game-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .game-card h3 {
            margin: 0;
        }

        .game-card a {
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
    <div class="login-register">
    <?php if (isset($_SESSION['username'])): ?>
        <span style="margin-right: 10px; font-weight: bold;">
            👤 <?= htmlspecialchars($_SESSION['username']) ?>
        </span>
        <a href="logout.php" class="btn-acesso">Logout</a>
    <?php else: ?>
        <a href="login.php" class="btn-acesso">Login</a>
        <a href="register.php" class="btn-acesso">Registrar</a>
    <?php endif; ?>
</div>


<img src="img/pf.png" alt="Platina Fácil" style="max-width: 250px; margin-bottom: 10px;">

        <form action="search.php" method="get">
            <input type="text" name="q" placeholder="Buscar jogo...">
            <button type="submit">🔍</button>
        </form>
        <?php if (isset($_SESSION['username']) && $_SESSION['username'] === 'admin'): ?>
    <div style="margin-top: 20px;">
        <a href="admin_add_game.php" class="btn-acesso">➕ Adicionar Jogo</a>
        <a href="admin_add_trophy.php" class="btn-acesso">🏆 Adicionar Troféu</a>
    </div>
<?php endif; ?>
    </header>
    <main>
        <h2>Lançamentos Recentes</h2>
        <div class="game-list">
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                <div class="game-card">
                    <a href="game.php?id=<?= $row['id'] ?>">
                        <img src="<?= $row['cover_image'] ?>" alt="<?= $row['title'] ?>">
                    </a>
                    <h3><a href="game.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a></h3>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>
