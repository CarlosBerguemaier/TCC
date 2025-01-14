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
    $servicos = buscarTodosServicos();
    $tamanho = buscarNumeroDeServicos();
    $vetor_servicos = [];
    for ($i = 0; $i <= $tamanho; $i++) {
        if (isset($_POST['servico_id' . $i])) {
            array_push($vetor_servicos, $i);
        }
    }


    if ($cliente->getCpf() != null and $funcionario->getCpf() != null and $carro->getPlaca() != null) {
        if (!isset($descricao) or !isset($valor) or !isset($kminicial) or !isset($kmfinal) or empty($descricao) or empty($valor) or empty($kminicial) or empty($kmfinal)) {
            header('Location: ../view/telaCadastroOrdemServico.php?msg=dadosinvalidos');
        } else {
            if (isset($_POST['pgto'])) {
                $pgto = true;
            } else {
                $pgto = false;
            }

            inserirOrdemServico($carro->getId(), $cliente->getId(), $funcionario->getId(), $valor, $descricao, $kminicial, $kmfinal, $data, $vetor_servicos, $pgto);
        }
    } else {
        header('Location: ../view/telaCadastroOrdemServico.php?msg=dadosinvalidos');
    }
}

if (isset($_POST['bt_busca_ordemservico'])) {

    if (($_GET['coluna'] == "todos" or $_GET['coluna'] == "pgto") and (empty($_POST['data_apos']) or empty($_POST['data_antes']))) {
        $valor = $_GET['coluna'];
        header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor=' . $valor);
    }
    if (isset($_POST['busca'])) {
        $valor = $_POST['busca'];
    }

    if (!empty($_POST['data_apos']) or !empty($_POST['data_antes'])) {
        if (!empty($_POST['data_apos']) and !empty($_POST['data_antes'])) {
            header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor=' . $valor . '&data_apos=' . $_POST['data_apos'] . '&data_antes=' . $_POST['data_antes']);
        } else {
            if (!empty($_POST['data_apos']) and empty($_POST['data_antes'])) {
                header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor=' . $valor . '&data_apos=' . $_POST['data_apos']);
            }
            if (!empty($_POST['data_antes']) and empty($_POST['data_apos'])) {
                header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor=' . $valor . '&data_antes=' . $_POST['data_antes']);
            }
        }
    } else {
        if (isset($_POST['busca']) or !empty($_POST['busca'])) {
            header('Location: ../view/telaBuscaOrdemServico.php?coluna=' . $_GET['coluna'] . '&valor=' . $valor);
        }
    }
}


function bt_buscar_os($busca, $coluna)
{
    if (!isset($busca) or empty($busca) or empty($coluna) or !isset($coluna)) {
        header('Location: ../view/telaBuscaOrdemServico.php?msg=naoencontrado');
    }
    $result = buscarOrdemServico($busca, $coluna);
    return $result;
}


function inserirOrdemServico($id_carro, $id_cliente, $id_funcionario, $valor, $descricao, $kminicial, $kmfinal, $data, $servicos, $pgto)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `ordem_servico`(`id_cliente`, `id_funcionario`, `id_carro`, `valor`, `descricao`, `kminicial`, `kmfinal`, `data`, `pagamento`)
     VALUES (:id_cliente,:id_funcionario,:id_carro,:valor,:descricao, :kminicial, :kmfinal, :dataa, :pgto)");
    $stmt->bindParam(':id_carro', $id_carro);
    $stmt->bindParam(':id_cliente', $id_cliente);
    $stmt->bindParam(':id_funcionario', $id_funcionario);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':kminicial', $kminicial);
    $stmt->bindParam(':kmfinal', $kmfinal);
    $stmt->bindParam(':dataa', $data);
    $stmt->bindParam(':pgto', $pgto);
    $stmt->execute();
    $stmt = null;

    $stmt = $conn->prepare("SELECT * FROM `ordem_servico` ORDER BY id DESC LIMIT 1");
    $stmt->execute();

    $resultado = $stmt->fetchAll();
    $i = 0;
    $ordemservico = new OrdemServico();
    foreach ($resultado as $ordem) {
        $ordemservico->setId($ordem['id']);
        $ordemservico->setId_carro($ordem['id_carro']);
        $ordemservico->setId_cliente($ordem['id_cliente']);
        $ordemservico->setId_funcionario($ordem['id_funcionario']);
        $ordemservico->setValor($ordem['valor']);
        $ordemservico->setDescricao($ordem['descricao']);
        $ordemservico->setKminicial($ordem['kminicial']);
        $ordemservico->setKmfinal($ordem['kmfinal']);
        $ordemservico->setData($ordem['data']);
        $ordemservico->setPagamento($ordem['pgto']);
        $i++;
    }
    foreach ($servicos as $servico) {
        inserirServico_OS($servico, $ordemservico->getId());
    }


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

        $servicos = buscarTodosServicos();
        $i = 1;

        $vetor_servicos = [];
        foreach ($servicos as $servico) {
            if (isset($_POST['servico_id' . $servico->getId()])) {
                array_push($vetor_servicos, $servico);
            }
        }

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

        if (isset($_POST['pgto'])) {
            $ordem->setPagamento(true);
        }

        $ordem->setId($_GET['id']);
        $ordem->setId_cliente($cliente->getId());
        $ordem->setId_funcionario($funcionario->getId());
        $ordem->setId_carro($carro->getId());
        $ordem->setDescricao($descricao);
        $ordem->setValor($valor);
        $ordem->setKminicial($kminicial);
        $ordem->setKmfinal($kmfinal);
        $ordem->setServicos($vetor_servicos);


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
    $pgto = $ordemservico->isPago();
    $servicos = $ordemservico->getServicos();



    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare(
        "UPDATE `ordem_servico`
     SET `id_cliente`= :id_cliente,`id_funcionario`=:id_funcionario,`id_carro`= :id_carro,`valor`=:valor,`descricao`=:descricao,`kminicial`=:kminicial,`kmfinal`= :kmfinal, `pagamento`= :pgto,`data`= :dataa
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
    $stmt->bindParam(':pgto', $pgto);

    $todoservicos = buscarTodosServicos();
    foreach ($todoservicos as $servico_generico) {
        if (!in_array($servico_generico, $servicos)) {
            removerServicosOS($id, $servico_generico->getId());
        }
    }

    foreach ($servicos as $servico) {
        if (!verificarServico_os($servico->getId(), $id)) {
            inserirServico_OS($servico->getId(), $id);
        }
    }


    $stmt->execute();
    $stmt = null;
    header('Location: ../view/index.php?msg=sucesso');
}

function buscarPorTodosParametros($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    if ($coluna == "buscar_todos_parametros") {
        $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE descricao like :busca_desc or valor like :busca_val or id_funcionario like :busca_fun");
        $buscadesc =  "%" . $valor_busca . "%";
        $stmt->bindParam(":busca_desc", $buscadesc);
        $stmt->bindParam(":busca_val", $valor_busca);

        $funcionario = buscarFuncionario($valor_busca, "nome");
        if (!empty($funcionario[0])) {
            $id = $funcionario[0]->getId();
            $stmt->bindParam(":busca_fun", $id);
        } else {
            $i = 0;
            $stmt->bindParam(":busca_fun", $i);
        }
    }

    $stmt->execute();

    $resultado = $stmt->fetchAll();
    $vetor_servicos[] = "";
    $i = 0;
    foreach ($resultado as $ordem) {
        $ordemservico = new OrdemServico();
        $ordemservico->setId($ordem['id']);
        $ordemservico->setId_carro($ordem['id_carro']);
        $ordemservico->setId_cliente($ordem['id_cliente']);
        $ordemservico->setId_funcionario($ordem['id_funcionario']);
        $ordemservico->setValor($ordem['valor']);
        $ordemservico->setDescricao($ordem['descricao']);
        $ordemservico->setKminicial($ordem['kminicial']);
        $ordemservico->setKmfinal($ordem['kmfinal']);
        $ordemservico->setData($ordem['data']);
        $ordemservico->setPagamento($ordem['pagamento']);
        $vetor_servicos[$i] = $ordemservico;
        $i++;
    }
    return $vetor_servicos;
}

function buscarOrdemServico($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    if ($coluna == "todos-inicial" or $coluna == "todos" or $coluna == "pgto") {
        if ($coluna == "todos") {
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico`");
        }
        if ($coluna == "todos-inicial") {
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico` ORDER BY data DESC LIMIT 6");
        }
        if ($coluna == "pgto") {
            $stmt = $conn->prepare("SELECT * FROM `ordem_servico` WHERE pagamento = 0");
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
        $ordemservico->setId($ordem['id']);
        $ordemservico->setId_carro($ordem['id_carro']);
        $ordemservico->setId_cliente($ordem['id_cliente']);
        $ordemservico->setId_funcionario($ordem['id_funcionario']);
        $ordemservico->setValor($ordem['valor']);
        $ordemservico->setDescricao($ordem['descricao']);
        $ordemservico->setKminicial($ordem['kminicial']);
        $ordemservico->setKmfinal($ordem['kmfinal']);
        $ordemservico->setData($ordem['data']);
        if ($ordem['pagamento'] == 1) {
            $ordemservico->setPagamento(true);
        } else {
            $ordemservico->setPagamento(false);
        }
        $vetor_servicos[$i] = $ordemservico;
        $i++;
    }
    return $vetor_servicos;
}

function buscarOrdemServicoEntreDatas($valor_busca, $coluna, $data_apos, $data_antes)
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
    if ($coluna == "todos" or $coluna == "pgto") {
        if ($coluna == "todos") {
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
            FROM ordem_servico
            WHERE data BETWEEN :data_apos AND :data_antes;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data >= :data_apos");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
                        $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data <= :data_antes");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
        }
        if ($coluna == "pgto") {
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE pagamento = 0 and data BETWEEN :data_apos AND :data_antes;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos and pagamento = 0");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
                        $stmt = $conn->prepare("SELECT * 
                        FROM ordem_servico
                        WHERE data <= :data_antes and pagamento = 0");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
        }
    } else {
        if ($coluna == "id") {
            if ($data_apos == true and $data_antes == true) {
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND id like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos == true and $data_antes == false) {
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND id like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == false and $data_antes == true) {
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
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND id_cliente like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND id_cliente like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
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
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND id_funcionario like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND id_funcionario like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
                        $stmt = $conn->prepare("SELECT * 
                        FROM ordem_servico
                        WHERE data <= :data_antes AND id_funcionario like :busca;");
                        $stmt->bindParam(':data_antes', $data_antes);
                    }
                }
            }
            $valor_para_buscar = $busca->getId();
            $stmt->bindParam(':busca', $valor_para_buscar);
        }
        if ($coluna == "placa") {
            $busca = buscarCarroPlaca($valor_busca);
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND id_carro like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND id_carro like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
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
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND descricao like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND descricao like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
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
            if ($data_apos != "nao" and $data_antes != "nao") {
                $stmt = $conn->prepare("SELECT * 
                FROM ordem_servico
                WHERE data BETWEEN :data_apos AND :data_antes AND valor like :busca;");
                $stmt->bindParam(':data_apos', $data_apos);
                $stmt->bindParam(':data_antes', $data_antes);
            } else {
                if ($data_apos != "nao" and $data_antes == "nao") {
                    $stmt = $conn->prepare("SELECT * 
                    FROM ordem_servico
                    WHERE data >= :data_apos AND valor like :busca;");
                    $stmt->bindParam(':data_apos', $data_apos);
                } else {
                    if ($data_apos == "nao" and $data_antes != "nao") {
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
        echo "<h2>Bem vindo!</h2>";
       # header('Location: ../view/telaBuscaOrdemServico.php?msg=naoencontrado');
    } else {
        echo "<h1>Últimas ordens de serviço</h1>";
        $tabela = " 
         <div class=\"row\">
          <div class=\"col\">

          </div>
          <div class=\"col-md-auto\" style=\"text-align:center;\">

        <link rel=\"stylesheet\" href=\"../tabelas.css\">
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
        $tabela = $tabela . "</tbody> </table>
                  </div>
          <div class=\"col-3\">
          <h1></h1>
          </div>
        </div>";

        return $tabela;
    }
}
function imprimirResultadosOrdemServicosParaOS($vetor_servicos)
{
    if (empty($vetor_servicos)) {
        echo "Não há dados para exibir";
        return;
    }

    $ordemservico1 = $vetor_servicos[0];
    if (empty($ordemservico1)) {
        header('Location: ../view/telaRelatorio.php?msg=naoencontrado');
    } else {
        $data_atual = date("d/m/Y");
        $tabela = "
        
        <link rel=\"stylesheet\" href=\"../tabelas.css\">
        <h1>Relatório personalizado</h1>
        <h2>Oficina do evandro - $data_atual</h2>
    <table id=\"tabelabusca\" border=\"1\" >
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Cliente</th>
                    <th>Funcionário</th>
                    <th>Serviço</th>
                    <th class=\"nao_quebrar_linha\">Data</th>
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

        return $tabela;
    }
}

function imprimirResultadosOrdemServicos($vetor_servicos)
{
    if (empty($vetor_servicos)) {
        echo "Não há dados para exibir";
        return;
    }

    $ordemservico1 = $vetor_servicos[0];
    if (empty($ordemservico1)) {
        header('Location: ../view/telaBuscaOrdemServico.php?msg=naoencontrado');
    } else {
       
        $tabela = "
        
        <link rel=\"stylesheet\" href=\"../tabelas.css\">
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
               <a href=\"../view/telaEditar.php?id=" . $ordemservico->getId() . "&tipo=ordemservico\">
               <button class=\"btn btn-primary\"><i class=\"material-icons\">edit</i></button></a></td>

               <td><input type=\"hidden\" name=\"id_apagar\" value=\" " . $ordemservico->getId() . "\">
                <button class=\"btn btn-danger\" name\"bt_apagar\" id=\"bt_apagar\" data-bs-toggle=\"modal\" data-bs-target=\"#modalFuncionarios\"><i class=\"material-icons\">delete</i></button>
                
            </td>"
                . "</tr>";
                $tabela .= '  <div class="modal fade" id="modalFuncionarios" tabindex="-1" aria-lablledby="exemploModalFuncionarios" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exemploModalFuncionarios">Confirmar</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="resultado_ajax_funcionarios">
                      <div id="Pesquisar">
                        <div class="input-group mb-3">
                        <h3>Deseja excluir está ordem de serviço?</h3> 
                        </div>
                      </div>
                      
                    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <form action="../view/telaExcluir.php" method="post">
        <input hidden name="id" value="'. $ordemservico->getId() . '">
        <button type="submit" class="btn btn-danger" name="bt_excluir">Excluir</button>
      </div>
                  </div>
                </div>
              </div>';
    
        }
        $tabela = $tabela . "</tbody> </table>";

        return $tabela;
    }
}

function gerarPdfdasOS($vetor_servicos)
{
    if (empty($vetor_servicos)) {
        #echo "Não há dados para exibir.";
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
function gerarPdfOSUnica($id_os)
{
    $ordemservico = buscarOrdemServico($id_os, "id");

    $ordem = $ordemservico[0];
    $cliente = buscarClientePorId($ordem->getId_cliente());
    $funcionario = buscarFuncionarioPorId($ordem->getId_funcionario());
    $carro = buscarCarroPorId($ordem->getId_carro());
    $servicos = buscar_sv_os_por_os($ordem->getId());
    $data_atual = date("d/m/Y");
    $tabela = "<h2> Relatório de ordem de serviço - Oficina do Evandro.</h2> <h2>Data do relatório: $data_atual.</h2>
        <label>Cliente : " . $cliente->getNome() . "</label><br><br>
        <label>Funcionário : " . $funcionario->getNome() . "</label><br><br>
        <label>Carro : " . $carro->getMarca() . " - " . $carro->getModelo() . " - " . $carro->getAno() . "</label><br><br>
        <label> Serviços realizados:</label><br>";
    foreach ($servicos as $servico) {
        $servico = buscarServicoPorId($servico, $ordem->getId());
        $tabela .= "<label>-" . $servico->getDescricao() . "</label><br>";
    }

    $data = implode("/", array_reverse(explode("-", $ordem->getData())));
    $tabela .= "<br><label>Descrição do serviço : " . $ordem->getDescricao() . "</label><br><br>
        <label>Data : $data</label><br><br>
        <label>Quilometragem Inicial : " . $ordem->getKminicial() . "</label><br>
        <label>Quilometragem Final : " . $ordem->getKmfinal() . "</label><br><br>";
    if ($ordem->isPago()) {
        $tabela .= "<label>Pagamento : Pago</label>";
    } else {
        $tabela .= "<label>Pagamento : Não pago</label>";
    }

    include_once 'gerarPdf.php';
    gerarPdf($tabela);
}

function imprimirEditarOrdemServico($ordemservico)
{
    if (empty($ordemservico)) {
        return null;
    }
    $cliente = buscarClientePorId($ordemservico->getId_cliente());
    $funcionario = buscarFuncionarioPorId($ordemservico->getId_funcionario());
    $carro = buscarCarroPorId($ordemservico->getId_carro());

    echo '
    <div class="container">
        <form method="post" action="../control/OrdemServicoControle.php?id_os=' . $ordemservico->getId() . '"><button class="btn btn-danger botao-enviar" type="submit" id="bt_gerar_pdf_unica" name="bt_gerar_pdf_unica"></a> <h6><i class="material-icons">picture_as_pdf</i> Gerar PDF</h6></button></form>
  <br>
        <form action="../control/OrdemServicoControle.php?id=' . $_GET['id'] . '&tipo=' . $_GET['tipo'] . '" method="post">
            <div class="form-floating mb-3 ">
              <input type="text" name="placa" class="form-control" id="exampleFormControlInput1" value="' . $carro->getPlaca() . '" placeholder="ABC1D23">
              <label for="exampleFormControlInput1" class="form-label">Placa do veículo</label>
            </div>

            <div class="input-group form-floating mb-3">
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
            <div class="form-floating mb-3">
            <h5>Selecione os serviços realizados:</h5>
            ';
    include_once '../control/ServicoControle.php';

    $servicos = buscarTodosServicos();
    $i = 1;
    foreach ($servicos as $servico) {
        echo '  <div class="form-check form-check-inline">
              <input ';
        if (verificarServico_os($servico->getId(), $ordemservico->getId())) {
            echo ' checked ';
        }
        echo 'class="form-check-input" type="checkbox" name="servico_id' . $servico->getId() . '" id="' . $servico->getDescricao() . '" value="option1">
              <label class="form-check-label" for="' . $servico->getDescricao() . '">' . $servico->getDescricao() . '</label>
            </div>';
        $i++;
    }

    echo '
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

             <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="pgto" id="pgto" value="option1" ';
    if ($ordemservico->isPago()) {
        echo ' checked ';
    }
    echo ' >
                <label class="form-check-label" for="pgto">O pagamento foi realizado?</label>
              </div>
            
              <br><br>
            <div style="text-align:center;">
            <button type="submit" class="btn btn-success" name="bt_editar_ordemservico">
              <h2>Editar</h2>
            </button>
            </div>
          </form>
        </div>';
}

if (isset($_POST['bt_gerar_pdf_unica'])) {
    if (isset($_GET['id_os'])) {
        gerarPdfOSUnica($_GET['id_os']);
    }
}

