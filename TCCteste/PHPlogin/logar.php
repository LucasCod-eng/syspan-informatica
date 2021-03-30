<?php 

require 'PHPconexao/conexao.php';

$login = $_POST['login'];
$senha = md5($_POST['senha']);
$entrar = $_POST['entrar'];
// $connect = mysql_connect('localhost','root','root');
$db = mysql_select_db('usuarios');
  if (isset($entrar)) {
           
    $verifica = mysql_query("SELECT * FROM usuarios WHERE login = 
    '$login' AND senha = '$senha'") or die("erro ao selecionar");
      if (mysql_num_rows($verifica)<=0){
        echo"<script language='javascript' type='text/javascript'>
        alert('Login e/ou senha incorretos');window.location
        .href='';</script>";
        die();
      }else{
        setcookie("login",$login);
        header("Location:");
      }
  }
?>