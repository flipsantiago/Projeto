<?php
require_once ("banco-usuario.php");
require_once("cabecalho.php");
require_once("logica-usuario.php");
?>

<h1>Bem vindo!</h1>

<?php
if(usuarioEstaLogado()) {
?>
	<p class="text-success">Você está logado como <?= usuarioLogado() ?>. <a href="logout.php">Deslogar</a></p>
<?php
} else {
?>
<?php
}
?>

<?php include("rodape.php"); ?>