<?php
session_start();
if(!$_SESSION['id']) {
  exit("erro sem permissão para essa parte");
}
else {
    $id = $_SESSION['id'];    
}
require_once('functions.php');
include(HEADER_TEMPLATE);
view($id);
?> 

<h2>Meu Perfil</h2>
<hr>
<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php
if ($foto) {
     foreach ($foto as $item) {
        echo "<img class='img-rounded' width='304' height='236' src='../inc/viewImg.php?id={$item['id']}&tabela=fotoUsuario'>   ";
    }
}
?>  
    <br /> <br /> 
<dl class="dl-horizontal">
    <dt>Nome de Usuário:</dt>
    <dd><?php echo $usuario['nomeUsuario'] ?></dd>
    <dt>Email:</dt>
    <dd><?php echo $usuario['email'] ?></dd>
    <dt>Idade:</dt>
    <dd><?php echo $usuario['idade'] ?></dd>
    <dt>Cidade:</dt>
    <dd><?php echo $usuario['cidade'] ?></dd>
    <dt>Categorias:</dt>
    <dd><?php if($categorias){ foreach ($categorias as $cat ){  foreach ($cat as $c ){   echo $c . "<br />"; }}} ?></dd>
</dl>   
<div id="actions" class="row">
    <div class="col-md-12">
        <a href="addFoto.php?id=<?php echo $usuario['id'];?>" class="btn btn btn-warning">Editar Foto</a>
        <a href="editUsuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-info">Editar Dados</a>
        <a href="addCategoria.php?id=<?php echo $usuario['id']; ?>" class="btn btn-success">Editar Categorias</a>
    </div>
</dl>    
<?php include(FOOTER_TEMPLATE); ?>