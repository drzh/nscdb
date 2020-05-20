<?php include('head.inc'); ?>

<div class="title_one">Search Result</div>

<?php
if (isset($_GET['kw'])) {
  $kw = $_GET['kw'];
}

// Process key word
$type = 'text';
if (preg_match('/(\S+):(\S+)/', $kw, $mat)) {
  $chr = $mat[0];
  $pos = $mat[1];
  if (preg_match('/chr(\S+)/', $chr, $matchr)) {
    $chr = $matchr[1];
  }
  if (preg_match('/(\d+):(\d+)/', $pos, $matpos)) {
    $type = 'region';
    $pos1 = $matpos[0];
    $pos2 = $matpos[1];
  }
  else if (preg_match('/^(\d+)$/', $pos)) {
    $type = 'pos';
  }
}
echo 'Type: ', $type;
?>

<?php include('tail.inc'); ?>
