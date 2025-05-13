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
<h2>Editar</h2>
<form action="edita_usuario.php?id=<?php echo $_GET['id']; ?>" method="post">
	<?php
        $id = $_GET['id'];

        $c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');

        $q = $c->query("SELECT * FROM usuarios WHERE id = '$id';") or die('Erro na consulta no banco de dados.');

        $usuario = $q->fetch_array();

        echo "<input class='form-control' type='text' name='nome' value='" . $usuario[1] . "' placeholder='Nome' minlength='8' maxlength='100'>";
		echo "<input class='form-control' type='text' name='email' value='" . $usuario[2] . "' placeholder='Email' minlength='8' maxlength='100'>";
		echo "<input class='form-control' type='password' name='senha_antiga' placeholder='Senha antiga' minlength='8' maxlength='16'>";
		echo "<input class='form-control' type='password' name='senha_nova' placeholder='Senha nova' minlength='8' maxlength='16'>";
    ?>
	<input class="form-control" type="submit" text="Atualizar">
</form>
</body>
<?php
	require("rodape.php");
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$id = $_GET['id'];

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
	
		if ($id == obtemIdAdmin()) {
			echo "Não é possível excluir o cadastro do administrador.";
		} else {
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$senha_antiga = md5($_POST['senha_antiga']);
			$senha_nova = md5($_POST['senha_nova']);
			
			if (validaUsuario($email, $senha_antiga)) {
				$q = $c->query("UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha_nova' WHERE id = $id") or die('Erro ao editar cadastro no banco de dados.');

				header("Location: usuarios.php");
			} else {
				echo "Cadastro inválido.";
			}
		}
	}
?>