var chr_number="";
var transcript_id="";
var gene_id="";
var type="";
var gene_start="";
var gene_end="";
var transcript_start="";
var transcript_end=""
var strand=""
var seq_array_tmp="";
//Document Ready function
$(document).ready( function() {
 $('#tab-container').easytabs({
		animationSpeed: "fast",
		 updateHash: true
		});
	
	var current_tab = $("#tab-container li.tab.active a").attr("href");
	if(current_tab=="#sequence"){
		get_sequence_info();
	}
	
	
		$('#tab-container').bind('easytabs:after', function(e, clicked, targetPanel, data) {
				if(targetPanel.selector=='#sequence'){get_sequence_info();
}
		});

	/*	$('#tab-container').bind('easytabs:after', function(e, clicked, targetPanel, data) {
			if(targetPanel.selector=='#sequence'){
          selectAndHighlightRangeforTranscript('transcriptequencediv', 424, 470);
		  selectAndHighlightRange('cdssequencediv', 424, 470);
		  selectAndHighlightRange('genomicsequencediv', 424, 470);

			 }
});*/

if (typeof $_GET('id') != 'undefined') {
	get_basic_info($_GET('id'));
}else{
	$('#tab-container').hide();
	$('#title').html("<font color='red'>Something went wrong, try again or contact website administrator!</font>");
	return false;
	}


	

	
	
	

});


function get_sequence_info(){
		var data_p="id="+$_GET('id');
	    $.ajax({
        type: "POST",
		data: (data_p),
        url: "plugins/gene/services/sequence.php",
        success: function (data) {
			$('#genomicsequencediv').html(JSON.parse(data)['genomic_data']);
			$('#cdssequencediv').html(JSON.parse(data)['cds_sequence']);
			$('#transcriptequencediv').html(JSON.parse(data)['transcript_sequence']);
			$('#proteinsequencediv').html(JSON.parse(data)['protein_sequence']);

			$('#genom_strand').html((strand=="-1")?"-":"+");

		//	console.log(strand)

			$('#genomic_number').html("><strong>"+JSON.parse(data)['genomic_header']+"</strong> ["+JSON.parse(data)['genomic_data_length']+ " nucleotides] ");
			$('#protein_number').html("><strong>"+JSON.parse(data)['transcript_id']+".p</strong> ["+JSON.parse(data)['protein_sequence_length']+ " residues] ");
			$('#transcript_number').html("><strong>"+JSON.parse(data)['transcript_id']+"</strong> ["+JSON.parse(data)['transcript_sequence_length']+ " nucleotides] ");
			$('#cds_number').html("><strong>"+JSON.parse(data)['transcript_id']+"</strong> ["+JSON.parse(data)['cds_sequence_length']+ " nucleotides] ");
			seq_array_tmp=JSON.parse(data)['genseqarray'];
				     selectAndHighlightRangeforTranscript('transcriptequencediv', 424, 470,seq_array_tmp);
//selectAndHighlightRange('cdssequencediv', 424, 470);
selectAndHighlightRange('genomicsequencediv', 424, 470,seq_array_tmp);


				}
		});

		
}




//Get the basic information
function get_basic_info(id){
	var data_p="id="+id;
	    $.ajax({
        type: "POST",
        url: "plugins/gene/services/basic.php",
        data: (data_p),
        success: function (data) {
			if(JSON.parse(data)['error']!=null){
				$('#tab-container').hide();
				$('#title').html("<font color='red'>Incorrect Arabidopsis thaliana id "+JSON.parse(data)['error']+'</font>');
				return false;
			}
			$('#description').html(JSON.parse(data)['basic_data'][0].description);
			$('#peptide_name').html(JSON.parse(data)['basic_data'][0].peptide_name);
			$('#transcript_id').html(JSON.parse(data)['basic_data'][0].transcript_id);
			$('#pac_id').html(JSON.parse(data)['basic_data'][0].pac_id);
			$('#gene_id').html(JSON.parse(data)['basic_data'][0].gene_id);
			$('#other_tids').html(JSON.parse(data)['basic_data'][0].other_transcripts);

			if(JSON.parse(data)['basic_data'][0].input_type=="transcript"){
			$('#title').html("Arabidopsis thaliana gene model "+JSON.parse(data)['basic_data'][0].transcript_id);
			$('#start').html(JSON.parse(data)['basic_data'][0].transcript_start);
			$('#end').html(JSON.parse(data)['basic_data'][0].transcript_end);
			}else{
			$('#title').html("Arabidopsis thaliana gene "+JSON.parse(data)['basic_data'][0].gene_id);
			$('#start').html(JSON.parse(data)['basic_data'][0].gene_start);
			$('#end').html(JSON.parse(data)['basic_data'][0].gene_end);
			}

			$('#potri_id').html(JSON.parse(data)['basic_data'][0].potri_id);
			$('#atg_id').html(JSON.parse(data)['basic_data'][0].atg_id);

			transcript_id=JSON.parse(data)['basic_data'][0].transcript_id;
			type=JSON.parse(data)['basic_data'][0].input_type;
			chr_number=JSON.parse(data)['basic_data'][0].chromosome_name;
			gene_id=JSON.parse(data)['basic_data'][0].gene_id;
			transcript_id=JSON.parse(data)['basic_data'][0].transcript_id;
			transcript_start=JSON.parse(data)['basic_data'][0].transcript_start;
			transcript_end=JSON.parse(data)['basic_data'][0].transcript_end;

			gene_start=JSON.parse(data)['basic_data'][0].gene_start;
			gene_end=JSON.parse(data)['basic_data'][0].gene_end;
			strand=JSON.parse(data)['basic_data'][0].strand;


			//console.log(JSON.parse(data)['basic_data'][0].potri_id)
			 },
			 error: function (jqXHR, exception) {
				console.log(jqXHR,exception)
				}
   });


}

//Sequence information
function downloadInnerHtml(filename, elId, mimeType) {
	 var header = document.getElementById(elId+"_pre").textContent;
    var sequence = document.getElementById(elId).textContent;
    var link = document.createElement('a');
    mimeType = mimeType || 'text/plain';

    link.setAttribute('download', filename);
    link.setAttribute('href', 'data:' + mimeType + ';charset=utf-8,' + encodeURIComponent(header+sequence));
    link.click();
}



//Very cool custom functions to $_GET http variables
function $_GET(q, s) {
    s = s ? s : window.location.search;
    var re = new RegExp('&' + q + '(?:=([^&]*))?(?=&|$)', 'i');
    return (s = s.replace('?', '&').match(re)) ? (typeof s[1] == 'undefined' ? '' : decodeURIComponent(s[1])) : undefined;
}



//////////Sequence Color

function getTextNodesIn(node) {
    var textNodes = [];
    if (node.nodeType == 3) {
        textNodes.push(node);
    } else {
        var children = node.childNodes;
        for (var i = 0, len = children.length; i < len; ++i) {
            textNodes.push.apply(textNodes, getTextNodesIn(children[i]));
        }
    }
    return textNodes;
}

function setSelectionRange(el, start, end) {
	//alert(start+' '+end);
	end=end+1;
	start=start;
    if (document.createRange && window.getSelection) {
        var range = document.createRange();
        range.selectNodeContents(el);
        var textNodes = getTextNodesIn(el);
        var foundStart = false;
        var charCount = 0, endCharCount;

        for (var i = 0, textNode; textNode = textNodes[i++]; ) {
            endCharCount = charCount + textNode.length;
            if (!foundStart && start >= charCount && (start < endCharCount || (start == endCharCount && i < textNodes.length))) {
                range.setStart(textNode, start - charCount);
                foundStart = true;
            }
            if (foundStart && end <= endCharCount) {
                range.setEnd(textNode, end - charCount);
                break;
            }
            charCount = endCharCount;

        }

        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    } else if (document.selection && document.body.createTextRange) {
        var textRange = document.body.createTextRange();
        textRange.moveToElementText(el);
        textRange.collapse(true);
        textRange.moveEnd("character", end);
        textRange.moveStart("character", start);
        textRange.select();
    }
}



function makeEditableAndHighlight(colour) {
    sel = window.getSelection();
    if (sel.rangeCount && sel.getRangeAt) {
        range = sel.getRangeAt(0);
    }
    document.designMode = "on";
    if (range) {
        sel.removeAllRanges();
        sel.addRange(range);
    }
    // Use HiliteColor since some browsers apply BackColor to the whole block
    if (!document.execCommand("HiliteColor", false, colour)) {
        document.execCommand("BackColor", false, colour);
    }
    document.designMode = "off";
	document.getElementById('bg_content').style.backgroundColor = "white";
}

function highlight(colour) {
    var range, sel;
    if (window.getSelection) {
        // IE9 and non-IE
        try {
            if (!document.execCommand("BackColor", false, colour)) {
                makeEditableAndHighlight(colour);
            }
        } catch (ex) {
            makeEditableAndHighlight(colour)
        }
    } else if (document.selection && document.selection.createRange) {
        // IE <= 8 case
        range = document.selection.createRange();
        range.execCommand("BackColor", false, colour);
    }
}



function selectAndHighlightRange2(id) {
	var tones = seq_array_tmp;//"";//<?php echo json_encode($genseqarray); ?>;
  	for (i=0; i<tones.length; i++)
  		{
			console.log(tones[i]["genepagecordstart"], parseInt(tones[i]["genepagecordend"]+1));
  		setSelectionRange(document.getElementById(id), parseInt(tones[i]["genepagecordstart"]), parseInt(tones[i]["genepagecordend"]+1));//+39



		 if(tones[i]["genepagecordregion"]=="3UTR"){
			highlight("#E9D2E4");
		 }
		  if(tones[i]["genepagecordregion"]=="CDS"){
			 highlight("#AABADD");
		 }


		  if(tones[i]["genepagecordregion"]=="5UTR"){
 		  highlight("#A4D4B0");

	 }
		//alert(tones[i]["genepagecordstart"])
		 }
		 setSelectionRange(document.getElementById(id), 0, -1);
   		 highlight("#A4D4B0");

}


function selectAndHighlightRange(id, start, end,seq_array_tmp) {
	var tones =seq_array_tmp;// "";//<?php echo json_encode($genseqarray); ?>;
  	for (i=0; i<tones.length; i++)
  		{
  		setSelectionRange(document.getElementById(id), parseInt(tones[i]["genepagecordstart"]), parseInt(tones[i]["genepagecordend"]));//+39
			if(id=='cdssequencediv'){
				highlight("#AABADD");
			}else{


		 if(tones[i]["genepagecordregion"]=="3UTR"){
			highlight("#E9D2E4");
		 }else if(tones[i]["genepagecordregion"]=="CDS"){
			 highlight("#AABADD");
		 }else if(tones[i]["genepagecordregion"]=="5UTR"){
 		  highlight("#A4D4B0");
		 }
	 }
		//alert(tones[i]["genepagecordstart"])
		 }
		 setSelectionRange(document.getElementById(id), 0, -1);
   		 highlight("#A4D4B0");

}



function selectAndHighlightRangeforTranscript(id, start, end,seq_array_tmp) {
	var tones = seq_array_tmp;//"ss";//<?php echo json_encode($genseqarray); ?>;

   	var w=0;
	for (i=0; i<tones.length; i++){
  		if(i==0){
				setSelectionRange(document.getElementById(id), 0 ,tones[i]["genepagecordend"]);
			switch (tones[i]["genepagecordregion"]){
				case "5UTR":
				highlight("#A4D4B0");
				break;
				case "CDS":
				highlight("#AABADD");
				break;
				case "3UTR":
				highlight("#E9D2E4");
				break;
					default :  ;//console.log(tones[i]["genepagecordregion"]);
				}
				//console.log(tones[i]["genepagecordregion"]);
		}else if(i> 0){

		w=(tones[i-1]["genepagecordend"]-tones[i-1]["genepagecordstart"])+w+1;
		setSelectionRange(document.getElementById(id), w ,w+(tones[i]["genepagecordend"]-tones[i]["genepagecordstart"])+1);
	//	console.log(w ,w+(tones[i]["genepagecordend"]-tones[i]["genepagecordstart"])+1,tones[i]["genepagecordregion"])

		switch (tones[i]["genepagecordregion"]){
				case "5UTR":
				//console.log('5UR'+w ,w+(tones[i]["genepagecordend"]-tones[i]["genepagecordstart"])+1)
				highlight("#A4D4B0");
				break;
				case "CDS":
				//console.log('CDS'+w ,w+(tones[i]["genepagecordend"]-tones[i]["genepagecordstart"])+1)
				highlight("#AABADD");
				break;
				case "3UTR":
				//console.log('3TUR'+w ,w+(tones[i]["genepagecordend"]-tones[i]["genepagecordstart"])+1)
				highlight("#E9D2E4");
				break;
				default :  ;//console.log(tones[i]["genepagecordregion"]);

				}
	}
	 }
		 setSelectionRange(document.getElementById(id), 0, -1);
   		//highlight("#A4D4B0");


}



var tmp_flag;
	var mainstr;
	var ustreamstr_old;
	var dstreamstr_old;

function givemethesequence(){

		var ustream_tmp=document.getElementById('ustream').value;
		var dstream_tmp=document.getElementById('dstream').value;
		var picea_basic_start_tmp="";//<?php echo json_encode($ResultArray['Gene_Start']);?>;
		var picea_basic_end_tmp="";//<?php echo json_encode($ResultArray['Gene_End']);?>;
		var picea_basic_chromosome="";//<?php echo json_encode($ResultArray['Chromosome_Name']);?>;
		var plus_minus_tmp="";//<?php echo json_encode($plus_minus);?>;

		if(ustream_tmp==""){
			ustream_tmp="0";
		}
		if(dstream_tmp==""){
			 dstream_tmp="0";
		}
		if(picea_basic_start_tmp==""){
			picea_basic_start_tmp="0";
		}

		if(picea_basic_end_tmp==""){
			picea_basic_end_tmp="0";
		}
		var picea_basic_start=parseInt(gene_start);
		var picea_basic_end=parseInt(gene_end);
		var ustream=parseInt(ustream_tmp);
		var dstream=parseInt(dstream_tmp);
		var plus_minus=parseInt(strand);

$.ajax({
        type: "GET",
        url: "plugins/autocomplete/test/retrieveflanksequence.php",
       	data: {
           	ustream: ustream,
			dstream: dstream,
			picea_basic_chromosome:chr_number,
			picea_basic_start:parseInt(picea_basic_start),
			picea_basic_end:parseInt(picea_basic_end),
			plus_minus:plus_minus
          	},
        dataType: "json",
        success: function(data){
            if(parseInt(data)!=0){

	if(tmp_flag!=false){
		mainstr=document.getElementById('genomicsequencediv').innerHTML;
		tmp_flag=false;
	}else{
		var mainstr2=mainstr.replace("<font style=\"background-color:#ffffff\">"+ustreamstr_old+"</font>","");
		var mainstr3=mainstr2.replace("<font style=\"background-color:#ffffff\">"+dstreamstr_old+"</font>","");
		mainstr=mainstr3;
	}

		document.getElementById('genomicsequencediv').innerHTML= "<font style='background-color:#ffffff' >"+data.ustreamstr+"</font>"+mainstr+"<font style='background-color:#ffffff'>"+data.dstreamstr+"</font>";

		 ustreamstr_old=data.ustreamstr;
		dstreamstr_old=data.dstreamstr;



            }
        }
    });

}


function send_to_blast(program_string){
	
	var form = document.createElement("form");
    var blast_text_element = document.createElement("input"); 
    var sequence_id_element = document.createElement("input");  
	var program_element = document.createElement("input");
	
    form.method = "POST";
    form.action = "blast";   
	
	var sequence_string="";
	var sequence_id="";
	var blast_program="";
	
	switch (program_string){
			case "genome":
			sequence_string=$("#genomicsequencediv")[0].innerText;
			sequence_id=$("#genomic_number")[0].innerText;
			blast_program="blastn";
			break;
			case "cds":
			sequence_string=$("#cdssequencediv")[0].innerText;
			sequence_id=$("#cds_number")[0].innerText;
			blast_program="blastn";
			break;
			case "transcript":
			sequence_string=$("#transcriptequencediv")[0].innerText;
			sequence_id=$("#transcript_number")[0].innerText;
			blast_program="blastn";
			break;
			case "protein":
			sequence_string=$("#proteinsequencediv")[0].innerText;
			sequence_id=$("#protein_number")[0].innerText;
			blast_program="blastp";
			break;

	}


    blast_text_element.value=sequence_string;
    blast_text_element.name="sequence_string";
    form.appendChild(blast_text_element);  

    sequence_id_element.value=sequence_id.split("[")[0];
    sequence_id_element.name="sequence_id";
    form.appendChild(sequence_id_element);

    program_element.value=blast_program;
    program_element.name="program";
    form.appendChild(program_element);	
	
    document.body.appendChild(form);

    form.submit();

}