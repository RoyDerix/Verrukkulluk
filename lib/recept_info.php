<?php

require_once("lib/gebruiker.php");

class recept_info {

    private $connectie;
    private $gebruiker;

    public function gevenScore($recept_id, $score) {
        $sql = "INSERT INTO recept_info (recept_id, record_type, datum, nummeriekveld)
                VALUES ('$recept_id', 'S', NOW(), '$score')";
        $result = mysqli_query($this->connectie, $sql);
    }

    public function toevoegenFavoriet($recept_id, $gebruiker_id) {

        $this->verwijderenFavoriet($recept_id, $gebruiker_id);

        $sql = "INSERT INTO recept_info (recept_id, gebruiker_id, record_type, datum) 
                VALUES ('$recept_id', '$gebruiker_id', 'F', NOW())";
        $result = mysqli_query($this->connectie, $sql);  
    }

    public function verwijderenFavoriet($recept_id, $gebruiker_id) {

        $sql = "DELETE FROM recept_info WHERE gebruiker_id = $gebruiker_id 
                                        AND recept_id = $recept_id
                                        AND record_type = 'F'";
        $result = mysqli_query($this->connectie, $sql);
    }

    public function selecteerReceptinfo($recept_id, $record_type) {

        $sql = "SELECT * FROM recept_info WHERE recept_id = $recept_id 
                AND record_type = '$record_type'";
        $result = mysqli_query($this->connectie, $sql);
        $data = [];

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            if(($row['record_type'] == "O") or ($row['record_type'] == "F")) {

                $user = $this->selecteerGebruiker($row['gebruiker_id']);
                $data[] = ["id"=>$row["id"],
                            "gebruiker_id"=>$user["id"],
                            "gebruiker_naam"=>$user["gebruiker_naam"],
                            "email"=>$user["email"],
                            "gebruiker_foto"=>$user["gebruiker_foto"],
                            "recept_id"=>$row["recept_id"],
                            "record_type"=>$row["record_type"],
                            "datum"=>$row["datum"],
                            "nummeriekveld"=>$row["nummeriekveld"],
                            "tekstveld"=>$row["tekstveld"]
                        ];
            }
            
            else {
                $data[] = $row;
            }
        }

        return($data);
    }
    private function selecteerGebruiker($gebruiker_id) {

        $gebruiker_data = $this->gebruiker->selecteerGebruiker($gebruiker_id);
        return($gebruiker_data);
    }

    public function __construct($connectie) {

        $this->connectie = $connectie;
        $this->gebruiker = new gebruiker($this->connectie); 
    }
}