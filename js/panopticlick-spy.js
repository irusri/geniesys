function identify_plugins(){
  // in Mozilla and in fact most non-IE browsers, this is easy
  if (navigator.plugins) {
    var np = navigator.plugins;
    var plist = new Array();
    // sorting navigator.plugins is a right royal pain
    // but it seems to be necessary because their order
    // is non-constant in some browsers
    for (var i = 0; i < np.length; i++) {
      plist[i] = np[i].name + "; ";
      plist[i] += np[i].description + "; ";
      plist[i] += np[i].filename + ";";
      for (var n = 0; n < np[i].length; n++) {
        plist[i] += " (" + np[i][n].description +"; "+ np[i][n].type +
                   "; "+ np[i][n].suffixes + ")";
      }
    }
    plist.sort(); 
  }
  return plist;
}

function ieAcrobatVersion() {
  // estimate the version of Acrobat on IE using horrible horrible hacks
  if (window.ActiveXObject) {
    for (var x = 2; x < 10; x++) {
      try {
        oAcro=eval("new ActiveXObject('PDF.PdfCtrl."+x+"');");
        if (oAcro) 
          return "Adobe Acrobat version" + x + ".?";
      } catch(ex) {}
    }
    try {
      oAcro4=new ActiveXObject('PDF.PdfCtrl.1');
      if (oAcro4)
        return "Adobe Acrobat version 4.?";
    } catch(ex) {}
    try {
      oAcro7=new ActiveXObject('AcroPDF.PDF.1');
      if (oAcro7)
        return "Adobe Acrobat version 7.?";
    } catch (ex) {}
    return "";
  }
}

function get_fonts() {
  // Try flash first
	var fonts = "";
	var obj = document.getElementById("flashfontshelper");
	if (obj && typeof(obj.GetVariable) != "undefined") {
		fonts = obj.GetVariable("/:user_fonts");
    fonts = fonts.replace(/,/g,", ");
    fonts += " (via Flash)";
	} else {
    // Try java fonts
    try {
      var javafontshelper = document.getElementById("javafontshelper");
      if (!javafontshelper) throw 'No java element';
      var jfonts = javafontshelper.getFontList();
      for (var n = 0; n < jfonts.length; n++) {
        fonts = fonts + jfonts[n] + ", ";
      }
    fonts += " (via Java)";
    } catch (ex) {}
  }
  return fonts;
}

function set_dom_storage(){
  try { 
    localStorage.panopticlick = "yea";
    sessionStorage.panopticlick = "yea";
  } catch (ex) { }
}

function test_dom_storage(){
  var supported = "";
  try {
    if (localStorage.panopticlick == "yea") {
       supported += "DOM localStorage: Yes";
    } else {
       supported += "DOM localStorage: No";
    }
  } catch (ex) { supported += "DOM localStorage: No"; }

  try {
    if (sessionStorage.panopticlick == "yea") {
       supported += ", DOM sessionStorage: Yes";
    } else {
       supported += ", DOM sessionStorage: No";
    }
  } catch (ex) { supported += ", DOM sessionStorage: No"; }

  return supported;
}

function test_ie_userdata(){
  try {
    oPersistDiv.setAttribute("remember", "remember this value");
    oPersistDiv.save("oXMLStore");
    oPersistDiv.setAttribute("remember", "overwritten!");
    oPersistDiv.load("oXMLStore");
    if ("remember this value" == (oPersistDiv.getAttribute("remember"))) {
      return true;
    } else { 
      return false;
    }
  } catch (ex) {
      return false;
  }
}

function get_navigator_data() {
  var nav = {};
  for (var name in navigator) {
    var data = navigator[name];
    switch (name) {
      case 'battery':
        data = {
          charging: data.charging,
          chargingTime: data.chargingTime,
          level: data.level
        };
        break;
      case 'javaEnabled':
        data = navigator.javaEnabled();
        break;
      default:
        try {
          var json = JSON.stringify(navigator[name]);
          if (json) {
            data = JSON.parse(json);
          } else {
            data = null;
          }
        } catch(e) {
          data = null;
        }
    }
    nav[name] = data;
  }
  return nav;
}

function get_client_whorls(){
  // fetch client-side vars
  var whorls = {};
  
  whorls['navigator'] = get_navigator_data();

  // Achieved in navigator
  /*try { 
    whorls['plugins'] = identify_plugins(); 
  } catch(ex) { 
    whorls['plugins'] = "";
  }*/

  // Do not catch exceptions here because the async Flash applet will raise
  // them until it is ready.  Instead, if Flash is present, the retry timeout
  // will cause us to try again until it returns something meaningful.

  whorls['fonts'] = get_fonts();
  
  try { 
    whorls['timezone'] = new Date().getTimezoneOffset();
  } catch(ex) {
    whorls['timezone'] = "";
  }

  try {
    whorls['video'] = screen.width+"x"+screen.height+"x"+screen.colorDepth;
  } catch(ex) {
    whorls['video'] = "";
  }

  whorls['ie_userdata'] = test_ie_userdata();

  return whorls;
};

function post_client_whorls(){
  var req = new XMLHttpRequest();

  req.onreadystatechange = function () {
    if (req.readyState == 4) {
      if (req.status == 200) {
        console.log('Sausage sent.');
        window.location.href = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
      } else {
        console.log('Cannot send sausage: server did not returned 200.');
        window.location.reload(); // Retry
      }
    }
  };
  req.onerror = function (e) {
    console.log('Cannot send sausage: XMLHttpRequest error.');
    window.location.reload(); // Retry
  };

  req.open('POST', 'whorls', true);
  req.setRequestHeader('Content-Type', 'application/json');
  req.send(JSON.stringify(get_client_whorls()));
}

//post_client_whorls();
