/**ADMIN TABS**/
var tabs = $("#tab-container");
$("#tab-container").easytabs({
  animationSpeed: "fast",
  //updateHash: false,
});

tabs.easytabs({ animate: false });
tabs.bind("easytabs:before", function (e, clicked) {
  // $("#main_editor").val(editor_content);
  if (clicked.parent().hasClass("disabled")) {
    return false;
  }
});
$(".prevent-default").click(function (e) {
  e.preventDefault();
  return false;
});


function enable_all() {
  $("#clone_div").show();
  var tabs = $("#tab-container");
  disable_easytabs(tabs, []);
  disable_easytabs(tabs, [4,5]);
}

disable_easytabs(tabs, [4,5]);
//Disable tabs on_disable_b_and_c_clicked();
function on_disable_b_and_c_clicked() {
  $("#clone_div").hide();
  var tabs = $("#tab-container");
  disable_easytabs(tabs, [3, 4, 5]);
  return false;
}

function disable_easytabs(tabs, indexes) {
  var lis = tabs.children("ul").children();
  var index = 0;
  lis.each(function () {
    var li = $(this);
    var a = li.children("a");
    var disabled = $.inArray(index, indexes) != -1;
    if (disabled) {
      li.addClass("disabled");
    } else {
      li.removeClass("disabled");
    }
    index++;
  });
}

tabs.bind('easytabs:after', function(e, clicked, targetPanel, data) {
  tab_opration(clicked[0].outerText)
});

// Realoading admin page will fire this function
tab_opration($("#tab-container .tab.active")[0].innerText);

// Tab change operation
function tab_opration(str){
    switch(str) {
      case "Edit page":
       fill_input_text();
        break;
      case "Site settings":
        // code block
        break;  
      case "Database settings":
        read_ini_file();
        //db_operation("db_name", "check_connection");
        break;
      case "Annotation":
       // db_operation("db_name", "check");
        check_files();
        break;  
      case "Expression":
        check_expression_files();
      // code block
        break; 
      case "Summary":
      // code block
        break;                       
      default:
      // code block
    }
}

// Refresh if there in no content added in home page
function fill_input_text(){
  if($("#tab-container .tab.active")[0].innerText =="Edit page"){
    if(CKEDITOR.instances.editor!=undefined){
    location.reload();
    }
  }
}

//Fill input boxes on admin page
function read_ini_file() {
  var finalvarx = "action=read_settings_ini";
  $.ajax({
    type: "POST",
    url: "plugins/home/service/db_settings.php",
    data: (finalvarx),
    dataType: 'json',
    success: function (data) {
      passStatus(data.status);
      $("#mhost").val(JSON.parse(data.name).host);
      $("#musername").val(JSON.parse(data.name).user); 
      $("#mpassword").val(JSON.parse(data.name).pass);
      $("#mdbname").val(JSON.parse(data.name).database);
    }
    });
}

// Trigger changes to admin input controls
$("#db_form input").on("input", function(e) {
  var input = $(this);
  var val = input.val();
  if (input.data("lastval") != val) {
    input.data("lastval", val);
    var mhost = $('#mhost').val();
    var musername = $('#musername').val();
    var mpasswd = $('#mpassword').val();
    var mdbname = $('#mdbname').val();
    var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=save_ini_file";
    $.ajax({
        type: "POST",
        url: "plugins/home/service/db_settings.php",
        data: (finalvarx),
        dataType: 'json',
        success: function (data) {
          passStatus(data.status);
        }
    });
  }
});

// Pass status to the visual elements
function passStatus(status){
  if(status=="error"){
    //Connection failed Wrong username or Password
    $("#create_db").hide();
    $("#drop_db").hide();
    $("#db_span").html("<font color='red'> &#9432; Wrong username or password. Please type in correct username and password. </font>");
    $("#clone_div").hide(); 
 }else{
   //Connection successful
   if(status=="success"){
     $("#drop_db").show();
     $("#create_db").hide();
     $("#db_span").html(" <font color='green'> &#9432;  Database created. You can click below phpMyAdmin link to see more details.</font>");
     $("#clone_div").hide(); 
   }else{
     $("#create_db").hide();
     $("#drop_db").hide();
     $("#db_span").html(" <font color='orange'> &#9432; Database does not exist, but you can create a new database.</font>");
     $("#clone_div").show(); 
   }
 }
}

$("#drop_db").click(function () {
  db_operation("drop_database", "drop");
});

$("#create_db").click(function () {
  db_operation("create_database", "dump");
});

$("#create_db_arabidopsis").click(function () {
  db_operation("create_database", "artha");
 // download_indices("create_database", "dump");
});

// Cloning 
function clone_genome(t) {
  if( t.id=="artha" || t.id=="eugra"){
    db_operation("create_database", t.id);
  }else{
    alert("This button will allow you to clone the existing "+t.id+" database into your database in the future","clone download");
  }
 };

//Check database
function db_operation(action, name) {
  if(action!="clone_database"){on_disable_b_and_c_clicked();}
  $(".loader-wrap").show();
    mhost = $('#mhost').val();
    musername = $('#musername').val();
    mpasswd = $('#mpassword').val();
    mdbname = $('#mdbname').val();
    var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=" + action + "&name=" + name;
    $.ajax({
        type: "POST",
        url: "plugins/home/service/db_settings.php",
        data: (finalvarx),
        dataType: 'json',
        success: function (data) {
          console.log(data)
          $(".loader-wrap").hide();
          read_ini_file();
        },
        error: function (data) { 
           if(data.status!=""){
            on_disable_b_and_c_clicked();}
        }
    });
}


//Download indices
function download_indices(action, name) {
  mhost = $('#mhost').val();
  musername = $('#musername').val();
  mpasswd = $('#mpassword').val();
  mdbname = $('#mdbname').val();
  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=" + action + "&name=" + name;
  $.ajax({
      type: "POST",
      url: "plugins/home/service/download_indices.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
          toastr.options = { "closeButton": false, "debug": false, "positionClass": "toast-top-right", "onclick": null, "showDuration": "10000", "hideDuration": "1000", "timeOut": "40000", "extendedTimeOut": "0", "showEasing": "linear", "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
          console.log(data)
          if (data > 10) {
              toastr.success("download and indexed fasta files", "Success");
          } else {
              toastr.error("remote server failed", "Failure");
          }
      }
  });
}



/** ANNOTATION **/
// Check files are in the data folder
function check_files() {
  mhost = $('#mhost').val();
  musername = $('#musername').val();
  mpasswd = $('#mpassword').val();
  mdbname = $('#mdbname').val();
  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=check_files" ;
  $("#files_waiting").show();
  $.ajax({
      type: "POST",
      url: "plugins/home/service/annotation.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
          toastr.options = { "closeButton": false, "debug": false, "positionClass": "toast-top-right", "onclick": null, "showDuration": "10000", "hideDuration": "1000", "timeOut": "40000", "extendedTimeOut": "0", "showEasing": "linear", "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
          if(data.length==0){
            $("#check_files_span").html("Now you have all the required files in the data directory");
            if($("#tab-container .tab.active")[0].innerText =="Annotation"){$("#files_checkbox").prop("checked", true);
              $("#files_waiting").hide();
            }
      
          }else{   
              $("#check_files_span").show();
              if(data!=null){
             $("#missing_files").html((JSON.stringify(data)).split(','));}
              toastr.warning("There are some missing files, please upload them to data directory", "Missing files");
          }
      }
  });
}

// Generate suitable files in correct formats
function generate_files(){
  $("#prepare_waiting").show();
  mhost = $('#mhost').val();
  musername = $('#musername').val();
  mpasswd = $('#mpassword').val();
  mdbname = $('#mdbname').val();
  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=prepare_files" ;
  $.ajax({
      type: "POST",
      url: "plugins/home/service/annotation.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
        $("#prepare_waiting").hide();
          if($("#tab-container .tab.active")[0].innerText =="Annotation"){$("#prepare_checkbox").prop("checked", true);}
      }
  });  
  }

// Load files into the database
  function load_database(){
    $("#load_waiting").show();
    mhost = $('#mhost').val();
    musername = $('#musername').val();
    mpasswd = $('#mpassword').val();
    mdbname = $('#mdbname').val();
    var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=load_files" ;
    $.ajax({
        type: "POST",
        url: "plugins/home/service/annotation.php",
        data: (finalvarx),
        dataType: 'json',
        success: function (data) {
          $("#load_waiting").hide();
            if($("#tab-container .tab.active")[0].innerText =="Annotation"){$("#load_checkbox").prop("checked", true);}
        },
        complete: function(xhr, textStatus) {
          
          $("#load_waiting").hide();
      } 
    });  
    }

// Refresh if there in no content added in home page
function fill_input_text(){
  if($("#tab-container .tab.active")[0].innerText =="Edit page"){
    if(CKEDITOR.instances.editor!=undefined){
    location.reload();
    }
  }
}

// Generate fatsa indices for BLAST
function generate_fasta_indices(){
  $("#fasta_waiting").show();
  var finalvarx = "action=generate_indices" ;
  $.ajax({
      type: "POST",
      url: "plugins/home/service/annotation.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
        $("#fasta_waiting").hide();
      },
      complete: function(xhr, textStatus) {
        $("#fasta_waiting").hide();
    } 
  });  
  }

// Update gene i in transcript_info table
function annotation_update_gene_i(){
  $("#update_gene_i_waiting").show();
  mhost = $('#mhost').val();
  musername = $('#musername').val();
  mpasswd = $('#mpassword').val();
  mdbname = $('#mdbname').val(); 

  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=update_gene_i" ; 
  $.ajax({
      type: "POST",
      url: "plugins/home/service/annotation.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
        $("#update_gene_i_waiting").hide();
      },
      complete: function(xhr, textStatus) {
        $("#update_gene_i_waiting").hide();
    } 
  }); 
}

// Update gene and transcript description
function annotation_update_description(){
  $("#update_description_waiting").show();
  mhost = $('#mhost').val();
  musername = $('#musername').val();
  mpasswd = $('#mpassword').val();
  mdbname = $('#mdbname').val(); 

  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=update_description" ; 
  $.ajax({
      type: "POST",
      url: "plugins/home/service/annotation.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
        $("#update_description_waiting").hide();
      },
      complete: function(xhr, textStatus) {
        $("#update_description_waiting").hide();
    } 
  }); 
}

// Load extra annotation KEGG/Pfam/GO
function annotation_update_extra_annotation(){
  $("#update_extra_annotation_waiting").show();
  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=load_extra_annotations" ; 
  $.ajax({
      type: "POST",
      url: "plugins/home/service/annotation.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
        $("#update_extra_annotation_waiting").hide();
      },
      complete: function(xhr, textStatus) {
        $("#update_extra_annotation_waiting").hide();
    } 
  }); 
}

// Load BLAST indices
function annotation_update_best_blast(){
  $("#update_best_blast_waiting").show();
  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=load_best_blast" ; 
  $.ajax({
      type: "POST",
      url: "plugins/home/service/annotation.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
        $("#update_best_blast_waiting").hide();
      },
      complete: function(xhr, textStatus) {
        $("#update_best_blast_waiting").hide();
    } 
  }); 
}



/** EXPRESSION **/
// Check if the experiment and expression files are exist
function check_expression_files() { 
  mhost = $('#mhost').val();
  musername = $('#musername').val();
  mpasswd = $('#mpassword').val();
  mdbname = $('#mdbname').val();
  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=check_files" ;
  $("#check_experiment_waiting").show();
  $.ajax({
      type: "POST",
      url: "plugins/home/service/expression.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
          if(data.length==0){
            //$("#check_files_span").html("Now you have all the required files in the data directory");
            $("#expression_error").hide();
            if($("#tab-container .tab.active")[0].innerText =="Expression"){$("#check_experiment_checkbox").prop("checked", true);
              $("#check_experiment_waiting").hide();
            }
          }else{
            
              $("#expression_error").show();
             $("#expression_error").html("Warning! There are some missing files "+JSON.stringify(data)+ ". Please upload them into the data directory.");
             // toastr.warning("There are some missing files, please upload them to data directory", "Missing files");
          }
      }
  });
}

// Load files into the database
function load_expression_table(tmp_name){
  $("#expression_info").hide()
  $("#"+tmp_name+"_waiting").show();
  mhost = $('#mhost').val();
  musername = $('#musername').val();
  mpasswd = $('#mpassword').val();
  mdbname = $('#mdbname').val();
  var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname + "&action=load_files&name="+tmp_name ;
  $.ajax({
      type: "POST",
      url: "plugins/home/service/expression.php",
      data: (finalvarx),
      dataType: 'json',
      success: function (data) {
        $("#"+tmp_name+"_waiting").hide();
        if(tmp_name=="expression"){$("#expression_info").show();}
          if($("#tab-container .tab.active")[0].innerText =="Expression"){$("#load_"+tmp_name+"_checkbox").prop("checked", true); }
      },
      complete: function(xhr, textStatus) {
        if($("#tab-container .tab.active")[0].innerText =="Expression"){$("#load_"+tmp_name+"_checkbox").prop("checked", true); }
        if(tmp_name=="expression"){$("#expression_info").show();}
        $("#"+tmp_name+"_waiting").hide();
    } 
  });  
  }

// Help
function go_to_help(t){
  console.log(t)
}


$("#myadmin_links").click(function () {
  window.open("/phpmyadmin/db_structure.php?db=" + $('#mdbname').val(), '_blank');
});
$("#myadmin_links_annotation").click(function () {
window.open("/phpmyadmin/db_structure.php?db=" + $('#mdbname').val(), '_blank');
});
$("#myadmin_links_expression").click(function () {
window.open( "/phpmyadmin/db_structure.php?db=" + $('#mdbname').val(), '_blank');
});