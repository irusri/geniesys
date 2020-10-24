function check_files() {
    mhost = $('#mhost').val();
    musername = $('#musername').val();
    mpasswd = $('#mpassword').val();
    mdbname = $('#mdbname').val();
    var finalvarx = "host=" + mhost + "&username=" + musername + "&password=" + mpasswd + "&database=" + mdbname ;//+ "&action=" + action + "&name=" + name;
    $.ajax({
        type: "POST",
        url: "plugins/home/service/annotation.php",
        data: (finalvarx),
        dataType: 'json',
        success: function (data) {
            toastr.options = { "closeButton": false, "debug": false, "positionClass": "toast-top-right", "onclick": null, "showDuration": "10000", "hideDuration": "1000", "timeOut": "40000", "extendedTimeOut": "0", "showEasing": "linear", "hideEasing": "linear", "showMethod": "fadeIn", "hideMethod": "fadeOut" }
            if(data.length==0){
                toastr.success("Now you have all the required files", "Success");
            }else{
                console.log(data)
                toastr.success("missing files", "Failure");
            }
           
              
           
        }
    });
}