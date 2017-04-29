JBrowse
=====================

**Installation**

1.) Download the jbrowse.zip file and unzip into plugins directory.      
2.) Edit database details in services/settings.php file.  

**Manual installation from JBrowse.org - optional**

This is important when you need to convert exsisting JBrowse into GenIE module.  
1.) Copy JBrowse into plugins folder  
2.) Copy index.php and tool.php into jbrowse folder  
3.) Create menu item called jbrowse  
4.) Change plugins plugins/jbrowse/main.css and plugins/jbrowse/genome.css   
5.) Copy pugins/jbrowse/index.html into plugins/jbrowse/tool.php from jbrowse.zip  
6.) Copy plugins/jbrowse/src/dojo/dojo.css from jbrowse.zip    
7.) Copy plugins/jbrowse/src/dijit/theme/tundra/tundra.css from jbrowse.zip  

**Loading data into JBrowse**

`
bin/prepare-refseqs.pl --fasta ../../data/Egrandis_297_v2.0.fa
bin/flatfile-to-json.pl --gff ../../data/Egrandis_297_v2.0.gene.gff3 --trackLabel E.Genes --trackType CanvasFeatures 
bin/generate-names.pl -v
`

**Usage**

Navigate to http://[your server name]/genie/jbrowse
