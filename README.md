# 🚀 HSEvents - Plataforma de Gerenciamento de Eventos

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

<br>

![Screenshot do Dashboard](https://i.imgur.com/uGzJg28.png)
*Painel de controle analítico com métricas de vendas e gráficos dinâmicos.*

## 📖 Sobre o Projeto

**HSEvents** é uma plataforma web completa e dinâmica desenvolvida para a criação, gerenciamento e divulgação de eventos. A aplicação conta com um sistema de autenticação de usuários, um painel de controle analítico para o gerenciamento de eventos (CRUD), e uma interface pública com galeria, detalhes de eventos e um sistema de e-commerce para a "venda" de ingressos e produtos.

O projeto foi construído com foco em uma interface moderna, responsiva e uma experiência de usuário fluida, utilizando PHP no backend para a lógica de negócios e JavaScript para interatividade e visualização de dados no frontend.

---

## ✨ Funcionalidades Principais

* **👤 Sistema de Autenticação Completo:**
    * Cadastro de novos usuários com upload de foto de perfil.
    * Login seguro com verificação de senhas criptografadas (`password_hash` e `password_verify`).
    * Sessões de usuário e sistema de Logout.

* **🖥️ Dashboard Analítico com Gráficos:**
    * Painel de controle que exibe métricas em tempo real: Faturamento Total, Ingressos Vendidos, Eventos Criados e Ticket Médio.
    * Gráficos dinâmicos (criados com Chart.js) para visualização de Faturamento Mensal e Top 5 Eventos mais vendidos.
    * Animações nos contadores para uma experiência mais dinâmica.

* **✍️ Gerenciamento de Eventos (CRUD):**
    * Formulários para **C**riar, **E**ditar e **E**xcluir eventos.
    * Upload de imagens para cada evento, com geração de nomes de arquivo únicos.
    * Validação de segurança para garantir que um usuário só possa gerenciar seus próprios eventos.

* **🛒 E-commerce e Carrinho de Compras:**
    * Sistema de carrinho de compras funcional em todas as páginas públicas.
    * Adição de ingressos e produtos ao carrinho.
    * Cálculo de subtotal e processamento de pedidos com armazenamento no banco de dados.
    * Validação de itens e preços no lado do servidor para maior segurança.

* **🖼️ Interface Pública Dinâmica e Profissional:**
    * **Página Home** com seções dinâmicas e animações de scroll.
    * **Galeria de Eventos** com busca por nome e paginação implícita.
    * **Página de Detalhes** para cada evento.
    * **Menu de Navegação Responsivo** ("hambúrguer") que se adapta a telas de celular.
    * **Notificações "Toast"** para feedback de ações do usuário (ex: "Item adicionado!", "Evento excluído!").

---

## 🛠️ Tecnologias Utilizadas

* **Backend:**
    * **PHP 8+**
    * **PDO** para conexão segura com o banco de dados e prevenção de SQL Injection.
* **Frontend:**
    * **HTML5**
    * **CSS3** (Flexbox, Grid, Variáveis CSS, Animações, Gradientes)
    * **JavaScript (ES6+)** (DOM, Eventos, `localStorage`, `fetch`, `FileReader` API)
* **Banco de Dados:**
    * **MySQL** ou **MariaDB**
* **Bibliotecas e Ferramentas:**
    * [**Chart.js**](https://www.chartjs.org/) para a criação dos gráficos do dashboard.
    * [**Swiper.js**](https://swiperjs.com/) para o carrossel de imagens da galeria.
    * [Google Fonts (Poppins)](https://fonts.google.com/specimen/Poppins)
    * [Font Awesome](https://fontawesome.com/) & [Ionicons](https://ionic.io/ionicons) para ícones.

---

## ⚙️ Instalação e Configuração

**Pré-requisitos:**
* Um ambiente de desenvolvimento local como [XAMPP](https://www.apachefriends.org/index.html) ou WAMP.
* PHP 8 ou superior.
* Um servidor de banco de dados MySQL ou MariaDB.

**Passos:**

1.  **Clone o repositório.**

2.  **Banco de Dados:**
    * Crie um novo banco de dados (ex: `dbevento`).
    * Execute o script SQL abaixo para criar **todas** as tabelas necessárias com a estrutura correta.

    ```sql
    -- Tabela de usuários
    CREATE TABLE `tbusuario` (
      `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
      `nomeUsuario` varchar(255) NOT NULL,
      `emailUsuario` varchar(255) NOT NULL,
      `senhaUsuario` varchar(255) NOT NULL,
      `foto` varchar(255) DEFAULT NULL,
      `idadeUsuario` int(11) DEFAULT NULL,
      PRIMARY KEY (`idUsuario`),
      UNIQUE KEY `emailUsuario_UNIQUE` (`emailUsuario`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Tabela de eventos
    CREATE TABLE `tbcadevento` (
      `idCadEvento` int(11) NOT NULL AUTO_INCREMENT,
      `nomeCadEvento` varchar(255) NOT NULL,
      `dataCadEvento` date NOT NULL,
      `descCadEvento` text NOT NULL,
      `fotoCadEvento` varchar(255) NOT NULL,
      `precoCadEvento` decimal(10,2) NOT NULL DEFAULT 49.90,
      `idUsuario` int(11) NOT NULL,
      PRIMARY KEY (`idCadEvento`),
      KEY `fk_evento_usuario_idx` (`idUsuario`),
      CONSTRAINT `fk_evento_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Tabela de produtos
    CREATE TABLE `tbprodutos` (
      `idProduto` int(11) NOT NULL AUTO_INCREMENT,
      `nomeProduto` varchar(150) NOT NULL,
      `precoProduto` decimal(10,2) NOT NULL,
      `imagemProduto` varchar(255) NOT NULL,
      PRIMARY KEY (`idProduto`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Tabela de pedidos
    CREATE TABLE `tbpedidos` (
      `idPedido` int(11) NOT NULL AUTO_INCREMENT,
      `idUsuario` int(11) NOT NULL,
      `valorTotal` decimal(10,2) NOT NULL,
      `formaPagamento` varchar(50) NOT NULL,
      `dataPedido` timestamp NOT NULL DEFAULT current_timestamp(),
      PRIMARY KEY (`idPedido`),
      KEY `fk_pedido_usuario_idx` (`idUsuario`),
      CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Tabela de itens do pedido
    CREATE TABLE `tbpedidos_itens` (
      `idItemPedido` int(11) NOT NULL AUTO_INCREMENT,
      `idPedido` int(11) NOT NULL,
      `idCadEvento` int(11) DEFAULT NULL,
      `idProduto` int(11) DEFAULT NULL,
      `quantidade` int(11) NOT NULL,
      `precoUnitario` decimal(10,2) NOT NULL,
      PRIMARY KEY (`idItemPedido`),
      KEY `fk_item_pedido_idx` (`idPedido`),
      KEY `fk_item_evento_idx` (`idCadEvento`),
      KEY `fk_item_produto_idx` (`idProduto`),
      CONSTRAINT `fk_item_evento` FOREIGN KEY (`idCadEvento`) REFERENCES `tbcadevento` (`idCadEvento`) ON DELETE SET NULL ON UPDATE CASCADE,
      CONSTRAINT `fk_item_pedido` FOREIGN KEY (`idPedido`) REFERENCES `tbpedidos` (`idPedido`) ON DELETE CASCADE ON UPDATE CASCADE,
      CONSTRAINT `fk_item_produto` FOREIGN KEY (`idProduto`) REFERENCES `tbprodutos` (`idProduto`) ON DELETE SET NULL ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

3.  **Configuração da Conexão:**
    * Abra o arquivo `conexao.php`.
    * Altere as variáveis com as credenciais do seu banco de dados.

4.  **Acesse a Aplicação:**
    * Inicie o Apache e o MySQL.
    * Acesse `http://localhost/sua-pasta/` no navegador.

---
## 📂 Estrutura do Projeto

A estrutura de arquivos do projeto está organizada da seguinte forma, com uma pasta para cada tipo de recurso público e os arquivos PHP na raiz.

/ (pasta raiz do projeto, ex: 'banco/')
├── Styles/
│   ├── main.css         (Estilos globais: navbar, footer, etc.)
│   ├── carrinho.css
│   ├── auth.css         (Estilos para login e cadastro)
│   ├── galeria.css      (Estilos específicos da galeria)
│   └── ...              (e outros arquivos de estilo)
│
├── js/
│   ├── main.js          (Scripts globais: animações, etc.)
│   ├── carrinho.js
│   ├── galeria.js       (Scripts específicos da galeria)
│   └── auth.js          (Scripts para preview de imagem no cadastro)
│
├── img/
│   └── (Imagens estáticas do site: logo, background, etc.)
│
├── uploads/
│   └── (Imagens dos eventos e perfis enviadas pelos usuários)
│
├── conexao.php
├── config.php
├── index.php (Home)
├── login.php
├── cadastro.php
├── galeria.php
├── dashboard.php
├── logout.php
├── processa_login.php
├── processa_cadastro.php
└── ... (e todos os outros arquivos .php)

--

## 👨‍💻 Autor

Feito com ❤️ por **Hyago I. F. Silva**

[![LinkedIn](https://img.shields.io/badge/linkedin-%230077B5.svg?style=for-the-badge&logo=linkedin&logoColor=white)](https://br.linkedin.com/in/hyagoinaciofarias?trk=people-guest_people_search-card)

---

## 📄 Licença

Distribuído sob a licença MIT.