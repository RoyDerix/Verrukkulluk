<?php

class recept {

    private $connectie;
    private $recept_info;
    private $ingredienten;

    public function selecteerRecept($recept_id) {

        $gem_score = $this->berekenenScore($recept_id);
        $ingredienten = $this->ophalenIngredienten($recept_id);
        $totale_prijs = $this->berekenenPrijs($recept_id);
        $totale_calorieen = $this->berekenCalorieen($recept_id);

        $recept = [
            "score"=>$gem_score,
            "totale_prijs"=>$totale_prijs,
            "totale_calorieen"=>$totale_calorieen,
            "ingredienten"=>$ingredienten,
        ];

        return($recept);
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
    }
}
