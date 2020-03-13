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
               <progress id = "myProgress" value = "0" max = "100"> </progress> <span id = "mySpan"> 0% </span><label class="upbtn" id = "upid"> Upload GFF3  </label> &nbsp; &#9432;   <br/>
      </td>
      <td><progress id = "myProgress_fp" value = "0" max = "100"> </progress> <span id = "mySpan"> 0% </span><label class="upbtn" id = "upid_fp"> Upload genome FASTA </label>&nbsp; &#9432;  </td>
      <td><progress id = "myProgress_a" value = "0" max = "100"> </progress> <span id = "mySpan"> 0% </span><label class="upbtn" id = "upid_a"> Upload annotation </label>&nbsp; &#9432; </td>
   </tr>
   <tr>
       <td height="40"></td>
       <td><progress id = "myProgress_ft" value = "0" max = "100"> </progress> <span id = "mySpan"> 0% </span><label class="upbtn" id = "upid_ft"> Upload transcript FASTA </label>&nbsp; &#9432;</td>
       <td></td>
   </tr>
   <tr>
       <td height="40"></td>
       <td><progress id = "myProgress_ft" value = "0" max = "100"> </progress> <span id = "mySpan"> 0% </span><label class="upbtn" id = "upid_ft"> Upload protein FASTA </label>&nbsp; &#9432;</td>
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
 function Progress(value) {
    var myProgress = document.getElementById("myProgress");
    var mySpan = document.getElementById("mySpan");
    mySpan.innerText = value + "%";
    myProgress.value = value;
}
$.genieuc({
    upId: 'upid', // upload the id of the dom
    upShardSize: '2', // Slice size, (maximum value of a single upload) unit M, default 2M
    upMaxSize: '2000', // upload file size, unit M, no limit
    upUrl: 'plugins/home/service/upload_files.php', // File upload interface
    upType: 'zip,txt,pdf,sql,gff3,gff', // Upload type detection, separated by, number
    // The interface returns a result callback, which is judged based on the data returned by the result. You can return a string or json for judgment.
    upCallBack: function(res) {
        var status = res.status;
        var msg = res.message;
        var url = res.url + "?" + Math.random();

        toastr.options = {"closeButton": false,"debug": false,"positionClass": "toast-top-right","onclick": null,"showDuration": "10000","hideDuration": "1000","timeOut": "40000","extendedTimeOut": "0","showEasing": "linear","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"}
        // Already done
        if (status == 2) {
            console.log(2, msg);
            toastr.success("Successfully uploaded", "Success");
        }
        // still uploading
        if (status == 1) {
            console.log(1, msg);
        }
        // The interface returns an error
        if (status == 0) {
            // Stop upload to trigger $ .upStop function
            $.upErrorMsg(msg);
            console.log(0, msg);
            toastr.error(res.message, "Failure");
        }
        // already uploaded
        if (status == 3) {
            Progress(100);
            $.upErrorMsg(msg);
            console.log(3, msg);
            toastr.success("Successfully uploaded", "Success");
        }
    },
    // The upload process is monitored, and the progress bar can be changed according to the current progress value
    upEvent: function(num) { // The value of num is the progress of the upload, from 1 to 100
        Progress(num);
        console.log(num);
    },
    // Processing after an error occurs
    upStop: function(errmsg) {
        // Here is just a simple alert result, you can use other pop-up reminder plugins
        alert(errmsg);
    },
    // Processing and callback before starting upload, such as progress bar initialization, etc.
    upStart: function() {
        Progress(0);
        // $('#pic').hide();
        console.log('Start upload');
        toastr.success("Start uploading", "Success");
    }
});
</script>

