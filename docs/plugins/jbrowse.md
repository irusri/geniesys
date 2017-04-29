JBrowse
=====================

**Installation**

  1.) Download the jbrowse.zip file and unzip into plugins directory.
  2.) Edit database details in `services/settings.php` file.   

**Manual installation from JBrowse.org - optional**

Following steps are important when you need to convert existing JBrowse into GenIE module.  
- Copy JBrowse into plugins folder  
- Copy `index.php` and `tool.php` into jbrowse folder  
- Create menu item called jbrowse  
- Change plugins `plugins/jbrowse/main.css` and `plugins/jbrowse/genome.css`   
- Copy `pugins/jbrowse/index.html` into `plugins/jbrowse/tool.php` from jbrowse.zip  
- Copy `plugins/jbrowse/src/dojo/dojo.css` from jbrowse.zip  
- Copy `plugins/jbrowse/src/dijit/theme/tundra/tundra.css` from jbrowse.zip   

**Loading data into JBrowse**

```shell
bin/prepare-refseqs.pl --fasta ../../data/Egrandis297v2.0.fa
bin/flatfile-to-json.pl --gff ../../data/Egrandis297v2.0.gene.gff3 --trackLabel E.Genes --trackType CanvasFeatures
bin/generate-names.pl -v

```

**Usage**

Navigate to `http://[your server name]/genie/jbrowse`
