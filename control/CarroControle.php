<?php

include_once '../model/Carro.php';
include_once '../database/conexao.php';

$conn = new Conexao();
$conn = $conn->conexao();


if(isset($_POST['placa'])){$placa = $_POST['placa'];}
if(isset($_POST['marca'])){$marca = $_POST['marca'];}
if(isset($_POST['modelo'])){$modelo = $_POST['modelo'];}
if(isset($_POST['ano'])){$ano = $_POST['ano'];}

if(isset($_POST['bt_cadastro_carro'])){
    if(!isset($placa) or !isset($marca) or !isset($modelo) or !isset($ano) or empty($placa) or empty($marca) or empty($modelo) or empty($ano)){
        header('Location: ../view/telaCadastro.php?msg=dadosinvalidos');
    }else{
        inserirCarro($placa, $marca, $modelo, $ano);
    }
}

function inserirCarro($placa, $marca, $modelo, $ano){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `carro`(`placa`, `marca`, `modelo`, `ano`)
                             VALUES (:placa,:marca,:modelo,:ano)");
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $stmt = null;    
    header('Location: ../view/telaCadastro.php?msg=sucesso'); 
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

function buscarCarroPorId($id){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `carro` WHERE `id` like :id");
    $stmt->bindParam(':id', $id);
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