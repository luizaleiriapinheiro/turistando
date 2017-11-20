<?php 
  require_once('functions.php'); 
  editViagem();
  viewCategorias();
?>

<?php
session_start();
if(!$_SESSION['id']) {
  exit("erro sem permissão para essa parte");
}
?>

<?php include(HEADER_TEMPLATE); ?>

<h2>Atualizar Viagem</h2>

<form action="editViagem.php?id=<?php echo $viagem['id']; ?>" method="post">
    <hr />
    <!-- area de campos do form -->
    <div class="row">
        <div class="form-group col-md-7">
            <label for="name">Local</label>
            <input type="text" class="form-control" name="viagem['local']" value = "<?php echo $viagem['local']; ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-3">
            <label for="campo2">Descrição</label>
            <input type="text" class="form-control" name="viagem['descricao']" value = "<?php echo $viagem['descricao']; ?>" required>
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
    <input type="hidden" name="usuario" value="<?php echo $_SESSION['id']; ?>">
    <div class="row">
        <div id="actions" class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="index.php" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>