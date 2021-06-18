
<!-- ----- debut ControllerPatient -->
<?php
require_once '../model/ModelPatient.php';
require_once '../model/ModelCentre.php';
require_once '../model/ModelVaccin.php';

class ControllerPatient {
 public static function patientReadAll() {
  $results = ModelPatient::getAll();
  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/patient/viewAll.php';
  if (DEBUG)
   echo ("ControllerPatient : vinReadAll : vue = $vue");
  require ($vue);
 }

 // Affiche le formulaire de creation d'un vaccin
 public static function patientCreate() {
  include 'config.php';
  $vue = $root . '/app/view/patient/viewInsert.php';
  require ($vue);
 }
 public static function patientReadId() {
  $results = ModelPatient::getAllId();

  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/patient/viewId.php';
  require ($vue);
 }
 
  public static function patientCentreDispo() {
  $results = ModelPatient::verifInjectionPatient($_GET['id']);
  if($results){
      $verif=ModelPatient::verifVaccinationAvailable($_GET['id']);
      if($verif)
          ControllerPatient::patientDossierMedical($_GET['id']);
      else{
          $results=ModelCentre::getCentreDisp($_GET['id']);
          include 'config.php';
          $vue = $root . '/app/view/patient/viewCentreDispo.php';
          require ($vue);
      }
  }else{
       $results=ModelCentre::centreDisponible();
        include 'config.php';
        $vue = $root . '/app/view/patient/viewCentreDispo.php';
        require ($vue);
  }
  
 }
public static function patientDossierMedical($id) {
    $results = ModelPatient::getMedicalFolder($id);
    include 'config.php';
    $vue = $root . '/app/view/patient/viewMedicalFolder.php';
    require ($vue);
 }
 
 public static function patientVacciné() {
    $results = ModelPatient::getPatientVacciné();
    include 'config.php';
    $vue = $root . '/app/view/patient/viewAll.php';
    require ($vue);
 }
 
  public static function patientvaccinArecevoir() {
  $verif = ModelPatient::verifInjectionPatient($_GET['patient']);
  if($verif)
      $results=ModelVaccin::getFirstVaccin($_GET['patient']);      
  else
      $results = ModelVaccin::getVaccinMaxNbreDose($_GET['id']);
  include 'config.php';
  $vue = $root . '/app/view/vaccin/viewVaccinArecevoir.php';
  require ($vue);
 }
 
 public static function patientCreated() {
  $results = ModelPatient::insert(
      htmlspecialchars($_GET['nom']), htmlspecialchars($_GET['prenom']),htmlspecialchars($_GET['adresse'])
  );
  // ----- Construction chemin de la vue
  include 'config.php';
  $vue = $root . '/app/view/patient/viewInserted.php';
  require ($vue);
 }
}
?>
<!-- ----- fin ControllerPatient -->


