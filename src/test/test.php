<?php
// Input to be tested
$stringInput = $_POST['userInput'];

// Assign start state
$startState = new State('');
foreach ($nfa as $state) {
  if ($state->isStartState == 1) {
    $startState = $state;
  }
}

// Check if the first character of the input/word
// is accepted by the start state
if (isset($stringInput) && $stringInput !== '') {
  if (array_key_exists($stringInput[0], $startState->transitions)) {
    if (!empty($startState->transitions[$stringInput[0]])) {
      $canStart = TRUE;
    } else {
      $canStart = FALSE;
    }
  } else {
    $canStart = FALSE;
  }
}

// An array to store reachable states
$reachedStates = array();

// Store reacheable states by the start state
if (isset($canStart) && $canStart == TRUE) {
  foreach ($startState->transitions as $key => $value) {
    if ($key == $stringInput[0]) {
      foreach ($value as $v) {
        array_push($reachedStates, $v);
      }
    }
  }
}

// Start string index by 1 because index 0 is already previously tested
// by the start state
$stringIndex = 1;

$continue = TRUE;

while ($stringIndex < strlen($stringInput) && $continue == TRUE) {
  $continue = FALSE;
  $newlyReachedStates = array();
  foreach ($reachedStates as $rs) {
    foreach ($nfa as $object) {
      if ($object->name == $rs) {
        foreach ($object->transitions as $key => $value) {
          if ($key == $stringInput[$stringIndex]) {
            foreach ($value as $v) {
              array_push($newlyReachedStates, $v);
              $continue = TRUE;
            }
          }
        }
      }
    }
  }
  $newlyReachedStates = array_unique($newlyReachedStates);
  $reachedStates = $newlyReachedStates;
  $stringIndex++;
}

$isFinal = FALSE;

// Check if the final states reached by the last character of the input/word
// is a final state
foreach ($reachedStates as $rs) {
  foreach ($nfa as $obj) {
    if ($obj->name == $rs && $obj->isFinalState == 1) {
      $isFinal = TRUE;
    }
  }
}

// Result of testing
if ($continue == TRUE && $isFinal == TRUE) {
  echo "<div id=\"accepted\">".$stringInput." is ACCEPTED</div>";
} elseif (!isset($canStart)){
  echo "<div id=\"warning\">No string entered.</div>";
} else {
  echo "<div id=\"rejected\">".$stringInput." is REJECTED</div>";
}

?>
