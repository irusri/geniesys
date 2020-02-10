Load additional genome
======================

Here is quick guide to describe how to load novel genome into GenIE-Sys database or integrate novel genome data with GenIE-Sys installation.  

### Download
Let's assume we need to integrate Populus tremula v2.0 genome into GenIE-System. First we need to download the required files. Latest version of the GFF3 and FASTA files are available on [PlantGenIE FTP](ftp://plantgenie.org/Data/PopGenIE/Populus_tremula/).

```shell
wget ftp://plantgenie.org/Data/PopGenIE/Populus_tremula/v2.2/gff/Potra02_genes.gff.gz
wget ftp://plantgenie.org/Data/PopGenIE/Populus_tremula/v2.2/fasta/Potra02_genome.fasta.gz
gzip -d Potra02_genes.gff.gz
gzip -d Potra02_genome.fasta.gz
```

### Parse genome
Now we need to parse GFF3 and FASTA files into requred formats.
