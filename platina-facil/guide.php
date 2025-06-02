<?php
require 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $guide_id = $_GET['id'];

    $query = "SELECT guides.*, games.title AS game_title, users.username 
              FROM guides 
              JOIN games ON guides.game_id = games.id 
              JOIN users ON guides.user_id = users.id
              WHERE guides.id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $guide_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $guide = mysqli_fetch_assoc($result);

    // Verifica se o usuário já curtiu
    $checkLike = mysqli_prepare($conn, "SELECT id FROM guide_likes WHERE user_id = ? AND guide_id = ?");
    mysqli_stmt_bind_param($checkLike, "ii", $_SESSION['user_id'], $guide_id);
    mysqli_stmt_execute($checkLike);
    $res = mysqli_stmt_get_result($checkLike);
    $jaCurtiu = mysqli_num_rows($res) > 0;

    // Total de curtidas
    $countLike = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM guide_likes WHERE guide_id = ?");
    mysqli_stmt_bind_param($countLike, "i", $guide_id);
    mysqli_stmt_execute($countLike);
    $countRes = mysqli_stmt_get_result($countLike);
    $likes = mysqli_fetch_assoc($countRes)['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Guia - <?= $guide['title'] ?> | Platina Fácil</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(to right, #1e1e2f, #151521);
            color: #f0f0f0;
            padding: 80px 20px 20px;
        }
        .top-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 60px;
            background: #151521;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        .btn-voltar, .btn-acesso {
            padding: 8px 14px;
            background: #00d4ff;
            color: #000;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-voltar:hover, .btn-acesso:hover {
            background-color: #00aacc;
            transform: scale(1.05);
            box-shadow: 0 0 10px #00d4ff66;
        }
        .usuario {
            color: #fff;
            font-weight: bold;
            margin-right: 10px;
        }
        main {
            max-width: 800px;
            margin: auto;
            background: rgba(255,255,255,0.05);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s ease-out;
        }
        h1 {
            text-align: center;
            font-size: 2em;
            color: #00d4ff;
            margin-bottom: 10px;
        }
        .autor-data {
            text-align: center;
            margin-bottom: 20px;
            color: #ccc;
            font-size: 0.9em;
        }
        .avaliacao {
            text-align: center;
            margin-bottom: 30px;
        }
        #btn-like {
            background: <?= $jaCurtiu ? '#00cc66' : '#ff4d4d' ?>;
            color: #fff;
            font-weight: bold;
            padding: 10px 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
        }
        #btn-like:active {
            transform: scale(0.95);
        }
        p {
            line-height: 1.8;
            font-size: 1.1em;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        main img,
        main p img {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            border-radius: 10px;
        }


        main p img {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            border-radius: 10px;
        }


    </style>
</head>
<body>
<div class="top-bar">
    
    <a href="game.php?id=<?= $guide['game_id'] ?>" class="btn-voltar">← Voltar para <?= $guide['game_title'] ?></a>
    <div>
        <span class="usuario">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="btn-acesso">Logout</a>
    </div>
</div>

<main>
<img src="img/pf.png" alt="Logo Platina Fácil" style="max-width: 200px; display: block; margin: 0 auto 20px;">
<h1><?= $guide['title'] ?></h1>
    <div class="autor-data">
        Guia criado por <strong><?= htmlspecialchars($guide['username']) ?></strong> em <?= date('d/m/Y H:i', strtotime($guide['created_at'])) ?>
    </div>

    <?php if ($_SESSION["user_id"] === $guide["user_id"]): ?>
    <div style="text-align: center; margin-bottom: 25px;">
        <a href="edit_guide.php?id=<?= $guide['id'] ?>" 
           style="background-color: #00d4ff; color: #000; padding: 10px 16px; border-radius: 10px; font-weight: bold; text-decoration: none; margin-right: 10px;">
           ✏️ Editar Guia
        </a>
        <form action="delete_guide.php" method="POST" style="display: inline;">
            <input type="hidden" name="guide_id" value="<?= $guide['id'] ?>">
            <button type="submit"
                onclick="return confirm('Tem certeza que deseja excluir este guia?')"
                style="background-color: #ff4d4d; color: white; padding: 10px 16px; border: none; border-radius: 10px; font-weight: bold; cursor: pointer;">
                🗑️ Excluir Guia
            </button>
        </form>
    </div>
<?php endif; ?>


    <div class="avaliacao">
        <p id="like-total">Total de Curtidas: <?= $likes ?></p>
        <button id="btn-like">👍 <?= $jaCurtiu ? 'Curtido' : 'Curtir' ?></button>
    </div>

    <div><?= $guide['content'] ?></div>
    </main>

<script>
const btn = document.getElementById('btn-like');
btn.addEventListener('click', function () {
    btn.disabled = true;

    fetch('toggle_like.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'guide_id=<?= $guide['id'] ?>'
    })
    .then(r => r.json())
    .then(data => {
        btn.textContent = data.liked ? '👍 Curtido' : '👍 Curtir';
        btn.style.background = data.liked ? '#00cc66' : '#ff4d4d';
        document.getElementById('like-total').innerText = 'Total de Curtidas: ' + data.total;
        btn.disabled = false;
    })
    .catch(() => {
        alert('Erro ao curtir.');
        btn.disabled = false;
    });
});
</script>
</body>
</html>
