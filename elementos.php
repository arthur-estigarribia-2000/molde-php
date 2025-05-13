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
<h2>Lista</h2>
<a href="inicio.php">Início</a> | <a href="cria_elemento.php?id_usuario=<?php echo $_SESSION['id']; ?>">Criar elemento</a>
<?php
	$c = new mysqli('localhost', 'root', '', 'teste') or die('Erro na conexão com o banco de dados.');
	
    $id = $_SESSION['id'];

	$q = $c->query("SELECT * FROM elementos WHERE usuario = '$id';") or die('Erro na consulta no banco de dados.');

    $elementos = $q->fetch_all();

    if ($elementos) {
        echo "<table class='table'><thead><tr><th scope='col'>Nome</th><th scope='col'>Acessar</th></tr></thead><tbody>";

        for ($i = 0; $i < sizeof($elementos); $i++) {
            $item = $elementos[$i];

            echo "<tr><th scope='row'>" . $item[1] . "</th><td><a href='le_elemento.php?id_elemento=" . $item[0] . "'>Acessar</a></td></tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>Nenhum elemento.</p>";
    }
?>
<?php
	require("rodape.php");
?>
</html>