<?php
	session_start();

	if (!isset($_SESSION['logado'])) {
		header('Location: login.php');
	}

	if (!isset($_SESSION['administracao'])) {
		
	}
?>
<?php
	require("cabecalho.php");
?>
<h1>Início</h1>
<h2><?php echo $_SESSION['nome']; ?></h2>
<?php
	$id = $_SESSION['id'];

	if (isset($_SESSION['administracao'])) {
		echo "<a href='elementos.php?id=" . $id . "'>Elementos</a> | <a href='logoff.php'>Logoff</a> | <a href='usuarios.php'>Usuários</a>";
	} else {
		echo "<a href='elementos.php?id=" . $id . "'>Elementos</a> | <a href='logoff.php'>Logoff</a> | <a href='atualiza_cadastro.php?id=" . $id . "'>Atualizar cadastro</a> | <a href='exclui_cadastro.php?id=" . $id . "'>Excluir cadastro</a>";
	}
?>
<?php
	require("rodape.php");
?>
</html>