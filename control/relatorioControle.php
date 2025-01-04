<?php
include_once '../model/Carro.php';
include_once '../model/OrdemServico.php';
include_once '../model/Cliente.php';
include_once '../model/Funcionario.php';

include_once '../database/Conexao.php';

include_once '../control/CarroControle.php';
include_once '../control/OrdemServicoControle.php';
include_once '../control/ClienteControle.php';
include_once '../control/FuncionarioControle.php';
include_once '../control/ServicoControle.php';





    function buscarRelatorio() {
    $placa = "aa";
    $cpf_c = "";
    $cpf_f = "";
    $descricao = "";
    $valor = "";
    $data = "";
    $kminicial = "";
    $kmfinal = "";
    $pgto = "";

    

    $string = "SELECT * FROM `ordem_servico` WHERE 1=1 ";

    if (!empty($_POST['placa'])) {
        $placa = $_POST['placa'];
        $placa = str_replace(' ', '', $placa);
        $carro = buscarCarroPlaca($placa);
        if($carro->getPlaca()!="") {    
            $id = $carro->getId();
            $string = $string . "and id_carro like " . $id;
        }else{
            $string = $string . "and id_carro like ''";
        }

    }
    if (!empty($_POST['cpf_cliente'])) {
        $cpf_c = $_POST['cpf_cliente'];
        $cliente = buscarClienteCpf($cpf_c);
        if ($cliente->getNome()!="") {
            $id = $cliente->getId();
            $string = $string . " and id_cliente like " . $id;
        }else{
            $string = $string . " and id_cliente like ''";
        }
    }
    if (!empty($_POST['cpf_funcionario'])) {
        $cpf_f = $_POST['cpf_funcionario'];
        $funcionario = buscarFuncionarioCpf($cpf_f);
        if ($funcionario->getNome()!="") {
            $id = $funcionario->getId();
            $string = $string . " and id_funcionario like " . $id;
        }else{
            $string = $string . " and id_funcionario like '' ";
        }
    }

    if (!empty($_POST['descricao'])) {
        $descricao = $_POST['descricao'];
        $string = $string . " and descricao like '" . $descricao . "' ";
    }
    if (!empty($_POST['valor'])) {
        $valor = $_POST['valor'];
        $string = $string . " and valor like " . $valor;
    }
    if (!empty($_POST['data'])) {
        $data = $_POST['data'];
        $string = $string . " and data like '" . $data . "' ";
    }
    if (!empty($_POST['kminicial'])) {
        $kminicial = $_POST['kminicial'];
        $string = $string . " and kminicial like " . $kminicial;
    }
    if (!empty($_POST['kmfinal'])) {
        $kmfinal = $_POST['kmfinal'];
        $string = $string . " and kmfinal like " . $kmfinal;
    }
    if (!empty($_POST['pago'])) {
        $pago = $_POST['pago'];
        if ($pago == "option1") {
            $string = $string . " and pagamento = 1 ";
        }
    }
    if (!empty($_POST['npago'])) {
        $pago = $_POST['npago'];
        if ($pago == "option1") {
            $string = $string . " and pagamento = 0 ";
        }
    }

    $vetor_servicos = [];
    $num_servicos = buscarNumeroDeServicos();
    for ($i = 0; $i <= $num_servicos; $i++) {
        if (!empty($_POST['servico_id' . $i])) {
            $servico_id = $_POST['servico_id' . $i];
            array_push($vetor_servicos, $servico_id);
        }
    }
    $string_servicos = "(";
    $tam = sizeof($vetor_servicos);
    $i = 0;
    foreach ($vetor_servicos as $sv_id) {
        if($i==$tam-1){
            $string_servicos =  $string_servicos . "$sv_id";
        }else{
            $string_servicos =  $string_servicos . "$sv_id, ";
        }
        $i++;
    }
    $string_servicos = $string_servicos . ")";

    if(sizeof($vetor_servicos)>=1){
        foreach ($vetor_servicos as $servico_id){
            $string = $string . " and id in (SELECT id_os
            from servico_os
             where id_servico = ".$servico_id.")";
        }
    
    }

    $conn = new Conexao;
    $conn = $conn->conexao();

    $stmt = $conn->prepare($string);
    $stmt->execute();

    $resultado = $stmt->fetchAll();
    $vetor_os = [];
    if(empty($resultado)){
        echo '<div class="alert alert-danger" style="text-align:center;" role="alert">
        <h6 class="texto-alertas">Não foram encontradas ordens de serviço com os termos específicados!</h6>
      </div>
      <a href="../view/telaRelatorio.php"><button class="btn btn-success"> Refazer a busca</button></a><br>
      ';
    }else{
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
        array_push($vetor_os,$ordemservico);
    }
}
$tabela = imprimirResultadosOrdemServicos($vetor_os);
echo $tabela;
}


 ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Principal</title>
 
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="../estilo.css">
</head>
<body>


<nav class="navbar navbar-light bg-light nav_bar">
  <div class="container-fluid justify-content-around">
    <a href="index.php"><h1><img src="../images/logo.webp" alt="" style="width:50px;"></h1></a>
    <form class="d-flex" method="post" action="../control/pesquisaControle.php">
      <input name="pesquisar" class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-dark" name="bt_pesquisar" type="submit"><i class="material-icons">search</i></button>
    </form>
    <h1></h1>
  </div>
</nav>

<?php
  if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    if ($msg == "sucesso") {
      echo '<div class="alert alert-success " style="text-align:center" role="alert">
      <h6 class="texto-alertas">Ação realizada com Sucesso!</h6>
    </div>';
    }
    if ($msg == "dadosinvalidos") {
      echo '<div class="alert alert-danger" style="text-align:center" role="alert">
      <h6 class="texto-alertas">Existe algum dado inválido e/ou faltando!</h6>
    </div>';
    }
    if ($msg == "semdados") {
        echo '<div class="alert alert-danger" style="text-align:center" role="alert">
        <h6 class="texto-alertas">Não foram encontradas ordens de serviço com os termos específicados!</h6>
      </div>';
      }
  }
  ?>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 nav-lateral bg-light">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                    <a href="../view/index.php"><button class="btn btn-dark m-1 bt_opcoes"><i class="material-icons">home</i> Início</button></a>
 
                    </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Ordem de serviço
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastroOrdemServico.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <a href="../view/telaBuscaOrdemServico.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>
                    </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Cliente
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastroCliente.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <a href="../view/telaBuscaClientes.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>     
                  </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Veículos
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastroCarro.php">   <button class="btn btn-outline-dark m-1 sub_bt_opcoes" ><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <a href="../view/telaBuscaCarros.php"> <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>
                    </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Funcionário
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastroFuncionario.php"> <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <a href="../view/telaBuscaFuncionarios.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>
                    </li>
                    <li>
                    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="material-icons">picture_as_pdf</i> Relatórios
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaRelatorio.php"> <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Personalizar</button></a>
   <br>
   <a href="../view/telaBuscaFuncionarios.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Mensal</button></a>
   <br>
   <a href="../view/telaBuscaFuncionarios.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Anual</button></a>
  </ul>
</div>
                    </li>
                </ul>
                <hr>
            </div>
        </div>

<div class="container central" style="margin-top:4%;">
  <div class="row">
    <div class="col">
      
    </div>
    <div class="col-md-auto" style="text-align:center; margin-left:5%;">
   <?php if (isset($_POST['bt_relatorio_ordemservico'])) { buscarRelatorio();}?>
    </div>
    <div class="col">
      
    </div>
  </div>

</div>

    </div>
  
  </div>


<script src="../js.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
</body>

</html>