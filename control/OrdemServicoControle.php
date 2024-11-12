<?php

include_once '../model/Funcionario.php';
include_once '../model/Carro.php';
include_once '../model/Cliente.php';
include_once '../model/OrdemServico.php';
include_once '../database/conexao.php';

$conn = new Conexao();
$conn = $conn->conexao();

if(isset($_POST['placa'])){$placa = $_POST['placa'];}
if(isset($_POST['cpf_cliente'])){$cpf_cliente = $_POST['cpf_cliente'];}
if(isset($_POST['cpf_funcionario'])){$cpf_funcionario = $_POST['cpf_funcionario'];}
if(isset($_POST['descricao'])){$descricao = $_POST['descricao'];}
if(isset($_POST['valor'])){$valor = $_POST['valor'];}
if(isset($_POST['kminicial'])){$kminicial = $_POST['kminicial'];}
if(isset($_POST['kmfinal'])){$kmfinal = $_POST['kmfinal'];}

if(isset($_POST['bt_cadastro_ordemservico'])){
    $cliente = buscarCliente($cpf_cliente);
    $funcionario = buscarFuncionario($cpf_funcionario);
    $carro = buscarCarro($placa);
  
     if($cliente->getCpf() != null and $funcionario->getCpf() != null and $carro->getPlaca() != null){
        if(!isset($descricao) or !isset($valor) or !isset($kminicial) or !isset($kmfinal) or empty($descricao) or empty($valor) or empty($kminicial) or empty($kmfinal)){
            header('Location: ../view/telaCadastro.php?msg=dadosinvalidos'); 
        }else{
            inserirOrdemServico($carro->getId(),$cliente->getId(),$funcionario->getId(),$valor,$descricao,$kminicial,$kmfinal);
        }
    }else{
        header('Location: ../view/telaCadastro.php?msg=dadosinvalidos'); 
    }

}

function inserirOrdemServico($id_carro,$id_cliente,$id_funcionario,$valor,$descricao,$kminicial,$kmfinal){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `ordem_servico`(`id_cliente`, `id_funcionario`, `id_carro`, `valor`, `descricao`, `kminicial`, `kmfinal`)
     VALUES (:id_cliente,:id_funcionario,:id_carro,:valor,:descricao, :kminicial, :kmfinal)");
    $stmt->bindParam(':id_carro', $id_carro);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->bindParam(':id_funcionario', $id_funcionario);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':kminicial', $kminicial);
    $stmt->bindParam(':kmfinal', $kmfinal);
 
    $stmt->execute();
    $stmt = null;    
    header('Location: ../view/telaCadastro.php?msg=sucesso'); 
}

function buscarCliente($cpf){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE `cpf` like :cpf");
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $cliente = new Cliente();
       while( $result = $stmt->fetch()){
        $cliente->setID($result["id"]);
        $cliente->setNome($result["nome"]);
        $cliente->setCpf($result["cpf"]);
        $cliente->setTelefone($result["telefone"]);
       }
       return $cliente;    
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


function buscarCarro($placa){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `carro` WHERE `placa` like :placa");
    $stmt->bindParam(':placa', $placa);
    $stmt->execute();
    $carro = new Carro();
       while( $result = $stmt->fetch()){
        $carro->setID($result["id"]);
        $carro->setPlaca($result["placa"]);
        $carro->setMarca($result["marca"]);
        $carro->setModelo($result["modelo"]);
        $carro->setAno($result["ano"]);
       }
       return $carro;    
}

?>