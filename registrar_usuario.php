<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro</title>
  <link rel="stylesheet" href="./Styles/registro.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
</head>
<body>
  <section>
    <div class="form-box">
      <h2>Cadastro</h2>

      <form action="script_cadastro_usuario.php" method="POST" enctype="multipart/form-data">
        <div class="inputbox">
          <input type="text" name="nome" id="nome" required>
          <label for="nome">Nome</label>
        </div>

        <div class="inputbox">
          <input type="email" name="email" id="email" required>
          <label for="email">Email</label>
        </div>

        <div class="inputbox">
          <input type="number" name="idade" id="idade" required>
          <label for="idade">Idade</label>
        </div>

        <div class="inputbox">
          <input type="password" name="senha" id="senha" required>
          <label for="senha">Senha</label>
        </div>

        <div class="inputbox">
          <input type="file" name="foto" id="foto" accept="image/*" required>
          <label for="foto" style="top: -5px;">Foto de Perfil</label>
        </div>

        <button type="submit">Cadastrar</button>

        <div class="register">
          <p>Já tem uma conta? <a href="login.html">Login</a></p>
        </div>
      </form>
    </div>
  </section>
</body>
</html>
