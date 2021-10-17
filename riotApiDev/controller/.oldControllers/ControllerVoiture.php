<?php
require_once(File::build_path(array("model","ModelVoiture.php")));
require_once(File::build_path(array("model","Model.php")));
class ControllerVoiture {
    public static function readAll() {
        $tab_v = ModelVoiture::getAllVoitures();     //appel au modèle pour gerer la BD
        $controller='voiture';
        $view='list';
        $pagetitle='Liste des voitures';
        require(File::build_path(array("view","view.php")));
    }
    public static function read(){
    	$v = ModelVoiture::getVoitureByImmat($_GET['immat']);
    	$controller='voiture';
        $view='detail';
        $pagetitle='Détail d\'une voiture';
        require(File::build_path(array("view","view.php")));
    }
    public static function create(){
        $controller='voiture';
        $view='create';
        $pagetitle='Créer une voiture';
        require(File::build_path(array("view","view.php")));
    }
    public static function created(){
    	$m = $_GET['marque'];
    	$c = $_GET['couleur'];
    	$i = $_GET['immatriculation'];
        $v = new ModelVoiture($m,$c,$i);
        $test = $v->save();
        if($test == false){
            require(File::build_path(array("view","error","duplicatedKey.php")));
        }elseif ($test == true) {
            self::readAll();
        }
    }
    public static function delete(){
        $immat = $_GET['immat'];
        $test = ModelVoiture::delete($immat);
        if($test == false){
            echo "error";
        }elseif($test == true){
            self::readAll();
        }
    } 
}
?>
