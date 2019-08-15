## Plugin architecture  
GenIE-CMS comes with a stable but yet simple-to-start plugin architecture. A plugin is a simple folder with a bunch of PHP files. This would be the simplest form:
```
site/plugins/my-plugin/index.php
```
GenIE-CMS automatically loads all plugins from folders within ```/site/plugins``` and tries to find an ```index.php```.

Analysis, expression or genomic tools ([Sundell et al., 2015](https://nph.onlinelibrary.wiley.com/doi/full/10.1111/nph.13557)) are integreated into a CMS as external plugins. GenIE-CMS contains JBrowse, GeneList, gene information pages and BLAST as standard default plugins. All additional tools (exImage, exNet, Enrichment) can be integrated as external plugins to the GenIE-CMS. 

