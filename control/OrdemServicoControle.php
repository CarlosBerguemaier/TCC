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

if (isset($_POST['placa'])) {
    $placa = $_POST['placa'];
}
if (isset($_POST['cpf_cliente'])) {
    $cpf_cliente = $_POST['cpf_cliente'];
}
if (isset($_POST['cpf_funcionario'])) {
    $cpf_funcionario = $_POST['cpf_funcionario'];
}
if (isset($_POST['descricao'])) {
    $descricao = $_POST['descricao'];
}
if (isset($_POST['valor'])) {
    $valor = $_POST['valor'];
}
if (isset($_POST['kminicial'])) {
    $kminicial = $_POST['kminicial'];
}
if (isset($_POST['kmfinal'])) {
    $kmfinal = $_POST['kmfinal'];
}

if (isset($_POST['bt_cadastro_ordemservico'])) {
    $cliente = buscarClienteCpf($cpf_cliente);
    $funcionario = buscarFuncionarioCpf($cpf_funcionario);
    $carro = buscarCarroPlaca($placa);

    if ($cliente->getCpf() != null and $funcionario->getCpf() != null and $carro->getPlaca() != null) {
        if (!isset($descricao) or !isset($valor) or !isset($kminicial) or !isset($kmfinal) or empty($descricao) or empty($valor) or empty($kminicial) or empty($kmfinal)) {
            header('Location: ../view/telaCadastro.php?msg=dadosinvalidos');
        } else {
            inserirOrdemServico($carro->getId(), $cliente->getId(), $funcionario->getId(), $valor, $descricao, $kminicial, $kmfinal);
        }
    } else {
        header('Location: ../view/telaCadastro.php?msg=dadosinvalidos');
    }
}

if(isset($_POST['bt_busca_ordemservico'])){
    if($_GET['coluna'] == "todos"){
        header('Location: ../view/telaBuscaOrdemServico.php?coluna='.$_GET['coluna'].'&valor=todos');
    }
if(isset($_POST['busca']) or !empty($_POST['busca'])){
  
header('Location: ../view/telaBuscaOrdemServico.php?coluna='.$_GET['coluna'].'&valor='.$_POST['busca']);
}}

function bt_buscar_os($busca , $coluna){
        if (!isset($busca) or empty($busca) or empty($coluna) or !isset($coluna)) {
            header('Location: ../view/telaBuscaOrdemServico.php?msg=naoencontrado');
        }
        $result = buscarOrdemServico($busca, $coluna);
        return $result;
}


function inserirOrdemServico($id_carro, $id_cliente, $id_funcionario, $valor, $descricao, $kminicial, $kmfinal)
{
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

if(isset($_POST['bt_editar_ordemservico'])){
if(isset($_POST['cpf_cliente']) and isset($_POST['cpf_funcionario']) and isset($_POST['placa'])){
$cpf_c = $_POST['cpf_cliente'];
$cpf_f = $_POST['cpf_funcionario'];
$placa = $_POST['placa'];
    $cliente = buscarClienteCpf($cpf_c);
    $funcionario = buscarFuncionarioCpf($cpf_f);
    $carro = buscarCarroPlaca($placa);

    if($cliente->getId() == 0 or $funcionario->getId() == 0 or $carro->getId() == 0){
        header('Location: ../view/telaEditar.php?id='.$_GET['id'].'&tipo=ordemservico&msg=naoencontrado');
    }
}

if(isset($_POST['descricao']) and isset($_POST['valor']) and isset($_POST['kminicial']) and isset($_POST['kmfinal'])){
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$kminicial = $_POST['kminicial'];
$kmfinal = $_POST['kmfinal'];

$ordem = new OrdemServico;

$ordem->setId($_GET['id']);
$ordem->setId_cliente($cliente->getId());
$ordem->setId_funcionario($funcionario->getId());
$ordem->setId_carro($carro->getId());
$ordem->setDescricao($descricao);
$ordem->setValor($valor);
$ordem->setKminicial($kminicial);
$ordem->setKmfinal($kmfinal);


editarOrdemServico($ordem);
}
}

function editarOrdemServico($ordemservico){
$id = $ordemservico->getId();
$id_carro = $ordemservico->getId_carro();
$id_cliente = $ordemservico->getId_cliente();
$id_funcionario = $ordemservico->getId_funcionario();
$descricao = $ordemservico->getDescricao();
$valor = $ordemservico->getValor();
$kminicial = $ordemservico->getKminicial();
$kmfinal = $ordemservico->getKmfinal();

    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("UPDATE `ordem_servico`
     SET `id_cliente`= :id_cliente,`id_funcionario`=:id_funcionario,`id_carro`= :id_carro,`valor`=:valor,`descricao`=:descricao,`kminicial`=:kminicial,`kmfinal`= :kmfinal
      WHERE id like :id");

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':id_carro', $id_carro);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->bindParam(':id_funcionario', $id_funcionario);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':kminicial', $kminicial);
    $stmt->bindParam(':kmfinal', $kmfinal);

    $stmt->execute();
    $stmt = null;
    header('Location: ../view/index.php?msg=sucesso');
}

function buscarOrdemServico($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    if ($coluna == "todos") {
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico`");
    }else{
    if (!isset($valor_busca) or !isset($coluna) or empty($valor_busca) or empty($coluna)) {
        header('Location: ../view/index.php?msg=naoencontrado');
    }
    if ($coluna == "id") {
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE id like :busca");
        $valor_para_buscar = $valor_busca;
    }
    if ($coluna == "cpf_c") {
        $busca = buscarClienteCpf($valor_busca);
        $valor_para_buscar = $busca->getId();
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE id_cliente like :busca");
    }
    if ($coluna == "cpf_f") {
        $busca = buscarFuncionarioCpf($valor_busca);
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE id_funcionario like :busca");
        $valor_para_buscar = $busca->getId();
    }
    if ($coluna == "placa") {
        $busca = buscarCarroPlaca($valor_busca);
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE id_carro like :busca");
        $valor_para_buscar = $busca->getId();
    }
    if ($coluna == "descricao") {
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE descricao like :busca");
        $valor_para_buscar = "%" . $valor_busca . "%";
    }
    if ($coluna == "valor") {
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE valor like :busca");
        $valor_para_buscar = $valor_busca;
    }
    $stmt->bindParam(':busca', $valor_para_buscar);
}

    $stmt->execute();

    $resultado = $stmt->fetchAll();
    $vetor_servicos[] = "";
    $i = 0;
    foreach ($resultado as $ordem) {
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
function imprimirResultadosOrdemServicos($vetor_servicos){
    if (empty($vetor_servicos)) {
        echo "Não há dados para exibir.";
        return;
    }
    $ordemservico = $vetor_servicos[0];
    if(empty($ordemservico)){
        echo "Nenhum dado foi encontrado!";
    }else{
        
    $tabela = "<table id=\"tabelabusca\" border='1'>
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Cliente</th>
                    <th>Funcionário</th>
                    <th>Serviço</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($vetor_servicos as $ordemservico) {
        $cliente = buscarClientePorId($ordemservico->getId_cliente());
        $funcionario = buscarFuncionarioPorId($ordemservico->getId_funcionario());
        $carro = buscarCarroPorId($ordemservico->getId_carro());
    
        
        $tabela = $tabela . "<tr><td>" . $carro->getPlaca() . "</td>".
         "<td>" . $cliente->getNome() . "</td>" .
         "<td>" . $funcionario->getNome() . "</td>"
        . "<td>" . $ordemservico->getDescricao() . "</td>"
        . "<td>R$ " . number_format($ordemservico->getValor(), 2, ',', '.') . "</td>"
        . "<td>
               <a href=\"telaEditar.php?id=".$ordemservico->getId()."&tipo=ordemservico\">
               <button class=\"btn btn-primary\">Editar</button></a>

               <form method=\"post\" action=\"../view/telaExcluir.php\">

                <input type=\"hidden\" name=\"id_apagar\" value=\" ". $ordemservico->getId() ."\">

                <button class=\"btn btn-danger\" name\"bt_apagar\" id=\"bt_apagar\">Apagar</button>

                </form>
                
            </td>"
        . "</tr>";
    }
    $tabela = $tabela . "</tbody> </table>";

    return $tabela;
    }
}

function gerarPdfdasOS($vetor_servicos){
    if (empty($vetor_servicos)) {
        echo "Não há dados para exibir.";
        return;
    }
    $ordemservico = $vetor_servicos[0];
    if(empty($ordemservico)){
        echo "Nenhum dado foi encontrado!";
    }else{
        $data_atual = date("d/m/Y");
    $tabela = "
    <h2> Relatório de ordem de serviço - Oficina do Evandro.</h2> <h2>Data do relatório: $data_atual.</h2>
    <table id=\"tabelabusca\" border='1'>
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Cliente</th>
                    <th>Funcionário</th>
                    <th>Serviço</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($vetor_servicos as $ordemservico) {
        $cliente = buscarClientePorId($ordemservico->getId_cliente());
        $funcionario = buscarFuncionarioPorId($ordemservico->getId_funcionario());
        $carro = buscarCarroPorId($ordemservico->getId_carro());
    
        
        $tabela = $tabela . "<tr><td>" . $carro->getPlaca() . "</td>".
         "<td>" . $cliente->getNome() . "</td>" .
         "<td>" . $funcionario->getNome() . "</td>"
        . "<td>" . $ordemservico->getDescricao() . "</td>"
        . "<td>R$ " . number_format($ordemservico->getValor(), 2, ',', '.') . "</td>"
        . "</tr>";
    }
    $tabela = $tabela . "</tbody> </table>";

    include_once 'gerarPdf.php';
    gerarPdf($tabela);

    }
}

    function imprimirEditarOrdemServico($ordemservico){
    if(empty($ordemservico)){
    return null;
    }
    $cliente = buscarClientePorId($ordemservico->getId_cliente());
    $funcionario = buscarFuncionarioPorId($ordemservico->getId_funcionario());
    $carro = buscarCarroPorId($ordemservico->getId_carro());
    
    echo " <form action=\"../control/OrdemServicoControle.php?id=". $_GET['id']."&tipo=".$_GET['tipo']."\" method=\"post\">
        Placa do Carro: <input type=\"text\" name=\"placa\" value=\"". $carro->getPlaca() ."\">
        CPF do Cliente: <input type=\"text\" name=\"cpf_cliente\" value=\"". $cliente->getCpf() ."\">
        CPF do Funcionário: <input type=\"text\" name=\"cpf_funcionario\" value=\"". $funcionario->getCpf()."\">
        Descrição: <input type=\"text\" name=\"descricao\" value=\"". $ordemservico->getDescricao()."\">
        Valor: <input type=\"text\" name=\"valor\" value=\"". $ordemservico->getValor()."\">
        Quilometragem Inicial: <input type=\"text\" name=\"kminicial\" value=\"". $ordemservico->getKminicial()."\">
        Quilometragem Final: <input type=\"text\" name=\"kmfinal\" value=\"". $ordemservico->getKmfinal()."\">
        <button class=\"btn btn-success botao-enviar\" type=\"submit\" id=\"bt_editar_ordemservico\" name=\"bt_editar_ordemservico\">Editar</button>
    </form>";
    }

?>
