<?php
$nfaObjects = unserialize($_SESSION['states']);
$nfa = unserialize($_SESSION['states']);

foreach ($nfa as $nf) {
  if ($nf->isStartState == 1) {
    $eReach = eClosure($nf, $nfaObjects);

    foreach ($eReach as $er) {
      if (in_array($er, $_SESSION['finalState'])) {
        $nf->isFinalState = 1;
      }
    }
  }
}

// Loop on every object
foreach ($nfaObjects as $object) {
  // First epsilon closure
  $eClosure = eClosure($object, $nfaObjects);

  foreach ($_SESSION['alpha'] as $key) {
    // First epsilon closure
    $eClosure2 = array();
    $currInputArr = array();
    if ($key !== 'Ɛ') {
      foreach ($eClosure as $e) {
        foreach ($nfaObjects as $n) {
          if ($e == $n->name) {
            if (array_key_exists($key,$n->transitions)) {
              foreach ($n->transitions[$key] as $elements) {
                array_push($currInputArr, $elements);
              }
            }
          }
        }
        $currInputArr = deleteDuplicate($currInputArr);
      }
      foreach ($currInputArr as $ci) {
        foreach ($nfaObjects as $n) {
          if ($n->name == $ci) {
            $temp = eClosure($n, $nfaObjects);
            foreach ($temp as $el) {
              array_push($eClosure2, $el);
            }
          }
        }
      }
    }
    $eClosure2 = deleteDuplicate($eClosure2);
    foreach ($nfa as $nf) {
      if ($nf->name == $object->name) {
        $nf->transitions[$key] = $eClosure2;
      }
    }
  }

  foreach ($nfa as $nf) {
    if ($nf->name == $object->name) {
      unset($nf->transitions['Ɛ']);
    }
  }
}

function eClosure($object, $nfaObjects) {
  $eClosure = array();

  // Adds itself first
  array_push($eClosure, $object->name);

  if (array_key_exists("Ɛ",$object->transitions)) {
    foreach ($object->transitions['Ɛ'] as $elements) {
      array_push($eClosure, $elements);
    }

    // Delete duplicate
    $eClosure = deleteDuplicate($eClosure);

    // Add epsilon transitions
    foreach ($eClosure as $epsilonTransitions) {
      foreach ($nfaObjects as $checkObjects) {
        if ($checkObjects->name == $epsilonTransitions ) {
          if (array_key_exists("Ɛ",$checkObjects->transitions)) {
            foreach ($checkObjects->transitions['Ɛ'] as $elements) {
              array_push($eClosure, $elements);
            }
            $eClosure = deleteDuplicate($eClosure);
          }
        }
      }
    }
  }
  return $eClosure;
}

function deleteDuplicate($array) {
  for($i=0; $i<count($array); $i++){
    for($j=$i+1; $j<count($array); $j++){
      if($array[$i] == $array[$j]) {
        unset($array[$j]);
      }
    }
    // Reindex
    $array = array_values($array);
  }
  return $array;
}
?>
