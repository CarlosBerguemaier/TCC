<?php

include_once '../model/Funcionario.php';
include_once '../database/conexao.php';

$conn = new Conexao();
$conn = $conn->conexao();


if(isset($_POST['nome'])){$nome = $_POST['nome'];}
if(isset($_POST['telefone'])){$telefone = $_POST['telefone'];}
if(isset($_POST['cpf'])){$cpf = $_POST['cpf'];}

if(isset($_POST['bt_cadastro_funcionario'])){
    if(!isset($nome) or !isset($telefone) or !isset($cpf)){
        header('Location: ../view/telaCadastro.php?erro=dadosinvalidos'); 
    }else{
        inserirFuncionario($nome, $telefone, $cpf);
    }
}

function inserirFuncionario($nome,$telefone,$cpf){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `funcionario`(`nome`, `telefone`, `cpf`)
                             VALUES (:nome,:telefone,:cpf)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $stmt = null;    
    header('Location: ../view/telaCadastro.php?msg=sucesso'); 
}
?>