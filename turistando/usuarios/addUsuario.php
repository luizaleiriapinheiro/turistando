<?php 
  require_once('functions.php'); 
  addUsuario();
?>

<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <title>Turistando</title>
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="<?php echo BASEURL; ?>css/bootstrap.min.css">
            <style>
                body {
                    padding-top: 50px;
                    padding-bottom: 20px;
					background-image: url("background.jpeg");
					background-size: 120%;
					color:#000000;
                }
            </style>
            <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
        </head>
        <body>                
            <main class="container">
<h2>Cadastro</h2>
<form action="addUsuario.php" method="post">
    <!-- area de campos do form -->
    <hr />
    <div class="row">
        <div class="form-group col-md-4">
            <label for="name">Nome</label>
            <input type="text" class="form-control" name="usuario['nome']" placeholder="Miguel Santos" required>
        </div>

        <div class="form-group col-md-1">
            <label for="campo3">Idade</label>
            <input type="number" class="form-control" name="usuario['idade']" placeholder="27" min="1" max="100" required>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-5">
            <label for="campo1">Cidade</label>
            <input type="text" class="form-control" name="usuario['cidade']" placeholder="São Paulo" required>
        </div>
    </div> 

    <div class="row">
        <div class="form-group col-md-5">
            <label for="campo2">Email</label>
            <input type="email" class="form-control" name="usuario['email']" placeholder="miguelSantos@email.com" required>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-5">
            <label for="campo1">Nome de Usuário</label>
            <input type="text" class="form-control" name="usuario['nomeUsuario']" placeholder="miguelSantos" required>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-md-5">
            <label for="campo1">Senha</label>
            <input type="password" class="form-control" name="usuario['senha']" placeholder="***********" maxlength="20" required>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-5">
            <label for="campo1">Confirme a senha</label>
            <input type="password" class="form-control" name="usuario['confirmaSenha']" placeholder="***********" maxlength="20" required>
        </div>
    </div>


    <div id="actions" class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="../index.php" class="btn btn-default">Cancelar</a>
        </div>
    </div>
</form>

<?php include(FOOTER_TEMPLATE); ?>