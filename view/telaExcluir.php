<?php
include_once '../model/Funcionario.php';
include_once '../model/Carro.php';
include_once '../model/Cliente.php';
include_once '../model/OrdemServico.php';
include_once '../database/conexao.php';
include_once '../control/ClienteControle.php';
include_once '../control/CarroControle.php';
include_once '../control/FuncionarioControle.php';
include_once '../control/ServicoControle.php';

if(isset($_POST['bt_excluir']) and isset($_POST['id'])){
  excluirOS($_POST['id']);
  header('Location: ../view/index.php?msg=sucesso');
}

function excluirOS($id){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("DELETE FROM `ordem_servico` WHERE id = :id;");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}


?>