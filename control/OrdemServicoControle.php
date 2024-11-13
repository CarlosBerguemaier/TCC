<?php

include_once '../model/Funcionario.php';
include_once '../model/Carro.php';
include_once '../model/Cliente.php';
include_once '../model/OrdemServico.php';
include_once '../database/conexao.php';
include_once '../control/ClienteControle.php';
include_once '../control/CarroControle.php';
include_once '../control/FuncionarioControle.php';

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

if(isset($_POST["bt_busca_ordemservico"])){
    if(!isset($_POST["busca"]) or empty($_POST["busca"]) or empty($_GET['coluna']) or !isset($_GET['coluna'])){
            header ('Location: ../view/telaBusca.php?msg=naoencontrado');
        }   
    if($_GET['coluna'] = "cpf_c"){
    $cliente = buscarCliente($_POST['busca']);
    if( null!==($cliente->getId()) or empty($cliente->getId())){
     header('Location: ../view/telaBusca.php?msg=naoencontrado');
    }
    }
    buscarOrdemServico($_POST['busca'] , $_GET['coluna']);
    

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

function buscarOrdemServico($valor_busca , $coluna){
    if(!isset($valor_busca) or !isset($coluna) or empty($valor_busca) or empty($coluna)){
        header('Location: ERRO');
    }
    $conn = new Conexao();
    $conn = $conn->conexao();
    if($coluna == "cpf_c"){
        $busca = buscarCliente($valor_busca);
        $valor_para_buscar = $busca->getId(); 
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE id_cliente like :busca"); 
        }
    if($coluna == "cpf_f"){
            $busca = buscarFuncionario($valor_busca);
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE id_funcionario like :busca");
            $valor_para_buscar = $busca->getId();   
        }
    if($coluna == "placa"){
            $busca = buscarCarro($valor_busca);
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE id_carro like :busca");
            $valor_para_buscar = $busca->getId();
        }
    if($coluna == "descricao"){
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE descricao like :busca");
            $valor_para_buscar = "%".$valor_busca."%";
        }
    if($coluna == "valor"){
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE valor like :busca");
            $valor_para_buscar = $valor_para_buscar;
        }
    $stmt->bindParam(':busca', $valor_para_buscar);
    $stmt->execute();

    $resultado = $stmt->fetchAll();
    $vetor_servicos[] = "";
    $i = 0;
       foreach($resultado as $ordem){
        $ordemservico = new OrdemServico();
        $ordemservico->setID($ordem['id']);
        $ordemservico->setId_carro($ordem['id_carro']);
        $ordemservico->setId_cliente($ordem['id_cliente']);
        $ordemservico->setId_funcionario($ordem['id_funcionario']);
        $ordemservico->setValor($ordem['valor']);
        $ordemservico->setDescricao($ordem['descricao']);
        $ordemservico->setKminicial($ordem['kminicial']);
        $ordemservico->setKmfinal($ordem['kmfinal']);
        $vetor_servicos[$i] = $ordemservico;
        $i++; 
    }
       return $vetor_servicos;    
}






?>