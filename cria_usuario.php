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
<h1>Criar</h1>
<form action="cria_usuario.php" method="post">
	<input class="form-control" type="text" name="nome" placeholder="Nome" minlength="8" maxlength="100">
	<input class="form-control" type="text" name="email" placeholder="Email" minlength="8" maxlength="100">
	<input class="form-control" type="password" name="senha" placeholder="Senha" minlength="8" maxlength="16">
	<input class="form-control" type="submit" text="Cadastrar">
</form>
<?php
	require("rodape.php");
?>
</html>
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');
		
		function validaUsuario($email, $senha){
			return preg_match("/(\S+)@(\S+).(\S+)/i", $email) && preg_match("/([a-zA-Z]+|[0-9]+){8,}/i", $senha);
		}

		function nenhumUsuario($c, $e, $s) {
			$q = $c->query("SELECT email, senha FROM usuarios WHERE email = '$e' AND senha = md5('$s');") or die('Erro na consulta no banco de dados.');
			$r = $q->fetch_assoc();

			return empty($r);
		}

		function obtemId($c, $e, $s) {
			$q = $c->query("SELECT id FROM usuarios WHERE email = '$e' AND senha = md5('$s');") or die("Erro na consulta no banco de dados.");
			$r = $q->fetch_assoc($q);

			return $r["id"];
		}

		function obtemIdAdmin($c) {
			return obtemId($c, 'admin@admin.ad', 'naosei1234*');
		}

		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$senha = $_POST['senha'];

		if (validaUsuario($email, $senha) && nenhumUsuario($c, $email, $senha)) {
			$insert = $c->query("INSERT INTO usuarios(nome, email, senha) VALUES ('$nome', '$email', md5('$senha'));") or die('Erro na conexão com o banco de dados.');

			header("Location: usuarios.php");

			echo 'Usuário cadastrado com sucesso!';
		} else {
			echo "Cadastro inválido.";
		}
	}
?>