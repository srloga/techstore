<?php
header('Content-Type: application/json');
require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'] ?? null;
    
    if (!$email) {
        jsonResponse(['success' => false, 'message' => 'Email não fornecido'], 400);
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse(['success' => false, 'message' => 'Email inválido'], 400);
    }
    
    // Arquivo de newsletter
    $newsletterFile = __DIR__ . '/../../data/newsletter.json';
    
    if (!file_exists($newsletterFile)) {
        file_put_contents($newsletterFile, json_encode([], JSON_PRETTY_PRINT));
    }
    
    $subscribers = json_decode(file_get_contents($newsletterFile), true) ?? [];
    
    // Verificar se já está inscrito
    foreach ($subscribers as $subscriber) {
        if ($subscriber['email'] === $email) {
            jsonResponse(['success' => false, 'message' => 'Este email já está inscrito'], 400);
        }
    }
    
    // Adicionar novo inscrito
    $subscribers[] = [
        'email' => htmlspecialchars($email),
        'subscribedAt' => date('Y-m-d H:i:s')
    ];
    
    file_put_contents($newsletterFile, json_encode($subscribers, JSON_PRETTY_PRINT));
    
    jsonResponse(['success' => true, 'message' => 'Inscrição realizada com sucesso!']);
}
?>
