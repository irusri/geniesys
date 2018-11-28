## exImage
The new exImage provides an intuitive pictographic view of expression data across a diverge range of Microarray and RNASeq datasets. 
It’s implemented based on Javascript frontend and PHP MYSQL webserrvice. It also uses [rsvg-convert](http://manpages.ubuntu.com/manpages/raring/man1/rsvg-convert.1.html) Perl library to convert SVG into PDF.

This tool is based on Javascript. Therfore it is more interactive easy to use and maintain.

## External parameters
Following parameters we can use as GET or POST variables.  
id - gene id  
mode - relative or absolute  
view - Here you can specify the name of your views
exptable - Boolean to visible expression table  
modecontrols - Boolean to visible mode controls  
genelist - Boolean to visible gene list  
allcontrols - Boolean to visible all controls  
download - Boolean to visible download buttons  
exlink - Boolean to visible external eFP link  
zoom - Zoom perecentage

## Database
exImage uses MySQL database and PHP JSON webservice.

## Cookies
exImage keeps temporary variables inside browser cookies to avoid page reloading data losses and increase tool efficiency.


## Example Use
http://localhost/eplant/index.php?allcontrols=[true/false]&exlink=[true/false]&download=[true/false]&mode=[relative/absolute]&view=[name of the view]&zoom=[0-1]&id=[gene id]

[![exImage](http://content.screencast.com/users/Chanm/folders/Jing/media/5b0aa9c3-7a0f-41c5-8e7f-b244e94a9ea7/00000008.png)]
