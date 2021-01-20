<?php

class keuken_type {

    private $connectie;

    public function __construct($connectie) {
        $this->connectie = $connectie;
    }

    public function selecteerKeukenType($keuken_type_id){
        $sql = "SELECT * FROM keuken_type WHERE id = $keuken_type_id";
        $result = mysqli_query($this->connectie, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($row);
    }
}