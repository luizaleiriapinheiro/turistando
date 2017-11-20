<?php
require_once('../config.php');
require_once(DBAPI);


/**
 *  Cadastro de Usuário
 */
function addUsuario() {
    if (!empty($_POST['usuario'])) {

        $usuario = $_POST['usuario'];
        $senha = $usuario["'senha'"];
        $confirmaSenha = $usuario ["'confirmaSenha'"];

        if ($senha != $confirmaSenha) {
            $mensagem = "<span class='erro'><b>Erro</b>: As senhas não conferem!</span>";
        } else {
            unset($usuario["'confirmaSenha'"]);
            $usuario["'senha'"] = hash('sha256', $senha);
            $mensagem = "<span class='sucesso'><b>Sucesso</b>: As senhas são iguais: " . $senha . "</span>";
            save('usuario', $usuario);
            
            
            $login = fazLogin($usuario["'nomeUsuario'"], $senha);
            if ($login['id']) {
                // Logou
                session_start();
                $_SESSION['id'] = $login['id'];
                header('Location: ../viagens/index.php');
            } else {
                //erro ao logar
                $escondeAviso = "";
            }
        }

       echo "<p id='mensagem'>" . $mensagem . "</p>";
    }
}

/**
 *	Atualizacao/Edicao de Usuário
 */
function editUsuario($id = null) {
  if (!empty($_POST['usuario'])) {
        $usuario = $_POST['usuario'];

        if ($usuario["'senha'"]){
            $login = fazLogin($usuario["'nomeUsuarioAtual'"], $usuario["'senha'"]);
            if($login['id'] == $id){
                if ($usuario["'novaSenha'"] && $usuario["'novaSenhaConfirmacao'"]){
                    if ($usuario["'novaSenha'"] == $usuario["'novaSenhaConfirmacao'"]) {
                        $usuario["'senha'"] = hash('sha256', $usuario["'novaSenha'"]);
                        unset($usuario["'novaSenhaConfirmacao'"]);
                        unset($usuario["'novaSenha'"]);
                        unset($usuario["'nomeUsuarioAtual'"]);
                        update('usuario', $id, $usuario);
                        header('location: index.php');
                    }
                    else
                    {
                        $mensagem = "<span class='erro'><b>Erro</b>: As senhas não conferem!</span>"; 
                    }
                }  
            }
            else
            {
                $mensagem = "<span class='erro'><b>Erro</b>: A senha atual não confere!</span>"; 
            }   
        }
        else
        {
            unset($usuario["'nomeUsuarioAtual'"]);
            unset($usuario["'novaSenhaConfirmacao'"]);
            unset($usuario["'novaSenha'"]);
            unset($usuario["'senha'"]);
            update('usuario', $id, $usuario);
            header('location: index.php');
        }
       echo "<p id='mensagem'>" . $mensagem . "</p>";
    }
}

/**
 * Visualização de um usuario
 */
function view($id = null){
    global $usuario;
    global $foto;
    global $categorias;
    $usuario = find ('usuario', $id);
    $foto = viewFoto('fotoUsuario',$id);
    $categorias = findCategorias('usuario_tem_categoria', $id);
}

/**
 * Adicionar foto à um usuario ou atualizá-la
 */

function editFoto(){
    if (!empty($_FILES)) {
    editFotoUsuario($_FILES,$_POST['idUsuario']);
    header('location: index.php');
    }
}

/**
 * Retorna uma lista de Categorias existentes
 */

function viewCategorias($id = null){
    global $categorias;
    $categorias = find ('categoria', $id);
    
}

/**
 *  Cadastro de Categorias de Usuario
 */
function addCategorias() {
    if (!empty($_POST['usuario'])) {
        $id = $_POST['usuario'];
        removeCategoria('usuario_tem_categoria', $id);
        $categoria = $_POST['categoria'];
        $dados['idUsuario'] = $_POST['usuario'];

        foreach ($categoria as $c){
            $dados['idCategoria']= $c;
            save('usuario_tem_categoria', $dados);
        }
        header('location: index.php');
    }
    echo "<p id='mensagem'>" . $mensagem . "</p>";
}