<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misfits Scan</title>
    <style>
        /* Reset CSS */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #e0e0e0;
            color: #222;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        /* Header */
        header {
            background-color: #3a3a3a;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo img {
            height: 60px;
        }
        
        .logo-text {
            color: white;
            font-weight: bold;
            font-size: 20px;
            margin-left: 10px;
        }
        
        nav {
            display: flex;
        }
        
        nav ul {
            display: flex;
            list-style: none;
        }
        
        nav ul li {
            margin-left: 20px;
        }
        
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        nav ul li a:hover {
            color: #4dabf7;
        }
        
        .nav-icon {
            margin-right: 5px;
            font-size: 12px;
        }
        
        .auth-buttons {
            display: flex;
            align-items: center;
        }
        
        .login-btn, .signup-btn {
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 12px;
            text-decoration: none;
            margin-left: 10px;
        }
        
        .login-btn {
            background-color: transparent;
            border: 1px solid #5b9bff;
            color: #5b9bff;
        }
        
        .signup-btn {
            background-color: #5b9bff;
            color: #fff;
            border: 1px solid #5b9bff;
        }
        
        /* Main Content */
        .main-content {
            padding-top: 60px;
            min-height: 100vh;
        }
        
        /* Slider */
        .slider {
            height: 250px; /* ou 180px, ajusta como preferir */
            border-radius: 8px;
            overflow: hidden;
            margin-top: 30px;
            margin-bottom: 30px;
            position: relative;
        }

        .slider img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* recorta a imagem pra encaixar na moldura */
            border-radius: 8px;
        }
        
        .slider-nav {
            text-align: center;
            margin-top: 10px;
        }
        
        .slider-nav span {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin: 0 5px;
            background-color: #555;
        }
        
        .slider-nav span.active {
            background-color: #fff;
        }
        
        /* Latest Releases Section */
        .latest-releases {
            margin-bottom: 50px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #fff;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-transform: uppercase;
        }
        
        .manga-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
        }
        
        .manga-card {
            border-radius: 8px;
            overflow: hidden;
            background-color: #3a3a3a;
            transition: transform 0.3s ease;
        }
        
        .manga-card:hover {
            transform: translateY(-5px);
        }
        
        .manga-cover {
            position: relative;
            overflow: hidden;
            height: 200px;
        }
        
        .manga-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .manga-info {
            padding: 10px;
        }
        
        .manga-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .manga-rating {
            color: #ffc107;
            font-size: 12px;
            margin-bottom: 5px;
        }
        
        .manga-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 8px;
        }
        
        .chapter-tag {
            background-color:rgba(155, 29, 29, 0.34);
            color: #222;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 10px;
        }
        
        .date-tag {
            color: #6c757d;
            font-size: 10px;
            margin-top: 3px;
        }
        
        /* More Button */
        .more-section {
            text-align: center;
            margin: 30px 0;
        }
        
        .more-btn {
            background-color: #8f8f8f;
            border: none;
            color: #fff;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .more-btn:hover {
            background-color: #8f8f8f;
        }
        
        /* Popular Section */
        .popular-section {
            margin-bottom: 50px;
        }
        
        .popular-carousel {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding-bottom: 15px;
            scrollbar-width: thin;
            scrollbar-color: #5b9bff #1c2438;
        }
        
        .popular-carousel::-webkit-scrollbar {
            height: 5px;
        }
        
        .popular-carousel::-webkit-scrollbar-track {
            background: #1c2438;
        }
        
        .popular-carousel::-webkit-scrollbar-thumb {
            background-color: #5b9bff;
            border-radius: 10px;
        }
        
        .popular-item {
            flex: 0 0 auto;
            width: 180px;
            background-color: #3a3a3a;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .popular-cover {
            height: 100px;
            overflow: hidden;
        }
        
        .popular-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .popular-info {
            padding: 10px;
        }
        
        .popular-title {
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .popular-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
        }
        
        .read-btn {
            background-color: #8f8f8f;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            text-decoration: none;
        }
        
        /* Footer */
        footer {
            background-color: #3a3a3a;
            padding: 20px 0;
            text-align: center;
            font-size: 12px;
            color: #b0b0b0;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }
            
            .manga-grid {
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
                gap: 15px;
            }
            
            .manga-cover {
                height: 180px;
            }
            
            nav ul li {
                margin-left: 15px;
            }
        }
        
        @media (max-width: 576px) {
            .manga-grid {
                grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
                gap: 10px;
            }
            
            .manga-cover {
                height: 150px;
            }
            
            nav ul li span {
                display: none;
            }
            
            .nav-icon {
                margin-right: 0;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <?php
    // Dados simulados para mangás
    $mangas = [
        [
            "id" => 1,
            "title" => "Bouryoko Banzai",
            "cover" => "assets/imagens/banzai.jpg",
            "rating" => 4.7,
            "rating_count" => 43,
            "chapter" => 205,
            "date" => "2 dias atrás"
        ],
        [
            "id" => 2,
            "title" => "Hitoribocchi no Isekai Kouryaku",
            "cover" => "assets/imagens/hitori.webp",
            "rating" => 4.4,
            "rating_count" => 42,
            "chapter" => 39,
            "date" => "2 dias atrás"
        ],
        [
            "id" => 3,
            "title" => "Dead Account",
            "cover" => "assets/imagens/dead.jpg",
            "rating" => 5.0,
            "rating_count" => 5,
            "chapter" => 15,
            "date" => "2 dias atrás"
        ],
        [
            "id" => 4,
            "title" => "Yuusha Party Kara Oidasareta Fuguushoku",
            "cover" => "assets/imagens/yuusha.jpg",
            "rating" => 5.0,
            "rating_count" => 47,
            "chapter" => 346,
            "date" => "26 de janeiro"
        ],
       
    ];
    
    // Dados simulados para mangás populares
    $popular_mangas = [
        [
            "id" => 1,
            "title" => "Bouryoko Banzai",
            "cover" => "assets/imagens/banzai2.jpg"
        ],
        [
            "id" => 4,
            "title" => "Hitoribocchi no Isekai Kouryaku",
            "cover" => "assets/imagens/hitori2.webp"
        ],
        [
            "id" => 10,
            "title" => "Dead Account",
            "cover" => "assets/imagens/dead2.jpg"
        ],
        [
            "id" => 11,
            "title" => "Yuusha Party Kara Oidasareta Fuguushoku",
            "cover" => "assets/imagens/yuusha2.jpeg"
        ],

    ];
    ?>

    <!-- Header -->
    <header>
        <div class="logo">
            <img src="assets/imagens/icon.png" alt="Logo">
            <span class="logo-text">MISFITS SCAN</span>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="#">
                        <span class="nav-icon">🏠</span>
                        <span>HOME</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="nav-icon">📚</span>
                        <span>PROJETOS</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="nav-icon">👥</span>
                        <span>NOSSA EQUIPE</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="nav-icon">💬</span>
                        <span>DISCORD</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <a href="#" class="login-btn">Login</a>
            <a href="#" class="signup-btn">Cadastrar</a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Slider Section -->
            <div class="slider">
                <img src="assets/imagens/banner.webp" alt="Banner principal">
                <div class="slider-nav">
                    <span class="active"></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <!-- Latest Releases Section -->
            <div class="latest-releases">
                <h2 class="section-title">ÚLTIMOS MANGÁS LANÇADOS</h2>
                <div class="manga-grid">
                    <?php foreach ($mangas as $manga): ?>
                    <div class="manga-card">
                        <div class="manga-cover">
                            <img src="<?php echo $manga["cover"]; ?>" alt="<?php echo $manga["title"]; ?>">
                        </div>
                        <div class="manga-info">
                            <h3 class="manga-title"><?php echo $manga["title"]; ?></h3>
                            <div class="manga-rating">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <?php if ($i < floor($manga["rating"])): ?>
                                        ★
                                    <?php elseif ($i < $manga["rating"]): ?>
                                        ☆
                                    <?php else: ?>
                                        ☆
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span><?php echo $manga["rating_count"]; ?></span>
                            </div>
                            <div class="manga-meta">
                                <div class="chapter-tag">Capítulo <?php echo $manga["chapter"]; ?></div>
                                <div class="date-tag"><?php echo $manga["date"]; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- More Button -->
            <div class="more-section">
                <button class="more-btn">MAIS -</button>
            </div>

            <!-- Popular Section -->
            <div class="popular-section">
                <h2 class="section-title">POPULARES</h2>
                <div class="popular-carousel">
                    <?php foreach ($popular_mangas as $manga): ?>
                    <div class="popular-item">
                        <div class="popular-cover">
                            <img src="<?php echo $manga["cover"]; ?>" alt="<?php echo $manga["title"]; ?>">
                        </div>
                        <div class="popular-info">
                            <h3 class="popular-title"><?php echo $manga["title"]; ?></h3>
                            <div class="popular-actions">
                                <a href="#" class="read-btn">Ler agora</a>
                                <a href="#" class="read-btn">Detalhes</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> MISFITS Scan. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>