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
else if (preg_match('/^(ENST\d+)(\.\d+)*$/', $kw, $mat)) {
  // tid or tid_m;
  $type = 'tid_m';
  $id_m = $mat[1];
}
else if (preg_match('/^(ENSG\d+)(\.\d+)*$/', $kw, $mat)) {
  // gid or gid_m;
  $type = 'gid_m';
  $id_m = $mat[1];
}
else if (preg_match('/^(uc\d{3}[a-z]{3})(\.\d+)*$/', $kw, $mat)) {
  // ucsc_id or ucsc_id_m;
  $type = 'ucsc_id_m';
  $id_m = $mat[1];
}
else if (preg_match('/^(N[MR]_\d{6})(\.\d+)*$/', $kw, $mat)) {
  // refid;
  $type = 'refseq_id';
  $id_m = $mat[1];
}

// generate sql
$col = 'nsc.chr, nsc.pos, nsc.ref, nsc.alt, nsc.str, nsc.tid, nsc.t_pos, nsc.t_ref, nsc.t_alt, nsc.frame, nsc.end_before, nsc.nsc_start, nsc.nsc_end, gene.gid, gene.gname, gene.symbol';
if ($type == 'pos') {
  $sql = "select $col from nsc, gene where nsc.tid = gene.tid and nsc.chr = '$chr' and nsc.pos = $pos;";
}
else if ($type == 'region') {
  $sql = "select $col from nsc, gene where nsc.tid = gene.tid and nsc.chr = '$chr' and nsc.pos >= $pos1 and nsc.pos <= $pos2;";
}
else if ($type == 'tid_m' || $type == 'gid_m' || $type == 'ucsc_id_m' || $type == 'refseq_id') {
  $sql = "select $col from nsc, gene where nsc.tid = gene.tid and gene.$type = '$id_m';";
}

// query 
/* echo $sql, '<br>'; */
if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
  // output
  echo "<table class='nsc_table'>";
  echo "<thead><tr><th>Chr</th><th>Position</th><th>Ref</th><th>Alt</th><th>Transcript_ID</th><th>Position<br>in transcript</th><th>Frame</th><th>Gene Name</th><th>Symbol</th></tr></thead>";
  echo "<tbody>";
  while($row = $res -> fetch_assoc()) {
    #echo $row['chr'], ' ', $row['pos'], ' ', $row['ref'], ' ', $row['alt'], ' ',  $row['str'], ' ', $row['tid'], '<br>';
    echo "<tr id='listrow' onclick=", '"', "document.location = 'nsc.php?chr=", $row['chr'], "&pos=", $row['pos'], "&ref=", $row['ref'], "&alt=", $row['alt'], "&tid=", $row['tid'], "';", '">';
    echo "<td>", $row['chr'], "</td>";
    echo "<td>", $row['pos'], "</td>";
    echo "<td>", $row['ref'], "</td>";
    echo "<td>", $row['alt'], "</td>";
    echo "<td>", $row['tid'], "</td>";
    echo "<td>", $row['t_pos'], "</td>";
    echo "<td>", $row['frame'], "</td>";
    /* echo "<td>", $row['gid'], "</td>"; */
    echo "<td>", $row['gname'], "</td>";
    echo "<td>", $row['symbol'], "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
}
else {
  echo "0 results";
}

?>

<?php include('tail.inc'); ?>
