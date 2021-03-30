<?php
//Incluindo varaiveis para uso
require_once __DIR__ . '/../../config/config.php';
?>

<html>
	<head>
		<title>Login Alunos </title>
		<meta charset="utf-8"/>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<style>
			label{
				display:block;
			}
			
			.semBlock{
				display: inline;
			}
			
		</style>
		
	</head>
	<body>

		<?php
            // A chamada <?= é a versao simplificada para <?php echo
		?>
		<form action="<?=__DIR_MODULO_ALUNO?>/autenticarAluno.php" method="post">
			<h1>Login</h1>
				
				<label for="email">E-mail</label>
                <input type="text" id="email" name="email" placeholder="Digite seu e-mail"/><br/>
                
                <label for="nome">Senha</label>
				<input type="password" name="senha" id="senha" placeholder="digite sua senha"/><br/><br/>

                <input type="submit" name="entrar" value="Acessar"/>
        </form>
    </body>
</html>