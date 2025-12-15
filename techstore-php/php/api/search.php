<?php
header('Content-Type: application/json');
require_once '../config.php';

$query = $_GET['q'] ?? '';

if (strlen($query) < 2) {
    jsonResponse(['success' => false, 'results' => [], 'message' => 'Busca deve ter pelo menos 2 caracteres'], 400);
}

$products = getProducts();
$query = strtolower($query);
$results = [];

foreach ($products as $product) {
    if (
        strpos(strtolower($product['name']), $query) !== false ||
        strpos(strtolower($product['category']), $query) !== false ||
        strpos(strtolower($product['description'] ?? ''), $query) !== false
    ) {
        $results[] = $product;
    }
}

jsonResponse(['success' => true, 'results' => $results, 'count' => count($results)]);
?>
