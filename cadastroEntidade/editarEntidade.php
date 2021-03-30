<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
	integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<title>Document</title>
</head>
<body>


<?php
require 'conexao.php';

$ID = $_GET['ID'];

$smtp = $conexao->prepare('SELECT NOME, ENDERECO, TELEFONE, UF, CIDADE, EMAIL, SENHA, CNPJ FROM alunos WHERE ID = :ID');

$smtp->bindValue('ID', $ID);

$smtp->execute();

$resultado = $smtp->fetch(PDO::FETCH_ASSOC);

?>

<html>
	<head>
		<title> </title>
		<meta charset="utf-8"/>
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
			
		<form action="confirmaEdicaoAluno.php" method="post">
			<h1>Editar dados Pessoais</h1>
				<input type="hidden" name="id"  value="<?php echo $resultado['ID'];?>"/>
				
				<label for="nome">Nome:</label>
				<input type="text" name="nome" id="nome" autofocus="autofocus" placeholder="digite seu nome" value="<?php echo $resultado['NOME'];?>"/>
				
				<label for="enderecp">Endereço:</label>
                <input type="text" id="endereco" name="endereco" placeholder="Digite seu Enderecço" value="<?php echo $resultado['ENDERECO'];?>"/><br/>
                
                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" placeholder="Digite seu Telefone" value="<?php echo $resultado['TELEFONE '];?>"/><br/>
                
                <label for="uf">UF:</label>
				<input type="text" id="uf" name="uf" placeholder="Digite seu UF" value="<?php echo $resultado['UF'];?>"/><br/>

				<label for="cidade">Cidade:</label>
				<input type="text" id="cidade" name="cidade" placeholder="Digite sua Cidade" value="<?php echo $resultado['Cidade'];?>"/><br/>

				<label for="email">Email:</label>
				<input type="text" id="uf" name="email" placeholder="Digite seu Email" value="<?php echo $resultado['EMAIL'];?>"/><br/>

				<label for="uf">Senha:</label>
				<input type="text" id="senha" name="senha" placeholder="Digite sua Senha" value="<?php echo $resultado['SENHA'];?>"/><br/>

				<label for="cnpj">CNPJ:</label>
				<input type="text" id="cnoj" name="cnpj" placeholder="Digite seu CNPJ" value="<?php echo $resultado['CNPJ'];?>"/><br/>
								
			
			<input type="submit" name="cadastrar" value="Confirmar Cadastro" />
			<a href="listarAlunos.php">Listar</a>
			
		</form>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>
	