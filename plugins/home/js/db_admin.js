var mhost;
var musername;
var mpasswd;
var mdbname;


$("#download_indices").click(function () {
    download_indices("create_database", "dump");
});


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
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "10000",
                "hideDuration": "1000",
                "timeOut": "40000",
                "extendedTimeOut": "0",
                "showEasing": "linear",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            console.log(data)
            if (data > 10) {
                toastr.success("download and indexed fasta files", "Success");
            } else {
                toastr.error("remote server failed", "Failure");
            }

        }
    });
}


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


/** CLoning buttons **/
function clone_genome(t) {
   //console.log(t.id)
   
   db_operation("create_database", t.id);
};


$("#myadmin_links").click(function () {
    window.open("http://" + $('#mhost').val() + "/phpmyadmin/db_structure.php?db=" + $('#mdbname').val(), '_blank');
});

db_operation("db_name", "check");

//Check database
function db_operation(action, name) {
    on_disable_b_and_c_clicked();
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
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "10000",
                "hideDuration": "1000",
                "timeOut": "40000",
                "extendedTimeOut": "0",
                "showEasing": "linear",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
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

//Upload progress component
 
function Progress(value, domname) {
    var myProgress = document.getElementById("progress_" + domname);
    var mySpan = document.getElementById("mySpan_" + domname);
    mySpan.innerText = value + "%";
    myProgress.value = value;
}

var upidgff3 = new genieuc({
    id: "upidgff3", // Binding id
    url: "plugins/home/service/upload_files.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff", // Limit upload type, empty without limit
    shardsize: "20", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "400", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {
        "version": "genieuc"
    }, // Additional file header
    apped_data: "gff3", //Additional data for each upload 
    // Define error messages
    // Error message
    error: (msg) => {
        alert(msg);
    },
    // Initialization event                
    start: (that) => {
        Progress(0, that.id)
    },
    // Upload progress event
    progress: (num, other, that) => {
        Progress(num, that.id);
    },
    // The upload success callback, the callback will cycle according to the slice, to terminate the upload cycle, you must return false, and always return true in the case of success;
    success: (res) => {
        let data = res ? eval('(' + res + ')') : '';
        if (data.status == 2) {
            toastr.success(data.message, "Success");
        }
        // If there is no error in the interface, it must return true to not terminate the upload cycle
        return true;
    }
});

var upid_a = new genieuc({
    id: "upid_a", // Binding id
    url: "plugins/home/service/upload_files.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff,fasta,fa", // Limit upload type, empty without limit
    shardsize: "20", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "400", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {
        "version": "genieuc"
    }, // Additional file header
    apped_data: "annotation", //Additional data for each upload
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
        Progress(0, that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other, that) => {
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
    url: "plugins/home/service/upload_fasta.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff,fasta,fa", // Limit upload type, empty without limit
    shardsize: "20", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "400", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {
        "version": "genieuc"
    }, // Additional file header
    apped_data: "genome", //Additional data for each upload
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
        Progress(0, that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other, that) => {
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
    url: "plugins/home/service/upload_fasta.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff,fasta,fa", // Limit upload type, empty without limit
    shardsize: "20", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "400", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {
        "version": "genieuc"
    }, // Additional file header
    apped_data: "protein", //Additional data for each upload
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
        Progress(0, that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other, that) => {
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
    url: "plugins/home/service/upload_fasta.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff,fasta,fa", // Limit upload type, empty without limit
    shardsize: "20", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "400", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {
        "version": "genieuc"
    }, // Additional file header
    apped_data: "transcript", //Additional data for each upload
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
        Progress(0, that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other, that) => {
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
    id: "upid_fc", // Binding id
    url: "plugins/home/service/upload_fasta.php", // url address
    //checkurl: "server/php_db/check.php", // Check upload url address
    type: "zip,txt,pdf,sql,gff3,gff,fasta,fa", // Limit upload type, empty without limit
    shardsize: "20", // The size of each fragment, the unit is M, the default is 1M
    minsize: '', // The minimum number of files to upload M, the unit is M, the default is none
    maxsize: "400", // The maximum number of files uploaded is M, the unit is M, the default is 200M
    headers: {
        "version": "genieuc"
    }, // Additional file header
    apped_data: "cds", //Additional data for each upload
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
        Progress(0, that.id)
    },

    // Waiting for upload event, can be used for loading
    beforeSend: () => {
        console.log('Waiting for request');
    },

    // Upload progress event
    progress: (num, other, that) => {
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



var tabs = $('#tab-container');
$('#tab-container').easytabs({
	animationSpeed: "fast",
        // updateHash: false,
       
        }
);



tabs.easytabs({ animate: false });  
tabs.bind("easytabs:before", function (e, clicked) {
   // $("#main_editor").val(editor_content);
   // console.log(editor_content)
    if(clicked.parent().hasClass('disabled')) {
        return false;
    }
});

$('.prevent-default').click(function(e) {
        e.preventDefault();
        return false;
    });


    function enable_all()
{
    $("#clone_div").show(); 
  var tabs = $('#tab-container');
  disable_easytabs(tabs, []); 
}


//on_disable_b_and_c_clicked();
function on_disable_b_and_c_clicked()
{
    $("#clone_div").hide(); 
  var tabs = $('#tab-container');
  disable_easytabs(tabs, [3,4,5]);
  return false;
}



function disable_easytabs(tabs, indexes)
{
    var lis = tabs.children('ul').children();
    var index = 0;
    lis.each(function()
    {
        var li = $(this);
        var a = li.children('a');
        var disabled = $.inArray(index, indexes) != -1;
        if (disabled)
        {
            li.addClass('disabled');            
        }
        else
        {
            li.removeClass('disabled');            
        }
        index++;
    });
}


//console.log(editor_content)