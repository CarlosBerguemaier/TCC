<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tela de serviços</title>
 <!-- Última versão CSS compilada e minificada -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<link rel="stylesheet" href="../estilo.css">

</head>
<body>
<?php include_once '../sidebar.php';?>

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
      <form action="">
        Placa do Carro: <input type="text">
        CPF do Cliente: <input type="text">
        CPF do Funcionário: <input type="text">
        Descrição: <input type="text">
        Valor: <input type="text">
        Quilometragem Inicial: <input type="text">
        Quilometragem Final: <input type="text">
    </form>
</div></div>

  <div class="tab-pane fade bg-white border" id="cliente" role="tabpanel" aria-labelledby="cliente-tab">
  <form action="">
        Nome: <input type="text">
        CPF: <input type="text">
        Telefone: <input type="text">
    </form>
  </div>
  <div class="tab-pane fade bg-white border" id="carro" role="tabpanel" aria-labelledby="carro-tab">
  <form action="">
        Placa: <input type="text">
        Marca: <input type="text">
        Modelo: <input type="text">
        Ano: <input type="text">
    </form>
  </div>
    <div class="tab-pane fade bg-white border" id="funcionario" role="tabpanel" aria-labelledby="funcionario-tab">
    <form action="">
        Nome: <input type="text">
        CPF: <input type="text">
        Telefone: <input type="text">
    </form>
    </div>
</div>





</div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="../js.js"></script>
<script src="../cadastros.js"></script>
</html>