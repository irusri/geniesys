/* ============ */
/* Chromosome Diagram Help */
/* ============ */
var tour = {
  id: "cd-help",
   showPrevButton: true,
    
  steps: [
    {
      title: "Load example",
      content: "If you haven't selected any genes yet, please load example data to start with.",
      target: "tool_tour",
      placement: "top",
	    xOffset: -80 
    },
	
	 {
      title: "Input Gene ids",
      content: "Your GeneList genes should appear here, otherwise please type in some gene ids seperated by comma or space.",
      target: "extensive_help",
      placement: "top",
   	  xOffset: -210,
	  yOffset: 60,
      
	  
    },
	
    {
      title: "Plot Geenes",
      content: "Click here to plot genes on Chromosome Diagram.",
      target: "extensive_help",
	 placement: "left",
	    xOffset: -40,
	  yOffset: 180,
    },
		 { 
      title: "Zoom In/Out",
      content: "Adjust the zoom level using slider clontrol.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -140,
	  yOffset: 260,
      
	  
    },
	 { 
      title: "Chrosmome Color",
      content: "Change the color of chromosomes.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -140,
	  yOffset: 300,
      
	  
    },
	{ 
      title: "Chrosmome Alpha",
      content: "Adjust the alpha value of chromosomes.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -140,
	  yOffset: 340,
      
	  
    },{ 
      title: "Gene Color",
      content: "Change the gene color.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -140,
	  yOffset: 380,
      
	  
    },
	{ 
      title: "Label Color",
      content: "Change the color of labels.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -140,
	  yOffset: 430,
      
	  
    },
	{ 
      title: "Upload File",
      content: "Click here to upload the custom bed file.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -80,
	  yOffset: 480,
      
	  
    },
	{ 
      title: "Clear GeneList",
      content: "Click here to clear the active GeneList.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -180,
	  yOffset: 480,
      
	  
    },
	{ 
      title: "Shaow Table",
      content: "Click here to see the current diagram data.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -280,
	  yOffset: 480,
      
	  
    },
	{ 
      title: "Export Diagram",
      content: "Export Chromosome Diagram to PDF or PNG.",
      target: "extensive_help",
      placement: "left",
   	  xOffset: -280,
	  yOffset: 520,
      
	  
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
/* Chromosome Diagram global functions */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
	  
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
	
  }
},
startBtnEl = document.getElementById("startTourBtn_cd");
if (startBtnEl) {
  addClickListener(startBtnEl, function() {
	if (!mannapperuma.isActive) {
      mannapperuma.startTour(tour);
    }
  });
}
else {
  if (mannapperuma.getState() === "help-cd:1") {
    mannapperuma.startTour(tour);
  }
}