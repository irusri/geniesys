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
}

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
        db_operation("db_name", "check");
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

/** DATABASE **/
$("#create_db").click(function () {
    db_operation("create_database", "dump");
});
$("#create_db_arabidopsis").click(function () {
    db_operation("create_database", "artha");
    download_indices("create_database", "dump");
});
$("#drop_db").click(function () {
    db_operation("drop_database", "drop");
});

// Cloning 
function clone_genome(t) {
    db_operation("clone_database", t.id);
 };

 $("#myadmin_links").click(function () {
     window.open("http://" + $('#mhost').val() + "/phpmyadmin/db_structure.php?db=" + $('#mdbname').val(), '_blank');
 });
 $("#myadmin_links_annotation").click(function () {
  window.open("http://" + $('#mhost').val() + "/phpmyadmin/db_structure.php?db=" + $('#mdbname').val(), '_blank');
});
$("#myadmin_links_expression").click(function () {
  window.open("http://" + $('#mhost').val() + "/phpmyadmin/db_structure.php?db=" + $('#mdbname').val(), '_blank');
});

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
          $(".loader-wrap").hide();
//            toastr.options = { "closeButton": false, "debug": false, "positionClass": "toast-top-right", "onclick": null, "showDuration": "10000", "hideDuration": "1000", "timeOut": "40000", "extendedTimeOut": "0", "showEasing": "linear", "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
             if (data.status == "success") {
                 toastr.success(data.message, "Success");
                 if(data.name!=""){
                 enable_all();
                 if(name=="check" && $("#tab-container .tab.active")[0].innerText =="Annotation"){$("#database_checkbox").prop("checked", true);}
                }
             } else {
                 toastr.error(data.message, "Failure");
                 on_disable_b_and_c_clicked();
                 $("#database_checkbox").prop("checked", false)
             }
             if (action == "db_name") {
                 $("#mdbname").val(data.name);
             }
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
              console.log(data)
              $("#check_files_span").show();
             $("#missing_files").html(data.join(','));
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
