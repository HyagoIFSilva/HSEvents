# 🚀HSEvents


![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)

<br>

![Screenshot da Aplicação](https://i.imgur.com/w1iLg9i.png)
*Tela principal da galeria de eventos do usuário.*

## 📖 Sobre o Projeto

**Eventos Gamer** é uma plataforma web completa e dinâmica desenvolvida para a criação, gerenciamento e divulgação de eventos. A aplicação conta com um sistema de autenticação de usuários, um painel de controle para o gerenciamento de eventos (CRUD), e uma interface pública com galeria e um sistema de e-commerce para a "venda" de ingressos.

O projeto foi construído com foco em uma interface moderna, responsiva e uma experiência de usuário fluida, utilizando PHP no backend para a lógica de negócios e JavaScript para interatividade no frontend.

---

## ✨ Funcionalidades Principais

* **👤 Sistema de Autenticação:** Cadastro e Login de usuários com senhas criptografadas.
* **🖥️ Painel de Controle (Dashboard):** Área restrita onde o usuário logado pode gerenciar seus eventos.
* **✍️ CRUD de Eventos:** Funcionalidade completa para Criar, Ler, Atualizar e Deletar eventos, com upload de imagens.
* **🖼️ Galeria Dinâmica:** Uma galeria de eventos moderna e responsiva, com um carrossel dinâmico que exibe os eventos cadastrados pelo usuário.
* **🛒 Carrinho de Compras:** Sistema de e-commerce no frontend que permite adicionar "ingressos" de eventos a um carrinho lateral, com persistência de dados no `localStorage`.
* **🎨 Interface Moderna:** Design com tema escuro, paleta de cores coesa, animações e efeitos de hover para uma experiência de usuário profissional.
* **📱 Design Responsivo:** A interface se adapta para uma visualização agradável em desktops, tablets e celulares.

---

## 🛠️ Tecnologias Utilizadas

Este projeto foi construído com as seguintes tecnologias:

* **Backend:**
    * **PHP 8+**
    * **PDO** para conexão segura com o banco de dados.
* **Frontend:**
    * **HTML5**
    * **CSS3** (Flexbox, Grid, Variáveis CSS, Animações)
    * **JavaScript (ES6+)** (Manipulação do DOM, Eventos, `localStorage`)
* **Banco de Dados:**
    * **MySQL** ou **MariaDB**
* **Bibliotecas e Ferramentas:**
    * [Google Fonts (Poppins)](https://fonts.google.com/specimen/Poppins)
    * [Font Awesome](https://fontawesome.com/) (Ícones)
    * [ionicons](https://ionic.io/ionicons) (Ícones na tela de login)

---

## ⚙️ Instalação e Configuração

Para rodar este projeto localmente, siga os passos abaixo:

**Pré-requisitos:**
* Um ambiente de desenvolvimento local como [XAMPP](https://www.apachefriends.org/index.html) ou WAMP.
* PHP 8 ou superior.
* Um servidor de banco de dados MySQL ou MariaDB.

**Passos:**

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/seu-usuario/seu-repositorio.git](https://github.com/seu-usuario/seu-repositorio.git)
    ```

2.  **Mova o projeto:**
    * Mova a pasta do projeto para o diretório raiz do seu servidor web (ex: `htdocs` no XAMPP).

3.  **Banco de Dados:**
    * Crie um novo banco de dados no seu servidor (ex: `bd_eventos_gamer`).
    * Execute o seguinte script SQL para criar as tabelas necessárias:

    ```sql
    -- Tabela de usuários
    CREATE TABLE `tbusuario` (
      `idUsuario` INT(11) NOT NULL AUTO_INCREMENT,
      `nomeUsuario` VARCHAR(100) NOT NULL,
      `emailUsuario` VARCHAR(100) NOT NULL UNIQUE,
      `senhaUsuario` VARCHAR(255) NOT NULL,
      `foto` VARCHAR(255) DEFAULT 'default.png',
      PRIMARY KEY (`idUsuario`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

    -- Tabela de eventos
    CREATE TABLE `tbcadevento` (
      `idCadEvento` INT(11) NOT NULL AUTO_INCREMENT,
      `nomeCadEvento` VARCHAR(150) NOT NULL,
      `dataCadEvento` DATE NOT NULL,
      `descCadEvento` TEXT NOT NULL,
      `fotoCadEvento` VARCHAR(255) NOT NULL,
      `idUsuario` INT(11) NOT NULL,
      PRIMARY KEY (`idCadEvento`),
      FOREIGN KEY (`idUsuario`) REFERENCES `tbusuario`(`idUsuario`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

4.  **Configuração da Conexão:**
    * Abra o arquivo `conexao.php`.
    * Altere as variáveis `$banco`, `$usuario`, e `$senha` com as credenciais do seu banco de dados local.

5.  **Acesse a Aplicação:**
    * Inicie os serviços do Apache e MySQL no seu painel XAMPP.
    * Abra o seu navegador e acesse `http://localhost/nome-da-pasta-do-projeto/`.

---

## 📂 Estrutura do Projeto
/

├── Styles/
│   ├── galeria.css
│   ├── login.css
│   ├── carrinho.css
│   └── ... (outros arquivos css)
├── js/
│   ├── galeria.js
│   └── carrinho.js
├── img/
│   └── (imagens estáticas do site)
├── uploads/
│   └── (imagens dos eventos e perfis enviadas pelos usuários)
├── conexao.php
├── login.php
├── cadastro.php
├── dashboard.php
├── galeria.php
├── editar_evento.php
├── excluir_evento.php
└── ... (outros arquivos php)


---

## 👨‍💻 Autor

Feito com ❤️ por **[HyagoIFSilva]**

[![LinkedIn](https://img.shields.io/badge/linkedin-%230077B5.svg?style=for-the-badge&logo=linkedin&logoColor=white)](https://br.linkedin.com/in/hyagoinaciofarias?trk=people-guest_people_search-card)

---

## 📄 Licença

Distribuído sob a licença MIT. Veja `LICENSE` para mais informações.
