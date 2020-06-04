<?php
$temp = '';

if ($type === 'dfa' || $type === 'nfa') {
  $currInput = $_SESSION['alphaSorted'][$inputIndex];

  // Column identifier
  if ($type === 'dfa' && isset($shared)) { // type = dfarelabel and dfamin
    $temp = $currState->transitions[$currInput];
  } else { // type = nfa and dfa
    if (array_key_exists($currInput, $currState->transitions)) {
        $temp = implode(",", $currState->transitions[$currInput]);
    }
  }

  if ($temp == '') {
    echo "<td><input id=\"renderedInput\" type=\"text\" size=\"1\"";
    echo " value=\"Ø\" readonly></td>".PHP_EOL;
  } else {
    echo "<td><input id=\"renderedInput\" type=\"text\" size=\"1\"";
    echo " value=\"{ $temp }\" readonly></td>".PHP_EOL;
  }

  $inputIndex++;
} else { //type = transitionTable
  if (isset($_SESSION['submitTransition'])) {
    $temp = $_SESSION['transition'][$transitionIndex];

    if ($temp == '') {
      echo "<td><input id=\"renderedInput\" type=\"text\" size=\"1\"";
      echo " value=\"Ø\" readonly></td>".PHP_EOL;
    } else {
      insertTransition($title, $temp, $n, $stateObject);
      echo "<td><input id=\"renderedInput\" type=\"text\" size=\"1\"";
      echo " value=\"{ $temp }\" readonly></td>".PHP_EOL;
    }

    $transitionIndex++;
  } else {
    echo "<td><input type=\"text\" name=\"transition[]\" size=\"1\">";
    echo "</td>".PHP_EOL;
  }
}
?>
