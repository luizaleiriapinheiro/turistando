<?php
require_once('../config.php');
require_once(DBAPI);


/**
 *  Listagem de Viagens
 */
function index($usuario) {
	global $viagens;
	$viagens = findViagem('viagem',$usuario);
}

/**
 *  Cadastro de Viagem
 */
function addViagem() {
  if (!empty($_POST['viagem']) and !empty($_POST['categoria'])) {
    $viagem = $_POST['viagem'];
    save('viagem', $viagem);
    
    $categoria = $_POST['categoria'];
    $usuario = $_POST['usuario'];
    $viagem = findViagemID($usuario);
    $viagemId = end($viagem);
    
    foreach ($viagemId as $v){
        $dados['idViagem']= $v;
    }
    foreach ($categoria as $c){
        $dados['idCategoria']= $c;
        save('viagem_tem_categoria', $dados);
    }
    header('location: index.php');
  }
}

/**
 *	Atualizacao/Edicao de Viagem
 */
function editViagem() {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_POST['viagem'])) {
      $viagem = $_POST['viagem'];
      update('viagem', $id, $viagem);
      if (isset($_POST['categoria'])){
        removeCategoria('viagem_tem_categoria', $id);
        $categoria = $_POST['categoria'];
        $usuario = $_POST['usuario'];
        $dados['idViagem']= $id;
        foreach ($categoria as $c){
            $dados['idCategoria']= $c;
            save('viagem_tem_categoria', $dados);
        }
    }
    header('location: index.php');
    } else {
      global $viagem;
      $viagem = find('viagem', $id);
    } 
    
  } else {
    header('location: index.php');
  }
}

/**
 * Visualização de uma viagem
 */
function view($id = null){
    global $viagem;
    global $found;
    global $categorias;
    $viagem = find ('viagem', $id);

    $found = viewFoto('foto',$id);
    $categorias = findCategorias('viagem_tem_categoria', $id);
}
              
/**
 * Exclusão de uma viagem
 */

function delete($id = null){
    global $viagem;
    $viagem = remove('viagem', $id);
    header('location: index.php');
}

/**
 * Retorna uma lista de Categorias existentes
 */

function viewCategorias($id = null){
    global $categorias;
    $categorias = find ('categoria', $id);
    
}

/**
 * Adicionar foto à uma viagem
 */

function addFoto(){
    if (!empty($_FILES)) {
    saveFoto($_FILES,$_POST['idViagem']);
    header('location: index.php');
    }
}