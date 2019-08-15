## Plugin architecture  
GenIE-CMS comes with a stable but yet simple-to-start plugin architecture. A plugin is a simple folder with a bunch of PHP files. This would be the simplest form:
```
site/plugins/my-plugin/index.php
```
GenIE-CMS automatically loads all plugins from folders within ```/site/plugins``` and tries to find an ```index.php```.

**Plugins/Modules**

Analysis, expression or genomic tools can be integreated into a CMS as external plugins. Detailed plugin development guidelines will be available under the [plugins section](https://geniecms.readthedocs.io/en/latest/plugins/index.html). GenIE-CMS will contain JBrowse, GeneList, gene information pages and BLAST as standard default plugins. All additional tools(exImage, exNet, Enrichment) can be integrated as external plugins to the GenIE-CMS. 

## Database design  

GenIE-CMS is a file-based CMS with basic content stored in text files. MySQL database is not needed to get started with the CMS. However, the database server is required to load the genomic data and integrate with GenIE-CMS plugins.


