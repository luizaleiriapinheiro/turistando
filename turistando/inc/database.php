<?php
mysqli_report(MYSQLI_REPORT_STRICT);
function open_database() {
	try {
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $conn->set_charset("utf8");
		return $conn;
	} catch (Exception $e) {
		echo $e->getMessage();
		return null;
	}
}
function close_database($conn) {
	try {
		mysqli_close($conn);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
}


/**
 *  Faz login do Usuario
 */
function fazLogin($usuario = null, $senha = null ) {
  	$database = open_database();
	if($usuario&&$senha){
            $senha = hash('sha256', $senha);
            $rs = $database->prepare("SELECT id FROM usuario WHERE  nomeUsuario= ? AND senha= ?");
            $rs->bind_param('ss', $usuario, $senha);
          try {
            $rs->execute();
            $result = $rs->get_result();
            $usuario = $result->fetch_assoc();
            if ($usuario['id']) {
	      $usuarioID = $usuario;
	    }else{
              $usuarioID = null;
            }
            } catch (Exception $e) {
                $_SESSION['message'] = $e->GetMessage();
                $_SESSION['type'] = 'danger';
            }
        }
        close_database($database);
                            print_r($usuarioID);
        return $usuarioID;

}

/**
 *  Pesquisa Todos os Registros de uma Tabela
 */
function find_all( $table ) {
  return find($table);
}

/**
 *  Pesquisa um ID de viagem 
 */
function findViagemID($idUsuario = null ) {
  	$database = open_database();
	$found = null;
	try {
	  if ($idUsuario) {
	    $sql = "SELECT id FROM viagem WHERE idUsuario = " . $idUsuario;
	    $result = $database->query($sql);	    
	    if ($result->num_rows > 0) {
	      $found = $result->fetch_all(MYSQLI_ASSOC);
	    }
	  }
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }
	close_database($database);
	return $found;
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function findViagem( $table = null, $id = null ) {
  	$database = open_database();
	$found = null;
	try {
	  if ($id) {
	    $sql = "SELECT viagem.id, local, descricao FROM " . $table . " JOIN usuario ON(viagem.idUsuario=usuario.id) WHERE idUsuario = " . $id;
	    $result = $database->query($sql);	    
	    if ($result->num_rows > 0) {
	      $found = $result->fetch_all(MYSQLI_ASSOC);
	    }	    
	  } else {
	    $sql = "SELECT usuario.nomeUsuario, viagem.id, local, descricao FROM viagem JOIN usuario ON(viagem.idUsuario=usuario.id)";
	    $result = $database->query($sql);
	    if ($result->num_rows > 0) {
	      $found = $result->fetch_all(MYSQLI_ASSOC);
	    }
	  }
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }
	close_database($database);
	return $found;
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function find( $table = null, $id = null ) {
  	$database = open_database();
	$found = null;
	try {
	  if ($id) {
	    $sql = "SELECT * FROM " . $table . " WHERE id = " . $id;
	    $result = $database->query($sql);	    
	    if ($result->num_rows > 0) {
	      $found = $result->fetch_assoc();
	    }	    
	  } else {
	    $sql = "SELECT * FROM " . $table;
	    $result = $database->query($sql);
	    if ($result->num_rows > 0) {
	      $found = $result->fetch_all(MYSQLI_ASSOC);
	    }
	  }
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }
	close_database($database);
        
	return $found;
}

/**
 *  Pesquisa um ID de uma Tabela
 */
function findCategorias( $table = null, $id = null ) {
  	$database = open_database();
	$found = null;
	try {
	  if ($id) {
            switch ($table){ 
                case "viagem_tem_categoria":
                $sql = "SELECT categoria.nome FROM categoria JOIN ". $table ." ON(categoria.id=idCategoria) WHERE idViagem = " . $id;
                break;
                case "usuario_tem_categoria":
                $sql = "SELECT categoria.nome FROM categoria JOIN ". $table ." ON(categoria.id=idCategoria) WHERE idUsuario = " . $id;
                break;
            }
            $result = $database->query($sql);
	    if ($result->num_rows > 0) {
	      $found[0] = $result->fetch_row();
              $i=1;
              while($row = $result->fetch_row()){
                    $found[$i] = $row;    
                    $i++;
                }
	    }	    
	  } 
	} catch (Exception $e) {
	  $_SESSION['message'] = $e->GetMessage();
	  $_SESSION['type'] = 'danger';
  }
	close_database($database);
	return $found;
}

/**
 *  Salva um Registro em uma Tabela
 */

function save($table = null, $data = null) {
  $database = open_database();
  $columns = null;
  $values = null;
  //print_r($data);
  foreach ($data as $key => $value) {
    $columns .= trim($key, "'") . ",";
    $values .= "'$value',";
  }
  // remove a ultima virgula
  $columns = rtrim($columns, ',');
  $values = rtrim($values, ',');
  
  $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
  try {
    $database->query($sql);
    $_SESSION['message'] = 'Registro cadastrado com sucesso.';
    $_SESSION['type'] = 'success';
  
  } catch (Exception $e) { 
  
    $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
    $_SESSION['type'] = 'danger';
  } 
  close_database($database);
  //echo $_SESSION['message'];
}

/**
 *  Atualiza os dados pelo ID em uma Tabela
 */

function update($table = null, $id = 0, $data = null) {
  $database = open_database();
  $items = null;
  foreach ($data as $key => $value) {
    $items .= trim($key, "'") . "='$value',";
  }
  // remove a ultima virgula
  $items = rtrim($items, ',');
  $sql  = "UPDATE " . $table;
  $sql .= " SET $items";
  $sql .= " WHERE id=" . $id . ";";
  try {
    $database->query($sql);
    $_SESSION['message'] = 'Registro atualizado com sucesso.';
    $_SESSION['type'] = 'success';
  } catch (Exception $e) { 
    $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
    $_SESSION['type'] = 'danger';
  } 
  close_database($database);
}

/**
 *  Exclui um Registro pelo ID em uma Tabela
 */
function remove($table = null, $id = null){
    $database = open_database();
    try {
        if ($id){
            $sqlA = "DELETE FROM foto WHERE idViagem = " . $id;
            $resultA = $database->query($sql);
            $sqlB = "DELETE FROM " . $table . " WHERE id = " . $id;
            $resultB = $database->query($sql);
            if ( $resultA = $database->query($sqlA) && $resultB = $database->query($sqlB)){
                $_SESSION['message'] = "Registro Removido com Sucesso.";
                $_SESSION['type'] = 'success';
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}

/**
 *  Exclui as categorias de uma viagem
 */
function removeCategoria($table = null, $id = null){
    $database = open_database();
    try {
        if ($id){
            switch ($table){
                case "viagem_tem_categoria":
                    $sql = "delete from viagem_tem_categoria where idViagem = " . $id;
                    break;
                case "usuario_tem_categoria":
                    $sql = "delete from usuario_tem_categoria where idUsuario = " . $id;
                    break;
            }
            $result = $database->query($sql);
            if ($result = $database->query($sql)){
                $_SESSION['message'] = "Registro Removido com Sucesso.";
                $_SESSION['type'] = 'success';
            }
        }
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = 'danger';
    }
    close_database($database);
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela com multiplos joins
 */
function pesquisar($tabela, $pesquisa){
      $database = open_database();
        try {
            switch ($tabela){ 
                case "usuario":
                    $sql = "SELECT usuario.nomeUsuario, viagem.id, viagem.local, viagem.descricao FROM viagem JOIN usuario ON(viagem.idUsuario=usuario.id) WHERE usuario.nomeUsuario like '%" . $pesquisa . "%' ;";
                    break;
                case "viagem":
                    $sql = "SELECT usuario.nomeUsuario, viagem.id, viagem.local, viagem.descricao FROM viagem JOIN usuario ON(viagem.idUsuario=usuario.id) WHERE viagem.local like '%" . $pesquisa . "%' ;";
                    break;
                case "categoria":
                    $sql = "SELECT categoria.nome, usuario.nomeUsuario, viagem.id, viagem.local, viagem.descricao FROM viagem JOIN usuario ON(viagem.idUsuario=usuario.id) "
                        . "JOIN viagem_tem_categoria ON(viagem.id=viagem_tem_categoria.idViagem) JOIN categoria ON(viagem_tem_categoria.idCategoria=categoria.id) WHERE categoria.nome like '%" . $pesquisa . "%' ;";
                    break; 
            }
	    $result = $database->query($sql);	    
	    if ($result->num_rows > 0) {
	      $found = $result->fetch_all(MYSQLI_ASSOC);
	    }
        } catch (Exception $e) {
          header('HTTP/1.1 500 Internal Server '.var_export($e));
        }
        close_database($database);
	return $found;
}

/**
 *  Salva fotos na tabela foto
 */
function saveFoto($foto,$id){
    session_start();
    $database = open_database();
    if($foto['arquivo']['tmp_name']) {
      $rs = $database->prepare("INSERT INTO foto (nome,tipo,arquivo,idViagem) VALUES(?,?,?,?)");
      $null = NULL;
      $rs->bind_param('ssbi', $foto['arquivo']['name'], $foto['arquivo']['type'], $null, $id);
      $rs->send_long_data(2, file_get_contents($foto['arquivo']['tmp_name']));
    try {
      $rs->execute();
      $_SESSION['message'] = 'Foto cadastrada com sucesso!';
      $_SESSION['type'] = 'success';
    } catch (Exception $e) { 
      $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
      $_SESSION['type'] = 'danger';
    } 
    } 
    close_database($database);
}
   
/**
 *  recupera as fotos do banco no formato certo
 */
function viewFoto($table, $id){
    $database = open_database();
    switch ($table){
        case "foto";
            $sql = "SELECT id FROM foto WHERE idViagem = " . $id;
            break;
        case "fotoUsuario";
            $sql = "SELECT id FROM fotoUsuario WHERE idUsuario = " . $id; 
            break;
    }   
    try {
        $result = $database->query($sql);	    
        $found = $result->fetch_all(MYSQLI_ASSOC);
    } catch (Exception $ex) {
        $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
        $_SESSION['type'] = 'danger';
    }
    return $found;
}

/**
 *  Edita a foto de usuario
 */
function editFotoUsuario($foto,$id){
    session_start();
    $database = open_database();
    if($foto['arquivo']['tmp_name']) {
        $teste = "select nome from fotoUsuario where idUsuario = $id";
        $result = $database->query($teste);	    
        if ($result->num_rows > 0) {
            $rs = $database->prepare("UPDATE fotoUsuario SET nome=?, tipo=?, arquivo=? WHERE idUsuario=?");
        } else {
            $rs = $database->prepare("INSERT INTO fotoUsuario (nome,tipo,arquivo,idUsuario) VALUES(?,?,?,?)");
        }
            $null = NULL;
            $rs->bind_param('ssbi', $foto['arquivo']['name'], $foto['arquivo']['type'], $null, $id);
            $rs->send_long_data(2, file_get_contents($foto['arquivo']['tmp_name']));
              try {
                $rs->execute();
                $_SESSION['message'] = 'Foto atualizada com sucesso!';
                $_SESSION['type'] = 'success';
              } catch (Exception $e) { 
                $_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
                $_SESSION['type'] = 'danger';
              }     
    } 
    close_database($database);
}	    

/**
 *  Pesquisa um Registro pelo ID em uma Tabela com multiplos joins
 */
function pesquisarInteresses($idUsuario){
      $database = open_database();
        try {
                $sql = "Select distinct usuario.nomeUsuario, viagem.id, viagem.local 
from viagem 
JOIN usuario ON (usuario.id=viagem.idUsuario)
JOIN viagem_tem_categoria ON(viagem.id=viagem_tem_categoria.idViagem) 
JOIN usuario_tem_categoria ON(viagem_tem_categoria.idCategoria=usuario_tem_categoria.idCategoria) 
JOIN categoria ON(viagem_tem_categoria.idCategoria=categoria.id)  
where usuario_tem_categoria.idUsuario=" . $idUsuario;
                $result = $database->query($sql);	    
                if ($result->num_rows > 0) {
                  $found = $result->fetch_all(MYSQLI_ASSOC);
                }
        } catch (Exception $e) {
          header('HTTP/1.1 500 Internal Server '.var_export($e));
        }
        close_database($database);
	return $found;
}