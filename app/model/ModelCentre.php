
<!-- ----- debut ModelCentre -->

<?php
require_once 'Model.php';

class ModelCentre {
 public $id, $label, $adresse;

 // pas possible d'avoir 2 constructeurs
 public function __construct($id = NULL, $label = NULL, $adresse = NULL) {
  // valeurs nulles si pas de passage de parametres
  if (!is_null($id)) {
   $this->id = $id;
   $this->label = $label;
   $this->adresse = $adresse;
  }
 }

 function setId($id) {
  $this->id = $id;
 }

 function setLabel($label) {
  $this->label = $label;
 }

 function setAdresse($adresse) {
  $this->adresse = $adresse;
 }

 function getId() {
  return $this->id;
 }

 function getLabel() {
  return $this->label;
 }

 function getAdresse() {
  return $this->adresse;
 }

// retourne une liste des id
 public static function getAllId() {
  try {
   $database = Model::getInstance();
   $query = "select id,label from centre";
   $statement = $database->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }

 public static function getMany($query) {
  try {
   $database = Model::getInstance();
   $statement = $database->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }

 public static function getAll() {
  try {
   $database = Model::getInstance();
   $query = "select * from centre";
   $statement = $database->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }
 public static function getVaccinéParCentre() {
    try{
        $database = Model::getInstance();
        $query = "select centre.label as label_centre, count(distinct rendezvous.patient_id) as nombre from `centre`,`rendezvous` where centre.id=rendezvous.centre_id group by rendezvous.centre_id;";
        $results = array();
        $select = $database->query($query);
        while($tuple = $select->fetch()){
           array_push($results,$tuple);
        }
        return $results;
    }catch(PDOException $e){
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return NULL;  
    }
 }
 
 public static function getOne($id) {
  try {
   $database = Model::getInstance();
   $query = "select * from centre where id = :id";
   $statement = $database->prepare($query);
   $statement->execute([
     'id' => $id
   ]);
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }

 public static function getRdvCentres() {
  try{
      $database = Model::getInstance();
      $query = "SELECT centre.label, count(centre_id) FROM `rendezvous`,`centre` WHERE centre_id=centre.id group by centre_id";
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
 
  public static function getCentreDisp($id) {
  try {
    $database = Model::getInstance();
    $verif=ModelCentre::getMaxInjection($id);
   if($verif['injection']==1){
        $query = "select id,label FROM `centre` where id in (select centre_id from `stock` where quantite > 0 and vaccin_id in (select vaccin_id from `rendezvous` where patient_id = :id));";
        $statement = $database->prepare($query);
        $statement->execute([
            'id' => $id
        ]);
        $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
   }else{
       
   }
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }
 public static function getMaxInjection($id){
   $database = Model::getInstance();
   $query = "select max(injection) as injection from rendezvous where patient_id = :id";
   $statement = $database->prepare($query);
   $statement->execute([
     'id' => $id
   ]);
   $verif = $statement->fetch(PDO::FETCH_ASSOC);
   return $verif;
 }
 public static function insert($label, $adresse) {
  try {
   $database = Model::getInstance();

   // recherche de la valeur de la clé = max(id) + 1
   $query = "select max(id) from centre";
   $statement = $database->query($query);
   $tuple = $statement->fetch();
   $id = $tuple['0'];
   $id++;

   // ajout d'un nouveau tuple;
   $query = "insert into centre value (:id, :label, :adresse)";
   $statement = $database->prepare($query);
   $statement->execute([
     'id' => $id,
     'label' => $label,
     'adresse' => $adresse
   ]);
   return $id;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return -1;
  }
 }

 public static function update($id,$doses) {
    try {
        $database = Model::getInstance();
     
        // ajout d'un nouveau tuple;
        $query = "update centre set adresse = :adresse where id = :id";
        $statement = $database->prepare($query);
        $statement->execute([
          'id' => $id,
          'doses' => $doses
        ]);
        return $id;
    } catch (PDOException $e) {
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return -1;
    }
 }

 public static function updateStockVaccin($centre_id, $vaccin_id, $nbreDose){
     //SELECT EXISTS (SELECT * FROM `stock` WHERE centre_id=1 AND vaccin_id=3) AS verif
    try {
        $database = Model::getInstance();
        $query ="select quantite from stock where centre_id= :centre and vaccin_id= :vaccin";
        $statement = $database->prepare($query);
        $statement->execute([
          'centre' => $centre_id,
          'vaccin' => $vaccin_id
        ]);
        $results = $statement->fetch();
        $quantite=$results["quantite"]+$nbreDose;
        // ajout d'un nouveau tuple;
        $query = "update stock set quantite = :quantite where centre_id= :centre and vaccin_id= :vaccin";
        $statement = $database->prepare($query);
        $statement->execute([
          'quantite' => $quantite,
          'centre' => $centre_id,
          'vaccin' => $vaccin_id
        ]);
        return 0;
    } catch (PDOException $e) {
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return -1;
    }    
 }
  public static function addStockVaccin($centre_id, $vaccin_id, $nbreDose){
    try {
        $database = Model::getInstance();
        $query = "insert into stock value (:centre_id, :vaccin_id, :quantite)";
        $statement = $database->prepare($query);
        $statement->execute([
            'centre_id' => $centre_id,
            'vaccin_id' => $vaccin_id,
            'quantite' => $nbreDose
        ]);
        return 0;
    } catch (PDOException $e) {
            printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
            return -1;
    }    
 }
 public static function verifStockVaccin($centre_id, $vaccin_id){
     try {
        $database = Model::getInstance();
     
        // ajout d'un nouveau tuple;
        $query = "SELECT EXISTS (SELECT * FROM `stock` WHERE centre_id= :centre AND vaccin_id= :vaccin) AS verif";
        $statement = $database->prepare($query);
        $statement->execute([
          'centre' => $centre_id,
          'vaccin' => $vaccin_id
        ]);
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results["verif"];
    } catch (PDOException $e) {
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return NULL;
    } 
 }
public static function centreDisponible(){
  try {
   $database = Model::getInstance();
   $query = "select id,label from `centre` where id in (select distinct centre_id from `stock` where stock.quantite > 0)";
   $statement = $database->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelCentre");
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }    
}
 public static function delete() {
  echo ("ModelVin : delete() TODO ....");
  return null;
 }

}
?>
<!-- ----- fin ModelCentre -->
