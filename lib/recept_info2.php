<?php

require_once("lib/gebruiker.php");

class recept_info {

    private $connectie;
    private $gebruiker;

    public function __construct($connectie) {
        $this->connectie = $connectie;
        $this->gebruiker = new gebruiker($this->connectie);
        
    }

    public function selecteerReceptinfo($recept_id, $record_type) {
        $sql = "SELECT * FROM recept_info WHERE recept_id = $recept_id AND record_type = '$record_type'";
        $result = mysqli_query($this->connectie, $sql);
        $data = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if($row['gebruiker_id'] != NULL){
                $gebruiker_data = $this->selecteerGebruiker($row['gebruiker_id']);
                $array = []
            }

            $data[] = $row;
        }

        return($data);
    }
    private function 
}