<?php 
  require_once('functions.php'); 
?>

<?php
session_start();
if(!$_SESSION['id']) {
  exit("erro sem permissão para essa parte");
} else {
      view($_SESSION['id']);
      editUsuario($_SESSION['id']);
}
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Atualizar Usuário</h2>
<form action="editUsuario.php?id=<?php echo $usuario['id']; ?>" method="post">
  <form enctype="multipart/form-data" action="add.php" method="post">
  <!-- area de campos do form -->
  <hr />
  <input type="hidden" name="usuario['nomeUsuarioAtual']" value="<?php echo $usuario['nomeUsuario']; ?>">
  <div class="row">
    <div class="form-group col-md-7">
      <label for="name">Nome de Usuário</label>
      <input type="text" class="form-control" name="usuario['nomeUsuario']" value = "<?php echo $usuario['nomeUsuario']; ?>" required>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-md-3">
      <label for="campo2">Email</label>
      <input type="email" class="form-control" name="usuario['email']" value = "<?php echo $usuario['email']; ?>" required>
    </div>

    <div class="form-group col-md-2">
      <label for="campo3">Idade</label>
      <input type="number" class="form-control" name="usuario['idade']" value = "<?php echo $usuario['idade']; ?>" required>
    </div>
  </div>
  
  <div class="row">
    <div class="form-group col-md-5">
      <label for="campo1">Cidade</label>
      <input type="text" class="form-control" name="usuario['cidade']" value = "<?php echo $usuario['cidade']; ?>" required>
    </div>

  </div>
  <div class="row">
    <div class="form-group col-md-5">
      <label for="campo1"> Senha Atual </label>
      <input type="password" class="form-control" name="usuario['senha']">
    </div>
  </div>
  <div class="row">
    <div class="form-group col-md-5">
      <label for="campo1"> Nova Senha </label>
      <input type="password" class="form-control" name="usuario['novaSenha']">
    </div>
  </div>
  <div class="row">
    <div class="form-group col-md-5">
      <label for="campo1"> Confirmar Nova Senha</label>
      <input type="password" class="form-control" name="usuario['novaSenhaConfirmacao']">
    </div>
  </div>
   <div id="actions" class="row">
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary">Salvar</button>
      <a href="index.php" class="btn btn-default">Cancelar</a>
    </div>
  </div> 
</form>

<?php include(FOOTER_TEMPLATE); ?>