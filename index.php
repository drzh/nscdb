<?php include('head.inc'); ?>

<br>
<font color="red">Welcome to Novel Start Codons Database:</font>
<ul style="margin-block-start: 0.5em">
  <li>NSCDB provides information on SNPs that introduced potential novel start codons in the human genomes</li>
  <li>You can search and browse the candidate novel start codons</li>
</ul>
<hr>

<div class="title_one">Search</div>
<form action="list.php" method="get">
  <input class="center_block" type="text" name="kw" id="input1" size="60" placeholder="enter position, region, gene symbol, HGVS or search terms" >
  <br>
  <input class="center_block" type="submit" value="Submit">
</form>

<?php include('tail.inc'); ?>
