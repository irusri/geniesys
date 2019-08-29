## BLAST

<strong>Overview</strong>

The BLAST (Basic Local Alignment Search Tool) tool compares input sequences with datasource to identify homologous sequence matches.

<strong>Basic Usage</strong>

Paste your sequence (with or without a FASTA header) into the query input text box.   Transcript sequence can be extracted by type in a gene ID into the Load example text box or upload a sequence file (Less than 100 MB)with the upload file function. Then click and select the desired dataset from the lists of available BLAST databases and click the BLAST! Button at the bottom of the page.

BLAST plugin uses standard default NCBI BLAST options. However users can change the following advanced options:
<table>
<thead>
<tr>
<th width="20%"><strong>Option</strong></th>
<th><strong>Description</strong></th>
</tr>
</thead>
<tbody>
<tr>
<td>Scoring matrix</td>
<td>Substitution matrix that determines the cost of each possible residue mismatch between query and target sequence. See BLAST <a class="ext" href="http://www.ncbi.nlm.nih.gov/blast/html/sub_matrix.html" target="_blank">substitution matrices</a> for more information.</td>
</tr>
<tr>
<td>Filtering</td>
<td>Whether to remove low complexity regions from the query sequence.</td>
</tr>
<tr>
<td>E-value cutoff</td>
<td>The maximum expectation value of retained alignments.</td>
</tr>
<tr>
<td>Query genetic code</td>
<td>Genetic code to be used in blastx translation of the query.</td>
</tr>
<tr>
<td>DB genetic code</td>
<td>Genetic code to be used in blastx translation of the datasets.</td>
</tr>
<tr>
<td>Frame shift penalty</td>
<td>Out-of-frame gapping (blastx, tblastn only) [Integer] default = 0.</td>
</tr>
<tr>
<td>Number of results</td>
<td>The maximum number of results to return.</td>
</tr>
</tbody>
</table>



<br>
<strong>BLAST results</strong>

The BLAST Results page will be automatically reloaded until the search results are successfully retrieved. BLAST results are organized into a table containing Query ID, Hit ID, Average bit score (top), Average e-value (lowest), Average identity (av. similarity) and Links. Clickable BLAST results display the corresponding region of identified homology within the JBrowse tool, where the matching region is shown.


<strong>Implementation</strong>

 BLAST search tool is implemented using NCBI Blast (v2.2.26) and a backend PostgresSQL Chado database. We use PHP, JavaScript, XSL, Perl and d3js, Drupal libraries to improve Open Source GMOD Bioinformatic Software Bench server to provide a graphical user interface.

