
<!-- ----- debut ModelCentreVacccin -->

<?php
require_once 'Model.php';


class ModelCentreVaccin {

 public static function getDosesCentre() {
    try{
        $database = Model::getInstance();
        $query = "select centre.label as label_centre, vaccin.label as label_vaccin, stock.quantite as quantite from centre, vaccin,stock where centre.id=stock.centre_id and vaccin.id=stock.vaccin_id";
        $results = array();
        $selectRecolte = $database->query($query);
        while($tuple = $selectRecolte->fetch()){
           array_push($results,$tuple);
        }
        return $results;
    }catch(PDOException $e){
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return NULL;  
    }
 }

 public static function getDosesGlobal() {
    try{
        $database = Model::getInstance();
        $query = "select centre.label as label_centre, sum(stock.quantite) as doses_globales from stock, centre where centre.id=stock.centre_id group BY centre.label";
        $results = array();
        $selectRecolte = $database->query($query);
        while($tuple = $selectRecolte->fetch()){
           array_push($results,$tuple);
        }
        return $results;
    }catch(PDOException $e){
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return NULL;  
    }
 }
}
?>
<!-- ----- fin ModelCentreVaccin -->
