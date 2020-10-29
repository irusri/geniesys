/* ============ */
/* Sequence Search Help */
/* ============ */
var tour = {
  id: "sequence_search-help",
   showPrevButton: true,
    
  steps: [
    	
	 {
      title: "Input Gene ids",
      content: "Your GeneList genes appear here otherwise please type in some gene ids seperated by comma/space or click Load Example button.",
      target: "ids",
      placement: "top",
   	  yOffset: 10
      
	  
    },
	
    {
      title: "Select Dataset",
      content: "Select BLAST dataset to extract sequences.",
      target: "database_type",
	 placement: "top",
	
    },
		 { 
      title: "Search",
      content: "Click here to search and extract the sequences.",
      target: "search_button",
      placement: "top",
      
	  
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
/* Sequence Search global functions */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
	  
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
	
  }
},

startBtnEl = document.getElementById("startTourBtn_sequence_search");

if (startBtnEl) {
  addClickListener(startBtnEl, function() {
	if (!mannapperuma.isActive) {
      mannapperuma.startTour(tour);
    }
  });
}
else {
  // Assuming we're on page tools page.
  if (mannapperuma.getState() === "help-sequence_search:1") {
	  
    // component id is help-explot and we're on the second step.
    mannapperuma.startTour(tour);
  }
}