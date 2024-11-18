<?php

include_once '../model/Funcionario.php';
include_once '../database/conexao.php';

$conn = new Conexao();
$conn = $conn->conexao();


if(isset($_POST['nome'])){$nome = $_POST['nome'];}
if(isset($_POST['telefone'])){$telefone = $_POST['telefone'];}
if(isset($_POST['cpf'])){$cpf = $_POST['cpf'];}

if(isset($_POST['bt_cadastro_funcionario'])){
    if(!isset($nome) or !isset($telefone) or !isset($cpf) or empty($nome) or empty($telefone) or empty($cpf)){
        header('Location: ../view/telaCadastro.php?msg=dadosinvalidos');
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

function buscarFuncionario($cpf){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `funcionario` WHERE `cpf` like :cpf");
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $funcionario = new Funcionario();
       while( $result = $stmt->fetch()){
        $funcionario->setID($result["id"]);
        $funcionario->setNome($result["nome"]);
        $funcionario->setCpf($result["cpf"]);
        $funcionario->setTelefone($result["telefone"]);
       }
       return $funcionario;    
}


function buscarFuncionarioPorId($id){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `funcionario` WHERE `id` like :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $funcionario = new Funcionario();
       while( $result = $stmt->fetch()){
        $funcionario->setID($result["id"]);
        $funcionario->setNome($result["nome"]);
        $funcionario->setCpf($result["cpf"]);
        $funcionario->setTelefone($result["telefone"]);
       }
       return $funcionario;    
}
?>