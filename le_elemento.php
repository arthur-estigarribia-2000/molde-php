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
<h1>Elementos</h1>
<h2>Ler</h2>
<a href="elementos.php?id_usuario=<?php echo $_SESSION['id']; ?>">Voltar</a>
<?php
	$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');

	$id_usuario = $_SESSION['id'];

    $id_elemento = $_GET['id_elemento'];

	$q = $c->query("SELECT * FROM elementos WHERE id = '$id_elemento';") or die('Erro na consulta no banco de dados.');

	$elemento = $q->fetch_array();

    if ($elemento[3] == $id_usuario) {
        echo "<h3>" . $elemento[1] . "</h3>";

		echo "<a href='edita_elemento.php?id_elemento=" . $id_elemento . "'>Editar</a> | <a href='exclui_elemento.php?id_elemento=" . $id_elemento . "'>Excluir</a>";

		echo "<p>" . $elemento[2] . "</p>";
    } else {
        echo "<h3>Acesso negado</h3>";
            
        echo "<p>Você não tem permissão para acessar este elemento.</p>";
    }
?>
<?php
	require("rodape.php");
?>
</html>