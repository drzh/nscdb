<?php include('head.inc'); ?>

<div class="loader"></div>

<br>
<font color="red">Welcome to Novel Start Codons Database:</font>
<ul style="margin-block-start: 0.5em">
  <li>NSCDB provides information on SNPs that introduced potential novel start codons in the human genomes</li>
  <li>You can search and browse the candidate novel start codons</li>
</ul>
<hr>

<div class="title_one">Upload your file</div>
<form action="down.php" method="post" enctype="multipart/form-data">
  <div align="center">
    <label for="myfile">Select a file:</label>
    <input type="file" id="upfile" name="upfile">
    <input class="submit1" type="submit" name="submit" value="Upload" onclick="show_loader(); this.disabled=true;"><br>
  </div>
</form>

<div id="loader" style="display: none;"></div>

<script type="text/javascript">
 function show_loader() {
   document.getElementById("loader").style.display = "block";
 }
</script>

<?php include('tail.inc'); ?>
