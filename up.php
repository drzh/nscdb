<?php include('head.inc'); ?>

<div class="info">
  <font color="red">Welcome to Novel Start Codons Database:</font>
  <ul style="margin-block-start: 0.5em">
    <li>NSCDB provides information on SNPs that introduced potential novel start codons in the human genomes</li>
    <li>You can search and browse the candidate novel start codons</li>
  </ul>
</div>
<hr>

<div class="title1">Upload your file</div>
<form action="down.php" method="post" enctype="multipart/form-data">
  <div align="center">
    <label for="myfile">Select a file:</label>
    <input type="file" id="upfile" name="upfile">
    <input class="submit1" type="submit" name="submit1" value="Upload" onclick="show_loader(); this.disabled=true;">
    <div style="padding: 10px 0px 10px 0px;">Or</div>
    <label for="myfid">Retrieve the result by ID:</label>
    <input type="text" id="fid" name="fid" size="50">
    <input class="submit1" type="submit" name="submit2" value="Submit" onclick="show_loader(); this.disabled=true;">
  </div>
</form>

<div id="loader" style="display: none;"></div>

<script type="text/javascript">
 function show_loader() {
   document.getElementById("loader").style.display = "block";
 }
</script>

<?php include('tail.inc'); ?>
