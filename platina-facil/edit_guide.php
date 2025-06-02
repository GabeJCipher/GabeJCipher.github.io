<?php
require 'db.php';
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$uploadDir = __DIR__ . '/uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$guide_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM guides WHERE id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $guide_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$guide = mysqli_fetch_assoc($result);

if (!$guide) {
    echo "Guia não encontrado ou acesso negado.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = "";

    if (isset($_POST['sections']) && isset($_POST['descriptions'])) {
        for ($i = 0; $i < count($_POST['sections']); $i++) {
            $section = htmlspecialchars(trim($_POST['sections'][$i]));
            $description = htmlspecialchars(trim($_POST['descriptions'][$i]));
            $imageTag = '';

            if (isset($_FILES['images']['name'][$i]) && $_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $imageTmp = $_FILES['images']['tmp_name'][$i];
                $imageName = uniqid() . '_' . basename($_FILES['images']['name'][$i]);
                $imagePath = 'uploads/' . $imageName;
                if (move_uploaded_file($imageTmp, $uploadDir . $imageName)) {
                    $imageTag = "<img src='$imagePath' style='max-width:100%; border-radius:10px; margin:10px auto; display:block;'>";
                }
            }

            $content .= "<h3>$section</h3>\n<p>" . nl2br($description) . "</p>\n$imageTag\n";
        }
    }

    $update = "UPDATE guides SET title = ?, content = ? WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, "ssii", $title, $content, $guide_id, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: guide.php?id=$guide_id");
        exit;
    } else {
        $error = "Erro ao atualizar o guia.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Guia - Platina Fácil</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: linear-gradient(to right, #1e1e2f, #151521); color: #f0f0f0; padding: 20px; }
        .top-bar { position: fixed; top: 0; left: 0; width: 100%; background: #151521; padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; z-index: 999; }
        .btn-acesso { padding: 6px 12px; background-color: #00d4ff; color: #000; text-decoration: none; border-radius: 8px; font-weight: bold; transition: all 0.3s ease; }
        .btn-acesso:hover { background-color: #00aacc; transform: scale(1.08); }
        main { max-width: 800px; margin: 80px auto 20px auto; background: rgba(255,255,255,0.05); padding: 20px; border-radius: 20px; box-shadow: 0 0 20px rgba(0,0,0,0.3); }
        input, textarea, button { width: 100%; padding: 10px; margin: 10px 0; border: none; border-radius: 10px; }
        input, textarea { background-color: #2c2c3d; color: #fff; }
        button { background-color: #00d4ff; color: #000; font-weight: bold; cursor: pointer; }
        .section-block { background: rgba(255,255,255,0.03); padding: 10px; border-radius: 10px; margin-bottom: 15px; position: relative; }
        .remove-btn { position: absolute; top: 10px; right: 10px; background: #ff5a5a; color: white; border: none; border-radius: 50%; width: 22px; height: 22px; font-size: 14px; font-weight: bold; text-align: center; line-height: 22px; cursor: pointer; padding: 0; }
        .remove-btn:hover { background: #e04a4a; transform: scale(1.2); }
    </style>
    <script>
        function adicionarSecao() {
            const container = document.getElementById('secoes');
            const bloco = document.createElement('div');
            bloco.className = 'section-block';
            bloco.innerHTML = `
                <input type="text" name="sections[]" placeholder="Título da seção" required>
                <textarea name="descriptions[]" rows="4" placeholder="Descrição da seção" required></textarea>
                <input type="file" name="images[]" accept="image/*">
                <button type="button" class="remove-btn" onclick="this.parentElement.remove()">✖</button>
            `;
            container.appendChild(bloco);
        }
    </script>
</head>
<body>
<div class="top-bar">
    <a href="guide.php?id=<?= $guide_id ?>" class="btn-acesso">Voltar</a>
    <div>
        <span>👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="btn-acesso">Logout</a>
    </div>
</div>
<div style="text-align:center; margin-top: 100px;">
    <img src="img/pf.png" alt="Logo Platina Fácil" style="max-width: 200px; display: block; margin: 0 auto 20px;">
</div>
<main>
    <h2>Editar Guia de Platina</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" value="<?= htmlspecialchars($guide['title']) ?>" required>
        <div id="secoes">
            <?php
            $parts = preg_split('/<h3>(.*?)<\/h3>\s*<p>(.*?)<\/p>/s', $guide['content'], -1, PREG_SPLIT_DELIM_CAPTURE);
            for ($i = 1; $i < count($parts); $i += 3) {
                $section = html_entity_decode($parts[$i]);
                $description = strip_tags($parts[$i + 1]);
                echo "
                <div class='section-block'>
                    <input type='text' name='sections[]' value='" . htmlspecialchars($section) . "' placeholder='Título da seção' required>
                    <textarea name='descriptions[]' rows='4' required>" . htmlspecialchars($description) . "</textarea>
                    <input type='file' name='images[]' accept='image/*'>
                    <button type='button' class='remove-btn' onclick='this.parentElement.remove()'>✖</button>
                </div>";
            }
            ?>
        </div>
        <button type="button" onclick="adicionarSecao()">+ Adicionar Seção</button>
        <button type="submit" style="margin-top: 20px;">Salvar Alterações</button>
        <?php if (isset($error)) echo "<p style='color: #ff5a5a; font-weight: bold;'>$error</p>"; ?>
    </form>
</main>
</body>
</html>
