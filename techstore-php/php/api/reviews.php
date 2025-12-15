<?php
header('Content-Type: application/json');
require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$productId = $_GET['productId'] ?? null;

$reviewsFile = __DIR__ . '/../../data/reviews.json';

function getReviews($productId = null) {
    global $reviewsFile;
    if (!file_exists($reviewsFile)) {
        return [];
    }
    
    $reviews = json_decode(file_get_contents($reviewsFile), true) ?? [];
    
    if ($productId) {
        $reviews = array_filter($reviews, function($review) use ($productId) {
            return $review['productId'] === (int)$productId;
        });
    }
    
    return array_values($reviews);
}

function saveReviews($reviews) {
    global $reviewsFile;
    file_put_contents($reviewsFile, json_encode($reviews, JSON_PRETTY_PRINT));
}

if ($method === 'GET') {
    if (!$productId) {
        jsonResponse(['success' => false, 'message' => 'ID do produto não fornecido'], 400);
    }
    
    $reviews = getReviews((int)$productId);
    jsonResponse(['success' => true, 'reviews' => $reviews, 'count' => count($reviews)]);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;
    
    if ($action === 'add') {
        if (!isLoggedIn()) {
            jsonResponse(['success' => false, 'message' => 'Você precisa estar logado'], 401);
        }
        
        $productId = $data['productId'] ?? null;
        $rating = $data['rating'] ?? null;
        $title = $data['title'] ?? null;
        $comment = $data['comment'] ?? null;
        
        if (!$productId || !$rating || !$title) {
            jsonResponse(['success' => false, 'message' => 'Dados incompletos'], 400);
        }
        
        if ($rating < 1 || $rating > 5) {
            jsonResponse(['success' => false, 'message' => 'Avaliação deve estar entre 1 e 5'], 400);
        }
        
        $user = getCurrentUser();
        
        $review = [
            'id' => uniqid('review_'),
            'productId' => (int)$productId,
            'userId' => $_SESSION['user_id'],
            'userName' => $user['name'],
            'rating' => (int)$rating,
            'title' => htmlspecialchars($title),
            'comment' => htmlspecialchars($comment),
            'createdAt' => date('Y-m-d H:i:s'),
            'helpful' => 0
        ];
        
        $reviews = getReviews();
        $reviews[] = $review;
        saveReviews($reviews);
        
        jsonResponse(['success' => true, 'message' => 'Avaliação adicionada com sucesso!', 'review' => $review]);
    }
}
?>
