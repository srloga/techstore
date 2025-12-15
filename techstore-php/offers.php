<?php
require_once 'config.php';

$pageTitle = "Ofertas Especiais - TechStore";

ob_start();
?>

<!-- Hero Section -->
<section class="hero-offers">
    <div class="container">
        <div class="hero-content">
            <div>
                <span class="badge badge-primary" style="margin-bottom: 1rem;">
                    <i class="fas fa-fire"></i> OFERTAS LIMITADAS
                </span>
                <h1 style="margin-bottom: 1rem;">
                    Até <span class="highlight">50% OFF</span><br>
                    em Produtos Selecionados
                </h1>
                <p class="hero-subtitle" style="font-size: 1.125rem; margin-bottom: 2rem;">
                    Aproveite nossas melhores promoções por tempo limitado
                </p>
                
                <div class="countdown" style="margin-bottom: 2rem;">
                    <h4 style="margin-bottom: 1rem; font-size: 1rem;">
                        <i class="fas fa-clock"></i> Oferta termina em:
                    </h4>
                    <div class="countdown-timer">
                        <div class="countdown-item">
                            <span class="countdown-number" id="days">05</span>
                            <span class="countdown-label">Dias</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-number" id="hours">12</span>
                            <span class="countdown-label">Horas</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-number" id="minutes">45</span>
                            <span class="countdown-label">Minutos</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-number" id="seconds">30</span>
                            <span class="countdown-label">Segundos</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="hero-image-container">
                <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=600&auto=format&fit=crop&q=80" 
                     alt="Ofertas TechStore" 
                     class="hero-image floating">
            </div>
        </div>
    </div>
</section>

<!-- Ofertas em Destaque -->
<section>
    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="margin-bottom: 0.5rem;">
                    <span class="highlight">Ofertas da Semana</span>
                </h2>
                <p class="text-muted">
                    As melhores promoções selecionadas para você
                </p>
            </div>
            <div class="filter-buttons">
                <button class="btn btn-secondary btn-small filter-btn active" data-filter="all">
                    Todas
                </button>
                <button class="btn btn-secondary btn-small filter-btn" data-filter="high-discount">
                    Maior Desconto
                </button>
                <button class="btn btn-secondary btn-small filter-btn" data-filter="best-selling">
                    Mais Vendidos
                </button>
            </div>
        </div>
        
        <div class="grid grid-3" id="offers-grid">
            <!-- Carregado via JavaScript -->
            <div class="loading-products" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <div class="spinner"></div>
                <p class="text-muted" style="margin-top: 1rem;">Carregando ofertas...</p>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <div class="alert alert-info" style="background: var(--info-light); border: 1px solid var(--info); 
                 padding: 1.5rem; border-radius: var(--radius); margin-bottom: 2rem;">
                <i class="fas fa-info-circle" style="color: var(--info); font-size: 1.5rem; margin-bottom: 1rem;"></i>
                <h4 style="margin-bottom: 0.5rem;">Não perca essas ofertas!</h4>
                <p class="text-muted" style="margin-bottom: 0;">
                    As promoções são por tempo limitado e podem acabar a qualquer momento
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-card">
            <div class="newsletter-content">
                <h2 style="margin-bottom: 1rem;">
                    Receba Ofertas <span class="highlight">Exclusivas!</span>
                </h2>
                <p class="text-muted" style="margin-bottom: 2rem;">
                    Inscreva-se na nossa newsletter e seja o primeiro a saber 
                    das nossas melhores promoções
                </p>
                
                <form class="newsletter-form" onsubmit="handleNewsletter(event)">
                    <div class="input-group">
                        <input type="email" placeholder="Seu melhor email" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Inscrever
                        </button>
                    </div>
                    <p class="disclaimer" style="font-size: 0.75rem; color: var(--muted); margin-top: 1rem;">
                        <i class="fas fa-shield-alt"></i> Não compartilhamos seu email com terceiros
                    </p>
                </form>
            </div>
            <div class="newsletter-image">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w-600&auto=format&fit=crop&q=80" 
                     alt="Newsletter">
            </div>
        </div>
    </div>
</section>

<style>
    .hero-offers {
        background: linear-gradient(135deg, var(--primary-light) 0%, transparent 100%);
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }
    
    .hero-offers::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,215,0,0.1)"/></svg>');
        background-size: cover;
        opacity: 0.3;
        z-index: -1;
    }
    
    .hero-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        align-items: center;
    }
    
    @media (min-width: 768px) {
        .hero-content {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .countdown-timer {
        display: flex;
        gap: 1rem;
    }
    
    .countdown-item {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1rem;
        text-align: center;
        min-width: 70px;
    }
    
    .countdown-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        display: block;
    }
    
    .countdown-label {
        font-size: 0.75rem;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .filter-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .filter-btn.active {
        background: var(--primary);
        color: var(--background);
        border-color: var(--primary);
    }
    
    .newsletter-section {
        padding: 4rem 0;
    }
    
    .newsletter-card {
        background: linear-gradient(135deg, var(--card), var(--background-secondary));
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 3rem;
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
        align-items: center;
        box-shadow: var(--shadow-lg);
    }
    
    @media (min-width: 768px) {
        .newsletter-card {
            grid-template-columns: 2fr 1fr;
        }
    }
    
    .newsletter-content {
        text-align: center;
    }
    
    @media (min-width: 768px) {
        .newsletter-content {
            text-align: left;
        }
    }
    
    .newsletter-form .input-group {
        display: flex;
        gap: 0.5rem;
        max-width: 500px;
        margin: 0 auto;
    }
    
    @media (min-width: 768px) {
        .newsletter-form .input-group {
            margin: 0;
        }
    }
    
    .newsletter-form input {
        flex: 1;
        padding: 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--background);
        color: var(--foreground);
    }
    
    .newsletter-image {
        display: none;
    }
    
    @media (min-width: 768px) {
        .newsletter-image {
            display: block;
        }
    }
    
    .newsletter-image img {
        width: 100%;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }
    
    .floating {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
</style>

<script>
    // Contador regressivo
    function updateCountdown() {
        const days = document.getElementById('days');
        const hours = document.getElementById('hours');
        const minutes = document.getElementById('minutes');
        const seconds = document.getElementById('seconds');
        
        const now = new Date();
        const target = new Date();
        target.setDate(now.getDate() + 5);
        
        const diff = target - now;
        
        const d = Math.floor(diff / (1000 * 60 * 60 * 24));
        const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const s = Math.floor((diff % (1000 * 60)) / 1000);
        
        days.textContent = d.toString().padStart(2, '0');
        hours.textContent = h.toString().padStart(2, '0');
        minutes.textContent = m.toString().padStart(2, '0');
        seconds.textContent = s.toString().padStart(2, '0');
    }
    
    setInterval(updateCountdown, 1000);
    updateCountdown();
    
    // Filtros
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Em uma implementação real, filtraria os produtos
            // Por enquanto apenas um efeito visual
            const filter = this.dataset.filter;
            showNotification(`Mostrando: ${filter === 'all' ? 'Todas' : filter === 'high-discount' ? 'Maior desconto' : 'Mais vendidos'}`, 'info');
        });
    });
    
    // Newsletter
    function handleNewsletter(event) {
        event.preventDefault();
        const email = event.target.querySelector('input[type="email"]').value;
        
        if (subscribeNewsletter(email)) {
            event.target.reset();
        }
    }
</script>

<?php
$content = ob_get_clean();
include 'template.php';
?>