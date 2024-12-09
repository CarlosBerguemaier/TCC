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
    <h1><img src="../images/logo.webp" alt="" style="width:50px;"></h1>
    <form class="d-flex">
      <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-dark" type="submit"><i class="material-icons">search</i></button>
    </form>
    <h1></h1>
  </div>
</nav>



<div class="container" style="margin-top:5%;">

  <div class="row">
    <div class="col-3 menulateral" >
    
    <div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Ordem de serviço
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastro.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">edit</i> Editar</button>
   <br>
   <a href="../view/telaBuscaOrdemServico.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>

<div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Cliente
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastro.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">edit</i> Editar</button>
   <br>
   <a href="../view/telaBuscaClientes.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>

<div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Carro
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastro.php">   <button class="btn btn-outline-dark m-1 sub_bt_opcoes" ><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">edit</i> Editar</button>
   <br>
   <a href="../view/telaBuscaCarros.php"> <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>

<div class="btn-group dropend m-1">
  <button type="button" class="btn btn-dark dropdown-toggle  bt_opcoes" data-bs-toggle="dropdown" aria-expanded="false">
  Funcionário
  </button>
  <ul class="dropdown-menu ">
  <a href="../view/telaCadastro.php"> <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">add</i> Cadastrar</button></a>
   <br>
   <button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">edit</i> Editar</button>
   <br>
   <a href="../view/telaBuscaFuncionarios.php"><button class="btn btn-outline-dark m-1 sub_bt_opcoes"><i class="material-icons">list</i> Listar</button></a>
  </ul>
</div>

</div>

<div class="col" style="text-align:center; margin-left:5%;">
      <h1>Últimas Ordens de serviço</h1>
      <div class="central">
<?php 
include_once '../control/OrdemServicoControle.php';

imprimirOS_telainicial();

?>
</div>
</div>

    </div>
  
  </div>
</div>


<?php 
    if(isset($_GET['msg'])){
      $msg=$_GET['msg'];
      if($msg == "sucesso"){
        echo '<div class="alert alert-success" role="alert">
        <h6 class="texto-alertas">Ação efetuada com Sucesso!</h6>
      </div>';
      }
      if($msg == "naoencontrado"){
        echo '<div class="alert alert-danger" role="alert">
        <h6 class="texto-alertas">Não foi encontrado nenhum registro com o dado informado!</h6>
      </div>';
      }
    } 
  ?>
<div class="principal"></div>
<script src="../js.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
</body>

</html>