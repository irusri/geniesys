  <div style="height:1000px">

    <link rel="stylesheet" type="text/css" href="plugins/jbrowse/genome.css">
    <script type="text/javascript" src="plugins/jbrowse/src/dojo/dojo.js" data-dojo-config="async: 1, baseUrl: './plugins/jbrowse/src'"></script>
    <script type="text/javascript" src="plugins/jbrowse/src/JBrowse/init.js"></script>
     
    <script type="text/javascript">
	
        window.onerror=function(msg){
            if( document.body )
                document.body.setAttribute("JSError",msg);
        }

        // puts the main Browser object in this for convenience.  feel
        // free to move it into function scope if you want to keep it
        // out of the global namespace
        var JBrowse;
        require(['JBrowse/Browser', 'dojo/io-query', 'dojo/json' ],
             function (Browser,ioQuery,JSON) {
                   // the initial configuration of this JBrowse
                   // instance

                   // NOTE: this initial config is the same as any
                   // other JBrowse config in any other file.  this
                   // one just sets defaults from URL query params.
                   // If you are embedding JBrowse in some other app,
                   // you might as well just set this initial config
                   // to something like { include: '../my/dynamic/conf.json' },
                   // or you could put the entire
                   // dynamically-generated JBrowse config here.

                   // parse the query vars in the page URL
                   var queryParams = ioQuery.queryToObject( window.location.search.slice(1) );

                   var config = {
                       containerID: "GenomeBrowser",

                       dataRoot: queryParams.data,
                       queryParams: queryParams,
                       location: queryParams.loc,
                       forceTracks: queryParams.tracks,
                       initialHighlight: queryParams.highlight,
                       show_nav: queryParams.nav,
                       show_tracklist: queryParams.tracklist,
                       show_overview: queryParams.overview,
                       show_menu: queryParams.menu,
                       stores: { url: { type: "JBrowse/Store/SeqFeature/FromConfig", features: [] } },
                       makeFullViewURL: function( browser ) {

                           // the URL for the 'Full view' link
                           // in embedded mode should be the current
                           // view URL, except with 'nav', 'tracklist',
                           // and 'overview' parameters forced to 1.

                           return browser.makeCurrentViewURL({ nav: 1, tracklist: 1, overview: 1 });
                       },
                       updateBrowserURL: true
                   };

                   //if there is ?addFeatures in the query params,
                   //define a store for data from the URL
                   if( queryParams.addFeatures ) {
                       config.stores.url.features = JSON.parse( queryParams.addFeatures );
                   }

                   // if there is ?addTracks in the query params, add
                   // those track configurations to our initial
                   // configuration
                   if( queryParams.addTracks ) {
                       config.tracks = JSON.parse( queryParams.addTracks );
                   }

                   // if there is ?addStores in the query params, add
                   // those store configurations to our initial
                   // configuration
                   if( queryParams.addStores ) {
                       config.stores = JSON.parse( queryParams.addStores );
                   }

                   // create a JBrowse global variable holding the JBrowse instance
                   JBrowse = new Browser( config );
        });
    </script>

<div id="alert-error" class="alert alert-error">
  <a onclick="closeme_tip()" class="close" data-dismiss="alert">×</a>
  <strong>By default, necessary files have been installed into the system. However, you need to configure the JBrowse configuration file and add relevant data into it. </strong><br>Please follow the <a target="_blank"  href="https://geniesys.readthedocs.io/en/latest/plugins/jbrowse.html">GenIE-Sys installation guide</a> and <a target="_blank" href="http://gmod.org/wiki/JBrowse_Configuration_Guide">JBrowse documentation</a> .
  </div>

    <div id="GenomeBrowser" style="height: 100%; width: 97%; padding: 0; border: 0;margin-left: -30px;margin-top: -20px; background: #fff;"></div>
    <!-- Added 'background: #fff' to hide background image in browser, David -->
    <div style="display: none">JBrowseDefaultMainPage</div>
  </div>
