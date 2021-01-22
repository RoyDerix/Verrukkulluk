<?php

class recept {

    private $connectie;
    private $recept_info;
    private $ingredienten;
    private $favoriet;
    private $keuken_type;
    private $gebruiker;

    public function ophalenRecept($recept_id, $gebruiker_id) {

        $recept = $this->selecteerRecept($recept_id);
        $gem_score = $this->berekenenScore($recept_id);
        $ingredienten = $this->ophalenIngredienten($recept_id);
        $totale_prijs = $this->berekenenPrijs($recept_id);
        $totale_calorieen = $this->berekenCalorieen($recept_id);
        $mijnFavoriet = $this->vergelijkenFavoriet($recept_id, $gebruiker_id);
        $keuken = $this->ophalenKeuken($recept_id);
        $type = $this->ophalenType($recept_id);
        $gebruiker = $this->ophalenGebruiker($recept_id);
        $bereidingswijze = $this->ophalenBereidingswijze($recept_id);
        $opmerkingen = $this->ophalenOpmerkingen($recept_id);

        $receptTotaal = [
            "id"=>$recept['id'],
            "titel_recept"=>$recept['titel_recept'],
            "keuken"=>$keuken['omschrijving'],
            "type"=>$type['omschrijving'],
            "auteur"=>$gebruiker['gebruiker_naam'],
            "receptbeschrijving"=>$recept['receptbeschrijving'],
            "samenvatting_beschrijving"=>$recept['samenvatting_beschrijving'],
            "receptfoto"=>$recept['receptfoto'],
            "datum_toegevoegd"=>$recept['datum_toegevoegd'],
            "score"=>$gem_score,
            "totale_prijs"=>$totale_prijs,
            "totale_calorieen"=>$totale_calorieen,
            "mijn_favoriet"=>$mijnFavoriet,
            "ingredienten"=>$ingredienten,
            "bereidingswijze"=>$bereidingswijze,
            "opmerkingen"=>$opmerkingen
        ];

        return($receptTotaal);
    }

    private function ophalenGebruiker($recept_id) {

        $recept = $this->selecteerRecept($recept_id);
        $gebruiker_id = $recept['gebruiker_id'];
        $gebruiker = $this->gebruiker->selecteerGebruiker($gebruiker_id);

        return($gebruiker);
    }

    private function ophalenType($recept_id) {

        $recept = $this->selecteerRecept($recept_id);
        $type_id = $recept['type_id'];
        $type = $this->keuken_type->selecteerKeukenType($type_id);

        return($type);
    }

    private function ophalenKeuken($recept_id) {

        $recept = $this->selecteerRecept($recept_id);
        $keuken_id = $recept['keuken_id'];
        $keuken = $this->keuken_type->selecteerKeukenType($keuken_id);

        return($keuken);
    }

    private function vergelijkenFavoriet($recept_id, $gebruiker_id) {
        
        $mijnFavoriet = FALSE;
        $favorieten = $this->ophalenReceptinfo($recept_id, "F");
        foreach($favorieten as $favoriet) {
            if ($favoriet['gebruiker_id'] == $gebruiker_id) {
                $mijnFavoriet = TRUE;
            }
        }

        return($mijnFavoriet);
    }

    private function berekenCalorieen($recept_id) {

        $totale_calorieen = 0;
        $ingredienten = $this->ophalenIngredienten($recept_id);

        foreach($ingredienten as $ingredient) {
            $aantal_verpakkingen = $ingredient['ingredienthoeveelheid'] / $ingredient['hoeveelheid'];
            $calorieen_per_ingredient = $aantal_verpakkingen * $ingredient['calorieen_per_artikel'];
            $totale_calorieen += $calorieen_per_ingredient;
        }

        return(round($totale_calorieen));
    }

    private function berekenenPrijs($recept_id) {

        $totale_prijs = 0;
        $ingredienten = $this->ophalenIngredienten($recept_id);

        foreach($ingredienten as $ingredient) {
            $aantal_verpakkingen = ceil($ingredient['ingredienthoeveelheid'] / $ingredient['hoeveelheid']);
            $prijs_ingredient = $aantal_verpakkingen * $ingredient['prijs_per_artikel'];
            $totale_prijs += $prijs_ingredient;
        }

        return(round($totale_prijs, 2));
    }

    private function berekenenScore($recept_id) {

        $som_scores = 0;
        $aantal_scores = 0;
        $data_scores = $this->ophalenReceptinfo($recept_id, "S");
        foreach($data_scores as $data_score) {
            $som_scores += $data_score['nummeriekveld'];
            $aantal_scores++;
        }
        $gem_score = round($som_scores / $aantal_scores);
        return($gem_score);
    }

    private function selecteerRecept($recept_id) {
        
        $sql = "SELECT * FROM recept WHERE id = $recept_id"; 
        $result = mysqli_query($this->connectie, $sql);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return($row);
    }

    private function ophalenBereidingswijze($recept_id) {
        $bereidingswijze = $this->ophalenReceptinfo($recept_id, "B");
        return($bereidingswijze);
    }

    private function ophalenOpmerkingen($recept_id) {
        $opmerkingen = $this->ophalenReceptinfo($recept_id, "O");
        return($opmerkingen);
    }

    private function ophalenIngredienten($recept_id) {
        $data_ingredienten = $this->ingredienten->selecteerIngredient($recept_id);
        return($data_ingredienten);
    }

    private function ophalenReceptinfo($recept_id, $record_type) {
        $data_scores = $this->recept_info->selecteerReceptinfo($recept_id, $record_type);
        return($data_scores);
    }

    public function __construct($connectie) {
        $this->connectie = $connectie;
        $this->recept_info = new recept_info($this->connectie);
        $this->ingredienten = new ingredient($this->connectie);
        $this->keuken_type = new keuken_type($this->connectie);
        $this->gebruiker = new gebruiker($this->connectie);
    }
}