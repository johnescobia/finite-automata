<!-- Start a session -->
<?php
session_start();
include "src/conditions.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
    <div id="leftbox">
      <?php include "src/mainForm.html" ?>

      <div id="leftbox">
        <?php
          if ( (isset($_POST['submitNFA'] ) && !is_null( $_POST['alpha'][0]))
            || funcCondtions() ) {
            include "src/transitionTable.php";
          }
        ?>
      </div>
    </div>

    <div id="middlebox">
      <?php (funcCondtions()) ? include "src/functionBar.html" : '' ?>
    </div>

    <div id="leftbox">
      <?php include "src/functionDisplay.php" ?>
    </div>
  </body>
</html>
