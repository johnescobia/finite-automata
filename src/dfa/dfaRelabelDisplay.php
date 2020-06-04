<?php
$shared = TRUE;
$type = 'dfa';
$stateObject = $dfa;
$totalFields = (count($stateObject) + 1) * (count($_SESSION['alphaSorted']));
$columnsPerRow = count($_SESSION['alphaSorted']);
$totalObjects = count($stateObject) + 1;

echo "<h4>Relabeled DFA Table</h4>";
include "src/table.php";

 ?>
