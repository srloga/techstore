// TechStore - JavaScript Principal Atualizado

// Estado da aplicação
const app = {
    cart: [],
    wishlist: [],
    user: null,
    theme: localStorage.getItem('theme') || 'dark',
    baseUrl: window.location.origin + '/techstore-php/'
};

// Inicializar aplicação
document.addEventListener('DOMContentLoaded', () => {
    initializeApp();
    loadCart();
    loadWishlist();
    checkUser();
    setupEventListeners();
    
    // Adicionar event listeners para botões dinâmicos
    setTimeout(setupDynamicEventListeners, 500);
});

function initializeApp() {
    applyTheme(app.theme);
    updateCartCount();
}

// Função helper para fetch
async function apiCall(endpoint, method = 'GET', data = null) {
    const url = app.baseUrl + 'php/api/' + endpoint;
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    };
    
    if (data && (method === 'POST' || method === 'PUT')) {
        options.body = JSON.stringify(data);
    }
    
    try {
        const response = await fetch(url, options);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            return await response.json();
        } else {
            return await response.text();
        }
    } catch (error) {
        console.error('API Error:', error);
        showNotification('Erro de conexão com o servidor', 'error');
        return { success: false, message: 'Erro de conexão' };
    }
}

// Carrinho - Atualizado
async function addToCart(productId) {
    try {
        const productResponse = await apiCall(`products.php?id=${productId}`);
        
        if (!productResponse.success || !productResponse.product) {
            showNotification('Produto não encontrado', 'error');
            return;
        }
        
        const product = productResponse.product;
        
        // Adicionar ao carrinho local
        const existingItem = app.cart.find(item => item.id === productId);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            app.cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: 1
            });
        }
        
        // Salvar no localStorage
        localStorage.setItem('techstore_cart', JSON.stringify(app.cart));
        
        // Atualizar interface
        updateCartCount();
        updateCartDisplay();
        
        // Mostrar confirmação
        showNotification(`${product.name} adicionado ao carrinho!`, 'success');
        
        // Se usuário estiver logado, sincronizar com servidor
        if (app.user) {
            await apiCall('cart.php', 'POST', {
                action: 'add',
                productId: productId,
                quantity: 1
            });
        }
        
    } catch (error) {
        console.error('Erro ao adicionar ao carrinho:', error);
        showNotification('Erro ao adicionar produto', 'error');
    }
}

function removeFromCart(productId) {
    app.cart = app.cart.filter(item => item.id !== productId);
    localStorage.setItem('techstore_cart', JSON.stringify(app.cart));
    updateCartCount();
    updateCartDisplay();
    
    if (app.user) {
        apiCall('cart.php', 'POST', {
            action: 'remove',
            productId: productId
        });
    }
    
    showNotification('Produto removido do carrinho', 'success');
}

function updateCartQuantity(productId, quantity) {
    if (quantity <= 0) {
        removeFromCart(productId);
        return;
    }
    
    const item = app.cart.find(item => item.id === productId);
    if (item) {
        item.quantity = quantity;
        localStorage.setItem('techstore_cart', JSON.stringify(app.cart));
        updateCartCount();
        updateCartDisplay();
    }
}

function loadCart() {
    const savedCart = localStorage.getItem('techstore_cart');
    if (savedCart) {
        try {
            app.cart = JSON.parse(savedCart);
        } catch (e) {
            app.cart = [];
        }
    }
    updateCartCount();
}

function updateCartCount() {
    const count = app.cart.reduce((total, item) => total + item.quantity, 0);
    const cartCountElements = document.querySelectorAll('.cart-count');
    
    cartCountElements.forEach(cartCount => {
        cartCount.textContent = count;
        cartCount.style.display = count > 0 ? 'flex' : 'none';
    });
}

// Wishlist
async function addToWishlist(productId) {
    try {
        const productResponse = await apiCall(`products.php?id=${productId}`);
        
        if (!productResponse.success || !productResponse.product) {
            showNotification('Produto não encontrado', 'error');
            return;
        }
        
        const product = productResponse.product;
        const isInWishlist = app.wishlist.some(item => item.id === productId);
        
        if (isInWishlist) {
            app.wishlist = app.wishlist.filter(item => item.id !== productId);
            showNotification('Removido dos favoritos', 'success');
        } else {
            app.wishlist.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                category: product.category
            });
            showNotification('Adicionado aos favoritos!', 'success');
        }
        
        localStorage.setItem('techstore_wishlist', JSON.stringify(app.wishlist));
        updateWishlistDisplay();
        
        if (app.user) {
            await apiCall('wishlist.php', 'POST', {
                action: isInWishlist ? 'remove' : 'add',
                productId: productId
            });
        }
        
    } catch (error) {
        console.error('Erro na wishlist:', error);
        showNotification('Erro ao atualizar favoritos', 'error');
    }
}

function loadWishlist() {
    const savedWishlist = localStorage.getItem('techstore_wishlist');
    if (savedWishlist) {
        try {
            app.wishlist = JSON.parse(savedWishlist);
        } catch (e) {
            app.wishlist = [];
        }
    }
    updateWishlistDisplay();
}

function updateWishlistDisplay() {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        if (btn.dataset.productId) {
            const productId = parseInt(btn.dataset.productId);
            const isInWishlist = app.wishlist.some(item => item.id === productId);
            btn.classList.toggle('active', isInWishlist);
            btn.innerHTML = isInWishlist ? 
                '<i class="fas fa-heart"></i>' : 
                '<i class="far fa-heart"></i>';
        }
    });
}

// Tema
function applyTheme(theme) {
    app.theme = theme;
    localStorage.setItem('theme', theme);
    document.documentElement.setAttribute('data-theme', theme);
    
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
        themeToggle.innerHTML = theme === 'dark' ? 
            '<i class="fas fa-sun"></i>' : 
            '<i class="fas fa-moon"></i>';
    }
}

function toggleTheme() {
    const newTheme = app.theme === 'dark' ? 'light' : 'dark';
    applyTheme(newTheme);
}

// Notificações
function showNotification(message, type = 'info') {
    // Remover notificações existentes
    document.querySelectorAll('.notification').forEach(n => n.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 
                          type === 'error' ? 'exclamation-circle' : 
                          type === 'warning' ? 'exclamation-triangle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="notification-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 10);
    
    // Fechar ao clicar no botão
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    });
    
    // Auto-remover após 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }
    }, 5000);
}

// Event Listeners
function setupEventListeners() {
    // Tema
    const themeToggle = document.querySelector('.theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }
    
    // Botões de tema demo
    document.querySelectorAll('.theme-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const theme = this.dataset.theme;
            
            // Atualizar variáveis CSS para temas personalizados
            const root = document.documentElement;
            
            if (theme === 'blue') {
                root.style.setProperty('--primary', '#3b82f6');
                root.style.setProperty('--primary-dark', '#1d4ed8');
                root.style.setProperty('--primary-light', 'rgba(59, 130, 246, 0.1)');
                root.style.setProperty('--primary-glow', 'rgba(59, 130, 246, 0.3)');
                root.style.setProperty('--background', '#0f172a');
                root.style.setProperty('--background-secondary', '#1e293b');
            } else if (theme === 'green') {
                root.style.setProperty('--primary', '#10b981');
                root.style.setProperty('--primary-dark', '#059669');
                root.style.setProperty('--primary-light', 'rgba(16, 185, 129, 0.1)');
                root.style.setProperty('--primary-glow', 'rgba(16, 185, 129, 0.3)');
                root.style.setProperty('--background', '#064e3b');
                root.style.setProperty('--background-secondary', '#065f46');
            } else {
                // Reset para tema padrão
                root.style = '';
                applyTheme(theme);
            }
            
            localStorage.setItem('demoTheme', theme);
            showNotification(`Tema ${theme} aplicado!`, 'success');
        });
    });
    
    // Menu mobile
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', () => {
            const nav = document.querySelector('nav');
            if (nav) {
                nav.classList.toggle('mobile-active');
            }
        });
    }
}

function setupDynamicEventListeners() {
    // Botões de adicionar ao carrinho (dinâmicos)
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        if (!btn.hasAttribute('data-listener')) {
            btn.setAttribute('data-listener', 'true');
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const productId = parseInt(this.dataset.productId);
                if (productId) {
                    addToCart(productId);
                    
                    // Efeito visual
                    this.innerHTML = '<i class="fas fa-check"></i> Adicionado';
                    this.classList.add('added');
                    
                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-shopping-cart"></i> Adicionar';
                        this.classList.remove('added');
                    }, 2000);
                }
            });
        }
    });
    
    // Botões de wishlist (dinâmicos)
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        if (!btn.hasAttribute('data-listener')) {
            btn.setAttribute('data-listener', 'true');
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const productId = parseInt(this.dataset.productId);
                if (productId) {
                    addToWishlist(productId);
                    
                    // Efeito visual
                    this.classList.add('animating');
                    setTimeout(() => {
                        this.classList.remove('animating');
                    }, 500);
                }
            });
        }
    });
}

// Verificar usuário
async function checkUser() {
    try {
        const response = await apiCall('auth.php?action=check');
        if (response.user) {
            app.user = response.user;
            updateUserDisplay();
        }
    } catch (error) {
        console.error('Erro ao verificar usuário:', error);
    }
}

function updateUserDisplay() {
    const userIcon = document.querySelector('.user-icon');
    if (userIcon && app.user) {
        userIcon.title = app.user.name;
    }
}

// Carregar produtos
async function loadFeaturedProducts() {
    try {
        const response = await apiCall('products.php?featured=true&limit=6');
        
        if (response.success && response.products) {
            const container = document.getElementById('featured-products');
            if (!container) return;
            
            let html = '';
            response.products.forEach(product => {
                const discount = product.oldPrice ? 
                    Math.round(((product.oldPrice - product.price) / product.oldPrice) * 100) : 0;
                
                html += `
                    <div class="product-card">
                        ${product.isSale ? `
                            <div class="product-badge sale">
                                <i class="fas fa-tag"></i> -${discount}%
                            </div>
                        ` : ''}
                        
                        ${product.isNew ? `
                            <div class="product-badge new">
                                <i class="fas fa-star"></i> NOVO
                            </div>
                        ` : ''}
                        
                        <img src="${product.image}" alt="${product.name}" class="product-image">
                        <div class="product-content">
                            <p class="product-category">
                                <i class="${product.category_icon || 'fas fa-box'}"></i>
                                ${product.category}
                            </p>
                            <h3 class="product-name">${product.name}</h3>
                            <div class="product-rating">
                                <div class="star-rating">
                                    ${[1,2,3,4,5].map(i => `
                                        <span class="star ${i <= Math.round(product.rating) ? 'filled' : ''}">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    `).join('')}
                                    <span class="rating-value">${product.rating}</span>
                                </div>
                            </div>
                            <div class="product-price">
                                <span class="price-current">
                                    €${product.price.toFixed(2).replace('.', ',')}
                                </span>
                                ${product.oldPrice ? `
                                    <span class="price-old">
                                        €${product.oldPrice.toFixed(2).replace('.', ',')}
                                    </span>
                                ` : ''}
                            </div>
                            <div class="product-actions">
                                <button class="btn btn-primary btn-small add-to-cart-btn" 
                                        data-product-id="${product.id}">
                                    <i class="fas fa-shopping-cart"></i> Adicionar
                                </button>
                                <button class="btn btn-secondary btn-small wishlist-btn" 
                                        data-product-id="${product.id}">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            setupDynamicEventListeners();
        }
    } catch (error) {
        console.error('Erro ao carregar produtos em destaque:', error);
    }
}

// Carregar ofertas
async function loadOffers() {
    try {
        const response = await apiCall('products.php?offers=true');
        
        if (response.success && response.products) {
            const container = document.getElementById('offers-grid');
            if (!container) return;
            
            if (response.products.length === 0) {
                container.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                        <i class="fas fa-tag" style="font-size: 3rem; color: var(--muted); margin-bottom: 1rem;"></i>
                        <h3>Nenhuma oferta disponível no momento</h3>
                        <p class="text-muted">Volte mais tarde para novas promoções!</p>
                    </div>
                `;
                return;
            }
            
            let html = '';
            response.products.forEach(product => {
                const discount = Math.round(((product.oldPrice - product.price) / product.oldPrice) * 100);
                
                html += `
                    <div class="product-card">
                        <div style="position: relative;">
                            <img src="${product.image}" alt="${product.name}" class="product-image">
                            <div class="offer-badge">
                                <span>-${discount}%</span>
                            </div>
                        </div>
                        <div class="product-content">
                            <p class="product-category">
                                <i class="${product.category_icon || 'fas fa-box'}"></i>
                                ${product.category}
                            </p>
                            <h3 class="product-name">${product.name}</h3>
                            <div class="product-rating">
                                <div class="star-rating">
                                    ${[1,2,3,4,5].map(i => `
                                        <span class="star ${i <= Math.round(product.rating) ? 'filled' : ''}">
                                            <i class="fas fa-star"></i>
                                        </span>
                                    `).join('')}
                                </div>
                            </div>
                            <div class="product-price">
                                <span class="price-current">
                                    €${product.price.toFixed(2).replace('.', ',')}
                                </span>
                                <span class="price-old">
                                    €${product.oldPrice.toFixed(2).replace('.', ',')}
                                </span>
                            </div>
                            <div class="product-actions">
                                <button class="btn btn-primary btn-small add-to-cart-btn" 
                                        data-product-id="${product.id}">
                                    <i class="fas fa-shopping-cart"></i> Comprar
                                </button>
                                <button class="btn btn-secondary btn-small wishlist-btn" 
                                        data-product-id="${product.id}">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            container.innerHTML = html;
            setupDynamicEventListeners();
        }
    } catch (error) {
        console.error('Erro ao carregar ofertas:', error);
    }
}

// Newsletter
async function subscribeNewsletter(email) {
    try {
        const response = await apiCall('newsletter.php', 'POST', {
            email: email,
            action: 'subscribe'
        });
        
        if (response.success) {
            showNotification('Inscrito na newsletter com sucesso!', 'success');
            return true;
        } else {
            showNotification(response.message || 'Erro ao inscrever', 'error');
            return false;
        }
    } catch (error) {
        console.error('Erro newsletter:', error);
        showNotification('Erro ao inscrever', 'error');
        return false;
    }
}

// Inicializar quando necessário
if (document.getElementById('featured-products')) {
    loadFeaturedProducts();
}

if (document.getElementById('offers-grid')) {
    loadOffers();
}

// Adicionar CSS para notificações
const notificationStyles = document.createElement('style');
notificationStyles.textContent = `
    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem;
        min-width: 300px;
        max-width: 400px;
        box-shadow: var(--shadow-lg);
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.3s var(--transition-normal);
        z-index: var(--z-tooltip);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    
    .notification.show {
        transform: translateX(0);
        opacity: 1;
    }
    
    .notification-content {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
    }
    
    .notification i {
        font-size: 1.25rem;
    }
    
    .notification-success {
        border-left: 4px solid var(--success);
    }
    
    .notification-success i {
        color: var(--success);
    }
    
    .notification-error {
        border-left: 4px solid var(--danger);
    }
    
    .notification-error i {
        color: var(--danger);
    }
    
    .notification-warning {
        border-left: 4px solid var(--warning);
    }
    
    .notification-warning i {
        color: var(--warning);
    }
    
    .notification-info {
        border-left: 4px solid var(--info);
    }
    
    .notification-info i {
        color: var(--info);
    }
    
    .notification-close {
        background: none;
        border: none;
        color: var(--muted);
        cursor: pointer;
        font-size: 1rem;
        padding: 0.25rem;
        border-radius: var(--radius-sm);
        transition: all 0.2s;
    }
    
    .notification-close:hover {
        background: var(--border);
        color: var(--foreground);
    }
    
    .offer-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: linear-gradient(135deg, var(--danger), #ff6b6b);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.125rem;
        box-shadow: var(--shadow);
    }
    
    .product-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: var(--danger);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--radius);
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .product-badge.sale {
        background: linear-gradient(135deg, var(--danger), #ff6b6b);
    }
    
    .product-badge.new {
        background: linear-gradient(135deg, var(--success), #10b981);
    }
    
    .add-to-cart-btn.added {
        background: var(--success) !important;
    }
    
    .wishlist-btn.active {
        color: var(--danger);
    }
    
    .wishlist-btn.animating {
        animation: heartBeat 0.5s ease;
    }
    
    @keyframes heartBeat {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.3); }
        50% { transform: scale(0.9); }
        75% { transform: scale(1.1); }
    }
`;

document.head.appendChild(notificationStyles);