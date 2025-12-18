# TechStore - E-commerce em HTML, CSS, JavaScript e PHP

![Banner](techstore/techstore-php/techstore.jpg)

Uma loja online completa e funcional desenvolvida com HTML, CSS, JavaScript e PHP. Inclui todas as funcionalidades essenciais de um e-commerce moderno.

## 🚀 Características

### Páginas Implementadas
- **Home** - Página inicial com produtos em destaque
- **Produtos** - Catálogo completo com filtros e busca
- **Categorias** - Navegação por categorias
- **Ofertas** - Produtos em promoção
- **Carrinho** - Gerenciamento de itens
- **Checkout** - Processo de compra com múltiplos métodos de pagamento
- **Login/Registro** - Autenticação de usuários
- **Perfil** - Página de usuário com histórico de pedidos
- **Wishlist** - Lista de favoritos
- **Sobre** - Informações sobre a loja
- **Contato** - Formulário de contato

### Funcionalidades
✅ Tema claro/escuro com persistência
✅ Carrinho de compras com armazenamento local
✅ Wishlist/Favoritos
✅ Sistema de autenticação (Login/Registro)
✅ Checkout com 4 métodos de pagamento:
   - Cartão de Crédito
   - PayPal
   - Transferência Bancária
   - MB Way
✅ Filtros avançados de produtos
✅ Busca em tempo real
✅ Newsletter
✅ Sistema de avaliações
✅ Histórico de pedidos
✅ Perfil de usuário personalizável

## 📋 Requisitos

- PHP 7.4 ou superior
- Servidor web (Apache, Nginx, etc.)
- Navegador moderno com suporte a JavaScript

## 🔧 Instalação

### 1. Clonar/Baixar o Projeto
```bash
git clone <repository-url>
cd techstore-php
```

### 2. Configurar o Servidor Web

#### Com PHP Built-in (Desenvolvimento)
```bash
php -S localhost:8000
```

Acesse: `http://localhost:8000`

#### Com Apache
1. Copie a pasta para o diretório `htdocs` (ou equivalente)
2. Configure o VirtualHost (opcional)
3. Acesse através do navegador

### 3. Estrutura de Pastas
```
techstore-php/
├── index.html              # Página inicial
├── products.html           # Catálogo de produtos
├── categories.html         # Categorias
├── offers.html            # Ofertas
├── cart.html              # Carrinho
├── checkout.html          # Checkout
├── login.html             # Login
├── register.html          # Registro
├── profile.html           # Perfil do usuário
├── wishlist.html          # Favoritos
├── about.html             # Sobre
├── contact.html           # Contato
├── css/
│   └── style.css          # Estilos principais
├── js/
│   └── main.js            # JavaScript principal
├── php/
│   ├── config.php         # Configuração
│   └── api/
│       ├── products.php   # API de produtos
│       ├── cart.php       # API de carrinho
│       ├── wishlist.php   # API de wishlist
│       ├── auth.php       # API de autenticação
│       ├── orders.php     # API de pedidos
│       ├── reviews.php    # API de avaliações
│       ├── search.php     # API de busca
│       └── newsletter.php # API de newsletter
└── data/                  # Dados persistentes (criado automaticamente)
```

## 🎨 Tema

O projeto suporta tema claro e escuro. Clique no botão 🌙/☀️ no header para alternar.

## 🛒 Funcionalidades do Carrinho

- Adicionar/remover produtos
- Ajustar quantidades
- Cálculo automático de totais
- Armazenamento local (localStorage)
- Sincronização com servidor

## 💳 Métodos de Pagamento

### Cartão de Crédito
- Formulário com validação de campos
- Suporte para principais bandeiras

### PayPal
- Redirecionamento para PayPal
- Integração simulada

### Transferência Bancária
- Dados bancários fornecidos após pedido
- Confirmação manual

### MB Way
- Número de telefone para confirmação
- Integração simulada

## 👤 Autenticação

### Registro
- Validação de email
- Confirmação de senha
- Armazenamento seguro com hash

### Login
- Email e senha
- Sessão persistente
- Recuperação de dados do usuário

## 📱 Responsividade

O projeto é totalmente responsivo e funciona em:
- Desktop
- Tablet
- Mobile

## 🔐 Segurança

- Senhas com hash bcrypt
- Validação de entrada
- Proteção contra XSS
- Sessões seguras

## 📊 Dados

Os dados são armazenados em arquivos JSON na pasta `data/`:
- `users.json` - Usuários registrados
- `products.json` - Catálogo de produtos
- `orders.json` - Pedidos realizados
- `cart_*.json` - Carrinhos de usuários
- `wishlist_*.json` - Listas de favoritos
- `reviews.json` - Avaliações de produtos
- `newsletter.json` - Inscritos na newsletter

## 🚀 Deployment

### Heroku
```bash
git push heroku main
```

### Vercel
```bash
vercel deploy
```

### DigitalOcean/AWS
1. Faça upload dos arquivos via SFTP
2. Configure o servidor web
3. Defina permissões de pasta `data/` (755)

## 🐛 Troubleshooting

### Erro: "Permission denied" na pasta data
```bash
chmod 755 data/
```

### Carrinho não persiste
- Verifique se localStorage está habilitado
- Limpe o cache do navegador

### Emails não funcionam
- Integre um serviço de email (SendGrid, Mailgun)
- Configure as credenciais em `php/config.php`

## 📝 Customização

### Alterar Cores
Edite as variáveis CSS em `css/style.css`:
```css
:root {
    --primary: #FFD700;
    --background: #1a1a1a;
    --foreground: #ffffff;
    /* ... */
}
```

### Adicionar Produtos
Edite a função `getProducts()` em `php/config.php`

### Alterar Métodos de Pagamento
Modifique `checkout.html` e `php/api/orders.php`

## 📚 Documentação

### API Endpoints

#### Produtos
- `GET /php/api/products.php` - Listar produtos
- `GET /php/api/products.php?id=1` - Obter produto específico
- `GET /php/api/products.php?featured=true` - Produtos em destaque

#### Carrinho
- `GET /php/api/cart.php` - Obter carrinho
- `POST /php/api/cart.php` - Adicionar/remover/atualizar

#### Autenticação
- `POST /php/api/auth.php` - Login/Registro
- `GET /php/api/auth.php?action=check` - Verificar login

#### Pedidos
- `GET /php/api/orders.php` - Listar pedidos do usuário
- `POST /php/api/orders.php` - Criar novo pedido

#### Busca
- `GET /php/api/search.php?q=termo` - Buscar produtos

#### Avaliações
- `GET /php/api/reviews.php?productId=1` - Obter avaliações
- `POST /php/api/reviews.php` - Adicionar avaliação

## 🤝 Contribuição

Contribuições são bem-vindas! Sinta-se livre para:
- Reportar bugs
- Sugerir melhorias
- Enviar pull requests

## 📄 Licença

Este projeto está sob licença MIT. Veja o arquivo LICENSE para mais detalhes.

## 📞 Suporte

Para suporte, abra uma issue no repositório ou entre em contato através do formulário de contato da loja.

## 🎯 Roadmap

- [ ] Integração com gateway de pagamento real
- [ ] Sistema de cupons e descontos
- [ ] Recomendações personalizadas
- [ ] Chat ao vivo
- [ ] App mobile
- [ ] Integração com redes sociais
- [ ] Analytics avançado

---

**Desenvolvido com ❤️ para uma melhor experiência de compra online**
