<?php
/*
  <-- Start of removing unreachable states -->
*/
$isDone = FALSE;

while ($isDone == FALSE) {
  $isDone = TRUE;
  $transitionList = array();

  foreach ($dfa as $d) {
    foreach ($d->transitions as $key => $value) {
      array_push($transitionList, $value);
    }
  }

  $transitionList = array_unique($transitionList);
  $indexList = array();

  foreach ($dfa as $d) {
    if (!in_array($d->label, $transitionList) && $d->label !== 'A') {
      array_push($indexList, $d->label);
      $isDone = FALSE;
    }
  }

  foreach ($indexList as $index) {
    foreach ($dfa as $dKey => $element) {
      foreach ($element as $key => $value) {
        if ($element->label == $index) {
          unset($dfa[$dKey]);
        }
      }
    }
  }
}

/*
  <-- End of removing unreachable states -->
*/

/*
  <-- Start of grouping states -->
*/

// Initialize possible inputs from the transition table
$alphabets = $_SESSION['alphaSorted'];

// Pop the epsilon transition
array_pop($alphabets);

// Array of group names
$groupNameArr = array('f', 'n');

// Initialize group by final states (f) and non-final state (n)
foreach ($dfa as $d) {
  if ($d->isFinalState == 1) {
    $d->group = 'f';
  } else {
    $d->group = 'n';
  }
}

$currentDFA = array();
$previousDFA = array();

// Clone dfa because if merely assigned,
// PHP will assign by reference for objects
foreach ($dfa as $element) {
  array_push($previousDFA, clone $element);
  array_push($currentDFA, clone $element);
}

// Stores comparison of each group with the other groups
$currentRound = "";
$previousRound = "";

$isDone = FALSE;

while ( $isDone == FALSE) {
  $isDone = TRUE;
  $currentRound = "";

  foreach ($currentDFA as $dKey => $element) {
    $tempName = array();
    foreach ($alphabets as $a) {
      $temp = $element->transitions[$a];
      foreach ($previousDFA as $pKey => $pElement) {
        if ($pElement->label == $temp) {
          array_push($tempName,$previousDFA[$pKey]->group);
        }
      }
    }

    $newGroup = implode('', $tempName);
    $currName = $element->group;
    $currName .= $newGroup;

    if (!in_array($newGroup, $groupNameArr)
      && count(array_count_values($tempName)) != 1) {
      array_push($groupNameArr, $newGroup);
    }

    $groupNameArr = array_unique($groupNameArr);
    $currentDFA[$dKey]->group = $currName;

  }

  $previousDFA = array();

  foreach ($currentDFA as $current) {
    array_push($previousDFA, clone $current);
  }

  foreach ($currentDFA as $parentDFA) {
    foreach ($currentDFA as $childDFA) {
      if ($parentDFA->group == $childDFA->group) {
        $currentRound .= 1;
      } else {
        $currentRound .= 0;
      }
    }
  }

  if ($previousRound == $currentRound) {
    $isDone = TRUE;
  } else {
    $previousRound = $currentRound;
    $isDone = FALSE;
  }

}

/*
  <-- End of grouping states -->
*/

/*
  <-- Start of combining states with the same group -->
*/

// Assign labels as names
foreach ($currentDFA as $c) {
  $c->name = $c->label;
}

// Create temporary dfa for reference/comparison purposes
$tempDFA = array();

foreach ($currentDFA as $dfaObject) {
  array_push($tempDFA, clone $dfaObject);
}

// Combine states
foreach ($currentDFA as $parentDFA) {
  foreach ($tempDFA as $childDFA) {
    if (($parentDFA->group == $childDFA->group)
      && ($parentDFA->label != $childDFA->label)) {

      // Append labels
      $parentDFA->label .= $childDFA->label;

      // Merge transitions
      foreach ($alphabets as $a) {
        if ($parentDFA->transitions[$a] != $childDFA->transitions[$a]) {
          // $tempString = "";
          // $tempString = $childDFA->label;
          $parentDFA->transitions[$a] .= $childDFA->label;

          $arrT = str_split($parentDFA->transitions[$a]);
          $tempT = array_unique($arrT);
          sort($tempT);
          $newT = implode('', $tempT);
          $parentDFA->transitions[$a] = $newT;
        }
      }
    }
  }
  $arrLabel = str_split($parentDFA->label);
  $tempLabel = array_unique($arrLabel);
  sort($tempLabel);
  $newLabel = implode('', $tempLabel);
  $parentDFA->label = $newLabel;
}

// Rename transitions
foreach ($currentDFA as $parentDFA) {
  foreach ($currentDFA as $childDFA) {
    foreach ($childDFA->transitions as $key => $value) {
      if ($value == $parentDFA->name) {

        $childDFA->transitions[$key] = $parentDFA->label;
      }
    }
  }
}

/*
  <-- End of combining states with the same group -->
*/

/*
  <-- Start of deleting states with repeating groups -->
*/

$isDone = FALSE;
while ($isDone == FALSE) {
  $isDone = TRUE;

  for ($i=0; $i < sizeof($currentDFA); $i++) {
    for ($j=$i+1; $j < sizeof($currentDFA); $j++) {
      if ($currentDFA[$i]->group == $currentDFA[$j]->group) {
        unset($currentDFA[$j]);
        $isDone = FALSE;
        $currentDFA = array_values($currentDFA);
      }
    }
  }
}

/*
  <-- End of deleting states with repeating groups -->
*/

foreach ($currentDFA as $key => $value) {

}
?>
