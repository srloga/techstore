<?php
header('Content-Type: application/json');
require_once '../config.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? $_POST['action'] ?? null;

if ($method === 'GET' && $action === 'check') {
    if (isLoggedIn()) {
        $user = getCurrentUser();
        jsonResponse(['success' => true, 'user' => $user]);
    } else {
        jsonResponse(['success' => false, 'user' => null]);
    }
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? null;
    
    switch($action) {
        case 'register':
            $name = $data['name'] ?? null;
            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;
            $confirmPassword = $data['confirmPassword'] ?? null;
            
            // Validações
            if (!$name || !$email || !$password) {
                jsonResponse(['success' => false, 'message' => 'Todos os campos são obrigatórios'], 400);
            }
            
            if ($password !== $confirmPassword) {
                jsonResponse(['success' => false, 'message' => 'As senhas não correspondem'], 400);
            }
            
            if (strlen($password) < 6) {
                jsonResponse(['success' => false, 'message' => 'A senha deve ter pelo menos 6 caracteres'], 400);
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                jsonResponse(['success' => false, 'message' => 'Email inválido'], 400);
            }
            
            // Verificar se email já existe
            if (getUserByEmail($email)) {
                jsonResponse(['success' => false, 'message' => 'Este email já está registrado'], 400);
            }
            
            // Criar novo usuário
            $user = [
                'id' => uniqid('user_'),
                'name' => htmlspecialchars($name),
                'email' => htmlspecialchars($email),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'createdAt' => date('Y-m-d H:i:s'),
                'phone' => '',
                'address' => '',
                'city' => '',
                'postalCode' => '',
                'country' => 'Portugal'
            ];
            
            saveUser($user);
            
            // Fazer login automático
            $_SESSION['user_id'] = $user['id'];
            
            jsonResponse(['success' => true, 'message' => 'Conta criada com sucesso!', 'user' => $user]);
            break;
            
        case 'login':
            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;
            
            if (!$email || !$password) {
                jsonResponse(['success' => false, 'message' => 'Email e senha são obrigatórios'], 400);
            }
            
            $user = getUserByEmail($email);
            
            if (!$user || !password_verify($password, $user['password'])) {
                jsonResponse(['success' => false, 'message' => 'Email ou senha incorretos'], 401);
            }
            
            $_SESSION['user_id'] = $user['id'];
            
            // Remover password da resposta
            unset($user['password']);
            
            jsonResponse(['success' => true, 'message' => 'Login realizado com sucesso!', 'user' => $user]);
            break;
            
        case 'logout':
            session_destroy();
            jsonResponse(['success' => true, 'message' => 'Logout realizado com sucesso!']);
            break;
            
        case 'update':
            if (!isLoggedIn()) {
                jsonResponse(['success' => false, 'message' => 'Você precisa estar logado'], 401);
            }
            
            $users = getUsers();
            $updated = false;
            
            foreach ($users as &$user) {
                if ($user['id'] === $_SESSION['user_id']) {
                    if (isset($data['name'])) $user['name'] = htmlspecialchars($data['name']);
                    if (isset($data['phone'])) $user['phone'] = htmlspecialchars($data['phone']);
                    if (isset($data['address'])) $user['address'] = htmlspecialchars($data['address']);
                    if (isset($data['city'])) $user['city'] = htmlspecialchars($data['city']);
                    if (isset($data['postalCode'])) $user['postalCode'] = htmlspecialchars($data['postalCode']);
                    if (isset($data['country'])) $user['country'] = htmlspecialchars($data['country']);
                    
                    $updated = true;
                    break;
                }
            }
            
            if ($updated) {
                file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT));
                unset($user['password']);
                jsonResponse(['success' => true, 'message' => 'Perfil atualizado com sucesso!', 'user' => $user]);
            } else {
                jsonResponse(['success' => false, 'message' => 'Erro ao atualizar perfil'], 500);
            }
            break;
            
        default:
            jsonResponse(['success' => false, 'message' => 'Ação inválida'], 400);
    }
}
?>
