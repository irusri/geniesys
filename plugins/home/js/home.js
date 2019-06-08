var select_text='<select id="datasetmenu"   name="datasetmenu_3" style="width: 260px;font-size:16px" > <option value="" selected="">- CHOOSE DATASET -</option><option value="Athaliana_447">Athaliana Araport11</option><option value="Athaliana_167">Athaliana TAIR10</option><option value="Egrandis_297">Egrandis v2.0</option><option value="Ptrichocarpa_210">Ptrichocarpa v3.0</option> <option value="Ptrichocarpa_444">Ptrichocarpa v3.1</option><option value="Zmays_284">Zmays Ensembl-18</option><option value="Atrichopoda_291">Atrichopoda v1.0</option></select>';	
	
function rainbowHide() {
  $(".mmo-illustration--rainbow svg").attr("class", "hide");
}
function rainbowFadeOutDown() {
  $(".mmo-illustration--rainbow svg").attr("class", "animated fadeOutDown");
}
function rainbowFadeInUp() {
  $(".mmo-illustration--rainbow svg").attr("class", "animated fadeInUp");
	
}

// Clicking on the timeline truck stops
var rainbowActivation = false;
/*Initialize just show the message to selected the species and the dropdown*/
datasetselector(1);	

var selected_species="null";	
var selected_species_name="null";
var selected_species_1="null";	
var selected_species_name_1="null";
var new_db_name="null";
var key;
var service_url="http://build.plantgenie.org/";

/*Main function to do different task depending on the id
id1= Display basic information and Download the database depending on the selection
id2= Get database information, create the database and grant user permissions
id3= Loading database and write sesttings file Finnaly display the summary information
*/
function datasetselector(a){
	switch(a) {
    case 5:
		new_db_name=$("#create_database_input").val();
		var load_img='<img width="40px" id="transcript_info_load" src="mif/load.gif" />';	
		$("#message-01").html("This might take a few minutes to download. <br>"+load_img); //You can access the mysql database using <br><br>http://localhost/phpmyadmin<br>username: admin<br>password: mypass<br>
		$("#message-02").html("");	
		$("#headline-01").html("You are almost done…");	
		$("#headline-02").html("");
		finalize_database();		
        break;			
	case 4:		
		var input_text_box='';	
		var go_2_last='<br><button id="sp_in" onclick="gotolast(2)" style="font-size:16px;height: 40px;" type="button">Install the empty database</button>';	
		$("#message-01").html(input_text_box);
		$("#message-02").html(" However, you can install the empty database into your MySQL server.<br>"+go_2_last);
		$("#headline-01").html("Sorry! we do not have your species in the list.");	
		$("#headline-02").html("");
		break;
    case 3:
		new_db_name=$("#create_database_input").val();
		var load_img='<img width="40px" id="transcript_info_load" src="mif/load.gif" />';	
		$("#message-01").html("This might take a few minutes to download <font color='red'>"+selected_species_name+"</font> data from Biomart and building <font color='red'>"+new_db_name+"</font> database inside your docker container. <br>"+load_img); //You can access the mysql database using <br><br>http://localhost/phpmyadmin<br>username: admin<br>password: mypass<br>
		$("#message-02").html("");	
		$("#headline-01").html("You are almost done…");	
		$("#headline-02").html("");
		finalize_database();		
        break;
    case 2:
		var input_text_box='Suggested database name is <input disabled="" type="text" id="create_database_input" value="'+selected_species+'" name="create_database_input" style="font-size: 20px;border:none;">';	
		var go_2_last='<br><button id="sp_in" onclick="gotolast(1)" style="font-size:16px;height: 40px;" type="button">go to next</button>';	
		$("#message-01").html(input_text_box);
		$("#message-02").html("If needed, please feel free to change the suggested database name.<br>"+go_2_last);
		$("#headline-01").html("You just selected "+selected_species_name);	
		$("#headline-02").html("");
        break;
	case 1:
        var downloadSpecies='<br><button  id="download_species" onclick="downloadTheSpecies(1)" style="font-size:16px;height: 40px;display:none" type="button">Download the selected species</button>';
        var downloadDump='<button id="download_dump" onclick="downloadTheSpecies(2)" style="font-size:16px;height: 40px;" type="button">My species is not in the list</button>';
		$("#message-01").html(select_text);	
		$("#message-02").html(downloadSpecies+"&nbsp;&nbsp;&nbsp;"+downloadDump);	
		$("#headline-01").html("Select species from the list to download");	
		$("#headline-02").html("");			
	}
	
}

var uniqueId;
/*Changing of species selection drodown*/ 
$('#datasetmenu').on('change', function(e) {
	selected_species=this.value;
    selected_species_name=this.options[this.selectedIndex].text;
	selected_species_1=this.value;
    selected_species_name_1=this.options[this.selectedIndex].text;    
    if(this.value==""){
        $('#download_species').hide();
    }else{
        $('#download_species').show();
    }
    uniqueId = Math.random().toString(36).substring(2)+(new Date()).getTime().toString(36);
    key=uniqueId=selected_species;
    if(selected_species==""){key="dump";}   
});


/*
Clcking the download button. This should download either correct database or the empty database from the server.
*/
function downloadTheSpecies(tmp_id){
   $(".loader-wrap").show();
   $("#headline-01").html("Downloading ...");
    $("#message-01").html("");
    $("#message-02").html("");

    $(".mmo-modal--tracking-intro").addClass( "mmo-state-02" ).removeClass( "mmo-state-01 mmo-state-03" );
    if (rainbowActivation == true) {
        rainbowFadeOutDown();
    }
    if(selected_species=="null" || selected_species=="" || tmp_id==2){key="dump";selected_species=key}   
    if(tmp_id==1){key=uniqueId;selected_species=selected_species_1;selected_species_name=selected_species_name_1};
    finalize_database();
}

var tmp_existence;
//Create directory based on key which is an unique id
function finalize_database(){
	var finalvarx= "key="+key;//this.value;
	$.ajax({
            type: "POST",
			async: true,
            url: service_url+"service/build_service.php",
            data: (finalvarx),
            complete: function (data) {
                tmp_existence=data.responseText;
                //if(data.responseText =="exists"){
                   $("#headline-01").html("Download completed");
                    $("#message-01").html("<div style='text-align:left;padding-left:24px;padding-right:24px;'>You can see the database and raw data files <a target='_blank' href='http://build.plantgenie.org/tmp/"+key+"'>here</a>. However, you won't be able to see any genomic data until you load data into the database. We need the following information to load data into the database.</div>");
                    $("#message-02").html("<form id='db_form'><p><label for='database'>Database:</label><input autocomplete='dbname' id='mdbname'  placeholder='MySQL database name: DBname' value='"+key+"' type='text'></p><p><label for='host'>Host:</label><input autocomplete='host' id='mhost' value='localhost' placeholder='MySQL host : localhost' type='text'></p><p><label for='username'>Username:</label><input value='root' autocomplete='username' id='musername' placeholder='MySQL username: root' type='text'></p><p><label for='password'>Password:</label><input value='root' autocomplete='password' id='mpassword'  placeholder='MySQL password : root' type='text'></p></form><button id='parse_to_local' onclick='loadintoLocalDB(\""+tmp_existence+"\")' style='font-size:16px;height: 40px;' type='button'>Load data into the Database</button>");
                    $(".loader-wrap").hide();
                /*}else{
                    $("#headline-01").html("Download completed");
                    $("#message-01").html("<div style='text-align:left;padding-left:24px;padding-right:24px;'>You can see the database and raw data files <a target='_blank' href='http://build.plantgenie.org/tmp/"+key+"'>here</a>. However, you won't be able to see any genomic data until you load data into the database. We need the following information to load data into the database.</div>");
                    $("#message-02").html("<form><input autocomplete='dbname' id='mdbname'  placeholder='MySQL database name: DBname' value='"+key+"' type='text'><br><input autocomplete='host' id='mhost'  placeholder='MySQL host : localhost' type='text'><br><input autocomplete='username' id='musername' placeholder='MySQL username: root' type='text'> <br> <input autocomplete='password' id='mpassword'  placeholder='MySQL password : root' type='text'> <br> <button id='parse_to_local' onclick='loadintoLocalDB()' style='font-size:16px;height: 40px;' type='button'>Load data into the Database</button>");
                    $(".loader-wrap").hide();
                    create_files();
                    $(".loader-wrap").hide();
                }*/
			}
			
		});
}

var mhost;
var musername;
var mpasswd;
var mdbname;
/*check database connection before it loaded into the database and create a database*/ 
function loadintoLocalDB(existence){
    $(".loader-wrap").show();
   mhost= $('#mhost').val();
   musername= $('#musername').val();
   mpasswd= $('#mpassword').val();
   mdbname= $('#mdbname').val();
   //mdatabase=key;
   final_var= "host="+mhost+"&username="+musername+"&password="+mpasswd+"&database="+mdbname+"&operation=check";		
     $.ajax({
     url: "plugins/home/service/check_connection.php",
      type: "POST",
       data: (final_var),
       success: function (data) {
           //console.log(typeof(JSON.parse(data)))
           if(JSON.parse(data)=="success"){
            $("#headline-01").html("Connection was successful");
            $("#message-01").html("<div style='text-align:left;padding-left:24px;padding-right:24px;'>Connection was successfully established. <strong>" +mdbname+"</strong> database was created with the right user permissions.<div>");
            //if(existence!="exists"){
             //   create_files();
            //}else{
                download_file();
            //}
            }else{
            $("#headline-01").html("<font color='red'>Connection failed</font>");  
            $("#message-01").html("<div style='text-align:left;padding-left:24px;padding-right:24px;'>Unable to connect to MySQL server. Please provide the correct host, username or password to create a database."+JSON.parse(data)+"<div>"); 
            $(".loader-wrap").hide();  
        }
        },
       error: function(request, error) {
         console.log(request, error);
       }
     });
}

/**Download files whenits success*/
function download_file(){
    var finalvarx= "key="+key+"&file_name="+key+".sql&host="+mhost+"&username="+musername+"&password="+mpasswd+"&database="+mdbname;
	$.ajax({
		type: "POST",
		url: "plugins/home/service/index.php",
        data: (finalvarx),
        dataType: 'json',   
		complete: function (data) {
            console.log(data);
            $(".loader-wrap").hide();
            $(".mmo-modal--tracking-intro").addClass( "mmo-state-03" ).removeClass( "mmo-state-02" );
            rainbowFadeInUp();
            $("#headline-01").html("Successfully loaded into the database");
            $("#message-01").html("<div style='text-align:left;padding-left:24px;padding-right:24px;'>"+mdbname+" database has been loaded with "+key+" data. Now we need to configure the settings file(plugins/settings.php) file like the following.</div>");
            $("#message-02").html("<div style='text-align:left;padding-left:24px;padding-right:24px;'></div>");

            //$("#db_name_1").html(file_name.split(".")[0].trim());
            //$("#db_name_2").html(file_name.split(".")[0].trim());
            //$("#species_name").html(file_name.split(".")[0].trim());
           // $("#post_information").show();
           // $("#build_frame").hide();
           
		}
	});
}

//$("#headline-02").html("Downloads");
//$("#message-02").html("Raw data is available in <a target='_blank' href='http://build.plantgenie.org/tmp/"+key+"'>this URL</a><br>");
//$("#message-02").html("Raw data is available in <a target='_blank' href='http://build.plantgenie.org/tmp/"+key+"'>this URL</a><br>You can download the database <a target='_blank' href='http://build.plantgenie.org/tmp/"+key+"'>here</a>");
 
var genie_tables = ['transcript_info', 'gene_info','gene_go','gene_pfam','gene_kegg']; 
//create files after creating a folder
function create_files(){
var tmparr=[];	
 for (var i in genie_tables) {
    create_a_database_callback(genie_tables[i], function(k,e,d) {
				//console.log(k,e,d)
				tmparr.push(e);
					if(tmparr.length==5){
						//$("#transcript_info_load").hide();
						create_a_database();
						}
	});
}
}

//callback iterating for-loop of table names
function create_a_database_callback(table, one_table_success) {
    var finalvarx= table+"=true&source="+selected_species+"&dataset="+key;		
     $.ajax({
     url: service_url+"service/build_service.php",
      type: "POST",
       data: (finalvarx),
       success: one_table_success,
       error: function(request, error) {
         console.log(request, error);
       }
     });
   }
   
   
   //create a database using key
   function create_a_database(){
   var finalvarx= "database_name="+key;
       $.ajax({
           type: "POST",
           url: service_url+"service/build_database.php",
           data: (finalvarx),
           complete: function (data) {
               console.log("created db")
               for(var i=0;i<genie_tables.length;i++){
                   load_databases(genie_tables[i]);	
               }
               
           }
           
       });
   }
   
   //Load databases
   function load_databases(ele){
       
       var finalvarx= "table_name="+ele+"&source="+key+"&folder="+key;
       $.ajax({
           type: "POST",
           url: service_url+"service/build_database.php",
           data: (finalvarx),
           complete: function (data) {
               if(ele=="transcript_info"){
                   update_gene_i();
               }
           }
       });
   }
   
   function update_gene_i(){
       var finalvarx= "table_name=transcript_info&source="+key+"&folder="+key;
       $.ajax({
           type: "POST",
           url: service_url+"service/build_update_i.php",
           data: (finalvarx),
           complete: function (data) {
               dump_database();
           }
       });
   }
   
   function dump_database(){
       var finalvarx= "key="+key+"&table_name="+key;
       $.ajax({
           type: "POST",
           url: service_url+"service/build_dump.php",
           data: (finalvarx),
           complete: function (data) {
               //$("#transcript_info_load").hide();
               var load_img='<img width="40px" id="transcript_info_load" src="mif/load.gif" />';
               $("#headline-01").html("Congratulations! All done ✓");
               $("#message-01").html("<font color='red'>"+selected_species_name+"</font> data has been loaded into <font color='red'>"+new_db_name+"</font> database inside your docker container. You can access the database in <a target='_blank' href='http://localhost/phpmyadmin/'>this URL</a><br><br>username: admin <br>password: mypass<br>")
               $("#headline-02").html("Downloads");
               $("#message-02").html("Raw data and the database are available in <a target='_blank' href='http://build.plantgenie.org/tmp/"+key+"'>this URL</a><br>");
               download_file();
           }
       });
       
   }
   





// Left & right button navigation
/*$( "#btn-left" ).click( function() {
  if ( $( ".mmo-modal--tracking-intro" ).hasClass( "mmo-state-02" ) ) {
    $(".mmo-modal--tracking-intro").addClass( "mmo-state-01" ).removeClass( "mmo-state-02" );
	  rainbowHide();
	 
  }
  else if ( $( ".mmo-modal--tracking-intro" ).hasClass( "mmo-state-03" ) ) {
    $(".mmo-modal--tracking-intro").addClass( "mmo-state-02" ).removeClass( "mmo-state-03" );
	  rainbowFadeOutDown();
	 
  }
 
});


$( "#btn-right" ).click( function() {
  if ( $( ".mmo-modal--tracking-intro" ).hasClass( "mmo-state-01" ) ) {
    $(".mmo-modal--tracking-intro").addClass( "mmo-state-02" ).removeClass( "mmo-state-01" );
	  rainbowHide();
	 
  }
  else if ( $( ".mmo-modal--tracking-intro" ).hasClass( "mmo-state-02" ) ) {
    $(".mmo-modal--tracking-intro").addClass( "mmo-state-03" ).removeClass( "mmo-state-02" );
	  rainbowFadeInUp();
	  datasetselector(8)
  }
 
});



function gotolast(t){
  $(".mmo-modal--tracking-intro").addClass( "mmo-state-03" ).removeClass( "mmo-state-01 mmo-state-02" );
	rainbowFadeInUp();
	if(t==2){
		datasetselector(5);
	}else{
		datasetselector(3)
	}
	
	rainbowActivation = true;	
	
}

*/



