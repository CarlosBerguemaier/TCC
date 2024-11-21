<?php

include_once '../model/Cliente.php';
include_once '../database/conexao.php';

$conn = new Conexao();
$conn = $conn->conexao();


if(isset($_POST['nome'])){$nome = $_POST['nome'];}
if(isset($_POST['telefone'])){$telefone = $_POST['telefone'];}
if(isset($_POST['cpf'])){$cpf = $_POST['cpf'];}

if(isset($_POST['bt_cadastro_cliente'])){
    if(!isset($nome) or !isset($telefone) or !isset($cpf) or empty($nome) or empty($telefone) or empty($cpf)){
        header('Location: ../view/telaCadastro.php?msg=dadosinvalidos');
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
function buscarClienteCpf($cpf){
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

if(isset($_POST['bt_busca_cliente'])){
    if(isset($_POST['busca']) or !empty($_POST['busca'])){
    header('Location: ../view/telaBuscaClientes.php?coluna='.$_GET['coluna'].'&valor='.$_POST['busca']);
    }}

function buscarClientePorId($id){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE `id` like :id");
    $stmt->bindParam(':id', $id);
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

function buscarCliente($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();

    if ($coluna == "nome") {
        $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE nome like :busca");
        $valor_busca = "%".$valor_busca."%";
        $stmt->bindParam(":busca", $valor_busca);
    }
    if ($coluna == "cpf_c") {
        $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE cpf like :busca");
        $stmt->bindParam(":busca", $valor_busca);
    }
    if ($coluna == "telefone") {
        $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE telefone like :busca");
        $stmt->bindParam(":busca", $valor_busca);
    }


    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $vetor_clientes[] = "";
    $i = 0;
    foreach ($resultado as $restultado_objeto) {
        $Cliente = new Cliente();
        $Cliente->setID($restultado_objeto['id']);
        $Cliente->setNome($restultado_objeto['nome']);
        $Cliente->setCpf($restultado_objeto['cpf']);
        $Cliente->setTelefone($restultado_objeto['telefone']);
        $vetor_clientes[$i] = $Cliente;
        $i++;
    }
    return $vetor_clientes;
}

function bt_buscar_cliente($busca,$coluna){
    if (!isset($busca) or empty($busca) or empty($coluna) or !isset($coluna)) {
        header('Location: ../view/telaBuscaClientes.php?msg=naoencontrado');
    }
    $result = buscarCliente($busca, $coluna);
    return $result;
}



function imprimirResultadosClientes($vetor_clientes){
    if (empty($vetor_clientes)) {
        echo "Não há dados para exibir.";
        return;
    }
    $cliente = $vetor_clientes[0];
    if(empty($cliente)){
        echo "Nenhum dado foi encontrado!";
    }else{
    echo "<table id=\"tabelabusca\" border='1'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($vetor_clientes as $cliente) {
        echo "<tr><td>" . $cliente->getNome() . "</td>".
         "<td>" . $cliente->getCpf() . "</td>" .
         "<td>" . $cliente->getTelefone() . "</td>"
        . "<td>
               <a href=\"telaEditar.php?id=".$cliente->getId()."&tipo=cliente\"><button class=\"btn btn-primary\">Editar</button></a>
                <a href=\"telaExlcuir.php?id=\"\"><button class=\"btn btn-danger\">Apagar</button></a>
            </td>"
        . "</tr>";
    }
    echo "</tbody> .
        </table>";
    }
}
?>