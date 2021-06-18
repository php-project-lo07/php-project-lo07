
<!-- ----- debut ModelPatient -->

<?php
require_once 'Model.php';
require_once 'ModelCentre.php';
require_once 'ModelVaccin.php';

class ModelPatient{
 private $id, $nom, $prenom, $adresse;

 // pas possible d'avoir 2 constructeurs
 public function __construct($id = NULL, $nom = NULL, $prenom = NULL, $adresse = NULL) {
  // valeurs nulles si pas de passage de parametres
  if (!is_null($id)) {
   $this->id = $id;
   $this->nom = $nom;
   $this->prenom = $prenom;
   $this->adresse = $adresse;
  }
 }

 function setId($id) {
  $this->id = $id;
 }

 function setNom($nom) {
  $this->nom = $nom;
 }

 function setPrenom($prenom) {
  $this->prenom = $prenom;
 }

 function setAdresse($adresse) {
  $this->adresse = $adresse;
 }

 function getId() {
  return $this->id;
 }

 function getNom() {
  return $this->nom;
 }

 function getPrenom() {
  return $this->prenom;
 }

 function getAdresse() {
  return $this->adresse;
 }

// retourne une liste des id
 public static function getAllId() {
  try {
   $database = Model::getInstance();
   $query = "select id,nom, prenom from patient";
   $statement = $database->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelPatient");
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
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelPatient");
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }

 public static function getAll() {
  try {
   $database = Model::getInstance();
   $query = "select * from patient";
   $statement = $database->prepare($query);
   $statement->execute();
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelPatient");
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }

 public static function getOne($id) {
  try {
   $database = Model::getInstance();
   $query = "select * from patient where id = :id";
   $statement = $database->prepare($query);
   $statement->execute([
     'id' => $id
   ]);
   $results = $statement->fetchAll(PDO::FETCH_CLASS, "ModelPatient");
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }

  public static function getMedicalFolder($id) {
  try {
   $database = Model::getInstance();
   $query = "select * from rendezvous where patient_id = :id";
   $statement = $database->prepare($query);
   $statement->execute([
     'id' => $id
   ]);
   $results = $statement->fetchAll();
   return $results;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return NULL;
  }
 }
  public static function verifInjectionPatient($patient_id){
     try {
        $database = Model::getInstance();
     
        // ajout d'un nouveau tuple;
        $query = "SELECT EXISTS (SELECT * FROM `rendezvous` WHERE patient_id= :patient) AS verif";
        $statement = $database->prepare($query);
        $statement->execute([
          'patient' => $patient_id
        ]);
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        return $results["verif"];
    } catch (PDOException $e) {
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return NULL;
    } 
 }
   public static function verifVaccinationAvailable($patient_id){
     try {
        $database = Model::getInstance();
        $firstDose = ModelVaccin::getFirstVaccin($patient_id);
        foreach($firstDose as $elt){
            $doseMax= ModelVaccin::getMaxDose($elt->getId()); break;
        }
        // ajout d'un nouveau tuple;
        $query = "select max(injection) maxInjection from rendezvous where patient_id=:patient";
        $statement = $database->prepare($query);
        $statement->execute([
          'patient' => $patient_id
        ]);
        $results = $statement->fetch(PDO::FETCH_ASSOC);
        if($results['maxInjection']==$doseMax['doses'])
            return 1;
        elseif ($results['maxInjection']<$doseMax['doses']) 
            return 0;
    } catch (PDOException $e) {
        printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
        return NULL;
    } 
 }
 public static function insert($nom, $prenom, $adresse) {
  try {
   $database = Model::getInstance();

   // recherche de la valeur de la clé = max(id) + 1
   $query = "select max(id) from patient";
   $statement = $database->query($query);
   $tuple = $statement->fetch();
   $id = $tuple['0'];
   $id++;

   // ajout d'un nouveau tuple;
   $query = "insert into patient value (:id, :nom, :prenom, :adresse)";
   $statement = $database->prepare($query);
   $statement->execute([
     'id' => $id,
     'nom' => $nom,
     'prenom' => $prenom,
     'adresse' => $adresse
   ]);
   return $id;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return -1;
  }
 }
 
 public static function insertRDVPatient($centre, $vaccin, $patient) {
  try {
   $database = Model::getInstance();
   $nbreInjection=ModelCentre::getMaxInjection($patient); 
   if($nbreInjection['injection']==0)
       $dose=1;
   else{
       $dose=$nbreInjection['injection']+1;
   }
   $query = "insert into rendezvous value (:centre_id, :patient_id, :injection, :vaccin_id)";
   $statement = $database->prepare($query);
   $statement->execute([
     'centre_id' => $centre,
     'patient_id' => $patient,
     'injection' => $dose,
     'vaccin_id' => $vaccin
   ]);
   return 0;
  } catch (PDOException $e) {
   printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
   return -1;
  }
 }
//  public static function update($id,$doses) {
//     try {
//         $database = Model::getInstance();
     
//         // ajout d'un nouveau tuple;
//         $query = "update patient set doses = :doses where id = :id";
//         $statement = $database->prepare($query);
//         $statement->execute([
//           'id' => $id,
//           'doses' => $doses
//         ]);
//         return $id;
//     } catch (PDOException $e) {
//         printf("%s - %s<p/>\n", $e->getCode(), $e->getMessage());
//         return -1;
//     }
//  }

 public static function delete() {
  echo ("ModelVin : delete() TODO ....");
  return null;
 }

}
?>
<!-- ----- fin ModelPatient -->
