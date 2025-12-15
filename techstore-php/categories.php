<?php
require_once 'config.php';

$pageTitle = "Categorias - TechStore";

// Buscar categorias do banco
function getCategoriesFromDB() {
    $url = BASE_URL . "php/api/categories.php";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    
    // Se a API não existir, usar dados estáticos
    if (!$data) {
        return [
            [
                'id' => 1,
                'nome' => 'Eletrônicos',
                'descricao' => 'Computadores, tablets e acessórios',
                'icone' => 'fas fa-laptop',
                'slug' => 'eletronicos',
                'produtos_count' => 150
            ],
            [
                'id' => 2,
                'nome' => 'Áudio',
                'descricao' => 'Fones, colunas e equipamentos',
                'icone' => 'fas fa-headphones',
                'slug' => 'audio',
                'produtos_count' => 85
            ],
            [
                'id' => 3,
                'nome' => 'Fotografia',
                'descricao' => 'Câmaras, lentes e acessórios',
                'icone' => 'fas fa-camera',
                'slug' => 'fotografia',
                'produtos_count' => 38
            ],
            [
                'id' => 4,
                'nome' => 'Wearables',
                'descricao' => 'Smartwatches e pulseiras',
                'icone' => 'fas fa-user-secret',
                'slug' => 'wearables',
                'produtos_count' => 52
            ],
            [
                'id' => 5,
                'nome' => 'Gaming',
                'descricao' => 'Consolas, periféricos e jogos',
                'icone' => 'fas fa-gamepad',
                'slug' => 'gaming',
                'produtos_count' => 120
            ],
            [
                'id' => 6,
                'nome' => 'Drones',
                'descricao' => 'Drones e acessórios',
                'icone' => 'fas fa-helicopter',
                'slug' => 'drones',
                'produtos_count' => 28
            ],
            [
                'id' => 7,
                'nome' => 'Iluminação',
                'descricao' => 'Luzes LED e acessórios',
                'icone' => 'fas fa-lightbulb',
                'slug' => 'iluminacao',
                'produtos_count' => 35
            ],
            [
                'id' => 8,
                'nome' => 'Acessórios',
                'descricao' => 'Cabos, carregadores e mais',
                'icone' => 'fas fa-plug',
                'slug' => 'acessorios',
                'produtos_count' => 156
            ],
            [
                'id' => 9,
                'nome' => 'Smartphones',
                'descricao' => 'Telemóveis e tablets',
                'icone' => 'fas fa-mobile-alt',
                'slug' => 'smartphones',
                'produtos_count' => 92
            ],
            [
                'id' => 10,
                'nome' => 'Casa Inteligente',
                'descricao' => 'IoT e automação residencial',
                'icone' => 'fas fa-home',
                'slug' => 'smart-home',
                'produtos_count' => 67
            ],
            [
                'id' => 11,
                'nome' => 'Realidade Virtual',
                'descricao' => 'VR e AR headsets',
                'icone' => 'fas fa-vr-cardboard',
                'slug' => 'vr-ar',
                'produtos_count' => 24
            ],
            [
                'id' => 12,
                'nome' => 'Armazenamento',
                'descricao' => 'Discos, SSDs e NAS',
                'icone' => 'fas fa-hdd',
                'slug' => 'armazenamento',
                'produtos_count' => 43
            ]
        ];
    }
    
    return $data['categories'] ?? [];
}

$categories = getCategoriesFromDB();

ob_start();
?>

<!-- Hero Categorias -->
<section class="categories-hero">
    <div class="container">
        <div class="hero-content">
            <h1>Explore por <span class="highlight">Categoria</span></h1>
            <p class="subtitle">
                Navegue por nossa seleção especializada de produtos de tecnologia
            </p>
            
            <div class="search-categories">
                <input type="text" id="category-search" placeholder="Buscar categoria...">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </div>
</section>

<!-- Categorias Grid -->
<section class="categories-grid-section">
    <div class="container">
        <div class="categories-header">
            <h2>
                Todas as Categorias
                <span class="count-badge"><?php echo count($categories); ?></span>
            </h2>
            
            <div class="filter-categories">
                <button class="filter-btn active" data-filter="all">Todas</button>
                <button class="filter-btn" data-filter="popular">Populares</button>
                <button class="filter-btn" data-filter="new">Novas</button>
                <button class="filter-btn" data-filter="sale">Em Promoção</button>
            </div>
        </div>
        
        <div class="categories-container" id="categories-container">
            <?php foreach ($categories as $category): ?>
                <a href="products.php?category=<?php echo urlencode($category['nome']); ?>" 
                   class="category-card-enhanced" 
                   data-category="<?php echo strtolower($category['nome']); ?>">
                    
                    <div class="category-header">
                        <div class="category-icon">
                            <i class="<?php echo $category['icone']; ?>"></i>
                        </div>
                        <span class="products-count">
                            <?php echo $category['produtos_count']; ?> produtos
                        </span>
                    </div>
                    
                    <div class="category-body">
                        <h3><?php echo htmlspecialchars($category['nome']); ?></h3>
                        <p class="category-description">
                            <?php echo htmlspecialchars($category['descricao']); ?>
                        </p>
                    </div>
                    
                    <div class="category-footer">
                        <span class="explore-link">
                            Explorar <i class="fas fa-arrow-right"></i>
                        </span>
                        <div class="trending">
                            <i class="fas fa-fire"></i>
                            <span>+<?php echo rand(5, 20); ?>% esta semana</span>
                        </div>
                    </div>
                    
                    <div class="category-hover-effect"></div>
                </a>
            <?php endforeach; ?>
        </div>
        
        <?php if (empty($categories)): ?>
            <div class="no-categories">
                <i class="fas fa-folder-open"></i>
                <h3>Nenhuma categoria encontrada</h3>
                <p>Em breve adicionaremos novas categorias</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Categorias em Destaque -->
<section class="featured-categories">
    <div class="container">
        <div class="section-header">
            <h2>
                Categorias <span class="highlight">Populares</span>
            </h2>
            <p class="section-subtitle">
                As categorias mais visitadas pelos nossos clientes
            </p>
        </div>
        
        <div class="featured-categories-slider">
            <?php 
            // Pegar as primeiras 6 categorias como populares
            $popularCategories = array_slice($categories, 0, 6);
            ?>
            
            <?php foreach ($popularCategories as $category): ?>
                <div class="featured-category-card">
                    <div class="category-badge">
                        <i class="fas fa-fire"></i> POPULAR
                    </div>
                    
                    <div class="category-visual">
                        <div class="visual-icon">
                            <i class="<?php echo $category['icone']; ?>"></i>
                        </div>
                        <div class="visual-image">
                            <img src="https://images.unsplash.com/<?php 
                                $images = [
                                    'photo-1496181133206-80ce9b88a853', // Laptop
                                    'photo-1505740420928-5e560c06d30e', // Headphones
                                    'photo-1516035069371-29a1b244cc32', // Camera
                                    'photo-1523275335684-37898b6baf30', // Smartwatch
                                    'photo-1534423861386-85a16f5d13fd', // Gamepad
                                    'photo-1521405924368-64c5b84bec60?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', // Drone
                                    'photo-1513506003901-1e6a229e2d15', // Light
                                    'photo-1526170375885-4d8ecf77b99f', // Cable
                                    'photo-1511707171634-5f897ff02aa9', // Phone
                                    'photo-1558618666-fcd25c85cd64', // Home
                                    'photo-1620641788421-7a1c342a42fd', // VR
                                    'photo-1591799264318-7e6ef8ddb7ea'  // Storage
                                ];
                                echo $images[($category['id'] - 1) % count($images)];
                            ?>?w=400&auto=format&fit=crop&q=80" 
                                 alt="<?php echo htmlspecialchars($category['nome']); ?>">
                        </div>
                    </div>
                    
                    <div class="category-info">
                        <h3><?php echo htmlspecialchars($category['nome']); ?></h3>
                        <p class="category-stats">
                            <span class="stat">
                                <i class="fas fa-box"></i>
                                <?php echo $category['produtos_count']; ?> produtos
                            </span>
                            <span class="stat">
                                <i class="fas fa-star"></i>
                                <?php echo rand(4, 5); ?>.<?php echo rand(0, 9); ?> avaliação
                            </span>
                        </p>
                        
                        <div class="category-actions">
                            <a href="products.php?category=<?php echo urlencode($category['nome']); ?>" 
                               class="btn btn-primary">
                                <i class="fas fa-shopping-bag"></i> Comprar Agora
                            </a>
                            <button class="btn btn-secondary follow-category" 
                                    data-category-id="<?php echo $category['id']; ?>">
                                <i class="far fa-bell"></i> Seguir
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Newsletter para Categorias -->
<section class="categories-newsletter">
    <div class="container">
        <div class="newsletter-card">
            <div class="newsletter-icon">
                <i class="fas fa-bell"></i>
            </div>
            <div class="newsletter-content">
                <h3>Receba Novidades por Categoria</h3>
                <p>Selecione suas categorias favoritas e receba ofertas personalizadas</p>
                
                <form class="category-preferences-form" id="category-preferences">
                    <div class="preferences-grid">
                        <?php foreach (array_slice($categories, 0, 8) as $category): ?>
                            <label class="preference-option">
                                <input type="checkbox" name="categories[]" value="<?php echo $category['id']; ?>">
                                <span class="checkmark"></span>
                                <span class="preference-label">
                                    <i class="<?php echo $category['icone']; ?>"></i>
                                    <?php echo htmlspecialchars($category['nome']); ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="preferences-actions">
                        <input type="email" placeholder="Seu email" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Ativar Notificações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Categorias -->
<section class="categories-faq">
    <div class="container">
        <div class="section-header">
            <h2>
                Dúvidas sobre <span class="highlight">Categorias</span>
            </h2>
        </div>
        
        <div class="faq-grid">
            <div class="faq-item">
                <h4>
                    <i class="fas fa-shopping-cart"></i>
                    Como escolher a categoria certa?
                </h4>
                <p>
                    Use nossa busca inteligente ou navegue pelas categorias principais. 
                    Cada categoria tem filtros específicos para ajudar na sua escolha.
                </p>
            </div>
            
            <div class="faq-item">
                <h4>
                    <i class="fas fa-sync-alt"></i>
                    Com que frequência atualizam as categorias?
                </h4>
                <p>
                    Atualizamos nosso catálogo semanalmente com novos produtos e 
                    categorias. Assine nossa newsletter para ser notificado.
                </p>
            </div>
            
            <!-- <div class="faq-item">
                <h4>
                    <i class="fas fa-tag"></i>
                    Todas as categorias têm promoções?
                </h4>
                <p>
                    Sim, todas as categorias possuem produtos em promoção regularmente. 
                    Verifique a seção "Ofertas" para os melhores descontos.
                </p>
            </div> -->
            
            <div class="faq-item">
                <h4>
                    <i class="fas fa-headset"></i>
                    Preciso de ajuda para escolher?
                </h4>
                <p>
                    Nossa equipe de especialistas está disponível 24/7 para ajudar na 
                    escolha do produto ideal para suas necessidades.
                </p>
            </div>
        </div>
    </div>
</section>

<style>
    /* Categories Hero */
    .categories-hero {
        padding: 4rem 0;
        background: linear-gradient(135deg, var(--primary-light) 0%, transparent 100%);
        text-align: center;
    }
    
    .categories-hero h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .categories-hero .subtitle {
        font-size: 1.25rem;
        color: var(--muted);
        margin-bottom: 2rem;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .search-categories {
        max-width: 500px;
        margin: 2rem auto 0;
        position: relative;
    }
    
    .search-categories input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 2px solid var(--border);
        border-radius: var(--radius-lg);
        background: var(--card);
        color: var(--foreground);
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .search-categories input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    
    .search-categories i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
    }
    
    /* Categories Grid Section */
    .categories-grid-section {
        padding: 3rem 0;
    }
    
    .categories-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 3rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .categories-header h2 {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 1.75rem;
    }
    
    .count-badge {
        background: var(--primary);
        color: var(--background);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .filter-categories {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .filter-btn {
        padding: 0.5rem 1.5rem;
        border: 1px solid var(--border);
        background: var(--card);
        color: var(--foreground);
        border-radius: 20px;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.3s;
    }
    
    .filter-btn:hover,
    .filter-btn.active {
        background: var(--primary);
        color: var(--background);
        border-color: var(--primary);
    }
    
    .categories-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .category-card-enhanced {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        text-decoration: none;
        color: var(--foreground);
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
        display: block;
    }
    
    .category-card-enhanced:hover {
        transform: translateY(-10px);
        border-color: var(--primary);
        box-shadow: var(--shadow-xl);
    }
    
    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    
    .category-icon {
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary);
    }
    
    .products-count {
        font-size: 0.75rem;
        color: var(--muted);
        background: var(--border);
        padding: 0.25rem 0.75rem;
        border-radius: 10px;
    }
    
    .category-body h3 {
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }
    
    .category-description {
        color: var(--muted);
        font-size: 0.875rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    .category-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.5rem;
        border-top: 1px solid var(--border);
    }
    
    .explore-link {
        color: var(--primary);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: gap 0.3s;
    }
    
    .category-card-enhanced:hover .explore-link {
        gap: 1rem;
    }
    
    .trending {
        font-size: 0.75rem;
        color: var(--success);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .category-hover-effect {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, 
            transparent, 
            rgba(255, 255, 255, 0.1), 
            transparent);
        transition: left 0.5s;
    }
    
    .category-card-enhanced:hover .category-hover-effect {
        left: 100%;
    }
    
    /* Featured Categories */
    .featured-categories {
        padding: 4rem 0;
        background: var(--background-secondary);
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
        max-width: 600px;
        margin: 0 auto;
    }
    
    .featured-categories-slider {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }
    
    .featured-category-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        position: relative;
        transition: transform 0.3s;
    }
    
    .featured-category-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-xl);
    }
    
    .category-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, var(--danger), #ff6b6b);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        z-index: 2;
    }
    
    .category-visual {
        height: 200px;
        position: relative;
        overflow: hidden;
    }
    
    .visual-icon {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 2;
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.9);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary);
    }
    
    .visual-image {
        width: 100%;
        height: 100%;
    }
    
    .visual-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .featured-category-card:hover .visual-image img {
        transform: scale(1.1);
    }
    
    .category-info {
        padding: 1.5rem;
    }
    
    .category-info h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .category-stats {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .category-stats .stat {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--muted);
    }
    
    .category-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .category-actions .btn {
        flex: 1;
    }
    
    .follow-category {
        width: 40px;
        padding: 0;
    }
    
    /* Categories Newsletter */
    .categories-newsletter {
        padding: 4rem 0;
    }
    
    .newsletter-card {
        background: linear-gradient(135deg, var(--card), var(--background-secondary));
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 3rem;
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 3rem;
        align-items: center;
        box-shadow: var(--shadow-lg);
    }
    
    @media (max-width: 768px) {
        .newsletter-card {
            grid-template-columns: 1fr;
            text-align: center;
        }
    }
    
    .newsletter-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: var(--primary);
    }
    
    .newsletter-content h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    
    .newsletter-content p {
        color: var(--muted);
        margin-bottom: 2rem;
    }
    
    .preferences-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .preference-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        padding: 0.75rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        transition: all 0.3s;
    }
    
    .preference-option:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }
    
    .preference-option input {
        display: none;
    }
    
    .checkmark {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border);
        border-radius: 4px;
        position: relative;
        transition: all 0.3s;
    }
    
    .preference-option input:checked + .checkmark {
        background: var(--primary);
        border-color: var(--primary);
    }
    
    .preference-option input:checked + .checkmark::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 0.75rem;
    }
    
    .preference-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .preferences-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .preferences-actions {
            flex-direction: column;
        }
    }
    
    .preferences-actions input {
        flex: 1;
        padding: 0.75rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--background);
        color: var(--foreground);
    }
    
    /* FAQ Categories */
    .categories-faq {
        padding: 4rem 0;
        background: var(--background-secondary);
    }
    
    .faq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .faq-item {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 2rem;
        transition: all 0.3s;
    }
    
    .faq-item:hover {
        border-color: var(--primary);
        transform: translateY(-5px);
    }
    
    .faq-item h4 {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: var(--primary);
    }
    
    .faq-item p {
        color: var(--muted);
        line-height: 1.6;
    }
    
    .no-categories {
        text-align: center;
        padding: 4rem 2rem;
        grid-column: 1 / -1;
    }
    
    .no-categories i {
        font-size: 4rem;
        color: var(--muted);
        margin-bottom: 1rem;
    }
    
    .no-categories h3 {
        margin-bottom: 0.5rem;
    }
    
    .no-categories p {
        color: var(--muted);
    }
</style>

<script>
    // Busca em tempo real
    document.getElementById('category-search').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const categories = document.querySelectorAll('.category-card-enhanced');
        
        categories.forEach(category => {
            const categoryName = category.querySelector('h3').textContent.toLowerCase();
            const categoryDesc = category.querySelector('.category-description').textContent.toLowerCase();
            
            if (categoryName.includes(searchTerm) || categoryDesc.includes(searchTerm)) {
                category.style.display = 'block';
            } else {
                category.style.display = 'none';
            }
        });
    });
    
    // Filtros
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remover active de todos
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            // Adicionar active ao clicado
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            filterCategories(filter);
        });
    });
    
    function filterCategories(filter) {
        const categories = document.querySelectorAll('.category-card-enhanced');
        
        categories.forEach(category => {
            const categoryName = category.dataset.category;
            
            switch(filter) {
                case 'all':
                    category.style.display = 'block';
                    break;
                case 'popular':
                    // Exibir categorias com mais de 50 produtos
                    const count = parseInt(category.querySelector('.products-count').textContent);
                    category.style.display = count > 50 ? 'block' : 'none';
                    break;
                case 'new':
                    // Exibir primeiras 4 categorias como "novas"
                    const index = Array.from(categories).indexOf(category);
                    category.style.display = index < 4 ? 'block' : 'none';
                    break;
                case 'sale':
                    // Exibir aleatoriamente algumas categorias
                    category.style.display = Math.random() > 0.5 ? 'block' : 'none';
                    break;
            }
        });
    }
    
    // Seguir categoria
    document.querySelectorAll('.follow-category').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const categoryId = this.dataset.categoryId;
            const icon = this.querySelector('i');
            
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.innerHTML = '<i class="fas fa-bell"></i> Seguindo';
                showNotification('Categoria seguida com sucesso!', 'success');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.innerHTML = '<i class="far fa-bell"></i> Seguir';
                showNotification('Categoria deixada de seguir', 'info');
            }
        });
    });
    
    // Formulário de preferências
    document.getElementById('category-preferences').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const email = this.querySelector('input[type="email"]').value;
        const selectedCategories = Array.from(this.querySelectorAll('input[type="checkbox"]:checked'))
            .map(cb => cb.value);
        
        if (selectedCategories.length === 0) {
            showNotification('Selecione pelo menos uma categoria', 'warning');
            return;
        }
        
        // Simular envio
        setTimeout(() => {
            showNotification('Preferências salvas com sucesso!', 'success');
            this.reset();
        }, 1000);
    });
    
    // Animação de entrada das categorias
    document.addEventListener('DOMContentLoaded', function() {
        const categories = document.querySelectorAll('.category-card-enhanced');
        
        categories.forEach((category, index) => {
            category.style.opacity = '0';
            category.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                category.style.transition = 'opacity 0.5s, transform 0.5s';
                category.style.opacity = '1';
                category.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

<?php
$content = ob_get_clean();
include 'template.php';
?>