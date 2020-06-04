<?php
$label = 'A';

foreach ($dfa as $dfaObj) {
  if ($dfaObj->name == 'Z') {
    $dfaObj->label = 'Z';

    foreach ($_SESSION['alphaSorted'] as $inputs) {
      if ($inputs != 'Ɛ') {
          $dfaObj->transitions[$inputs] = 'Z';
        }
    }
  } else {
    $dfaObj->label = $label;
    $label++;
  }
}

foreach ($dfa as $dfaObject) {
  if ($dfaObject->name != 'Z') {
    foreach ($dfaObject->transitions as $key => $value) {
      $temp = $dfaObject->transitions[$key];
      $sorted = "";

      sort($temp);
      $sorted = implode("", $temp);

      foreach ($dfa as $d) {
        if ($d->name == $sorted) {
          $dfaObject->transitions[$key] = $d->label;
        }
      }

      if (empty($dfaObject->transitions[$key]) || !array_key_exists($key,$dfaObject->transitions)) {
        $dfaObject->transitions[$key] = 'Z';
      }
    }
  }
}
?>
