## Gene Information Page

**Overview**  

The Gene information page contains basic information about a gene including sequence, function and family information.

**Basic Usage**

The Gene Information Page consists of dedicated tabs names: Basic Information (including GBrowse details), Sequence, Functional Information, Expression Overview, Gene Family and Publications (including community annotations). The Basic tab gives a quick overview (Chromosome, Description, Synonyms, Arabidopsis id and GBrowse image map) of the gene or the gene model. The Sequence tab contains Genomic-, CDS-, Transcript- and Protein- sequences. You can easily BLAST any of the above sequences by clicking the related BLAST button, and you can extract Upstream or Downstream Genomic sequence by adjusting the upstream/downstream input boxes. 5’ UTR, CDS, 3’ UTR regions are highlighted with dedicated colors. The Functional information tab includes annotations from different data sources including GO, PFAM, PANTHER, KO, EC and KOG. The Expression Overview tab displays the exImage image for the gene, and gives a visual overview of the tissues where the gene is expressed. More tissues/samples are avaiable at the dedicated exImage tool. The Gene Family tab contains gene family information across several different species. You can select a species and download fasta file or create a phylogenetic tree using either Galaxy or Phylogeny.fr. You can also send a gene families to the PlantGenIE GeneList or visualize expression conservation/divergence using the ComPlEX tool. The Community Annotation tab will display the user submitted annotation of gene models. You can edit the current annotation using the WebApollo annotation editor. Once members of PlantGenIE team approved the new submission, it will display inside the Community Annotation tab.

The Gene Information page is the starting point to WebApollo and this will also be the final destination for many of the PlantGenIE tools, for example GBrowse, GeneList or exPlot. There are dedicated pages for both genes and transcripts information.


**Implementation**  

The Gene Information page uses JavaScript, PHP, MySQL, PostgreSQL, JQuery and d3js.
