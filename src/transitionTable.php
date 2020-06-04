<?php
include "stateObject.php";

if (isset($_SESSION['submitTransition'])) {
  $stateObject = unserialize($_SESSION['states']);
} elseif (isset($_POST['submitTransition'])) {
  $stateObject = unserialize($_SESSION['states']);
  $_SESSION['transition'] = $_POST['transition'];
  $_SESSION['submitTransition'] = $_POST['submitTransition'];
} else {
  $_SESSION['alphaSorted'] = $_SESSION['alpha'];
  $_SESSION['stateSorted'] = $_SESSION['state'];

  popNullAndReindex ( $_SESSION['alphaSorted'] );
  popNullAndReindex ( $_SESSION['stateSorted'] );

  $stateObject = array();

  // Insert states to stateObject
  foreach ( $_SESSION['stateSorted'] as $state ) {
    array_push( $stateObject, new State( $state ) );
  }

  // Insert starting state in stateObject array
  foreach ( $stateObject as $state ) {
    if ( $state->name == $_SESSION['startState'] ) {
      $state->isStartState = 1;
    }
  }

  // Insert final states in stateObject array
  foreach ($_SESSION['finalState'] as $state) {
    foreach ($stateObject as $stateCheck) {
      if ($stateCheck->name === $state) {
        $stateCheck->isFinalState = 1;
      }
    }
  }

  $totalAlphabets = count($_SESSION['alphaSorted']);
  $totalColumns = $totalAlphabets + 1;

  $_SESSION['totalObjects'] = count($stateObject);
  $totalRows = $_SESSION['totalObjects'] + 1;

  $_SESSION['columnsPerRow'] = $totalAlphabets + 1;
  $_SESSION['totalFields'] = $totalColumns * $totalRows;
}

$totalFields =$_SESSION['totalFields'];
$columnsPerRow = $_SESSION['columnsPerRow'];
$totalObjects = $_SESSION['totalObjects'];
$type = 'transitionTable';

echo "<h4>Transition Table</h4>";

echo "<form method=\"POST\">";

  include "src/table.php";

  // Create a storable representation of $stateObject array
  // and store in session to be used in the next session
  $_SESSION['states'] = serialize($stateObject);

  if (!isset($_SESSION['submitTransition'])) {
    echo "<p>".PHP_EOL;
      echo "<input type=\"submit\" name=\"submitTransition\"";
      echo "value=\"Submit transitions\">".PHP_EOL;
    echo "</p>".PHP_EOL;
  }

echo "</form>".PHP_EOL;

// Delete null index and reindex array
function popNullAndReindex ( &$arrayToSort ) {
  foreach (array_keys($arrayToSort, null) as $key) {
    unset( $arrayToSort[$key] );

  }

  $arrayToSort = array_values( $arrayToSort );

  // Append Ɛ if array is array of alphabets
  if ( $arrayToSort == $_SESSION['alphaSorted'] ) {
    array_push( $arrayToSort, 'Ɛ' );
  }
}

function insertTransition ($state, $transition, $counter, $stateObject) {
  $alphaIndex = $counter%$_SESSION['columnsPerRow'];
  $alphaKey = $_SESSION['alphaSorted'][$alphaIndex-1];

  $alphaArray = array();
  $transitionLength = strlen($transition);

  for ($i=0; $i < $transitionLength; $i++) {
    if (ctype_alpha($transition[$i])) {
      array_push($alphaArray, $transition[$i]);
    }
  }

  foreach ($stateObject as $object) {
    if ($object->name == $state) {
      $object->transitions[$alphaKey] = $alphaArray;
    }
  }
}
?>
