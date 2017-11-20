<?php
require_once ('functions.php');
view($_GET['id']);
include(HEADER_TEMPLATE); ?>

<?php
session_start();
if(!$_SESSION['id']) {
  exit("erro sem permissão para essa parte");
}
?>

<h2>Viagem</h2>
<hr>
<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<dl class="dl-horizontal">
    <dt>Destino:</dt>
    <dd><?php echo $viagem['local'] ?></dd>
    <dt>Experiência:</dt>
    <dd><?php echo $viagem['descricao'] ?></dd>
    <dt>Categorias:</dt>
    <dd><?php foreach ($categorias as $cat ){  foreach ($cat as $c ){   echo $c . "<br />"; }} ?></dd>
</dl>
    
    
<?php
if ($found) {
    foreach ($found as $item) {
        echo "<img width='304' height='236' src='../inc/viewImg.php?id={$item['id']}&tabela=foto'>   ";
    }
}
?>  
        <br /> <br /> 
<div id="actions" class="row">
    <div class="col-md-12">
        <a href="editViagem.php?id=<?php echo $viagem['id']; ?>" class="btn btn-primary">Editar</a>
        <a href="index.php" class="btn btn-default">Voltar</a>
    </div>
</dl>    
<?php include(FOOTER_TEMPLATE); ?>