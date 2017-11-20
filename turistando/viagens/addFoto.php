<?php 
  require_once('functions.php'); 
  addFoto();
?>

<?php
session_start();
if(!$_SESSION['id']) {
  exit("erro sem permissão para essa parte");
}
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Adicionar Fotos</h2>

<form action="addFoto.php" method="post" enctype="multipart/form-data">
  <!-- area de campos do form -->
  <hr />
  <div class="row">
    <div class="form-group col-md-5">
      <label for="arquivo">Foto:</label>
      <input id="arquivo" type="file" name="arquivo" accept="image*/" class="form-control" required>
    </div>
  </div>
  <input type="hidden" name="idViagem" value="<?php echo $_GET['id']; ?>">
    <div id="actions" class="row">
        <div class="col-md-5">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <a href="index.php" class="btn btn-default">Cancelar</a>
        </div>
    </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>