<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuário ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Platina Fácil</title>
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
    max-width: 500px;
    margin: auto;
    background: rgba(255, 255, 255, 0.05);
    padding: 40px 30px;
    border-radius: 20px;
    box-shadow: 0 0 20px rgba(0,0,0,0.3);
    animation: fadeInUp 0.8s ease-out;
}

        h2 {
            text-align: center;
            color: #00d4ff;
            margin-bottom: 20px;
        }

        form input, form button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: none;
            border-radius: 10px;
        }

        form input {
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
            color: #ff5a5a;
            font-weight: bold;
        }

        @keyframes fadeInUp {
            from {opacity: 0; transform: translateY(40px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<img src="img/pf.png" alt="Logo Platina Fácil" style="max-width: 200px; display: block; margin: 0 auto 20px;">

    <a href="index.php" style="position: absolute; top: 20px; left: 20px; padding: 8px 14px; background: #00d4ff; color: #000; text-decoration: none; border-radius: 10px; font-weight: bold; transition: background-color 0.3s; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#00aacc'; this.style.transform='scale(1.05)'" onmouseout="this.style.backgroundColor='#00d4ff'; this.style.transform='scale(1)'">Voltar</a>
    <main>
        <h2>Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </main>
</body>
</html>
