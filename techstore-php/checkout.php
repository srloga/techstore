<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TechStore</title>

    <!-- Caminhos absolutos para recursos -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --base-url: <?php echo BASE_URL; ?>;
        }
        .checkout-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            margin: 2rem 0;
        }
        
        @media (max-width: 768px) {
            .checkout-container {
                grid-template-columns: 1fr;
            }
        }
        
        .checkout-form {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
        }
        
        .form-section {
            margin-bottom: 2rem;
        }
        
        .form-section h3 {
            font-size: 1.125rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .form-row.full {
            grid-template-columns: 1fr;
        }
        
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .payment-option {
            padding: 1rem;
            border: 2px solid var(--border);
            border-radius: var(--radius);
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .payment-option:hover {
            border-color: var(--primary);
        }
        
        .payment-option.active {
            border-color: var(--primary);
            background: rgba(255, 215, 0, 0.1);
        }
        
        .payment-option input[type="radio"] {
            display: none;
        }
        
        .payment-details {
            background: var(--border);
            padding: 1rem;
            border-radius: var(--radius);
            margin-top: 1rem;
            display: none;
        }
        
        .payment-details.show {
            display: block;
        }
        
        .order-summary {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.5rem;
            height: fit-content;
        }
        
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.875rem;
        }
        
        .summary-item:last-child {
            border-bottom: none;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .summary-row.total {
            border-top: 1px solid var(--border);
            padding-top: 1rem;
            font-size: 1.125rem;
            font-weight: 700;
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
            <h1 style="margin-bottom: 2rem;">Checkout</h1>
            
            <div id="empty-cart-message" style="display: none; text-align: center; padding: 3rem;">
                <p style="font-size: 1.125rem; margin-bottom: 1rem;">Seu carrinho está vazio</p>
                <a href="products.php" class="btn btn-primary">Continuar Comprando</a>
            </div>
            
            <div class="checkout-container" id="checkout-form-container">
                <form class="checkout-form" id="checkout-form" onsubmit="handleCheckout(event)">
                    <!-- Informações de Envio -->
                    <div class="form-section">
                        <h3>📍 Informações de Envio</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">Primeiro Nome</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Sobrenome</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Telefone</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Endereço</label>
                            <input type="text" id="address" name="address" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">Cidade</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="postalCode">Código Postal</label>
                                <input type="text" id="postalCode" name="postalCode" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="country">País</label>
                            <select id="country" name="country" required>
                                <option value="Portugal">Portugal</option>
                                <option value="Espanha">Espanha</option>
                                <option value="França">França</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Método de Pagamento -->
                    <div class="form-section">
                        <h3>💳 Método de Pagamento</h3>
                        
                        <div class="payment-methods">
                            <label class="payment-option active">
                                <input type="radio" name="paymentMethod" value="card" checked onchange="updatePaymentDetails()">
                                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">💳</div>
                                <div style="font-size: 0.875rem;">Cartão</div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="paymentMethod" value="paypal" onchange="updatePaymentDetails()">
                                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🅿️</div>
                                <div style="font-size: 0.875rem;">PayPal</div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="paymentMethod" value="transfer" onchange="updatePaymentDetails()">
                                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🏦</div>
                                <div style="font-size: 0.875rem;">Transferência</div>
                            </label>
                            
                            <label class="payment-option">
                                <input type="radio" name="paymentMethod" value="mbway" onchange="updatePaymentDetails()">
                                <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📱</div>
                                <div style="font-size: 0.875rem;">MB Way</div>
                            </label>
                        </div>
                        
                        <!-- Detalhes do Cartão -->
                        <div id="card-details" class="payment-details show">
                            <div class="form-group">
                                <label for="cardName">Nome no Cartão</label>
                                <input type="text" id="cardName" name="cardName">
                            </div>
                            <div class="form-group">
                                <label for="cardNumber">Número do Cartão</label>
                                <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456">
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="cardExpiry">Validade</label>
                                    <input type="text" id="cardExpiry" name="cardExpiry" placeholder="MM/AA">
                                </div>
                                <div class="form-group">
                                    <label for="cardCVC">CVC</label>
                                    <input type="text" id="cardCVC" name="cardCVC" placeholder="123">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Detalhes PayPal -->
                        <div id="paypal-details" class="payment-details">
                            <p style="font-size: 0.875rem; color: var(--muted);">Será redirecionado para PayPal para completar o pagamento.</p>
                        </div>
                        
                        <!-- Detalhes Transferência -->
                        <div id="transfer-details" class="payment-details">
                            <p style="font-size: 0.875rem; color: var(--muted);">
                                Após confirmar o pedido, receberá os dados bancários para fazer a transferência.
                            </p>
                        </div>
                        
                        <!-- Detalhes MB Way -->
                        <div id="mbway-details" class="payment-details">
                            <div class="form-group">
                                <label for="mbwayPhone">Número de Telefone</label>
                                <input type="tel" id="mbwayPhone" name="mbwayPhone" placeholder="9XXXXXXXX">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 1rem;">
                        Confirmar Pedido
                    </button>
                </form>
                
                <!-- Resumo do Pedido -->
                <div class="order-summary">
                    <h3 style="margin-bottom: 1rem;">Resumo do Pedido</h3>
                    
                    <div id="order-items">
                        <!-- Carregado via JavaScript -->
                    </div>
                    
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
        function updatePaymentDetails() {
            const method = document.querySelector('input[name="paymentMethod"]:checked').value;
            
            document.querySelectorAll('.payment-details').forEach(el => {
                el.classList.remove('show');
            });
            
            document.getElementById(method + '-details').classList.add('show');
        }
        
        function displayOrderSummary() {
            const container = document.getElementById('order-items');
            
            if (app.cart.length === 0) {
                document.getElementById('empty-cart-message').style.display = 'block';
                document.getElementById('checkout-form-container').style.display = 'none';
                return;
            }
            
            let html = '';
            let subtotal = 0;
            
            app.cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                
                html += `
                    <div class="summary-item">
                        <div>
                            <div>${item.name}</div>
                            <div style="color: var(--muted);">x${item.quantity}</div>
                        </div>
                        <div>€${itemTotal.toFixed(2)}</div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            
            const shippingCost = subtotal > 50 ? 0 : 5.99;
            const total = subtotal + shippingCost;
            
            document.getElementById('subtotal').textContent = '€' + subtotal.toFixed(2);
            document.getElementById('shipping').textContent = shippingCost === 0 ? 'Grátis' : '€' + shippingCost.toFixed(2);
            document.getElementById('total').textContent = '€' + total.toFixed(2);
        }
        
        function handleCheckout(event) {
            event.preventDefault();
            
            const shippingInfo = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                city: document.getElementById('city').value,
                postalCode: document.getElementById('postalCode').value,
                country: document.getElementById('country').value
            };
            
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            
            fetch('/php/api/orders.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'create',
                    items: app.cart,
                    shippingInfo: shippingInfo,
                    paymentMethod: paymentMethod
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Pedido criado com sucesso!', 'success');
                    
                    // Limpar carrinho
                    fetch('/php/api/cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            action: 'clear'
                        })
                    });
                    
                    setTimeout(() => {
                        window.location.href = '/';
                    }, 2000);
                } else {
                    showNotification(data.message || 'Erro ao criar pedido', 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showNotification('Erro ao criar pedido', 'error');
            });
        }
        
        // Carregar carrinho e exibir resumo
        loadCart();
        displayOrderSummary();
    </script>
</body>
</html>
