
<?php

require ($root . '/app/view/fragment/fragmentCovidHeader.html');
?>

<body>
  <div class="container">
      <?php
      include $root . '/app/view/fragment/fragmentCovidMenu.html';
      include $root . '/app/view/fragment/fragmentCovidJumbotron.html';
      ?>

    <form role="form" method='get' action='router1.php'>
      <div class="form-group">
          <input type="hidden" name='action' value="vaccinValidate" >
          <input type="hidden" name='centre' value=<?php echo $_GET['id']; ?> >
          <input type="hidden" name='patient' value=<?php echo $_GET['patient']; ?> >
         <?php if(count($results)==1){ foreach ($results as $element) { ?>
            <input type="hidden" name='vaccin' value=<?php echo $element->getId(); ?> >
            <label for="id">Le vaccin à recevoir dans ce centre : </label> <input class="form-control" id='id' value='<?php echo $element->getLabel(); ?>' style="width: 200px">
         <?php } }else{ ?>
         <label for="id">Patient oas encore vacciné, choisissez un vaccin : </label> <select class="form-control" id='id' name='vaccin' style="width: 200px">
            <?php
            foreach ($results as $element) {
            // echo ("<option value='$elt->getId()'>$elt->getLabel()</option>");
             printf("<option value='%d' >%s</option>", $element->getId(), 
             $element->getLabel());
            }
            ?>
        </select>           
         <?php } ?>
      </div>
      <p/>
      <button class="btn btn-primary" type="submit">Valider ce vaccin</button>
    </form>
    <p/>
  </div>

 <?php include $root . '/app/view/fragment/fragmentCovidFooter.html'; ?>
