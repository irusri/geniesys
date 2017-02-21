  $(document).ready(function() {
      $('#example-1').sticklr({
          showOn: 'hover',
          stickTo: 'right'
      });
      $('#example-2').sticklr({
          showOn: 'click',
          stickTo: 'left'
      });
      updateallbaskets();

if($_GET("table")!=undefined){
  open_genelist();
}


  });

  function glowme(id) {
      //console.log("fired");
      //		 $(id).toggleClass('active');
      //$(id).effect('bounce',100);
      $(id).delay(60).css({
          opacity: 0.6
      }).animate({
          opacity: 1
      }, 60);
      /*$(id).stop().animate({ opacity: 0.2,borderSpacing:"10px" }, 100, 'linear')
              .animate({ opacity: 1,borderSpacing:"0px"  }, 100, 'linear')*/
      //  .stop();
      //	glower.toggleClass('active');
      /*$(id).illuminate({
			'intensity': '0.2',
			'color': '#d35530',
			'blink': 'false',
			'blinkSpeed': '100',
			'outerGlow': 'true',
			'outerGlowSize': '150px',
			'outerGlowColor': '#d35530'
		});*/
  }

  function pad2(number) {
      return (number < 10 ? 0 : '') + number;
  }

  function updategenebasketsss() {
      //$("#numberofgenesSpan").illuminate();
      $.ajax({
          url: "plugins/genelist/baskets/updatebaskets.php?id=gene",
          type: "GET",
          success: function(hasil) {
              var numberc = pad2(hasil).replace(/\s/g, "");
              document.getElementById("numberofgenesSpan").innerHTML = numberc;
              $("#content").load("plugins/genelist/baskets/listbarang.php");
              /*		var nogenes_blinker = setInterval(function(){ blinker() }, 1000);
				if(numberc!="00"){
					clearInterval(nogenes_blinker);
					 $('#nogenesspan').hide();
				}else{
					$('#nogenesspan').show();
				}*/
             // glowme("#numberofgenesSpan");
          }
      });
      return false;
  }

  function updategenebasketx() {
      //$("#numberofgenesSpan").illuminate();
      $.ajax({
          url: "plugins/genelist/crud/updatebaskets.php?id=gene",
          type: "GET",
          success: function(hasil) {
              var numberc = pad2(hasil).replace(/\s/g, "");
              document.getElementById("numberofgenesSpan").innerHTML = numberc;
              $("#content").load("plugins/genelist/crud/listbarang.php");
              //glowme("#numberofgenesSpan");
          }
      });
      return false;
  }

  function updatesamplebasket() {
      $.ajax({
          url: "plugins/genelist/crud/updatebaskets.php?id=sample",
          type: "GET",
          success: function(hasil) {
              var numberc = pad2(hasil).replace(/\s/g, "");
              document.getElementById("numberofexpSpan").innerHTML = numberc;
              //alert('something happening');
          }
      });
      glowme("#numberofexpSpan");
      return false;
  }

  function updateallbaskets() {
      //updategobasket();
      //   updatesamplebasket();
      updategenebasket();
      //$("#content").load("http://beta.popgenie.org/crud/listbarang.php");
  }
  $(function() {
      $("a.add").click(function() {
          page = $(this).attr("href")
          $("#Formcontent").html("loading...").load(page);
		  $("#cancelbtn").show();
          return false
      })
      $("a.cancel").click(function() {
          page = $(this).attr("href")
          $("#Formcontent").html("").unload(page);
		  $("#cancelbtn").hide();
          return false
      })
      $("a.savecurrent").click(function() {
          page2 = $(this).attr("href")
          $("#Formcontent").html("loading...").load(page2);
		  $("#cancelbtn").show();
          return false
      })
  })

  function clickgenelink() {
      updategenebasket();
      $("#content").load("plugins/genelist/crud/listbarang.php");
  }


//<!--<a href="plugins/genelist/tool.php" data-toggle="modal" data-target="#myModal" onclick="hidemef(this)" data-refresh="true"><font  style="color:#00F" >here</font></a>

  function open_genelist(e) {
      try {
          $('#example-2').sticklr('hide');
      } catch (err) {}
      var genelink = document.getElementById('genelistlink'); //("#");
      genelink.click();
      //e.stopPropagation();
  }

  function open_genelist_slider() {
      var genelink = document.getElementById('genebagclick'); //("#");
      genelink.click();
  }

  function open_samplelist(e) {
      try {
          $('#example-2').sticklr('hide');
      } catch (err) {}
      var samplelink = document.getElementById('samplelistlink'); //("#");
    //  samplelink.click();
//	  e.stopPropagation();
  }

  function open_golist() {
      try {
          $('#example-2').sticklr('hide');
      } catch (err) {}
      var golink = document.getElementById('golistlink'); //("#");
      golink.click();
  }

  function blinker() {
      $('#nogenesspan').fadeOut(500);
      $('#nogenesspan').fadeIn(500);
  }
  var getcookie_tmp = getCookie("showhidespans_cookie");
  if (getcookie_tmp == null) {
      getcookie_tmp = "open"
  }
  if (getcookie_tmp == "close") {
      $("#example-2").addClass('sticklrx');
      $("#showhidespans").html(">");
  } else {
      $("#example-2").removeClass('sticklrx');
      $("#showhidespans").html("<");
  }

  function closeslider() {
      var className = $('#example-2').attr('class');
      if (className == "sticklr sticklrx sticklr-js" || className == "sticklr sticklr-js sticklrx") {
          $("#example-2").removeClass('sticklrx');
          $("#showhidespans").html("<");
          setCookie("showhidespans_cookie", "open");
      } else {
          $("#example-2").addClass('sticklrx');
          $("#showhidespans").html(">");
          setCookie("showhidespans_cookie", "close");
      }
  }
