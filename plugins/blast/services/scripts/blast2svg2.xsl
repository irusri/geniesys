<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
 version="1.0"
 xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
 xmlns:svg="http://www.w3.org/2000/svg"
 xmlns:xlink="http://www.w3.org/1999/xlink"
 xmlns:h="http://www.w3.org/1999/xhtml"
 >
<!-- ========================================================================= -->
<xsl:output method='xml' indent='yes' omit-xml-declaration="no"/>
<!-- we preserve the spaces in that element -->
<xsl:preserve-space elements="svg:style style" />

<!-- ========================================================================= -->
<!-- the width of the SVG -->
<xsl:variable name="svg-width">1104</xsl:variable>

<!-- height of a HSP -->
<xsl:variable name="hsp-height">14</xsl:variable>

<!--  total number of iteration  -->
<xsl:variable name="tootal-iterations"><xsl:value-of select="count(BlastOutput/BlastOutput_iterations/Iteration/Iteration_iter-num)"/></xsl:variable> 

<!-- total number of Hits in first blast iteration -->
<xsl:variable name="hit-count"><xsl:value-of select="count(BlastOutput/BlastOutput_iterations/Iteration[1]/Iteration_hits/Hit)"/></xsl:variable>

<xsl:variable name="hit-accession"><xsl:value-of select="BlastOutput/BlastOutput_iterations/Iteration[1]/Iteration_hits/Hit/Hit_accession"/></xsl:variable>
<!-- total number of HSP in first blast iteration -->
<xsl:variable name="hsp-count"><xsl:value-of select="count(BlastOutput/BlastOutput_iterations/Iteration[1]/Iteration_hits/Hit/Hit_hsps/Hsp)"/></xsl:variable>
<!-- query length (bases or amino acids ) -->
<xsl:variable name="query-length"><xsl:value-of select="BlastOutput/BlastOutput_query-len"/></xsl:variable>
<!-- margin between two hits -->
<xsl:variable name="space-between-hits"><xsl:value-of select="3* $hsp-height"/></xsl:variable>
<!-- height of all hits -->
<xsl:variable name="hits-height"><xsl:value-of select="$hsp-count * $hsp-height + ($hit-count + 1 ) * $space-between-hits"/></xsl:variable>
<!-- size of the top header -->
<xsl:variable name="header-height">0</xsl:variable>

<!-- ========================================================================= -->

<!-- matching the root node -->
<xsl:template match="/">
<!-- start XHTML -->
<!--
<html>
<head>
	<svg:style type="text/css">
	body	{
		font-size:12px;
		font-family:Helvetica; 
		background: #fbfaf7;
		color:white;
        height:auto;
        
		}
	</svg:style>
</head>
<body >
<h1>Blast Results</h1>-->
<!--<title><xsl:value-of select="BlastOutput/BlastOutput_query-def"/></title>-->
<!--<div>
<h3>Parameters</h3>
  <table>
	<tr><th>Database</th><td><xsl:value-of select="BlastOutput/BlastOutput_db"/></td></tr>
	<tr><th>Query ID</th><td><xsl:value-of select="BlastOutput/BlastOutput_query-ID"/></td></tr>
	<tr><th>Query Def.</th><td><b><xsl:value-of select="BlastOutput/BlastOutput_query-def"/></b></td></tr>
	<tr><th>Query Length</th><td><b><xsl:value-of select="BlastOutput/BlastOutput_query-len"/></b></td></tr>
	<tr><th>Version</th><td><xsl:value-of select="BlastOutput/BlastOutput_version"/></td></tr>
	<tr><th>Reference</th><td><a href="http://www.ncbi.nlm.nih.gov/pubmed/9254694"><xsl:value-of select="BlastOutput/BlastOutput_reference"/></a></td></tr>
  </table>
</div>
<hr/>-->
<!--<div style="text-align:center">-->

<!-- starts SVG figure -->
<xsl:element name="svg:svg">
<xsl:attribute name="version">1.0</xsl:attribute>
<xsl:attribute name="width"><xsl:value-of select="$svg-width"/></xsl:attribute>
<xsl:attribute name="height"><xsl:value-of select="$hits-height + $header-height+40 "/></xsl:attribute>
<svg:title><xsl:value-of select="BlastOutput/BlastOutput_query-def"/></svg:title>

<b><xsl:value-of select="$tootal-iterations"/></b>
  


<svg:defs >
<svg:style  type="text/css">

svg:rect{
fill: #fbfaf7;
}

text.t1	{
	fill:black;
	font-size:<xsl:value-of select="$hsp-height"/>px;
	
	 font-family: Verdana, Tahoma, Geneva, sans-serif;
	}
text.t2	{
 cursor:pointer;
	fill:red;
	<!--font-size:<xsl:value-of select="$space-between-hits - 2"/>px;-->
    font-size:12px;
		 font-family: Verdana, Tahoma, Geneva, sans-serif;
	text-anchor:middle;
  /*  font-weight:bold;*/
	}
text.title	{
	fill:white;
	stroke:black;
	font-size:12px;
	font-family:Helvetica; 
	text-anchor:middle;
	alignment-baseline:middle;
	}
line.grid	{
		stroke:lightgray;
		stroke-width:1.5px;
		}
		
rect.hit	{
cursor:pointer;
	fill:none;
	stroke:darkgray;
	stroke-width:1px;
	}
    
    rect.rect1{
    cursor:pointer;
    
    }
    
   rect1:hover{
           cursor:pointer;
        }
    
    
     .tooltip{
     text-align:left;
	 font-family: Verdana, Tahoma, Geneva, sans-serif;
	font-size: 14px;
    fill:#222;
   z-index:40;
    
    }
    .tooltip_bg{
	fill: #F0F8FF;
   z-index:40;
	stroke: #808285;
	stroke-width: 0.5;
	/*opacity: 0.85;*/
    
    }
    
</svg:style>

	<svg:script type="text/ecmascript">



   function init(evt)
	{
	if ( window.svgDocument == null )
	    {
		svgDocument = evt.target.ownerDocument;
	    }
        tooltip = svgDocument.getElementById('tooltip');
        tooltip2 = svgDocument.getElementById('tooltip2');
	    tooltip_bg = svgDocument.getElementById('tooltip_bg');

	}
  
    
    function ShowTooltip(evt, accession,from,to)
	{
    	init(evt);
    	if(from>to){
    	mouseovertext=to+' to '+from +' (-)'; 
	    }else{
        mouseovertext=from+' to '+to +' (+)'; 
        }
        
        if(tooltip.getComputedTextLength()>tooltip2.getComputedTextLength()){
        length = tooltip.getComputedTextLength();
        }else{
        length = tooltip2.getComputedTextLength();
        }
        
        tooltip.firstChild.data = "This is a HSP spaning "+accession;
	    tooltip.setAttributeNS(null,"visibility","visible");
        
        tooltip2.firstChild.data = "from "+ mouseovertext+ ". Click for more details";
	    tooltip2.setAttributeNS(null,"visibility","visible");
      
        tooltip_bg.setAttributeNS(null,"width",length+12);
        
        if(evt.clientX>550){
        tooltip.setAttributeNS(null,"x",evt.clientX-length+5);
	    tooltip.setAttributeNS(null,"y",evt.clientY+30); 
        
        tooltip2.setAttributeNS(null,"x",evt.clientX-length+5);
	    tooltip2.setAttributeNS(null,"y",evt.clientY+44);
        
        tooltip_bg.setAttributeNS(null,"x",evt.clientX-length);
	    tooltip_bg.setAttributeNS(null,"y",evt.clientY+14);
              
        }else{
        tooltip.setAttributeNS(null,"x",evt.clientX+15);
	    tooltip.setAttributeNS(null,"y",evt.clientY+30);
        
        tooltip2.setAttributeNS(null,"x",evt.clientX+15);
	    tooltip2.setAttributeNS(null,"y",evt.clientY+44);
        
        tooltip_bg.setAttributeNS(null,"x",evt.clientX+8);
	    tooltip_bg.setAttributeNS(null,"y",evt.clientY+14);
        
        }
	  	tooltip_bg.setAttributeNS(null,"visibility","visibile");
	}

	function HideTooltip(evt,accession,from,to)
	{
    	init(evt);
	    tooltip.setAttributeNS(null,"visibility","hidden");
        tooltip2.setAttributeNS(null,"visibility","hidden");
	    tooltip_bg.setAttributeNS(null,"visibility","hidden");
	}


    function gototheGBrowse(accession,from,to){
		if(from>to){
    	cordinates=to+'..'+from; 
	    }else{
        cordinates=from+'..'+to;
        }

//var str="<xsl:value-of select="BlastOutput/BlastOutput_db"/>"; 
//var n=str.search("Ptrichocarpa_210");
//var str="<xsl:value-of select="BlastOutput/BlastOutput_db"/>"; 
//var n=str.search("Ptrichocarpa_210");
//console.log(accession);
//console.log(evt, accession,from,to);
//BlastOutput_query-def


//if(n>1){

    //    window.open('http://popgenie.org/gbrowse?enable=UserBlast;name='+accession+':'+cordinates);
 //       }else{
        window.open('http://popgenie.org/gbrowse?accession='+accession+'&#38;cordinates='+cordinates+'&#38;enable=UserBlast;'); 
  //      }

    }


var urlpaths=window.location.search;
var cookie_path = urlpaths.split("=");
setCookie('uid_new',cookie_path[1],7); 

function setCookie(c_name,value,exdays)
{
var exdate=new Date(); 
exdate.setDate(exdate.getDate() + exdays);
var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
document.cookie=c_name + "=" + c_value+ ";path=/";
}


</svg:script>
<svg:linearGradient  x1="0%" y1="0%" x2="0%" y2="100%" id="score1">
	<svg:stop offset="45%" stop-color="#d84c4f" /><!--red-->
	<svg:stop offset="5%" stop-color="#d84c4f" />
	<svg:stop offset="95%" stop-color="#d84c4f" />
</svg:linearGradient>
<svg:linearGradient  x1="0%" y1="0%" x2="0%" y2="100%" id="score2">
	<svg:stop offset="5%" stop-color="#7ca49e" /><!--blue-->
	<svg:stop offset="50%" stop-color="#7ca49e" />
	<svg:stop offset="95%"  stop-color="#7ca49e" />
</svg:linearGradient>
<svg:linearGradient x1="0%" y1="0%" x2="0%" y2="100%" id="score3">
	<svg:stop offset="5%" stop-color="#6e874d" /><!--green-->
	<svg:stop offset="50%" stop-color="#6e874d" />
	<svg:stop offset="95%" stop-color="#6e874d" />
</svg:linearGradient>
<svg:linearGradient x1="0%" y1="0%" x2="0%" y2="100%" id="score4">
	<svg:stop offset="5%" stop-color="#b1c6a9" /><!--blue-->
	<svg:stop offset="50%" stop-color="#b1c6a9" />
	<svg:stop offset="95%" stop-color="#b1c6a9" />
</svg:linearGradient>
<svg:linearGradient x1="0%" y1="0%" x2="0%" y2="100%" id="score5">
	<svg:stop offset="5%" stop-color="#32302b" />
	<svg:stop offset="50%" stop-color="#32302b" />
	<svg:stop offset="95%" stop-color="#32302b" />
</svg:linearGradient>
</svg:defs>

<xsl:element name="svg:rect">
    <xsl:attribute name="x">0</xsl:attribute>
    <xsl:attribute name="y"></xsl:attribute>
    <xsl:attribute name="width"><xsl:value-of select="$svg-width - 1"/></xsl:attribute>
    <xsl:attribute name="height"><xsl:value-of select="$hits-height + $header-height "/></xsl:attribute>
    <xsl:attribute name="fill">#fbfaf7</xsl:attribute>
    <xsl:attribute name="stroke">#fbfaf7</xsl:attribute>
  </xsl:element>

<!-- Query length bar -->
  <!--<xsl:element name="svg:rect">
    <xsl:attribute name="x">0</xsl:attribute>
    <xsl:attribute name="y">0</xsl:attribute>
    <xsl:attribute name="width"><xsl:value-of select="BlastOutput/BlastOutput_query-len*5"/></xsl:attribute>
    <xsl:attribute name="height">2</xsl:attribute>
    <xsl:attribute name="fill">#d84c4f</xsl:attribute>
    <xsl:attribute name="stroke">#d84c4f</xsl:attribute>
  </xsl:element>-->
  
 <xsl:apply-templates select="BlastOutput"/>
</xsl:element>
<!-- end SVG figure -->

<!--</div>-->
 <!--<hr/>
<xsl:apply-templates select="BlastOutput/BlastOutput_param/Parameters"/>
<hr/>
<p><b>SVG</b> figure generated with <a href="http://code.google.com/p/lindenb/source/browse/trunk/src/xsl/blast2svg.xsl">blast2svg</a>. <a href="http://plindenbaum.blogspot.com">Pierre Lindenbaum PhD</a> <i>( plindenbaum at yahoo dot fr )</i></p>-->

<!--</body>
</html>-->
</xsl:template>
<!-- ========================================================================= -->
<!-- display parameters in a HTML table -->
<xsl:template match="Parameters">
<div>
<h3>Parameters</h3>
  <table>
	<tr><th>Expect</th><td><xsl:value-of select="Parameters_expect"/></td></tr>
	<tr><th>Sc-match</th><td><xsl:value-of select="Parameters_sc-match"/></td></tr>
	<tr><th>Sc-mismatch</th><td><xsl:value-of select="Parameters_sc-mismatch"/></td></tr>
	<tr><th>Gap-open</th><td><xsl:value-of select="Parameters_gap-open"/></td></tr>
	<tr><th>Gap-extend</th><td><xsl:value-of select="Parameters_gap-extend"/></td></tr>
	<tr><th>Filter</th><td><xsl:value-of select="Parameters_filter"/></td></tr>
  </table>
</div>

<!--<xsl:for-each select="$tootal-iterations">
<p><xsl:value-of select="Iteration_iter-num"/></p>
</xsl:for-each>-->

</xsl:template>



<!-- ========================================================================= -->
<xsl:template match="BlastOutput">
<xsl:apply-templates select="BlastOutput_iterations/Iteration[1]/Iteration_hits"/>
<svg:g>
  <!-- paint header -->

	<xsl:element name="svg:rect">
	<xsl:attribute name="x">0</xsl:attribute>
	<xsl:attribute name="y">0</xsl:attribute>
    <xsl:attribute name="rx">4</xsl:attribute>
	<xsl:attribute name="ry">4</xsl:attribute>
	<xsl:attribute name="width">55</xsl:attribute>
    <xsl:attribute name="visibility">hidden</xsl:attribute>
	<xsl:attribute name="height">40</xsl:attribute>
	<!--<xsl:attribute name="fill">red</xsl:attribute>
	<xsl:attribute name="stroke">black</xsl:attribute>-->
    <xsl:attribute name="id">tooltip_bg</xsl:attribute>
    <xsl:attribute name="class">tooltip_bg</xsl:attribute>
</xsl:element>
	
	<xsl:element name="svg:text">
        <xsl:attribute name="id">tooltip</xsl:attribute>
		<xsl:attribute name="x">0</xsl:attribute>
        <xsl:attribute name="visibility">hidden</xsl:attribute>        
		<xsl:attribute name="y">10</xsl:attribute>
		<xsl:attribute name="class">tooltip</xsl:attribute>
		<xsl:value-of select="BlastOutput_query-def"/>test
      </xsl:element>
      
  
  </svg:g>
  

</xsl:template> 

<!-- ========================================================================= -->

<xsl:template match="Iteration_hits">
  <xsl:apply-templates select="Hit"/>
</xsl:template> 

<!-- ========================================================================= -->

<xsl:template match="Hit">

  <xsl:variable name="preceding-hits"><xsl:value-of select="count(preceding-sibling::Hit)"/></xsl:variable>
    <!-- count number of preceding hits -->

     <!-- count number of preceding hsp -->
    <xsl:variable name="preceding-hsp"><xsl:value-of select="count(preceding-sibling::Hit/Hit_hsps/Hsp)"/></xsl:variable>
    <!-- calculate hieght of this part -->
    <xsl:variable name="height"><xsl:value-of select="count(Hit_hsps/Hsp)*$hsp-height"/></xsl:variable>
    <!-- translate this part verticaly -->
    <xsl:element name="svg:g">
      <!--  <xsl:attribute name="onclick">window.top.location='http://spruce.plantphys.umu.se/cgi-bin/gbrowse3/gbrowse/Poplarv3/?name=<xsl:value-of select="Hit_accession"/>:	1..<xsl:value-of select="Hit_len"/>';</xsl:attribute>-->
      <xsl:attribute name="transform">translate(0,<xsl:value-of select="$header-height + $preceding-hsp * $hsp-height + ($preceding-hits + 1) * $space-between-hits "/>)</xsl:attribute>
      <xsl:attribute name="id">hit-<xsl:value-of select="generate-id(.)"/></xsl:attribute>
	<xsl:element name="svg:text">
		<xsl:attribute name="x"><xsl:value-of select="$svg-width div 6"/></xsl:attribute>
		<xsl:attribute name="y"><xsl:value-of select="-2"/></xsl:attribute>
		<xsl:attribute name="class">t2</xsl:attribute>
        <xsl:value-of select="Hit_accession"/>
	</xsl:element>
<!--     <xsl:variable name="hit-accessions"><xsl:value-of select="Hit_def"/></xsl:variable>
-->	<xsl:element name="svg:rect">
<!--chanaka		<xsl:attribute name="x">0</xsl:attribute>
		<xsl:attribute name="y">0</xsl:attribute>
		<xsl:attribute name="width"><xsl:value-of select="$svg-width"/></xsl:attribute>
		<xsl:attribute name="height"><xsl:value-of select="$height"/></xsl:attribute>
		<xsl:attribute name="class">hit</xsl:attribute>-->
	</xsl:element>
	
	<xsl:call-template name="grid">
<!--chanaka		<xsl:with-param name="x" select="0"/>
		<xsl:with-param name="d" select="20"/>
		<xsl:with-param name="W" select="$svg-width"/>
		<xsl:with-param name="H" select="$height"/>-->
	</xsl:call-template>
	
	<xsl:apply-templates select="Hit_hsps"/>
	
	
	
    </xsl:element>
</xsl:template>
 
<!-- ========================================================================= -->
<!-- draw vertical lines , recursive template -->
<xsl:template name="grid">
	<xsl:param name="x" select="0" />
	<xsl:param name="d" select="20" />
	<xsl:param name="W" select="0" />
	<xsl:param name="H" select="0" />
	<svg:line class="grid" x1="{$x}" x2="{$x}" y1="0" y2="{$H}"/>
	<xsl:if test="$d + $x &lt; $W">
		<xsl:call-template name="grid">
			<xsl:with-param name="x" select="$d + $x"/>
			<xsl:with-param name="d" select="$d"/>
			<xsl:with-param name="W" select="$W"/>
			<xsl:with-param name="H" select="$H"/>
		</xsl:call-template>
	</xsl:if>
</xsl:template>

<!-- ========================================================================= -->

<xsl:template match="Hit_hsps">
  <xsl:apply-templates select="Hsp"/>
</xsl:template>



<!-- ========================================================================= -->
<xsl:template match="Hsp">
<!-- number of previous hsp in the same Hit -->
<xsl:variable name="preceding-hsp"><xsl:value-of select="count(preceding-sibling::Hsp)"/></xsl:variable>
<!-- get the 5' position of the hsp in the query -->
<xsl:variable name="hsp-left"><xsl:choose>
  <xsl:when test="Hsp_query-from &lt; Hsp_query-to"><xsl:value-of select="Hsp_query-from"/></xsl:when>
  <xsl:otherwise><xsl:value-of select="Hsp_query-to"/></xsl:otherwise>
</xsl:choose></xsl:variable>
<!-- get the 3' position of the hsp in the query -->
<xsl:variable name="hsp-right"><xsl:choose>
  <xsl:when test="Hsp_query-from &lt; Hsp_query-to"><xsl:value-of select="Hsp_query-to"/></xsl:when>
  <xsl:otherwise><xsl:value-of select="Hsp_query-from"/></xsl:otherwise>
</xsl:choose></xsl:variable>
<!-- 5' position on screen -->
<xsl:variable name="x1"><xsl:value-of select="($hsp-left div $query-length ) * $svg-width"/></xsl:variable>
<!-- 3' position on screen -->
<xsl:variable name="x2"><xsl:value-of select="($hsp-right div $query-length ) * $svg-width"/></xsl:variable>
<!-- label -->
<xsl:variable name="label"><!--<xsl:value-of select="Hsp_hit-from"/> - <xsl:value-of select="Hsp_hit-to"/> (<xsl:choose>
  <xsl:when test="Hsp_query-from &lt; Hsp_query-to">+</xsl:when>
  <xsl:otherwise>-</xsl:otherwise></xsl:choose>)--> E=<xsl:value-of select="Hsp_evalue"/></xsl:variable>

 
 
  <!-- translate this Hsp verticaly in its Hit -->
   <xsl:element name="svg:g">
      <xsl:attribute name="transform">translate(0,<xsl:value-of select="$preceding-hsp * $hsp-height"/>)</xsl:attribute>
      <xsl:attribute name="id">hsp-<xsl:value-of select="generate-id(.)"/></xsl:attribute>
      <xsl:attribute name="title"><xsl:value-of select="Hsp_evalue"/></xsl:attribute>
      
      
         <!-- paint the Hsp Rectangle --> 
	 <xsl:element name="svg:rect">
       <xsl:attribute name="class">rect1</xsl:attribute>
	   <xsl:attribute name="x"><xsl:value-of select="$x1"/></xsl:attribute>
	   <xsl:attribute name="y">2</xsl:attribute>
	   <xsl:attribute name="width"><xsl:value-of select="$x2 - $x1"/></xsl:attribute>
	   <xsl:attribute name="height"><xsl:value-of select="$hsp-height - 4"/></xsl:attribute>
	   <!-- choose a color according to the e-value 
 <xsl:attribute name="sinha"><xsl:value-of  select="string(parent::node()/parent::node()/Hit_accession)"/></xsl:attribute>
-->
<xsl:variable name="Hit_accession"  select="parent::node()/parent::node()/Hit_accession" ></xsl:variable>

<xsl:attribute name="onmouseout">HideTooltip(evt,"<xsl:copy-of  select="$Hit_accession" disable-output-escaping="yes"/>",<xsl:value-of select="Hsp_hit-from"/>,<xsl:value-of select="Hsp_hit-to"/>)</xsl:attribute> 
<xsl:attribute name="onmousemove">ShowTooltip(evt,"<xsl:copy-of  select="$Hit_accession" disable-output-escaping="yes"/>",<xsl:value-of select="Hsp_hit-from"/>,<xsl:value-of select="Hsp_hit-to"/>)</xsl:attribute>
       <xsl:attribute name="onclick">gototheGBrowse("<xsl:copy-of  select="$Hit_accession" disable-output-escaping="yes"/>",<xsl:value-of select="Hsp_hit-from"/>,<xsl:value-of select="Hsp_hit-to"/>)</xsl:attribute>
	   <xsl:attribute name="fill"><xsl:choose>
	       <xsl:when test="Hsp_evalue &lt; 1E-100">url(#score1)</xsl:when>
	       <xsl:when test="Hsp_evalue &lt; 1E-10">url(#score2)</xsl:when>
	       <xsl:when test="Hsp_evalue &lt; 0.1">url(#score3)</xsl:when>
	        <xsl:when test="Hsp_evalue &lt; 0">url(#score4)</xsl:when>
	       <xsl:otherwise>url(#score5)</xsl:otherwise>
	     </xsl:choose></xsl:attribute>
	 </xsl:element>
	 
	 <!-- paint the label according to the position of the Hsp on screen  -->
	 <xsl:choose>
	 	<xsl:when test="$x2 &lt; (0.75 * $svg-width)">
			<xsl:element name="svg:text">
			  <xsl:attribute name="class">t1</xsl:attribute>
			  <xsl:attribute name="x"><xsl:value-of select="$x2 + 10 "/></xsl:attribute>
			  <xsl:attribute name="y"><xsl:value-of select="$hsp-height -1"/></xsl:attribute>
			  <xsl:attribute name="text-anchor">start</xsl:attribute>
			  <xsl:value-of select="$label"/>
			</xsl:element>
		</xsl:when>
		<xsl:when test="$x1 &gt; (0.25 * $svg-width)">
			<xsl:element name="svg:text">
			  <xsl:attribute name="class">t1</xsl:attribute>
			  <xsl:attribute name="x"><xsl:value-of select="$x1 - 10 "/></xsl:attribute>
			  <xsl:attribute name="y"><xsl:value-of select="$hsp-height -1"/></xsl:attribute>
			  <xsl:attribute name="text-anchor">end</xsl:attribute>
			  <xsl:value-of select="$label"/>
			</xsl:element>
		</xsl:when>
		<xsl:otherwise>
			<xsl:element name="svg:text">
            
			  <xsl:attribute name="class">t1</xsl:attribute>
			  <xsl:attribute name="x"><xsl:value-of select="($x2 - $x1) div 2 "/></xsl:attribute>
			  <xsl:attribute name="y"><xsl:value-of select="$hsp-height -1"/></xsl:attribute>
			  <xsl:attribute name="text-anchor">middle</xsl:attribute>
			  <xsl:value-of select="$label"/> (Q-Length: <xsl:value-of select="$query-length"/>)
			</xsl:element>
		</xsl:otherwise>
         </xsl:choose>
         
    </xsl:element>
</xsl:template>
<!-- ========================================================================= -->


</xsl:stylesheet>