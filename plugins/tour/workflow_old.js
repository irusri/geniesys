/* ============ */
/* WORKFLOW HELP */
/* ============ */
/*Annotate GeneList*/
var w1 = {
    id: "w1h",
    showPrevButton: true,
    steps: [{
            title: "Gene search",
            content: "Type in gene id, descriptions or different annotations.    <br><strong>for example:</strong> Potri.018G142700.5, AT2G32080, POPTR_0001s03760 ",
            target: "myInputTextField",
            placement: "bottom",
        }, {
            target: "ToolTables_tblPrueba2_0",
            placement: "bottom",
            title: "Select Displayed Annotation",
            yOffset: 0,
            xOffset: -120,
            content: "Add or remove different annotation into the current search results using Select Displayed Annotation menu.",
        }, {
            target: "ToolTables_tblPrueba2_0",
            placement: "bottom",
            title: "Export table as TSV",
            yOffset: 0,
            content: "Export current search results into tab seperated file.",
        }, {
            target: "ToolTables_tblPrueba2_1",
            placement: "bottom",
            title: "Save all to active GeneList",
            yOffset: 0,
            content: "Save current search results into default GeneList.",
        }, {
            target: "ToolTables_tblPrueba2_2",
            placement: "bottom",
            title: "Save all to new GeneList",
            yOffset: 0,
            content: "It's possible to keep multiple GeneList at a time using Save all to new GeneList button.",
        }, {
            target: "ToolTables_tblPrueba2_3",
            placement: "bottom",
            title: "Remove selected from GeneList",
            yOffset: 0,
            content: "Remove selected genes from active GeneList.",
        }, {
            target: "ToolTables_tblPrueba2_4",
            placement: "left",
            title: "Empty GeneList",
            yOffset: 0,
            content: "Delete all genes from active GeneList.",
        }, {
            target: "ToolTables_tblPrueba2_5",
            placement: "left",
            title: "Share GeneList",
            yOffset: 0,
            content: "We can share the current search results with others or in publications using auto genarated url given by Sahre GeneList button.",
        }

    ]

}

/*Explore gene expression*/
var w2 = {
        id: "w2h",
        showPrevButton: true,
        steps: [{
            title: "Gene search",
            content: "Type in gene ids, descriptions or different annotations.    <br><strong>for example:</strong> Potri.018G142700.5, AT2G32080, POPTR_0001s03760 ",
            target: "myInputTextField",
            placement: "bottom",
        }, {
            target: "ToolTables_tblPrueba2_1",
            placement: "bottom",
            title: "Save all to active GeneList",
            yOffset: 0,
            content: "Save current search results into default GeneList.",
            multipage: true,
            onNext: function() {
                window.location = "http://popgenie.org/eximage?workflow=2"
            }
        }, {
            target: "inner-content",
            placement: "top",
            title: "exImage",
            content: "exImage provides pictographic view of expression data across a diverge range of spruce datasets.",

        }, {
            title: "Control panel",
            content: "Use control panel to change the input parameters and visualize the color changes in realtime.",
            target: "startTourBtn",
            placement: "left",
            xOffset: -40,
            multipage: true,
            onNext: function() {
                window.location = "http://popgenie.org/explot?workflow=2"
            },

        }, {
            title: "exPlot",
            content: "Plot the level of gene expression per selected genes and samples.",
            target: "inner-content",
            placement: "top",

        }, {
            title: "Control panel",
            content: "Use control panel to change the input parameters and manipulate the exPlot.",
            target: "startTourBtn",
            placement: "left",
            xOffset: -40,
            multipage: true,
            onNext: function() {
                window.location = "http://popgenie.org/exheatmap?workflow=2"
            },
        }, {
            title: "exHeatmap",
            content: "exHeatmap generates heatmap for gene expression per selected genes and samples.",
            target: "inner-content",
            placement: "top",

        }, {
            target: "extensive_help",
            placement: "left",
            title: "Help",
            content: "Click here to read detail help page.",
        }]

    }
    /*Explore co-expression*/
var w3 = {
        id: "w3h",
        showPrevButton: true,
        steps: [{
            title: "Gene search",
            content: "Type in gene ids, descriptions or different annotations.    <br><strong>for example:</strong> Potri.018G142700.5, AT2G32080, POPTR_0001s03760 ",
            target: "myInputTextField",
            placement: "bottom",
        }, {
            target: "ToolTables_tblPrueba2_1",
            placement: "bottom",
            title: "Save all to active GeneList",
            yOffset: 0,
            content: "Save current search results into default GeneList.",
            multipage: true,
            onNext: function() {
                window.location = "http://popgenie.org/exnet?workflow=3"
            }
        }, {
            target: "inner-content",
            placement: "top",
            title: "exNet",
            content: "exNet is an interactive tool for exploring co-expression networks.",

        }, {
            target: "extensive_help",
            placement: "left",
            title: "Help",
            content: "Click here to read detail help page.",

        }]

    }
    /*Explore conservation using genefamily analysis*/
var w4 = {
    id: "w4h",
    showPrevButton: true,
    steps: [{
            title: "Gene search",
            content: "Type in gene ids, descriptions or different annotations.    <br><strong>for example:</strong> Potri.018G142700.5, AT2G32080, POPTR_0001s03760 ",
            target: "myInputTextField",
            placement: "bottom",
        }, {
            title: "Gene search results",
            content: "Click next button or gene id to go to Gene Information page.",
            target: "tblPrueba2",
            placement: "top",
            multipage: true,
            onNext: function() {
                window.location = "http://popgenie.org/gene?id=Potri.001G009100&workflow=4#genefamily"
            }
        }, {
            target: "gf_table",
            placement: "top",
            title: "Gene Family",
            content: "Select few gene families.",
            onNext: function() {
                help_tool_tips()
            }

        }, {
            target: "download_tree",
            placement: "bottom",
            title: "Download Fasta",
            content: "Click here to download protein fasta file."

        }, {
            target: "download_fasta",
            placement: "bottom",
            title: "Create tree",
            content: "Click here to create Phylogeny tree with PlantGenIE Galaxy."

        }, {
            target: "download_tree1",
            placement: "left",
            title: "Create tree",
            content: "Click here to create Phylogeny tree with Phylogeny.fr."

        }

    ]

}

/*Explore conservation using ComPlEX*/
var w5 = {
    id: "w5h",
    showPrevButton: true,
    steps: [{
            title: "Gene search",
            content: "Type in gene ids, descriptions or different annotations.    <br><strong>for example:</strong> Potri.018G142700.5, AT2G32080, POPTR_0001s03760 ",
            target: "myInputTextField",
            placement: "bottom",
        }, {
            target: "ToolTables_tblPrueba2_2",
            placement: "bottom",

            title: "Save all to new active GeneList",
            yOffset: 0,
            content: "Save current search results into Complex GeneList.",
            multipage: true,
            onNext: function() {
                window.location = "http://complex.plantgenie.org?workflow=5"
            }
        },

        {
            title: "Select species",
            content: "Select correct species(P.trichocarpa) from drop down box",
            target: "sp_1",
            placement: "top",
        },

        {
            title: "Align selected genes",
            content: "Click Align P.trichocarpa to second sepecies button",
            target: "align_to_species_button",
            placement: "top",
        }, {
            title: "Help Tour",
            content: "Click help tour button for more information.",
            target: "startTourBtn",
            placement: "left",
        }



    ]

}

,
/* ========== */
/* WORKFLOW global */
/* ========== */
addClickListener = function(el, fn) {  
        if (el.addEventListener) {
            el.addEventListener('click', fn, false);
        } else {
            el.attachEvent('onclick', fn);
        }
    },

    strb = document.getElementById("str");



if (strb) {
    addClickListener(strb, function() { 
        if (!mannapperuma.isActive) {

        }
    });
} else {
    //  console.log(mannapperuma.getState() );
    if (mannapperuma.getState() === "w1h:1") {
        mannapperuma.startTour(w1);
    }
    if (mannapperuma.getState() === "w1h:2") {
        mannapperuma.startTour(w1);
    }
    if (mannapperuma.getState() === "w1h:3") {
        mannapperuma.startTour(w1);
    }
    if (mannapperuma.getState() === "w2h:1") {
        mannapperuma.startTour(w2);
    }
    if (mannapperuma.getState() === "w2h:2") {
        mannapperuma.startTour(w2);
    }
    if (mannapperuma.getState() === "w2h:3") {
        mannapperuma.startTour(w2);
    }
}