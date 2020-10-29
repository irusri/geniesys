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
      title: "Change base pairs",
      content: "You can change the slider and select the number of pase pairs for weblogo.",
      target: "slider",
      placement: "left",
   	  yOffset: -10
      
	  
    }, {
      title: "Input Gene ids",
      content: "Your genelist should appear here otherwise please go to the <a href='?genelist=enable'>genelist</a> and select some genes.",
      target: "input_ids",
      placement: "left",
   	  yOffset: 10
      
	  
    },
	
	 {
      title: "Zoom in/out",
      content: "Use Zoom in/out button to adjust your sequence logo.",
      target: "outerCenter",
      placement: "top",
   	  yOffset: 10
      
	  
    },
	
		 {
      title: "Generate a Phylogeny tree",
      content: "Click here to generate phylogeny tree.",
      target: "phylogeny_tree",
      placement: "left",
   	  yOffset:-10
      
	  
    },
	
	{
      title: "Download fasta",
      content: "Here you can download a fasta file.",
      target: "fasta_download",
      placement: "left",
   	  yOffset: -10
      
	  
    },
	 {
      title: "Download vector",
      content: "Here you can download the Sequencelogo.",
      target: "pdf_download",
      placement: "left",
   	  yOffset:-10
      
	  
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