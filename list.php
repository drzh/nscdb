<?php include('head.inc'); ?>

<div class="title_one">Search Result</div>

<?php
$kw = '';
$ftstat = [];
$fid = '';
if (isset($_GET['kw'])) {
  $kw = $_GET['kw'];
}
if (isset($_GET['rd_frame'])) {
  $ftstat['frame'] = $_GET['rd_frame'];
}
if (isset($_GET['rd_stop'])) {
  $ftstat['stop'] = $_GET['rd_stop'];
}
if (isset($_GET['rd_cds'])) {
  $ftstat['cds'] = $_GET['rd_cds'];
}
if (isset($_GET['cb_1000g'])) {
  $ftstat['1000g'] = $_GET['cb_1000g'];
}
if (isset($_GET['cb_exac'])) {
  $ftstat['exac'] = $_GET['cb_exac'];
}
if (isset($_GET['cb_dbsnp'])) {
  $ftstat['dbsnp'] = $_GET['cb_dbsnp'];
}
if (isset($_GET['fid'])) {
  $fid = $_GET['fid'];
}

$para = [
  'pg' => 1,
  'n' => 50
];
if (isset($_GET['pg'])) {
  $para['pg'] = $_GET['pg'];
}
if (isset($_GET['n'])) {
  $para['n'] = $_GET['n'];
}

$rows = [];

// Process key word or fid
if ($kw != '') {
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
  $sqlf = "";
  if (array_key_exists('frame', $ftstat)) {
    if ($ftstat['frame'] == '0') {
      $sqlf .= " and nsc.frame = 0";
    }
    else if ($ftstat['frame'] == '1') {
      $sqlf .= " and nsc.frame != 0";
    }
  }
  if (array_key_exists('stop', $ftstat)) {
    if ($ftstat['stop'] == 0) {
      $sqlf .= " and nsc.nsc_end >= 0";
    }
    else if ($ftstat['stop'] == 1) {
      $sqlf .= " and nsc.nsc_end < 0";
    }
  }
  if (array_key_exists('cds', $ftstat)) {
    if ($ftstat['cds'] == 0) {
      $sqlf .= " and nsc.overlap_cds = 0";
    }
    else if ($ftstat['cds'] == 1) {
      $sqlf .= " and nsc.overlap_cds = 1";
    }
  }

  $sqlfdb = '';
  if (array_key_exists('1000g', $ftstat)) {
    if ($ftstat['1000g'] == 'on') {
      if ($sqlfdb == '') {
        $sqlfdb = " and (nsc.1000g = 1";
      }
      else {
        $sqlfdb .= " or nsc.1000g = 1";
      }
    }
  }
  if (array_key_exists('exac', $ftstat)) {
    if ($ftstat['exac'] == 'on') {
      if ($sqlfdb == '') {
        $sqlfdb = " and (nsc.exac = 1";
      }
      else {
        $sqlfdb .= " or nsc.exac = 1";
      }
    }
  }
  if (array_key_exists('dbsnp', $ftstat)) {
    if ($ftstat['dbsnp'] == 'on') {
      if ($sqlfdb == '') {
        $sqlfdb = " and (nsc.dbsnp = 1";
      }
      else {
        $sqlfdb .= " or nsc.dbsnp = 1";
      }
    }
  }
  if ($sqlfdb != '') {
    $sqlfdb .= ')';
  }
  $sqlf .= $sqlfdb;

  $sqls = [];
  $col = "nsc.chr, nsc.pos, nsc.ref, nsc.alt, nsc.str, nsc.tid, nsc.t_pos, nsc.t_ref, nsc.t_alt, nsc.frame, nsc.end_before, nsc.nsc_start, nsc.nsc_end, gene.gid, gene.gname, gene.symbol";
  if ($type == 'pos') {
    $sql = "select $col from nsc, gene where nsc.tid = gene.tid and nsc.chr = '$chr' and nsc.pos = $pos" . $sqlf . $sqllimit;
    $sqls[] = $sql;
  }
  else if ($type == 'region') {
    $sql = "select $col from nsc, gene where nsc.tid = gene.tid and nsc.chr = '$chr' and nsc.pos >= $pos1 and nsc.pos <= $pos2" . $sqlf . $sqllimit;
    $sqls[] = $sql;
  }
  else if ($type == 'tid_m' || $type == 'gid_m' || $type == 'ucsc_id_m' || $type == 'refseq_id') {
    $sql = "select $col from nsc, gene where nsc.tid = gene.tid and gene.$type = '$id_m'" . $sqlf . $sqllimit;
    $sqls[] = $sql;
  }
  else {
    $sql = "select $col from nsc, gene where nsc.tid = gene.tid and (gene.gname = '$kw' or gene.symbol = '$kw')" . $sqlf . $sqllimit;
    $sqls[] = $sql;
    $sql = "select $col from nsc, gene where nsc.tid = gene.tid and  match(gene.des) against ('$kw' in natural language mode)" . $sqlf . $sqllimit;
    $sqls[] = $sql;
  }

  // query 
  $rows = [];
  $stat = [];
  foreach ($sqls as $sql) {
    /* echo $sql, "<br>"; */
    if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
      while ($row = $res -> fetch_assoc()) {
        $rows[] = $row;
      }
    }
  }
  $rows = array_unique($rows, SORT_REGULAR);
}
else if ($fid != '') {
  $target_dir = "upload/";
  $target_output = $target_dir . $fid . ".tsv";
  if ($fh = fopen($target_output, "r")) {
    while(! feof($fh)) {
      $line = rtrim(fgets($fh));
      if (! preg_match('/^#/', $line)) {
        if ($line != '') {
          $e = explode("\t", $line);
          $row = [
            'chr' => $e[0],
              'pos' => $e[1],
              'ref' => $e[2],
              'alt' => $e[3],
              'str' => $e[4],
              'tid' => $e[5],
              't_pos' => $e[6],
              't_ref' => $e[7],
              't_alt' => $e[8],
              'frame' => $e[9],
              'end_before' => $e[10],
              'nsc_start' => $e[11],
              'nsc_end' => $e[12],
              'new_cds' => $e[13],
              'new_pep' => $e[14],
              'kozak' => $e[15],
              'symbol' => '.'
          ];
          $sql = "select * from gene where tid = '" . $row['tid'] . "';";
          if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
            $e = $res -> fetch_assoc();
            $row['symbol'] = $e['symbol'];
          }
          $rows[] = $row;
        }
      }
    }
  } 
}

$nrow = count($rows);
if ($nrow > 0) {
  // split pages
  $pgall = ceil($nrow / $para['n']);
  if ($para['pg'] <= $pgall) {
    $i = ($para['pg'] - 1) * $para['n'];
    $n = ($nrow - $i < $para['n']) ? ($nrow - $i) : $para['n'];
    echo $i + 1, " - ", $i + $n, " of $nrow results<br>";
    $rows = array_slice($rows, $i, $n);
    
    // output
    echo "<table class='nsc_table'>";
    echo "<thead><tr><th>Chr</th><th>Position</th><th>Ref</th><th>Alt</th><th>Transcript_ID</th><th>Position<br>in transcript</th><th>Frame</th><th>Position<br>of new stop codon</th><th>Symbol</th></tr></thead>";
    echo "<tbody>";
    foreach ($rows as $row) {
      echo "<tr id='listrow' onclick=", '"', "document.location = 'nsc.php?chr=", $row['chr'], "&pos=", $row['pos'], "&ref=", $row['ref'], "&alt=", $row['alt'], "&tid=", $row['tid'], "';", '">';
      echo "<td>", $row['chr'], "</td>";
      echo "<td>", $row['pos'], "</td>";
      echo "<td>", $row['ref'], "</td>";
      echo "<td>", $row['alt'], "</td>";
      echo "<td>", $row['tid'], "</td>";
      echo "<td>", $row['t_pos'], "</td>";
      echo "<td>", $row['frame'], "</td>";
      echo "<td>", $row['nsc_end'], "</td>";
      /* echo "<td>", $row['gname'], "</td>"; */
      echo "<td>", $row['symbol'], "</td>";
      echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
  }
  // print pages
  echo "<table class='page_panel'><tr><td>Pages: ";
  $i = 1;
  while ($i <= $pgall) {
    echo "<span class='page'>";
    if ($i != $para['pg']) {
      echo "<a href='list.php?";
      foreach ($_GET as $k => $v) {
        if ($k != 'pg') {
          echo "$k=$v&";
        }
      }
      echo "pg=$i'>";
    }
    echo $i;
    if ($i != $para['pg']) {
      echo "</a>";
    }
    $i++;
    echo "</span>";
  }
  echo "</td></tr></table>";
}
else {
  echo "<div align='center'>No novel start codons were found.</div><br>";
}

?>

<?php include('tail.inc'); ?>
