<?php
require_once 'config.php';

$pageTitle = "Contato - TechStore";

// Processar formulário de contato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    // Aqui você implementaria o envio de email
    // Por enquanto, apenas simulamos o sucesso
    $success = true;
    $message = $success ? 
        'Mensagem enviada com sucesso! Entraremos em contato em até 24 horas.' : 
        'Erro ao enviar mensagem. Tente novamente.';
    
    $alertType = $success ? 'success' : 'error';
    $alertIcon = $success ? 'check-circle' : 'exclamation-circle';
}

ob_start();
?>

<!-- Hero Section -->
<section class="hero-contact">
    <div class="container">
        <div class="hero-content">
            <div>
                <h1 style="margin-bottom: 1rem;">
                    Estamos aqui para <span class="highlight">Ajudar</span>
                </h1>
                <p class="hero-subtitle" style="font-size: 1.125rem; margin-bottom: 2rem;">
                    Tem alguma dúvida ou precisa de suporte? Nossa equipe está pronta para atender você.
                </p>
                <div class="contact-stats">
                    <div class="contact-stat">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-title">Resposta Rápida</div>
                            <div class="stat-desc">Média de 2 horas</div>
                        </div>
                    </div>
                    <div class="contact-stat">
                        <div class="stat-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-title">Suporte 24/7</div>
                            <div class="stat-desc">Chat e telefone</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-image-container">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&auto=format&fit=crop&q=80" 
                     alt="Suporte TechStore" 
                     class="hero-image">
            </div>
        </div>
    </div>
</section>

<!-- Formulário de Contato -->
<section>
    <div class="container">
        <div class="contact-container">
            <!-- Formulário -->
            <div class="contact-form-container">
                <?php if (isset($success)): ?>
                    <div class="alert alert-<?php echo $alertType; ?>" style="margin-bottom: 2rem;">
                        <i class="fas fa-<?php echo $alertIcon; ?>"></i>
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <div class="contact-form-header">
                    <h2>Envie uma Mensagem</h2>
                    <p class="text-muted">Preencha o formulário abaixo e entraremos em contato</p>
                </div>
                
                <form class="contact-form" method="POST" action="">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-user"></i> Nome Completo
                            </label>
                            <input type="text" id="name" name="name" required 
                                   placeholder="Seu nome completo">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <input type="email" id="email" name="email" required 
                                   placeholder="seu@email.com">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">
                            <i class="fas fa-tag"></i> Assunto
                        </label>
                        <select id="subject" name="subject" required>
                            <option value="">Selecione um assunto</option>
                            <option value="suporte">Suporte Técnico</option>
                            <option value="vendas">Dúvidas sobre Produtos</option>
                            <option value="pedidos">Status do Pedido</option>
                            <option value="devolucoes">Devoluções e Trocas</option>
                            <option value="parcerias">Parcerias Comerciais</option>
                            <option value="outros">Outros Assuntos</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">
                            <i class="fas fa-comment"></i> Mensagem
                        </label>
                        <textarea id="message" name="message" rows="5" required 
                                  placeholder="Descreva sua dúvida ou solicitação..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-paper-plane"></i> Enviar Mensagem
                    </button>
                </form>
            </div>
            
            <!-- Informações de Contato -->
            <div class="contact-info-container">
                <div class="contact-info-card">
                    <h2>Contactos</h2>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="method-info">
                                <h3>Endereço</h3>
                                <p>Rua da Tecnologia, 123<br>
                                   Vila das Aves<br>
                                   4430-000 Portugal</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="method-info">
                                <h3>Telefone</h3>
                                <p>+351 123 456 789<br>
                                   Segunda a Sexta: 9h - 18h<br>
                                   Sábado: 10h - 14h</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="method-info">
                                <h3>Email</h3>
                                <p>contato@techstore.pt<br>
                                   suporte@techstore.pt<br>
                                   vendas@techstore.pt</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-section">
                        <h3><i class="fas fa-share-alt"></i> Siga-nos</h3>
                        <div class="social-links">
                            <a href="#" class="social-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section style="background: var(--background-secondary);">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
            <h2>
                <i class="fas fa-question-circle" style="color: var(--primary);"></i>
                Perguntas Frequentes
            </h2>
            <p class="text-muted" style="max-width: 600px; margin: 1rem auto;">
                Encontre respostas rápidas para as dúvidas mais comuns
            </p>
        </div>
        
        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question">
                    <span>Quais são os métodos de pagamento aceitos?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Aceitamos cartões de crédito/débito (Visa, Mastercard, American Express), PayPal, MB Way e transferência bancária. Todos os pagamentos são processados de forma segura com criptografia SSL.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    <span>Qual o prazo de entrega?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>O prazo de entrega varia de 2 a 5 dias úteis para Portugal Continental. Para as ilhas e outros países da UE, o prazo é de 5 a 10 dias úteis. Você receberá um código de rastreamento assim que seu pedido for enviado.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    <span>Como funciona a política de devolução?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Oferecemos 30 dias para devolução a partir da data de recebimento. O produto deve estar em perfeitas condições, com todas as embalagens e acessórios originais. O reembolso é processado em até 14 dias úteis.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <button class="faq-question">
                    <span>Oferecem garantia nos produtos?</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>Sim, todos os produtos possuem garantia do fabricante que varia de 1 a 3 anos, dependendo do produto. Além disso, oferecemos suporte técnico gratuito durante o período de garantia.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mapa -->
<section>
    <div class="container">
        <div class="map-container">
            <div class="section-header" style="text-align: center; margin-bottom: 3rem;">
             <h2 style="margin-bottom: 1rem; text-align: center;">
                Nossa <span class="highlight">Localização</span>
            </h2>
            </div>
            <div class="map-wrapper">
                <!-- Mapa do Google Maps (substitua com seu embed real) -->
                <div class="map-placeholder">
                    <div style="padding: 2rem; text-align: center; background: var(--border); border-radius: var(--radius);">
                        <i class="fas fa-map" style="font-size: 3rem; color: var(--muted); margin-bottom: 1rem;"></i>
                        <h3>Mapa da Localização</h3>
                        <p class="text-muted">Rua da Tecnologia, 123 - Vila das Aves</p>
                        <a href="https://maps.google.com/?q=Vila+das+Aves+Portugal" 
                           target="_blank" 
                           class="btn btn-secondary" 
                           style="margin-top: 1rem;">
                            <i class="fas fa-external-link-alt"></i> Abrir no Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-contact {
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
    
    .contact-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .contact-stat {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: var(--card);
        padding: 1rem;
        border-radius: var(--radius);
        border: 1px solid var(--border);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    
    .stat-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .stat-desc {
        font-size: 0.875rem;
        color: var(--muted);
    }
    
    .contact-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    
    @media (min-width: 992px) {
        .contact-container {
            grid-template-columns: 2fr 1fr;
        }
    }
    
    .contact-form-container {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        box-shadow: var(--shadow);
    }
    
    .contact-form-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    @media (min-width: 768px) {
        .contact-form-header {
            text-align: left;
        }
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    @media (min-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    
    .contact-form .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .contact-form input,
    .contact-form select,
    .contact-form textarea {
        width: 100%;
        padding: 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: var(--background);
        color: var(--foreground);
        font-size: 1rem;
        transition: all 0.3s;
    }
    
    .contact-form input:focus,
    .contact-form select:focus,
    .contact-form textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    
    .contact-info-container {
        position: relative;
    }
    
    @media (min-width: 992px) {
        .contact-info-container {
            position: sticky;
            top: 100px;
        }
    }
    
    .contact-info-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        height: 100%;
    }
    
    .contact-methods {
        margin: 2rem 0;
    }
    
    .contact-method {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }
    
    .contact-method:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    
    .method-icon {
        width: 50px;
        height: 50px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .method-info h3 {
        font-size: 1rem;
        margin-bottom: 0.5rem;
        color: var(--primary);
    }
    
    .method-info p {
        color: var(--muted);
        font-size: 0.875rem;
        line-height: 1.6;
    }
    
    .social-section {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border);
    }
    
    .social-links {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .social-link {
        width: 40px;
        height: 40px;
        background: var(--border);
        color: var(--foreground);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .social-link:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }
    
    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .faq-item {
        margin-bottom: 1rem;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
    }
    
    .faq-question {
        width: 100%;
        padding: 1.5rem;
        background: var(--card);
        border: none;
        text-align: left;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        color: var(--foreground);
        transition: background 0.3s;
    }
    
    .faq-question:hover {
        background: var(--card-hover);
    }
    
    .faq-question i {
        transition: transform 0.3s;
    }
    
    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }
    
    .faq-answer {
        padding: 0 1.5rem;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s;
        background: var(--background);
    }
    
    .faq-item.active .faq-answer {
        padding: 1.5rem;
        max-height: 500px;
    }
    
    .map-container {
        margin-top: 3rem;
    }
    
    .map-wrapper {
        margin-top: 2rem;
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }
    
    .alert {
        padding: 1rem 1.5rem;
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .alert-success {
        background: var(--success-light);
        border: 1px solid var(--success);
        color: var(--success);
    }
    
    .alert-error {
        background: var(--danger-light);
        border: 1px solid var(--danger);
        color: var(--danger);
    }
</style>

<script>
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const item = button.parentElement;
            item.classList.toggle('active');
        });
    });
    
    // Form validation
    document.querySelector('.contact-form').addEventListener('submit', function(e) {
        const email = this.querySelector('#email').value;
        const message = this.querySelector('#message').value;
        
        if (!isValidEmail(email)) {
            e.preventDefault();
            showNotification('Por favor, insira um email válido', 'error');
            return;
        }
        
        if (message.length < 10) {
            e.preventDefault();
            showNotification('A mensagem deve ter pelo menos 10 caracteres', 'error');
            return;
        }
    });
    
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
</script>

<?php
$content = ob_get_clean();
include 'template.php';
?>