/* ============ */
/* exNet Help */
/* ============ */
var tour = {
  id: "exnet-help",
   showPrevButton: true,
   smoothScroll: false,
  steps: [
    {
      title: "exNet",
      content: "exNet. Click on the Load example button if no previous genes were selected.",
      target: "inner-content",
      placement: "top",
      xOffset: 50,
      yOffset: 10,
    },
	
	 {
      title: "Network panel",
      content: "The network panel shows the co-expression network, left-click to select genes, right click on a selected genes to get additional options, like expand network.",
      target: "inner-content",
      placement: "top",
   	  xOffset: 250,
      yOffset: 150,
    },
    {
      title: "Select dataset",
      content: "Choose dataset in the scroll bar",
      target: "mfooter",
      placement: "right",
      yOffset: -280,
      xOffset: -1100,
      },

    {
      title: "Select Correlation type",
      content: "Click here to select correlation type (MI+CLR default)",
      target: "mfooter",
      placement: "right",
      yOffset: -255,
      xOffset: -1100,
    },
     {
      title: "Select thresholds",
      content: "The display threshold adjust the number of edges shown in the network, expand threshold adjust the threhold in which the expand to network neighbours function is adding neighbours.",
      target: "mfooter",
      placement: "right",
      yOffset: -220,
      xOffset: -1100,
    },
     {
      title: "Visual apperance",
      content: "Change shape of network nodes, by default genes are circles and transcription factors are rectangles.",
      target: "mfooter",
      placement: "right",
      yOffset: -165,
      xOffset: -1080,
    },
    {
      title: "Subnetwork",
      content: "Click the checkbox and choose a threshold for the subnetwork.",
      target: "mfooter",
      placement: "right",
      yOffset: -130,
      xOffset: -1080,
    },
     {
      title: "Reload network",
      content: "Click the Reload button to reload network with new settings",
      target: "mfooter",
      placement: "right",
      yOffset: -100,
      xOffset: -1080,
    },
     {
      title: "Expand network",
      content: "Select one or several nodes in the network, then right-click on one of the selected nodes and choose Expand.",
      target: "inner-content",
      placement: "top",
      yOffset: 300,
      xOffset: 100,
    },
    {
      title: "Gene list actions",
      content: "To add newly added genes (orange) select genes and click add button, remove button will remove genes from your genelist (green) and the replace button will replace any genes in the basket with the currently selected genes in the network panel.",
      target: "mfooter",
      placement: "right",
      yOffset: -265,
      xOffset: -820,
    },
    {
      title: "Save genes in a gene list",
      content: "Write a gene list name and choose to save all visible nodes or all currently selected nodes to a new or existing gene list.",
      target: "mfooter",
      placement: "right",
      yOffset: -188,
      xOffset: -820,
    },
    {
      title: "Export network",
      content: "Click buttons to get a list of genes (genes), an Svg image(Svg) or a Graphml output (Graphml) of the network.",
      target: "mfooter",
      placement: "right",
      yOffset: -110,
      xOffset: -820,
    },
    {
      title: "Gene information plots",
      content: "Click the image buttons to get profiles scatterplots or a heatmap of the selected genes.",
      target: "mfooter",
      placement: "right",
      yOffset: -255,
      xOffset: -400,
    },
    {
      title: "Color genes",
      content: "Add annotation id and click the 'color genes' button to color genes in the network panel. (See help for detailed description)",
      target: "mfooter",
      placement: "left",
      yOffset: -255,
      xOffset: 1200,
    },
  ]
},

/* ========== */
/* exNet global functions */
/* ========== */
addClickListener = function(el, fn) {
  if (el.addEventListener) {
	  
    el.addEventListener('click', fn, false);
  }
  else {
    el.attachEvent('onclick', fn);
	
  }
},
startBtnEl = document.getElementById("tool_tour");
if (startBtnEl) {
  addClickListener(startBtnEl, function() {
	if (!mannapperuma.isActive) {
      mannapperuma.startTour(tour);
    }
  });
}
else {
  if (mannapperuma.getState() === "help-exnet:1") {
    mannapperuma.startTour(tour);
  }
}
