
<!-- ----- début viewAll -->
<?php

require ($root . '/app/view/fragment/fragmentCovidHeader.html');
?>

<body>
  <div class="container">
      <?php
      include $root . '/app/view/fragment/fragmentCovidMenu.html';
      include $root . '/app/view/fragment/fragmentCovidJumbotron.html';
      function input($id){
          $string="<form role='form' method='get' action='router1.php'>
               <input type=hidden name=action value=centreUpdateStock >
              <input type=hidden name=centre value=$_GET[id]>
              <input type=hidden name=vaccin value=$id>
              <input type=number name='nbreDose'> <button class='btn btn-primary' type='submit'>Metre à jour</button>
              </form>"; 
          return $string;
      }
      ?>

    
    <table class = "table table-striped table-bordered">
      <thead>
        <tr>
          <th scope = "col">id</th>
          <th scope = "col">label</th>
          <th scope = "col">Nombre</th>
        </tr>
      </thead>
      <tbody>
          <?php
          // La liste des vins est dans une variable $results             
          foreach ($results as $element) {
           printf("<tr><td>%d</td><td>%s</td><td>%s</td></tr>", $element->getId(), 
             $element->getLabel(), input($element->getId()));
          }
          ?>
      </tbody>
    </table>

  </div>
  <?php include $root . '/app/view/fragment/fragmentCovidFooter.html'; ?>

  <!-- ----- fin viewAll -->
  
  
  