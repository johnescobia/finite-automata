<?php
function combineObjects($nfa, $n, $r, &$dfa) {
  // A temporary array to store all combinations one by one
  $data = array();
  combineUntil($nfa, $data, 0, $n - 1, 0, $r, $dfa);
}

/*
nfa[]  ---> Input Array
data[] ---> Temporary array to store current combination
start  ---> Staring index in nfa[]
& end  ---> Ending index in nfa[]
index  ---> Current index in data[]
r      ---> Size of a combination to be printed
*/

function combineUntil($nfa, $data, $start, $end, $index, $r, &$dfa) {
  // Current combination is ready to be printed, print it
  if ($index == $r) {
    // Instantiate new state object
    $combinedObject = new State('name');

    // Initialize an empty string to store the combination of object  names
    $combinedName = "";

    for ($j = 0; $j < $r; $j++) {
      // Concatenate names
      $combinedName .= $data[$j]->name;

      // Union operation for the transtions
      foreach ($data[$j]->transitions as $key => $value) {

        // Merge transitions with the same input
        // key --> input
        if (array_key_exists($key, $combinedObject->transitions)) {
          $combinedObject->transitions[$key] = array_merge($combinedObject->transitions[$key],
                      $data[$j]->transitions[$key]);
        } else {
          $combinedObject->transitions[$key] = $data[$j]->transitions[$key];
        }

        // Filter out duplicates and sort
        $combinedObject->transitions[$key] = array_unique($combinedObject->transitions[$key]);
        sort($combinedObject->transitions[$key]);

      }

      // Set combined object as final state if one of the objects is
      // a final state
      if ($data[$j]->isFinalState == 1) {
        $combinedObject->isFinalState = 1;
      }
    }

    // Split the union of names into an array
    $arrName = str_split($combinedName);

    // Sort transitions in ascending order
    sort($arrName);

    // Combine back the transitions
    $combinedName = implode('', $arrName);

    // Set the combined object name with the concatenated name
    $combinedObject->name = $combinedName;

    // Append the newly combined objects to the overall dfa array
    array_push($dfa, $combinedObject);
    return;
  }

  /*
  Replace index with all possible elements. The condition "end-i+1 >= r-index"
  makes sure that including one element at index will make a combination with
  remaining elements at remaining positions.
  */

  for ($i = $start; $i <= $end && $end - $i + 1 >= $r - $index; $i++) {
    $data[$index] = $nfa[$i];
    combineUntil($nfa, $data, $i + 1, $end, $index + 1, $r, $dfa);
  }
}

// DRIVER CODE

// Initialize DFA with NFA
$dfa = $nfa;

// Iniitialize the first combination
$r = 2;

// Size of nfa array that will be used for looping
$n = sizeof($nfa);

// Include State class from file stateObject.php
include_once('src/stateObject.php');

// Initialize
while ($r <= $n) {
  combineObjects($nfa, $n, $r, $dfa);
  $r++;
}

// Insert state Z in the beginning of the overall dfa array
array_unshift($dfa, new State( 'Z' ));
?>
