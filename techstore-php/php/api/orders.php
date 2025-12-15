<?php
header('Content-Type: application/json');
require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (!isLoggedIn()) {
        jsonResponse(['success' => false, 'message' => 'Você precisa estar logado'], 401);
    }
    
    $orders = json_decode(file_get_contents(ORDERS_FILE), true) ?? [];
    $userId = $_SESSION['user_id'];
    
    // Filtrar pedidos do usuário
    $userOrders = array_filter($orders, function($order) use ($userId) {
        return $order['userId'] === $userId;
    });
    
    jsonResponse(['success' => true, 'orders' => array_values($userOrders)]);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;
    
    if ($action === 'create') {
        if (!isLoggedIn()) {
            jsonResponse(['success' => false, 'message' => 'Você precisa estar logado'], 401);
        }
        
        $items = $data['items'] ?? [];
        $shippingInfo = $data['shippingInfo'] ?? [];
        $paymentMethod = $data['paymentMethod'] ?? null;
        
        if (empty($items) || empty($shippingInfo) || !$paymentMethod) {
            jsonResponse(['success' => false, 'message' => 'Dados incompletos'], 400);
        }
        
        // Calcular total
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Adicionar taxa de envio
        $shippingCost = $total > 50 ? 0 : 5.99;
        $total += $shippingCost;
        
        // Criar pedido
        $order = [
            'id' => 'TS' . strtoupper(uniqid()),
            'userId' => $_SESSION['user_id'],
            'items' => $items,
            'shippingInfo' => $shippingInfo,
            'paymentMethod' => $paymentMethod,
            'subtotal' => $total - $shippingCost,
            'shippingCost' => $shippingCost,
            'total' => $total,
            'status' => 'pending',
            'createdAt' => date('Y-m-d H:i:s'),
            'updatedAt' => date('Y-m-d H:i:s')
        ];
        
        // Salvar pedido
        $orders = json_decode(file_get_contents(ORDERS_FILE), true) ?? [];
        $orders[] = $order;
        file_put_contents(ORDERS_FILE, json_encode($orders, JSON_PRETTY_PRINT));
        
        jsonResponse(['success' => true, 'message' => 'Pedido criado com sucesso!', 'order' => $order]);
    }
}
?>
