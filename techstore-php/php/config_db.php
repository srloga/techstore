<?php
// Configuração do banco de dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'techstore_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // Senha vazia padrão do XAMPP
define('DB_CHARSET', 'utf8mb4');

class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }
            
            $this->connection->set_charset(DB_CHARSET);
        } catch (Exception $e) {
            error_log($e->getMessage());
            die("Erro na conexão com o banco de dados. Por favor, tente novamente mais tarde.");
        }
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Erro na preparação da query: " . $this->connection->error);
        }
        
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt;
    }
    
    public function select($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        $result = $stmt->get_result();
        
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        
        $stmt->close();
        return $rows;
    }
    
    public function selectOne($sql, $params = []) {
        $rows = $this->select($sql, $params);
        return $rows[0] ?? null;
    }
    
    public function insert($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        $insertId = $stmt->insert_id;
        $stmt->close();
        return $insertId;
    }
    
    public function update($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        $affectedRows = $stmt->affected_rows;
        $stmt->close();
        return $affectedRows;
    }
    
    public function delete($sql, $params = []) {
        return $this->update($sql, $params);
    }
}

// Função para testar conexão
function testDatabaseConnection() {
    try {
        $db = Database::getInstance();
        $result = $db->select("SELECT 1 as test");
        return isset($result[0]['test']);
    } catch (Exception $e) {
        return false;
    }
}

// Criar tabelas se não existirem (para desenvolvimento)
function setupDatabase() {
    $sql = file_get_contents(__DIR__ . '/database.sql');
    $db = Database::getInstance();
    $db->getConnection()->multi_query($sql);
}

// Verificar e setup automático
if (!testDatabaseConnection()) {
    // Tentar criar banco de dados
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    if ($conn->connect_error) {
        die("Não foi possível conectar ao MySQL: " . $conn->connect_error);
    }
    
    $conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $conn->select_db(DB_NAME);
    $conn->close();
    
    setupDatabase();
}
?>