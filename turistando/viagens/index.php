<?php
    session_start();
    if(!$_SESSION['id']) {
      exit("erro sem permissão para essa parte");
    } 
 else {
    $usuario = $_SESSION['id'];
    require_once('functions.php');
    index($usuario);

}
    
?> 

<?php include(HEADER_TEMPLATE); ?>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
    
    body,h1,h2,h3,h4,h5,h6 {
        font-family: "Raleway", sans-serif;
        background:#ffffff;
    }
    #myImg {
    cursor: pointer;
    transition: 0.3s;
}
.mySlides {display:none}

<?php foreach ($viagens as $viagem) {
echo '.mySlides'.$viagem['id'].'{}';
echo '.demo'.$viagem['id'].'{}';
} ?>

.w3-left, .w3-right, .w3-badge {cursor:pointer}
.w3-badge {height:13px;width:13px;padding:0}
</style>
<script>
    function plusDivs(viagem,n) {
      showDivs(viagem,slideIndex += n);
    }

    function currentDiv(viagem, n) {
      showDivs(viagem, slideIndex = n);
    }

    function showDivs(viagem,n) {
      var i;
      var x = document.getElementsByClassName("viagem"+viagem);
      var dots = document.getElementsByClassName("demo"+viagem);
      console.log("Dots");
      console.log(dots);
      
      if (n > x.length) {slideIndex = 1}    
      if (n < 1) {slideIndex = x.length}
      for (i = 0; i < x.length; i++) {
         x[i].style.display = "none";  
      }
 for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-black", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-black";
      }
</script>
</head>
<header>
	<div class="row">
            <div class="col-sm-6">
                <br />
		<h2>Minhas Viagens</h2>
            </div>
            <div class="col-sm-6 text-right h2"> 
                <br />
	    	<a class="btn btn-primary" href="addViagem.php"><i class="fa fa-plus"></i> Nova Viagem</a>
	    </div>
	</div>
</header>
<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>
<hr />
<table class="table table-hover">
<?php if ($viagens) : ?>
<?php foreach ($viagens as $viagem) : 
    view($viagem['id']); ?>
        <div class="col-md-4">
            <div class="w3-row-padding w3-light-grey" border-radius="7px">
                <div class="w3-content w3-display-container" style="max-width:800px">
                <br />  
                    <?php if ($found) {
                        foreach ($found as $item) {
                        echo "<img class='mySlides viagem{$viagem['id']}' src='../inc/viewImg.php?id={$item['id']}&tabela=foto' style='width:100%'>   ";
                        }
                    }
                    else{
                        echo "<br />";
                        echo "<img class='mySlides viagem{$viagem['id']}' src='../semImagem.png' style='width:100%'>   ";
                    }?>
                    <br />
                    <div class="w3-center w3-container w3-section w3-large w3-display-bottommiddle" style="width:100%">
                        
                        <div class="w3-left w3-hover-text-khaki" onclick="plusDivs(<?php echo $viagem['id']; ?>,-1)">&#10094;</div>
                        <div class="w3-right w3-hover-text-khaki" onclick="plusDivs(<?php echo $viagem['id']; ?>,1)">&#10095;</div>
                    <?php if ($found) {
                        $total=1;
                        foreach ($found as $item) {
                        echo "<span class=\"w3-badge demo{$viagem['id']} w3-border w3-transparent w3-hover-white\" onclick=\"currentDiv({$viagem['id']},";
                        echo  ($total++).")\"></span>";
                        }
                    }
                    ?>
      
                    </div>
                            <br><br>
                </div>
            <div class="w3-container">
                <p align='center'><b><?php echo $viagem['local']; ?></b>
                    <a href="addFoto.php?id=<?php echo $viagem['id']; ?>" class="btn btn-sm btn-info"><i class="fa fa-camera"></i> </a>
                    <a href="editViagem.php?id=<?php echo $viagem['id']; ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a>
                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete-modal" data-book="<?php echo $viagem['id']; ?>">
                            <i class="fa fa-trash"></i>
                    </a>
                </p>
                <p><b>Categorias: </b>
                    <?php $todos=[];
                    foreach ($categorias as $cat ){ 
                        $todos = array_merge($todos, $cat);
                        } 
                        echo implode(", ", $todos);
                    ?></p>
                <p><?php echo $viagem['descricao']; ?></p>
            </div>
            </div>
            <br />
        </div>
    <script>
    var slideIndex = 1;
    
    <?php
    
    echo "showDivs({$viagem['id']},slideIndex)";
    ?>
    </script>
<?php endforeach; ?>
<?php else : ?>
	<tr>
		<td colspan="6">Você ainda não adicionou suas experiências. Por que não começar agora? </td>
	</tr>
<?php endif; ?>
</table>



<?php include('modal.php'); ?>
<?php include(FOOTER_TEMPLATE); ?>