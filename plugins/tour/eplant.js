/* ============ */
/* POPGENIE HELP */
/* ============ */
var tour = {
  id: "eplant-help",
  showPrevButton: true,
  steps: [
    {
      title: "Select a view",
      content: "Please select a desired view option.",
      target: "datasourcediv",
      placement: "left",
	    yOffset: -10
    },
	
	 {
      title: "Input Gene id",
      content: "Enter a gene id (such as Eucgr.A00375) into the text box and click the search icon.",
      target: "input_id",
      placement: "left",
   	  yOffset: -10
      
	  
    },
	 {
      title: "Change mode",
      content: "Here we can change the mode to absolute or relative.",
      target: "modechk",
      placement: "left",
   	  yOffset: -10
      
	  
    },
	{
      title: "ePlant GeneList",
      content: "This is the GeneList. If this is empty please go GeneList and select some genes.",
      target: "newtable_2",
	 placement: "left",
	  
	   yOffset: 10
    },
		 {
      title: "Download vector",
      content: "You can download our output into different vector formats.",
      target: "save_as_svg",
      placement: "left",
   	  yOffset: -10
      
	  
    }/*,
	{
      target: "charttyperadio",
      placement: "left",
      title: "Change chart type",
      content: "Here we can change the chart type by selecting line or column."
    }*/
	
  ]
  
},
/* ========== */
/* Explot global functions */
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
  // Assuming we're on page tools page.
  if (mannapperuma.getState() === "help-explot:1") {
	  
    // component id is help-explot and we're on the second step.
    mannapperuma.startTour(tour);
  }
}