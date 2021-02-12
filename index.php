<?php

require_once("./vendor/autoload.php");

$loader = new \Twig\Loader\FilesystemLoader("./templates");

$twig = new \Twig\Environment($loader, ["debug" => true ]);
$twig->addExtension(new \Twig\Extension\DebugExtension());

require_once("lib/database.php");
require_once("lib/artikel.php");
require_once("lib/gebruiker.php");
require_once("lib/keuken_type.php");
require_once("lib/recept_info.php");
require_once("lib/ingredient.php");
require_once("lib/recept.php");
require_once("lib/boodschappenlijst.php");

$db = new database();
$conn = $db->getConnectie();
$recept_info = new recept_info($conn);
$recept = new recept($conn);
$boodschappenlijst = new boodschappenlijst($conn);

$artikel_id = isset($_GET['artikel_id']) ? $_GET['artikel_id'] : "";
$recept_id = isset($_GET['recept_id']) ? $_GET['recept_id'] : "";
$gebruiker_id = isset($_GET['gebruiker_id']) ? $_GET['gebruiker_id'] : "1";
$action = isset($_GET['action']) ? $_GET['action'] : "homepage";
$template = "";

switch($action) {
    
    //homepage
    case ("homepage"):
        $data = $recept->ophalenRecept($gebruiker_id);
        $template = 'homepage.html.twig';
        $title = 'homepage';
        break;
    
    //detailpagina 
    case ("detailpagina"):
        $data = $recept->ophalenRecept($gebruiker_id, $recept_id);
        $template = 'detail.html.twig';
        $title = 'detail pagina';
        break;

    //boodschappen
    case("boodschappen_toevoegen"):
        $boodschappenlijst->toevoegenRecept($recept_id, $gebruiker_id);
        header("Location: index.php?action=boodschappenlijst");
        break;

    case("artikel_verwijderen"):
        if(isset($_POST['artikel_id'])) {
            $artikel_id = $_POST['artikel_id'];
        }
        $boodschappenlijst->verwijderenArtikel($artikel_id, $gebruiker_id);
        break;

    case("lijst_verwijderen"):
        $boodschappenlijst->verwijderenLijst($gebruiker_id);
        header("Location: index.php?action=boodschappenlijst");
        break;

    case("boodschappenlijst"):
        $data = $boodschappenlijst->ophalenLijst($gebruiker_id);
        $template = 'boodschappenlijst.html.twig';
        $title = 'boodschappenlijst';
        break;
    
    case("min_artikel"):
        $artikel_id = $_POST['artikel_id'];
        $aantal_verpakkingen = $boodschappenlijst->minArtikel($artikel_id, $gebruiker_id);
        if($aantal_verpakkingen < 1) {
            header("Location: index.php?action=artikel_verwijderen&artikel_id=$artikel_id");
        }
        break;

    case("plus_artikel"):
        $artikel_id = $_POST['artikel_id'];
        $boodschappenlijst->plusArtikel($artikel_id, $gebruiker_id);
        break;

    //favoriet
    case("favoriet_wijzigen"):
        if($_POST['rating'] == "no") {
            $recept_info->toevoegenFavoriet($recept_id, $gebruiker_id);
        }
        else {
            $recept_info->verwijderenFavoriet($recept_id, $gebruiker_id);
        }
        
        break;

    case("favorieten_tonen"):
        $data = [];
        $recepten = $recept->ophalenRecept($gebruiker_id);
        foreach($recepten as $recept) {
            if($recept['mijn_favoriet']) {
                $data[] = $recept;
            }
        }
        $template = 'homepage.html.twig';
        $title = 'homepage';
        break;

    //score geven
    case('score_geven'):
        $score = $_POST['rating'];
        $recept_info->gevenScore($recept_id, $score);
        if (isset($_POST['rating'])) {
            $score = $_POST['rating'];
            echo "Score aangekomen: ";
            echo $score;
        }
        break;

    //zoeken 
    case("zoeken"):
        $keyword = $_POST['keyword'];
        $data = $recept->zoeken($keyword);
        $template = 'homepage.html.twig';
        $title = 'homepage';
        break;

    default:
        echo"Oops, something went wrong here!";
}

if($template) {

    $template = $twig->load($template);

    echo $template->render(["title" => $title, "data" => $data]);
}