<?php
// php/api/categories.php
require_once '../config_db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$db = Database::getInstance();

// Obter categorias com contagem de produtos
$sql = "SELECT 
            c.id,
            c.nome,
            c.descricao,
            c.icone,
            c.slug,
            COUNT(p.id) as produtos_count
        FROM categorias c
        LEFT JOIN produtos p ON c.id = p.categoria_id AND p.ativo = 1
        GROUP BY c.id
        ORDER BY c.nome";

$categories = $db->select($sql);

echo json_encode([
    'success' => true,
    'categories' => $categories
]);
?>