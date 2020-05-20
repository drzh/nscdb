<?php include('head.inc'); ?>

<div class="title_one">Search Result</div>

<?php
if (isset($_GET['kw'])) {
  $kw = $_GET['kw'];
}

// Process key word
$type = 'text';
$flag_id_m = 0;
if (preg_match('/(\S+):(\S+)/', $kw, $mat)) {
  // Position or region
  $chr = $mat[1];
  $pos = $mat[2];
  if (preg_match('/chr(\S+)/', $chr, $matchr)) {
    $chr = $matchr[1];
  }
  if (preg_match('/(\d+)-(\d+)/', $pos, $matpos)) {
    $type = 'region';
    $pos1 = $matpos[1];
    $pos2 = $matpos[2];
  }
  else if (preg_match('/^(\d+)$/', $pos)) {
    $type = 'pos';
  }
}
else if (preg_match('/^ENST/', $kw, $mat)) {
  // tid or tid_m;
  if (preg_match('/^ENST\d+$/', $kw)) {
    $type = 'tid_m';
    $id_m = $kw;
  }
  else if (preg_match('/^(ENST\d+)\.\d+$/', $kw, $matid)) {
    $type = 'tid';
    $id = $kw;
    $id_m = $matid[1];
  }
}
else if (preg_match('/^ENSG/', $kw, $mat)) {
  // gid or gid_m;
  if (preg_match('/^ENSG\d+$/', $kw)) {
    $type = 'gid_m';
    $id_m = $kw;
  }
  else if (preg_match('/^(ENSG\d+)\.\d+$/', $kw, $matid)) {
    $type = 'gid';
    $id = $kw;
    $id_m = $matid[1];
  }
}
else if (preg_match('/^uc\d{3}[a-z]{3}/', $kw, $mat)) {
  // gid or gid_m;
  if (preg_match('/^uc\d{3}[a-z]{3}$/', $kw)) {
    $type = 'ucsc_id_m';
    $id_m = $kw;
    echo $type, ' | ', $id_m;
  }
  else if (preg_match('/^(uc\d{3}[a-z]{3})\.\d+$/', $kw, $matid)) {
    $type = 'ucsc_id';
    $id = $kw;
    $id_m = $matid[1];
    echo $type, ' | ', $id, ' | ', $id_m;
  }
}
else if (preg_match('/^(N[MR]_\d{6})(\.\d+)*$/', $kw, $mat)) {
  // refid;
  $type = 'refseq_id';
  $id_m = $mat[1];
  echo $type, ' | ', $id_m;
}



?>

<?php include('tail.inc'); ?>
