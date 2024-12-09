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
if (isset($_POST['data'])) {
    $data = $_POST['data'];
} else {
    $data;
}

if (isset($_POST['bt_cadastro_ordemservico'])) {
    $cliente = buscarClienteCpf($cpf_cliente);
    $funcionario = buscarFuncionarioCpf($cpf_funcionario);
    $carro = buscarCarroPlaca($placa);

    if ($cliente->getCpf() != null and $funcionario->getCpf() != null and $carro->getPlaca() != null) {
        if (!isset($descricao) or !isset($valor) or !isset($kminicial) or !isset($kmfinal) or empty($descricao) or empty($valor) or empty($kminicial) or empty($kmfinal)) {
            header('Location: ../view/telaCadastroOrdemServico.php?msg=dadosinvalidos');
        } else {
            inserirOrdemServico($carro->getId(), $cliente->getId(), $funcionario->getId(), $valor, $descricao, $kminicial, $kmfinal, $data);
        }
    } else {
        header('Location: ../view/telaCadastroOrdemServico.php?msg=dadosinvalidos');
    }
}

if (isset($_POST['bt_busca_ordemservico'])) {

    if ($_GET['coluna'] == "todos" and (empty($_POST['data_apos']) or empty($_POST['data_antes']))) {
        $valor = "todos";
       header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor='.$valor);
    }
    if( isset($_POST['busca'])){
        $valor = $_POST['busca'];
    }
  
    if(!empty($_POST['data_apos']) or !empty($_POST['data_antes'])){
        if (!empty($_POST['data_apos']) and !empty($_POST['data_antes'])) {
            header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor='.$valor. '&data_apos=' . $_POST['data_apos'] . '&data_antes=' . $_POST['data_antes']);
        } else{
        if (!empty($_POST['data_apos']) and empty($_POST['data_antes'])) {
            header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor='.$valor. '&data_apos=' . $_POST['data_apos']);
        }
        if (!empty($_POST['data_antes']) and empty($_POST['data_apos'])) {
           header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor='.$valor . '&data_antes=' . $_POST['data_antes']);
        }
    }}else{
    if (isset($_POST['busca']) or !empty($_POST['busca'])) {
      header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor='.$valor);
    }}
}
    

function bt_buscar_os($busca, $coluna)
{
    if (!isset($busca) or empty($busca) or empty($coluna) or !isset($coluna)) {
        header('Location: ../view/telaBuscaOrdemServico.php?msg=naoencontrado');
    }
    $result = buscarOrdemServico($busca, $coluna);
    return $result;
}


function inserirOrdemServico($id_carro, $id_cliente, $id_funcionario, $valor, $descricao, $kminicial, $kmfinal, $data)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `ordem_servico`(`id_cliente`, `id_funcionario`, `id_carro`, `valor`, `descricao`, `kminicial`, `kmfinal`, `data`)
     VALUES (:id_cliente,:id_funcionario,:id_carro,:valor,:descricao, :kminicial, :kmfinal, :dataa)");
    $stmt->bindParam(':id_carro', $id_carro);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->bindParam(':id_funcionario', $id_funcionario);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':kminicial', $kminicial);
    $stmt->bindParam(':kmfinal', $kmfinal);
    $stmt->bindParam(':dataa', $data);
    $stmt->execute();
    $stmt = null;
    header('Location: ../view/telaCadastroOrdemServico.php?msg=sucesso');
}

if (isset($_POST['bt_editar_ordemservico'])) {
    if (isset($_POST['cpf_cliente']) and isset($_POST['cpf_funcionario']) and isset($_POST['placa'])) {
        $cpf_c = $_POST['cpf_cliente'];
        $cpf_f = $_POST['cpf_funcionario'];
        $placa = $_POST['placa'];
        $cliente = buscarClienteCpf($cpf_c);
        $funcionario = buscarFuncionarioCpf($cpf_f);
        $carro = buscarCarroPlaca($placa);

        if ($cliente->getId() == 0 or $funcionario->getId() == 0 or $carro->getId() == 0) {
            header('Location: ../view/telaEditar.php?id=' . $_GET['id'] . '&tipo=ordemservico&msg=naoencontrado');
        }
    }

    if (isset($_POST['descricao']) and isset($_POST['valor']) and isset($_POST['kminicial']) and isset($_POST['kmfinal'])) {
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        $kminicial = $_POST['kminicial'];
        $kmfinal = $_POST['kmfinal'];

        $ordem = new OrdemServico;

        if (isset($_POST['data'])) {
            $data = $_POST['data'];
            $ordem->setData($data);
        }

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

function imprimirOS_telainicial()
{
    $os = buscarOrdemServico("", "todos-inicial");
    $tabela = imprimirResultadosOrdemServicosTelaInicial($os);
    echo $tabela;
}

function editarOrdemServico($ordemservico)
{
    $id = $ordemservico->getId();
    $id_carro = $ordemservico->getId_carro();
    $id_cliente = $ordemservico->getId_cliente();
    $id_funcionario = $ordemservico->getId_funcionario();
    $descricao = $ordemservico->getDescricao();
    $valor = $ordemservico->getValor();
    $kminicial = $ordemservico->getKminicial();
    $kmfinal = $ordemservico->getKmfinal();
    $data = $ordemservico->getData();

    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("UPDATE `ordem_servico`
     SET `id_cliente`= :id_cliente,`id_funcionario`=:id_funcionario,`id_carro`= :id_carro,`valor`=:valor,`descricao`=:descricao,`kminicial`=:kminicial,`kmfinal`= :kmfinal,`data`= :dataa
      WHERE id like :id "
    );

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':id_carro', $id_carro);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->bindParam(':id_funcionario', $id_funcionario);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':kminicial', $kminicial);
    $stmt->bindParam(':kmfinal', $kmfinal);
    $stmt->bindParam(':dataa', $data);

    $stmt->execute();
    $stmt = null;
    header('Location: ../view/index.php?msg=sucesso');
}

function buscarOrdemServico($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    if ($coluna == "todos-inicial" or $coluna == "todos") {
        if ($coluna == "todos") {
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico`");
        } 
        if ($coluna == "todos-inicial") {
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico` ORDER BY data DESC LIMIT 6");
        } 
       } else {
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
        if ($coluna == "data") {
            $valor_para_buscar = $busca;
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE datga like :busca");
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
        $ordemservico->setData($ordem['data']);
        $vetor_servicos[$i] = $ordemservico;
        $i++;
    }
    return $vetor_servicos;
}

function buscarOrdemServicoEntreDatas($valor_busca, $coluna, $data_apos, $data_antes)
{
    $data1 = "";
    $data2 = "";
    $valor_para_buscar ="";

    if($data_apos == "nao") {$data1 == false;}else{$data1 == true;}
    if($data_antes == "nao") { $data2 == false;}else{$data2 == true;}

    $conn = new Conexao();
    $conn = $conn->conexao();
   
     if($coluna == "todos"){
        if($data_apos != "nao" and $data_antes != "nao"){
            $stmt = $conn->prepare("SELECT * 
            FROM ordem_servico
            WHERE data BETWEEN :data_apos AND :data_antes;");
            $stmt->bindParam(':data_apos', $data_apos);
            $stmt->bindParam(':data_antes', $data_antes);
        }else{
            if($data_apos != "nao" and $data_antes == "nao"){
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data >= :data_apos");
                $stmt->bindParam(':data_apos', $data_apos);
            }else{
                if($data_apos == "nao" and $data_antes != "nao"){
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data <= :data_antes");
                    $stmt->bindParam(':data_antes', $data_antes);
                }
            }
        }
        }
        else{
        if ($coluna == "id") {
            if($data_apos == true and $data_antes == true){
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND id like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            }else{
                if($data_apos == true and $data_antes == false){
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND id like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                }else{
                    if($data_apos == false and $data_antes == true){
                        $stmt = $conn->prepare("SELECT * 
                        FROM ordem_servico
                        WHERE data <= :data_antes AND id like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $stmt->bindParam(':busca', $valor_busca);
        }

        if ($coluna == "cpf_c") {
            $busca = buscarClienteCpf($valor_busca);
            if($data_apos != "nao" and $data_antes != "nao"){
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND id_cliente like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
               
            }else{
                if($data_apos != "nao" and $data_antes == "nao"){
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND id_cliente like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                }else{
                    if($data_apos == "nao" and $data_antes != "nao"){
                        $stmt = $conn->prepare("SELECT * 
                        FROM ordem_servico
                        WHERE data <= :data_antes AND id_cliente like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $valor_para_buscar = $busca->getId();
            $stmt->bindParam(':busca', $valor_para_buscar);
        }
        if ($coluna == "cpf_f") {
            $busca = buscarFuncionarioCpf($valor_busca);
            if($data_apos != "nao" and $data_antes != "nao"){
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND id_funcionario like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            }else{
                if($data_apos != "nao" and $data_antes == "nao"){
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND id_funcionario like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                }else{
                    if($data_apos == "nao" and $data_antes != "nao"){
                        $stmt = $conn->prepare("SELECT * 
                        FROM ordem_servico
                        WHERE data <= :data_antes AND id_funcionario like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $valor_para_buscar = $busca->getId();
            $stmt->bindParam(':busca',$valor_para_buscar);
        }
        if ($coluna == "placa") {
            $busca = buscarCarroPlaca($valor_busca);
            if($data_apos != "nao" and $data_antes != "nao"){
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND id_carro like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            }else{
                if($data_apos != "nao" and $data_antes == "nao"){
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND id_carro like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                }else{
                    if($data_apos == "nao" and $data_antes != "nao"){
                        $stmt = $conn->prepare("SELECT * 
                        FROM ordem_servico
                        WHERE data <= :data_antes AND id_carro like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $valor_para_buscar = $busca->getId();
            $stmt->bindParam(':busca', $valor_para_buscar);
        }
        if ($coluna == "descricao") {
            if($data_apos != "nao" and $data_antes != "nao"){
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND descricao like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            }else{
                if($data_apos != "nao" and $data_antes == "nao"){
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND descricao like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                }else{
                    if($data_apos == "nao" and $data_antes != "nao"){
                        $stmt = $conn->prepare("SELECT * 
                        FROM ordem_servico
                        WHERE data <= :data_antes AND descricao like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $valor_para_buscar = "%" . $valor_busca . "%";
            $stmt->bindParam(':busca', $valor_para_buscar);
        }
        if ($coluna == "valor") {
            if($data_apos != "nao" and $data_antes != "nao"){
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND valor like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            }else{
                if($data_apos != "nao" and $data_antes == "nao"){
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND valor like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                }else{
                    if($data_apos == "nao" and $data_antes != "nao"){
                        $stmt = $conn->prepare("SELECT * 
                        FROM ordem_servico
                        WHERE data <= :data_antes AND valor like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $valor_para_buscar = $valor_busca;
            $stmt->bindParam(':busca', $valor_para_buscar);
           
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
function imprimirResultadosOrdemServicosTelaInicial($vetor_servicos)
{
    if (empty($vetor_servicos)) {
        echo "Não há dados para exibir.";
        return;
    }
    $ordemservico = $vetor_servicos[0];
    if (empty($ordemservico)) {
        header('Location: ../view/telaBuscaOrdemServico.php?msg=naoencontrado');
    } else {

        $tabela = "  <link rel=\"stylesheet\" href=\"../tabelas.css\">
    <table class=\"table_inicio\" border=\"1\">
            <thead>
                <tr>
                    <th>Carro</th>
                    <th>Cliente</th>
                    <th>Funcionário</th>
                    <th class=\"nao_quebrar_linha\">Data</th>
                    <th>Valor</th>
                    <th class=\"centralizar_coluna\"></th>
                </tr>
            </thead>
            <tbody>";
        foreach ($vetor_servicos as $ordemservico) {
            $cliente = buscarClientePorId($ordemservico->getId_cliente());
            $funcionario = buscarFuncionarioPorId($ordemservico->getId_funcionario());
            $carro = buscarCarroPorId($ordemservico->getId_carro());

            $txt_carro = $carro->getMarca() . " " . $carro->getModelo();


            $tabela = $tabela . "<tr><td>" . $txt_carro . "</td>"
                . "<td>" . $cliente->getNome() . "</td>"
                . "<td>" . $funcionario->getNome() . "</td>"
                . "<td>" . $ordemservico->getData() . "</td>"
                . "<td>R$ " . number_format($ordemservico->getValor(), 2, ',', '.') . "</td>"
                . "<td>
               <a href=\"telaEditar.php?id=" . $ordemservico->getId() . "&tipo=ordemservico\">
               <button class=\"btn btn-primary\"><i class=\"material-icons\">visibility</i></button></a></td>
                </form>
                
            </td>"
                . "</tr>";
        }
        $tabela = $tabela . "</tbody> </table>";

        return $tabela;
    }
}

function imprimirResultadosOrdemServicos($vetor_servicos)
{
    if (empty($vetor_servicos)) {
        echo "Não há dados para exibir.";
        return;
    }
    $ordemservico = $vetor_servicos[0];
    if (empty($ordemservico)) {
       # header('Location: ../view/telaBuscaOrdemServico.php?msg=naoencontrado');
    } else {

        $tabela = "  <link rel=\"stylesheet\" href=\"../tabelas.css\">
    <table id=\"tabelabusca\" border=\"1\" >
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Cliente</th>
                    <th>Funcionário</th>
                    <th>Serviço</th>
                    <th class=\"nao_quebrar_linha\">Data</th>
                    <th>Valor</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>";
        foreach ($vetor_servicos as $ordemservico) {
            $cliente = buscarClientePorId($ordemservico->getId_cliente());
            $funcionario = buscarFuncionarioPorId($ordemservico->getId_funcionario());
            $carro = buscarCarroPorId($ordemservico->getId_carro());


            $tabela = $tabela . "<tr><td>" . $carro->getPlaca() . "</td>" .
                "<td>" . $cliente->getNome() . "</td>" .
                "<td>" . $funcionario->getNome() . "</td>"
                . "<td>" . $ordemservico->getDescricao() . "</td>"
                . "<td>" . $ordemservico->getData() . "</td>"
                . "<td>R$ " . number_format($ordemservico->getValor(), 2, ',', '.') . "</td>"
                . "<td>
               <a href=\"telaEditar.php?id=" . $ordemservico->getId() . "&tipo=ordemservico\">
               <button class=\"btn btn-primary\"><i class=\"material-icons\">edit</i></button></a></td>

               <td><form method=\"post\" action=\"../view/telaExcluir.php\">

                <input type=\"hidden\" name=\"id_apagar\" value=\" " . $ordemservico->getId() . "\">

                <button class=\"btn btn-danger\" name\"bt_apagar\" id=\"bt_apagar\"><i class=\"material-icons\">delete</i></button>

                </form>
                
            </td>"
                . "</tr>";
        }
        $tabela = $tabela . "</tbody> </table>";

        return $tabela;
    }
}

function gerarPdfdasOS($vetor_servicos)
{
    if (empty($vetor_servicos)) {
        echo "Não há dados para exibir.";
        return;
    }
    $ordemservico = $vetor_servicos[0];
    if (empty($ordemservico)) {
        echo "Nenhum dado foi encontrado!";
    } else {
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
                    <th>Data</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($vetor_servicos as $ordemservico) {
            $cliente = buscarClientePorId($ordemservico->getId_cliente());
            $funcionario = buscarFuncionarioPorId($ordemservico->getId_funcionario());
            $carro = buscarCarroPorId($ordemservico->getId_carro());


            $tabela = $tabela . "<tr><td>" . $carro->getPlaca() . "</td>" .
                "<td>" . $cliente->getNome() . "</td>" .
                "<td>" . $funcionario->getNome() . "</td>"
                . "<td>" . $ordemservico->getDescricao() . "</td>"
                . "<td>" . $ordemservico->getData() . "</td>"
                . "<td>R$ " . number_format($ordemservico->getValor(), 2, ',', '.') . "</td>"
                . "</tr>";
        }
        $tabela = $tabela . "</tbody> </table>";

        include_once 'gerarPdf.php';
        gerarPdf($tabela);
    }
}
function imprimirEditarOrdemServico($ordemservico)
{
    if (empty($ordemservico)) {
        return null;
    }
    $cliente = buscarClientePorId($ordemservico->getId_cliente());
    $funcionario = buscarFuncionarioPorId($ordemservico->getId_funcionario());
    $carro = buscarCarroPorId($ordemservico->getId_carro());

    echo '<div class="container">
        <form action="../control/OrdemServicoControle.php?id=' . $_GET['id'] . '&tipo=' . $_GET['tipo'] . '" method="post">
            <div class="form-floating mb-3 ">
              <input type="text" name="placa" class="form-control" id="exampleFormControlInput1" value="' . $carro->getPlaca() . '" placeholder="ABC1D23">
              <label for="exampleFormControlInput1" class="form-label">Placa do veículo</label>
            </div>

            <div class=" input-group form-floating mb-3">
              <input type="text" name="cpf_cliente" class="form-control" id="cliente_cpf_input" value="' . $cliente->getCpf() . '">
              <label for="cliente_cpf_input input-group-text" class="form-label">CPF do cliente</label>

              <span class="input-group-text">ou</span>

              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCliente">
                <i class="material-icons">search</i></button>
            </div>

            <div class=" input-group form-floating mb-3">
              <input type="text" name="cpf_funcionario" class="form-control" id="funcionario_cpf_input" value="' . $funcionario->getCpf() . '">
              <label for="funcionario_cpf_input" class="form-label">CPF do funcionário</label>

              <span class="input-group-text">ou</span>

              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFuncionario">
                <i class="material-icons">search</i></button>
            </div>

            <div class="form mb-3">
              <textarea class="form-control" name="descricao" id="exampleFormControlTextarea1" rows="5" value="' . $ordemservico->getDescricao() . '" style="height: 150px;" >' . $ordemservico->getDescricao() . '</textarea>

            </div>

            <div class="form-floating mb-3">
              <input type="text" name="valor" class="form-control" id="exampleFormControlInput1" value="' . $ordemservico->getValor() . '">
              <label for="exampleFormControlInput1" class="form-label">Valor</label>
            </div>

            <div class="form-item mb-3">
              <input type="date" name="data" class="form-control" id="" value="' . $ordemservico->getData() . '">
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="kminicial" class="form-control" id="exampleFormControlInput1" value="' . $ordemservico->getKminicial() . '">
              <label for="exampleFormControlInput1" class="form-label">Quilometragem Inicial</label>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="kmfinal" class="form-control" id="exampleFormControlInput1" value="' . $ordemservico->getKmfinal() . '">
              <label for="exampleFormControlInput1" class="form-label">Quilometragem Final</label>
            </div>

            
            <div style="text-align:center;">
            <button type="submit" class="btn btn-success" name="bt_editar_ordemservico">
              <h2>Editar</h2>
            </button>
            </div>
          </form>
        </div>';
}
