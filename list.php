<?php include('head.inc'); ?>

<div class="title_one">Search Result</div>

<?php
if (isset($_GET['kw'])) {
  $kw = $_GET['kw'];
}

// Process key word
if (preg_match('/(\S+):(\S+)/', $kw, $mat)) {
  $chr = $mat[0];
  if (preg_match('/chr(\S+)/', $chr, $matchr)) {
    $chr = $matchr[1];
  }
  
print_r($mat);

?>

<?php include('tail.inc'); ?>
