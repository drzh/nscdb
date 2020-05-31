<?php include('head.inc'); ?>

<?php
$hid = '';
if (isset($_GET['hid'])) {
  $hid = $_GET['hid'];
}
?>

<div class='title1'>Help topics</div>
<div class='help'>
  <p <?php echo "class='", ($hid == "search") ? "hl" : "que", "'"; ?> id='search'>
    Terms that can be used to search the novel start codon mutations
  </p>
  <p class='ans'>
    <ul>
      <li><i>Genome Position (GRCh38)</i> (e.g., chr9:2158532 or 9:2158532)</li>
      <li><i>Genome Region (GRCh38)</i> (e.g., chr9:100000-6000000 or 9:100000-6000000)</li>
      <li><i>Gencode/Ensembl Transcript ID</i> (e.g., ENST00000417599)</li>
      <li><i>Gencode/Ensembl Gene ID</i> (e.g., ENSG00000080503)</li>
      <li><i>RefSeq ID</i> (e.g., NM_001032280)</li>
      <li><i>Gene symbol</i> (e.g., CETP)</li>
      <li><i>Description of the gene</i> (e.g., SH2 domain)</li>
    </ul>
  </p>
  <p <?php echo "class='", ($hid == "filter") ? "hl" : "que", "'"; ?> id='filter'>
    Filters used to select the records
  </p>
  <p class='ans'>
    <ul>
      <li><i>Frame of novel CDS</i>: Whether the CDS introduced by the novel start codon is in the frame with the original CDS.</li>
      <li><i>Position of the stop codon</i>: The stop codon of the novel CDS can be loacted before the original start codon or after the stop codon. If the stop codon is located before the original start codon, the novel CDS is totally located within 5'UTR of the transcript. If the stop codon is located after the original start codon, the novel CDS is overlapped with the original CDS.</li>
      <li><i>Whether the novel start codon is located within any known CDS</i>: The novel start codon in one isoform/transcript may be within the CDS of the other isofomr/transcript.</li>
      <li><i>SNP source</i>: Only show stat-gain SNPs existing in the given databases/projects, including <a href="https://www.internationalgenome.org/" target="_blank">1000 Genomes</a>, <a href="https://gnomad.broadinstitute.org/downloads" target="_blank">ExAC (r1)</a>, <a href="https://gnomad.broadinstitute.org/" target="_blank">gnomAD (v3)</a> and <a href="https://www.ncbi.nlm.nih.gov/snp/" target="_blank">dbSNP (151)</a></li>
      <li>Kozak sequence score: Only show the novel start codon with a Kozak sequence with score greater than the given value.</li>
    </ul>
  </p>
  <p <?php echo "class='", ($hid == "kozak") ? "hl" : "que", "'"; ?> id='kozak'>
    Estimation of the Kozak sequence score
  </p>
  <p class='ans'>
    Based on the annotation from <a href="https://www.gencodegenes.org/human/release_30.html" target="_blank">GENCODE v30</a>,19,497 non-redundant transcripts with transcript supporting level 1 (TSL=1) were used to estimate the scoring matrix of the Kozak sequences. The nucleotide sequences from -6nt to 5nt (the position of the first nucleotide 'A' of the start codon 'ATG' was 0) around the start codon of each transcript was extracted to construct a scoring matrix representing the Kozak sequence feature. This scoring matrix was applied to calculate the Kozak sequence score for each potential novel start codons.
  </p>
  <p <?php echo "class='", ($hid == "export") ? "hl" : "que", "'"; ?> id='export'>
    Download the search result
  </p>
  <p class='ans'>
    Click the 'Export records' to download the search results. The downloaded file is a plain text file.
  </p>
  <p <?php echo "class='", ($hid == "nscinfo") ? "hl" : "que", "'"; ?> id='nscinfo'>
    Detailed information of start-gain SNP and novel start codon
  </p>
  <p class='ans'>
    <ul>
      <li><i>Genome Position</i>: Genome position of the start-gain SNP. Both GRCh38(hg38) and GRCh37(hg19) positions were provided. External link to UCSC genome browser was provided.</li>
      <li><i>dbSNP RefSNP ID</i>: SNP ID in dbSNP. External link to dbSNP was provided.</li>
      <li><i>Strand</i>: The genome strand of transcript where the novel start codon is located.</li>
      <li><i>Alleles</i>: The reference allele and alternative allele in the genome and transcript. If the transcript is on the '+' strand of the reference genome, the alleles in the genome are the same with the alleles in the transcript. If the transcript is on the '-' strand of the reference genome, the alleles in the genome are complementary with the alleles in the transcript.</li>
      <li><i>Position in Transcript</i>: The position of SNP in the transcript. '0' represents the position of the first nucleotide 'A' in the original start codon 'ATG'. Negative value means this SNP is located within the 5'UTR of the transcript.</li>
      <li><i>Frame of New CDS</i>: '0' represents the frame of the novel CDS is the same with the original CDS. If the Novel CDS can extend to the original CDS, the novel CDS becomes an extra CDS added to the 5'UTR of the original CDS.</li>
      <li><i>Transcript ID</i>: Transcript ID from Gencode/Ensembl</li>
      <li><i>Gene ID</i>: Gene ID from Gencode/Ensembl</li>
      <li><i>Symbol</i>: Symbol of the transcript or gene</li>
      <li><i>Length of Novel CDS</i>: If the frame of the novel CDS is 0 and the novel CDS can be extended to the original start codon, the length of the novel CDS is from the novel start codon to the original start codon. Otherwise, the length of the novel CDS is from the novel start codon to the stop codon of the novel CDS or the end of the transcript (no stop codon was found in the novel CDS)</li>
      <li><i>Allele Frequency</i>: Allele frequencies of the alternative allele (allele that introduce the novel start codon) from 1000 Genomes, ExAC and gnomAD datasets.</li>
      <li><i>Gene Description</i>: Description of the gene</li>
      <li><i>Novel CDS and Peptide</i>: The sequence of the novel CDS and peptide. The complete novel CDS and 6 nucleotides before the novel start codon were showed. The start-gain SNP was also showed at the corresponding position.</li>
      <li><i>Kozak Sequence (Score)</i>: Kozak sequence around the novel start codon and its score. The length of the Kozak sequence included the 6 nucleotides before the start codon and 3 nucleotides after the start codon. If the novel start codon is within the first 6 nucleotides of the transcript, then the first few bases were represented as '.' to make the kozak sequence with a length of 12nt.</li>
    </ul>
  </p>
  <p <?php echo "class='", ($hid == "samemut") ? "hl" : "que", "'"; ?> id='samemut'>
    Why are there several records of novel start codons for the same SNP?
  </p>
  <p class='ans'>
    The same position in the genome can be expressed in different isoforms/transcripts of one gene. Thus one mutation can introduce novel start codons in multipe isoforms/transcripts from the same gene.
  </p>
</div>

<?php include('tail.inc'); ?>
