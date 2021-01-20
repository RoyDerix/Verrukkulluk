<?php

class artikel {

    private $connectie;

    public function __construct($connectie) {
        $this->connectie = $connectie;
    }

    public function selecteerArtikel($artikel_id) {
        $sql = "SELECT * FROM artikel WHERE id = $artikel_id";
        $result = mysqli_query($this->connectie, $sql);
        $row = mysqli_fetch_array( $result , MYSQLI_ASSOC );

        return($row);
    }
}