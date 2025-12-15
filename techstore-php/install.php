<?php
// Script de instalação
require_once 'php/config_db.php';

echo "<h1>Instalação do TechStore</h1>";

try {
    $db = Database::getInstance();
    
    // Executar script SQL
    $sql = file_get_contents(__DIR__ . '/database.sql');
    
    if ($db->getConnection()->multi_query($sql)) {
        echo "<p style='color: green;'>✅ Banco de dados criado com sucesso!</p>";
        
        // Verificar tabelas criadas
        $tables = $db->select("SHOW TABLES");
        echo "<p>Tabelas criadas:</p><ul>";
        foreach ($tables as $table) {
            $tableName = array_values($table)[0];
            echo "<li>{$tableName}</li>";
        }
        echo "</ul>";
        
        // Verificar produtos
        $products = $db->select("SELECT COUNT(*) as total FROM produtos");
        echo "<p>Produtos inseridos: " . $products[0]['total'] . "</p>";
        
        echo "<h3>Instalação concluída!</h3>";
        echo "<p><a href='index.php'>Acessar a loja</a></p>";
        
    } else {
        echo "<p style='color: red;'>❌ Erro ao criar banco de dados: " . $db->getConnection()->error . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erro: " . $e->getMessage() . "</p>";
}
?>