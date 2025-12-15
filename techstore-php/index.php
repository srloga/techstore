<?php
require_once 'config.php';

$pageTitle = "TechStore - Tecnologia Premium";

// Buscar produtos em destaque
function getFeaturedProducts() {
    $url = BASE_URL . "php/api/products.php?featured=true&limit=6";
    $response = @file_get_contents($url);
    
    if ($response === FALSE) {
        return [];
    }
    
    $data = json_decode($response, true);
    return $data['products'] ?? [];
}

$featuredProducts = getFeaturedProducts();

ob_start();
?>

<!-- Hero Section Moderna -->
<section class="hero-premium">
    <div class="particles-container" id="particles-js"></div>
    
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badges">
                    <span class="badge badge-primary">
                        <i class="fas fa-bolt"></i> NOVA COLEÇÃO 2025
                    </span>
                    <span class="badge badge-success">
                        <i class="fas fa-truck"></i> ENVIO GRÁTIS +50€
                    </span>
                </div>
                
                <h1 class="hero-title">
                    <span>Tecnologia que</span><br>
                    <span class="highlight-gradient">Inspira</span> o
                    <span>Futuro</span>
                </h1>
                
                <p class="hero-subtitle">
                    Descubra gadgets inovadores e produtos premium selecionados para 
                    elevar seu estilo de vida digital.
                </p>
                
                <div class="hero-stats">
                    <div class="stat">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Produtos</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Clientes Satisfeitos</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">24h</div>
                        <div class="stat-label">Suporte</div>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="products.php" class="btn btn-primary btn-lg btn-glow">
                        <i class="fas fa-shopping-bag"></i> Explorar Loja
                    </a>
                    <a href="#featured" class="btn btn-secondary btn-lg">
                        <i class="fas fa-star"></i> Ver Destaques
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="floating-products">
                    <div class="product-float p1" style="--delay: 0s">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&auto=format&fit=crop&q=80" 
                             alt="Headphones">
                    </div>
                    <div class="product-float p2" style="--delay: 1s">
                        <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?w-300&auto=format&fit=crop&q=80" 
                             alt="Smartwatch">
                    </div>
                    <div class="product-float p3" style="--delay: 2s">
                        <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=300&auto=format&fit=crop&q=80" 
                             alt="Câmera">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="scroll-indicator">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- Categorias Destaque -->
<section class="categories-showcase">
    <div class="container">
        <div class="section-header">
            <h2>
                Explore por <span class="highlight">Categoria</span>
            </h2>
            <p class="section-subtitle">
                Navegue por nossas categorias especializadas
            </p>
        </div>
        
        <div class="categories-grid">
            <a href="products.php?category=eletronicos" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-tv"></i>
                </div>
                <h3>Eletrônicos</h3>
                <p class="category-count">150+ produtos</p>
                <div class="category-hover">
                    <span>Explorar <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <a href="products.php?category=audio" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-headphones"></i>
                </div>
                <h3>Áudio</h3>
                <p class="category-count">85+ produtos</p>
                <div class="category-hover">
                    <span>Explorar <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <a href="products.php?category=gaming" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <h3>Gaming</h3>
                <p class="category-count">120+ produtos</p>
                <div class="category-hover">
                    <span>Explorar <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
            
            <a href="products.php?category=wearables" class="category-card">
                <div class="category-icon">
                    <i class="fas fa-user-secret"></i>
                </div>
                <h3>Wearables</h3>
                <p class="category-count">65+ produtos</p>
                <div class="category-hover">
                    <span>Explorar <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- Produtos em Destaque -->
<section id="featured" class="featured-products">
    <div class="container">
        <div class="section-header">
            <div class="header-content">
                <h2>
                    Produtos em <span class="highlight">Destaque</span>
                </h2>
                <p class="section-subtitle">
                    Os mais vendidos e melhor avaliados
                </p>
            </div>
            <a href="products.php" class="view-all">
                Ver Todos <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="products-grid" id="featured-products">
            <?php if (!empty($featuredProducts)): ?>
                <?php foreach ($featuredProducts as $product): ?>
                    <?php
                    $discount = isset($product['oldPrice']) && $product['oldPrice'] ? 
                        round((($product['oldPrice'] - $product['price']) / $product['oldPrice']) * 100) : 0;
                    ?>
                    
                    <div class="product-card-premium">
                        <!-- Badges -->
                        <div class="product-badges">
                            <?php if (isset($product['isSale']) && $product['isSale']): ?>
                                <span class="badge badge-danger">
                                    <i class="fas fa-fire"></i> -<?php echo $discount; ?>%
                                </span>
                            <?php endif; ?>
                            <?php if (isset($product['isNew']) && $product['isNew']): ?>
                                <span class="badge badge-success">
                                    <i class="fas fa-star"></i> NOVO
                                </span>
                            <?php endif; ?>
                            <?php if (isset($product['isFeatured']) && $product['isFeatured']): ?>
                                <span class="badge badge-warning">
                                    <i class="fas fa-crown"></i> DESTAQUE
                                </span>
                            <?php endif; ?>
                        </div>                                            
                        <!-- Imagem -->
                        <div class="product-image-container">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                 class="product-image">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <i class="fas fa-box-open"></i>
                    <h3>Carregando produtos...</h3>
                    <p>Aguarde um momento</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Banner Promocional -->
<section class="promo-banner">
    <div class="container">
        <div class="banner-content">
            <div class="banner-text">
                <h2>Black Friday Tech</h2><br>
                <span class="banner-badge">
                    <i class="fas fa-gift"></i> OFERTA ESPECIAL
                </span>
                <p>Até 60% de desconto em produtos selecionados</p>
                <div class="countdown">
                    <div class="countdown-item">
                        <span class="number">05</span>
                        <span class="label">Dias</span>
                    </div>
                    <div class="countdown-item">
                        <span class="number">12</span>
                        <span class="label">Horas</span>
                    </div>
                    <div class="countdown-item">
                        <span class="number">45</span>
                        <span class="label">Minutos</span>
                    </div>
                    <div class="countdown-item">
                        <span class="number">30</span>
                        <span class="label">Segundos</span>
                    </div>
                </div>
                <a href="offers.php" class="btn btn-primary btn-lg">
                    <i>🗲</i> Ver Ofertas
                </a>
            </div>
            <div class="banner-image">
                <img src="https://images.unsplash.com/photo-1607082350899-7e105aa886ae?w=600&auto=format&fit=crop&q=80" 
                     alt="Black Friday">
            </div>
        </div>
    </div>
</section>

<!-- Por que Escolher a TechStore -->
<section class="why-choose-us">
    <div class="container">
        <div class="section-header">
            <h2>
                Por que escolher a <span class="highlight">TechStore?</span>
            </h2>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3>Envio Rápido</h3>
                <p>Entregas em 24-48h para Portugal Continental</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Garantia Extendida</h3>
                <p>3 anos de garantia em todos os produtos</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Suporte 24/7</h3>
                <p>Equipe especializada sempre disponível</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-undo"></i>
                </div>
                <h3>Devolução Fácil</h3>
                <p>30 dias para devolução sem complicações</p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Moderna -->
<section class="newsletter-modern">
    <div class="container">
        <div class="newsletter-wrapper">
            <div class="newsletter-content">
                <h2>
                    Não perca nada!
                </h2>
                <p>Inscreva-se para receber ofertas exclusivas e novidades</p>
                
                <form class="newsletter-form" id="newsletter-form">
                    <div class="input-group">
                        <input type="email" placeholder="seu@email.com" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Inscrever
                        </button>
                    </div>
                    <p class="disclaimer">
                        <i class="fas fa-lock"></i> Seus dados estão seguros conosco
                    </p>
                </form>
            </div>
            <div class="newsletter-image">
                <img src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?w=600&auto=format&fit=crop&q=80" 
                     alt="Newsletter">
            </div>
        </div>
    </div>
</section>

<!-- Marca Carousel -->
<section class="brands-showcase">
    <div class="container">
        <div class="brands-carousel">
            <div class="brand-item">
                <i class="fab fa-apple"></i>
                <span>Apple</span>
            </div>
            <div class="brand-item">
                <i class="fas fa-gamepad"></i>
                <span>PlayStation</span>
            </div>
            <div class="brand-item">
                <i class="fab fa-windows"></i>
                <span>Microsoft</span>
            </div>
            <div class="brand-item">
                <i class="fab fa-google"></i>
                <span>Google</span>
            </div>
            <div class="brand-item">
                <i class="fab fa-android"></i>
                <span>Samsung</span>
            </div>
            <div class="brand-item">
                <i class="fas fa-headphones"></i>
                <span>Sony</span>
            </div>
        </div>
    </div>
</section>

<style>
    /* Hero Premium */
    .hero-premium {
        padding: 6rem 0 4rem;
        background: linear-gradient(135deg, 
            var(--background) 0%, 
            var(--background-secondary) 100%);
        position: relative;
        overflow: hidden;
    }
    
    .particles-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    
    .hero-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    
    @media (min-width: 992px) {
        .hero-content {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .hero-badges {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
    }
    
    .highlight-gradient {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .typewriter-text {
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        animation: typing 3.5s steps(40, end);
    }
    
    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--muted);
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin: 2rem 0;
    }
    
    .stat {
        text-align: center;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: var(--muted);
    }
    
    .hero-actions {
        display: flex;
        gap: 1rem;
        margin: 2rem 0;
        flex-wrap: wrap;
    }
    
    .btn-glow {
        box-shadow: 0 0 20px var(--primary-glow);
        animation: pulse 2s infinite;
    }
    
    .theme-selector {
        margin-top: 2rem;
    }
    
    .theme-selector small {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--muted);
    }
    
    .theme-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .theme-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: var(--card);
        color: var(--foreground);
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .theme-btn:hover {
        transform: translateY(-2px);
        border-color: var(--primary);
    }
    
    .floating-products {
        position: relative;
        height: 400px;
    }
    
    .product-float {
        position: absolute;
        width: 150px;
        height: 150px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
        animation: float 6s ease-in-out infinite;
        animation-delay: var(--delay);
    }
    
    .product-float img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .p1 {
        top: 0;
        left: 20%;
        transform: rotate(-5deg);
    }
    
    .p2 {
        top: 30%;
        right: 10%;
        transform: rotate(5deg);
    }
    
    .p3 {
        bottom: 0;
        left: 40%;
        transform: rotate(-3deg);
    }
    
    .scroll-indicator {
        position: absolute;
        bottom: 2rem;
        left: 50%;
        transform: translateX(-50%);
        animation: bounce 2s infinite;
        color: var(--primary);
        font-size: 1.5rem;
    }
    
    /* Categories Showcase */
    .categories-showcase {
        padding: 4rem 0;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .section-header h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .section-subtitle {
        color: var(--muted);
        font-size: 1.125rem;
    }
    
    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }
    
    .category-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        text-align: center;
        text-decoration: none;
        color: var(--foreground);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }
    
    .category-card:hover {
        transform: translateY(-10px);
        border-color: var(--primary);
        box-shadow: var(--shadow-lg);
    }
    
    .category-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--primary);
    }
    
    .category-card h3 {
        margin-bottom: 0.5rem;
    }
    
    .category-count {
        color: var(--muted);
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .category-hover {
        position: absolute;
        bottom: -50px;
        left: 0;
        right: 0;
        background: var(--primary);
        color: var(--background);
        padding: 1rem;
        transition: bottom 0.3s;
    }
    
    .category-card:hover .category-hover {
        bottom: 0;
    }
    
    /* Featured Products */
    .featured-products {
        padding: 4rem 0;
        background: var(--background-secondary);
    }
    
    .featured-products .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: left;
        margin-bottom: 2rem;
    }
    
    .view-all {
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: gap 0.3s;
    }
    
    .view-all:hover {
        gap: 1rem;
    }
    
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .product-card-premium {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: all 0.3s;
    }
    
    .product-card-premium:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-xl);
    }
    
    .product-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .product-image-container {
        position: relative;
        overflow: hidden;
        height: 150px;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .product-card-premium:hover .product-image {
        transform: scale(1.05);
    }
    
    .product-card-premium:hover{
        opacity: 1;
    }
    
    .stars {
        display: flex;
        align-items: center;
        gap: 2px;
        margin-bottom: 1rem;
    }
    
    .stars .fa-star {
        color: var(--muted);
    }
    
    .stars .fa-star.filled {
        color: #FFD700;
    }
    
    .rating-value {
        margin-left: 0.5rem;
        font-size: 0.875rem;
        color: var(--muted);
    }
    
    /* Promo Banner */
    .promo-banner {
        padding: 5rem 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .banner-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        align-items: center;
    }
    
    @media (min-width: 768px) {
        .banner-content {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .banner-badge {
        background: rgba(255,255,255,0.2);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .banner-text h2 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .banner-text p {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }
    
    .countdown {
        display: flex;
        gap: 1rem;
        margin: 2rem 0;
    }
    
    .countdown-item {
        background: rgba(255,255,255,0.1);
        padding: 1rem;
        border-radius: var(--radius);
        text-align: center;
        min-width: 70px;
        backdrop-filter: blur(10px);
    }
    
    .countdown-item .number {
        font-size: 1.5rem;
        font-weight: 700;
        display: block;
    }
    
    .countdown-item .label {
        font-size: 0.75rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .banner-image img {
        width: 100%;
        border-radius: var(--radius-lg);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }
    
    /* Why Choose Us */
    .why-choose-us {
        padding: 4rem 0;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
    }
    
    .feature-card {
        text-align: center;
        padding: 2rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        transition: all 0.3s;
    }
    
    .feature-card:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 1.5rem;
        color: var(--primary);
    }
    
    .feature-card h3 {
        margin-bottom: 0.5rem;
    }
    
    .feature-card p {
        color: var(--muted);
        font-size: 0.875rem;
    }
    
    /* Newsletter Modern */
    .newsletter-modern {
        padding: 4rem 0;
        background: var(--background-secondary);
    }
    
    .newsletter-wrapper {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 3rem;
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        align-items: center;
    }
    
    @media (min-width: 768px) {
        .newsletter-wrapper {
            grid-template-columns: 2fr 1fr;
        }
    }
    
    .newsletter-content h2 {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }
    
    .newsletter-content p {
        color: var(--muted);
        margin-bottom: 2rem;
        font-size: 1.125rem;
    }
    
    .input-group {
        display: flex;
        gap: 0.5rem;
        max-width: 500px;
    }
    
    .input-group input {
        flex: 1;
        padding: 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--background);
        color: var(--foreground);
    }
    
    .disclaimer {
        margin-top: 1rem;
        font-size: 0.875rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .newsletter-image img {
        width: 100%;
        border-radius: var(--radius);
    }
    
    /* Brands Showcase */
    .brands-showcase {
        padding: 3rem 0;
        background: var(--card);
    }
    
    .brands-carousel {
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }
    
    .brand-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: var(--muted);
        transition: color 0.3s;
    }
    
    .brand-item:hover {
        color: var(--primary);
    }
    
    .brand-item i {
        font-size: 2rem;
    }
    
    .brand-item span {
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    /* Animations */
    @keyframes typing {
        from { width: 0 }
        to { width: 100% }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(var(--rotation));
        }
        50% {
            transform: translateY(-20px) rotate(calc(var(--rotation) + 5deg));
        }
    }
    
    @keyframes bounce {
        0%, 100% {
            transform: translateX(-50%) translateY(0);
        }
        50% {
            transform: translateX(-50%) translateY(-10px);
        }
    }
    
    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 20px var(--primary-glow);
        }
        50% {
            box-shadow: 0 0 40px var(--primary-glow);
        }
    }
    
    .no-products {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem;
    }
    
    .no-products i {
        font-size: 3rem;
        color: var(--muted);
        margin-bottom: 1rem;
    }
</style>

<script>
    // Inicializar quando a página carregar
    document.addEventListener('DOMContentLoaded', function() {
        // Configurar botões de tema
        document.querySelectorAll('.theme-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const theme = this.dataset.theme;
                applyTheme(theme);
                
                // Atualizar ícone
                const icon = this.querySelector('i');
                if (theme === 'dark') icon.className = 'fas fa-moon';
                if (theme === 'light') icon.className = 'fas fa-sun';
                if (theme === 'blue') icon.className = 'fas fa-water';
                if (theme === 'purple') icon.className = 'fas fa-palette';
                
                showNotification(`Tema ${theme} aplicado!`, 'success');
            });
        });
        
        // Contador regressivo
        function updateCountdown() {
            const now = new Date();
            const target = new Date(now);
            target.setDate(now.getDate() + 5);
            
            const diff = target - now;
            
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            document.querySelectorAll('.countdown-item .number').forEach((el, index) => {
                if (index === 0) el.textContent = days.toString().padStart(2, '0');
                if (index === 1) el.textContent = hours.toString().padStart(2, '0');
                if (index === 2) el.textContent = minutes.toString().padStart(2, '0');
                if (index === 3) el.textContent = seconds.toString().padStart(2, '0');
            });
        }
        
        setInterval(updateCountdown, 1000);
        updateCountdown();
        
        // Newsletter
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            fetch('php/api/newsletter.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    action: 'subscribe'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Inscrito com sucesso!', 'success');
                    this.reset();
                } else {
                    showNotification(data.message || 'Erro ao inscrever', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Erro ao inscrever', 'error');
            });
        });
        
        // Adicionar efeitos de hover nos produtos
        document.querySelectorAll('.product-card-premium').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Botão scroll suave
        document.querySelector('.scroll-indicator').addEventListener('click', function() {
            window.scrollTo({
                top: window.innerHeight,
                behavior: 'smooth'
            });
        });
        
        // Inicializar partículas
        initParticles();
    });
    
    function initParticles() {
        const container = document.querySelector('.particles-container');
        if (!container) return;
        
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            
            // Posição aleatória
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            
            // Tamanho aleatório
            const size = Math.random() * 4 + 1;
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            
            // Opacidade aleatória
            particle.style.opacity = Math.random() * 0.5 + 0.1;
            
            // Animação
            const duration = Math.random() * 20 + 10;
            particle.style.animation = `float ${duration}s linear infinite`;
            
            container.appendChild(particle);
        }
    }
    
    // Adicionar CSS para partículas
    const particlesCSS = `
        .particle {
            position: absolute;
            background: var(--primary);
            border-radius: 50%;
            pointer-events: none;
        }
        
        @keyframes float {
            0% {
                transform: translateY(0) translateX(0);
            }
            100% {
                transform: translateY(-100vh) translateX(100px);
            }
        }
    `;
    
    const style = document.createElement('style');
    style.textContent = particlesCSS;
    document.head.appendChild(style);

    
</script>

<?php
$content = ob_get_clean();
include 'template.php';
?>
