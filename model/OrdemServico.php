<?php

class OrdemServico{
    private $id;
    private $id_cliente;
    private $id_carro;
    private $id_funcionario;
    private $valor;
    private $descricao;
    private $kminicial;
    private $kmfinal;

    public function getId() {return $this->id;}
    public function getId_cliente() {return $this->id_cliente;}
    public function getId_carro() {return $this->id_carro;}
    public function getId_funcionario() {return $this->id_funcionario;}
    public function getValor() {return $this->valor;}
    public function getDescricao() {return $this->descricao;}
    public function getKminicial() {return $this->kminicial;}
    public function getKmfinal() {return $this->kmfinal;}

    public function setId($id){$this->id = $id;}
    public function setId_cliente($id){$this->id_cliente = $id;}
    public function setId_carro($id){$this->id_carro = $id;}
    public function setId_funcionario($id){$this->id_funcionario = $id;}
    public function setValor($valor){$this->valor = $valor;}
    public function setDescricao($descricao){$this->descricao = $descricao;}
    public function setKminicial($kminicial){$this->kminicial = $kminicial;}
    public function setKmfinal($kmfinal){$this->kmfinal = $kmfinal;}
   
}

?>