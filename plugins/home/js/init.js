/**ADMIN TABS**/
var tabs = $("#tab-container");
$("#tab-container").easytabs({
  animationSpeed: "fast",
  // updateHash: false,
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

 //db_operation("db_name", "check");
 db_operation("db_name", "check");

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
          
            toastr.options = { "closeButton": false, "debug": false, "positionClass": "toast-top-right", "onclick": null, "showDuration": "10000", "hideDuration": "1000", "timeOut": "40000", "extendedTimeOut": "0", "showEasing": "linear", "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
             if (data.status == "success") {
                 toastr.success(data.message, "Success");
                 if(data.name!=""){
                    
                 enable_all();}
             } else {
                 toastr.error(data.message, "Failure");
                 on_disable_b_and_c_clicked();
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