#!/bin/bash
#declare INPUT* variables
awk  '
#BEGIN { print "start of file." }
{if(substr($1,1,7)=="Potri.0"){
	split($1,a,"Potri.0");split(a[2],b,"G");print "Chr"b[1]"\t"$2"\t"$3"\t"$4"\t"$5"\t"$6"\t"$7"\t"$8"\t"$9;
}else if(substr($1,1,5)=="Potrs"){
	split($1,c,"Potrs");split(c[2],d,"g");print "Potrs"d[1]"\t"$2"\t"$3"\t"$4"\t"$5"\t"$6"\t"$7"\t"$8"\t"$9;
}else if(substr($1,1,5)=="Potra"){
	split($1,e,"Potra");split(e[2],f,"g");print "Potra"f[1]"\t"$2"\t"$3"\t"$4"\t"$5"\t"$6"\t"$7"\t"$8"\t"$9;
}else if(substr($1,1,5)=="Potrx"){
	split($1,g,"Potrx");split(g[2],h,"g");print "Potrx"h[1]"\t"$2"\t"$3"\t"$4"\t"$5"\t"$6"\t"$7"\t"$8"\t"$9;
}else{print}}
#END { print "end of file." } 
'  $1 > $2
