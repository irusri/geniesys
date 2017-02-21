/*
* @author     Chanaka Mannapperuma <irusri@gmail.com>
* @date       2013-08-20
* @version    Beta 1.0
* @usage      Expression view create new elements
* @licence    GNU GENERAL PUBLIC LICENSE
* @link       http://irusri.com
*/
var tblPrueba2;
var gaiSelected = [];
var uniqueGenes = [];
var selectboolean = false;
var selected_genome="potri";
var current_species_tmp;

function changedbsource(sel_genome){
	//setCookie("select_species",sel_genome,10);
	//$('#poplar_species_select').val(sel_genome).change();
	//current_species_tmp=sel_genome;
}

/*if(species_selection!=""){
	$('input:radio[name="popr"][value='+species_selection+']').attr('checked', true);
	}else{
		if(getCookie("select_species") != undefined) {
		var tmpcookier=getCookie("select_species");
		$('input:radio[name="popr"][value='+tmpcookie+']').attr('checked', true);
		}

	}*/


//Very cool custom functions
function $_GET(q, s) {
    s = s ? s : window.location.search;
    var re = new RegExp('&' + q + '(?:=([^&]*))?(?=&|$)', 'i');
    return (s = s.replace('?', '&').match(re)) ? (typeof s[1] == 'undefined' ? '' : decodeURIComponent(s[1])) : undefined;
}

$.fn.getColumnsShown = function (dTable) {
    var vCols = [];
    $.each(dTable.fnSettings().aoColumns, function (c) {
        if (dTable.fnSettings().aoColumns[c].bVisible === true && c != 1) {
            vCols = vCols.concat(dTable.fnSettings().aoColumns[c].sTitle);
        }
    });
    return vCols;
}

function handleAjaxError(xhr, textStatus, error) {
	 var hm_basic = $("body").wHumanMsg();
    if (textStatus === 'timeout') {
	/*	hm_basic.wHumanMsg('Sorry! The server took too long to send the data.', {
                        theme: 'red',
                        opacity: 1,
                        displayLength: 200
                    });*/
    } else {
        hm_basic.wHumanMsg('An error occurred on the server. Please try again in a minute.', {
                        theme: 'red',
                        opacity: 1,
                        displayLength: 200
                    }); }
    tblPrueba2.fnProcessingIndicator(false);
}

jQuery.fn.dataTableExt.oApi.fnProcessingIndicator = function (oSettings, onoff) {
    if (typeof (onoff) == 'undefined') {
        onoff = true;
    }
    this.oApi._fnProcessingDisplay(oSettings, onoff);
};

$(document).ready(function () {



	 $('#loadexamplebtn').click(function(){
		 $('#myInputTextField').val("Eucgr.A00375,Eucgr.A02339,Eucgr.A02507,Eucgr.A02805,Eucgr.B01555,Eucgr.B01565,Eucgr.B02550,Eucgr.B03345,Eucgr.C00013,Eucgr.C01404,Eucgr.C03704,Eucgr.C04032,Eucgr.D00340,Eucgr.D02217,Eucgr.E00249,Eucgr.E02383,Eucgr.E02408,Eucgr.F02158,Eucgr.F02226,Eucgr.F03085,Eucgr.F03879,Eucgr.F03935,Eucgr.G00451,Eucgr.G01189,Eucgr.G02727,Eucgr.H00078,Eucgr.H02323,Eucgr.H02885,Eucgr.H02940,Eucgr.H04219,Eucgr.I00376,Eucgr.I01735,Eucgr.I02096,Eucgr.I02787,Eucgr.J00133,Eucgr.K00962,Eucgr.K01083,Eucgr.K01427,Eucgr.K01460,Eucgr.K02315,Eucgr.K02319,Eucgr.L02916");
		  tblPrueba2.fnFilter($(this).val(), $('#myInputTextField').val());
	 });

    /*
     * Main search support
     */
    $('#myInputTextField').keyup(function () {
        tblPrueba2.fnFilter($(this).val(), $('#myInputTextField').val());
		//console.log($(this).val());
       // setCookie("mainsearchcookie", $('#myInputTextField').val(), 7);

		if($('#myInputTextField').val().length==0){
	toastr.options = {"closeButton": false,"debug": false,"positionClass": "toast-bottom-right","onclick": null,"showDuration": "100","hideDuration": "100","timeOut": "2000","extendedTimeOut": "0","showEasing": "linear","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"}
 	 toastr.warning('Please type some gene ids to search.', 'Please enter gene ids..');
	}

		invalid_boolean=false;
    })


	$('input[name=popr]:radio').on('change', function(){
		tblPrueba2.fnFilter($(this).val(), $('#myInputTextField').val());
	});

    /*
     * Column search support
     */
    $('#tblPrueba2 thead input').keyup(function () { /* Filter on the column (the index) of this element */
        tblPrueba2.fnFilter($(this).val(), $('#_' + this.id + '_index').val());

        //tblPrueba2.fnFilter( $(this).val(),4 );
    }).focus(function () {
        if ($(this).hasClass('search_init')) {
            $(this).removeClass('search_init');
            $(this).val('');
        }
    })

    .blur(function (i) {
        if ($(this).val() === '') {
            $(this).addClass('search_init');
            $(this).val($('#_' + this.id + '_initVal').val());
        }
    });

	// When GET search
	if (typeof $_GET('_term') != 'undefined') {
		  var tmp_search = $_GET('_term');
		$('#myInputTextField').val(tmp_search);

	 }


	if (typeof $_GET('workflow') != 'undefined') {
		var workflow="w"+$_GET('workflow');
		 mannapperuma.startTour(eval(workflow));
	}

	// When GET table defined only
    if (typeof $_GET('table') != 'undefined') {
        var hm_1 = $("body").wHumanMsg();
        var finalvarx = "checkrandomid=" + $_GET('table');
        $.ajax({
            type: "POST",
            url: "plugins/genelist/genelist/services/search.php",
            data: (finalvarx),
            success: function (data) {
                //console.log(data);
                if (data.trim() == 'null') {
                    hm_1.wHumanMsg('Sorry! It appears that you entered the wrong table id(' + $_GET('table') + '). Please check with person who created this table.', {
                        theme: 'red',
                        opacity: 1,
                        displayLength: 3000000
                    });

                } else {
                    hm_1.wHumanMsg('It appears that you found this gene table from a shared link created in ' + data.trim() + '. If you want, you can bookmark this page: your results will be stored on the server at least for 30 days.', {
                        theme: 'yellow',
                        opacity: 1,
                        displayLength: 3000000
                    });
                }
            }
        });

        $("#myInputTextField").val('Shared table id:' + $_GET('table'));
        $("#myInputTextField").prop("disabled", true);
    }



    tblPrueba2 = $('#tblPrueba2').dataTable({
        'sAjaxSource': 'plugins/genelist/genelist/services/search.php',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({"name": "id","value": $('#myInputTextField').val()},
			{"name": "selected_genome","value": $('input[name=popr]:checked').val()}
			);
            $.ajax({
                'dataType': 'json',
                'type': 'POST',
                'url': sSource,
                'data': aoData,
                'success':fnCallback ,
                "error": handleAjaxError
            });
        },
        "sScrollXInner": "100%",
        'bAutoWidth': false,
        "bProcessing": true,
        'bServerSide': true,
        "sPaginationType": "full_numbers",
        'bInfo': true,
        'bLengthChange': true,
        'bScrollCollapse': true,
        'bSort': true,
        "aLengthMenu": [
            [10, 25, 50, 100, 500],
            [10, 25, 50, 100, 500]
        ],
        'iDisplayLength': 25,
        'oColVis': {
            'sSize': "100",
            'aiExclude': [0, 1, 2],
            'buttonText': "<span class='hint--top' aria-label='Add or Remove search columns'><i class='fa fa-table' aria-hidden='true'> </i>Change Table Columns</span>",
            'sAlign': 'left',
            "bRestore": true,
            "sRestore": "Restore default values"
        },
        "aoColumns": [{ "bVisible": 0,"aTargets": 0 }, {"aTargets": 1}, {"sWidth": "2px","aTargets": 2}, {"sWidth": "50px","aTargets": 3}, {"sWidth": "10%","aTargets": 4,"bVisible":0}, {"sWidth": "20%","aTargets": 5}, {"sWidth": "10%","bVisible":0,"aTargets": 6}, {"sWidth": "10%","bVisible":0,"aTargets": 6},{"sWidth": "10%","bVisible":0,"aTargets": 7},{"sWidth": "10%","bVisible":0,"aTargets": 8},{"sWidth": "30%","aTargets": 9},{"sWidth": "40%","aTargets": 10}],
        "aoColumnDefs": [{
        "fnRender": function (oObj) {
                if (oObj.aData[1] == true) {
                    return '<input class="checkboxSelector" checked id="rcheckbox" type="checkbox" > ';
                } else {
                    return '<input class="checkboxSelector"  id="rcheckbox" type="checkbox" > ';
                }
            },
            "aTargets": [1],
            "bSortable": false
        },
						 	{
            "aTargets": [8],
            "mData": 8,
			"sWidth": "100%",
            "mRender": function (data, type, full) {
                var pfam_str = "";
                if (data != null) {
                    var tmppfamArray = data.split(";");
                    $.each(tmppfamArray, function (key, value) {
                        var endstr;
                        (key % 2 != 0) ? (endstr = "<br>") : ((key == tmppfamArray.length - 1) ? endstr = "" : endstr = "<br>")
pfam_str += ("<a target='_blank' href='http://www.genome.jp/dbget-bin/www_bget?ko:"+value.substr(0,value.indexOf('-')) + "'>" + value.substr(0,value.indexOf('-')) + "</a>-"+value.substr(value.indexOf('-')+1)+""+ endstr);
                    });
                } else {
                    pfam_str = "";
                }
                return pfam_str;
            }
        }
						 
						 
						 ,
						 	{
            "aTargets": [9],
            "mData": 9,
			"sWidth": "100%",
            "mRender": function (data, type, full) {
                var pfam_str = "";
                if (data != null) {
                    var tmppfamArray = data.split(";");
                    $.each(tmppfamArray, function (key, value) {
                        var endstr;
                        (key % 2 != 0) ? (endstr = "<br>") : ((key == tmppfamArray.length - 1) ? endstr = "" : endstr = "<br>")
pfam_str += ("<a target='_blank' href='http://atgenie.org/gene?id="+value.substr(0,value.indexOf('-')) + "'>" + value.substr(0,value.indexOf('-')) + "</a>-"+value.substr(value.indexOf('-')+1)+""+ endstr);
                    });
                } else {
                    pfam_str = "";
                }
                return pfam_str;
            }
        },
						 
						 	{
            "aTargets": [10],
            "mData": 10,
			"sWidth": "100%",
            "mRender": function (data, type, full) {
                var pfam_str = "";
                if (data != null) {
                    var tmppfamArray = data.split(";");
                    $.each(tmppfamArray, function (key, value) {
                        var endstr;
                        (key % 2 != 0) ? (endstr = "<br>") : ((key == tmppfamArray.length - 1) ? endstr = "" : endstr = "<br>")
pfam_str += ("<a target='_blank' href='http://amigo.geneontology.org/cgi-bin/amigo/term_details?term="+value.substr(0,value.indexOf('-')) + "'>" + value.substr(0,value.indexOf('-')) + "</a>-"+value.substr(value.indexOf('-')+1)+""+ endstr);
                    });
                } else {
                    pfam_str = "";
                }
                return pfam_str;
            }
        },
						  
						 	{
            "aTargets": [11],
            "mData": 11,
			"sWidth": "100%",
            "mRender": function (data, type, full) {
                var pfam_str = "";
                if (data != null) {
                    var tmppfamArray = data.split(";");
                    $.each(tmppfamArray, function (key, value) {
                        var endstr;
                        (key % 2 != 0) ? (endstr = "<br>") : ((key == tmppfamArray.length - 1) ? endstr = "" : endstr = "<br>")
pfam_str += ("<a target='_blank' href='http://pfam.xfam.org/family/"+value.substr(0,value.indexOf('-')) + "'>" + value.substr(0,value.indexOf('-')) + "</a>-"+value.substr(value.indexOf('-')+1)+""+ endstr);
                    });
                } else {
                    pfam_str = "";
                }
                return pfam_str;
            }
        }
						 

						 

        ],
        "fnRowCallback": function (nRow, aData, iDisplayIndex) {
            if (jQuery.inArray(aData[0], gaiSelected) != -1) {
                $(nRow).find('.checkboxSelector').prop("checked", true);
            } else {
                $(nRow).find('.checkboxSelector').prop("checked", $(".checkboxSelectorall").prop('checked'));

            }
            return nRow;
        },
        'oTableTools': {
            "sRowSelect": "multi",
            "sSwfPath": "plugins/genelist/genelist/swf/copy_csv_xls_pdf.swf",
            'aButtons': [/*{
                'sExtends': 'copy',
                'sToolTip': 'Copy table',
                'sButtonText': 'Copy table'
            }, */


			/*{
                'sExtends': 'downloadtest',
                'sToolTip': 'Export table as CSV',
                'sButtonText': 'Export table as CSV',
                'sFileName': '*.csv',
                "sUrl": "plugins/genelist/genelist/services/download.php",
                "mColumns": "visible"
            },*/{
                "sExtends": "ajax",
                'sButtonText': '<span class="hint--top" aria-label="Save current search results to active GeneList"><i class="fa fa-cart-plus  fa-2x" aria-hidden="true"></i></span>',
				 titleAttr: 'Add Genes to Active GeneList',
                "fnClick": function (nButton, oConfig) {
                    var searchs = $('#myInputTextField').val();
                    var columns = this.s.dt.aoPreSearchCols;
                    var columnsearch = "";
                    var oParams = this.s.dt.oApi._fnAjaxParameters(this.s.dt);
                    var numberofgenesrecord = this.s.dt._iRecordsTotal;
                    for (i = 0; i < columns.length; i++) {
                        columnsearch += "&filter_" + i + "=" + encodeURIComponent(columns[i].sSearch);
                    }
                    var finalvar = $.param(oParams) + "&iDisplayLength=" + this.s.dt._iRecordsTotal + "&add_genes=true&id=" + $('#myInputTextField').val()+"&selected_genome="+$('input[name=popr]:checked').val();
                    $('body').css("cursor", "wait");
                    $(nButton).html("<img src='plugins/genelist/genelist/swf/btnloader.GIF' />");
                    $.ajax({
                        type: "POST",
                        url: "plugins/genelist/genelist/services/search_id.php",
                        data: (finalvar),
                        success: function () {
                            $("#tblPrueba2").stop();
                            $("#tblPrueba2").effect("transfer", {
                                to: "#numberofgenesSpan",
                                className: "ui-effects-transfer-2"
                            }, 800);

                            updategenebasket();
                            $('body').css("cursor", "auto");
                            $(nButton).html('<span class="hint--top" aria-label="Save current search results to active GeneList"><i class="fa fa-cart-plus  fa-2x" aria-hidden="true"></i></span>');
                            $('.checkboxSelector', tblPrueba2.fnGetNodes()).prop('checked', true);
                            selectboolean = true;


                        }
                    });
                }
            },


			{
                "sExtends": "ajax",
                'sButtonText': '<span class="hint--top" aria-label="Save as a new GeneList"><i class="fa fa-plus  fa-2x" aria-hidden="true"></i></span>',
                "fnClick": function (nButton, oConfig) {
                    var searchs = $('#myInputTextField').val();
                    var columns = this.s.dt.aoPreSearchCols;
                    var columnsearch = "";
                    var oParams = this.s.dt.oApi._fnAjaxParameters(this.s.dt);
                    var numberofgenesrecord = this.s.dt._iRecordsTotal;
                    for (i = 0; i < columns.length; i++) {
                        columnsearch += "&filter_" + i + "=" + encodeURIComponent(columns[i].sSearch);
                    }


					 var new_gene_list_name = prompt("Please enter new Gene List name", "Complex");

if(new_gene_list_name == "" || new_gene_list_name == null) {
		return;
	}


                    var finalvar = $.param(oParams) + "&iDisplayLength=" + this.s.dt._iRecordsTotal +"&add_new_genes_name="+new_gene_list_name+ "&add_new_genes=true&id=" + $('#myInputTextField').val()+"&selected_genome="+$('input[name=popr]:checked').val();
                    $('body').css("cursor", "wait");
                    $(nButton).html("<img src='plugins/genelist/genelist/swf/btnloader.GIF' />");
                    $.ajax({
                        type: "POST",
                        url: "plugins/genelist/genelist/services/search_id.php",
                        data: (finalvar),
                        success: function () {
                            $("#tblPrueba2").stop();
                            $("#tblPrueba2").effect("transfer", {
                                to: "#numberofgenesSpan",
                                className: "ui-effects-transfer-2"
                            }, 1600);

                            updategenebasket();
                            $('body').css("cursor", "auto");
                            $(nButton).html('<span class="hint--top" aria-label="Save as a new GeneList"><i class="fa fa-plus  fa-2x" aria-hidden="true"></i></span>');
                            $('.checkboxSelector', tblPrueba2.fnGetNodes()).prop('checked', true);
                            selectboolean = true;


                        }
                    });
                }
            },


            //
            // {
            //     "sExtends": "ajax",
            //     'sButtonText': 'Remove selected from Gene List',
            //     "fnClick": function (nButton, oConfig) {
            //
            //         var searchs = $('#myInputTextField').val(); //this.s.dt.oPreviousSearch.sSearch;
            //         var columns = this.s.dt.aoPreSearchCols;
            //         var columnsearch = "";
            //         var oParams = this.s.dt.oApi._fnAjaxParameters(this.s.dt);
            //         var numberofgenesrecord = this.s.dt._iRecordsTotal;
            //
            //         for (i = 0; i < columns.length; i++) {
            //             columnsearch += "&filter_" + i + "=" + encodeURIComponent(columns[i].sSearch);
            //         }
            //         var finalvar = $.param(oParams) + "&iDisplayLength=" + this.s.dt._iRecordsTotal + "&remove_genes=true&id=" + $('#myInputTextField').val()+"&selected_genome="+$('input[name=popr]:checked').val();;
            //         $('body').css("cursor", "wait");
            //         $(nButton).html("Removing genes..<img src='plugins/genelist/genelist/swf/btnloader.GIF' />");
            //         $.ajax({
            //             type: "POST",
            //             url: "plugins/genelist/genelist/services/search_id.php",
            //             data: (finalvar),
            //             success: function () {
            //                 $("#numberofgenesSpan").stop();
            //                 $("#numberofgenesSpan").effect("transfer", {
            //                     to: "#deletebasket",
            //                     className: "ui-effects-transfer-2"
            //                 }, 1600);
            //                 updategenebasket();
            //                 $('body').css("cursor", "auto");
						// 	$(nButton).html("Remove all from Gene List");
            //                 $('.checkboxSelector', tblPrueba2.fnGetNodes()).prop('checked', false);
            //                 selectboolean = false;
            //             }
            //
            //         });
            //
            //
            //     }
            //
            // },

            {
                "sExtends": "ajax",
                'sButtonText': '<span class="hint--top hint--error" aria-label="Replace active GeneList"><i class="fa fa-retweet fa-2x" style="color:#FFF" aria-hidden="true"></i></span>',
                "fnClick": function (nButton, oConfig) {
                    var searchs = $('#myInputTextField').val();
                    var columns = this.s.dt.aoPreSearchCols;
                    var columnsearch = "";
                    var oParams = this.s.dt.oApi._fnAjaxParameters(this.s.dt);
                    var numberofgenesrecord = this.s.dt._iRecordsTotal;
                    for (i = 0; i < columns.length; i++) {
                        columnsearch += "&filter_" + i + "=" + encodeURIComponent(columns[i].sSearch);
                    }
                    var finalvar = $.param(oParams) + "&iDisplayLength=" + this.s.dt._iRecordsTotal + "&replace_genes=true&id=" + $('#myInputTextField').val()+"&selected_genome="+$('input[name=popr]:checked').val();
                    $('body').css("cursor", "wait");
                    $(nButton).html("<img src='plugins/genelist/genelist/swf/btnloader.GIF' />");
                    $.ajax({
                        type: "POST",
                        url: "plugins/genelist/genelist/services/search_id.php",
                        data: (finalvar),
                        success: function () {
                            $("#tblPrueba2").stop();
                            $("#tblPrueba2").effect("transfer", {
                                to: "#numberofgenesSpan",
                                className: "ui-effects-transfer-2"
                            }, 800);

                            updategenebasket();
                            $('body').css("cursor", "auto");
                            $(nButton).html('<span class="hint--top hint--error" aria-label="Replace active GeneList"><i class="fa fa-retweet fa-2x" style="color:#FFF" aria-hidden="true"></i></span>');
                            $('.checkboxSelector', tblPrueba2.fnGetNodes()).prop('checked', true);
                            selectboolean = true;


                        }
                    });
                }
            },
            {
                "sExtends": "ajax",
                'sButtonText': '<span class="hint--top hint--error" aria-label="Remove active GeneList"><i class="fa fa-trash  fa-2x" style="color:#FFF" aria-hidden="true"></i></span>',
                "fnClick": function (nButton, oConfig) {
                    $('body').css("cursor", "wait");
                    $(nButton).html("<img src='plugins/genelist/genelist/swf/btnloader.GIF' />");
                    $.ajax({
                        type: "POST",
                        url: "plugins/genelist/crud/updatedatabase.php",
                        data: {
                            empty_default_basket: "ss"
                        },
                        success: function () {
                            $("#numberofgenesSpan").stop();
                            $("#numberofgenesSpan").effect("transfer", {
                                to: "#deletebasket",
                                className: "ui-effects-transfer-2"
                            }, 1600);
                            updategenebasket();
                            $('body').css("cursor", "auto");
                            $(nButton).html('<span class="hint--top hint--error" aria-label="Remove active GeneList"><i class="fa fa-trash  fa-2x" style="color:#FFF" aria-hidden="true"></i></span>');
                            $('.checkboxSelector', tblPrueba2.fnGetNodes()).prop('checked', false);
                            selectboolean = false;
                        }
                    });
                }


            },
            {
               'sExtends': 'downloadtest',
               'sButtonText': '<span class="hint--top" aria-label="Download current search results"><i class="fa fa-download  fa-2x" aria-hidden="true"></i></span>',
               'sFileName': '*.tsv',
               "sUrl": "plugins/genelist/genelist/services/download.php",
               "mColumns": "visible"
           },
            {
                "sExtends": "ajax",
                'sButtonText': '<span class="hint--top" aria-label="Share current search results"><i class="fa fa-share-alt  fa-2x" aria-hidden="true"></i></span>',
                "fnClick": function (nButton, oConfig) {
                    var searchs = $('#myInputTextField').val();
                    var columns = this.s.dt.aoPreSearchCols;
                    var columnsearch = "";
                    var oParams = this.s.dt.oApi._fnAjaxParameters(this.s.dt);
                    var numberofgenesrecord = this.s.dt._iRecordsTotal;
                    var rowsk = $("#tblPrueba2").dataTable().fnGetNodes();
                    for (i = 0; i < columns.length; i++) {
                        columnsearch += "&filter_" + i + "=" + encodeURIComponent(columns[i].sSearch);
                    }
                    var finalvar = $.param(oParams) + "&iDisplayLength=" + this.s.dt._iRecordsTotal + "&share_table=true&id=" + $('#myInputTextField').val()+"&selected_genome="+$('input[name=popr]:checked').val();
                    $('body').css("cursor", "wait");
					$(nButton).html("<img src='plugins/genelist/genelist/swf/btnloader.GIF' />");
                    $.ajax({
                        type: "POST",
                        url: "plugins/genelist/genelist/services/search_id.php",
                        data: (finalvar),
                        success: function (data) {
                            $('body').css("cursor", "auto");
							$(nButton).html('<span class="hint--top" aria-label="Share current search results"><i class="fa fa-share-alt  fa-2x" aria-hidden="true"></i></span>');
                            var hm = $("body").wHumanMsg();
                            hm.wHumanMsg('Shared Link: <a target="_blank" href="' + "/?table=" + data.trim() + '">http://eucgenie.org/?table=' + data.trim() + '</a>', {
                                theme: 'cream',
                                opacity: 1,
                                displayLength: 30000
                            });
                        }
                    });
                }
            }, ]
        },

    'sDom': 'TC<\'clear\'>lfrtip',
        'sScrollX': '100%',
		
		
          "sScrollXInner": "120%",
        	'sScrollY': ($(window).height()-400),
        'fnInitComplete': function (oSettings, json) {
            new FixedColumns(this, {
                'iLeftColumns': 0
/*,
        'iRightColumns': 0*/
            });
        },
        "fnDrawCallback": function () {
            tblPrueba2.fnAdjustColumnSizing(false);

            // TableTools
            if (typeof (TableTools) != "undefined") {
                var tableTools = TableTools.fnGetInstance(tblPrueba2);
                if (tableTools != null && tableTools.fnResizeRequired()) {
                    tableTools.fnResizeButtons();
                }
            }
            //
            var $dataTableWrapper = tblPrueba2.closest(".dataTables_wrapper");
            var panelHeight = $dataTableWrapper.parent().height();

            var toolbarHeights = 0;
            $dataTableWrapper.find(".fg-toolbar").each(function (i, obj) {
                toolbarHeights = toolbarHeights + $(obj).height();
            });

            var scrollHeadHeight = $dataTableWrapper.find(".dataTables_scrollHead").height();
            var height = panelHeight - toolbarHeights - scrollHeadHeight;
            $dataTableWrapper.find(".dataTables_scrollBody").height(height);

            tblPrueba2._fnScrollDraw();
        }
        //datatables end
    });
//tblPrueba2.bind('processing',function(e, oSettings, bShow){console.log(bShow)});
var old_number=0;
var invalid_boolean;
tblPrueba2.bind('processing',
function (e, oSettings, bShow) {

    if (bShow) {
        $("#loader").show();
    } else {
        $("#loader").hide();

		if($('#myInputTextField').val()==""){
			//hm_loading_errors.wHumanMsg('Please type in some gene ids.', {theme: 'green', opacity: 0.8, displayLength: 300});

		}else{
			//  $('#elem').wHumanMsg('opacity', 0.0)
	   // console.log($('#elem').wHumanMsg('opacity'));

			if(oSettings._iRecordsDisplay==73013 || oSettings._iRecordsDisplay==0){
			//	hm_loading_errors.wHumanMsg('Invalid input detected, please type in correct ids.', {theme: 'yellow', opacity: 0.6,displayLength: 200});
			if(invalid_boolean!=true){
			toastr.options = {"closeButton": false,"debug": false,"positionClass": "toast-bottom-right","onclick": null,"showDuration": "1","hideDuration": "0","timeOut": "1000","extendedTimeOut": "0","showEasing": "linear","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"}
 	 toastr.error('Invalid input detected, please type in correct ids', 'Invalid input');
	 invalid_boolean=true;
			}

			}else {
				 //var hm_loading_errors = $("body").wHumanMsg();
				if(oSettings._iRecordsDisplay>1 && oSettings._iRecordsDisplay!=73013){
					// $('#elem').wHumanMsg('opacity', 0.0);
				//hm_loading_errors.wHumanMsg(''+oSettings._iRecordsDisplay+' gene models found.', {theme: 'green', opacity: 0.8, displayLength: 8000});
					//toastr.clear();

					if(old_number!=oSettings._iRecordsDisplay){
					toastr.options = {"closeButton": false,"debug": false,"positionClass": "toast-bottom-right","onclick": null,"showDuration": "1","hideDuration": "0","timeOut": "4000","extendedTimeOut": "0","showEasing": "linear","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"}
 	 toastr.success(''+oSettings._iRecordsDisplay+' gene models found.', 'Success');
					old_number=oSettings._iRecordsDisplay
					}

				}
				}
		}
    }

});



//Initialize table with already selected genes
var init_flag=true;
 if (init_flag == true && typeof $_GET('table') == 'undefined' && typeof $_GET('_term') == 'undefined') {
       // var hm_flag= $("body").wHumanMsg();
        var finalvarx = "init_flag=true";
        $.ajax({
            type: "POST",
            url: "plugins/genelist/genelist/services/search.php",
            data: (finalvarx),
            success: function (data) {
                if (data.trim() == 'null') {
					(getCookie("mainsearchcookie") != undefined) ? $('#myInputTextField').val(getCookie("mainsearchcookie")) : $('#myInputTextField').val("");
					tblPrueba2.fnFilter($('#myInputTextField').val(), getCookie("mainsearchcookie"));

					if($('#myInputTextField').val().length<4){
	toastr.options = {"closeButton": false,"debug": false,"positionClass": "toast-bottom-right","onclick": null,"showDuration": "100","hideDuration": "100","timeOut": "6000","extendedTimeOut": "0","showEasing": "linear","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"}
 	 toastr.info('Please enter a gene id (such as Potri.004G059600) or synonym (such as cesa) to search all database fields.', 'Start your search');
	}

                } else {
					try
  						{
//event.stopPropagation();
					$("#myInputTextField").val(JSON.parse(data));
					//event.stopPropagation();
					//console.log(data);
					tblPrueba2.fnFilter($('#myInputTextField').val(), JSON.parse(data));
				}
					catch(err)
 				 {
					 console.log(err)
	 				 }

                }
            }
        });
		init_flag=false;
    }


    /***cache thing */
    var t = document.getElementsByTagName('textarea')[0];
    var offset = !window.opera ? (t.offsetHeight - t.clientHeight) : (t.offsetHeight + parseInt(window.getComputedStyle(t, null).getPropertyValue('border-top-width')));

    t.style.height = 'auto';
    t.style.height = (t.scrollHeight + offset) + 'px';

    var resize = function (t) {
            t.style.height = 'auto';
            t.style.height = (t.scrollHeight + offset) + 'px';
        }

    t.addEventListener && t.addEventListener('input', function (event) {
        resize(t);
    });

    t['attachEvent'] && t.attachEvent('onkeyup', function () {
        resize(t);
    }); /** cache thing end */
    $(".checkboxSelectorall").change(function () {
        var aData = tblPrueba2.fnGetData();
        for (var j = 0; j < aData.length; j++) {
            var iId = aData[j][0];
            if (jQuery.inArray(iId, gaiSelected) == -1) {
                gaiSelected[gaiSelected.length++] = iId;
            } else {

            }
        }

        if ($(".checkboxSelectorall").prop('checked') == true) {
          //  addtothebasket(gaiSelected.join(","));
        } else {
            //removefrombasket(gaiSelected.join(","));
        }
        tblPrueba2.$(".checkboxSelector").prop('checked', $(".checkboxSelectorall").prop('checked'));
    });

    $("#tblPrueba2 tbody tr td input").live("change", function (event) {
        var temp_gene_selecct_id = ($(event.target).parent().parent().find("tr").prevObject[0].childNodes[1].textContent);
        if ($(event.target)[0].checked == true) {
            addtothebasket(temp_gene_selecct_id);
            $(event.target).stop();
            $(event.target).effect("transfer", {
                to: "#numberofgenesSpan",
                className: "ui-effects-transfer-2"
            }, 800);
        } else {
            removefrombasket(temp_gene_selecct_id);
            $("#numberofgenesSpan").stop();
            $("#numberofgenesSpan").effect("transfer", {
                to: $(event.target),
                className: "ui-effects-transfer-2"
            }, 800);
        }
    });
    //Function ready end
});

TableTools.BUTTONS.downloadtest = {
    "sAction": "text",
    "sTag": "default",
    "sFieldBoundary": "",
    "sFieldSeperator": "\t",
    "sNewLine": "<br>",
    "sToolTip": "",
    "sButtonClass": "DTTT_button_text",
    "sButtonClassHover": "DTTT_button_text_hover",
    "sButtonText": "Download",
    "mColumns": "visible",
    "bHeader": true,
    "bFooter": true,
    "sDiv": "",
    "fnMouseover": null,
    "fnMouseout": null,
    "fnClick": function (nButton, oConfig) {
        var ColumnsShown = $('#tblPrueba2').getColumnsShown(tblPrueba2);

        var oParams = this.s.dt.oApi._fnAjaxParameters(this.s.dt);
		var tmp_str= $('#myInputTextField').val().replace( /\r?\n/g, " " );
        var ignitedPost = [{
            "name": "id",
            "value": tmp_str
        },
		{
           "name": "selected_genome","value": $('input[name=popr]:checked').val()
        },

		 {
            "name": "iDisplayLength",
            "value": this.s.dt._iRecordsTotal
        }, {
            "name": "visColumns",
            "value": ColumnsShown
        }, {
            "name": "button_name",
            "value": oConfig.sButtonText
        }

        ];
        var aoGet = [];
		//console.log(ignitedPost)
        var aoPost = oParams.concat(ignitedPost);
        nIFrame = document.createElement('iframe');
        nIFrame.setAttribute('id', 'RemotingIFrame');
        nIFrame.style.border = '0px';
        nIFrame.style.width = '0px';
        nIFrame.style.height = '0px';

        document.body.appendChild(nIFrame);
        var nContentWindow = nIFrame.contentWindow;
        nContentWindow.document.open();
        nContentWindow.document.close();

        var nForm = nContentWindow.document.createElement('form');
        nForm.setAttribute('method', 'post');

        for (var i = 0; i < aoPost.length; i++) {
            nInput = nContentWindow.document.createElement('input');
            nInput.setAttribute('name', aoPost[i].name);
            nInput.setAttribute('type', 'text');
            nInput.value = aoPost[i].value;

            nForm.appendChild(nInput);
        }
        var sUrlAddition = '';
        for (var i = 0; i < aoGet.length; i++) {
            sUrlAddition += aoGet[i].name + '=' + aoGet[i].value + '&';
        }
        nForm.setAttribute('action', oConfig.sUrl);
        nContentWindow.document.body.appendChild(nForm);


        nForm.submit();
    },
    "fnSelect": null,
    "fnComplete": null,
    "fnInit": null
};

function updateGeneBasket(gaiSelected) {
    $.each(gaiSelected, function (i, el) {
        if ($.inArray(el, uniqueGenes) === -1) uniqueGenes.push(el);
    });
}


function addtothebasket(addstr) {
    $.ajax({
        type: "POST",
        url: "plugins/genelist/crud/updatedatabase.php",
        data: {
            genes_send_add: addstr
        },
        success: function () {
            updategenebasket()
        }
    });
}

function removefrombasket(removestr) {
    $.ajax({
        type: "POST",
        url: "plugins/genelist/crud/updatedatabase.php",
        data: {
            genes_send_remove: removestr
        },
        success: function () {
            updategenebasket()
        }
    });
}


function setCookie(c_name, value, exdays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value = escape(value) + ((exdays == null) ? "" : "; expires=" + exdate.toUTCString());
    document.cookie = c_name + "=" + c_value;
}

function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}
