<?php include('head.inc'); ?>

<div class="info">
  <font color="red">Welcome to Novel Start Codons Database:</font>
  <ul style="margin-block-start: 0.5em">
    <li>NSCDB provides information on SNPs that introduced potential novel start codons in the human genomes</li>
    <li>You can search and browse the candidate novel start codons</li>
  </ul>
</div>
<hr>

<div class="title1">Search</div>
<form action="/list.php" method="get">
  <div align="center">
    <input type="text" name="kw" id="input1" size="60" placeholder="enter position, region, gene symbol, HGVS or search terms" >
    <input class="submit1" type="submit" value="Submit"><br>
    <div style="padding-top: 6px;">
      e.g., <a onclick="javascript: document.getElementById('input1').value='9:100000-2000000'">9:100000-2000000</a>,
      <a onclick="javascript: document.getElementById('input1').value='CETP'">CETP</a>,
    </div>
  </div>
  <div class="title1">Filters</div>
  <table class="ft_table">
    <tr>
      <th>Frame of novel CDS : </th>
      <td>
        <input type="radio" name="rd_frame" value="0" checked="checked">
        <label>In frame</label>&nbsp;&nbsp;
        <input type="radio" name="rd_frame" value="1">
        <label>Out of frame</label>&nbsp;&nbsp;
        <input type="radio" name="rd_frame" value="2">
        <label>In or out of frame</label>
      </td>
    </tr>
    <tr>
      <th>Position of the stop codon : </th>
      <td>
        <input type="radio" name="rd_stop" value="0" checked="checked">
        <label>After original start codon</label>&nbsp;&nbsp;
        <input type="radio" name="rd_stop" value="1">
        <label>Before original start codon</label>&nbsp;&nbsp;
        <input type="radio" name="rd_stop" value="2">
        <label>Before or after original start codon</label>
      </td>
    </tr>
    <tr>
      <th>Novel start codon : </th>
      <td>
        <input type="radio" name="rd_cds" value="0" checked="checked">
        <label>Not overlapped with CDS</label>&nbsp;&nbsp;
        <input type="radio" name="rd_cds" value="1">
        <label>Overlapped with known CDS</label>&nbsp;&nbsp;
        <input type="radio" name="rd_cds" value="2">
        <label>Overlapped with or without CDS</label>
      </td>
    </tr>
    <tr>
      <th>SNP source : </th>
      <td>
        <input type="checkbox" name="cb_1000g" checked="checked">
        <label>1000 Genomes</label>&nbsp;&nbsp;
        <input type="checkbox" name="cb_exac" checked="checked">
        <label>ExAC</label>&nbsp;&nbsp;
        <input type="checkbox" name="cb_dbsnp" checked="checked">
        <label>dbSNP</label>
      </td>
    </tr>
  </table>
    
</form>

<?php include('tail.inc'); ?>
