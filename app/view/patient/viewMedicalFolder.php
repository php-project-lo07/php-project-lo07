
<?php

require ($root . '/app/view/fragment/fragmentCovidHeader.html');
?>

<body>
  <div class="container">
      <?php
      include $root . '/app/view/fragment/fragmentCovidMenu.html';
      include $root . '/app/view/fragment/fragmentCovidJumbotron.html';
      ?>

    <table class = "table table-striped table-bordered">
      <thead>
        <tr>
          <th scope = "col">label_centre</th>
          <th scope = "col">label_vaccin</th>
          <th scope = "col">injection</th>
        </tr>
      </thead>
      <tbody>
          <?php
          // La liste des vins est dans une variable $results 
                   
          
            foreach($results as $value){
                echo('<tr>'); 
                        foreach($value as $subKey => $subValue){
                            if(is_string($subKey)){
                                echo('<td>');
                                echo($subValue);  
                                echo('</td>');
                            }
                        }
                
                echo('</tr>');
    } 
          
          ?>
      </tbody>
    </table>
  </div>
  <?php include $root . '/app/view/fragment/fragmentCovidFooter.html'; ?>


  
  
  