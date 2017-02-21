function hidemef(e) {
    $("#numberofgenesSpanDetail").hide();
    $('.sticklr-arrow').hide();
}
$(function() {
    $.ajaxSetup({
        // Disable caching of AJAX responses
        // cache: false
    });
    $("a.edit").click(function() {
        page = $(this).attr("href");
        $("#Formcontent").html("loading...").load(page);
		$("#cancelbtn").show();
        return false;
    })
    $("a.delete").click(function() {
        el = $(this);
        if (confirm("Are you sure you want to delete this gene list,you will loose all the genes in it?")) {
            $.ajax({
                url: $(this).attr("href"),
                type: "GET",
                success: function(hasil) {
                    if (hasil == 1) {
                        $("#content").load("plugins/genelist/baskets/listbarang.php");
                        updategenebasket();
                        el.parent().parent().fadeOut('slow');
                    } else {
                        alert(hasil);
                    }
                }
            })
        }
        return false;
    })
    $("a.bname").click(function() {
        var valuest = $(this).attr("id");
        $.ajax({
            url: $(this).attr("href"),
            type: "GET",
            success: function(hasil) {
                if (hasil == 1) {
                    page4 = $(this).attr("href");
                    $("#content").load("plugins/genelist/baskets/listbarang.php");
                    //$("#numberofgenesSpan").html(valuest).load(page4);
                    updategenebasket();
                } else {
                    alert(hasil);
                }
            }
        })
        return false;
    })
})

function changespeciesdropdown(tmpcookie) {
    //console.log(tmpcookie);
    if (tmpcookie.match(/^potr[aisx]$/)) {
        $('#poplar_species_select').val(tmpcookie).change();
        setCookie("select_species", tmpcookie, 10);
    }
}
