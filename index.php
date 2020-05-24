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
  <input class="submit1" type="submit" value="Submit">
  <div class="title_one">Filters</div>
  <table class="ft_table">
    <tr>
      <th>Frame of novel CDS : </th>
      <td>
        <input type="radio" name="rd_frame" value="i" checked="checked">
        <label>In frame</label>&nbsp;&nbsp;
        <input type="radio" name="rd_frame" value="o">
        <label>Out of frame</label>&nbsp;&nbsp;
        <input type="radio" name="rd_frame" value="io">
        <label>In or out of frame</label>
      </td>
    </tr>
    <tr>
      <th>Position of the stop codon : </th>
      <td>
        <input type="radio" name="rd_stop" value="a" checked="checked">
        <label>After original start codon</label>&nbsp;&nbsp;
        <input type="radio" name="rd_stop" value="b">
        <label>Before original start codon</label>&nbsp;&nbsp;
        <input type="radio" name="rd_stop" value="ab">
        <label>Before or after original start codon</label>
      </td>
    </tr>
    <tr>
      <th>Novel start codon : </th>
      <td>
        <input type="checkbox" name="cb_nocds" value="1">Not overlapped with any known CDS
      </td>
    </tr>
  </table>
    
</form>

<?php include('tail.inc'); ?>
