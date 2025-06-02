<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Conquistas</title>
</head>
<body>
    <h1>Buscar Conquistas do Jogo</h1>

    <!-- Formulário para digitar o nome do jogo -->
    <form method="GET" action="">
        <label for="game_name">Nome do Jogo:</label>
        <input type="text" id="game_name" name="game_name" required>
        <button type="submit">Buscar Conquistas</button>
    </form>

    <?php
    // Verifica se o nome do jogo foi enviado pelo formulário
    if (isset($_GET['game_name'])) {
        $game_name = $_GET['game_name'];

        // URL da API Flask rodando localmente
        $url = "http://localhost:5000/achievements?game_name=$game_name";

        // Inicializa a requisição
        $ch = curl_init($url);

        // Configurações da requisição
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        // Executa a requisição
        $response = curl_exec($ch);
        curl_close($ch);

        // Verifica se veio um JSON válido
        $data = json_decode($response, true);

        // Exibe os resultados ou erro
        if (isset($data['error'])) {
            echo "<p><strong>Erro:</strong> " . $data['error'] . "</p>";
        } elseif (isset($data['message'])) {
            echo "<p><strong>Mensagem:</strong> " . $data['message'] . "</p>";
        } else {
            echo "<img src='" . $data['cover'] . "' alt='Capa do Jogo' style='width: 200px; height: 300px;'>";
            echo "<h2>Jogo: " . $data['gameName'] . "</h2>";
            echo "<h3>Conquistas:</h3>";
            foreach ($data['achievements'] as $achievement) {
                echo "<p><strong>" . $achievement['name'] . "</strong>: " . $achievement['description'] . "</p>";
                echo "<img src='" . $achievement['icon'] . "' alt='Ícone' style='width: 50px; height: 50px;'>";
                echo "<hr>";
            }
        }
    }
    ?>
</body>
</html>