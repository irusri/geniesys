|readthedocs|

## GenIECMS
The Genome Integrative Explorer Content Management System (GenIE-CMS) is the first dedicative in-house CMS to facilitate external groups in setting up their own web resource for searching, visualizing, editing, sharing and reproducing their genomic and transcriptomic data while using project raw data(gff3,fasta,fatsq) as an input.


###Use GFF3 file and generate source input file to load into gene_info mysql table
awk -F"\t" '/gene/{split($9,a,"ID=");split(a[2],b,";");print b[1]"\t"$1"\t"$4"\t"$5"\t"$7}' input/Potra01-gene-mRNA-wo-intron.gff3 > input/gene_info.txt

###Load above generated source file into gene_info table
./load_data.sh gene_info gene_info.txt

##Use GFF3 and generate source input file to load into transcript_info mysql table
awk -F"\t" '/mRNA/{split($9,a,"ID=");split(a[2],b,";");split(b[1],c,".");print b[1]"\t"c[1]"\t"$1"\t"$4"\t"$5"\t"$7}' input/Potra01-gene-mRNA-wo-intron.gff3 > input/transcript_info.txt

###Load previously generated source file into transcript_info table
./load_data.sh transcript_info transcript_info.txt

###Load sequence coloring table
./sequence_coloring.sh input/Potra01-gene-mRNA-wo-intron.gff3

###Load gene description
./update_descriptions.sh gene_info input/Potra01.1_gene_Description.tsv

#Load transcript description
./update_descriptions.sh transcript_info input/Potra01.1_transcript_Description.tsv

###Load Annotations
###Let's assume, if we have Best BLAST atg Ids which are corresponding to Poplar ids. Results file will look like following example.

Potra000001g00001.1	AT5G39130.1
Potra000001g00002.1	AT5G39130.1
Potra000002g00003.1	AT4G21215.2
Potra000002g00005.1	AT4G21200.1	ATGA2OX8,GA2OX8
Potra000002g00005.2	AT4G21200.1	ATGA2OX8,GA2OX8
Potra000002g00005.3	AT4G21200.1	ATGA2OX8,GA2OX8
Potra000002g00005.4	AT4G21200.1	ATGA2OX8,GA2OX8
Potra000002g00005.5	AT4G21200.1	ATGA2OX8,GA2OX8
Potra000002g00006.1	AT1G61770.1
Potra000002g00006.2	AT1G61770.1

###We will load above file into following table.
###mysql> explain transcript_atg;
+-----------------+------------------------+------+-----+---------+-------+
| Field           | Type                   | Null | Key | Default | Extra |
+-----------------+------------------------+------+-----+---------+-------+
| transcript_id   | varchar(255)           | NO   | PRI | NULL    |       |
| atg_id          | varchar(24)            | NO   | MUL | NULL    |       |
| atg_description | varchar(255)           | YES  |     | NULL    |       |
| transcript_i    | mediumint(20) unsigned | NO   | PRI | NULL    |       |
+-----------------+------------------------+------+-----+---------+-------+
4 rows in set (0.00 sec)

./load_data.sh transcript_atg input/potra_genelist_atg.txt transcript_id
./update_transcript_i.sh transcript_atg

###Finally update the gene_i
update_gene_i.sh
### Following script will update the gene_i in gene_[go/pfam/kegg] tables
update_annotation_gene_i.sh  gene_[go/pfam/kegg]
</pre>
