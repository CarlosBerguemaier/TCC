<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tela de serviços</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<link rel="stylesheet" href="../estilo.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #6AA6F9;">   
    <ul class="navbar-nav">
      <li class="nav-item custom">
        <a class="nav-link navbar-link" href="index.php"><i class="material-icons">arrow_back</i></a>
      </li>
    </ul>
</nav>

<?php 
  if(isset($_GET['msg'])){
    $msg=$_GET['msg'];
    if($msg == "sucesso"){
      echo '<div class="alert alert-success" role="alert">
      <h6 class="texto-alertas">Cadastro realizado com Sucesso!</h6>
    </div>';
    }
    if($msg == "naoencontrado"){
      echo '<div class="alert alert-danger" role="alert">
      <h6 class="texto-alertas">Não foi encontrado nenhum registro com o dado informado!</h6>
    </div>';
    }
  } 
?>

<div class="principal">
<div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="servico-tab" data-toggle="tab" href="#servico" role="tab" aria-controls="servico" aria-selected="true">Serviços</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="cliente-tab" data-toggle="tab" href="#cliente" role="tab" aria-controls="cliente" aria-selected="false">Clientes</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="carro-tab" data-toggle="tab" href="#carro" role="tab" aria-controls="carro" aria-selected="false">Carros</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="funcionario-tab" data-toggle="tab" href="#funcionario" role="tab" aria-controls="funcionario" aria-selected="false">Funcionários</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active bg-white border" id="servico" role="tabpanel" aria-labelledby="servico-tab"> 
       <div class="card-body">
       <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           Escolha o parametro para buscar
          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="../view/telaBusca.php?sv_busca=placa">Placa do Veículo</a>
          <a class="dropdown-item" href="../view/telaBusca.php?sv_busca=cpf_c">CPF do cliente</a>
          <a class="dropdown-item" href="../view/telaBusca.php?sv_busca=cpf_f">CPF do Funcionário</a>
          <a class="dropdown-item" href="../view/telaBusca.php?sv_busca=descricao">Descrição</a>
          <a class="dropdown-item" href="../view/telaBusca.php?sv_busca=valor">Valor</a>
         </div>
          </div>
      
        <?php if(isset($_GET["sv_busca"])){
          if($_GET["sv_busca"] == "cpf_c"){
            $coluna = "cpf_c";
             echo '<form action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
             echo "Digite o CPF do cliente:<input type='text' name='busca'>";
             echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

          }
          if($_GET["sv_busca"] == "cpf_f"){
            $coluna = "cpf_f";
            echo '<form action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
            echo "Digite o CPF do Funcionário:<input type='text' name='busca'>";
            echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

          }
          if($_GET["sv_busca"] == "placa"){
            $coluna = "placa";
            echo '<form action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
            echo "Digite a placa do veículo:<input type='text' name='busca'>";
            echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

          }
          if($_GET["sv_busca"] == "valor"){
            $coluna = "valor";
            echo '<form action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
            echo "Digite o valor do serviço:<input type='text' name='busca'>";
            echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

          }
          if($_GET["sv_busca"] == "descricao"){
            $coluna = "descricao";
            echo '<form action="../control/OrdemServicoControle.php?coluna='.$coluna.'" method="post">';
            echo "Digite a descrição do serviço:<input type='text' name='busca'>";
            echo '<button class="btn btn-success botao-enviar" type="submit" id="bt_busca_ordemservico" name="bt_busca_ordemservico">Buscar</button>';

          }
        }
          ?>
  
       
    </form>
</div></div>

  <div class="tab-pane fade bg-white border" id="cliente" role="tabpanel" aria-labelledby="cliente-tab">
  <div class="card-body">
  <form action="../control/ClienteControle.php" method="post">
        Nome: <input type="text" name="nome">
        CPF: <input type="text" name="cpf">
        Telefone: <input class="" type="text" name="telefone">
        <button class="btn btn-success botao-enviar" type="submit" id="bt_cadastro_cliente" name="bt_cadastro_cliente">Cadastrar</button>
    </form>
  </div></div>
  <div class="tab-pane fade bg-white border" id="carro" role="tabpanel" aria-labelledby="carro-tab">
  <div class="card-body">
  <form action="../control/CarroControle.php" method="post">
        Placa: <input type="text" name="placa">
        Marca: <input type="text" name="marca">
        Modelo: <input type="text" name="modelo">
        Ano: <input type="text" name="ano">
        <button class="btn btn-success botao-enviar" type="submit" id="bt_cadastro_carro" name="bt_cadastro_carro">Cadastrar</button>
    </form>
  </div>  </div>
    <div class="tab-pane fade bg-white border" id="funcionario" role="tabpanel" aria-labelledby="funcionario-tab">
    <div class="card-body">
    <form action="../control/FuncionarioControle.php" method="post">
        Nome: <input type="text" name="nome">
        CPF: <input type="text" name="cpf">
        Telefone: <input type="text" name="telefone">
        <button class="btn btn-success botao-enviar" type="submit" id="bt_cadastro_funcionario" name="bt_cadastro_funcionario">Cadastrar</button>
    </form>
    </div>  </div>
</div>
</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="../js.js"></script>
</html>