var tblPrueba2;
var gaiSelected =  [];
var gaiSelected2 =  [];
var uniqueGenes = [];
var selectboolean=false;

$(document).ready(function() {
	(getCookie("mainsearchcookie")!=undefined)?$('#myInputTextField').val(getCookie("mainsearchcookie")):$('#myInputTextField').val("MA_10000213g0010");

  var columnDefinitions = [
   /* {"sTitle":"Engine","aTargets":[0],"mData":"engine","bVisible":true,"bSearchable":true,"bSortable":true},
    {"sTitle":"Browser","aTargets":[1],"mData":"browser","bVisible":true,"bSearchable":true,"bSortable":true},
    {"sTitle":"Platform","aTargets":[2],"mData":"platform","bVisible":true,"bSearchable":true,"bSortable":true},
    {"sTitle":"Version","aTargets":[3],"mData":"version","bVisible":true,"bSearchable":true,"bSortable":true}*/
   	// {"sTitle":"Grade","aTargets":[4],"mData":"grade","bVisible":true,"bSearchable":true,"bSortable":true},
	//{"sTitle":"Acciones","aTargets":[5],"mData":"acciones","bVisible":true,"bSearchable":true,"bSortable":true}//,"sClass":"botonera"
  ];
    /*
   * Main search support
   */	
  $('#myInputTextField').keyup(function(){
	    tblPrueba2.fnFilter( $(this).val(), $('#myInputTextField').val() );
		setCookie("mainsearchcookie",$('#myInputTextField').val(),7);
		})
    /*
   * Column search support
   */				
$('#tblPrueba2 thead input')
  .keyup( function () {
    /* Filter on the column (the index) of this element */
    tblPrueba2.fnFilter( $(this).val(), $('#_'+this.id+'_index').val() );
  } )
  .focus( function () {
    if ( $(this).hasClass('search_init') ){
      $(this).removeClass('search_init');
      $(this).val('');}
  } )
  
  .blur( function (i) {
    if ( $(this).val() === '' ){
      $(this).addClass('search_init');
      $(this).val($('#_'+this.id+'_initVal').val());}
  } );
  tblPrueba2 = $('#tblPrueba2').dataTable( {
     'sAjaxSource'    : 'http://congenie.org/sites/all/themes/admire_grunge/requests/beta_search_augusts2.php',
	  'fnServerData': function(sSource, aoData, fnCallback){
          aoData.push( { "name": "id", "value": $('#myInputTextField').val()} );
	      $.ajax
            ({
              'dataType': 'json',
              'type'    : 'GET',
              'url'     : sSource,
              'data'    : aoData,
              'success' : fnCallback
            }); 
		//	console.log(fnCallback());
	    },
   //'aoColumnDefs': columnDefinitions,
    'bAutoWidth': true,
	//'aoColumns':[{ type: "checkbox", values: [ 'Gecko', 'Trident'] },{},{},{},{ type: "checkbox", values: [ 'A', 'C']  } ],
   // 'bFilter': true,
   	"bProcessing": true,
	'bServerSide'    : true,
	"sPaginationType": "full_numbers",
    'bInfo': true,
    'bLengthChange': true,
    'bScrollCollapse': true,
    'bSort': true,
	"aLengthMenu": [[10, 25, 50, 100,500,1000,2000,4000], [10, 25, 50, 100,500,1000,2000,4000]],
    'iDisplayLength': 500,
    'oColVis': {
		'aiExclude': [0],
		'buttonText': "Show/ Hide columns",
		'sAlign' : 'left'
    	},
	"aoColumns": [
			{ "bVisible": 0 }, /* ID column */
			null,
			null,
			null,
			null,
			null,
			{"sTitle": "<input class='checkboxSelectorall'  type='checkbox' id='selectAll'></input>"}
		],
	"aoColumnDefs": [{
				"fnRender": function ( oObj ) {
					/*if ( selectboolean== true)
					{
						return '<input class="checkboxSelector" id="rcheckbox" checked type="checkbox" > ';//'+oObj.aData[0]+'
					}else{*/
						return '<input class="checkboxSelector" id="rcheckbox" type="checkbox" > ';	
					//}
					},
		"aTargets": [6],
		"bSortable": false  
				}],
	"fnRowCallback": function( nRow, aData, iDisplayIndex ) {
		//$('#rcheckbox'+aData[0]).prop('checked', true);
			if ( jQuery.inArray(aData[0], gaiSelected) != -1 ){
				//console.log($('#rcheckbox'+aData[0]).prop);
				////$(nRow).addClass('DTTT_selected');
				$(nRow).find('.checkboxSelector').prop("checked", true);
				//	if (nRow).hasClass('DTTT_selected')) {
					//$(nRow).find('#rcheckbox'+aData[0]).prop("checked", true);
					//}
			}else{
				$(nRow).find('.checkboxSelector').prop("checked", $(".checkboxSelectorall").prop('checked'));
				
				}
			return nRow;
		},
    'oTableTools': {
		"sRowSelect": "multi",
      	"sSwfPath": "sites/all/themes/admire_grunge/genelist/swf/copy_csv_xls_pdf.swf.1",
      	'aButtons': [
		{
          'sExtends': 'select_all',
          'sToolTip': 'Select All',
          'sButtonText': 'Select All'
        },
		
		{
          'sExtends': 'select_none',
          'sToolTip': 'Deselect All',
          'sButtonText': 'Deselect All'
        },
		
		
        {
          'sExtends': 'copy',
          'sToolTip': 'Copy table',
          'sButtonText': 'Copy table'
        },
        {
          'sExtends': 'pdf',
          'sToolTip': 'Export table as PDF',
          'sButtonText': 'Export table as PDF'
        },
        {
          'sExtends': 'xls',
          'sToolTip': 'Export table a Excel',
          'sButtonText': 'Export table as Excel',
          'sFileName': '*.xls'
        }
      ]
    },
    'sDom': 'TC<\'clear\'>lfrtip',
    'sScrollX': '100%',
    'fnInitComplete': function(oSettings, json) {
      new FixedColumns( this, {
        'iLeftColumns': 0/*,
        'iRightColumns': 1*/
      } );
    }
  } );
  
  /*$("#selectAll").toggle(function (e) { 
  		$('.checkboxSelector', tblPrueba2.fnGetNodes()).prop('checked', true); 
		
		$('.checkboxSelectorall').prop('checked', true);
		
				//var aData = tblPrueba2.fnGetNodes();
	////	console.log(aData);
		$(tblPrueba2.fnGetNodes()).addClass('DTTT_selected');
		 e.stopPropagation();
		  return false;
		}
      // $("checkboxSelector", tblPrueba2.fnGetNodes()).attr("checked", true); }
     , function () { 
	 	$('.checkboxSelector' ,tblPrueba2.fnGetNodes()).prop('checked', false);
		$(tblPrueba2.fnGetNodes()).removeClass('DTTT_selected');
       //  $("checkboxSelector", tblPrueba2.fnGetNodes()).attr("checked", false); 
     });*/
  
  $(".checkboxSelectorall").change(function() {
       tblPrueba2.$(".checkboxSelector").prop('checked', $(".checkboxSelectorall").prop('checked'));
	   
	   var aData = tblPrueba2.fnGetData(  );
	   
	    var aData2 =tblPrueba2.fnGetNodes();
 // console.log(aData2);



 
	 
	 for(var j=0;j<aData.length;j++){
	 	 var iId = aData[j][0];
		 
	   if ( jQuery.inArray(iId, gaiSelected) == -1 ){
			gaiSelected[gaiSelected.length++] = iId;
		}else{
			gaiSelected = jQuery.grep(gaiSelected, function(value) {
				return value != iId;
			} );
		}
	 }
	   
	updateGeneBasket(gaiSelected);
	  // selectboolean=true;
     });
	 
	
	$("#tblPrueba2 tbody tr td input").live("change",function() {
		 if(tblPrueba2.$(".checkboxSelector").prop('checked') ==false){
			$(".checkboxSelectorall").prop('checked',false); 
		 }
	 });
  
  /* Click event handler 
	$('#tblPrueba2 tbody tr').live('click', function () {
		var aData = tblPrueba2.fnGetData( this );
		
		var iId = aData[0];
		if ( jQuery.inArray(iId, gaiSelected) == -1 ){
			gaiSelected[gaiSelected.length++] = iId;
		}else{
			gaiSelected = jQuery.grep(gaiSelected, function(value) {
				return value != iId;
			} );
		}
		$(this).toggleClass('row_selected');
		//// chanaka $('#rcheckbox'+iId).prop('checked', true);
		
	} ); */
  
  
} );


function updateGeneBasket(gaiSelected){
	$.each(gaiSelected, function(i, el){
    		if($.inArray(el, uniqueGenes) === -1) uniqueGenes.push(el);
	});
		
	console.log(uniqueGenes.length);
}



function setCookie(c_name,value,exdays)
{
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}

function getCookie(c_name){
	var c_value = document.cookie;
	var c_start = c_value.indexOf(" " + c_name + "=");
	if (c_start == -1){
	  c_start = c_value.indexOf(c_name + "=");
	  }
	if (c_start == -1) {
	  c_value = null;
	  }else{
	  c_start = c_value.indexOf("=", c_start) + 1;
	  var c_end = c_value.indexOf(";", c_start);
	  if (c_end == -1){
		c_end = c_value.length;
		}
		c_value = unescape(c_value.substring(c_start,c_end));
		}
	return c_value;
}

