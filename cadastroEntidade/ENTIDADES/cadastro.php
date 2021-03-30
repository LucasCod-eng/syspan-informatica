
<?php

//Incluindo varaiveis para uso
require_once __DIR__ . '/../../config/config.php';

//INCLUIR A CONEXAO
require_once __DIR__ . '/../../config/conexao.php';

?>


<html>
<head>
    <title> </title>
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

<div class="container">
    <form action="<?=__DIR_MODULO_ALUNO?>/inserir.php" method="post" enctype="multipart/form-data">
        <h1>Dados Pessoais</h1>

        <label class="form-group">Nome
            <input class="form-control" type="text" name="nome" id="nome" autofocus="autofocus" placeholder="Digite seu nome" required />
        </label>

        <label class="form-group">E-mail
            <input class="form-control" type="text" id="email" name="email" placeholder="Digite seu e-mail" required />
        </label>

        <label class="form-group">Senha
            <input class="form-control" type="password" name="senha" placeholder="Digite seu senha" required />
        </label>

        <label class="form-group">CPF
            <input class="form-control" type="tel" id="cpf" name="cpf" placeholder="Digite seu CPF" required />
        </label>

        <label class="form-group">Cidade
            <input class="form-control" type="text" id="cidade" name="cidade" placeholder="Digite sua cidade" required />
        </label>

        <div class="form-group mt-3">
            <input type="file" class="form-control" id="foto" name="foto" required >
        </div>
        <div class="mb-5"></div>
        <label for="turmas">Turmas</label>
        <style>
            .custom-size{
                min-width: 100px;
            }
        </style>

        <div class="d-flex flex-wrap">
            <?php

            //CRIANDO SQL QUe IRA BUSCAR AS TURMAS
            $stmt = $conexao->prepare('SELECT * FROM TURMAS');

            //EXECUTAR SQL
            $stmt->execute();

            if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {

                do {

                    echo '
                        <div class="custom-control custom-checkbox mr-5 mb-2 custom-size">
                          <input 
                          value="'.$resultado['ID_TURMA'].'" 
                          type="checkbox" 
                          class="custom-control-input"
                          id="checkbox-'.$resultado['ID_TURMA'].'" 
                          name="turmas[]">
                          <label class="custom-control-label" for="checkbox-'.$resultado['ID_TURMA'].'">'.$resultado['NOME'].'</label>
                        </div>
								';

                }while($resultado = $stmt->fetch(PDO::FETCH_ASSOC));

            } else {
                echo "Nenhum registro encontrado";
            }

            ?>
        </div>

        <button type="submit" class="btn btn-success mt-3" name="cadastrar">Confirmar Cadastro</button>

    </form>
</div>

</body>
</html>	
	