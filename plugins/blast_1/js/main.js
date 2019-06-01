/*Populate dataset based on selection of BLAST program type*/
$("#database_type").change(function() {
    populate_datasets();
});
/*Populate BLAST datasets based on config.json file*/
function populate_datasets() {
        $select = $('#Datasets');
        $.ajax({
            url: 'plugins/blast/config.json',
            dataType: 'JSON',
            success: function(data) {
                $select.css("height", data.selection_box[0].height).css("width", data.selection_box[0].width)
                $select.html('');
                $.each(data.datasets, function(key, cat) {
                    var option = "<option  value='" + cat.number + "'>" + cat.user_friendly_name + "</option>";
                    // if (cat.hasOwnProperty("group_name")) { text="+cat.dataset_path+"
                    var group = cat.group_name;
                    if ($("#database_type option:selected").val().match(/blastn|tblastn|tblastx/g) && cat.molecule_type == "nucleotide") {
                        if ($select.find("optgroup[label='" + group + "']").length === 0) {
                            $select.append("<optgroup label='" + group + "' />");
                        }
                        $select.find("optgroup[label='" + group + "']").append(option);
                    }
                    if ($("#database_type option:selected").val().match(/^blastx|blastp/g) && cat.molecule_type == "protein") {
                        if ($select.find("optgroup[label='" + group + "']").length === 0) {
                            $select.append("<optgroup label='" + group + "' />");
                        }
                        $select.find("optgroup[label='" + group + "']").append(option);
                    }
                    /* } else {
        $select.append(option);
    }  
	*/
                    $("#Datasets option:selected").prop("selected", false);
                    $("#Datasets option:first").prop("selected", "selected");
                });
            },
            error: function() {
                $select.html('<option id="-1">none available</option>');
            }
        });
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
            console.log(JSON.parse(data)['table'])
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
                    console.log(result_string['BlastOutput'][0]['BlastOutput_iterations'][0]['Iteration'][0]);
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
    console.log(obj3);
}

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
            console.log(JSON.parse(data)['read_map']);
            $('#results_div').html(JSON.parse(data)['read_map']);
            $('#blast_image').attr("src", "plugins/blast/tmp/" + uuid + ".output.png");
            $('#results_div').append('<br/><br/><br/><table id="example" class="display" width="100%"></table>');
            $('#example').wrap('<div class="class-name"></div>');
            setCookie("blast_uuid", uuid, 7);
            $('#waiting_div').fadeOut(500);
            //$('#results_div').fadeIn(100);
            var source_tmp = JSON.parse(data)['table'];
            //var children = hege.concat(source_tmp);
            /*var fruits = [];
				for(var q=0;q<Object.keys(source_tmp).length;q++){
					fruits.push(JSON.stringify(source_tmp[Object.keys(source_tmp)[q]]))
				}
				console.log(fruits)*/
            $('#example').DataTable({
                "data": source_tmp,
                "columns": [{
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