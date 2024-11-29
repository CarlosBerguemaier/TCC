<?php
// Verifica se existe a variável txtnome
if (isset($_GET["txtnome"])) {
    $nome = $_GET["txtnome"];

   include_once '../control/FuncionarioControle.php';

   $funcionarios = buscarFuncionario($nome,"nome");

   if (empty($funcionarios)) {
    echo "Não há dados para exibir.";
    return;
}
    $funcionario = $funcionarios[0];
    if(empty($funcionario)){
        echo "Nenhum dado foi encontrado!";
}else{
    echo "<table id=\"tabelabusca\"  border='1' width=\"100%\" cellspacing=\"10\">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                </tr>
    </thead>
            <tbody>";
    foreach ($funcionarios as $funcionario) {
        echo "<tr><td>" . $funcionario->getNome() . "</td>".
         "<td>" . $funcionario->getCpf() . "</td>" .
         "<td>" . $funcionario->getTelefone() . "</td>".
         "<td>". "<button class=\"btn btn-primary bt-select\" id=\"".$funcionario->getCpf()."\" data-bs-dismiss=\"modal\" onclick=\"atualizarCpf_funcionarios(this.id)\">Selecionar</button>" ."</td>".
         " </tr>";
    }
    echo "</tbody> 
        </table>";
}}
?>