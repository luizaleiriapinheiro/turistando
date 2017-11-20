<?php 
  require_once('functions.php'); 
  addViagem();
  viewCategorias();
?>

<?php
session_start();
if(!$_SESSION['id']) {
  exit("erro sem permissão para essa parte");
}
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Nova Viagem</h2>

<form action="addViagem.php" method="post">
  <!-- area de campos do form -->
  <hr />
  <div class="row">
    <div class="form-group col-md-5">
      <label for="name">Local</label>
      <input type="text" class="form-control" name="viagem['local']" placeholder="Qual seu destino?" required>
    </div>
 </div>   
    <div id="actions" class="row">
    <div class="form-group col-md-5">
      <label for="campo2">Descrição</label>
      <input type="text" class="form-control" name="viagem['descricao']" placeholder="Como foi sua experiência?" required>
    </div>
   </div>  
  <div class="row">
        <div class="form-group col-md-5">
            <label for="campo7">Categorias</label> <br />
            <?php if ($categorias) : 
                $i=0; ?>
            <?php foreach ($categorias as $categoria) : ?>
                <input type="checkbox" name="categoria['idCategoria[<?php echo $i; ?>]']" value="<?php echo $categoria['id']; ?>">  <?php echo $categoria['nome'];?> <br />
                <?php $i++; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div> 
  <input type="hidden" name="viagem['idUsuario']" value="<?php echo $_SESSION['id']; ?>">
  <input type="hidden" name="usuario" value="<?php echo $_SESSION['id']; ?>">
    <div id="actions" class="row">
        <div class="col-md-5">
          <button type="submit" class="btn btn-primary">Salvar</button>
          <a href="index.php" class="btn btn-default">Cancelar</a>
        </div>
    </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>