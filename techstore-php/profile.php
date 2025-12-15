<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - TechStore</title>

    <!-- Caminhos absolutos para recursos -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --base-url: <?php echo BASE_URL; ?>;
        }
        .profile-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 2rem;
            margin: 2rem 0;
        }
        
        @media (max-width: 768px) {
            .profile-container {
                grid-template-columns: 1fr;
            }
        }
        
        .profile-sidebar {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            height: fit-content;
        }
        
        .profile-sidebar a {
            display: block;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            border-radius: var(--radius);
            text-decoration: none;
            color: var(--foreground);
            transition: all 0.3s;
        }
        
        .profile-sidebar a:hover,
        .profile-sidebar a.active {
            background: var(--primary);
            color: var(--primary-foreground);
        }
        
        .profile-content {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
        }
        
        .profile-section {
            display: none;
        }
        
        .profile-section.active {
            display: block;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .form-row.full {
            grid-template-columns: 1fr;
        }
        
        .order-card {
            background: var(--border);
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .order-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .order-status.pending {
            background: var(--warning);
            color: var(--warning-foreground);
        }
        
        .order-status.completed {
            background: var(--success);
            color: var(--success-foreground);
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
    
    <!-- Main Content -->
    <section>
        <div class="container">
            <h1 style="margin-bottom: 2rem;">Meu Perfil</h1>
            
            <div id="login-prompt" style="display: none; text-align: center; padding: 3rem;">
                <p style="font-size: 1.125rem; margin-bottom: 1rem;">Você precisa estar logado para acessar esta página</p>
                <a href="login.php" class="btn btn-primary">Fazer Login</a>
            </div>
            
            <div class="profile-container" id="profile-container" style="display: none;">
                <!-- Sidebar -->
                <aside class="profile-sidebar">
                    <a href="#" onclick="showSection('info')" class="active">👤 Informações</a>
                    <a href="#" onclick="showSection('orders')">📦 Pedidos</a>
                    <a href="#" onclick="showSection('wishlist')">❤️ Favoritos</a>
                    <a href="#" onclick="showSection('settings')">⚙️ Configurações</a>
                    <hr>
                    <a href="#" onclick="handleLogout()" style="color: var(--danger);">🚪 Sair</a>
                </aside>
                
                <!-- Content -->
                <div class="profile-content">
                    <!-- Informações Pessoais -->
                    <div id="info" class="profile-section active">
                        <h2 style="margin-bottom: 1.5rem;">Informações Pessoais</h2>
                        
                        <form id="info-form" onsubmit="handleUpdateProfile(event)">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Nome Completo</label>
                                    <input type="text" id="name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" disabled>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Telefone</label>
                                    <input type="tel" id="phone" name="phone">
                                </div>
                                <div class="form-group">
                                    <label for="country">País</label>
                                    <input type="text" id="country" name="country">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="address">Endereço</label>
                                <input type="text" id="address" name="address">
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="city">Cidade</label>
                                    <input type="text" id="city" name="city">
                                </div>
                                <div class="form-group">
                                    <label for="postalCode">Código Postal</label>
                                    <input type="text" id="postalCode" name="postalCode">
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        </form>
                    </div>
                    
                    <!-- Pedidos -->
                    <div id="orders" class="profile-section">
                        <h2 style="margin-bottom: 1.5rem;">Meus Pedidos</h2>
                        
                        <div id="orders-list">
                            <!-- Carregado via JavaScript -->
                        </div>
                    </div>
                    
                    <!-- Favoritos -->
                    <div id="wishlist" class="profile-section">
                        <h2 style="margin-bottom: 1.5rem;">Meus Favoritos</h2>
                        
                        <div class="grid grid-3" id="wishlist-items">
                            <!-- Carregado via JavaScript -->
                        </div>
                    </div>
                    
                    <!-- Configurações -->
                    <div id="settings" class="profile-section">
                        <h2 style="margin-bottom: 1.5rem;">Configurações</h2>
                        
                        <div class="form-group">
                            <label>Tema</label>
                            <div style="display: flex; gap: 1rem;">
                                <button class="btn btn-secondary" onclick="applyTheme('light')">☀️ Claro</button>
                                <button class="btn btn-secondary" onclick="applyTheme('dark')">🌙 Escuro</button>
                            </div>
                        </div>
                        
                        <hr style="margin: 2rem 0;">
                        
                        <h3>Notificações</h3>
                        <div style="margin-top: 1rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                <input type="checkbox" checked> Receber emails de promoções
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                                <input type="checkbox" checked> Receber notificações de pedidos
                            </label>
                            <label style="display: flex; align-items: center; gap: 0.5rem;">
                                <input type="checkbox"> Receber newsletter semanal
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>🗲 TechStore</h3>
                    <p class="text-muted" style="font-size: 0.875rem;">Sua loja online de confiança com os <br> melhores produtos em eletrônicos,<br> moda, casa e livros.</p>
                    <div class="social-icons">
                        <a href="#" class="social-icons" title="GitHub">
                         <i class="fab fa-github"></i>
                        </a>
                        <a href="#" class="social-icons" title="LinkedIn">
                         <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="social-icons" title="Twitter">
                         <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icons" title="Instagram">
                         <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3><i class="fas fa-link"></i> Links Rápidos</h3>
                    <ul>
                        <li><a href="products.php"><i class="fas fa-box"></i> Produtos</a></li>
                        <li><a href="categories.php"><i class="fas fa-list"></i> Categorias</a></li>
                        <li><a href="offers.php"><i class="fas fa-tag"></i> Ofertas</a></li>
                        <li><a href="about.php"><i class="fas fa-info-circle"></i> Informações</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3><i class="fas fa-headset"></i> Suporte</h3>
                    <ul>
                        <li><a href="contact.php"><i class="fas fa-envelope"></i> Contato</a></li>
                        <li><a href="#"><i class="fas fa-question-circle"></i> FAQ</a></li>
                        <li><a href="#"><i class="fas fa-shipping-fast"></i> Envios</a></li>
                        <li><a href="#"><i class="fas fa-shield-alt"></i> Privacidade</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3><i class="fas fa-map-marker-alt"></i> Contacte-nos</h3>
                    <ul class="text-muted" style="font-size: 0.875rem;">
                        <li><a href="contact.php"><i class="fas fa-location-dot"></i> Vila das Aves, Portugal</a></li>
                        <li><a href="contact.php"><i class="fas fa-envelope"></i> contato@techstore.pt</a></li>
                        <li><a href="contact.php"><i class="fas fa-phone"></i> +351 123 456 789</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 TechStore. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    
    <script src="<?php echo BASE_URL; ?>js/main.js"></script>
    <script>
        function showSection(section) {
            document.querySelectorAll('.profile-section').forEach(el => {
                el.classList.remove('active');
            });
            
            document.querySelectorAll('.profile-sidebar a').forEach(el => {
                el.classList.remove('active');
            });
            
            document.getElementById(section).classList.add('active');
            event.target.classList.add('active');
        }
        
        function handleUpdateProfile(event) {
            event.preventDefault();
            
            const data = {
                action: 'update',
                name: document.getElementById('name').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                city: document.getElementById('city').value,
                postalCode: document.getElementById('postalCode').value,
                country: document.getElementById('country').value
            };
            
            fetch('/php/api/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Perfil atualizado com sucesso!', 'success');
                } else {
                    showNotification(data.message || 'Erro ao atualizar perfil', 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showNotification('Erro ao atualizar perfil', 'error');
            });
        }
        
        function loadUserOrders() {
            fetch('/php/api/orders.php')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('orders-list');
                    
                    if (!data.orders || data.orders.length === 0) {
                        container.innerHTML = '<p style="color: var(--muted);">Você ainda não fez nenhum pedido</p>';
                        return;
                    }
                    
                    let html = '';
                    data.orders.forEach(order => {
                        html += `
                            <div class="order-card">
                                <div class="order-header">
                                    <div>
                                        <strong>Pedido ${order.id}</strong>
                                        <p style="font-size: 0.875rem; color: var(--muted);">${new Date(order.createdAt).toLocaleDateString('pt-PT')}</p>
                                    </div>
                                    <span class="order-status ${order.status}">${order.status === 'pending' ? 'Pendente' : 'Concluído'}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <p style="font-size: 0.875rem; color: var(--muted);">${order.items.length} item(ns)</p>
                                    </div>
                                    <strong>€${order.total.toFixed(2)}</strong>
                                </div>
                            </div>
                        `;
                    });
                    
                    container.innerHTML = html;
                })
                .catch(error => console.error('Erro:', error));
        }
        
        function loadUserWishlist() {
            const container = document.getElementById('wishlist-items');
            
            if (app.wishlist.length === 0) {
                container.innerHTML = '<p style="grid-column: 1 / -1; color: var(--muted);">Você ainda não adicionou nenhum favorito</p>';
                return;
            }
            
            let html = '';
            app.wishlist.forEach(product => {
                html += `
                    <div class="product-card">
                        <img src="${product.image}" alt="${product.name}" class="product-image">
                        <div class="product-content">
                            <h3 class="product-name">${product.name}</h3>
                            <div class="product-price">
                                <span class="price-current">€${product.price.toFixed(2)}</span>
                            </div>
                            <div class="product-actions">
                                <button class="btn btn-primary btn-small add-to-cart-btn" data-product-id="${product.id}">
                                    🛒 Adicionar
                                </button>
                                <button class="btn btn-secondary btn-small wishlist-btn" data-product-id="${product.id}">
                                    ❤️
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            setupEventListeners();
        }
        
        function handleLogout() {
            fetch('/php/api/auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'logout'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Logout realizado com sucesso!', 'success');
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 1500);
                }
            })
            .catch(error => console.error('Erro:', error));
        }
        
        // Inicializar página
        function initProfile() {
            if (!app.user) {
                document.getElementById('login-prompt').style.display = 'block';
                return;
            }
            
            document.getElementById('profile-container').style.display = 'grid';
            
            // Preencher formulário
            document.getElementById('name').value = app.user.name || '';
            document.getElementById('email').value = app.user.email || '';
            document.getElementById('phone').value = app.user.phone || '';
            document.getElementById('address').value = app.user.address || '';
            document.getElementById('city').value = app.user.city || '';
            document.getElementById('postalCode').value = app.user.postalCode || '';
            document.getElementById('country').value = app.user.country || '';
            
            // Carregar dados
            loadUserOrders();
            loadUserWishlist();
        }
        
        // Esperar por carregamento do usuário
        setTimeout(initProfile, 500);
    </script>
</body>
</html>
