<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechStore</title>

    <!-- Caminhos absolutos para recursos -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --base-url: <?php echo BASE_URL; ?>;
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .auth-form {
            width: 100%;
            max-width: 400px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
        }
        
        .auth-form h1 {
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }
        
        .auth-form p {
            color: var(--muted);
            margin-bottom: 2rem;
            font-size: 0.875rem;
        }
        
        .auth-form .form-group {
            margin-bottom: 1.5rem;
        }
        
        .auth-form .btn {
            width: 100%;
            margin-top: 1rem;
        }
        
        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: var(--muted);
        }
        
        .auth-link a {
            color: var(--primary);
            text-decoration: none;
        }
        
        .auth-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: var(--danger);
            color: white;
            padding: 0.75rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-size: 0.875rem;
            display: none;
        }
        
        .error-message.show {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <a href="<?php echo BASE_URL; ?>" class="logo">
                <div class="logo-icon">🗲</div>
                <span>TechStore</span>
            </a>
            
            <nav>
                <a href="<?php echo BASE_URL; ?>index.php">Home</a>
                <a href="<?php echo BASE_URL; ?>products.php">Produtos</a>
                <a href="<?php echo BASE_URL; ?>categories.php">Categorias</a>
                <a href="<?php echo BASE_URL; ?>offers.php">Ofertas</a>
                <a href="<?php echo BASE_URL; ?>about.php">Sobre</a>
                <a href="<?php echo BASE_URL; ?>contact.php">Contato</a>
            </nav>
            
            <div class="header-actions">
            <button class="theme-toggle" title="Alternar tema">
              <i class="fas fa-moon"></i>
            </button>
            <div class="cart-icon" onclick="window.location.href='cart.php'" title="Ver carrinho">
              <i class="fas fa-shopping-cart"></i>
              <span class="cart-count" style="display: none;">0</span>
            </div>
    
            <div class="user-icon" onclick="window.location.href='profile.php'" title="Minha conta">
              <i class="fas fa-user"></i>
            </div>
    
            <button class="mobile-menu-toggle">
              <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>
    
    <!-- Auth Container -->
    <div class="auth-container">
        <form class="auth-form" id="login-form" onsubmit="handleLogin(event)">
            <h1>Bem-vindo de volta</h1>
            <p>Faça login na sua conta para continuar</p>
            
            <div class="error-message" id="error-message"></div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="seu@email.com">
            </div>
            
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required placeholder="••••••••">
            </div>
            
            <button type="submit" class="btn btn-primary">Entrar</button>
            
            <div class="auth-link">
                Não tem conta? <a href="register.php">Criar conta</a>
            </div>
        </form>
    </div>
    
    <script src="<?php echo BASE_URL; ?>js/main.js"></script>
    <script>
        function handleLogin(event) {
            event.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');
            
            fetch('php/api/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'login',
                    email: email,
                    password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Login realizado com sucesso!', 'success');
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1500);
                } else {
                    errorMessage.textContent = data.message;
                    errorMessage.classList.add('show');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                errorMessage.textContent = 'Erro ao fazer login. Tente novamente.';
                errorMessage.classList.add('show');
            });
        }
    </script>
</body>
</html>
