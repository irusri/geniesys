function check_filess() {
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
                generate_indices();
            }else{
                console.log(data)
                toastr.error("missing files", "Failure"); 
            }
           
              
           
        }
    });
}

function generate_indices(){
// Here we have make relevant files using gff3 files
// Then load them into the database
// update gene_i
// make blast indices.


}