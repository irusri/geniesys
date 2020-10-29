/* ============ */
/* POPGENIE HELP */
/* ============ */
var tour = {
  id: "eplant-help",
  showPrevButton: true,
  steps: [
    {
      title: "Select a view",
      content: "Please select a desired experiment",
      target: "datasourcediv",
      placement: "left",
	    yOffset: -10
    },
	
	 {
      title: "Customize dendrogram ",
      content: "Add or remove dual dendrogram view",
      target: "datasourcediv2",
      placement: "left",
   	  yOffset: -10
      
	  
    },
    {
      title: "Customize cell values",
      content: "Show Hide cell values in the heatmap",
      target: "show_hide_chk_lbl",
      placement: "left",
   	  yOffset: -10
    },
    
	 {
      title: "Change row distance",
      content: "Here you can change row distance",
      target: "distfunc",
      placement: "left",
   	  yOffset: -16
      
	  
    },
	{
      title: "Change row linkage",
      content: "Here you can change row linkage",
      target: "clustfunc",
	 placement: "left",
	   yOffset: -16
    },
		 
    {
      title: "Export.",
      content: "Save Heatmap as an image.",
      target: "inchlib",
      placement: "top",
      yOffset: 24,
      xOffset: 920
    },
	 {
      title: "Filter columns",
      content: "Choose filter settings and click create heatmap to update the image.",
      target: "inchlib",
      placement: "top",
      yOffset: 20,
      xOffset: -16
    },
    
    /*,
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