<?php include('head.inc'); ?>

<div class="title1">Predict the start-gain SNPs from the SNPs in you file</div>
<div class="pred">
  <ul>
    <li>You can upload a file here to identify candidate start-gain SNPs. The uploaded file can be a plain text file or a gzip compressed file. There should be four columns seperated by tab in the file: 1. Chromosome; 2. Position; 3. Reference Allele; 4. Alternative Allele</li>
    <li>Here is an <a href="example/input_example.txt" download>example file</a>.</li>
    <li>The ouput file is a tab seperated plain text file.</li>
    <li>If you have uploaded a file previously, you can also retrive the result by ID</li>
  </ul>
  <hr>
</div>

<div class="title1">Upload your file<?php echo infolink('upload'); ?></div>
<form action="down.php" method="post" enctype="multipart/form-data">
  <div align="center">
    <label for="myfile">Select a file:</label>
    <input type="file" id="upfile" name="upfile">
    <input class="submit1" type="submit" name="submit1" value="Upload" onclick="show_loader('loader1'); this.disabled=true;">
    <div class="loader" id="loader1" style="display: none;"></div>
    <div style="padding: 10px 0px 10px 0px;">Or</div>
    <label for="myfid">Retrieve the result by ID:</label>
    <input type="text" id="fid" name="fid" size="50">
    <input class="submit1" type="submit" name="submit2" value="Submit" onclick="show_loader('loader2'); this.disabled=true;">
    <div class="loader" id="loader2" style="display: none;"></div>
  </div>
</form>

<?php include('nsc.js'); ?>
<?php include('tail.inc'); ?>
