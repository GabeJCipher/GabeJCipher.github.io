<?php
session_start();
require 'db.php';

if (isset($_GET['id'])) {
    $game_id = $_GET['id'];
    $query = "SELECT * FROM games WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $game_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $game = mysqli_fetch_assoc($result);

    $trophy_query = "SELECT * FROM trophies WHERE game_id = ?";
    $trophy_stmt = mysqli_prepare($conn, $trophy_query);
    mysqli_stmt_bind_param($trophy_stmt, "i", $game_id);
    mysqli_stmt_execute($trophy_stmt);
    $trophies = mysqli_stmt_get_result($trophy_stmt);

    $guide_query = "
    SELECT guides.*, 
           (SELECT COUNT(*) FROM guide_likes WHERE guide_likes.guide_id = guides.id) as total_likes
    FROM guides
    WHERE game_id = ?
    ORDER BY total_likes DESC
";
    $guide_stmt = mysqli_prepare($conn, $guide_query);
    mysqli_stmt_bind_param($guide_stmt, "i", $game_id);
    mysqli_stmt_execute($guide_stmt);
    $guides = mysqli_stmt_get_result($guide_stmt);
    $all_guides = [];
while ($g = mysqli_fetch_assoc($guides)) {
    $all_guides[] = $g;
}

}

function getTrophyIcon($type) {
    switch ($type) {
        case 'bronze': return '🥉';
        case 'silver': return '🥈';
        case 'gold': return '🥇';
        case 'platinum': return '💎';
        default: return '';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $game['title'] ?> - Platina Fácil</title>
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
            font-size: 2.5em;
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

        h2 { color: #00d4ff; margin-bottom: 10px; }
        p { margin: 10px 0; line-height: 1.6; }

        .trofeus-container {
            text-align: center;
            margin: 20px auto;
        }

        .trofeus-container ul {
            list-style: none;
            padding: 0;
        }

        .trofeus-container li {
            margin-bottom: 10px;
            background: rgba(255,255,255,0.1);
            padding: 10px;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .trofeus-container li:hover {
            transform: scale(1.02);
            background: rgba(255,255,255,0.15);
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

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
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
            z-index: 999;
        }

        .voltar:hover {
            background-color: #00aacc;
            transform: scale(1.05);
            box-shadow: 0 0 10px #00d4ff66;
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
            top: 20px;
            right: 20px;
            z-index: 999;
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

                .fixed-top-bar {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 999;
        }

        .fixed-user-bar {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 999;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .fixed-top-bar a,
        .fixed-user-bar a {
            background: #00d4ff;
            color: #000;
            padding: 8px 14px;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .fixed-top-bar a:hover,
        .fixed-user-bar a:hover {
            background-color: #00aacc;
            transform: scale(1.05);
            box-shadow: 0 0 10px #00d4ff66;
        }

        .fixed-user-bar span {
            font-weight: bold;
            color: #fff;
        }

    </style>
</head>
<body>
    <!-- Botão fixo de Voltar -->
<div class="fixed-top-bar">
    <a href="index.php">Voltar</a>
</div>

<!-- Barra fixa com usuário e logout/login -->
<div class="fixed-user-bar">
    <?php if (isset($_SESSION['username'])): ?>
        <span>👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Registrar</a>
    <?php endif; ?>
</div>

    <header>
    <img src="img/pf.png" alt="Platina Fácil" style="max-width: 250px; margin-bottom: 10px;">

        <h1><?= $game['title'] ?></h1>
        <p><?= nl2br($game['description']) ?></p>
        <p><strong>Dificuldade da Platina:</strong> <?= $game['difficulty'] ?? 'N/A' ?></p>
        <p><strong>Tempo Médio:</strong> <?= $game['average_time'] ?? 'N/A' ?></p>
    </header>
    <main>
        
        <div class="trofeus-container">
            <h2>Troféus</h2>
            <?php
            mysqli_data_seek($trophies, 0);
            $total_bronze = $total_silver = $total_gold = $total_platinum = 0;
            while ($t = mysqli_fetch_assoc($trophies)) {
                switch ($t['type']) {
                    case 'bronze': $total_bronze++; break;
                    case 'silver': $total_silver++; break;
                    case 'gold': $total_gold++; break;
                    case 'platinum': $total_platinum++; break;
                }
            }
            $total_all = $total_bronze + $total_silver + $total_gold + $total_platinum;
            mysqli_data_seek($trophies, 0);
            ?>
            <p><strong>Total de Troféus:</strong>
                🥉 <?= $total_bronze ?> |
                🥈 <?= $total_silver ?> |
                🥇 <?= $total_gold ?> |
                💎 <?= $total_platinum ?> |
                <strong>Total:</strong> <?= $total_all ?> 🏆
            </p>
            <ul>
                <?php while ($trophy = mysqli_fetch_assoc($trophies)) { ?>
                    <li>
                        <?= getTrophyIcon($trophy['type']) ?>
                        <strong><?= $trophy['title'] ?></strong>: <?= $trophy['description'] ?>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <h2>Comentários</h2>
        <ul>

        </ul>

        <?php if (isset($_SESSION['username'])): ?>
    <h3>Comentar</h3>
    <form action="create_comment.php" method="POST">
        <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
        <textarea name="comment" rows="3" placeholder="Escreva seu comentário..." required></textarea>
        <button type="submit">Enviar Comentário</button>
    </form>
<?php else: ?>
    <p style="text-align:center; margin-top: 20px;">🔒 Faça <a href='login.php' style='color: #00d4ff;'>login</a> para comentar.</p>
<?php endif; ?>

<h3></h3>
<div style="max-height: 400px; overflow-y: auto; margin-top: 10px; background-color: rgba(255,255,255,0.05); padding: 15px; border-radius: 10px;">
<?php
$comment_query = "SELECT id, username, comment, created_at FROM comments WHERE game_id = ? ORDER BY created_at DESC";
$comment_stmt = mysqli_prepare($conn, $comment_query);
mysqli_stmt_bind_param($comment_stmt, "i", $game_id);
mysqli_stmt_execute($comment_stmt);
$comments = mysqli_stmt_get_result($comment_stmt);
while ($c = mysqli_fetch_assoc($comments)) {
    echo "<div style='position: relative; margin-bottom: 10px;'>";
    echo "<p style='margin-bottom: 4px;'>
            <strong style='color: #00d4ff;'>" . htmlspecialchars($c['username']) . "</strong>
            <span style='font-size: 0.8em; color: #ccc; float: right;'>" . date('d/m/Y H:i', strtotime($c['created_at'])) . "</span>
          </p>";
    echo "<p style='margin-bottom: 8px;'>" . nl2br(htmlspecialchars($c['comment'])) . "</p>";
    
    if (isset($_SESSION['username']) && $_SESSION['username'] === $c['username']) {
        echo "<form method='POST' action='delete_comment.php' style='position: absolute; top: 0; right: 0;'>
                <input type='hidden' name='comment_id' value='" . $c['id'] . "'>
                <input type='hidden' name='game_id' value='" . $game_id . "'>
                <button type='submit'
                    style='background: none; border: none; color: #ff5a5a; font-weight: bold; cursor: pointer; transition: transform 0.2s, color 0.2s;'
                    onmouseover=\"this.style.transform='scale(1.2)'\"
                    onmouseout=\"this.style.transform='scale(1)'\"
                    onclick=\"return confirm('Tem certeza que deseja apagar este comentário?')\"
                >🗑️</button>
              </form>";
    }
    
    echo "<hr style='border-color: rgba(255,255,255,0.1);'>";
    echo "</div>";
    
    }
?>
</div>

    </main>
    <div id="guia-panel" style="
    position: fixed;
    top: 100px;
    right: 20px;
    width: 300px;
    max-height: 80vh;
    background-color: rgba(255,255,255,0.05);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.4);
    overflow-y: auto;
    z-index: 99;
">
    <h2 style="color: #00d4ff;">Top Guias</h2>

    <div id="lista-guias">
        <?php foreach ($all_guides as $i => $guide): ?>
            <p class="guia-item" style="margin-bottom: 8px; display: <?= $i < 3 ? 'block' : 'none' ?>;">
                <a href="guide.php?id=<?= $guide['id'] ?>" style="color: #fff; text-decoration: none; font-weight: bold;">
                    <?= htmlspecialchars($guide['title']) ?> 👍 <?= $guide['total_likes'] ?>
                </a>
            </p>
        <?php endforeach; ?>
    </div>

    <button id="toggle-guias" onclick="toggleGuias()"
        style="margin-top: 10px; padding: 10px; background: #00d4ff; color: #000; font-weight: bold; border: none; border-radius: 8px; cursor: pointer;">
        Mostrar mais
    </button>

    <a href="create_guide.php?game_id=<?= $game['id'] ?>"
       style="display: block; margin-top: 15px; text-align: center; background: #00d4ff; padding: 12px; border-radius: 10px; font-weight: bold; color: #000; text-decoration: none;">
       + Criar Guia
    </a>
</div>


    </a>
</div>
<script>
let mostrandoMais = false;

function toggleGuias() {
    const guias = document.querySelectorAll('.guia-item');
    const btn = document.getElementById('toggle-guias');

    guias.forEach((el, i) => {
        if (i >= 3) el.style.display = mostrandoMais ? 'none' : 'block';
    });

    btn.innerText = mostrandoMais ? 'Mostrar mais' : 'Mostrar menos';
    mostrandoMais = !mostrandoMais;
}
</script>


</body>
</html>
