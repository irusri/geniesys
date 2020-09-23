/*Populate dataset based on selection of BLAST program type*/
$("#database_type").change(function() {
    populate_datasets();
});
/*Populate BLAST datasets based on config.json file*/
function populate_datasets() {
	//console.log()
        $select = $('#Datasets');
        $.ajax({
            url: 'plugins/config.json',
            dataType: 'JSON',
            success: function(data) {
                $select.css("height", data.selection_box[0].height).css("width", data.selection_box[0].width)
                $select.html('');

                $.each(data.datasets, function(key, cat) {
                    var option = "<option  value='" + cat.number + "'>" + cat.user_friendly_name + "</option>";
                    var group = cat.group_name;
                   
                    if ($("#database_type option:selected").val().match(/blastn|tblastn|tblastx/g) && cat.molecule_type == "nucleotide") {
                        if ($select.find("optgroup[label='" + group + "']").length === 0) {
                            $select.append("<optgroup label='" + group + "' />");//console.log($select.find("optgroup")[0].label)
                        }
                        
                        $select.find("optgroup[label='" + group + "']").append(option);
                        
						$("#protein_btn").hide();
						$("#genomic_btn").show();
						$("#transcript_btn").show();
                        $("#cds_btn").show();
                    }
                    
                    if ($("#database_type option:selected").val().match(/^blastx|blastp/g) && cat.molecule_type == "protein") {
                        if ($select.find("optgroup[label='" + group + "']").length === 0) {
                            $select.append("<optgroup label='" + group + "' />");
                        }
                        $select.find("optgroup[label='" + group + "']").append(option);

						 $("#protein_btn").show();
						$("#genomic_btn").hide();
						$("#transcript_btn").hide();
						$("#cds_btn").hide();
						if(document.getElementById('seqid').value!=""){
						get_sequence_info(document.getElementById('seqid').value,"protein_sequence");
						}
						
                    }

                   $("#Datasets option:selected").prop("selected", false);
                   $("#Datasets option:first").prop("selected", "selected");

                });

                $select.find("optgroup").each(function(e,a) {
                    if(a.label==""){
                        this.remove();
                    }
                });

                
            },
            error: function() {
                $select.html('<option id="-1">none available</option>');
            }


            
        });
	
		if(blast_program=="blastp"){
            document.getElementById("database_type").value="blastp";
			blast_program="";
        }

	
    }
    /**Toggle advanced option**/
function toggleMenu(objID) {
        if (!document.getElementById) return;
        var ob = document.getElementById(objID).style;
        ob.display = (ob.display == 'block') ? 'none' : 'block';
    }
    /**Loop form elements & call web service for BLAST**/
var submission_timer;

function submitformelements() {
        var elem = document.getElementById('genie_blast_form').elements;
        var tmp_datasets_array = new Array()
        $("#Datasets option:selected").each(function() {
            tmp_datasets_array.push($(this).val()); //.attr('text'));
        });
        var tmp_datasets_array_str = "selected_datasets=" + tmp_datasets_array.join(",");
        var tmp_general_array = new Array()
        for (var i = 1; i < elem.length; i++) {
            if (elem[i].value != "" && elem[i].name != "datasets") {
                if (elem[i].type == "checkbox") {
                    tmp_general_array.push(elem[i].name + "=" + elem[i].checked)
                } else {
                    tmp_general_array.push(elem[i].name + "=" + elem[i].value.trim())
                }
            }
        }
        $.ajax({
            url: 'plugins/blast/services/blast.php',
            type: "POST",
            data: tmp_general_array.join("&") + "&" + tmp_datasets_array_str,
            success: function(data) {
                submission_timer = setInterval(function() {
                    validate_the_submission(JSON.parse(data)['uuid'], parseInt(JSON.parse(data)['qid']), JSON.parse(data)['program'])
                }, 5000);
                $('#genie_blast_form').fadeOut(500);
                $('#waiting_div').fadeIn(500);
            },
            error: function(e) {
                console.log("Following error has been reported during the execution")
                console.log(e);
            }
        });
    }
    /*Validate the blast submission by queryid and uuid*/
function validate_the_submission(uuid, qid, program) {
    $.ajax({
        url: 'plugins/blast/services/validate_blast.php',
        type: "POST",
        data: "uuid=" + uuid + "&qid=" + qid + "&program=" + program,
        success: function(data) {
            var a_t = [];
           // console.log(JSON.parse(data)['table']) 
            for (var j = 0; j < (JSON.parse(data)['table']).length; j++) {
                a_t.push({
                    'accession_of_hit': JSON.parse(data)['table'][j]['accession_of_hit']
                });
            }
            //drawRow(JSON.parse(data)['table'])
            $('#waiting_div').fadeIn(500);
            //	$('#results_div').fadeIn(500);
            if (program == "blatp" || program == "blastx") {
                //$('#results_div').html("<embed src='plugins/blast/tmp/"+uuid+".output.graph.png'  />");
            } else {
                //$('#results_div').html("<embed src='plugins/blast/tmp/"+uuid+".output.svg' type='image/svg+xml' />");
            }
            clearInterval(submission_timer);
            var url = window.location.href;
            url += (url.indexOf('?') > -1) ? "" : "?" + "results=" + uuid + "&program=" + program;
            window.location.href = url;
        },
        error: function(e) {
            console.log("Following error has been reported during the execution")
            console.log(e);
            clearInterval(submission_timer);
        }
    });
}

function drawRow(rowData) {
        $('#example').DataTable({
            data: rowData,
            'bSort': false,
            "processing": true,
            "serverSide": true,
            "columns": [{
                "title": "accession_of_hit"
            }, {
                "title": "accession_of_hit"
            }, {
                "title": "accession_of_hit"
            }, {
                "title": "accession_of_hit"
            }, {
                "title": "accession_of_hit"
            }, {
                "title": "accession_of_hit"
            }, {
                "title": "accession_of_hit"
            }, {
                "title": "accession_of_hit"
            }],
            "scrollY": "200px",
            "scrollCollapse": true,
            "info": true,
            "paging": true
        });
    }
    /*Read file*/
function readTextFile(uuid) {
        var file = "http://v22.popgenie.org/demo/geniecms/plugins/blast/tmp/" + uuid + ".output";
        var rawFile = new XMLHttpRequest();
        rawFile.open("GET", file, false);
        rawFile.onreadystatechange = function() {
            if (rawFile.readyState === 4) {
                if (rawFile.status === 200 || rawFile.status == 0) {
                    var allText = rawFile.responseText;
                    var result_string = xmlToJSON.parseString(allText);
                  //  console.log(result_string['BlastOutput'][0]['BlastOutput_iterations'][0]['Iteration'][0]);
                }
            }
        }
        rawFile.send(null);
    }
    /*Validate the blast submission by uuid*/
function checking_the_submission() {
        var url = window.location.href;
        url += (url.indexOf('?') > -1) ? "" : "?" + "results=dasdsa";
        window.location.href = url;
        //location.reload()
        /*$.ajax({ 
			url: 'plugins/blast/services/validate_blast.php',
			type: "POST",
			data:"uuid="+uuid+"&qid="+qid,
  			success:function(data){
				console.log(data)
				
				$('#genie_blast_form').fadeOut(500);
				
			},
			error:function(e){
			console.log("Following error has been reported during the execution")
    		console.log(e);
  			}
		});*/
    }
    //Page initialization
populate_datasets();
if (typeof $_GET('results') != 'undefined') {
    $('#genie_blast_form').hide();
    $('#waiting_div').fadeIn(500);
    var uuid = $_GET('results');
    var program = $_GET('program');
    initialize_page(uuid, program);
    /*$('#results_div').fadeIn(500);
				if(program=="blatp" || program=="blastx"){
				$('#results_div').html("<embed src='plugins/blast/tmp/"+uuid+".output.graph.png'  />");
				}else{	
				$('#results_div').html("<embed src='plugins/blast/tmp/"+uuid+".output.svg' type='image/svg+xml' />");
				}*/
    //readTextFile(uuid);
}
/**
 * Overwrites obj1's values with obj2's and adds obj2's if non existent in obj1
 * @param obj1
 * @param obj2
 * @returns obj3 a new object based on obj1 and obj2
 */
function merge_options(obj1, obj2) {
    var obj3 = {};
    for (var attrname in obj1) {
        obj3[attrname] = obj1[attrname];
    }
    for (var attrname in obj2) {
        obj3[attrname] = obj2[attrname];
    }
   // console.log(obj3);
}
var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 1 ?
                        data.replace( /[$,]/g, '' ) :
                        data;
                }
            }
        }
    };

function initialize_page(uuid, program) {
    $('#results_div').fadeIn(500);
    if (program == "blatp" || program == "blastx") {
        //$('#results_div').html("<embed src='plugins/blast/tmp/"+uuid+".output.graph.png'  />");
    } else {
        //$('#results_div').html("<embed src='plugins/blast/tmp/"+uuid+".output.svg' type='image/svg+xml' />");
    }
    $.ajax({
        url: 'plugins/blast/services/validate_blast.php',
        type: "POST",
        data: "uuid=" + uuid + "&program=" + program,
        success: function(data) {
            //  console.log(JSON.parse(data))
            if (data == "error") {
                $('#waiting_div').fadeOut(500);
                $('#results_div').html('<strong>Results unavailable!</strong>');
                return false;
            }
           // console.log(JSON.parse(data)['read_map']);
            $('#results_div').html(JSON.parse(data)['read_map']);
            $('#blast_image').attr("src", "plugins/blast/tmp/" + uuid + ".output.png");
            $('#results_div').append('<br/><br/><br/><table id="example" class="display" width="100%"> <thead></thead> <tbody> </tbody></table>');
            $('#example').wrap('<div class="class-name"></div>');
            setCookie("blast_uuid", uuid, 7);
            $('#waiting_div').fadeOut(500);
            //$('#results_div').fadeIn(100);
			$('#result_buttons').show();
            var source_tmp = JSON.parse(data)['table'];
            //var children = hege.concat(source_tmp);
            /*var fruits = [];
				for(var q=0;q<Object.keys(source_tmp).length;q++){
					fruits.push(JSON.stringify(source_tmp[Object.keys(source_tmp)[q]]))
				}
				console.log(source_tmp)*/
			//console.log(source_tmp)
           var table= $('#example').DataTable({
                "data": source_tmp,
				 'columnDefs': [{
         'targets': 0,
         'searchable': false,
         'orderable': false,
         'className': 'dt-body-center',
         'render': function (data, type, full, meta){
			//var i=0;i++;
             return '<input type="checkbox" name="'+full["accession_of_hit"]+'" value="' + $('<div/>').text(data).html() + '">';
         }
      }],
			   
			
			   
dom: 'Bfrtip',
        buttons: [
			        
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5', text: 'Download Text',
				exportOptions: {
            columns: [2,3,4,5,6,7,8,9]
        }} ),
				 $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5', text: 'Download PDF',orientation: 'landscape',
				exportOptions: {
              columns: [2,3,4,5,6,7,8,9]
        }
				
				
				
            } ),
			 $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5', text: 'Copy Table',
				exportOptions: {
            columns: [2,3,4,5,6,7,8,9]
        }} )
        ],
			
			     
			   
			   
      'order': [[1, 'asc']],
                "columns": [
				{
                    "data": "query_id",
                    "title": '<input name="select_all" value="1" id="example-select-all" type="checkbox" />'
                },	
					
					{
                    "data": "query_id",
                    "title": "Query Id"
                }, {
                    "data": "name_of_hit",
                    "title": "Name of Hit",
                    "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html("<a target='_blank' href='plugins/blast/tmp/" + uuid + ".output.Query" + oData.query_rank + ".html#" + oData.name_of_hit + "'>" + oData.name_of_hit + "</a>");
                    }
                }, {
                    "data": "accession_of_hit",
                    "title": "Accession of Hit"
                }, {
                    "data": "average_bit_score",
                    "title": "Average bit Score"
                }, {
                    "data": "top_bit_score",
                    "title": "Top bit score"
                }, {
                    "data": "average_evalue",
                    "title": "Average evalue"
                }, {
                    "data": "lowest_evalue",
                    "title": "Lowest evalue"
                }, {
                    "data": "average_identity",
                    "title": "Average identity"
                }, {
                    "data": "average_similarity",
                    "title": "Average similarity"
                }, {
                    "data": "query_rank",
                    "title": "Links",
                    "fnCreatedCell": function(nTd, sData, oData, iRow, iCol) {
                        $(nTd).html("<a target='_blank' href='plugins/blast/tmp/" + uuid + ".output.Query" + oData.query_rank + ".html'>HTML</a>  <a target='_blank' href='plugins/blast/tmp/" + uuid + ".output.Query" + oData.query_rank + ".txt'>TXT</a");
                    }
                }],
                'bSort': false,
                "bFilter": false,
                "scrollCollapse": false,
                "info": false,
                "paging": false
            });
			
			 // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Check/uncheck all checkboxes in the table
      var rows = table.rows({ 'search': 'applied' }).nodes();
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });
			
			   // Handle click on checkbox to set state of "Select all" control
   $('#example tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control 
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });
	
			
		
$('#frm-fasta').on('click', function(e){
	var id_list=[];	
	
      var form = this;
      // Iterate over all checkboxes in the table
      table.$('input[type="checkbox"]').each(function(e1){ 
		 // console.log(e1,this.checked)
         // If checkbox doesn't exist in DOM
        //// if(!$.contains(document, this)){
			//console.log(this,document)
            // If checkbox is checked
            if(this.checked){
				id_list.push(this.name)
				
				
               // Create a hidden element 

            }
         //// } 
      });
	
	var filteredArray = id_list.filter(function(item, pos){
  return id_list.indexOf(item)== pos; 
});
	
	if(filteredArray.length==0){
		toastr.error("Please select some results to Download.", "Empty Selection!");
	}else{
		downloadFasta( filteredArray,uuid );
	}
	});

 
			
			
$('#frm-genelist').on('click', function(e) {
	var id_list = [];
	var form = this;
	table.$('input[type="checkbox"]').each(function(e1) {
		if (this.checked) {
			id_list.push(this.name)
		}
	});
	var filteredArray = id_list.filter(function(item, pos) {
		return id_list.indexOf(item) == pos;
	});
	
	if(filteredArray.length==0){
		toastr.error("Please select some results to create a GeneList.", "Empty Selection!");
	}else{
		createagenelist( filteredArray,uuid );
	}
	
	
});
	
$('#frm-kablammo').on('click', function(e) {
	
	var link=document.createElement('a');
			document.body.appendChild(link);
			link.href="/plugins/blast/tmp/"+uuid+".output" ;
			link.target="_blank";
			link.click();
});
				
			

            /*for(var j=0;j<(JSON.parse(data)['table']).length;j++){
				a_t.push({'accession_of_hit':JSON.parse(data)['table'][j]['accession_of_hit']});
				}
				*/
            //drawRow(JSON.parse(data)['table'])
            /*var a_t=[];
				console.log(JSON.parse(data)['table'])
				for(var j=0;j<(JSON.parse(data)['table']).length;j++){
				a_t.push({'accession_of_hit':JSON.parse(data)['table'][j]['accession_of_hit']});
				}
				drawRow(JSON.parse(data)['table'])
				
				$('#waiting_div').fadeOut(500);	
				$('#results_div').fadeIn(500);
				if(program=="blatp" || program=="blastx"){
				//$('#results_div').html("<embed src='plugins/blast/tmp/"+uuid+".output.graph.png'  />");
				
				}else{	
				//$('#results_div').html("<embed src='plugins/blast/tmp/"+uuid+".output.svg' type='image/svg+xml' />");
				}
				clearInterval(submission_timer);
				
					var url = window.location.href;    
					url += (url.indexOf('?') > -1)?"":"?" + "results="+uuid+"&program="+program ;
					window.location.href = url;*/
        },
        error: function(e) {
            console.log("Following error has been reported during the execution")
            console.log(e);
            //clearInterval(submission_timer);
        }
    });
}


function downloadFasta(filteredArray,uuid){
	$.ajax({
        url: 'plugins/blast/services/download.php',
        type: "POST",
        data: "uuid=" + uuid + "&ids=" + filteredArray.join(","),
        success: function(data) {
			var link=document.createElement('a');
			document.body.appendChild(link);
			link.href="/plugins/blast/tmp/"+uuid+".fasta" ;
			link.target="_blank";
			link.click();
		}
	});
}

function createagenelist(filteredArray,uuid){
$.ajax({
        url: 'plugins/blast/services/createlist.php',
        type: "POST",
        data: "uuid=" + uuid + "&ids=" + filteredArray.join(","),
        success: function(data) {
				mainCreategenelistbyName(JSON.parse(data).join(),"blast_list",function(e){get_active(function(e){
					toastr.success("BLAST results GeneList has been created with " + JSON.parse(data).length + ' gene ids.', 'New GeneList created');
				
			$("#frm-genelist").effect("transfer", {
				to: "#numberofgenesSpan",
				className: "ui-effects-transfer-2"
			}, 600);
			//	$("#newtable_2").hide();
				
			})})
		}
	});
	
}


function sendtoKablammo(filteredArray,uuid){
	$.ajax({
        url: 'plugins/blast/services/download.php',
        type: "POST",
        data: "uuid=" + uuid + "&ids=" + filteredArray.join(","),
        success: function(data) {
			var link=document.createElement('a');
			document.body.appendChild(link);
			link.href="/plugins/blast/tmp/"+uuid+".fasta" ;
			link.target="_blank";
			link.click();
		}
	});
}



$(function() {
	$("#seqid").autocomplete({
		source: function(request, response) {
			$.ajax({
				url: "plugins/blast/services/autocomplete.php",
				dataType: "json",
				data: {
					q: request.term,
					output: 'json'
				},
				success: function(data) {
					if (data.genedata == null) {
						response($.map(data, function() {
							return {
								label2: "No Results found",
							}
						}));
					} else {
						response($.map(data.genedata, function(item) {
							return {
								label2: item.TranscriptName,
								label: item.TranscriptName,
							}
						}));
					}
				}
			});
		},
		minLength: 2,
		select: function(event, ui) {
			document.getElementById('seqid').value = ui.item.label;
			if (ui.item.label2 != "") {
				get_sequence_info(document.getElementById('seqid').value,"transcript_sequence");
				//window.location = "/blast?seqid=" + ui.item.label;
			} else {
				window.location = "#";
			}
			return false;
		}
		/*,
		open: function () {
            $(this).data("autocomplete").menu.element.addClass("results");
        }*/
	}).data("ui-autocomplete")._renderItem = function(ul, item) {
		item.label2 = item.label2.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<font color='#FF0000' >$1</font>");
		return $("<li></li>").data("item.autocomplete", item).append("<a><div  style=';top:0px;'>" + item.label2 + "</div></a><hr>").appendTo(ul);
	}
});
//end

function extract_sequence(tmp_str){
	get_sequence_info(document.getElementById('seqid').value,tmp_str)
}


function get_sequence_info(id,tmp_str){
		var data_p="id="+id;
	    $.ajax({
        type: "POST",
		data: (data_p),
        url: "plugins/gene/services/sequence.php",
        success: function (data) {
			var ele="#"+tmp_str.split("_")[0]+"_btn";
			if(tmp_str.split("_")[0]=="genomic"){
				$('#query_sequence_text').val(">"+JSON.parse(data)['genomic_header']+"\n"+JSON.parse(data)[tmp_str])
			}else{
				$('#query_sequence_text').val(">"+JSON.parse(data)['transcript_id']+"\n"+JSON.parse(data)[tmp_str])
			}
			
			$(".form-submit").css('highlight', 'none');
				$(".form-submit").css('border-color', '#ccc');
				$("#"+tmp_str.split("_")[0]+"_btn").css('border-color', 'red');
			
			

$("#sequence_waiting").hide();
		
			}
		});		
}





