<?php
require_once('../config.php');
require_once(DBAPI);

/**
 *  Listagem de Viagens
 */
function index() {
	global $resultados;
	$resultados = findViagem('viagem');
        if (!empty($_POST['tabela']) and $_POST['tabela'] !== "selecionar" and !empty($_POST['pesquisa'])){
            global $resultados;
            $resultados = pesquisar($_POST['tabela'], $_POST['pesquisa']);
        }
        elseif(!empty($_POST['tabela']) or !empty($_POST['pesquisa'])){
          $_SESSION['message'] = "Preencha todos os campos!";
          $_SESSION['type'] = 'danger';
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
 *  Listagem de Viagens com categorias do usuario
 */
function indexMeusInteresses($id) {
	global $resultados;
        $resultados = pesquisarInteresses($id);

   
}