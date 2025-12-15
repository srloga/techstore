<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - TechStore' : 'TechStore'; ?></title>
    
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --base-url: <?php echo BASE_URL; ?>;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <a href="<?php echo BASE_URL; ?>" class="logo">
                <div class="logo-icon">🗲</div>
                <span>TechStore</span>
            </a>
            
            <nav>
                <a href="<?php echo BASE_URL; ?>index.php">Home</a> <!-- class="active" -->
                <a href="<?php echo BASE_URL; ?>products.php">Produtos</a>
                <a href="<?php echo BASE_URL; ?>categories.php">Categorias</a>
                <a href="<?php echo BASE_URL; ?>offers.php">Ofertas</a>
                <a href="<?php echo BASE_URL; ?>about.php">Sobre</a>
                <a href="<?php echo BASE_URL; ?>contact.php">Contato</a>
            </nav>
            
            <div class="header-actions">
            <button class="theme-toggle" title="Alternar tema">
              <i class="fas fa-moon"></i>
            </button>
            <div class="cart-icon" onclick="window.location.href='cart.php'" title="Ver carrinho">
              <i class="fas fa-shopping-cart"></i>
              <span class="cart-count" style="display: none;">0</span>
            </div>
    
            <div class="user-icon" onclick="window.location.href='profile.php'" title="Minha conta">
              <i class="fas fa-user"></i>
            </div>
    
            <button class="mobile-menu-toggle">
              <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>
    
    <main>
        <?php echo $content ?? ''; ?>
    </main>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>🗲 TechStore</h3>
                    <p class="text-muted" style="font-size: 0.875rem;">Sua loja online de confiança com os <br> melhores produtos em eletrônicos,<br> moda, casa e livros.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icons" title="GitHub">
                         <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="social-icons" title="LinkedIn">
                         <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="social-icons" title="Twitter">
                         <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icons" title="Instagram">
                         <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3><i class="fas fa-link"></i> Links Rápidos</h3>
                    <ul>
                        <li><a href="products.php"><i class="fas fa-box"></i> Produtos</a></li>
                        <li><a href="categories.php"><i class="fas fa-list"></i> Categorias</a></li>
                        <li><a href="offers.php"><i class="fas fa-tag"></i> Ofertas</a></li>
                        <li><a href="about.php"><i class="fas fa-info-circle"></i> Informações</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3><i class="fas fa-headset"></i> Suporte</h3>
                    <ul>
                        <li><a href="contact.php"><i class="fas fa-envelope"></i> Contato</a></li>
                        <li><a href="#"><i class="fas fa-question-circle"></i> FAQ</a></li>
                        <li><a href="#"><i class="fas fa-shipping-fast"></i> Envios</a></li>
                        <li><a href="#"><i class="fas fa-shield-alt"></i> Privacidade</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3><i class="fas fa-map-marker-alt"></i> Contacte-nos</h3>
                    <ul class="text-muted" style="font-size: 0.875rem;">
                        <li><a href="contact.php"><i class="fas fa-location-dot"></i> Vila das Aves, Portugal</a></li>
                        <li><a href="contact.php"><i class="fas fa-envelope"></i> contato@techstore.pt</a></li>
                        <li><a href="contact.php"><i class="fas fa-phone"></i> +351 123 456 789</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 TechStore. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    
    <script src="<?php echo BASE_URL; ?>js/main.js"></script>
</body>
</html>