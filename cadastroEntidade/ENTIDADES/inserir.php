<!Doctype html>
<html>
<head>
    <title>Formulário de cadastro de Alunos</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<?php

//Incluindo varaiveis para uso
require_once __DIR__ . '/../../config/config.php';

//INCLUIR A CONEXAO
require_once __DIR__ . '/../../config/conexao.php';

//INCLUIR FUNÇÕES úTEIS
require_once __DIR__ . '/../../config/funcoes.php';

//Juntando o array de dados do POST junto com o FILES
$dados  = array_merge($_POST, $_FILES);
$regras = [
    'nome'   => 'obrigatorio|max:100',
    'email'  => 'obrigatorio|email|max:100',
    'cpf'    => 'obrigatorio|cpf|max:15',
    'senha'  => 'obrigatorio|max:100',
    'cidade' => 'obrigatorio|max:100',
    'foto'   => 'obrigatorio|tipo:png,jpg,jpeg',
    'turmas' => 'obrigatorio|array',
];

//Validando os campos que forma enviados pelo formulario com base nas regras passdas
if ($msgErro = validacaoCampos($dados, $regras)) {
    echo $msgErro;
    die;
}

//Fazendo upload e tratamento do arquivo
$retorno = uploadArquivo($_FILES['foto'], 'aluno');

//Verificando se ocorreu algum erro
if ($retorno['erro']) {
    var_dump($retorno['msg']);
    die;
}

//RECEBENDO DADOS DO FORMULÁRIO
$nome   = $_POST['nome'];
$email  = $_POST['email'];
$cpf    = $_POST['cpf'];
$cpf = preg_replace('/[^0-9]/is', '', $cpf);
$cidade = $_POST['cidade'];
$foto   = $retorno['msg'];
$senha  = md5($_POST['senha']);
$turmas = $_POST['turmas'];

//Verificando antes se já existe um usuário com este email

//CRIANDO SQL QUE IRA VERIFICAR SE EXISTE O REGISTRO
$stmt = $conexao->prepare('SELECT * FROM ALUNOS WHERE EMAIL = :email LIMIT 1');
$stmt->bindValue('email', $email);

//EXECUTAR SQL
$stmt->execute();

if ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo 'Já existe um registro com este e-mail';
    die;
}

//CRIANDO SQL QUE IRA INSERIR OS DADOS
$stmt = $conexao->prepare('INSERT INTO alunos (NOME, EMAIL, SENHA, FOTO, CPF, CIDADE) VALUE (:nome, :email, :senha, :foto, :cpf, :cidade)');

//PASSANDO OS VALORES PARA OS PARAMENTROS DA SQL
$stmt->bindValue('nome', $nome);
$stmt->bindValue('email', $email);
$stmt->bindValue('cpf', $cpf);
$stmt->bindValue('senha', $senha);
$stmt->bindValue('foto', $foto);
$stmt->bindValue('cidade', $cidade);

//EXECUTA A SQL E VERIFICA O RESULTAO PARA MOSTRAR UMA MENSAGEM DE SUCESSO OU ERRO
if ($stmt->execute() == true) {
    echo 'Aluno inserido com sucesso' . PHP_EOL;

    $idAluno = $conexao->lastInsertId();

    //CRIANDO SQL QUE IRA INSERIR OS DADOS
    $stmtTurma = $conexao->prepare('INSERT INTO turma_tem_alunos (ID_TURMA, ID_ALUNO, DATA_MATRICULA) VALUE (:turma, :aluno, :datamatricula)');

    foreach ($turmas as $idTurma) {

        $stmtTurma->bindValue('turma', $idTurma);
        $stmtTurma->bindValue('aluno', $idAluno);
        $stmtTurma->bindValue('datamatricula', date('Y-m-d'));

        if ($stmtTurma->execute() == true) {
            echo 'Aluno matriculado na turma ' . $idTurma . ' com sucesso</br/>';
        } else {
            echo 'Erro ao matricular o aluno</br/>';
        }

    }

} else {
    print_r($stmt->errorInfo());
    echo 'Erro ao inserir aluno';
}

?>

<a href="<?=__DIR_MODULO_ALUNO?>/listar.php" class="mt-5 btn btn-primary">Voltar a listagem de aluno</a>

</body>
</html>