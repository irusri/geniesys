
BLAST
=====================

**Implementation**

PlantGenIE BLAST search is implemented using NCBI Blast (v2.2.26) and no database will be used. config.json files contains all necessary.  We use PHP, JavaScript, XSL, Perl and d3js, Drupal libraries to improve Open Source GMOD Bioinformatic Software Bench server to provide a graphical user interface.

**Libraries**

Makesure ubuntu taskspooler and blastall properly installed into /use/bin

````shell
use DBI;
use Bio::Tools::GFF;
use File::Basename;
use Bio::SearchIO;
use Bio::SearchIO::Writer::HTMLResultWriter;
use Bio::SearchIO::Writer::TextResultWriter;
use Bio::SearchIO::Writer::GbrowseGFF;
use Bio::Graphics;
use Bio::FeatureIO;
use Bio::SeqFeature::Generic;
````

**Installation**

Download the BLAST tool plugin from [here](https://github.com/irusri/GenIECMS/tree/master/plugins). Then place it into your `CMS/plugins/` folder.

**Adding Datasets**

Adding a dataset into BLAST tool we must use [formatdb](http://structure.usc.edu/blast/formatdb.html) or [makeblastdb](http://nebc.nerc.ac.uk/bioinformatics/documentation/blast+/user_manual.pdf) tools. `Config.json` file contains all necessary configuration parameters to add new datasets into existing BLAST tool. An  example of config.json file looks like following:

```json
{
"selecttion_box":[{"height":180,"width":400}],
"datasets":[{
   	 "number": 1,
        	 "user_friendly_name": "A Label which appears in the Tool",
		 "dataset_path":"/path/to/the/blast/indices",
            "molecule_type":"nucleotide/protein",
            "group_name":"Group Name"
    },{
        	 "number": 2,
        	 "user_friendly_name": "A Label which appears in the Tool",
		 "dataset_path":"/path/to/the/blast/indices",
            "molecule_type":"nucleotide/protein",
            "group_name":"Group Name"
    }],
"default_jbrowse_dataset_directory":"Fegr20"
}
```

- number: This is an incremental unique number to identify the dataset id.  
- user_friendly_name: This name will be appeared as dataset name  inside the BLAST tool.  
- molecule_type: This value should be either nucleotide or protein.  
- group_name: Group name helps to grouping the datasets based on similarity.  
