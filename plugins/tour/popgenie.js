/* ============ */
/* POPGENIE HELP */
/* ============ */
var tour = {
  id: "popgenie-help",
  showPrevButton: true,
  steps: [
	    {
      target: "geniemenu-controller-0",
      placement: "top",
      title: "Draggable Menu",
	   yOffset: 0,
      content: "Click the numeric icon to go to GeneList and add your genes of interest to begin with. You can drag this menu around the screen. Move the cursor over the icons to see more information.",
	 // multipage: true,
	//  onNext: function() {
     //   window.location = "http://v3.popgenie.org/flashbulktools"
   //   }
    },
    {
      title: "Autocomplete search input",
      content: "Here is the place to search gene ids, descriptions, synonyms or other related ids. <br><strong>for example:</strong> Eucgr.C01899, AT2G32080, Eucgr.I01102.1 ",
      target: "mainsearch",
      placement: "bottom",
    },
	  
	/*{ 
		title: "Search few genes",
      content: "Please type in few genes or use click me to add demo data button",
		target: "main",
      placement: "top",
	  xOffset:500,
	   yOffset:60,
	   multipage: false,
	   onPrev: function() {
        window.location = "http://v3.popgenie.org/flashbulktools"
      },

	},
	
	{
		title: "Add genes into gene list",
      content: "Click here to add genes into your gene list",
		target: "main",
      placement: "right",

	   yOffset:160,
	},
	
	
	 {
      target: "samplelistli",
      placement: "right",
      title: "Sample List",
	   yOffset: -20,
      content: "This is the number of samples in the sample list. First we need go to the <a href='?samplelist=enable'>SampleList</a> and add some of interested samples."
    },
	{
      target: "golistli",
      placement: "right",
      title: "GO List",
	   yOffset: -20,
      content: "This is the number of GO in the GO list. First we need go to the <a href='?golist=enable'>GOList</a> and add some of interested Go ids."
    },
	{
      target: "analysisli",
      placement: "right",
      title: "Analysis  Tools",
	   multipage: true,
	    yOffset: -20,
      content: "Once we have added few genes and samples into your Gene and Sample Lists. Here we can do further analysis using analysis tools.",
	  onNext: function() {
        window.location = "http://v3.popgenie.org/eplant"
      }
    }*/

  ]
  
},
/* ========== */
/* PopGenIE global */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
  }
},

startBtnEl = document.getElementById("startTourBtn");

if (startBtnEl) {
  addClickListener(startBtnEl, function() {
	if (!mannapperuma.isActive) {
      mannapperuma.startTour(tour);
    }
  });
}
else {
	console.log(mannapperuma.getState() );
	 if (mannapperuma.getState() === "popgenie-help:1") {
		mannapperuma.startTour(tour);
	  }
	  if (mannapperuma.getState() === "popgenie-help:2") {
		mannapperuma.startTour(tour);
	  }
	  if (mannapperuma.getState() === "popgenie-help:3") {
		mannapperuma.startTour(tour);
	  }
	
}