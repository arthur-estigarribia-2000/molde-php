<?php
	session_start();

	if (isset($_SESSION['logado'])) {
		header('Location: inicio.php');
	}

	if (isset($_SESSION['administracao'])) {
		header('Location: usuarios.php');
	}
?>
<?php
	require("cabecalho.php");
?>
<h1>Login</h1>
<form action="login.php" method="post">
	<input class="form-control" type="text" name="email" placeholder="Email" minlength="8" maxlength="100">
	<input class="form-control" type="password" name="senha" placeholder="Senha" minlength="8" maxlength="16">
	<input class="form-control" type="submit" text="Entrar">
</form>
<a href="cadastro.php">Ainda não é cadastrado? Faça seu cadastro aqui!</a>
<?php
	require("rodape.php");
?>
</html>
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');

		function valida($email, $senha){
			return preg_match("/(\S+)@(\S+).(\S+)/i", $email) && preg_match("/([a-zA-Z]+|[0-9]+){8,}/i", $senha);
		}

		function obtem($email, $senha) {
			$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');

			$q = $c->query("SELECT * FROM usuarios WHERE email = '$email' AND senha = md5('$senha');") or die("Erro na consulta no banco de dados.");
			$r = $q->fetch_assoc();

			return $r;
		}

		function obtemIdAdmin() {
			return obtem('admin@admin.ad', 'naosei1234*')['id'];
		}

		$email = $_POST['email'];
		$senha = $_POST['senha'];

		if (validaUsuario($email, $senha) && obtem($email, $senha)) {
			$_SESSION['id'] = obtem($c, $email, $senha)['id'];
			$_SESSION['nome'] = obtem($c, $email, $senha)['nome'];
			$_SESSION['email'] = $email;
			$_SESSION['logado'] = true;

			if ($_SESSION['id'] == obtemIdAdmin($c)) {
				$_SESSION['administracao'] = true;
			}

			header("Location: inicio.php");
		} else {
			unset($_SESSION['id'], $_SESSION['nome'], $_SESSION['email'], $_SESSION['logado'], $_SESSION['administracao']);

			session_destroy();

			echo "Login inválido.";
		}
	}
?>