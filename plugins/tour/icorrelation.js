/* ============ */
/* Explot Help */
/* ============ */
var tour = {
  id: "explot-help",
   showPrevButton: true,
    
  steps: [
    {
      title: "Select a data source",
      content: "Please select a desired data source option.",
      target: "datasourcediv",
      placement: "left",
	    yOffset: -10
    },
	
	 {
      title: "Input Gene ids",
      content: "Your genelist genes appear here otherwise please type in some gene ids seperated by comma or space.",
      target: "input_ids",
      placement: "left",
   	  yOffset: 10
      
	  
    },
	
    {
      title: "Draw a chart",
      content: "Click here to update heatmap.",
      target: "submit",
	 placement: "left",
	  onNext: function() {
		  $.drawchart();
      },
	   yOffset: -10
    },
		 {
      title: "Download vector",
      content: "You can download final output into different vector formats.",
      target: "save_as_svg",
      placement: "left",
   	  yOffset: -10
      
	  
    },
	 {
      title: "Select line series",
      content: "You can select line series and create a new gene list.",
      target: "container",
      placement: "top",
   	  yOffset: 110,
	   xOffset: 110,
	  
      
	  
    }
	
	
	
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
