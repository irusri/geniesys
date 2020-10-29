/* ============ */
/* ConGenIE HELP */
/* ============ */
var tour = {
  id: "congenie-help",
  showPrevButton: true,
  steps: [
    {
      title: "Autocomplete search input",
      content: "Here you can search gene ids.    e.g. MA_75204g0010",
      target: "search2",
      placement: "bottom",
    },
	{
      title: "Tools",
      content: "GBrowse,BLAST,ePlant,exPlot and GeneSearch tools are listed here",
      target: "primary_menu_bar",
      placement: "top",
	  xOffset:30
    },
	{
      title: "Projects",
      content: "Read more information about ConGenIE and Spruce genome project.",
      target: "primary_menu_bar",
      placement: "top",
	  xOffset:130
    },
	{
      title: "Downloads",
      content: "Download the latest Spruce genome assembly or much more data.",
      target: "primary_menu_bar",
      placement: "top",
	  xOffset:230
    },
	{
      title: "Help",
      content: "Detail help pages and screencasts about how to use ConGenIE tools.",
      target: "primary_menu_bar",
      placement: "top",
	  xOffset:370
    },
	
	
	{
      title: "Report a Bug",
      content: "Report an error or contact us.",
      target: "bug",
      placement: "left",
    },
	{
      title: "Tool Navigator",
      content: "Overview and basic features about tools.",
      target: "node-37",
      placement: "left",
	  xOffset:100,
	    yOffset:40
    },
	
	{
      title: "Stats",
      content: "ConGenIE site hits using Google Analytics.",
      target: "stats",
      placement: "top",
    }
	
	
	
  ]
  
},
/* ========== */
/* ConGenIe global */
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
	if (!hopscotch.isActive) {
      hopscotch.startTour(tour);
    }
  });
}
else {
	console.log(hopscotch.getState() );
	 if (hopscotch.getState() === "congenie-help:1") {
		hopscotch.startTour(tour);
	  }
	  if (hopscotch.getState() === "congenie-help:2") {
		hopscotch.startTour(tour);
	  }
	  if (hopscotch.getState() === "congenie-help:3") {
		hopscotch.startTour(tour);
	  }
}