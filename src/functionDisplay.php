<?php
if ( isset($_POST['test']) || isset($_POST['submitString'])) {
  include "src/nfa/nfa.php";
  include "src/test/testDisplay.php";

  if (isset($_POST['submitString'])) {
    include "src/test/test.php";
  }
}

if (isset($_POST['nfa'])) {
  include "src/nfa/nfa.php";
  include "src/nfa/nfaDisplay.php";
}

if (isset($_POST['dfa'])) {
  include "src/nfa/nfa.php";
  echo "<div id=\"leftbox\">";
    echo "<div id=\"leftbox\">";
    include "src/dfa/dfa.php";
    include "src/dfa/dfaDisplay.php";
    echo "</div>";
    echo "<div id=\"middlebox\">";
      include "src/dfa/dfaRelabel.php";
      include "src/dfa/dfaRelabelDisplay.php";
    echo "</div>";
  echo "</div>";
}

if (isset($_POST['min'])) {
  include "src/nfa/nfa.php";
  include "src/dfa/dfa.php";
  include "src/dfa/dfaRelabel.php";
  include "src/dfa/dfaMin.php";
  include "src/dfa/dfaMinDisplay.php";
}
?>
