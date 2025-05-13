<?php
	session_start();

	if (!isset($_SESSION['logado'])) {
		header('Location: login.php');
	}

	if (!isset($_SESSION['administracao'])) {
		
	}
?>
<?php
	$id = $_GET['id_elemento'];

	$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');

	$q = $c->query($c, "DELETE FROM elementos WHERE id = $id");

	if ($q) {
		echo "Elemento excluído com sucesso.";

		$c->close();

		header('Location: elementos.php');
	} else {
		echo "Erro ao excuir elemento.";
	}
?>