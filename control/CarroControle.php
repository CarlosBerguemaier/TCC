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
        header('Location: ../view/telaCadastro.php?msg=dadosinvalidos');
    }else{
        inserirCarro($placa, $marca, $modelo, $ano);
    }
}

function inserirCarro($placa, $marca, $modelo, $ano){
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
    header('Location: ../view/telaCadastro.php?msg=sucesso'); 
}

function buscarCarro($valor_busca, $coluna)
{
    $conn = new Conexao();
    $conn = $conn->conexao();
    if ($coluna == "todos") {
        $stmt = $conn->prepare("SELECT * FROM `carro`");
    }else{
    if (!isset($valor_busca) or !isset($coluna) or empty($valor_busca) or empty($coluna)) {
        header('Location: ERRO');
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
    echo "<table id=\"tabelabusca\" border='1'>
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
        echo "<tr><td>" . $carro->getPlaca() . "</td>".
         "<td>" . $carro->getMarca() . "</td>" .
         "<td>" . $carro->getModelo() . "</td>" .
         "<td>" . $carro->getAno() . "</td>"

        . "<td>
               <a href=\"telaEditar.php?id=".$carro->getId()."&tipo=carro\"><button class=\"btn btn-primary\">Editar</button></a>
                <a href=\"telaExlcuir.php?id=".$carro->getId()."\"><button class=\"btn btn-danger\">Apagar</button></a>
            </td>"
        . "</tr>";
    }
    echo "</tbody> 
        </table>";
    }
}


function imprimirEditarCarro($carro){
    if(empty($carro)){
    return null;
    }

    echo " <form action=\"../control/CarroControle.php?id=". $_GET['id']."&tipo=".$_GET['tipo']."\" method=\"post\">
        Placa: <input type=\"text\" name=\"placa\" value=\"". $carro->getPlaca() ."\">
        Marca: <input type=\"text\" name=\"marca\" value=\"". $carro->getMarca() ."\">
        Modelo <input type=\"text\" name=\"modelo\" value=\"". $carro->getModelo()."\">
        Ano <input type=\"text\" name=\"ano\" value=\"". $carro->getAno()."\">
       
        <button class=\"btn btn-success botao-enviar\" type=\"submit\" id=\"bt_editar_carro\" name=\"bt_editar_carro\">Editar</button>
    </form>";
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
       # header('Location: ../view/index.php?msg=sucesso');
    }
?>