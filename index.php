<?php include('head.inc'); ?>

<div class="info">
  <font color="red">Welcome to Novel Start Codons Database:</font>
  <ul style="margin-block-start: 0.5em">
    <li>NSCDB provides information on SNPs that introduced potential novel start codons in the human genomes</li>
    <li>You can search and browse the candidate novel start codons</li>
  </ul>
</div>
<hr>

<div class="title1">Search<?php echo infolink('search'); ?></div>
<form action="/list.php" method="get">
  <div align="center">
    <table>
      <tr>
        <td>
          <input type="text" name="kw" id="input1" size="60" placeholder="enter position, region, gene symbol or search terms" >
          <input class="submit1" type="submit" value="Submit" onclick="show_loader('loader1'); this.disabled=true;">
          <div class="loader" id='loader1' style="display: none;"></div>
        </td>
      </tr>
      <tr>
        <td>
          &nbsp;&nbsp;e.g., <a onclick="javascript: document.getElementById('input1').value='9:100000-6000000'">9:100000-6000000</a>,
          <a onclick="javascript: document.getElementById('input1').value='CETP'">CETP</a>,
          <a onclick="javascript: document.getElementById('input1').value='ENST00000540585'">ENST00000540585</a>
        </td>
      </tr>
    </table>
  </div>
  <div class="title1">Filters<?php echo infolink('filter'); ?></div>
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
        <input type="checkbox" name="cb_gnomad" checked="checked">
        <label>gnomAD</label>&nbsp;&nbsp;
        <input type="checkbox" name="cb_dbsnp" checked="checked">
        <label>dbSNP</label>
      </td>
    </tr>
    <tr>
      <th>Kozak sequence score : </th>
      <td>
        <label>&nbsp;&#62;</label>&nbsp;
        <input type="text" name="tx_kozak" size="2">
        <label>&nbsp;&nbsp;(Input a number between -10 and 7.1)<?php echo infolink('kozak'); ?></label>
      </td>
    </tr>
  </table>
</form>

<?php include('nsc.js'); ?>
<?php include('tail.inc'); ?>
