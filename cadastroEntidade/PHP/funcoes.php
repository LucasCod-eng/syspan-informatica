<?php

/**
 * @param array $dados
 * @param array $regras
 *
 * @return string
 */
function validacaoCampos(array $dados, array $regras)
{
    $msgErros = '';

    foreach ($regras as $indice => $valor) {

        $regrasCampo = explode('|', $regras[$indice]);

        foreach ($regrasCampo as $regra) {
            if (strstr($regra, ':')) {
                $regraAux  = explode(':', $regra);
                $regra     = $regraAux[0];
                $adicional = $regraAux[1];

                //Apagando a variavel auxiliar após seu uso para economizar meoria do PHP
                unset($regraAux);
            }

            switch ($regra) {
                case 'obrigatorio':
                    if (!array_key_exists($indice, $dados)) {
                        $msgErros .= 'O campo ' . ucfirst($indice) . ' é obrigatório' . PHP_EOL;
                    }
                    break;

                case 'max':
                    if (!isset($adicional)) {
                        var_dump('Por favor passe o valor máximo usando como exemplo => max:100');
                        die;
                    }

                    if (isset($dados[$indice]) && (strlen($dados[$indice]) > $adicional)) {
                        $msgErros .= 'O campo ' . ucfirst($indice) . ' deve ter no máximo ' . $adicional . ' caracteres' . PHP_EOL;
                    }
                    break;

                case 'tipo':
                    if (!isset($adicional)) {
                        var_dump('Por favor passe o tipo usando como exemplo => tipo:png,jpg');
                    }

                    $arquivo = $dados[$indice];
                    $check   = getimagesize($arquivo['tmp_name']);

                    if ($check === false) {
                        var_dump('O arquivo enviado não é uma imagem');
                        die;
                    }

                    if (!strstr($adicional, strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION)))) {
                        $msgErros .= 'O arquivo deve ser dos seguintes tipos: ' . $adicional . PHP_EOL;
                    }
                    break;

                case 'cpf':

                    $cpf = $dados[$indice];

                    // Extrair somente os números
                    $cpf = preg_replace('/[^0-9]/is', '', $cpf);

                    // Verifica se foi informado todos os digitos corretamente
                    if (strlen($cpf) != 11) {
                        $msgErros .= 'O CPF não possui o tamanho adequado' . PHP_EOL;
                    }
                    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
                    if (preg_match('/(\d)\1{10}/', $cpf)) {
                        $msgErros .= 'O CPF não não pode ter todos os número repetidos' . PHP_EOL;
                    }
                    // Faz o calculo para validar o CPF
                    for ($t = 9; $t < 11; $t++) {
                        for ($d = 0, $c = 0; $c < $t; $c++) {
                            $d += $cpf{$c} * (($t + 1) - $c);
                        }
                        $d = ((10 * $d) % 11) % 10;
                        if ($cpf{$c} != $d) {
                            $msgErros .= 'O CPF é inválido' . PHP_EOL;
                            break;
                        }
                    }

                    break;

            }

        }

    }

    if (!empty($msgErros)) {
        return $msgErros;
    }

}

/**
 * @param $arquivo
 * @param $complemento
 *
 * @return array
 */
function uploadArquivo($arquivo, $complemento)
{
    $targetDir      = $_SERVER['DOCUMENT_ROOT'] . '/guimasanto/banco2/arquivos/';
    $extension      = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $arquivoCaminho = $complemento . '/' . md5(time()) . '.' . $extension;
    $targetFile     = $targetDir . $arquivoCaminho;

    if (!mkdir($targetDir) && !is_dir($targetDir)) {
        return [
            'erro' => true,
            'msg'  => sprintf('O diretorio "%s" não pode ser criado', $targetDir)
        ];
    }

    //Verificando se a imagem é válida
    $check = getimagesize($arquivo['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        return [
            'erro' => true,
            'msg'  => 'O arquivo já existe'
        ];
    }

    //Verificando o tamanho do arquivo
    if ($arquivo['size'] > 500000) {
        return [
            'erro' => true,
            'msg'  => 'O arquivo tem mais de 50Mb'
        ];
    }

    //Verificando se houve erros
    if (!$uploadOk) {
        return [
            'erro' => true,
            'msg'  => 'Não foi possível fazer o upload'
        ];
    }

    //Caso nao ocorreu um erro fazer o upload
    if (!move_uploaded_file($arquivo['tmp_name'], $targetFile)) {
        return [
            'erro' => true,
            'msg'  => 'Não foi possível fazer o upload'
        ];
    }

    //Caso nao ocorra nenhum problema sera devolvido erro como falso e o caminho do arquivo
    return [
        'erro' => false,
        'msg'  => $arquivoCaminho
    ];
}

/**
 * @param $arquivo
 */
function apagarArquivo($arquivo)
{
    $arquivo = $_SERVER['DOCUMENT_ROOT'] . '/guimasanto/banco2/arquivos/' . $arquivo;

    if (is_file($arquivo)) {
        unlink($arquivo);
    }

}

/**
 * @param $arquivo
 *
 * @return bool|string
 */
function exibirArquivo($arquivo)
{

    if (is_file($_SERVER['DOCUMENT_ROOT'].'/guimasanto/banco2/arquivos/' . $arquivo)) {
        return __DIR_RAIZ . '/arquivos/' . $arquivo;
    }

    return false;
}