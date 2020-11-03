var tmp_array = new Array();
var tmp_ids_array = new Array();
var data_points = "";
var y_axis_label = 'Normalized expression';
var replicate_flag;
var plus_minus_corr;
var private_selected_sample="";
var private_selected_datatype="";

function tmp_array_alert(removeItem) {
	var removeme = "     <a target='_blank' href='gene?id=" + removeItem + "'>" + removeItem + "</a>  <span onclick='" + 'tmp_array_alert("' + removeItem + '");' + "' style='font-weight:bold;font-size:14px;color:#FF0000;cursor:pointer'>x</span>";
	tmp_array = $.grep(tmp_array, function(value) {
		return value != removeme;
	});
	tmp_ids_array = $.grep(tmp_ids_array, function(value) {
		return value != removeItem;
	});
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"positionClass": "toast-bottom-right",
		"onclick": null,
		"showDuration": "1",
		"hideDuration": "0",
		"timeOut": "4000",
		"extendedTimeOut": "0",
		"showEasing": "linear",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	toastr.info('' + removeItem + ' gene has been removed from explot list.', 'Successfully removed');
	if (tmp_ids_array.length == 0) {
		toastr.options = {
			"closeButton": false,
			"debug": false,
			"positionClass": "toast-bottom-right",
			"onclick": null,
			"showDuration": "100",
			"hideDuration": "100",
			"timeOut": "8000",
			"extendedTimeOut": "0",
			"showEasing": "linear",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		}
		toastr.warning('You just removed all genes in your explot list. Please add some genes.', 'Empty explot list');
		$('#newtable_2').fadeOut()
	}
	tmp_array = $.unique(tmp_array);
	tmp_array = tmp_array.sort();
	tmp_ids_array = $.unique(tmp_ids_array);
	tmp_ids_array = tmp_ids_array.sort();
	if (tmp_array != null) {
		$('#newtable_2').show();
		$('#newtable_2title').html("- Selected Genes <strong>" + tmp_array.length + "</strong>");
		$('#newtable_4title').html("+ Selected Genes <strong>" + tmp_array.length + "</strong>");
		$('#listids').html(tmp_array.join("<br>"));
	}
	else {
		$('#newtable_2').hide();
	}
}

function geneadded(addedgene) {
	toastr.options = {
		"closeButton": false,
		"debug": false,
		"positionClass": "toast-bottom-right",
		"onclick": null,
		"showDuration": "1",
		"hideDuration": "0",
		"timeOut": "4000",
		"extendedTimeOut": "0",
		"showEasing": "linear",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
	toastr.success('' + addedgene + ' gene has been added to explot list.', 'Successfully added');
}
$(function() {
	//var tmp_array= new Array(); ;
	
console.log("ss")
	
	Popcharts.setOptions({
		//  colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572',
		//         '#FF9655', '#FFF263', '#6AF9C4']
		//colors: [ "#55BF3B", "#DF5353", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
		//"#55BF3B", "#DF5353", "#7798BF", "#aaeeee"]
		colors: ['#a6cee3', '#1f78b4', '#b2df8a', '#33a02c', '#fb9a99', '#e31a1c', '#fdbf6f', '#ff7f00', '#cab2d6', '#6a3d9a']
	});
	//$.pageslide({ direction: 'left', href: '#modal', modal: false });
	//Basic Parameters
	var chart;
	var chartType = 'line';
	var chartDataLength = 0;
	var private_datatype="";
	//var datasource="experiment_1";
	//Custom funcadtion to draw chart
	$.drawchart = function() {
		$("#explot_waiting").show(); 
		input_ids = $('#input_ids').val();
		input_ids3 = input_ids.replace(/ /g, '')
		var tmp_datasource = "";
		var tmp_datatype = "";
		
		if (replicate_flag == "true") {
			tmp_datasource = datasource;
		}
		else {
			tmp_datasource = datasource; //+"_no_replicates";
		}
		
		
		var cookie_datatype=getCookie("cookie_datatype");
		if(cookie_datatype!=null && cookie_datatype != undefined){private_datatype=cookie_datatype;}else{private_datatype="vst";}
	
		
		private_selected_sample=tmp_datasource;
		private_selected_datatype=private_datatype;
		
			var ele_type = document.getElementsByName('typergb');
	/*if(private_datatype=="vst"){
		ele_type[0].checked=true;
	}else{
		ele_type[1].checked=true;;
	}
	*/
		
		
		$.post("plugins/explot/service/explot_service.php", {
			primaryGenes: input_ids3,
			source: tmp_datasource,
			datatype:private_datatype
		}, function(json) {
			
			if (json == "exceeded") {
				$("#outterbox").hide();
				$('#externallink2').html("<font color='#CC0000'><strong>Limit exceeded!</strong></br> Please select number of genes less than 1000.</font>");
				return true;
			}
			if (json.popids != null) {
				
				
				var ids = json.popids.join(', ');
				$('#input_ids').val(ids);
				$('#infolabels').html("You have selected <font color='#CC0000'>" + json.popdata.length + "</font> genes and <font color='#CC0000'>" + json.samples.length + "</font> samples.");
			}
			else {
				if (json.popdata.length == 0) {
					$('#infolabels').html("You haven't selected any genes and samples yet. Please go to the <a  href='?genelist=enable'>GeneList</a> and  <a href='?samplelist=enable' >SampleList</a> and select few genes.");
				}
				else {
					if (json.popdata.length > 40) {
						Popcharts.setOptions({
							colors: ["#999999"]
						});
					}
					$('#infolabels').html("There are <font color='#CC0000'>" + json.samples.length + "</font> samples in this view.");
				}
			}
			chartDataLength = json.popdata.length;
			var testarr = json.samples;
			if (datasource != "experiment_1") {
				var testarramd = new Array();
				var testarramd2 = new Array();
				for (var c = 0; c < testarr.length; c++) {
					var sample_name;
					var sample_name2;
					switch (testarr[c]) {
						case "stage1":
							sample_name = "Flowers stage1 late";
							break;
						case "stage2":
							sample_name = "Flowers stage2 early";
							break;
						case "stage3":
							sample_name = "Flowers stage2 late";
							break;
						case "TTGT stage3":
							sample_name = "Flowers stage3 (biorep 2)";
							break;
						case "CACT stage2":
							sample_name = "Flowers stage2 (biorep 3)";
							break;
						case "CACT stage3":
							sample_name = "Flowers stage3 (biorep 3)";
							break;
						case "GCTT stage1":
							sample_name = "Flowers stage1 (biorep 3)";
							break;
						case "TTGT stage2":
							sample_name = "Flowers stage2 (biorep 1)";
							break;
						case "GCTT stage3":
							sample_name = "Flowers stage3 (biorep 1)";
							break;
						case "Rep1":
							sample_name = "Tensionwood Xylem (biorep 1)";
							break;
						case "Rep2":
							sample_name = "Tensionwood Xylem (biorep 2)";
							break;
						case "Rep3":
							sample_name = "Tensionwood Xylem (biorep 3)";
							break;
						case "GCTT":
							sample_name = "Unbent control (biorep 1)";
							break;
						case "CACT":
							sample_name = "Unbent control (biorep 2)";
							break;
						case "TTGT":
							sample_name = "Unbent control (biorep 3)";
							break;
						case "InfBR":
							sample_name = "P. cinnamomi: S inoculated";
							break;
						case "ConBR":
							sample_name = "P. cinnamomi: S mock inoculated";
							break;
						case "l_invasa_s_infested":
							console.log(sample_name);
							sample_name = "L. invasa: S infested";
							break;
						case "l_invasa_r_infested":
							sample_name = "L. invasa: R infested";
							break;
						case "l_invasa_s_uninfested":
							sample_name = "L. invasa: S uninfested";
							break;
						case "l_invasa_r_uninfested":
							sample_name = "L. invasa: R uninfested";
							break;
						case "c_austroafricana_r_mock_inoculated":
							sample_name = "C. austroafricana: R mock inoculated";
							break;
						case "c_austroafricana_s_mock_inoculated":
							sample_name = "C. austroafricana: S mock inoculated";
							break;
						case "c_austroafricana_s_inoculated":
							sample_name = "C. austroafricana: S inoculated";
							break;
						case "c_austroafricana_r_inoculated":
							sample_name = "C. austroafricana: R inoculated";
							break;
						case "shoottips":
							sample_name = "Shoot tips";
							break;
						case "immaturexylem":
							sample_name = "Immature xylem";
							break;
						case "matureleaf":
							sample_name = "Mature leaf";
							break;
						case "youngleaf":
							sample_name = "Young leaf";
							break;
						case "rep":
							sample_name = "Replicates";
							break;
						case "Matureleaf TTGT":
							sample_name = "Mature leaves (biorep 1)";
							break;
						case "Matureleaf GCTT":
							sample_name = "Mature leaves (biorep 2)";
							break
						case "Matureleaf CACT":
							sample_name = "Mature leaves (biorep 3)";
							break;
						case "Phloem TTGT":
							sample_name = "Phloem (biorep 1)";
							break;
						case "Phloem GCTT":
							sample_name = "Phloem (biorep 2)";
							break;
						case "Phloem CACT":
							sample_name = "Phloem (biorep 3)";
							break;
						case "Immature xylem 4":
							sample_name = "immature_xylem (biorep 3)";
							break;
						case "Immature xylem 2":
							sample_name = "immature_xylem (biorep 2)";
							break;
						default:
							sample_name = testarr[c];
							break;
							/*default:
						console.log(json.samples)
 				 	sample_name="immature_xylem (biorep 2)";
						
  					break;		*/
					}
					testarramd.push(sample_name);
					testarramd2.push(sample_name2);
					//console.log(sample_name2)
					//console.log(sample_name2);
				}
			}
			else {
				testarramd = testarr;
				testarramd2 = testarr;
				//console.log(testarr);
			}
			var setMin = function() {
				var chart = this,
					ex = chart.yAxis[0].getExtremes();
				// Sets the min value for the chart 
				var minVal = 0;
				if (ex.dataMin < 0) {
					minVal = ex.dataMin;
				}
				//set the min and return the values
				chart.yAxis[0].setExtremes(minVal, 2, true, false);
			}
			chart = new Popcharts.Chart({
				chart: { /*zoomType: 'x',*/
					renderTo: 'container',
					type: chartType,
					marginRight: 130,
					marginBottom: 180,
					zoomType: 'x'
				},
				animation: {
					duration: 1500,
					easing: 'easeOutBounce'
				},
				title: {
					
					text: '<i>'+$('#'+private_view)[0].labels[0].innerHTML+'</i> vs. gene expression',
					x: -20
				}, //center
				subtitle: {
					text: 'Source : '+MAIN_GENELIST_TABLE.split("_")[0]+'.org',
					x: -20
				},
				xAxis: {
					categories: testarramd,
					maxZoom: 1,
					labels: {
						rotation: -45,
						align: 'right',
						style: {
							fontSize: '12px',
							fontFamily: 'Verdana, sans-serif'
						}
					},
					 tickmarkPlacement: 'on'
				},
				yAxis: {
					title: {
						text: 'Normalized expression'
					},
					plotLines: [{
						value: 0,
						width: 0.5,
						color: '#808080'
					}],
					gridLineColor: '#FFFFFF',
					lineWidth: 1
				},
				credits: {
					enabled: false
				},
				tooltip: {
					formatter: function() {
						return '<b>' + this.series.name + '</b><br/>' + this.x + ': ' + this.y;
					}
				},
				exporting: {
					sourceWidth: 1024,
					sourceHeight: 768,
				},
				legend: {
					layout: 'verticle',
					align: 'right',
					verticalAlign: 'top',
					y: 60,
					borderWidth: 1
				},
				series: json.popdata,
				plotOptions: {
					series: {
						point: {
							events: {
								/*
					click: function(event) {
        console.log(event.point.series.userOptions.id,"X("+this.x+"),Y("+this.y+")",this.series.data);
      },*/
								drag: function(e) {
									// Returning false stops the drag and drops. Example:
									/*
									if (e.newY > 300) {
									    this.y = 300;
									    return false;
									}
									*/
									/*if(e.y>chart.yAxis[0].min){
                        $('#drag').html(
							
                            'Dragging <b>' + this.series.name + '</b>, <b>' + this.category + '</b> to <b>' + Popcharts.numberFormat(e.y, 2) + '</b>');
					 
					} else{
					e.y = 1
					return false;
				}*/
									if (e.y < chart.yAxis[0].min) {
										e.y = chart.yAxis[0].min;
										return false;
									}
									else if (e.y > chart.yAxis[0].max) {
										e.y = chart.yAxis[0].max;
										return false;
									}
									else {
										//$('#drag').html('Dragging <b>' + this.series.name + '</b>, <b>' + this.category + '</b> to <b>' + Popcharts.numberFormat(e.y, 2) + '</b>');
									}
								},
								drop: function() {
									$('#drop').html('In <b>' + this.series.name + '</b>, <b>' + this.category + '</b> was set to <b>' + Popcharts.numberFormat(this.y, 2) + '</b>');
								} //drop
							}
						},
						stickyTracking: false,
						marker: {
							enabled: true
						},
						cursor: 'pointer',
						events: {
							click: function(e) {
								tmp_array.push("     <a target='_blank' href='gene?id=" + this.name + "'>" + this.name + "</a>  <span onclick='" + 'tmp_array_alert("' + this.name + '");' + "' style='font-weight:bold;font-size:14px;color:#FF0000;cursor:pointer'>x</span>");
								geneadded(this.name);
								tmp_array = $.unique(tmp_array);
								tmp_array = tmp_array.sort();
								tmp_ids_array.push(this.name);
								tmp_ids_array = $.unique(tmp_ids_array);
								tmp_ids_array = tmp_ids_array.sort();
								if (tmp_array != null) {
									$('#newtable_2').fadeIn();
									$('#newtable_2title').html("- Selected Genes <strong>" + tmp_array.length + "</strong>");
									$('#newtable_4title').html("+ Selected Genes <strong>" + tmp_array.length + "</strong>");
									$('#listids').html(tmp_array.join("<br>"));
								}
								else {
									$('#newtable_2').hide();
								}
							}
						}
					},
					column: {
						stacking: 'normal'
					},
					line: {
						cursor: 'ns-resize'
					}
				}
				
			});
			$("#explot_waiting").hide(); 
			//Trigger swaplabelsbtn click event and Fire the swaplabelsbtn click event with xAxis update
			var swap_boolean = true;
			$("#swaplabelsbtn").click(function() {
				if (swap_boolean == true) {
					chart.xAxis[0].update({
						categories: testarramd2
					}, true);
					swap_boolean = false;
				}
				else {
					chart.xAxis[0].update({
						categories: testarramd
					}, true);
					swap_boolean = true;
				}
			});
		}, "json");
		if (datasource == "experiment_1") {
			document.getElementById('externallink2').innerHTML = "<a target='_blank' href='http://dx.doi.org/10.1186/1471-2164-11-681'>De novo assembled expressed gene catalog of a fast-growing Eucalyptus tree produced by Illumina mRNA-Seq</a><br><FONT size='2px'>Eshchar Mizrachi, Charles A Hefer, Martin Ranik, Fourie Joubert and Alexander A Myburg</FONT>";
		}
		if (datasource == "experiment_2") {
			document.getElementById('externallink2').innerHTML = "<a target='_blank' href='http://plantgenie.org'>To be published when EucGenIE launches in PlantGenIE</a><br>";
		}
		if (datasource == "experiment_3") {
			document.getElementById('externallink2').innerHTML = "<a target='_blank' href='http://dx.doi.org/10.1111/nph.13152'><FONT size='2px'>Investigating the molecular underpinnings underlying morphology and changes in carbon partitioning during tension wood formation in Eucalyptus</a><br>Eshchar Mizrachi, Victoria J. Maloney, Janine Silberbauer, Charles A. Hefer, Dave K. Berger, Shawn D. Mansfield and Alexander A. Myburg</FONT>";
		}
		if (datasource == "experiment_4") {
			document.getElementById('externallink2').innerHTML = "<a target='_blank' href='http://dx.doi.org/10.1111/nph.13077'>The floral transcriptome of Eucalyptus grandis</a><br><FONT size='2px'>Kelly J. Vining, Elisson Romanel, Rebecca C. Jones, Amy Klocko, Marcio Alves-Ferreira, Charles A. Hefer, Vindhya Amarasinghe, Palitha Dharmawardhana, Sushma Naithani, Martin Ranik, James Wesley-Smith, Luke Solomon, Pankaj Jaiswal, Alexander A. Myburg and Steven H. Strauss</FONT>";
		}
	}
	
	
	//Trigger swapyaxis click event
	$("#swapyaxis").click(function() {
		if (data_points == "non_log") {
			data_points = "";
			y_axis_label = 'Data Expression (log2)';
			$("#swapyaxis").html("Change to non Log values")
			$.drawchart();
		}
		else {
			data_points = "non_log";
			y_axis_label = 'Data Expression ';
			$("#swapyaxis").html("Change to Log values")
			$.drawchart();
		}
	});
	// Testing add series
	$('#findcorr').click(function() {
		var series = chart.get('wow')
		var genelist_str = series.yData.join(",");
		var random_id = Math.round(Math.random() * 100) + 1;
		var new_gene_list_name = datasource + "_" + random_id;
		var tmp_datasource = "";
		if (replicate_flag == "true") {
			tmp_datasource = datasource;
		}
		else {
			tmp_datasource = datasource; //+"_no_replicates";
		}
		console.log(plus_minus_corr)
		var tmp_threshold = $("#corr_slider").slider("option", "value");
		$(".loader-wrap").show();
		var finalvar = "private_view=" + tmp_datasource + "&add_new_genes_name=" + new_gene_list_name + "&add_new_genes=true&ids=" + genelist_str + "&tmp_threshold=" + tmp_threshold + "&plus_minus_corr" + plus_minus_corr;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "plugins/explot/service/explot_corr.php",
			data: (finalvar),
			success: function(json) {
				/*if(json.length==0 ){
									toastr.options = {"closeButton": false,"debug": false,"positionClass": "toast-bottom-right","onclick": null,"showDuration": "1","hideDuration": "0","timeOut": "4000","extendedTimeOut": "0","showEasing": "linear","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"}
 	 toastr.error('No similar genes can be found for your profile.', 'No macthes!');												  
							}else{
							
								
							}
							$(".loader-wrap").hide();*/
				if (json.popdata.length == 0) {
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"positionClass": "toast-bottom-right",
						"onclick": null,
						"showDuration": "1",
						"hideDuration": "0",
						"timeOut": "4000",
						"extendedTimeOut": "0",
						"showEasing": "linear",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					toastr.error('No similar genes can be found for your profile.', 'No macthes!');
				}
				var seriesLength = chart.series.length;
				var navigator;
				for (var i = seriesLength - 1; i > -1; i--) {
					if (chart.series[i].name.toLowerCase() == 'navigator') {
						navigator = chart.series[i];
					}
					else {
						if (chart.series[i].name != "Draggable Series") {
							chart.series[i].remove();
						}
					}
				}
				for (var k = 0; k < 16; k++) {
					chart.addSeries(json.popdata[k]);
					//console.log(json.popdata[k]);
				}
				$(".loader-wrap").hide(); //$("#loading_img").hide(); 			
				//   console.log(data);
				//	draw_avg_line();					
			}
		});
	});
	// Testing add series
	$('#findexp').click(function() {
		var series = chart.get('wow')
		var genelist_str = series.yData.join(",");
		console.log(series)
		
		var random_id = Math.round(Math.random() * 100) + 1;
		var new_gene_list_name = datasource + "_" + random_id;
		var tmp_datasource = "";
		if (replicate_flag == "true") {
			tmp_datasource = datasource;
		}
		else {
			tmp_datasource = datasource; //+"_no_replicates";
		}
		var tmp_range = $("#expr_slider").slider("option", "value");
		$(".loader-wrap").show();
		var finalvar = "private_view=" + tmp_datasource + "&add_new_genes_name=" + new_gene_list_name + "&add_new_genes=true&ids=" + genelist_str + "&range=" + tmp_range;
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "plugins/explot/service/explot_get_genes.php",
			data: (finalvar),
			success: function(json) {
				//console.log(json)
				if (json.popdata.length == 0) {
					toastr.options = {
						"closeButton": false,
						"debug": false,
						"positionClass": "toast-bottom-right",
						"onclick": null,
						"showDuration": "1",
						"hideDuration": "0",
						"timeOut": "4000",
						"extendedTimeOut": "0",
						"showEasing": "linear",
						"hideEasing": "linear",
						"showMethod": "fadeIn",
						"hideMethod": "fadeOut"
					}
					toastr.error('No similar genes can be found for your profile.', 'No macthes!');
				}
				var seriesLength = chart.series.length;
				var navigator;
				for (var i = seriesLength - 1; i > -1; i--) {
					if (chart.series[i].name.toLowerCase() == 'navigator') {
						navigator = chart.series[i];
					}
					else {
						if (chart.series[i].name != "Draggable Series") {
							chart.series[i].remove();
						}
					}
				}
				for (var k = 0; k < 16; k++) {
					chart.addSeries(json.popdata[k]);
					//console.log(json.popdata[k]);
				}
				$(".loader-wrap").hide(); //$("#loading_img").hide(); 			
				//   console.log(data);
				//	draw_avg_line();					
			}
		});
		//console.log(finalvar);
	});
	$('#newtable_3title').click(function() {
		
			mainCreategenelistbyName(tmp_ids_array.join(),"explot_list",function(e){get_active(function(e){
				
toastr.success("explot_list GeneList has been created with " + tmp_ids_array.length + ' gene ids.', 'New GeneList created');
				
			$("#newtable_3title").effect("transfer", {
				to: "#numberofgenesSpan",
				className: "ui-effects-transfer-2"
			}, 600);
				$("#newtable_2").hide();
				
			})})

		
/*		
		$.post("plugins/explot/service/explot.php", {
			selected_genelist: tmp_ids_array.join()
		}, function(json) {
			var hm_basic = $("body").wHumanMsg();
			hm_basic.wHumanMsg("explot list has been created. Please click GeneList link to see more details.", {
				theme: 'yellow',
				opacity: 1,
				displayLength: 8000
			});
			$("#newtable_3title").effect("transfer", {
				to: "#numberofgenesSpan",
				className: "ui-effects-transfer-2"
			}, 600);
			open_genelist_slider();
		});*/
		//alert("Wait!, I'll make a special list for you.");
	});
	//Click startTour BUtton
	$('#startTourBtn').click(function() {
		mannapperuma.startTour(tour);
	});
	//data source change
/*	$.each(['eplant_log', 'eplant_sex', 'eplant_asp201'], function(i, type) {
		$('#' + type).change(function() {
			datasource = type;
			setCookie("cookie_view", datasource, 10);
			$.drawchart();
			$("#button2").hide();
			$("#buttonxx").show();
			$("#button3").hide();
		});
	});*/
	
	
	
	
	
		//data source change
	$.each(['vstvalue', 'tpmvalue'], function(i, type2) {
		$('#' + type2).change(function(e) {
			var datatype = e.target.value;
			setCookie("cookie_datatype", datatype, 10);
			$.drawchart();
			//$("#button2").hide();
			//$("#buttonxx").show();
			//$("#button3").hide();
		});
	});
	
	

	
	
	// the button action
var hasPlotBand = false,
    $button = $('#button');

$button.click(function () {
    if (!hasPlotBand) {
        chart.xAxis[0].addPlotBand({
            from: 3.5,
            to: 7.5,
            color: '#FCFFC5',
            id: 'plot-band-1'
        });
        $button.html('Remove plot band');
    } else {
        chart.xAxis[0].removePlotBand('plot-band-1');
        $button.html('Add plot band');
    }
    hasPlotBand = !hasPlotBand;
});

	
	
	//Export
	$('#save_as_pdf').click(function() {
		chart.exportChart({
			type: 'application/pdf',
			filename: datasource
		}, {
			subtitle: {
				text: ''
			}
		});
	});
	$('#save_as_png').click(function() {
		chart.exportChart({
			type: 'image/png',
			filename: datasource
		}, {
			subtitle: {
				text: ''
			}
		});
	});
	$('#save_as_svg').click(function() {
		chart.exportChart({
			type: 'image/svg+xml',
			filename: datasource
		}, {
			subtitle: {
				text: ''
			}
		});
	});
	//Chart type radio change
	$.each(['line', 'bar', 'spline', 'area', 'areaspline', 'scatter', 'pie', 'column'], function(i, type) {
		$('#' + type).change(function() {
			chartType = type;
			for (var j = 0; j < chartDataLength; j++) {
				chart.series[j].update({
					type: type
				});
			}
		});
	});
	// the submit handler
	$('#submit').click(function() {
		$.drawchart();
	});
	
	
	
	
	
	
	
	
	
	
});
/*//hide/show sliding window
function toggleslide(){
	if( $pageslide.is( ':visible' )) {
	 $.pageslide.close();
	      document.getElementById('showbtn').style.display='inline';
		    document.getElementById('container').style.width='100%';
	   }else{
		  $.pageslide({ direction: 'left', href: '#modal', modal: false });

	     document.getElementById('showbtn').style.display='none';
	   }
}*/
function toggleMe() {
	var e = document.getElementById('newtable_3');
	if (!e) return true;
	if (e.style.display == "none") {
		//  e.style.display="block"
		document.getElementById('newtable_3').style.display = "block"
		document.getElementById('newtable_2').style.display = "none"
	}
	else {
		document.getElementById('newtable_3').style.display = "none"
		document.getElementById('newtable_2').style.display = "block"
	}
	return true;
}
// Testing add series
function draw_avg_line() {
	var chart = $('#container').Popcharts();
	var average_v = (chart.yAxis[0].max - chart.yAxis[0].min) / 2 + chart.yAxis[0].min
	//console.log(chart.yAxis[0].max,chart.yAxis[0].min,average_v)
	var tmp_a = [];
	for (var j = 0; j < chart.series[0].data.length; j++) {
		tmp_a.push(average_v)
	}
	if (chart.series.length != 1 && chart.get('wow') == undefined) {
		chart.addSeries({
			data: tmp_a,
			name: "Draggable Series",
			draggableY: true,
			id: "wow",
			tooltip: {
				valueDecimals: "sss"
			},
			lineWidth: 4,
			color: "#FF0000",
			zIndex: 9
		});
		$(this).attr('disabled', true);
		chart.yAxis[0].setExtremes(0, 10, true, false); //(chart.yAxis[0].min,chart.yAxis[0].max, true, false);
	}
	$(".radio").hide();
	$("#swaplabelsbtn").hide();
	$("#draw_line").hide();
	$("#additional_controls").slideDown("slow");
}

function additional_control_close() {
	$("#additional_controls").slideUp("slow");
	$("#draw_line").show();
	var chart = $('#container').Popcharts();
	//chart.get('wow').remove();	
}


function changeview(e){
	private_view=e;
	datasource = "expression_"+e+"_vst";
	setCookie("cookie_view", private_view, 10);
	$.drawchart();
}

function reinitTool(newArray){
	$("#experiment_div").empty();
	maingetAllExpriments(function(activeexpriments) {	
		
		var tmp_selected="";
		var tmp_arr=[];
		activeexpriments=JSON.parse(activeexpriments);


		for(var i=0;i<activeexpriments.length;i++){
			var tmp_name=activeexpriments[i]["experiment_name"];
			var tmp_value=activeexpriments[i]["experiment_value"];
			 $("#experiment_div").append('<div><input  type="radio" id="'+tmp_value+'" onchange="changeview(this.id)" name="datasource" class="radio" ><label s="" style="font-style:italic" for="'+tmp_value+'">'+tmp_name+'</label></div>');
			if(activeexpriments[i]["default selection"]=="1"){
				tmp_selected=tmp_value;
			}
			tmp_arr.push(tmp_value);
		}
				
		var cookieView = getCookie('cookie_view')
		if(cookieView== null || jQuery.inArray(cookieView, tmp_arr) == -1 ){
			private_view=tmp_selected;	 
			setCookie('cookie_view',private_view);
		}else{
			private_view=cookieView;
		}
		var b1 = document.getElementById(private_view);
		b1.checked = true;
		
		
	datasource = "expression_"+private_view+"_vst";	

		if(newArray[0]!=undefined && newArray[0].length>0){
		
			console.log(newArray)
			if(newArray[0].length>1000){toastr.error('Please save less than 1000 genes.', 'Limit exceeded');return true}
			$('#input_ids').val(newArray[0]);
			$.drawchart();
		}
		
	});	
}


maingetactiveDB(function(activedb) {
	console.log("reinitTool from print.js")
	//activedb=JSON.parse(activedb);
	MAIN_ACTIVE_GENELIST_ARRAY=activedb.split(",");

	MAIN_ACTIVE_GENELIST=activedb;
	 // tmp_selected_species_abb=activedb[0]['abbreviation'];
	 // setCookie("genie_select_species_abb", activedb[0]['abbreviation'], 10);
	  if (typeof reinitTool == 'function') { 
		
		reinitTool(activedb); 
		  }
	});
	
