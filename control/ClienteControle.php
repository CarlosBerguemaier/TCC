<?php

include_once '../model/Cliente.php';
include_once '../database/conexao.php';

$conn = new Conexao();
$conn = $conn->conexao();


if (isset($_POST['nome'])) {
    $nome = $_POST['nome'];
}
if (isset($_POST['telefone'])) {
    $telefone = $_POST['telefone'];
}
if (isset($_POST['cpf'])) {
    $cpf = $_POST['cpf'];
}

if (isset($_POST['bt_cadastro_cliente'])) {
    if (!isset($nome) or !isset($telefone) or !isset($cpf) or empty($nome) or empty($telefone) or empty($cpf)) {
        header('Location: ../view/telaCadastroCliente.php?msg=dadosinvalidos');
    } else {
        inserirCliente($nome, $telefone, $cpf);
    }
}

function inserirCliente($nome, $telefone, $cpf)
{

    $cliente = buscarCliente($cpf, "cpf_c");
    if (!empty($cliente[0])) {
        header('Location: ../view/telaCadastroCliente.php?msg=dadosduplicadoscpf');
    }


    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `cliente`(`nome`, `telefone`, `cpf`)
                             VALUES (:nome,:telefone,:cpf)");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $stmt = null;
    header('Location: ../view/telaCadastroCliente.php?msg=sucesso');
}
function buscarClienteCpf($cpf)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE `cpf` like :cpf");
    $stmt->bindParam(':cpf', $cpf);
    $stmt->execute();
    $cliente = new Cliente();
    while ($result = $stmt->fetch()) {
        $cliente->setID($result["id"]);
        $cliente->setNome($result["nome"]);
        $cliente->setCpf($result["cpf"]);
        $cliente->setTelefone($result["telefone"]);
    }
    return $cliente;
}

if (isset($_POST['bt_busca_cliente'])) {
    if (isset($_POST['coluna'])) {
        header('Location: ../view/telaBuscaClientes.php?coluna=' . $_GET['coluna'] . '&valor=todos');
    }
    if (isset($_POST['busca']) or !empty($_POST['busca'])) {
        header('Location: ../view/telaBuscaClientes.php?coluna=' . $_GET['coluna'] . '&valor=' . $_POST['busca']);
    }
}

function buscarClientePorId($id)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE `id` like :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $cliente = new Cliente();
    while ($result = $stmt->fetch()) {
        $cliente->setID($result["id"]);
        $cliente->setNome($result["nome"]);
        $cliente->setCpf($result["cpf"]);
        $cliente->setTelefone($result["telefone"]);
    }
    return $cliente;
}

function getNomeClienteViaID($nome)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE id like :busca");
    $stmt->bindParam(":busca", $nome);
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
        return $Cliente;
    }
}

function buscarCliente($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    if ($coluna == "todos") {
        $stmt = $conn->prepare("SELECT * FROM `cliente`;");
    }
    if ($coluna == "buscar_todos_parametros") {
        $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE nome like :busca or telefone like :busca1 or cpf like :busca2");
        $buscanometelefone = "%" . $valor_busca . "%";
        $stmt->bindParam(":busca", $buscanometelefone);
        $stmt->bindParam(":busca1", $buscanometelefone);
        $stmt->bindParam(":busca2", $valor_busca);
    }
    if ($coluna == "id") {
        $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE id like :busca");
        $stmt->bindParam(":busca", $valor_busca);
    }
    if ($coluna == "nome") {
        $stmt = $conn->prepare("SELECT * FROM `cliente` WHERE nome like :busca");
        $valor_busca = "%" . $valor_busca . "%";
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

function bt_buscar_cliente($busca, $coluna)
{
    if (!isset($busca) or empty($busca) or empty($coluna) or !isset($coluna)) {
        header('Location: ../view/telaBuscaClientes.php?msg=naoencontrado');
    }
    $result = buscarCliente($busca, $coluna);
    return $result;
}



function imprimirResultadosClientes($vetor_clientes)
{
    if (empty($vetor_clientes)) {
        echo "Não há dados para exibir.";
        return;
    }
    $cliente = $vetor_clientes[0];
    if (empty($cliente)) {
        header('Location: ../view/telaBuscaClientes.php?msg=naoencontrado');
    } else {
        echo "<br> <link rel=\"stylesheet\" href=\"../tabelas.css\"><table id=\"tabelabusca\" border='1'>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th class=\"centralizar_coluna\"></th>
                    <th class=\"centralizar_coluna\"></th>
                </tr>
    </thead>
            <tbody>";
        foreach ($vetor_clientes as $cliente) {
            echo "<tr><td>" . $cliente->getNome() . "</td>" .
                "<td>" . $cliente->getCpf() . "</td>" .
                "<td>" . $cliente->getTelefone() . "</td>" . "<td class=\"centralizar_coluna\">
               <a href=\"telaEditar.php?id=" . $cliente->getId() . "&tipo=cliente\"><button class=\"btn btn-primary\"><i class=\"material-icons\">edit</i></button></a></td>
             <td class=\"centralizar_coluna\">   <a href=\"telaExlcuir.php?id=\"\"><button class=\"btn btn-danger\"><i class=\"material-icons\">delete</i></button></a>
            </td> </tr>";
        }
        echo "</tbody> 
        </table>";
    }
}

function imprimirEditarCliente($cliente)
{
    if (empty($cliente)) {
        return null;
    }

    echo " <div class=\"container\">
        <form action=\"../control/ClienteControle.php?id=" . $_GET['id'] . "&tipo=" . $_GET['tipo'] . "\" method=\"post\">
            <div class=\" input-group form-floating mb-3\">
              <input type=\"text\" name=\"nome\" class=\"form-control\" id=\"cliente_cpf_input\" value=\"".$cliente->getNome()."\">
              <label for=\"cliente_cpf_input input-group-text\" class=\"form-label\">Nome</label>   
            </div>
            <div class=\" input-group form-floating mb-3\">
              <input type=\"text\" name=\"cpf_c\" class=\"form-control\" id=\"cliente_cpf_input\" value=\"".$cliente->getCpf()."\">
              <label for=\"cliente_cpf_input input-group-text\" class=\"form-label\">CPF</label>   
        </div>
            <div class=\" input-group form-floating mb-3\">
              <input type=\"text\" name=\"cpf_c\" class=\"form-control\" id=\"cliente_cpf_input\" value=\"".$cliente->getTelefone()."\">
              <label for=\"cliente_cpf_input input-group-text\" class=\"form-label\">Telefone</label>   
                 </div>";

              echo '<div style="text-align:center;">
            <button type="submit" class="btn btn-success" name="bt_editar_cliente">
              <h2>Editar</h2>
            </button>
            </div></form>';
}




if (isset($_POST['bt_editar_cliente'])) {

    if (isset($_POST['nome']) and isset($_POST['cpf_c']) and isset($_POST['telefone']) and !empty($_POST['nome']) and !empty($_POST['cpf_c']) and !empty($_POST['telefone'])) {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf_c'];
        $telefone = $_POST['telefone'];

        $cliente = new Cliente;

        $cliente->setId($_GET['id']);
        $cliente->setNome($_POST['nome']);
        $cliente->setCpf($_POST['cpf_c']);
        $cliente->setTelefone($_POST['telefone']);


        editarCliente($cliente);
    } else {
        header('Location: ../view/telaEditar.php?msg=dadosinvalidos');
    }
}

function editarCliente($cliente)
{
    $id = $cliente->getId();
    $nome = $cliente->getNome();
    $telefone = $cliente->getTelefone();
    $cpf = $cliente->getCpf();
    echo $cpf;
    if ($cpf == "" or empty($cpf)) {
        header('Location: ../view/telaBuscaClientes.php?msg=dadosinvalidos');
    } else {
        $conn = new Conexao();
        $conn = $conn->conexao();
        $stmt = $conn->prepare("UPDATE `cliente`
             SET `nome`= :nome,`cpf`=:cpf,`telefone`= :telefone
             WHERE id like :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':telefone', $telefone);

        $stmt->execute();
        $stmt = null;
        header('Location: ../view/index.php?msg=sucesso');
    }
}

function gerarPdfdosClientes($vetor_clientes)
{
    if (empty($vetor_clientes)) {
        echo "Não há dados para exibir.";
        return;
    }
    $cliente = $vetor_clientes[0];
    if (empty($cliente)) {
        echo "Nenhum dado foi encontrado!";
    } else {
        $data_atual = date("d/m/Y");
        $tabela = "
            <h2> Relatório de Clientes - Oficina do Evandro.</h2> <h2>Data do relatório: $data_atual.</h2>
            <table id=\"tabelabusca\" border='1'>
                    <thead>
                        <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        </tr>
                    </thead>
                    <tbody>";
        foreach ($vetor_clientes as $cliente) {
            $tabela .=  "<tr><td>" . $cliente->getNome() . "</td>" .
                "<td>" . $cliente->getCpf() . "</td>" .
                "<td>" . $cliente->getTelefone() . "</td>"
                . "</tr>";
        }
        $tabela .=  "</tbody> </table>";

        include_once 'gerarPdf.php';
        gerarPdf($tabela);
    }
}

function buscarClienteEntreDatas($valor_busca, $coluna, $data_apos, $data_antes)
{
    $data1 = "";
    $data2 = "";
    $valor_para_buscar = "";

    if ($data_apos == "nao") {
        $data1 == false;
    } else {
        $data1 == true;
    }
    if ($data_antes == "nao") {
        $data2 == false;
    } else {
        $data2 == true;
    }

    $conn = new Conexao();
    $conn = $conn->conexao();

    if ($coluna == "todos") {
        if ($data_apos != "nao" and $data_antes != "nao") {
            $stmt = $conn->prepare("SELECT * 
            FROM cliente
            WHERE data BETWEEN :data_apos AND :data_antes;");
            $stmt->bindParam(':data_apos', $data_apos);
            $stmt->bindParam(':data_antes', $data_antes);
        } else {
            if ($data_apos != "nao" and $data_antes == "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM cliente
                WHERE data >= :data_apos");
                $stmt->bindParam(':data_apos', $data_apos);
            } else {
                if ($data_apos == "nao" and $data_antes != "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM cliente
                    WHERE data <= :data_antes");
                    $stmt->bindParam(':data_antes', $data_antes);
                }
            }
        }
    } else {
        if ($coluna == "id") {
            if ($data_apos == true and $data_antes == true) {
                $stmt = $conn->prepare("SELECT * 
                FROM cliente
                WHERE data BETWEEN :data_apos AND :data_antes AND id like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos == true and $data_antes == false) {
                    $stmt = $conn->prepare("SELECT * 
                    FROM cliente
                    WHERE data >= :data_apos AND id like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == false and $data_antes == true) {
                        $stmt = $conn->prepare("SELECT * 
                        FROM cliente
                        WHERE data <= :data_antes AND id like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $valor_para_buscar = $valor_busca;
        }

        if ($coluna == "cpf") {
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM cliente
                WHERE data BETWEEN :data_apos AND :data_antes AND cpf like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM cliente
                    WHERE data >= :data_apos AND cpf like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
                        $stmt = $conn->prepare("SELECT * 
                        FROM cliente
                        WHERE data <= :data_antes AND cpf like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $stmt->bindParam(':busca', $valor_para_buscar);
        }
        if ($coluna == "telefone") {
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM cliente
                WHERE data BETWEEN :data_apos AND :data_antes AND telefone like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM cliente
                    WHERE data >= :data_apos AND telefone like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
                        $stmt = $conn->prepare("SELECT * 
                        FROM cliente
                        WHERE data <= :data_antes AND telefone like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $stmt->bindParam(':busca', $valor_busca);
        }
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
        $ordemservico->setData($ordem['data']);
        $vetor_servicos[$i] = $ordemservico;
        $i++;
    }

    return $vetor_servicos;
}
