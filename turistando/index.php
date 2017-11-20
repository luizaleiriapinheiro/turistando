<?php require_once 'config.php'; ?>
<?php require_once DBAPI; ?>
<?php $db = open_database(); ?>
<?php if ($db) : ?>

    <?php
    $escondeAviso = "hidden";
    $usuario = fazLogin($_POST['usuario'], $_POST['senha']);
    if ($usuario['id']) {
        // Logou
        session_start();
        $_SESSION['id'] = $usuario['id'];
        header('Location: viagens/index.php');
    } else {
        //erro ao logar
        $escondeAviso = "";
    }
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
                    color:#000000;
                    text-align: center;
                }
            </style>
            <link rel="stylesheet" href="<?php echo BASEURL; ?>css/style.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">
        </head>
        <body>                
            <main class="container">
                <img src="onlinelogomaker-061417-0909-2943.png" width="400">
                <form action="index.php" method="post">
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-4">
                        <div class="form-group col-md-5">
                            <input type="text" class="form-control" name="usuario" placeholder="Digite seu Nome de Usuário" required>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-10 col-lg-offset-4">
                        <div class="form-group col-md-5">
                            <input type="password" class="form-control" name="senha" placeholder="Digite sua senha" required>
                        </div>
                        </div>
                    </div>
                    <div id="actions" class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Fazer Login</button>
                        </div>
                    </div>
                </form>

                <div class="col-sm-0 h2">
                    <a class="btn btn-primary" href="usuarios/addUsuario.php"><i class="fa fa-plus"></i> Novo Usuario</a>
                </div>

            <?php else : ?>

                <div class="alert alert-danger" role="alert">

                    <p><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>

                </div>



            <?php endif; ?>



            <?php include(FOOTER_TEMPLATE); ?>