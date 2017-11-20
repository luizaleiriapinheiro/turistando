<?php
require_once '../config.php';
require_once 'database.php';

$database = open_database();
switch ($_GET['tabela']){
    case "foto";
        $rs = $database->prepare("SELECT nome, tipo, arquivo FROM foto WHERE id=?"); 
        break;
    case "fotoUsuario";
        $rs = $database->prepare("SELECT nome, tipo, arquivo FROM fotoUsuario WHERE id=?"); 
        break;
}
$rs->bind_param("i", $_GET['id']);
try{
    $rs->execute();
} catch (Exception $e) {
    header('HTTP/1.1 500 Internal Server '.var_export($e));
}
    $result = $rs->get_result();
    $arquivo = $result->fetch_assoc();
    if($arquivo){
        header('Content-Type:'.$arquivo['tipo']);
      echo $arquivo['arquivo'];
    } else {
      header("HTTP/1.0 404 Not Found");
      echo "<h1>404 Arquivo não encontrado</h1>";
    }
    

 ?>
