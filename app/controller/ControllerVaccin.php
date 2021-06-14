
<!-- ----- debut ControllerVaccin -->
<?php
require_once '../model/ModelVaccin.php';

class ControllerVaccin {

    public static function vaccinReadAll() {
    $results = ModelVaccin::getAll();
    // ----- Construction chemin de la vue
    include 'config.php';
    $vue = $root . '/app/view/vaccin/viewAll.php';
    if (DEBUG)
    echo ("ControllerVaccin : vinReadAll : vue = $vue");
    require ($vue);
    }

    public static function vaccinCreate() {
    // ----- Construction chemin de la vue
    include 'config.php';
    $vue = $root . '/app/view/vaccin/viewInsert.php';
    require ($vue);
    }

    public static function vaccinCreated() {
    $results = ModelVaccin::insert(
        htmlspecialchars($_GET['label']), htmlspecialchars($_GET['doses'])
    );
    // ----- Construction chemin de la vue
    include 'config.php';
    $vue = $root . '/app/view/vaccin/viewInserted.php';
    require ($vue);
    }
   public static function vaccinUpdate() {
     $results = ModelVaccin::getAllId();

    // ----- Construction chemin de la vue
    include 'config.php';
    $vue = $root . '/app/view/vaccin/viewUpdate.php';
    require ($vue);
   }
  
   public static function vaccinUpdated() {

    $results = ModelVaccin::update(
        htmlspecialchars($_GET['id']),htmlspecialchars($_GET['doses'])
    );
    // ----- Construction chemin de la vue
    include 'config.php';
    $vue = $root . '/app/view/vaccin/viewUpdated.php';
    require ($vue);
   }
 
}
?>
<!-- ----- fin ControllerVaccin -->


