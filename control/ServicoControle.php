<?php 
include_once '../database/conexao.php';
include_once '../model/Servico.php';
include_once '../model/Servico_OS.php';

function buscarTodosServicos()
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `servico`");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $vetor_servicos[] = "";
    $i = 0;
    foreach ($resultado as $restultado_objeto) {
        $Servico = new Servico();
        $Servico->setID($restultado_objeto['id']);
        $Servico->setDescricao($restultado_objeto['descricao']);
        $vetor_servicos[$i] = $Servico;
        $i++;
    }
    return $vetor_servicos;
}

function buscarNumeroDeServicos()
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `servico`");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $vetor_servicos[] = "";
    $i = 0;
    $maior = 0;
    foreach ($resultado as $restultado_objeto) {
        if($restultado_objeto['id'] > $maior){
            $maior = $restultado_objeto['id'];
        }

        $i++;
    }
    return $maior;
}

function inserirServico_OS($id_servico, $id_os){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `servico_os`(`id_servico`, `id_os`)
     VALUES (:id_servico,:id_os)");
    $stmt->bindParam(':id_servico', $id_servico);
    $stmt->bindParam(':id_os', $id_os);
    $stmt->execute();
    $stmt = null;
}

function verificarServico_os($id_servico, $id_os){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `servico_os` where `id_servico` like :id_servico and `id_os` like :id_os ");
    $stmt->bindParam(':id_servico', $id_servico);
    $stmt->bindParam(':id_os', $id_os);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach ($resultado as $restultado_objeto){
        if(!empty($restultado_objeto)){
             return true;
        }
    }
    return false;
    }
    
    function buscarServicoPorId($id_servico)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `servico` where `id` like :id_servico");
    $stmt->bindParam(':id_servico', $id_servico);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    foreach ($resultado as $restultado_objeto) {
        $servico = new Servico();
        $servico->setId($id_servico);
        $servico->setDescricao($restultado_objeto['descricao']);
        echo $servico->getDescricao();
    }
 
    return $servico;
}

    function buscar_sv_os_por_os($id_os)
    {
        $conn = new Conexao();
        $conn = $conn->conexao();
        $stmt = $conn->prepare("SELECT * FROM `servico_os` WHERE `id_os` like :id_os");
        $stmt->bindParam(':id_os', $id_os);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $vetor_servicos[] = "";
        $i = 0;
        foreach ($resultado as $restultado_objeto) {
            $vetor_servicos[$i] = $restultado_objeto['id_servico'];
            $i++;
        }
        return $vetor_servicos;
    }

    function buscar_os_os_por_sv($id_sv)
    {
        $conn = new Conexao();
        $conn = $conn->conexao();
        $stmt = $conn->prepare("SELECT * FROM `servico_os` WHERE `id_servico` = :id_servico");
        $stmt->bindParam(':id_servico', $id_sv);
        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $vetor_os[] = "";
        $i = 0;
        foreach ($resultado as $restultado_objeto) {
            $vetor_os[$i] = $restultado_objeto['id_os'];
            $i++;
        }
        return $vetor_os;
    }

    function buscarTodosServicosOS()
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `servico_os`");
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $vetor_servicos[] = "";
    $i = 0;
    foreach ($resultado as $restultado_objeto) {
        $Servico = new ServicoOS();
        $Servico->setIdos($restultado_objeto['id_os']);
        $Servico->setIdservico($restultado_objeto['id_servico']);
        $vetor_servicos[$i] = $Servico;
        $i++;
    }
    return $vetor_servicos;
}


function removerServicosOS($id_os,$id_servico)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("DELETE FROM `servico_os` WHERE `id_os` like :id_os and `id_servico` like :id_servico");
    $stmt->bindParam(':id_servico', $id_servico);
    $stmt->bindParam(':id_os', $id_os);
    $stmt->execute();
}



?>