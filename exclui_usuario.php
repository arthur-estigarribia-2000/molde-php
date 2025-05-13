<?php
	session_start();

	if (!isset($_SESSION['logado'])) {
		header('Location: login.php');
	}

	if (!isset($_SESSION['administracao'])) {
		echo 'Você não tem permissão para acessar esta página.';
	}
?>
<?php
	$id = $_GET['id'];

	$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');

	function obtemId($c, $e, $s) {
		$q = $c->query("SELECT id FROM usuarios WHERE email = '$e' AND senha = md5('$s');") or die("Erro na consulta no banco de dados.");
		$r = $q->fetch_assoc();

		return $r["id"];
	}

	function obtemIdAdmin($c) {
		return obtemId($c, 'admin@admin.ad', 'naosei1234*');
	}

	if ($id == obtemIdAdmin($c)) {
		echo "Não é possível excluir o cadastro do administrador.";
	} else {
		$q = $c->query("DELETE FROM usuarios WHERE id = $id");

		if ($q) {
			echo "Cadastro excluído com sucesso.";
			
			$c->close();

			header('Location: usuarios.php');
		} else {
			echo "Erro ao excluir cadastro.";
		}
	}
?>