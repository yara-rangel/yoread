<?php
	require_once("../config.php");

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if(checkValues($_POST['user'], $_POST['senha']))
		{
			$username = $_POST['user'];
			$senha = $_POST['senha'];
			login($username, $senha);
		}
		else {
			$message = '<h1>Por favor, preencha os campos corretamente.</h1>
						<h3><a href="index.php">Tentar Novamente</a></h3>';
			echo $message;
		}
	}
	else {		
		header("Location: ../index.html");
	}

	function checkValues($username, $senha) {
		if( isset($username) && !empty($username) && isset($senha) && !empty($senha) ){
			$R = true;
		}
		else {
			$R = false;
		}
		return $R;
	}

	function login($username, $senha) {
		$config = new Config();
		$conexao = $config->conectaBanco();

		$query = "SELECT * FROM yoread.users WHERE username = '".$username."' AND senha = ".$senha;

		$result = mysqli_query($conexao, $query) or die('Invalid query: ' . $conexao->error);

		if(mysqli_num_rows($result) == 1){
			$user = $result->fetch_array(MYSQLI_ASSOC);
			session_start();
			$_SESSION['user']['username'] = $user['username'];
			$_SESSION['user']['nome'] = $user['nome'];
			$_SESSION['user']['sobrenome'] = $user['sobrenome'];
			header("Location: ../inicial.php");
		}
		else {
			$message = '<h1>Senha ou username Incorretos.</h1>
						<h3>Por favor, <a href="index.php">Tente Novamente</a></h3>';
		}
		//echo $message;
	}
?>