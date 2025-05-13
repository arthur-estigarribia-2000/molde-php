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
<h2>Editar</h2>
<a href="elementos.php?id_usuario=<?php echo $_GET['id_elemento']; ?>">Voltar</a>
<form action="edita_elemento.php?id_elemento=<?php echo $_GET['id_elemento']; ?>" method="post">
	<?php
        $id_elemento = $_GET['id_elemento'];

        $c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');

        $insert = $c->query($c, "SELECT * FROM elementos WHERE id = '$id_elemento';") or die('Erro na consulta no banco de dados.');

        $elementos = $c->fetch_array($insert);

        echo "<input class='form-control' type='text' name='nome' value='" . $elementos[1] . "' placeholder='Nome' minlength='0' maxlength='100'>";
        echo "<input class='form-control' type='text' name='conteudo' value='" . $elementos[2] . "' placeholder='Conteúdo'>";
    ?>
	<input class="form-control" type="submit" text="Salvar">
</form>
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_usuario = $_SESSION['id'];

        $c = mysqli_connect('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');
    
        $nome = $_POST['nome'];
        $conteudo = $_POST['conteudo'];
    
        $insert = mysqli_query($c, "UPDATE elementos SET nome='$nome', conteudo='$conteudo', usuario='$id_usuario' WHERE id='$id_elemento';") or die('Erro ao editar no banco de dados.');
    
        header('Location: elementos.php?id_usuario=' . $id_usuario);
    }
?>
<?php
	require("rodape.php");
?>
</html>