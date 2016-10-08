<?php
require_once("cabecalho.php");
require_once("banco-produto.php");

// definir o numero de itens por pagina
$itens_por_pagina = 3;

// pegar a pagina atual
// pega a quantidade total de objetos no banco de dados
$num_total = mysqli_query($conexao, "select nome, preco, descricao, categoria_id, usado from produtos")->num_rows;

// definir numero de páginas
$num_paginas = ceil($num_total/$itens_por_pagina);

if(($num_paginas%$itens_por_pagina)>0){
	$paginas = (int)($num_paginas/$itens_por_pagina)+1;
}else{
	$paginas = ($num_paginas/$itens_por_pagina);
};

//$pagina = intval($_GET['pagina']);
if(isset($_GET['pagina'])){
$pagina =$_GET['pagina'];
}else{
	$pagina =1;
}
$pagina = max(min($paginas, $pagina),1);

$offset = ($pagina+1)*$itens_por_pagina;
// puxar produtos do banco

$resultado = mysqli_query($conexao, "select nome, preco, descricao, categoria_id, usado from produtos LIMIT $offset, $itens_por_pagina")  or die($mysqli->error);
//$execute = $mysqli->query($resultado);
$produto = $resultado->fetch_assoc();
$num = $resultado->num_rows;


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Paginação</title>

	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
  <body>

  	
  				<?php if($num > 0){ ?>
				<table class="table table-bordered table-hover">
				<?php
					//$produtos = listaProdutos($conexao);
					$produtos = $resultado;
					foreach($produtos as $produto) :
					?>
						<tr>
							<td><?= $produto['nome'] ?></td>
							<td><?= $produto['preco'] ?></td>
							<td><?= substr($produto['descricao'], 0, 40) ?></td>
							<td><?= $produto['categoria_nome']?></td>
							<td><a class="btn btn-primary" href="produto-altera-formulario.php?id=<?=$produto['id']?>">Alterar</a></td>
							<td>
								<form action="remove-produto.php" method="post">
									<input type="hidden" name="id" value="<?=$produto['id']?>">
									<button class="btn btn-danger">Remover</button>
								</form>
							</td>
						</tr>
					<?php
					endforeach
					?>	
				</table>

				<nav>
				  <ul class="pagination">
				    <li>
				      <a href="testepaginacao.php?pagina=0" aria-label="Previous">
				        <span aria-hidden="true">&laquo;</span>
				      </a>
				    </li>
				    <?php 
				    for($i=0;$i<$num_paginas;$i++){
				    $estilo = "";
				    if($pagina == $i)
				    	$estilo = "class=\"active\"";
				    ?>
				    <li <?php echo $estilo; ?> ><a href="testepaginacao.php?pagina=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
					<?php } ?>
				    <li>
				      <a href="testepaginacao.php?pagina=<?php echo $num_paginas-1; ?>" aria-label="Next">
				        <span aria-hidden="true">&raquo;</span>
				      </a>
				    </li>
				  </ul>
				</nav>
  				<?php } ?>
  			</div>
  		</div>
  	</div>


  	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  	<!-- Include all compiled plugins (below), or include individual files as needed -->
  	<script src="js/bootstrap.min.js"></script>
  </body>
  </html>