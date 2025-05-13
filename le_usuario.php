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
	require("cabecalho.php");
?>
<h1>Usuários</h1>
<h2>Ler</h2>
<a href="elementos.php?id_usuario=<?php echo $_GET['id']; ?>">Voltar</a>
<?php
	$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');

    $id = $_GET['id'];

	$q = $c->query("SELECT * FROM usuarios WHERE id = '$id';") or die('Erro na consulta no banco de dados.');

	$u = $q->fetch_array();

    echo "<h3>" . $u[1] . "</h3>";

    echo "<a href='edita_usuario.php?id=" . $id . "'>Editar</a> | <a href='exclui_usuario.php?id=" . $id . "'>Excluir</a>";

    echo "<p>" . $u[2] . "</p>";
?>
<?php
	require("rodape.php");
?>
</html>