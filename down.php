<?php include('head.inc'); ?>

<div class="title_one">Result</div>

<?php

/* print_r($_POST);
 * echo "<br>";
 * print_r($_FILES);
 * echo "<br>"; */

$flag = 0;
$target_dir = "upload/";
if (isset($_POST['fid']) && strlen($_POST['fid']) == 44) {
  $fid = $_POST['fid'];
  $target_output = $target_dir . $fid . ".tsv";
  $flag = 2;
}
else if (isset($_FILES['upfile']['tmp_name']) && strlen($_FILES['upfile']['tmp_name']) > 1) {
  // check if file was uploaded succesfully and moved to the target directory
  $dt = date("ymdHis");
  $rand = mt_rand(100000000, 999999999);
  $md5 = md5_file($_FILES['upfile']['tmp_name']);
  $pattern = $target_dir . "*$md5.tsv";
  $fouts = glob($pattern);
  if ($fouts) {
    $target_output = $fouts[0];
    $fid = 'N.A.';
    if (preg_match('/(\d{12}\S{32}).tsv/', $target_output, $mat)) {
      $fid = $mat[1];
    }
    $flag = 2;
  }
  else {
    $fid = $dt . $md5;
    $target_file = $target_dir . $fid . ".in";
    $target_output = $target_dir . $fid . ".tsv";
    if (move_uploaded_file($_FILES['upfile']['tmp_name'], $target_file)) {
      $flag = 1;
    }
  }
}

// 
if ($flag != 0) {
  if ($flag == 1) {
    $cmd = "data/extract_nsc.sh data/nsc.all.gz $target_file >$target_output 2>$target_output.err ";
    exec($cmd);
  }
  if (file_exists($target_output)) {
    echo "<div align='center' style='font-size:1.5em;padding-bottom:10px;'><a href='$target_output'>Download the result</a></div>";
    echo "<div align='center'>Result ID (result can be retrieved in future using this ID):&nbsp;&nbsp;<span style='color:red;'>$fid</span></a></div>";
  }
}
else {
  echo "Upload failed.<br>";
}

?>

<?php include('tail.inc'); ?>
