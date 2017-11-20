<?php 
  require_once('functions.php'); 
  addCategorias();
  viewCategorias();
?>

<?php
session_start();
if(!$_SESSION['id']) {
  exit("erro sem permissão para essa parte");
}
?>

<?php include(HEADER_TEMPLATE); ?>

<h3>Selecione as categorias que você prefere:</h3>

<form action="addCategoria.php" method="post">
  <!-- area de campos do form -->
  <div class="row">
        <div class="form-group col-md-5">
            <?php if ($categorias) : 
                $i=0; ?>
            <?php foreach ($categorias as $categoria) : ?>
                <input type="checkbox" name="categoria['idCategoria[<?php echo $i; ?>]']" value="<?php echo $categoria['id']; ?>">  <?php echo $categoria['nome'];?> <br />
                <?php $i++; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div> 
  <input type="hidden" name="usuario" value="<?php echo $_SESSION['id']; ?>">
    <div id="actions" class="row">
        <div class="col-md-5">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <a href="index.php" class="btn btn-default">Cancelar</a>
        </div>
    </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>