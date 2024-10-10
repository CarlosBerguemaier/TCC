<?php

class Cliente{
    private $id;
    private $nome;
    private $telefone;
    private $cpf;

    public function getId() {return $this->id;}
    public function getNome() {return $this->nome;}
    public function getTelefone() {return $this->telefone;}
    public function getCpf() {return $this->cpf;}

    public function setId($id){$this->id = $id;}
    public function setNome($nome){$this->nome = $nome;}
    public function setTelefone($telefone){$this->telefone = $telefone;}
    public function setCpf($cpf){$this->cpf = $cpf;}
}

?>