<?php

include_once '../model/Cliente.php';
include_once '../database/conexao.php';

$conn = new Conexao();
$conn = $conn->conexao();
$result = false;

if(isset($_POST['nome'])){$nome = $_POST['nome'];$result = true;}
if(isset($_POST['telefone'])){$telefone = $_POST['telefone'];}
if(isset($_POST['cpf'])){$cpf = $_POST['cpf'];}

if(isset($_POST['bt_cadastro_cliente'])){
    echo 'botao clicado';
    if(!isset($nome) or !isset($telefone) or !isset($cpf)){
        header('Location: ../view/telaCadastro.php?erro=dadosinvalidos'); 
    }else{
        inserirCliente($nome, $telefone, $cpf);
    }
}

function inserirCliente($nome,$telefone,$cpf){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `cliente`(`nome`, `telefone`, `cpf`)
                             VALUES (:nome,:telefone,:cpf)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $stmt = null;    
    header('Location: ../view/telaCadastro.php?msg=sucesso'); 
}
?>