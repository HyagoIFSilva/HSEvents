<?php
session_start();

// Verificação de segurança completa para garantir que o usuário está logado
if (!isset($_SESSION['idUsuario']) || !isset($_SESSION['nome']) || !isset($_SESSION['foto'])) {
    header('Location: login.php');
    exit();
}

// Pega os dados da sessão para usar na página
$nome = $_SESSION['nome'];
$foto_perfil = $_SESSION['foto'];
$caminho_foto_perfil = 'uploads/' . $foto_perfil;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Novo Evento</title>
    <link rel="stylesheet" href="./Styles/dashboard.css">
</head>
<body>

<?php if (isset($_SESSION['evento_sucesso'])): ?>
<div class="modal-sucesso" id="modalSucesso" style="display: flex;">
  <div class="modal-content">
    <span class="close" onclick="document.getElementById('modalSucesso').style.display='none'">&times;</span>
    <h2>Evento cadastrado com sucesso!</h2>
    <p>Seu evento foi registrado. Deseja realizar outra ação?</p>
    <div class="modal-actions">
      <a href="cadastrar_evento.php">➕ Novo Evento</a>
      <a href="dashboard.php">📋 Ir ao Dashboard</a>
    </div>
  </div>
</div>
<?php unset($_SESSION['evento_sucesso']); endif; ?>

<div class="dashboard">
  <aside class="sidebar">
      <div class="profile">
          <img src="<?php echo htmlspecialchars($caminho_foto_perfil); ?>" alt="Foto de Perfil" class="profile-pic">
          <h3><?php echo htmlspecialchars($nome); ?></h3>
      </div>
      
      <h2>Menu</h2>
      <nav>
          <ul>
              <li><a href="dashboard.php">🏠 Dashboard</a></li>
              <li><a href="cadastrar_evento.php" class="active">📒 Cadastrar Evento</a></li>
              <li><a href="meus_eventos.php">📁 Meus Eventos</a></li>
              <li><a href="galeria.php">🖼️ Galeria Geral</a></li>
          </ul>
      </nav>
      <div class="logout">
          <a href="login.php">🚪 Logout</a>
      </div>
  </aside>

  <main class="main-content">
      <h1>Cadastrar Novo Evento</h1>
      <p>Preencha os campos abaixo para registrar um novo evento na plataforma.</p>
      
      <div class="form-wrapper">
          <form action="processa_evento.php" method="POST" enctype="multipart/form-data">

              <div class="form-group">
                  <label for="nomeCadEvento">Título do Evento</label>
                  <input type="text" name="nomeCadEvento" id="nomeCadEvento" required>

              </div>

              <div class="form-group">
                  <label for="dataCadEvento">Data</label>
                  <input type="date" name="dataCadEvento" id="dataCadEvento" required>
              </div>

              <div class="form-group">
                  <label for="descCadEvento">Descrição</label>
                  <textarea name="descCadEvento" id="descCadEvento" rows="4" required></textarea>
              </div>

              <div class="form-group">
                  <label for="fotoCadEvento">Imagem de Capa</label>
                  <input type="file" name="fotoCadEvento" id="fotoCadEvento" accept="image/*" required>
                  <div class="preview-container">
                      <img id="preview" src="" alt="Prévia da imagem">
                  </div>
              </div>

              <div class="form-actions">
                  <button type="submit" class="btn">Publicar Evento</button>
              </div>
          </form>
      </div>
  </main>
</div>

<script>
const inputImagem = document.getElementById('fotoCadEvento');
const preview     = document.getElementById('preview');
const previewContainer = document.querySelector('.preview-container');

inputImagem.addEventListener('change', () => {
  const arquivo = inputImagem.files[0];
  if (arquivo) {
      const leitor = new FileReader();
      leitor.onload = e => {
          preview.src = e.target.result;
          preview.style.display = 'block';
      };
      leitor.readAsDataURL(arquivo);
  } else {
      preview.src = '';
      preview.style.display = 'none';
  }
});
</script>

</body>
</html>