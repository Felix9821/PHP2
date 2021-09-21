<?php

include_once 'db.php';

//insercion codigo unido
class Survey extends DB{

    private $totalVotes;
    private $optionSelected;

    public function setOptionSelected($option){
        $this->optionSelected = $option;
    }
    public function getOptionSelected(){
        return $this->optionSelected;
    }
//division de las diversas partes para seccionar los servicios.
    public function vote(){
        $query = $this->connect()->prepare('UPDATE lenguajes SET votos = votos + 1 WHERE opcion = :opcion');
        $query->execute(['opcion' => $this->optionSelected]);
    }

    public function showResults(){
        return $this->connect()->query('SELECT * FROM lenguajes');
    }

    public function getTotalVotos(){
        $querySum = $this->connect()->query('SELECT SUM(votos) AS votos_totales  FROM lenguajes');
        $this->totalVotes = $querySum->fetch(PDO::FETCH_OBJ)->votos_totales;

        return $this->totalVotes;
    }

    public function getPercentageVotes($option){
        return round(($option / $this->totalVotes) * 100, 0);
    }
}

?>