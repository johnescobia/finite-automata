<table>
  <?php
  $n = 0;
  $stateIndex = 0;
  $transitionIndex = 0;

  while ( $n < $totalFields ) {
    if ( $n%$columnsPerRow == 0 ) {
      echo "<tr>".PHP_EOL;
    }

    // First column of first row is always empty
    if ($n == 0) {
      echo "<td></td>".PHP_EOL;
    // The rest of the first row are alphabets
    } elseif ($n > 0 && $n < $columnsPerRow) {
      echo "<th>".$_SESSION['alphaSorted'][$n-1]."</th>".PHP_EOL;
    // The rest of the first columns are state names
    } elseif ($n%$columnsPerRow == 0 && $stateIndex < $totalObjects) {

      include "src/tableTitle.php";

    } else {
      include "src/tableInputs.php";
    }

    $n++;

    if ($n%$columnsPerRow == 0) {
      echo "</tr>".PHP_EOL;
    }
  }
  ?>
</table>
