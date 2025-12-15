<?php
require_once 'config.php';

$pageTitle = "Produtos - TechStore";

// Obter parâmetros
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? 'newest';
$page = $_GET['page'] ?? 1;
$limit = 12;

// Buscar produtos
function getProducts($params = []) {
    $query = http_build_query($params);
    $url = BASE_URL . "php/api/products.php?" . $query;
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    return $data ?: ['products' => [], 'total' => 0];
}

// Buscar categorias
function getCategories() {
    $url = BASE_URL . "php/api/products.php?limit=100";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    $data = json_decode($response, true);
    $products = $data['products'] ?? [];
    
    $categories = [];
    foreach ($products as $product) {
        $cat = $product['category'] ?? 'Outros';
        if (!isset($categories[$cat])) {
            $categories[$cat] = 0;
        }
        $categories[$cat]++;
    }
    
    return $categories;
}

// Configurar parâmetros da busca
$params = [
    'limit' => $limit,
    'sort' => $sort
];

if ($category) {
    $params['category'] = $category;
}

if ($search) {
    $params['search'] = $search;
}

$result = getProducts($params);
$products = $result['products'];
$totalProducts = $result['total'];

$categories = getCategories();

ob_start();
?>

<!-- Hero Products -->
<section class="products-hero">
    <div class="container">
        <div class="hero-content">
            <h1>Catálogo <span class="highlight">Premium</span></h1>
            <p class="subtitle">Encontre os melhores produtos de tecnologia</p>
            
            <form class="search-bar-large" method="GET" action="">
                <div class="search-input">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                           placeholder="Buscar produtos...">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
                
                <?php if ($category): ?>
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                <?php endif; ?>
            </form>
            
            <div class="product-stats">
                <div class="stat">
                    <i class="fas fa-box"></i>
                    <span><?php echo $totalProducts; ?> Produtos</span>
                </div>
                <div class="stat">
                    <i class="fas fa-tags"></i>
                    <span><?php echo count($categories); ?> Categorias</span>
                </div>
                <div class="stat">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Entrega 24h</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Products Grid -->
<section class="products-main">
    <div class="container">
        <div class="products-layout">
            <!-- Sidebar de Filtros -->
            <aside class="products-sidebar">
                <div class="sidebar-section">
                    <h3><i class="fas fa-filter"></i> Filtros</h3>
                    
                    <div class="filter-group">
                        <h4>Categorias</h4>
                        <div class="filter-list">
                            <a href="products.php" class="filter-item <?php echo !$category ? 'active' : ''; ?>">
                                <span>Todas as Categorias</span>
                                <span class="count"><?php echo $totalProducts; ?></span>
                            </a>
                            <?php foreach ($categories as $catName => $count): ?>
                                <a href="products.php?category=<?php echo urlencode($catName); ?>" 
                                   class="filter-item <?php echo $category === $catName ? 'active' : ''; ?>">
                                    <span><?php echo htmlspecialchars($catName); ?></span>
                                    <span class="count"><?php echo $count; ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h4>Preço</h4>
                        <div class="price-range">
                            <input type="range" min="0" max="2000" value="1000" class="range-slider" id="price-range">
                            <div class="range-values">
                                <span id="min-price">€0</span>
                                <span id="max-price">€2000</span>
                            </div>
                            <button class="btn btn-small" onclick="filterByPrice()">
                                <i class="fas fa-check"></i> Aplicar
                            </button>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h4>Avaliação</h4>
                        <div class="rating-filter">
                            <label class="rating-option">
                                <input type="checkbox" onchange="filterByRating(5)">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star filled"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-text">5 estrelas</span>
                            </label>
                            <label class="rating-option">
                                <input type="checkbox" onchange="filterByRating(4)">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <i class="fas fa-star filled"></i>
                                    <?php endfor; ?>
                                    <i class="far fa-star"></i>
                                </div>
                                <span class="rating-text">4+ estrelas</span>
                            </label>
                            <label class="rating-option">
                                <input type="checkbox" onchange="filterByRating(3)">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 3; $i++): ?>
                                        <i class="fas fa-star filled"></i>
                                    <?php endfor; ?>
                                    <?php for ($i = 1; $i <= 2; $i++): ?>
                                        <i class="far fa-star"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-text">3+ estrelas</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <h4>Recursos</h4>
                        <div class="feature-filters">
                            <label class="feature-option">
                                <input type="checkbox" onchange="toggleFeature('promo')">
                                <span class="feature-label">
                                    <i class="fas fa-tag"></i> Em Promoção
                                </span>
                            </label>
                            <label class="feature-option">
                                <input type="checkbox" onchange="toggleFeature('new')">
                                <span class="feature-label">
                                    <i class="fas fa-star"></i> Produtos Novos
                                </span>
                            </label>
                            <label class="feature-option">
                                <input type="checkbox" onchange="toggleFeature('stock')">
                                <span class="feature-label">
                                    <i class="fas fa-check-circle"></i> Em Stock
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    <button class="btn btn-secondary btn-block" onclick="resetFilters()">
                        <i class="fas fa-redo"></i> Limpar Filtros
                    </button>
                </div>
                
                <div class="sidebar-banner">
                    <h4>Ofertas Especiais</h4>
                    <p>Até 50% OFF em selecionados</p>
                    <a href="offers.php" class="btn btn-primary btn-small">
                        <i class="fas fa-bolt"></i> Ver Ofertas
                    </a>
                </div>
            </aside>
            
            <!-- Conteúdo Principal -->
            <main class="products-content">
                <div class="products-header">
                    <div class="results-info">
                        <h2>
                            <?php if ($category): ?>
                                <?php echo htmlspecialchars($category); ?>
                            <?php elseif ($search): ?>
                                Resultados para "<?php echo htmlspecialchars($search); ?>"
                            <?php else: ?>
                                Todos os Produtos
                            <?php endif; ?>
                        </h2>
                        <p class="results-count">
                            Mostrando <span><?php echo count($products); ?></span> de 
                            <span><?php echo $totalProducts; ?></span> produtos
                        </p>
                    </div>
                    
                    <div class="sort-options">
                        <select class="sort-select" onchange="window.location.href = updateUrlParam('sort', this.value)">
                            <option value="newest" <?php echo $sort === 'newest' ? 'selected' : ''; ?>>Mais Recentes</option>
                            <option value="price-low" <?php echo $sort === 'price-low' ? 'selected' : ''; ?>>Preço: Baixo para Alto</option>
                            <option value="price-high" <?php echo $sort === 'price-high' ? 'selected' : ''; ?>>Preço: Alto para Baixo</option>
                            <option value="rating" <?php echo $sort === 'rating' ? 'selected' : ''; ?>>Melhor Avaliados</option>
                        </select>
                        
                        <div class="view-toggle">
                            <button class="view-btn active" data-view="grid">
                                <i class="fas fa-th"></i>
                            </button>
                            <button class="view-btn" data-view="list">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <?php if (empty($products)): ?>
                    <div class="no-products-found">
                        <div class="empty-state">
                            <i class="fas fa-search"></i>
                            <h3>Nenhum produto encontrado</h3>
                            <p>Tente ajustar seus filtros ou buscar por outro termo</p>
                            <a href="products.php" class="btn btn-primary">
                                <i class="fas fa-redo"></i> Limpar Filtros
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="products-grid" id="products-container" data-view="grid">
                        <?php foreach ($products as $product): ?>
                            <?php
                            $discount = $product['oldPrice'] ? 
                                round((($product['oldPrice'] - $product['price']) / $product['oldPrice']) * 100) : 0;
                            ?>
                            
                            <div class="product-item">
                                <div class="product-card">
                                    <!-- Badges -->
                                    <div class="product-flags">
                                        <?php if ($product['isSale']): ?>
                                            <span class="flag discount">
                                                <i class="fas fa-fire"></i> -<?php echo $discount; ?>%
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($product['isNew']): ?>
                                            <span class="flag new">
                                                <i class="fas fa-star"></i> NOVO
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($product['isFeatured']): ?>
                                            <span class="flag featured">
                                                <i class="fas fa-crown"></i> DESTAQUE
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Imagem -->
                                    <div class="product-image-wrapper">
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                                             class="product-image">
                                        <div class="image-overlay">
                                            <button class="btn-quick-view" data-product-id="<?php echo $product['id']; ?>">
                                                <i class="fas fa-eye"></i> Vista Rápida
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Informações -->
                                    <div class="product-info">
                                        <div class="category">
                                            <i class="<?php echo $product['category_icon'] ?? 'fas fa-box'; ?>"></i>
                                            <?php echo htmlspecialchars($product['category']); ?>
                                        </div>
                                        
                                        <h3 class="product-title">
                                            <a href="product-detail.php?id=<?php echo $product['id']; ?>">
                                                <?php echo htmlspecialchars($product['name']); ?>
                                            </a>
                                        </h3>
                                        
                                        <div class="product-rating">
                                            <div class="stars">
                                                <?php 
                                                $rating = $product['rating'];
                                                $fullStars = floor($rating);
                                                $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                                
                                                for ($i = 1; $i <= 5; $i++):
                                                    if ($i <= $fullStars): ?>
                                                        <i class="fas fa-star filled"></i>
                                                    <?php elseif ($hasHalfStar && $i == $fullStars + 1): ?>
                                                        <i class="fas fa-star-half-alt filled"></i>
                                                    <?php else: ?>
                                                        <i class="far fa-star"></i>
                                                    <?php endif;
                                                endfor; ?>
                                            </div>
                                            <span class="rating-value"><?php echo number_format($rating, 1); ?></span>
                                        </div>
                                        
                                        <div class="product-price">
                                            <span class="current">€<?php echo number_format($product['price'], 2, ',', '.'); ?></span>
                                            <?php if ($product['oldPrice']): ?>
                                                <span class="old">€<?php echo number_format($product['oldPrice'], 2, ',', '.'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="product-specs">
                                            <span class="spec">
                                                <i class="fas fa-shipping-fast"></i> Entrega 24h
                                            </span>
                                            <span class="spec">
                                                <i class="fas fa-shield-alt"></i> 3 anos
                                            </span>
                                        </div>
                                        
                                        <div class="product-actions">
                                            <button class="btn-add-cart" data-product-id="<?php echo $product['id']; ?>">
                                                <i class="fas fa-shopping-cart"></i>
                                                <span>Adicionar</span>
                                            </button>
                                            <button class="btn-wishlist" data-product-id="<?php echo $product['id']; ?>">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            <button class="btn-compare" data-product-id="<?php echo $product['id']; ?>">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Paginação -->
                    <?php if ($totalProducts > $limit): ?>
                        <div class="pagination">
                            <?php
                            $totalPages = ceil($totalProducts / $limit);
                            $visiblePages = 5;
                            $startPage = max(1, $page - floor($visiblePages / 2));
                            $endPage = min($totalPages, $startPage + $visiblePages - 1);
                            $startPage = max(1, $endPage - $visiblePages + 1);
                            ?>
                            
                            <?php if ($page > 1): ?>
                                <a href="<?php echo buildPageUrl($page - 1); ?>" class="page-item">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                                <a href="<?php echo buildPageUrl($i); ?>" 
                                   class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <a href="<?php echo buildPageUrl($page + 1); ?>" class="page-item">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                
                <!-- Comparação -->
                <div class="comparison-bar" id="comparison-bar">
                    <div class="comparison-content">
                        <h4>
                            <i class="fas fa-balance-scale"></i>
                            Comparação de Produtos
                            <span class="count">(<span id="compare-count">0</span>)</span>
                        </h4>
                        <div class="compare-items" id="compare-items"></div>
                        <div class="compare-actions">
                            <button class="btn btn-secondary" onclick="clearComparison()">
                                <i class="fas fa-trash"></i> Limpar
                            </button>
                            <button class="btn btn-primary" onclick="openComparison()">
                                <i class="fas fa-chart-bar"></i> Comparar
                            </button>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</section>

<!-- Quick View Modal -->
<div class="modal" id="quick-view-modal">
    <div class="modal-content">
        <button class="modal-close">
            <i class="fas fa-times"></i>
        </button>
        <div class="quick-view-content" id="quick-view-content">
            <!-- Carregado via JavaScript -->
        </div>
    </div>
</div>

<style>
    /* Products Hero */
    .products-hero {
        padding: 4rem 0;
        background: linear-gradient(135deg, var(--primary-light) 0%, transparent 100%);
        text-align: center;
    }
    
    .products-hero h1 {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .products-hero .subtitle {
        font-size: 1.25rem;
        color: var(--muted);
        margin-bottom: 2rem;
    }
    
    .search-bar-large {
        max-width: 600px;
        margin: 0 auto 3rem;
    }
    
    .search-input {
        display: flex;
        align-items: center;
        background: var(--card);
        border: 2px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 0.5rem;
        box-shadow: var(--shadow);
    }
    
    .search-input i {
        color: var(--muted);
        margin: 0 1rem;
        font-size: 1.25rem;
    }
    
    .search-input input {
        flex: 1;
        border: none;
        background: none;
        color: var(--foreground);
        font-size: 1rem;
        padding: 0.75rem 0;
    }
    
    .search-input input:focus {
        outline: none;
    }
    
    .product-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
    }
    
    .product-stats .stat {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.125rem;
    }
    
    .product-stats .stat i {
        color: var(--primary);
        font-size: 1.5rem;
    }
    
    /* Products Main */
    .products-main {
        padding: 3rem 0;
    }
    
    .products-layout {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 3rem;
    }
    
    @media (max-width: 992px) {
        .products-layout {
            grid-template-columns: 1fr;
        }
        
        .products-sidebar {
            display: none;
        }
    }
    
    /* Sidebar */
    .products-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }
    
    .sidebar-section {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .sidebar-section h3 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        color: var(--primary);
    }
    
    .filter-group {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }
    
    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .filter-group h4 {
        font-size: 0.875rem;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 1rem;
        letter-spacing: 0.05em;
    }
    
    .filter-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .filter-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        border-radius: var(--radius);
        text-decoration: none;
        color: var(--foreground);
        transition: all 0.3s;
    }
    
    .filter-item:hover,
    .filter-item.active {
        background: var(--primary-light);
        color: var(--primary);
    }
    
    .filter-item .count {
        font-size: 0.875rem;
        color: var(--muted);
        background: var(--border);
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        min-width: 30px;
        text-align: center;
    }
    
    .filter-item.active .count {
        background: var(--primary);
        color: var(--background);
    }
    
    .price-range {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .range-slider {
        width: 100%;
        height: 4px;
        -webkit-appearance: none;
        background: var(--border);
        border-radius: 2px;
        outline: none;
    }
    
    .range-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        background: var(--primary);
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid var(--background);
        box-shadow: var(--shadow);
    }
    
    .range-values {
        display: flex;
        justify-content: space-between;
        font-size: 0.875rem;
        color: var(--muted);
    }
    
    .rating-filter {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .rating-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: var(--radius);
        transition: background 0.3s;
    }
    
    .rating-option:hover {
        background: var(--border);
    }
    
    .rating-option input {
        display: none;
    }
    
    .rating-option .stars {
        display: flex;
        gap: 2px;
    }
    
    .rating-option .stars i {
        color: var(--muted);
        font-size: 0.875rem;
    }
    
    .rating-option .stars i.filled {
        color: #FFD700;
    }
    
    .rating-text {
        font-size: 0.875rem;
        color: var(--foreground);
    }
    
    .feature-filters {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .feature-option {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: var(--radius);
        transition: background 0.3s;
    }
    
    .feature-option:hover {
        background: var(--border);
    }
    
    .feature-option input {
        display: none;
    }
    
    .feature-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--foreground);
    }
    
    .feature-label i {
        color: var(--primary);
    }
    
    .btn-block {
        width: 100%;
        margin-top: 1rem;
    }
    
    .sidebar-banner {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 2rem;
        border-radius: var(--radius-lg);
        text-align: center;
    }
    
    .sidebar-banner h4 {
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
    }
    
    .sidebar-banner p {
        opacity: 0.9;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
    }
    
    /* Products Content */
    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .results-info h2 {
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
    }
    
    .results-count {
        color: var(--muted);
        font-size: 0.875rem;
    }
    
    .results-count span {
        font-weight: 600;
        color: var(--primary);
    }
    
    .sort-options {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .sort-select {
        padding: 0.75rem 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--card);
        color: var(--foreground);
        font-size: 0.875rem;
        cursor: pointer;
    }
    
    .view-toggle {
        display: flex;
        gap: 0.5rem;
        background: var(--border);
        padding: 0.25rem;
        border-radius: var(--radius);
    }
    
    .view-btn {
        width: 40px;
        height: 40px;
        border: none;
        background: none;
        color: var(--muted);
        border-radius: var(--radius);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    
    .view-btn.active {
        background: var(--card);
        color: var(--primary);
        box-shadow: var(--shadow);
    }
    
    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .products-grid[data-view="list"] {
        grid-template-columns: 1fr;
    }
    
    .products-grid[data-view="list"] .product-item {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 2rem;
    }
    
    .product-item {
        transition: transform 0.3s;
    }
    
    .product-item:hover {
        transform: translateY(-5px);
    }
    
    .product-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        overflow: hidden;
        height: 100%;
        position: relative;
    }
    
    .products-grid[data-view="list"] .product-card {
        display: grid;
        grid-template-columns: 200px 1fr;
    }
    
    .product-flags {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .flag {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: white;
    }
    
    .flag.discount {
        background: linear-gradient(135deg, var(--danger), #ff6b6b);
    }
    
    .flag.new {
        background: linear-gradient(135deg, var(--success), #10b981);
    }
    
    .flag.featured {
        background: linear-gradient(135deg, var(--warning), #f59e0b);
    }
    
    .product-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
    }
    
    .products-grid[data-view="list"] .product-image-wrapper {
        height: 200px;
    }
    
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .product-card:hover .image-overlay {
        opacity: 1;
    }
    
    .btn-quick-view {
        background: var(--primary);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius);
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: transform 0.3s;
    }
    
    .btn-quick-view:hover {
        transform: scale(1.05);
    }
    
    .product-info {
        padding: 1.5rem;
    }
    
    .products-grid[data-view="list"] .product-info {
        padding: 2rem;
    }
    
    .category {
        font-size: 0.75rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .product-title {
        font-size: 1.125rem;
        margin-bottom: 1rem;
        line-height: 1.4;
    }
    
    .product-title a {
        color: var(--foreground);
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .product-title a:hover {
        color: var(--primary);
    }
    
    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .product-rating .stars {
        display: flex;
        gap: 2px;
    }
    
    .product-rating .stars i {
        font-size: 0.875rem;
    }
    
    .product-rating .stars i.filled {
        color: #FFD700;
    }
    
    .rating-value {
        font-size: 0.875rem;
        color: var(--muted);
    }
    
    .product-price {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .product-price .current {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
    }
    
    .product-price .old {
        font-size: 1rem;
        color: var(--muted);
        text-decoration: line-through;
    }
    
    .product-specs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .product-specs .spec {
        font-size: 0.75rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .product-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-add-cart {
        flex: 1;
        background: var(--primary);
        color: var(--background);
        border: none;
        padding: 0.75rem;
        border-radius: var(--radius);
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: background 0.3s;
    }
    
    .btn-add-cart:hover {
        background: var(--primary-dark);
    }
    
    .btn-wishlist,
    .btn-compare {
        width: 40px;
        height: 40px;
        border: 1px solid var(--border);
        background: var(--card);
        color: var(--foreground);
        border-radius: var(--radius);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    
    .btn-wishlist:hover,
    .btn-compare:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    /* Paginação */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin: 3rem 0;
    }
    
    .page-item {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        text-decoration: none;
        color: var(--foreground);
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .page-item:hover,
    .page-item.active {
        background: var(--primary);
        color: var(--background);
        border-color: var(--primary);
    }
    
    /* Comparison Bar */
    .comparison-bar {
        position: fixed;
        bottom: -100px;
        left: 0;
        right: 0;
        background: var(--card);
        border-top: 1px solid var(--border);
        box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
        padding: 1rem;
        transition: bottom 0.3s;
        z-index: 1000;
    }
    
    .comparison-bar.active {
        bottom: 0;
    }
    
    .comparison-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }
    
    .comparison-content h4 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }
    
    .comparison-content .count {
        color: var(--primary);
    }
    
    .compare-items {
        flex: 1;
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding: 0.5rem;
    }
    
    .compare-item {
        width: 60px;
        height: 60px;
        border-radius: var(--radius);
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
    }
    
    .compare-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .compare-item-remove {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        background: var(--danger);
        color: white;
        border-radius: 50%;
        border: none;
        font-size: 0.75rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .compare-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.8);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    
    .modal.active {
        display: flex;
    }
    
    .modal-content {
        background: var(--card);
        border-radius: var(--radius-lg);
        max-width: 900px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }
    
    .modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: var(--background);
        color: var(--foreground);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: all 0.3s;
    }
    
    .modal-close:hover {
        background: var(--primary);
        color: var(--background);
    }
    
    /* Empty State */
    .no-products-found {
        grid-column: 1 / -1;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state i {
        font-size: 4rem;
        color: var(--muted);
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        color: var(--muted);
        margin-bottom: 2rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<script>
    // Funções de utilidade
    function updateUrlParam(key, value) {
        const url = new URL(window.location.href);
        url.searchParams.set(key, value);
        return url.toString();
    }
    
    function buildPageUrl(page) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);
        return url.toString();
    }
    
    // Filtros
    function filterByPrice() {
        const range = document.getElementById('price-range');
        const maxPrice = range.value;
        const url = updateUrlParam('max_price', maxPrice);
        window.location.href = url;
    }
    
    function filterByRating(rating) {
        const url = updateUrlParam('min_rating', rating);
        window.location.href = url;
    }
    
    function toggleFeature(feature) {
        const url = new URL(window.location.href);
        const params = url.searchParams;
        
        if (params.has(feature)) {
            params.delete(feature);
        } else {
            params.set(feature, '1');
        }
        
        window.location.href = url.toString();
    }
    
    function resetFilters() {
        window.location.href = 'products.php';
    }
    
    // Sistema de comparação
    let comparisonProducts = JSON.parse(localStorage.getItem('techstore_comparison')) || [];
    
    function updateComparisonBar() {
        const bar = document.getElementById('comparison-bar');
        const count = document.getElementById('compare-count');
        const itemsContainer = document.getElementById('compare-items');
        
        if (comparisonProducts.length > 0) {
            bar.classList.add('active');
            count.textContent = comparisonProducts.length;
            
            itemsContainer.innerHTML = comparisonProducts.map(product => `
                <div class="compare-item">
                    <img src="${product.image}" alt="${product.name}">
                    <button class="compare-item-remove" onclick="removeFromComparison(${product.id})">
                        ×
                    </button>
                </div>
            `).join('');
        } else {
            bar.classList.remove('active');
        }
    }
    
    function addToComparison(productId) {
        // Buscar produto da API
        fetch(`php/api/products.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.product) {
                    const product = data.product;
                    
                    if (comparisonProducts.length >= 4) {
                        showNotification('Máximo de 4 produtos para comparação', 'warning');
                        return;
                    }
                    
                    if (!comparisonProducts.find(p => p.id === productId)) {
                        comparisonProducts.push({
                            id: product.id,
                            name: product.name,
                            image: product.image,
                            price: product.price
                        });
                        
                        localStorage.setItem('techstore_comparison', JSON.stringify(comparisonProducts));
                        updateComparisonBar();
                        showNotification('Produto adicionado à comparação', 'success');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Erro ao adicionar à comparação', 'error');
            });
    }
    
    function removeFromComparison(productId) {
        comparisonProducts = comparisonProducts.filter(p => p.id !== productId);
        localStorage.setItem('techstore_comparison', JSON.stringify(comparisonProducts));
        updateComparisonBar();
    }
    
    function clearComparison() {
        comparisonProducts = [];
        localStorage.removeItem('techstore_comparison');
        updateComparisonBar();
    }
    
    function openComparison() {
        // Implementar página de comparação
        showNotification('Página de comparação em desenvolvimento', 'info');
    }
    
    // Quick View
    const quickViewModal = document.getElementById('quick-view-modal');
    const quickViewContent = document.getElementById('quick-view-content');
    
    document.querySelectorAll('.btn-quick-view').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            openQuickView(productId);
        });
    });
    
    function openQuickView(productId) {
        fetch(`php/api/products.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.product) {
                    const product = data.product;
                    const discount = product.oldPrice ? 
                        Math.round(((product.oldPrice - product.price) / product.oldPrice) * 100) : 0;
                    
                    quickViewContent.innerHTML = `
                        <div class="quick-view-grid">
                            <div class="quick-view-images">
                                <div class="main-image">
                                    <img src="${product.image}" alt="${product.name}">
                                </div>
                            </div>
                            <div class="quick-view-details">
                                <h2>${product.name}</h2>
                                
                                <div class="quick-view-meta">
                                    <span class="category">
                                        <i class="${product.category_icon}"></i>
                                        ${product.category}
                                    </span>
                                    <span class="rating">
                                        <i class="fas fa-star"></i>
                                        ${product.rating}/5
                                    </span>
                                    <span class="stock">
                                        <i class="fas fa-check-circle"></i>
                                        Em stock
                                    </span>
                                </div>
                                
                                <div class="quick-view-price">
                                    <span class="current">€${product.price.toFixed(2)}</span>
                                    ${product.oldPrice ? `
                                        <span class="old">€${product.oldPrice.toFixed(2)}</span>
                                        <span class="discount">-${discount}%</span>
                                    ` : ''}
                                </div>
                                
                                <p class="description">${product.description || 'Produto de alta qualidade com tecnologia avançada.'}</p>
                                
                                <div class="quick-view-actions">
                                    <div class="quantity-selector">
                                        <button class="qty-btn minus">−</button>
                                        <input type="number" value="1" min="1" max="10" class="qty-input">
                                        <button class="qty-btn plus">+</button>
                                    </div>
                                    
                                    <button class="btn btn-primary btn-lg add-to-cart-btn" data-product-id="${product.id}">
                                        <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                                    </button>
                                    
                                    <button class="btn btn-secondary wishlist-btn" data-product-id="${product.id}">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    
                                    <button class="btn btn-secondary compare-btn" data-product-id="${product.id}">
                                        <i class="fas fa-balance-scale"></i>
                                    </button>
                                </div>
                                
                                <div class="quick-view-features">
                                    <div class="feature">
                                        <i class="fas fa-shipping-fast"></i>
                                        <span>Entrega em 24h</span>
                                    </div>
                                    <div class="feature">
                                        <i class="fas fa-shield-alt"></i>
                                        <span>Garantia 3 anos</span>
                                    </div>
                                    <div class="feature">
                                        <i class="fas fa-undo"></i>
                                        <span>Devolução em 30 dias</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    quickViewModal.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Erro ao carregar produto', 'error');
            });
    }
    
    // Fechar modal
    document.querySelector('.modal-close').addEventListener('click', function() {
        quickViewModal.classList.remove('active');
        document.body.style.overflow = 'auto';
    });
    
    // Fechar modal ao clicar fora
    quickViewModal.addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    });
    
    // Alternar visualização
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('products-container').dataset.view = view;
        });
    });
    
    // Inicializar
    document.addEventListener('DOMContentLoaded', function() {
        updateComparisonBar();
        
        // Configurar botões de comparação
        document.querySelectorAll('.btn-compare').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.productId;
                addToComparison(productId);
            });
        });
        
        // Configurar slider de preço
        const priceRange = document.getElementById('price-range');
        const minPrice = document.getElementById('min-price');
        const maxPrice = document.getElementById('max-price');
        
        if (priceRange) {
            priceRange.addEventListener('input', function() {
                maxPrice.textContent = '€' + this.value;
            });
        }
    });
</script>

<?php
$content = ob_get_clean();
include 'template.php';
?>
