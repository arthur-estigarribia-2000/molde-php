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
<h2>Criar</h2>
<a href="elementos.php?id=<?php echo $_SESSION['id']; ?>">Voltar</a>
<form action="cria_elemento.php" method="post">
	<input class="form-control" type="text" name="nome" placeholder="Nome" minlength="0" maxlength="100">
	<input class="form-control" type="text" name="conteudo" placeholder="Conteúdo">
	<input class="form-control" type="submit" text="Salvar">
</form>
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_SESSION['id'];

        $c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');
    
        $nome = $_POST['nome'];
        $conteudo = $_POST['conteudo'];
    
        $insert = $c->query("INSERT INTO elementos(nome, conteudo, usuario) VALUES('$nome', '$conteudo', '$id');") or die('Erro ao inserir no banco de dados.');
    
        header('Location: elementos.php?id_usuario=' . $id);
    }
?>
<?php
	require("rodape.php");
?>
</html>