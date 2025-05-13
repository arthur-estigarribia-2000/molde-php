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
<h2>Lista</h2>
<a href="inicio.php">Início</a> | <a href="cria_usuario.php">Criar usuário</a>
<?php
	$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');
	
    $id = $_SESSION['id'];

	$q = $c->query("SELECT * FROM usuarios;") or die('Erro na consulta no banco de dados.');

    $usuarios = $q->fetch_all();

    if ($usuarios) {
        echo "<table class='table'><thead><tr><th scope='col'>Nome</th><th scope='col'>Acessar</th></thead><tbody>";

        for ($i = 1; $i < sizeof($usuarios); $i++) {
            $u = $usuarios[$i];

            echo "<tr><th scope='row'>" . $u[1] . "</th><td><a href='le_usuario.php?id=" . $u[0] . "'>Acessar</a></td></tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>Nenhum usuário.</p>";
    }
?>
<?php
	require("rodape.php");
?>
</html>