<?php
header('Content-Type: application/json');
require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$userId = $_SESSION['user_id'] ?? 'guest_' . md5($_SERVER['REMOTE_ADDR']);

// Arquivo do carrinho do usuário
$userCartFile = __DIR__ . '/../../data/cart_' . $userId . '.json';

function getUserCart() {
    global $userCartFile;
    if (!file_exists($userCartFile)) {
        return [];
    }
    return json_decode(file_get_contents($userCartFile), true) ?? [];
}

function saveUserCart($cart) {
    global $userCartFile;
    file_put_contents($userCartFile, json_encode($cart, JSON_PRETTY_PRINT));
}

if ($method === 'GET') {
    $cart = getUserCart();
    jsonResponse(['success' => true, 'items' => $cart]);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;
    
    if (!$action) {
        jsonResponse(['success' => false, 'message' => 'Ação não especificada'], 400);
    }
    
    $cart = getUserCart();
    
    switch($action) {
        case 'add':
            $productId = $data['productId'] ?? null;
            $quantity = $data['quantity'] ?? 1;
            
            if (!$productId) {
                jsonResponse(['success' => false, 'message' => 'ID do produto não fornecido'], 400);
            }
            
            $product = getProductById($productId);
            if (!$product) {
                jsonResponse(['success' => false, 'message' => 'Produto não encontrado'], 404);
            }
            
            // Verificar se já existe no carrinho
            $found = false;
            foreach ($cart as &$item) {
                if ($item['id'] === $productId) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $cart[] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => $quantity
                ];
            }
            
            saveUserCart($cart);
            jsonResponse(['success' => true, 'message' => 'Produto adicionado ao carrinho']);
            break;
            
        case 'remove':
            $productId = $data['productId'] ?? null;
            
            if (!$productId) {
                jsonResponse(['success' => false, 'message' => 'ID do produto não fornecido'], 400);
            }
            
            $cart = array_filter($cart, function($item) use ($productId) {
                return $item['id'] !== $productId;
            });
            
            saveUserCart(array_values($cart));
            jsonResponse(['success' => true, 'message' => 'Produto removido do carrinho']);
            break;
            
        case 'update':
            $productId = $data['productId'] ?? null;
            $quantity = $data['quantity'] ?? 1;
            
            if (!$productId) {
                jsonResponse(['success' => false, 'message' => 'ID do produto não fornecido'], 400);
            }
            
            foreach ($cart as &$item) {
                if ($item['id'] === $productId) {
                    $item['quantity'] = max(1, $quantity);
                    break;
                }
            }
            
            saveUserCart($cart);
            jsonResponse(['success' => true, 'message' => 'Carrinho atualizado']);
            break;
            
        case 'clear':
            saveUserCart([]);
            jsonResponse(['success' => true, 'message' => 'Carrinho limpo']);
            break;
            
        default:
            jsonResponse(['success' => false, 'message' => 'Ação inválida'], 400);
    }
}
?>
