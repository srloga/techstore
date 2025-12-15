<?php
header('Content-Type: application/json');
require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$userId = $_SESSION['user_id'] ?? 'guest_' . md5($_SERVER['REMOTE_ADDR']);

// Arquivo da wishlist do usuário
$userWishlistFile = __DIR__ . '/../../data/wishlist_' . $userId . '.json';

function getUserWishlist() {
    global $userWishlistFile;
    if (!file_exists($userWishlistFile)) {
        return [];
    }
    return json_decode(file_get_contents($userWishlistFile), true) ?? [];
}

function saveUserWishlist($wishlist) {
    global $userWishlistFile;
    file_put_contents($userWishlistFile, json_encode($wishlist, JSON_PRETTY_PRINT));
}

if ($method === 'GET') {
    $wishlist = getUserWishlist();
    jsonResponse(['success' => true, 'items' => $wishlist]);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;
    
    if (!$action) {
        jsonResponse(['success' => false, 'message' => 'Ação não especificada'], 400);
    }
    
    $wishlist = getUserWishlist();
    
    switch($action) {
        case 'add':
            $productId = $data['productId'] ?? null;
            
            if (!$productId) {
                jsonResponse(['success' => false, 'message' => 'ID do produto não fornecido'], 400);
            }
            
            $product = getProductById($productId);
            if (!$product) {
                jsonResponse(['success' => false, 'message' => 'Produto não encontrado'], 404);
            }
            
            // Verificar se já existe na wishlist
            $exists = false;
            foreach ($wishlist as $item) {
                if ($item['id'] === $productId) {
                    $exists = true;
                    break;
                }
            }
            
            if (!$exists) {
                $wishlist[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'addedAt' => date('Y-m-d H:i:s')
                ];
            }
            
            saveUserWishlist($wishlist);
            jsonResponse(['success' => true, 'message' => 'Produto adicionado aos favoritos']);
            break;
            
        case 'remove':
            $productId = $data['productId'] ?? null;
            
            if (!$productId) {
                jsonResponse(['success' => false, 'message' => 'ID do produto não fornecido'], 400);
            }
            
            $wishlist = array_filter($wishlist, function($item) use ($productId) {
                return $item['id'] !== $productId;
            });
            
            saveUserWishlist(array_values($wishlist));
            jsonResponse(['success' => true, 'message' => 'Produto removido dos favoritos']);
            break;
            
        default:
            jsonResponse(['success' => false, 'message' => 'Ação inválida'], 400);
    }
}
?>
