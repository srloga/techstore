<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - TechStore</title>

    <!-- Caminhos absolutos para recursos -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --base-url: <?php echo BASE_URL; ?>;
        }
        .cart-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            margin: 2rem 0;
        }
        
        @media (max-width: 768px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
        }
        
        .cart-items {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
        }
        
        .cart-item {
            display: grid;
            grid-template-columns: 80px 1fr auto;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
            align-items: center;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--radius);
        }
        
        .cart-item-details h4 {
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }
        
        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--border);
            border-radius: var(--radius);
            padding: 0.25rem;
        }
        
        .cart-item-quantity button {
            background: none;
            border: none;
            color: var(--foreground);
            cursor: pointer;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .cart-item-quantity span {
            min-width: 30px;
            text-align: center;
        }
        
        .cart-summary {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            height: fit-content;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        
        .summary-row.total {
            border-top: 1px solid var(--border);
            padding-top: 1rem;
            font-size: 1.125rem;
            font-weight: 700;
        }
        
        .empty-cart {
            text-align: center;
            padding: 3rem;
            color: var(--muted);
        }
        
        .empty-cart-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
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
            <h1 style="margin-bottom: 2rem;">Seu Carrinho</h1>
            
            <div class="cart-container">
                <div id="cart-items-container">
                    <!-- Carregado via JavaScript -->
                </div>
                
                <div class="cart-summary">
                    <h3 style="margin-bottom: 1rem;">Resumo do Pedido</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">€0.00</span>
                    </div>
                    
                    <div class="summary-row">
                        <span>Envio:</span>
                        <span id="shipping">€0.00</span>
                    </div>
                    
                    <div class="summary-row total">
                        <span>Total:</span>
                        <span id="total">€0.00</span>
                    </div>
                    
                    <a href="checkout.php" class="btn btn-primary" style="width: 100%; margin-bottom: 0.5rem;">
                        Ir para Checkout
                    </a>
                    
                    <a href="products.php" class="btn btn-secondary" style="width: 100%;">
                        Continuar Comprando
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>TechStore</h3>
                    <p class="text-muted" style="font-size: 0.875rem;">Sua loja online de confiança.</p>
                </div>
                
                <div class="footer-section">
                    <h3>Links Rápidos</h3>
                    <ul>
                        <li><a href="products.php">Produtos</a></li>
                        <li><a href="categories.php">Categorias</a></li>
                        <li><a href="about.php">Sobre</a></li>
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
        function displayCart() {
            const container = document.getElementById('cart-items-container');
            
            if (app.cart.length === 0) {
                container.innerHTML = `
                    <div class="empty-cart">
                        <div class="empty-cart-icon">🛒</div>
                        <h3>Seu carrinho está vazio</h3>
                        <p>Adicione produtos para começar a comprar</p>
                        <a href="/products.html" class="btn btn-primary" style="margin-top: 1rem;">
                            Explorar Produtos
                        </a>
                    </div>
                `;
                return;
            }
            
            let html = '<div class="cart-items">';
            let subtotal = 0;
            
            app.cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                html += `
                    <div class="cart-item">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-details">
                            <h4>${item.name}</h4>
                            <p class="text-muted">€${item.price.toFixed(2)}</p>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                            <div class="cart-item-quantity">
                                <button onclick="updateCartQuantity(${item.id}, ${item.quantity - 1})">−</button>
                                <span>${item.quantity}</span>
                                <button onclick="updateCartQuantity(${item.id}, ${item.quantity + 1})">+</button>
                            </div>
                            <div style="font-weight: 600;">€${itemTotal.toFixed(2)}</div>
                            <button onclick="removeFromCart(${item.id})" style="background: none; border: none; color: var(--danger); cursor: pointer; font-size: 0.875rem;">
                                Remover
                            </button>
                        </div>
                    </div>
                `;
            });
            
            html += '</div>';
            container.innerHTML = html;
            
            // Atualizar resumo
            const shippingCost = subtotal > 50 ? 0 : 5.99;
            const total = subtotal + shippingCost;
            
            document.getElementById('subtotal').textContent = '€' + subtotal.toFixed(2);
            document.getElementById('shipping').textContent = shippingCost === 0 ? 'Grátis' : '€' + shippingCost.toFixed(2);
            document.getElementById('total').textContent = '€' + total.toFixed(2);
        }
        
        // Carregar carrinho ao iniciar
        loadCart();
        
        // Atualizar exibição quando o carrinho muda
        const originalUpdateCartDisplay = updateCartDisplay;
        updateCartDisplay = function() {
            originalUpdateCartDisplay();
            displayCart();
        };
    </script>
</body>
</html>
