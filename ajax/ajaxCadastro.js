function CriaRequest() {
    try{
        request = new XMLHttpRequest();
    }catch (IEAtual){

        try{
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(IEAntigo){

            try{
                request = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(falha){
                request = false;
            }
        }
    }

    if (!request)
        alert("Seu Navegador não suporta Ajax!");
    else
        return request;
}

function getDadosCliente() {

    // Declaração de Variáveis
    var nome   = document.getElementById("txtnome_clientes").value;
    var result = document.getElementById("Resultado_clientes");
    var xmlreq = CriaRequest();



    // Iniciar uma requisição
    xmlreq.open("GET", "../ajax/buscarClienteAjax.php?txtnome=" + nome, true);

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function getDadosFuncionarios() {

    // Declaração de Variáveis
    var nome   = document.getElementById("txtnome_funcionario").value;
    var result = document.getElementById("Resultado_funcionarios");
    var xmlreq = CriaRequest();



    // Iniciar uma requisição
    xmlreq.open("GET", "../ajax/buscarFuncionarioAjax.php?txtnome=" + nome, true);

    // Atribui uma função para ser executada sempre que houver uma mudança de ado
    xmlreq.onreadystatechange = function(){

        // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
        if (xmlreq.readyState == 4) {

            // Verifica se o arquivo foi encontrado com sucesso
            if (xmlreq.status == 200) {
                result.innerHTML = xmlreq.responseText;
            }else{
                result.innerHTML = "Erro: " + xmlreq.statusText;
            }
        }
    };
    xmlreq.send(null);
}

function atualizarCpf_clientes(e){
    var cpf_cliente = document.getElementById("cliente_cpf_input");
    cpf_cliente.value = e;
}
function atualizarCpf_funcionarios(e){
    var cpf_funcionario = document.getElementById("funcionario_cpf_input");
    cpf_funcionario.value = e;
}





