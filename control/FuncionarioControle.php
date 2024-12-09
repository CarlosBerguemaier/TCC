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
        header('Location: ../view/telaCadastroFuncionario.php?msg=dadosinvalidos');
    }else{
        inserirFuncionario($nome, $telefone, $cpf);
    }
}

function inserirFuncionario($nome,$telefone,$cpf){
  
    $funcionario = buscarFuncionario($cpf,"cpf_f");
    if(!empty($funcionario[0])){
        header('Location: ../view/telaCadastroFuncionario.php?msg=dadosduplicadoscpf');
    }

    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `funcionario`(`nome`, `telefone`, `cpf`)
                             VALUES (:nome,:telefone,:cpf)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $stmt = null;    
    header('Location: ../view/telaCadastroFuncionario.php?msg=sucesso'); 
}

function buscarFuncionarioCpf($cpf){
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

if(isset($_POST['bt_busca_funcionario'])){
    if(isset($_POST['busca']) or !empty($_POST['busca'])){
    header('Location: ../view/telaBuscaFuncionarios.php?coluna='.$_GET['coluna'].'&valor='.$_POST['busca']);
    }}


function buscarFuncionario($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();

    if ($coluna == "todos") {
        $stmt = $conn->prepare("SELECT * FROM `funcionario`");
    }
    if ($coluna == "id") {
        $stmt = $conn->prepare("SELECT * FROM `funcionario` WHERE id like :busca");
        $stmt->bindParam(":busca", $valor_busca);
    }
    if ($coluna == "nome") {
        $stmt = $conn->prepare("SELECT * FROM `funcionario` WHERE nome like :busca");
        $valor_busca = "%".$valor_busca."%";
        $stmt->bindParam(":busca", $valor_busca);
    }
    if ($coluna == "cpf_f") {
        $stmt = $conn->prepare("SELECT * FROM `funcionario` WHERE cpf like :busca");
        $stmt->bindParam(":busca", $valor_busca);
    }
    if ($coluna == "telefone") {
        $stmt = $conn->prepare("SELECT * FROM `funcionario` WHERE telefone like :busca");
        $stmt->bindParam(":busca", $valor_busca);
    }


    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $vetor_funcionarios[] = "";
    $i = 0;
    foreach ($resultado as $restultado_objeto) {
        $Funcionario = new Funcionario();
        $Funcionario->setID($restultado_objeto['id']);
        $Funcionario->setNome($restultado_objeto['nome']);
        $Funcionario->setCpf($restultado_objeto['cpf']);
        $Funcionario->setTelefone($restultado_objeto['telefone']);
        $vetor_funcionarios[$i] = $Funcionario;
        $i++;
    }
    return $vetor_funcionarios;
}

function bt_buscar_funcionarios($busca,$coluna){
    if (!isset($busca) or empty($busca) or empty($coluna) or !isset($coluna)) {
        header('Location: ../view/telaBuscaFuncionarios.php?msg=naoencontrado');
    }
    $result = buscarFuncionario($busca, $coluna);
    return $result;
}



function imprimirResultadosFuncionarios($vetor_funcionarios){
    if (empty($vetor_funcionarios)) {
        echo "Não há dados para exibir.";
        return;
    }
    $funcionario = $vetor_funcionarios[0];
    if(empty($funcionario)){
        echo "Nenhum dado foi encontrado!";
    }else{
    $resultado = " <link rel=\"stylesheet\" href=\"../tabelas.css\">
    <table id=\"tabelabusca\" border='1'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>";
    foreach ($vetor_funcionarios as $funcionario) {
        $resultado .= "<tr><td>" . $funcionario->getNome() . "</td>".
         "<td>" . $funcionario->getCpf() . "</td>" .
         "<td>" . $funcionario->getTelefone() . "</td>"
        . "<td class=\"centralizar_coluna\">
               <a href=\"telaEditar.php?id=" . $funcionario->getId() . "&tipo=funcionario\">
               <button class=\"btn btn-primary\"><i class=\"material-icons\">edit</i></button></a></td>

               <td class=\"centralizar_coluna\"><form method=\"post\" action=\"../view/telaExcluir.php\">

                <input type=\"hidden\" name=\"id_apagar\" value=\" " . $funcionario->getId() . "\">

                <button class=\"btn btn-danger\" name\"bt_apagar\" id=\"bt_apagar\"><i class=\"material-icons\">delete</i></button>

                </form>
                
            </td>"
                . "</tr>";
    }
    $resultado .= "</tbody> 
        </table>";

        return $resultado;
    }
}


function imprimirEditarFuncionario($funcionario){
    if(empty($funcionario)){
    return null;
    }

    echo " <form action=\"../control/FuncionarioControle.php?id=". $_GET['id']."&tipo=".$_GET['tipo']."\" method=\"post\">
        Nome: <input type=\"text\" name=\"nome\" value=\"". $funcionario->getNome() ."\">
        CPF: <input type=\"text\" name=\"cpf_f\" value=\"". $funcionario->getCpf() ."\">
        Telefone <input type=\"text\" name=\"telefone\" value=\"". $funcionario->getTelefone()."\">
       
        <button class=\"btn btn-success botao-enviar\" type=\"submit\" id=\"bt_editar_funcionario\" name=\"bt_editar_funcionario\">Editar</button>
    </form>";
    }




if(isset($_POST['bt_editar_funcionario'])){

if(isset($_POST['nome']) and isset($_POST['cpf_f']) and isset($_POST['telefone'])){
$nome = $_POST['nome'];
$cpf = $_POST['cpf_f'];
$telefone = $_POST['telefone'];

$funcionario = new Funcionario;

$funcionario->setId($_GET['id']);
$funcionario->setNome($_POST['nome']);
$funcionario->setCpf($_POST['cpf_f']);
$funcionario->setTelefone($_POST['telefone']);


editarFuncionario($funcionario);
}
}

function editarFuncionario($funcionario){
    $id = $funcionario->getId();
    $nome = $funcionario->getNome();
    $telefone = $funcionario->getTelefone();
    $cpf = $funcionario->getCpf();

    
        $conn = new Conexao();
        $conn = $conn->conexao();
        $stmt = $conn->prepare("UPDATE `funcionario`
         SET `nome`= :nome,`cpf`=:cpf,`telefone`= :telefone WHERE id like :id");
    
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);

    
        $stmt->execute();
        $stmt = null;
        header('Location: ../view/index.php?msg=sucesso');
    }
    function gerarPdfdosFuncionarios($vetor_funcionarios){
        if (empty($vetor_funcionarios)) {
            echo "Não há dados para exibir.";
            return;
        }
        $funcionario = $vetor_funcionarios[0];
        if(empty($funcionario)){
            echo "Nenhum dado foi encontrado!";
        }else{
            $data_atual = date("d/m/Y");
        $tabela = "
        <h2> Relatório de funcionários - Oficina do Evandro.</h2> <h2>Data do relatório: $data_atual.</h2>
        <table id=\"tabelabusca\" border='1'>
                <thead>
                    <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    </tr>
                </thead>
                <tbody>";
                foreach ($vetor_funcionarios as $funcionario) {
                    $tabela .=  "<tr><td>" . $funcionario->getNome() . "</td>".
                     "<td>" . $funcionario->getCpf() . "</td>" .
                     "<td>" . $funcionario->getTelefone() . "</td>"
                    . "</tr>";
                }
        $tabela .=  "</tbody> </table>";
    
        include_once 'gerarPdf.php';
        gerarPdf($tabela);
    
        }
    }
?>