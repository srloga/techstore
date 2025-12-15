<?php
require_once '../config_db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$db = Database::getInstance();

// Obter produtos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $params = [];
    
    // Filtros
    $where = "WHERE p.ativo = 1";
    
    if (isset($_GET['id'])) {
        $where .= " AND p.id = ?";
        $params[] = $_GET['id'];
    }
    
    if (isset($_GET['category'])) {
        $where .= " AND c.slug = ?";
        $params[] = $_GET['category'];
    }
    
    if (isset($_GET['featured']) && $_GET['featured'] === 'true') {
        $where .= " AND p.destaque = 1";
    }
    
    if (isset($_GET['offers']) && $_GET['offers'] === 'true') {
        $where .= " AND p.promocao = 1 AND p.preco_antigo IS NOT NULL";
    }
    
    if (isset($_GET['new']) && $_GET['new'] === 'true') {
        $where .= " AND p.novo = 1";
    }
    
    if (isset($_GET['search'])) {
        $where .= " AND (p.nome LIKE ? OR p.descricao LIKE ?)";
        $search = "%" . $_GET['search'] . "%";
        $params[] = $search;
        $params[] = $search;
    }
    
    // Ordenação
    $order = "ORDER BY ";
    if (isset($_GET['sort'])) {
        switch ($_GET['sort']) {
            case 'price-low':
                $order .= "p.preco ASC";
                break;
            case 'price-high':
                $order .= "p.preco DESC";
                break;
            case 'rating':
                $order .= "p.rating DESC";
                break;
            case 'newest':
                $order .= "p.created_at DESC";
                break;
            default:
                $order .= "p.destaque DESC, p.created_at DESC";
        }
    } else {
        $order .= "p.destaque DESC, p.created_at DESC";
    }
    
    // Limite
    $limit = "";
    if (isset($_GET['limit'])) {
        $limit = "LIMIT " . intval($_GET['limit']);
    }
    
    // Query
    $sql = "SELECT 
                p.id,
                p.nome,
                p.descricao,
                p.preco,
                p.preco_antigo,
                COALESCE(p.imagem_principal, '') as image,
                p.rating,
                p.estoque,
                p.destaque as isFeatured,
                p.promocao as isSale,
                p.novo as isNew,
                p.slug,
                c.nome as category,
                c.icone as category_icon
            FROM produtos p
            LEFT JOIN categorias c ON p.categoria_id = c.id
            $where
            $order
            $limit";
    
    $products = $db->select($sql, $params);
    
    // Garantir que todos produtos tenham imagem
    $defaultImages = [
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1620641788421-7a1c342a42fd?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1579829365928-5d2f6e4c2f17?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1527814050087-3793815479db?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1591483460721-9de9c0b86c9a?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=600&auto=format&fit=crop&q=80'
    ];
    
    foreach ($products as &$product) {
        if (empty($product['image']) || !filter_var($product['image'], FILTER_VALIDATE_URL)) {
            $product['image'] = $defaultImages[$product['id'] % count($defaultImages)];
        }
        
        // Formatar campos
        $product['price'] = floatval($product['preco']);
        $product['oldPrice'] = $product['preco_antigo'] ? floatval($product['preco_antigo']) : null;
        $product['name'] = $product['nome'];
        
        // Remover campos antigos
        unset($product['preco'], $product['preco_antigo'], $product['nome']);
    }
    
    echo json_encode([
        'success' => true,
        'total' => count($products),
        'products' => $products
    ]);
    exit;
}
?>