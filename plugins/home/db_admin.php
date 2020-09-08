<?php?><h3>Loading novel genome to GenIE-Sys database. Follow the steps one at a time.</h3>
<span style="overflow: hidden;position: absolute;top:30px" id="error_msg"></span>
<form  id="db_form">
   <p><label for="host">Host:</label><input autocomplete="host" id="mhost" value="localhost" placeholder="MySQL host : localhost" type="text"/> &#9432; This is the default host </p>
   <p><label for="username">Username:</label><input value="root" autocomplete="username" id="musername" placeholder="MySQL username: root" type="text"/> &#9432; This is the default username </p>
   <p><label for="password">Password:</label><input value="root" autocomplete="password" id="mpassword" placeholder="MySQL password : root" type="text"/> &#9432; This is the default password </p>
   <p><label for="database">Database:</label><input id="mdbname" placeholder="Type in new database name" value="" type="text"/> &#9432; Current database name should be typed in here</p>
</form>
<br>
<!--<h3> There is a database name stated in the setting file. Howevere that database does not exsist in MySQL server. Do you want to create a new database?</h3>-->
<button class="upbtn"  id="create_db">create a fresh database</button>
<button class="upbtn"  id="create_db_arabidopsis">create a database with <i>Arabidopsis thaliana</i></button>
<button id="drop_db" class="upbtn"  style="background:red;color:white">Delete current database</button>&nbsp; &#9432;
</br></br>
<table id="upload_table" style="width:100%">
   <tr style="font-weight:bold" align="left">
      <th>Upload GFF3</th>
      <th>Upload FASTA</th>
      <th>Upload Annotation</th>
   </tr>
   <tr>
      <td height="40">
           <!--Progress bar html element-->
               <progress id = "progress_upidgff3" value = "0" max = "100"> </progress> <span id = "mySpan_upidgff3"> 0% </span><button  class="upbtn"  id = "upidgff3"> Upload GFF3  </button> &nbsp; &#9432;   <br/>
      </td>
      <td><input placeholder="Path to BLAST directory"  style="width:60%" value="" type="text" id = "upid_fp_path">  </input>&nbsp; &#9432;  </td>
      <td><progress id = "progress_upid_a" value = "0" max = "100"> </progress> <span id = "mySpan_upid_a"> 0% </span><button  class="upbtn" id = "upid_a"> Upload annotation </button>&nbsp; &#9432; </td>
   </tr>
   <tr>
       <td height="40"></td>
       <td><progress id = "progress_upid_fg" value = "0" max = "100"> </progress> <span id = "mySpan_upid_fg"> 0% </span><button class="upbtn" id = "upid_fg"> Upload genome FASTA </button>&nbsp; &#9432;</td>
       <td></td>
   </tr>
   <tr>
       <td height="40"></td>
       <td><progress id = "progress_upid_fp" value = "0" max = "100"> </progress> <span id = "mySpan_upid_fp"> 0% </span><button class="upbtn" id = "upid_fp"> Upload genome FASTA </button>&nbsp; &#9432;</td>
       <td></td>
   </tr>   

   <tr>
       <td height="40"></td>
       <td><progress id = "progress_upid_ft" value = "0" max = "100"> </progress> <span id = "mySpan_upid_ft"> 0% </span><button class="upbtn" id = "upid_ft"> Upload transcript FASTA </button>&nbsp; &#9432;</td>
       <td></td>
   </tr>   

 

</table>
<br><br>
<a target="_blank" id="myadmin_links" style="color:blue;font-weight:bold;float:right">External link to phpMyAdmin page >></a><br>
<script src = "plugins/home/js/genieuc.js"> </script> 
<script type="application/javascript">
var mhost;
var musername;
var mpasswd;
var mdbname;

$("#create_db").click(function() {
    db_operation("create_database","dump");
});

$("#create_db_arabidopsis").click(function() {
    db_operation("create_database","artha");
});

$("#drop_db").click(function() {
    db_operation("drop_database","drop");
});

$("#myadmin_links").click(function() {
  window.open("http://"+$('#mhost').val()+"/phpMyAdmin/db_structure.php?db="+$('#mdbname').val(), '_blank');
});

db_operation("db_name","check");

//Check database
function db_operation(action,name){
    mhost= $('#mhost').val();
    musername= $('#musername').val();
    mpasswd= $('#mpassword').val();
    mdbname= $('#mdbname').val();
    var finalvarx= "host="+mhost+"&username="+musername+"&password="+mpasswd+"&database="+mdbname+"&action="+action+"&name="+name;	
   $.ajax({
       type: "POST",
       url: "plugins/home/service/db_settings.php",
       data: (finalvarx),
       dataType: 'json',   
       success: function (data) {
        toastr.options = {"closeButton": false,"debug": false,"positionClass": "toast-top-right","onclick": null,"showDuration": "10000","hideDuration": "1000","timeOut": "40000","extendedTimeOut": "0","showEasing": "linear","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"}
        if(data.status=="success"){
          toastr.success(data.message,"Success");
        }else{
          toastr.error(data.message,"Failure");
          }
          if(action=="db_name"){$("#mdbname").val(data.name);}
        }
   });
}

//Upload progress component
 function Progress(value,domname) {
    var myProgress = document.getElementById("progress_"+domname);
    var mySpan = document.getElementById("mySpan_"+domname);
    mySpan.innerText = value + "%";
    myProgress.value = value;
}

var upidgff3 = new genieuc({
id: "upidgff3", // Binding id
    url: "plugins/home/service/upload_files.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff", // Limit upload type, empty without limit
    shardsize: "0.5", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "20", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {"version": "genieuc"}, // Additional file header
    // apped_data: {}, //Additional data for each upload
    // Define error messages
    // Error message
    error: (msg) => {
      alert(msg);
    },      
    // Initialization event                
    start: (that) => {
        Progress(0,that.id)
    },
    // Upload progress event
    progress: (num, other,that) => {
        Progress(num, that.id);
    },
    // The upload success callback, the callback will cycle according to the slice, to terminate the upload cycle, you must return false, and always return true in the case of success;
    success: (res) => {
        let data = res ? eval('(' + res + ')') : '';
        if (data.status == 2) {
            toastr.success(data.message,"Success");
        }
        // If there is no error in the interface, it must return true to not terminate the upload cycle
        return true;
    }
});

var upid_a = new genieuc({
id: "upid_a", // Binding id
    url: "plugins/home/service/upload_files.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff", // Limit upload type, empty without limit
    shardsize: "0.5", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "20", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {"version": "genieuc"}, // Additional file header
    // apped_data: {}, //Additional data for each upload
    // Define error messages


    errormsg: {
        1000: "Upload id not found",
        1001: "Type does not allow upload",
        1002: "Upload file is too small",
        1003: "Upload file is too large",
        1004: "Upload request timed out"
    },



    // Error message
    error: (msg) => {
      alert(msg);
    },      

    // Initialization event                
    start: (that) => {
        Progress(0,that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other,that) => {
        Progress(num, that.id);
        console.log('Upload progress' + num);
        console.log("Upload type" + other.type);
        console.log("Uploaded" + other.current);
        console.log("Remaining uploads" + other.surplus);
        console.log("Elapsed time" + other.usetime);
        console.log("estimated time" + other.totaltime);
    },

    // The upload success callback, the callback will cycle according to the slice, to terminate the upload cycle, you must return false, and always return true in the case of success;
    success: (res) => {
        let data = res ? eval('(' + res + ')') : '';
        let url = data.url + "?" + Math.random();
        let file_index = data.file_index ? parseInt(data.file_index) : 1;
        if (data.status == 2) {
            $('#pic').attr("src", url);
            $('#pic').show();
            alert('upload completed');
        }
        // If there is no error in the interface, it must return true to not terminate the upload cycle
        return true;
    }
});

var upid_fg = new genieuc({
id: "upid_fg", // Binding id
    url: "plugins/home/service/upload_files.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff", // Limit upload type, empty without limit
    shardsize: "0.5", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "20", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {"version": "genieuc"}, // Additional file header
    // apped_data: {}, //Additional data for each upload
    // Define error messages


    errormsg: {
        1000: "Upload id not found",
        1001: "Type does not allow upload",
        1002: "Upload file is too small",
        1003: "Upload file is too large",
        1004: "Upload request timed out"
    },



    // Error message
    error: (msg) => {
      alert(msg);
    },      

    // Initialization event                
    start: (that) => {
        Progress(0,that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other,that) => {
        Progress(num, that.id);
        console.log('Upload progress' + num);
        console.log("Upload type" + other.type);
        console.log("Uploaded" + other.current);
        console.log("Remaining uploads" + other.surplus);
        console.log("Elapsed time" + other.usetime);
        console.log("estimated time" + other.totaltime);
    },

    // The upload success callback, the callback will cycle according to the slice, to terminate the upload cycle, you must return false, and always return true in the case of success;
    success: (res) => {
        let data = res ? eval('(' + res + ')') : '';
        let url = data.url + "?" + Math.random();
        let file_index = data.file_index ? parseInt(data.file_index) : 1;
        if (data.status == 2) {
            $('#pic').attr("src", url);
            $('#pic').show();
            alert('upload completed');
        }
        // If there is no error in the interface, it must return true to not terminate the upload cycle
        return true;
    }
});

var upid_fp = new genieuc({
id: "upid_fp", // Binding id
    url: "plugins/home/service/upload_files.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff", // Limit upload type, empty without limit
    shardsize: "0.5", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "20", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {"version": "genieuc"}, // Additional file header
    // apped_data: {}, //Additional data for each upload
    // Define error messages


    errormsg: {
        1000: "Upload id not found",
        1001: "Type does not allow upload",
        1002: "Upload file is too small",
        1003: "Upload file is too large",
        1004: "Upload request timed out"
    },



    // Error message
    error: (msg) => {
      alert(msg);
    },      

    // Initialization event                
    start: (that) => {
        Progress(0,that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other,that) => {
        Progress(num, that.id);
        console.log('Upload progress' + num);
        console.log("Upload type" + other.type);
        console.log("Uploaded" + other.current);
        console.log("Remaining uploads" + other.surplus);
        console.log("Elapsed time" + other.usetime);
        console.log("estimated time" + other.totaltime);
    },

    // The upload success callback, the callback will cycle according to the slice, to terminate the upload cycle, you must return false, and always return true in the case of success;
    success: (res) => {
        let data = res ? eval('(' + res + ')') : '';
        let url = data.url + "?" + Math.random();
        let file_index = data.file_index ? parseInt(data.file_index) : 1;
        if (data.status == 2) {
            $('#pic').attr("src", url);
            $('#pic').show();
            alert('upload completed');
        }
        // If there is no error in the interface, it must return true to not terminate the upload cycle
        return true;
    }
});

var upid_ft = new genieuc({
id: "upid_ft", // Binding id
    url: "plugins/home/service/upload_files.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff", // Limit upload type, empty without limit
    shardsize: "0.5", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "20", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {"version": "genieuc"}, // Additional file header
    // apped_data: {}, //Additional data for each upload
    // Define error messages


    errormsg: {
        1000: "Upload id not found",
        1001: "Type does not allow upload",
        1002: "Upload file is too small",
        1003: "Upload file is too large",
        1004: "Upload request timed out"
    },



    // Error message
    error: (msg) => {
      alert(msg);
    },      

    // Initialization event                
    start: (that) => {
        Progress(0,that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other,that) => {
        Progress(num, that.id);
        console.log('Upload progress' + num);
        console.log("Upload type" + other.type);
        console.log("Uploaded" + other.current);
        console.log("Remaining uploads" + other.surplus);
        console.log("Elapsed time" + other.usetime);
        console.log("estimated time" + other.totaltime);
    },

    // The upload success callback, the callback will cycle according to the slice, to terminate the upload cycle, you must return false, and always return true in the case of success;
    success: (res) => {
        let data = res ? eval('(' + res + ')') : '';
        let url = data.url + "?" + Math.random();
        let file_index = data.file_index ? parseInt(data.file_index) : 1;
        if (data.status == 2) {
            $('#pic').attr("src", url);
            $('#pic').show();
            alert('upload completed');
        }
        // If there is no error in the interface, it must return true to not terminate the upload cycle
        return true;
    }
});

 

</script>

