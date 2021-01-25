<?php

class boodschappenlijst {

    private $connectie;
    private $recept;

    public function receptToevoegen($recept_id, $gebruiker_id = null) {

        $recept = $this->recept->ophalenRecept($gebruiker_id, $recept_id);
        $ingredienten = $recept[0]['ingredienten'];
        foreach($ingredienten as $ingredient) {

            $artikel_id = $ingredient["artikel_id"];
            $ingredienthoeveelheid = $ingredient["ingredienthoeveelheid"];
            $result = $this->artikelOpLijst($artikel_id, $gebruiker_id);
            if($result != false) {

                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $ingredienthoeveelheid = $row['ingredienthoeveelheid'] + $ingredient['ingredienthoeveelheid'];
                $aantal_verpakkingen = ceil($ingredienthoeveelheid / $ingredient['hoeveelheid']);
                $sql = "UPDATE boodschappen 
                        SET ingredienthoeveelheid = '$ingredienthoeveelheid', 
                            aantal_verpakkingen = '$aantal_verpakkingen'
                        WHERE artikel_id = $artikel_id AND gebruiker_id = $gebruiker_id";
                $result = mysqli_query($this->connectie, $sql);
            }

            else{
                
                $aantal_verpakkingen = ceil($ingredient['ingredienthoeveelheid'] / $ingredient['hoeveelheid']);
                $sql = "INSERT INTO boodschappen (artikel_id, gebruiker_id, ingredienthoeveelheid, aantal_verpakkingen)
                VALUES ('$artikel_id', '$gebruiker_id', '$ingredienthoeveelheid', '$aantal_verpakkingen')";
                $result = mysqli_query($this->connectie, $sql);   
            }
        }
    }

    private function artikelOpLijst($artikel_id, $gebruiker_id) {
        $sql = "SELECT * FROM boodschappen WHERE artikel_id = $artikel_id AND gebruiker_id = $gebruiker_id";
        $result = mysqli_query($this->connectie, $sql);

        if(mysqli_num_rows($result) > 0) {
            return($result);
        }

        else {
            return false;
        }

    }

    public function __construct($connectie) {
        $this->connectie = $connectie;
        $this->recept = new recept($this->connectie);
    }
}