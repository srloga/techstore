<?php
// Configuração do TechStore
session_start();

// Definir timezone
date_default_timezone_set('Europe/Lisbon');

// Configurações de banco de dados (simulado com arquivo JSON)
define('DB_FILE', __DIR__ . '/../data/database.json');
define('USERS_FILE', __DIR__ . '/../data/users.json');
define('ORDERS_FILE', __DIR__ . '/../data/orders.json');
define('CART_FILE', __DIR__ . '/../data/cart.json');
define('WISHLIST_FILE', __DIR__ . '/../data/wishlist.json');

// Criar diretório de dados se não existir
if (!file_exists(__DIR__ . '/../data')) {
    mkdir(__DIR__ . '/../data', 0755, true);
}

// Inicializar arquivos de dados
function initializeDatabase() {
    // Produtos
    if (!file_exists(DB_FILE)) {
        $products = [
            [
                'id' => 1,
                'name' => 'Headphones Premium Wireless Noise Cancelling',
                'price' => 299.99,
                'oldPrice' => 349.99,
                'image' => '/images/headphones.jpg',
                'category' => 'Áudio',
                'rating' => 4.8,
                'isSale' => true,
                'description' => 'Headphones premium com cancelamento de ruído ativo'
            ],
            [
                'id' => 2,
                'name' => 'Smartwatch Series 7 Pro Edition',
                'price' => 399.00,
                'image' => '/images/smartwatch.jpg',
                'category' => 'Wearables',
                'rating' => 4.9,
                'isNew' => true,
                'description' => 'Smartwatch com tela AMOLED e bateria de 7 dias'
            ],
            [
                'id' => 3,
                'name' => 'Câmera Mirrorless 4K Professional',
                'price' => 1299.00,
                'oldPrice' => 1499.00,
                'image' => '/images/camera.jpg',
                'category' => 'Fotografia',
                'rating' => 4.7,
                'isSale' => true,
                'description' => 'Câmera mirrorless profissional com gravação 4K'
            ],
            [
                'id' => 4,
                'name' => 'Laptop Ultra Slim Developer Edition',
                'price' => 1899.00,
                'image' => '/images/laptop.jpg',
                'category' => 'Computadores',
                'rating' => 5.0,
                'isNew' => true,
                'description' => 'Laptop ultraslim com processador de última geração'
            ],
            [
                'id' => 5,
                'name' => 'VR Headset Pro X',
                'price' => 599.00,
                'image' => '/images/vr-headset.jpg',
                'category' => 'Gaming',
                'rating' => 4.6,
                'description' => 'Headset VR de realidade virtual com resolução 4K'
            ],
            [
                'id' => 6,
                'name' => 'Drone 4K Professional',
                'price' => 799.00,
                'image' => '/images/drone.jpg',
                'category' => 'Drones',
                'rating' => 4.5,
                'description' => 'Drone profissional com câmera 4K e bateria de 30 minutos'
            ]
        ];
        file_put_contents(DB_FILE, json_encode($products, JSON_PRETTY_PRINT));
    }
    
    // Usuários
    if (!file_exists(USERS_FILE)) {
        file_put_contents(USERS_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
    
    // Pedidos
    if (!file_exists(ORDERS_FILE)) {
        file_put_contents(ORDERS_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
    
    // Carrinho
    if (!file_exists(CART_FILE)) {
        file_put_contents(CART_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
    
    // Wishlist
    if (!file_exists(WISHLIST_FILE)) {
        file_put_contents(WISHLIST_FILE, json_encode([], JSON_PRETTY_PRINT));
    }
}

initializeDatabase();

// Funções auxiliares
function getProducts() {
    $data = file_get_contents(DB_FILE);
    return json_decode($data, true) ?? [];
}

function getProductById($id) {
    $products = getProducts();
    foreach ($products as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    return null;
}

function getUsers() {
    $data = file_get_contents(USERS_FILE);
    return json_decode($data, true) ?? [];
}

function getUserByEmail($email) {
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return $user;
        }
    }
    return null;
}

function saveUser($user) {
    $users = getUsers();
    $users[] = $user;
    file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if (!isLoggedIn()) {
        return null;
    }
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['id'] === $_SESSION['user_id']) {
            return $user;
        }
    }
    return null;
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
?>
