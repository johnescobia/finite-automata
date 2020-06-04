<?php
$n = 0;
$stateIndex = 0;
$transitionIndex = 0;

$label = 'A';

$type = 'dfa';
$stateObject = $dfa;
$totalFields = (count($stateObject) + 1) * (count($_SESSION['alphaSorted']) + 1);
$columnsPerRow = count($_SESSION['alphaSorted']) + 1;
$totalObjects = count($stateObject) + 1;

echo "<h4>DFA Table</h4>";

echo "<table>";
  while ( $n < $totalFields ) {
    if ( $n%$columnsPerRow == 0 ) {
      echo "<tr>".PHP_EOL;
    }

    // First column of first row is always label
    if ($n == 0) {
      echo "<th id=\"newLabel\">Label</th>".PHP_EOL;
    // The rest of the first column are labels
    } elseif ($n%$columnsPerRow == 0) {
      if ($stateObject[$stateIndex]->name == 'Z') {
        echo "<th id=\"newLabel\">Z</th>".PHP_EOL;
      } else {
        echo "<th id=\"newLabel\">".$label."</th>".PHP_EOL;
        $label++;
      }
    // Second column of first row is always empty
    } elseif ($n == 1) {
      echo "<th id=\"newLabel\"></th>".PHP_EOL;
    // The rest of the first row are alphabets
    } elseif ($n > 0 && $n < $columnsPerRow) {
      echo "<th>".$_SESSION['alphaSorted'][$n-2]."</th>".PHP_EOL;
    // The rest of the second columns are state names
    } elseif ($n%$columnsPerRow == 1 && $stateIndex < $totalObjects) {

      include "src/tableTitle.php";

    } else {
      include "src/tableInputs.php";
    }

    $n++;

    if ($n%$columnsPerRow == 0) {
      echo "</tr>".PHP_EOL;
    }
  }
echo "</table>".PHP_EOL;
?>
