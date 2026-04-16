---

# 📚 Sistema Biblioteca ETESC

Sistema web completo de gerenciamento de biblioteca escolar, desenvolvido para controle de alunos, livros e empréstimos. Ideal para escolas ou instituições que desejam automatizar o gerenciamento de acervos e processos de empréstimo.

> Projeto profissional com foco em PHP, MySQL, JavaScript e interface responsiva, integrando funcionalidades de CRUD, empréstimos e devoluções, pesquisa avançada e histórico de alunos.

---

## 🚀 Preview do Sistema

O sistema permite:

* Cadastro e edição de **alunos** e **livros**
* Controle de **empréstimos e devoluções**
* Listagem detalhada de livros **disponíveis e emprestados**
* Histórico de alunos e livros
* Interface **responsiva e amigável** para desktop e mobile

---

## 🧠 Funcionalidades

### Gestão de Alunos

* Cadastro, edição e exclusão de alunos
* Histórico de empréstimos e devoluções
* Validação de dados e integridade

### Gestão de Livros

* Cadastro, edição e exclusão de livros
* Controle de quantidade disponível vs emprestada
* Classificação e assunto para organização do acervo

### Empréstimos e Devoluções

* Emprestar livros e atualizar quantidade em tempo real
* Devolver livros automaticamente ajustando status no acervo
* Controle de datas de empréstimo e devolução
* Atualização dinâmica de livros emprestados por aluno

### Listagens e Pesquisas

* Listagem de livros do acervo
* Filtragem por autor, título e livros emprestados
* Paginação para controle de grandes volumes
* Pesquisa avançada para agilizar consultas

---

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP, PDO (MySQL)
* **Banco de Dados:** MySQL
* **Frontend:** HTML5, CSS3, JavaScript
* **Bibliotecas e Frameworks:** Bootstrap, Cleave.js, SweetAlert.js, Notify.js

---

## 📂 Estrutura do Projeto

```
📁 css/
 ├── acervo.css
 ├── bootstrap.css
 └── style.css

📁 js/
 ├── acervo.js
 ├── Cleave.js
 ├── Notify.js
 └── sweetalert.js

📁 img/
 ├── logo-etesc.png
 ├── logo-faetec.png
 ├── aluno.png
 └── home-section-bg.jpg

📄 index.php
📄 alunos.php
📄 cadastro-alunos.php
📄 cadastro-livros.php
📄 editar-aluno.php
📄 editar-livro.php
📄 emprestar-livro.php
📄 devolver.php
📄 deletar-livro.php
📄 livros-acervo.php
📄 livros-acervo-emprestados.php
📄 database.php
```

---

## ⚙️ Como Funciona

1. **Login e Navegação**

   * O sistema abre em `index.php`, que exibe o dashboard com estatísticas rápidas de alunos e livros.
2. **Cadastro**

   * Alunos e livros podem ser cadastrados com dados obrigatórios validados.
3. **Empréstimos**

   * Seleção de aluno e livro.
   * Atualização automática do status do livro (Acervo → Emprestado).
   * Registro de data de empréstimo e data prevista de devolução.
4. **Devoluções**

   * Atualiza o status do livro automaticamente.
   * Registra devolução e libera o livro no acervo.
5. **Listagem**

   * Filtragem por autor, título, ou livros emprestados.
   * Paginação automática para grandes listas.

---

## 📱 Interface e UX

* Layout responsivo compatível com **desktop e tablet**
* Botões intuitivos e visuais de fácil identificação
* Feedback visual imediato via **Notify.js e SweetAlert.js**
* Uso de cores para status de livros e ações de usuários

---

## 💡 Aprendizados Técnicos

* Uso de **PDO com MySQL** para segurança e performance
* Estrutura modular de **CRUD** para fácil manutenção
* Aplicação de lógica de **empréstimos e controle de estoque**
* Paginação e filtragem avançada em listas grandes
* Desenvolvimento de **interfaces interativas** e responsivas

---

## ▶️ Como Executar

1. **Clonar o repositório**

```bash
git clone https://github.com/tvbrgamer/Sistema-Biblioteca-ETESC.git
```

2. **Configurar o banco de dados**

   * Crie um banco MySQL.
   * Importe as tabelas e dados iniciais (arquivo `.sql` pode ser usado como exemplo real).
   * Atualize o arquivo `database.php` com suas credenciais:

```php
$host = 'localhost';
$db   = 'nome_do_banco';
$user = 'usuario';
$pass = 'senha';
```

3. **Iniciar o servidor local**

   * Se estiver usando **XAMPP**, coloque a pasta do projeto dentro de `htdocs/`.
   * Inicie **Apache** e **MySQL**.

4. **Acessar o sistema no navegador**

   * Digite no navegador:

```
http://localhost/Sistema-Biblioteca-ETESC/index.php
```

5. **Pronto!**

   * O sistema estará funcional, com dashboard, cadastro de alunos e livros, controle de empréstimos e devoluções.

---
