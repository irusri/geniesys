/* ============ */
/* Enrichment Help */
/* ============ */
var tour = {
  id: "enrichment-help",
   showPrevButton: true,
   scrollTopMargin: 300,
  steps: [
    {
      title: "Enrichment",
      content: "Click the Load Example button if no genes are previously selected.",
      target: "inner-content",
      placement: "top",
      xOffset: 50,
      yOffset: 10,
	  
    },
	 {
      title: "Summary",
      content: "The summary tab shows enrichments for several annotations, scroll down to see enrichemnts.",
      target: "inner-content",
      placement: "top",
      xOffset: 20,
      yOffset: 40,
    
    },
	 {
      title: "GO details",
      content: "Click the GO details tab before continuing the tour.",
      target: "inner-content",
      placement: "top",
   	  yOffset: 40,
      xOffset: 80,
    },
    {
      title: "Enrichment tree view",
      content: "This window shows the enrichment tree structure for the selected category (default: Biological process)",
      target: "inner-content",
      placement: "top",
      yOffset: 100,
      xOffset: 200,
    },
     {
      title: "Display settings",
      content: "This panel contains options for the tree view output, choose Category (Biological process, molecular function, cellular component) Tree layout, Annotation (Full GO or Plant slim GO), Enrichment type and Correction. Click display to update view.",
      target: "inner-content",
      placement: "top",
      yOffset: 540,
      xOffset: 100,
    },
     {
      title: "Display settings",
      content: "Change requiremets for significance, min number of genes and max p-value. ",
      target: "inner-content",
      placement: "top",
      yOffset: 540,
      xOffset: 250,
    },
     {
      title: "External view",
      content: "Get static images of the tree view or export your result to REVIGO.",
      target: "inner-content",
      placement: "top",
      yOffset: 620,
      xOffset: 250,
    },

     {
      title: "Export",
      content: "Export gene ontology table (text), a publication quality Svg image or a Graphml output.",
      target: "inner-content",
      placement: "top",
      yOffset: 540,
      xOffset: 410,
    },

  ]
},

/* ========== */
/* Enrichment global functions */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
	  
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
	
  }
},
startBtnEl = document.getElementById("startTourBtn_enrichment");
if (startBtnEl) {
  addClickListener(startBtnEl, function() {
	if (!mannapperuma.isActive) {
      mannapperuma.startTour(tour);
    }
  });
}
else {
  if (mannapperuma.getState() === "help-enrichment:1") {
    mannapperuma.startTour(tour);
  }
}
