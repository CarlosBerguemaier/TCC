<?php

include_once '../model/Carro.php';
include_once '../database/conexao.php';

$conn = new Conexao();
$conn = $conn->conexao();


if(isset($_POST['placa'])){$placa = $_POST['placa'];}
if(isset($_POST['marca'])){$marca = $_POST['marca'];}
if(isset($_POST['modelo'])){$modelo = $_POST['modelo'];}
if(isset($_POST['ano'])){$ano = $_POST['ano'];}

if(isset($_POST['bt_cadastro_carro'])){
    if(!isset($placa) or !isset($marca) or !isset($modelo) or !isset($ano) or empty($placa) or empty($marca) or empty($modelo) or empty($ano)){
        header('Location: ../view/telaCadastroCarro.php?msg=dadosinvalidos');
    }else{
        inserirCarro($placa, $marca, $modelo, $ano);
    }
}

function inserirCarro($placa, $marca, $modelo, $ano){
    $carro = buscarCarro($placa,"placa");
    if(!empty($carro[0])){
    header('Location: ../view/telaCadastroCarro.php?msg=dadosduplicadosplaca');
    }

    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("INSERT INTO `carro`(`placa`, `marca`, `modelo`, `ano`)
                             VALUES (:placa,:marca,:modelo,:ano)");
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':ano', $ano);
    $stmt->execute();
    $stmt = null;    
    header('Location: ../view/telaCadastroCarro.php?msg=sucesso'); 
}

function buscarCarro($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    if ($coluna == "todos") {
        $stmt = $conn->prepare("SELECT * FROM `carro`");
    }else{
    if (!isset($valor_busca) or !isset($coluna) or empty($valor_busca) or empty($coluna)) {
        header('Location: ../view/index.php?msg=dadosinvalidos');
    }
    if ($coluna == "id") {
        $stmt = $conn->prepare("SELECT * FROM `carro` WHERE id like :busca");
        $valor_para_buscar = $valor_busca;
    }
    if ($coluna == "marca") {
        $stmt = $conn->prepare("SELECT * FROM `carro` WHERE marca like :busca");
        $valor_para_buscar = "%".$valor_busca."%";
    }
    if ($coluna == "modelo") {
        $stmt = $conn->prepare("SELECT * FROM `carro` WHERE modelo like :busca");
        $valor_para_buscar = "%".$valor_busca."%";
    }
    if ($coluna == "placa") {
        $stmt = $conn->prepare("SELECT * FROM `carro` WHERE placa like :busca");
        $valor_para_buscar = "%".$valor_busca."%";
    }
    if ($coluna == "ano") {
        $stmt = $conn->prepare("SELECT * FROM `carro` WHERE ano like :busca");
        $valor_para_buscar = $valor_busca;
    }
    $stmt->bindParam(':busca', $valor_para_buscar);
}

    $stmt->execute();

    $resultado = $stmt->fetchAll();
    $vetor_carros[] = "";
    $i = 0;
    foreach ($resultado as $ordem) {
        $carro = new Carro();
        $carro->setID($ordem['id']);
        $carro->setMarca($ordem['marca']);
        $carro->setModelo($ordem['modelo']);
        $carro->setPlaca($ordem['placa']);
        $carro->setAno($ordem['ano']);
        $vetor_carros[$i] = $carro;
        $i++;
    }
    return $vetor_carros;
}

function buscarCarroPlaca($placa){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `carro` WHERE `placa` like :placa");
    $placa = "%".$placa."%";
    $stmt->bindParam(':placa', $placa);
    $stmt->execute();
    $carro = new Carro();
       while( $result = $stmt->fetch()){
        $carro->setID($result["id"]);
        $carro->setPlaca($result["placa"]);
        $carro->setMarca($result["marca"]);
        $carro->setModelo($result["modelo"]);
        $carro->setAno($result["ano"]);
       }
       return $carro;    
}

if(isset($_POST['bt_busca_carro'])){
    if($_GET['coluna'] == "todos"){
        header('Location: ../view/telaBuscaCarros.php?coluna='.$_GET['coluna'].'&valor=todos');
    }
if(isset($_POST['busca']) or !empty($_POST['busca'])){
header('Location: ../view/telaBuscaCarros.php?coluna='.$_GET['coluna'].'&valor='.$_POST['busca']);
}}

function buscarCarroPorId($id){
    $conn = new Conexao();
    $conn = $conn->conexao();
    $stmt = $conn->prepare("SELECT * FROM `carro` WHERE `id` like :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $carro = new Carro();
       while( $result = $stmt->fetch()){
        $carro->setID($result["id"]);
        $carro->setPlaca($result["placa"]);
        $carro->setMarca($result["marca"]);
        $carro->setModelo($result["modelo"]);
        $carro->setAno($result["ano"]);
       }
       return $carro;    
}
function bt_buscar_carros($busca,$coluna){
    if (!isset($busca) or empty($busca) or empty($coluna) or !isset($coluna)) {
        header('Location: ../view/telaBuscaCarros.php?msg=naoencontrado');
    }
    $result = buscarCarro($busca, $coluna);
    return $result;
}



function imprimirResultadosCarros($vetor_carros){
    if (empty($vetor_carros)) {
        echo "Não há dados para exibir.";
        return;
    }
    $carro = $vetor_carros[0];
    if(empty($carro)){
        echo "Nenhum dado foi encontrado!";
    }else{
        $resultado = " <link rel=\"stylesheet\" href=\"../tabelas.css\">
        <table id=\"tabelabusca\" border='1'>
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th class=\"centralizar_coluna\"></th>
                    <th class=\"centralizar_coluna\"></th>
                </tr>
            </thead>
            <tbody>";
    foreach ($vetor_carros as $carro) {
        $resultado .= "<tr><td>" . $carro->getPlaca() . "</td>".
         "<td>" . $carro->getMarca() . "</td>" .
         "<td>" . $carro->getModelo() . "</td>" .
         "<td>" . $carro->getAno() . "</td>
        <td>
         <a href=\"telaEditar.php?id=" . $carro->getId() . "&tipo=carro\">
         <button class=\"btn btn-primary\"><i class=\"material-icons\">edit</i></button></a></td>

         <td><form method=\"post\" action=\"../view/telaExcluir.php\">

          <input type=\"hidden\" name=\"id_apagar\" value=\" " . $carro->getId() . "\">

          <button class=\"btn btn-danger\" name\"bt_apagar\" id=\"bt_apagar\"><i class=\"material-icons\">delete</i></button>

          </form>
          
      </td>"
          . "</tr>";
    }
       $resultado.= "</tbody> 
        </table>";
        return $resultado;
    }
}


function imprimirEditarCarro($carro){
    if(empty($carro)){
    return null;
    }

    echo " <div class=\"container\">
<form action=\"../control/CarroControle.php?id=". $_GET['id']."&tipo=".$_GET['tipo']."\" method=\"post\">
        <div class=\" input-group form-floating mb-3\">
          <input type=\"text\" name=\"placa\" class=\"form-control\" id=\"placa\" value=\"". $carro->getPlaca() ."\">
          <label for=\"placa input-group-text\" class=\"form-label\">Placa</label>   
        </div>
        <div class=\" input-group form-floating mb-3\">
          <input type=\"text\" name=\"marca\" class=\"form-control\" id=\"marca\" value=\"". $carro->getMarca() ."\">
          <label for=\"marca input-group-text\" class=\"form-label\">Marca</label>   
    </div>
        <div class=\" input-group form-floating mb-3\">
          <input type=\"text\" name=\"modelo\" class=\"form-control\" id=\"modelo\" value=\"". $carro->getModelo() ."\">
          <label for=\"modelo input-group-text\" class=\"form-label\">Modelo</label>   
    </div>
        <div class=\" input-group form-floating mb-3\">
          <input type=\"text\" name=\"ano\" class=\"form-control\" id=\"ano\" value=\"". $carro->getAno()."\">
          <label for=\"ano input-group-text\" class=\"form-label\">Telefone</label>   
             </div>";

          echo '<div style="text-align:center;">
        <button type="submit" class="btn btn-success" name="bt_editar_carro">
          <h2>Editar</h2>
        </button>
        </div></form>';

    }




if(isset($_POST['bt_editar_carro'])){

if(isset($_POST['placa']) and isset($_POST['marca']) and isset($_POST['modelo']) and isset($_POST['ano'])){

$placa = $_POST['placa'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$ano = $_POST['ano'];

$carro = new Carro;

$carro->setId($_GET['id']);
$carro->setPlaca($placa);
$carro->setMarca($marca);
$carro->setModelo($modelo);
$carro->setAno($ano);


editarCarro($carro);
}
}

function editarCarro($carro){
    $id = $carro->getId();
    $placa = $carro->getPlaca();
    $marca = $carro->getMarca();
    $modelo = $carro->getModelo();
    $ano = $carro->getAno();

    
        $conn = new Conexao();
        $conn = $conn->conexao();
        $stmt = $conn->prepare("UPDATE `carro`
         SET `placa`=:placa, `marca`=:marca , `modelo`= :modelo,`ano`= :ano WHERE id like :id");
    
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':id', $id);

    
        $stmt->execute();
        $stmt = null;
        header('Location: ../view/index.php?msg=sucesso');
    }

    function gerarPdfdosCarros($vetor_carros){
        if (empty($vetor_carros)) {
            echo "Não há dados para exibir.";
            return;
        }
        $carro = $vetor_carros[0];
        if(empty($carro)){
            echo "Nenhum dado foi encontrado!";
        }else{
            $data_atual = date("d/m/Y");
        $tabela = "
        <h2> Relatório de funcionários - Oficina do Evandro.</h2> <h2>Data do relatório: $data_atual.</h2>
        <table id=\"tabelabusca\" border='1'>
                <thead>
                    <tr>
                  <th>Placa</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    </tr>
                </thead>
                <tbody>";
                foreach ($vetor_carros as $carro) {
          $tabela .="<tr><td>" . $carro->getPlaca() . "</td>".
         "<td>" . $carro->getMarca() . "</td>" .
         "<td>" . $carro->getModelo() . "</td>" .
         "<td>" . $carro->getAno() . "</td>"
                    . "</tr>";
                }
        $tabela .=  "</tbody> </table>";
    
        include_once 'gerarPdf.php';
        gerarPdf($tabela);
    
        }
    }
?>