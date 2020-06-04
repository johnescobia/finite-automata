<?php
$currState = $stateObject[$stateIndex];
$inputIndex = 0;

if ($type === 'dfa' && isset($shared)) {
  $title = $currState->label;
} else { // type = transitionTable and nfa
  $title = $currState->name;
}

if ($title == 'Z' && !isset($shared)) {
  echo "<td id=\"states\">Ø</td>".PHP_EOL;
} elseif ($currState->isStartState == 1 && $currState->isFinalState == 0) {
  echo "<td id=\"states\">> ".$title."</td>".PHP_EOL;
} elseif ($currState->isStartState == 0 && $currState->isFinalState == 1) {
  echo "<td id=\"states\">* ".$title."</td>".PHP_EOL;
} elseif ($currState->isStartState == 1 && $currState->isFinalState == 1) {
  echo "<td id=\"states\">>* ".$title."</td>".PHP_EOL;
} else {
  echo "<td id=\"states\"> ".$title."</td>".PHP_EOL;
}

$stateIndex++;
?>
