<?php
require_once 'config.php';

$pageTitle = "Sobre Nós - TechStore";

ob_start();
?>

<!-- Hero Section -->
<section class="hero-about">
    <div class="container">
        <div class="hero-content">
            <div>
                <h1 style="margin-bottom: 1rem;">
                    <span class="highlight">Inovação</span> que conecta<br>
                    o <span class="typewriter-text">Futuro!</span>
                </h1>
                <p class="hero-subtitle" style="font-size: 1.125rem; margin-bottom: 2rem;">
                    Somos mais que uma loja de tecnologia. Somos uma plataforma 
                    que transforma a maneira como você interage com o mundo digital.
                </p>
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Anos de Experiência</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">5K+</div>
                        <div class="stat-label">Clientes Satisfeitos</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Produtos Premium</div>
                    </div>
                </div>
            </div>
            <div class="hero-image-container">
                <img src="https://images.unsplash.com/photo-1556740714-a8395b3bf30f?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                     alt="Equipe TechStore" 
                     class="hero-image">
            </div>
        </div>
    </div>
</section>

<!-- Nossa História -->
<section>
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <h2>
                Nossa <span class="highlight">História</span>
            </h2>
            <p class="text-muted" style="max-width: 600px; margin: 1rem auto;">
                Da paixão por tecnologia a uma das maiores lojas online de Portugal
            </p>
        </div>
        
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-year">2015</div>
                <div class="timeline-content">
                    <h3>O Começo</h3>
                    <p>Fundada por três amigos apaixonados por tecnologia em Vila das Aves, Portugal.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2017</div>
                <div class="timeline-content">
                    <h3>Primeira Loja Online</h3>
                    <p>Lançamento da nossa plataforma e-commerce com foco em produtos premium.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2020</div>
                <div class="timeline-content">
                    <h3>Expansão Internacional</h3>
                    <p>Começamos a enviar para toda Europa com parceiros logísticos premium.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2023</div>
                <div class="timeline-content">
                    <h3>Reconhecimento</h3>
                    <p>Premiada como "Melhor E-commerce de Tecnologia" pelo Tech Awards Portugal.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-year">2025</div>
                <div class="timeline-content">
                    <h3>Futuro</h3>
                    <p>Expansão para realidade aumentada e experiência de compra imersiva.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Valores -->
<section style="background: var(--background-secondary);">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <h2>
                Nossos <span class="highlight">Valores</span> 
            </h2>
        </div>
        
        <div class="grid grid-4">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Excelência</h3>
                <p class="text-muted">Só trabalhamos com produtos das melhores marcas e qualidade comprovada.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h3>Confiança</h3>
                <p class="text-muted">Transparência em todas as transações e comunicação clara com nossos clientes.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <h3>Inovação</h3>
                <p class="text-muted">Sempre à frente das tendências tecnológicas para oferecer o que há de melhor.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Comunidade</h3>
                <p class="text-muted">Criamos uma comunidade de entusiastas de tecnologia que compartilham conhecimento.</p>
            </div>
        </div>
    </div>
</section>

<!-- Equipe -->
<section>
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <h2>
                Conheça Nossa <span class="highlight">Equipe</span>
            </h2>
            <p class="text-muted" style="max-width: 600px; margin: 1rem auto;">
                Profissionais apaixonados por tecnologia e comprometidos com sua satisfação
            </p>
        </div>
        
        <div class="grid grid-3">
            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1473830394358-91588751b241?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                         alt="Lucas Ramos">
                </div>
                <div class="team-info">
                    <h3>Lucas Ramos</h3>
                    <p class="team-role">CEO & Fundador</p>
                    <p class="text-muted">15+ anos em tecnologia e e-commerce</p>
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1483884105135-c06ea81a7a80?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                         alt="Daniela Pinto">
                </div>
                <div class="team-info">
                    <h3>Daniela Pinto</h3>
                    <p class="team-role">CTO</p>
                    <p class="text-muted">Especialista em inovação e experiência do usuário</p>
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="team-card">
                <div class="team-image">
                    <img src="https://images.unsplash.com/photo-1508145622095-70bb7b2d59cb?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" 
                         alt="Beatriz Martins">
                </div>
                <div class="team-info">
                    <h3>Beatriz Martins</h3>
                    <p class="team-role">Head of Customer Success</p>
                    <p class="text-muted">Garantindo a melhor experiência para nossos clientes</p>
                    <div class="team-social">
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-card">
            <div class="cta-content">
                <h2 style="margin-bottom: 1rem;">
                    Pronto para Transformar sua Experiência Digital?
                </h2>
                <p class="text-muted" style="margin-bottom: 2rem;">
                    Junte-se a milhares de clientes satisfeitos e descubra o melhor da tecnologia
                </p>
                <div class="cta-buttons">
                    <a href="products.php" class="btn btn-primary btn-large">
                        <i class="fas fa-shopping-bag"></i> Começar a Comprar
                    </a>
                    <a href="contact.php" class="btn btn-secondary btn-large">
                        <i class="fas fa-envelope"></i> Fale Conosco
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-about {
        padding: 4rem 0;
        background: linear-gradient(135deg, var(--primary-light) 0%, transparent 100%);
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
    
    .hero-image {
        width: 100%;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
    }
    
    .stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: var(--muted);
    }
    
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--primary);
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding-left: 80px;
    }
    
    .timeline-year {
        position: absolute;
        left: 0;
        top: 0;
        width: 60px;
        height: 60px;
        background: var(--primary);
        color: var(--background);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        z-index: 2;
    }
    
    .timeline-content {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 1.5rem;
        box-shadow: var(--shadow);
    }
    
    .timeline-content h3 {
        margin-bottom: 0.5rem;
        color: var(--primary);
    }
    
    .value-card {
        text-align: center;
        padding: 2rem 1rem;
    }
    
    .value-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--primary);
    }
    
    .team-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        transition: all 0.3s;
    }
    
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .team-image {
        width: 100%;
        height: 250px;
        overflow: hidden;
    }
    
    .team-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }
    
    .team-card:hover .team-image img {
        transform: scale(1.05);
    }
    
    .team-info {
        padding: 1.5rem;
        text-align: center;
    }
    
    .team-role {
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .team-social {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 1rem;
    }
    
    .team-social a {
        color: var(--muted);
        font-size: 1.125rem;
        transition: color 0.3s;
    }
    
    .team-social a:hover {
        color: var(--primary);
    }
    
    .cta-section {
        padding: 4rem 0;
    }
    
    .cta-card {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-lg);
        padding: 4rem;
        text-align: center;
        color: white;
    }
    
    .cta-content .text-muted {
        color: rgba(255, 255, 255, 0.8);
    }
    
    .cta-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .cta-buttons .btn-primary {
        background: white;
        color: var(--primary);
    }
    
    .cta-buttons .btn-secondary {
        background: transparent;
        border: 2px solid white;
        color: white;
    }
</style>

<?php
$content = ob_get_clean();
include 'template.php';
?>