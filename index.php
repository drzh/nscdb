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
  <input type="text" name="kw" id="input1" size="60" placeholder="enter position, region, gene symbol, HGVS or search terms" >
  <!-- <br> -->
  <input class="submit1" type="submit" value="Submit">
  <div class="title_one">Filters</div>
  <table class="ft_table">
    <tr>
      <td>Frame of novel CDS : </td>
      <td>
        <input type="checkbox" name="cb_if" value="1">In frame
        <input type="checkbox" name="cb_of" value="1">Out of frame
      </td>
    </tr>
    <tr>
      <td>Position of the stop codon : </td>
      <td>
        <input type="checkbox" name="cb_stopb" value="1">Before original start codon
        <input type="checkbox" name="cb_stopa" value="1">After original start codon
      </td>
    </tr>
  </table>
    
</form>

<?php include('tail.inc'); ?>
