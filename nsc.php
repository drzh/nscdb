<?php include('head.inc'); ?>

<div class="title_one">Detailed Information</div>

<?php
$flag = 1;

if (isset($_GET['chr'])) {
  $chr = $_GET['chr'];
}
else {
  $flag = 0;
}

if (isset($_GET['pos'])) {
  $pos = $_GET['pos'];
}
else {
  $flag = 0;
}

if (isset($_GET['ref'])) {
  $ref = $_GET['ref'];
}
else {
  $flag = 0;
}

if (isset($_GET['alt'])) {
  $alt = $_GET['alt'];
}
else {
  $flag = 0;
}

if (isset($_GET['tid'])) {
  $tid = $_GET['tid'];
}
else {
  $flag = 0;
}

$sqllimit = " limit 100;";

$na = "N.A.";

if ($flag == 1) {
  // generate sql
  $sql = "select * from nsc where chr = '$chr' and pos = $pos and ref = '$ref' and alt = '$alt' and tid = '$tid';";
  if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
    $row = $res -> fetch_assoc();
    $tb_chr = array_key_exists('chr', $row) ? $row['chr'] : $na;
    $tb_pos = array_key_exists('pos', $row) ? $row['pos'] : $na;
    $tb_ref = array_key_exists('ref', $row) ? $row['ref'] : $na;
    $tb_alt = array_key_exists('alt', $row) ? $row['alt'] : $na;
    $tb_str = array_key_exists('str', $row) ? $row['str'] : $na;
    $tb_tid = array_key_exists('tid', $row) ? $row['tid'] : $na;
    $tb_t_pos = array_key_exists('t_pos', $row) ? $row['t_pos'] : $na;
    $tb_t_ref = array_key_exists('t_ref', $row) ? $row['t_ref'] : $na;
    $tb_t_alt = array_key_exists('t_alt', $row) ? $row['t_alt'] : $na;
    $tb_frame = array_key_exists('frame', $row) ? $row['frame'] : $na;
    $tb_end_before = array_key_exists('end_before', $row) ? $row['end_before'] : $na;
    $tb_nsc_start = array_key_exists('nsc_start', $row) ? $row['nsc_start'] : $na;
    $tb_nsc_end = array_key_exists('nsc_end', $row) ? $row['nsc_end'] : $na;
    $tb_new_cds = array_key_exists('new_cds', $row) ? $row['new_cds'] : $na;
    $tb_new_pep = array_key_exists('new_pep', $row) ? $row['new_pep'] : $na;
    $tb_kozak = array_key_exists('kozak', $row) ? $row['kozak'] : $na;
    $tb_cdslen = strlen($tb_new_cds);
    $tb_peplen = intdiv($tb_cdslen, 3);
  }
  $sql = "select * from hg38_hg19 where chr = '$chr' and pos = $pos;";
  if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
    $row = $res -> fetch_assoc();
    $tb_hg19_chr = array_key_exists('hg19_chr', $row) ? $row['hg19_chr'] : $na;
    $tb_hg19_pos = array_key_exists('hg19_pos', $row) ? $row['hg19_pos'] : $na;
  }
  $sql = "select * from gene where tid = '$tid';";
  if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
    $row = $res -> fetch_assoc();
    $tb_gid = array_key_exists('gid', $row) ? $row['gid'] : $na;
    $tb_gname = array_key_exists('gname', $row) ? $row['gname'] : $na;
    $tb_ucsc_id = array_key_exists('ucsc_id', $row) ? $row['ucsc_id'] : $na;
    $tb_refseq_id = array_key_exists('refseq_id', $row) ? $row['refseq_id'] : $na;
    $tb_symbol = array_key_exists('symbol', $row) ? $row['symbol'] : $na;
    $tb_des = array_key_exists('des', $row) ? $row['des'] : $na;
  }
  $f_1000g = 0;
  $sql = "select * from pop_1000g where chr = '$chr' and pos = $pos and alt = '$alt';";
  if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
    $tb_1000g_frq = [];
    while($row = $res -> fetch_assoc()) {
      if(array_key_exists('pop_grp', $row)) {
        $f_1000g = 1;
        $tb_1000g_frq[$row['pop_grp']] = $row['frq_show'];
      }
    }
  }
  $f_exac = 0;
  $sql = "select * from pop_exac where chr = '$chr' and pos = $pos and alt = '$alt';";
  if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
    $tb_exac_frq = [];
    while($row = $res -> fetch_assoc()) {
      if(array_key_exists('pop_grp', $row)) {
        $f_exac = 1;
        $tb_exac_frq[$row['pop_grp']] = $row['frq_show'];
      }
    }
  }
  echo "<table class='nsc_table'>";
  echo "<tr><th>Position in Genome</th><td><table class='inner_table'><tr><td><a href='http://genome.ucsc.edu/cgi-bin/hgTracks?db=hg38&position=chr$tb_chr:$tb_pos' target='_blank'>chr$tb_chr:$tb_pos</a>&nbsp;(GRCh38)</td><td align='right'><a href='http://genome.ucsc.edu/cgi-bin/hgTracks?db=hg19&position=chr$tb_hg19_chr:$tb_hg19_pos' target='_blank'>chr$tb_hg19_chr:$tb_hg19_pos</a>&nbsp;(GRCh37)</td></tr></table></td></tr>";
  echo "<tr><th>Strand</th><td>$tb_str</td></tr>";
  echo "<tr><th>Alleles</th><td>$tb_ref>$tb_alt&nbsp;(Genome);&nbsp;&nbsp;&nbsp;&nbsp;$tb_t_ref>$tb_t_alt&nbsp;(Transcript)</td></tr>";
  echo "<tr><th>Position in Transcript</th><td>$tb_t_pos</td></tr>";
  echo "<tr><th>Frame of New CDS</th><td>$tb_frame</td></tr>";
  echo "<tr><th>Transcript ID</th><td><a href='https://useast.ensembl.org/Homo_sapiens/Transcript/Summary?db=core;t=$tid' target='_blank'>$tb_tid</a>";
  /* if ($tb_refseq_id != $na and $tb_refseq_id != '.') {
   *   echo " | <a href='https://www.ncbi.nlm.nih.gov/nuccore/$tb_refseq_id' target='_blank'>$tb_refseq_id</a>";
   * } */
  /* if ($tb_ucsc_id != $na and $tb_ucsc_id != '.') {
   *   echo "<br><a href='http://genome.ucsc.edu/cgi-bin/hgTracks?db=hg38&singleSearch=knownCanonical&position=$tb_ucsc_id' target='_blank'>$tb_ucsc_id</a>";
   * } */
  echo "</td></tr>";
  echo "<tr><th>Gene ID</th><td><a href='https://useast.ensembl.org/Homo_sapiens/Gene/Summary?db=core;g=$tb_gid' target='_blank'>$tb_gid</a></td></tr>";
  echo "<tr><th>Symbol</th><td>$tb_symbol</td></tr>";
  echo "<tr><th>Length of Novel CDS</th><td>$tb_cdslen nucleotides / $tb_peplen codons</td></tr>";
  // show allele frequency
  echo "<tr><th>Allele Frequency</th><td>";
  if ($f_1000g == 1) {
    echo "1000G: ";
    $pop = ['ALL', 'AFR', 'AMR', 'EAS', 'EUR', 'SAS'];
    foreach ($pop as $p) {
      if (array_key_exists($p, $tb_1000g_frq)) {
        echo " $p=", $tb_1000g_frq[$p], ";";
      }
    }
  }
  if ($f_1000g == 1 && $f_exac == 1) {
    echo "<br>";
  }
  if ($f_exac == 1) {
    echo "EXAC: ";
    $pop = ['ALL', 'AFR', 'AMR', 'EAS', 'EUR', 'SAS'];
    foreach ($pop as $p) {
      if (array_key_exists($p, $tb_exac_frq)) {
        echo " $p=", $tb_exac_frq[$p], ";";
      }
    }
  }
  if ($f_1000g == 0 && $f_exac == 0) {
    echo "N.A.";
  }
  echo "</td></tr>";
  echo "<tr><th>Description</th><td>$tb_des</td></tr>";
  echo "</table>";
  echo "<br>";

  // sequence info
  $sql = "select * from seq where chr = '$chr' and pos = $pos and ref = '$ref' and alt = '$alt' and tid = '$tid';";
  if (($res = $conn -> query($sql)) && ($res -> num_rows > 0)) {
    $row = $res -> fetch_assoc();
    $alt_pos = $row['alt_pos'];
    $newstart_pos = $row['newstart_pos'];
    $newstop_pos = $row['newstop_pos'];
    $oldstart_pos = $row['oldstart_pos'];
    $seq = $row['seq'];
  }
  echo "<table class='nsc_table'>";
  echo "<tr><th>Novel CDS and Peptide</th></tr>";
  echo "<tr><td align='center'>";
  echo "<table><tr><td style='border:0px;'>";
  $nbeforecodon = 6;
  $nperline = 66;
  $i = 0;
  $n = 0;
  $cds = '';
  $pep = '';
  $new_cds = $seq;
  $new_pep = $tb_new_pep;
  $diff = $nbeforecodon - $newstart_pos + 1;
  if ($diff > 0) {
    $new_cds = str_repeat(' ', $diff) . $new_cds;
    $alt_pos += $diff;
    $newstart_pos += $diff;
    $newstop_pos += $diff;
    $oldstart_pos += $diff;
  }
  $new_pep = str_repeat(' ', $nbeforecodon / 3) . $new_pep;
  $new_cds = substr_replace($new_cds, $tb_t_alt, $alt_pos - 1, 1);
  $cdslen = strlen($new_cds);

  // generate the position and mutation
  $t_pos_str = strval($tb_t_pos);
  $t_pos_len = strlen($t_pos_str);
  echo "<div class='nuc'>", str_repeat(' ', $alt_pos - $t_pos_len - 2), "$tb_t_pos.$tb_t_ref>$tb_t_alt</div>";
  echo "<div class='nuc'>", str_repeat(' ', $alt_pos - 1), "&darr;</div>";
  $j = 0;
  while ($i < $cdslen) {
    // ----- newstart span begin -----
    if ($i == $newstart_pos - 1) {
      $cds .= "<span class='newstart'>";
      $pep = $pep . " " . substr($new_pep, $i / 3, 1) . " ";
    }

    // ----- cds span begin -----
    if ($i >= $newstart_pos + 2 && $i < $newstop_pos - 1) {
      if (($i - $newstart_pos + 1) % 3 == 0) {
        $cds .= "<span class='codon" . ($j++ % 2) . "'>";
        $pep = $pep . " " . substr($new_pep, $i / 3, 1) . " ";
      }
    }

    // ----- newstop span begin -----
    if ($newstop_pos != $oldstart_pos && $i >= $newstop_pos - 1 && $i <= $newstop_pos + 1) {
      $cds .= "<span class='newstop'>";
    }

    // ----- oldstart span begin -----
    if ($i >= $oldstart_pos - 1 && $i <= $oldstart_pos + 1) {
      $cds .= "<span class='oldstart'>";
    }

    // cds seq
    $cds .= substr($new_cds, $i, 1);

    // ----- oldstart span end -----
    if ($i >= $oldstart_pos - 1 && $i <= $oldstart_pos + 1) {
      $cds .= "</span>";
    }

    // ----- newstop span end -----
    if ($newstop_pos != $oldstart_pos && $i >= $newstop_pos - 1 && $i <= $newstop_pos + 1) {
      $cds .= "</span>";
    }

    // ----- newstart or cds span end -----
    if ($i > $newstart_pos - 1 && $i < $newstop_pos - 1 && ($i - $newstart_pos + 1) % 3 == 2) {
      $cds .= "</span>";
    }

    // spaces before newstart
    if ($i < $newstart_pos - 1) {
      $pep = $pep . ' ';
    }

    $i++;
    $n++;
    if ($n >= $nperline) {
      echo "<div class='nuc'>$cds</div>";
      if ($pep == '') {
        $pep = ' ';
      }
      echo "<div class='pep'>$pep</div>";
      $cds = '';
      $pep = '';
      $n = 0;
    }
  }
  if ($cds != '') {
    echo "<div class='nuc'>$cds</div>";
    if ($pep == '') {
      $pep = ' ';
    }
    echo "<div class='pep'>$pep</div>";
  }

  echo "</td></td></table>";
  echo "</td></tr>";
  echo "</table><br>";
  
  echo "<table class='nsc_table'>";
  echo "<tr><th>Kozak Sequence</th></tr>";
  echo "<tr><td>";
  echo $tb_kozak;
  echo "</td></tr>";
  echo "</table>";

}
?>

<?php include('tail.inc'); ?>
