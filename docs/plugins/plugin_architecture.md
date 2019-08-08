## Plugin architecture  
GenIE-CMS comes with a stable but yet simple-to-start plugin architecture. A plugin is a simple folder with a bunch of PHP files. This would be the simplest form:
```
site/plugins/my-plugin/index.php
```
GenIE-CMS automatically loads all plugins from folders within ```/site/plugins``` and tries to find an ```index.php```.