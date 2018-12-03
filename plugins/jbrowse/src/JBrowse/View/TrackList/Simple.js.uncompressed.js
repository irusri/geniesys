require({cache:{
'dojo/fx/easing':function(){
define("dojo/fx/easing", ["../_base/lang"], function(lang){

// module:
//		dojo/fx/easing

var easingFuncs = {
	// summary:
	//		Collection of easing functions to use beyond the default
	//		`dojo._defaultEasing` function.
	// description:
	//		Easing functions are used to manipulate the iteration through
	//		an `dojo.Animation`s _Line. _Line being the properties of an Animation,
	//		and the easing function progresses through that Line determining
	//		how quickly (or slowly) it should go. Or more accurately: modify
	//		the value of the _Line based on the percentage of animation completed.
	//
	//		All functions follow a simple naming convention of "ease type" + "when".
	//		If the name of the function ends in Out, the easing described appears
	//		towards the end of the animation. "In" means during the beginning,
	//		and InOut means both ranges of the Animation will applied, both
	//		beginning and end.
	//
	//		One does not call the easing function directly, it must be passed to
	//		the `easing` property of an animation.
	// example:
	//	|	dojo.require("dojo.fx.easing");
	//	|	var anim = dojo.fadeOut({
	//	|		node: 'node',
	//	|		duration: 2000,
	//	|		//	note there is no ()
	//	|		easing: dojo.fx.easing.quadIn
	//	|	}).play();
	//

	linear: function(/* Decimal? */n){
		// summary:
		//		A linear easing function
		return n;
	},

	quadIn: function(/* Decimal? */n){
		return Math.pow(n, 2);
	},

	quadOut: function(/* Decimal? */n){
		return n * (n - 2) * -1;
	},

	quadInOut: function(/* Decimal? */n){
		n = n * 2;
		if(n < 1){ return Math.pow(n, 2) / 2; }
		return -1 * ((--n) * (n - 2) - 1) / 2;
	},

	cubicIn: function(/* Decimal? */n){
		return Math.pow(n, 3);
	},

	cubicOut: function(/* Decimal? */n){
		return Math.pow(n - 1, 3) + 1;
	},

	cubicInOut: function(/* Decimal? */n){
		n = n * 2;
		if(n < 1){ return Math.pow(n, 3) / 2; }
		n -= 2;
		return (Math.pow(n, 3) + 2) / 2;
	},

	quartIn: function(/* Decimal? */n){
		return Math.pow(n, 4);
	},

	quartOut: function(/* Decimal? */n){
		return -1 * (Math.pow(n - 1, 4) - 1);
	},

	quartInOut: function(/* Decimal? */n){
		n = n * 2;
		if(n < 1){ return Math.pow(n, 4) / 2; }
		n -= 2;
		return -1 / 2 * (Math.pow(n, 4) - 2);
	},

	quintIn: function(/* Decimal? */n){
		return Math.pow(n, 5);
	},

	quintOut: function(/* Decimal? */n){
		return Math.pow(n - 1, 5) + 1;
	},

	quintInOut: function(/* Decimal? */n){
		n = n * 2;
		if(n < 1){ return Math.pow(n, 5) / 2; }
		n -= 2;
		return (Math.pow(n, 5) + 2) / 2;
	},

	sineIn: function(/* Decimal? */n){
		return -1 * Math.cos(n * (Math.PI / 2)) + 1;
	},

	sineOut: function(/* Decimal? */n){
		return Math.sin(n * (Math.PI / 2));
	},

	sineInOut: function(/* Decimal? */n){
		return -1 * (Math.cos(Math.PI * n) - 1) / 2;
	},

	expoIn: function(/* Decimal? */n){
		return (n == 0) ? 0 : Math.pow(2, 10 * (n - 1));
	},

	expoOut: function(/* Decimal? */n){
		return (n == 1) ? 1 : (-1 * Math.pow(2, -10 * n) + 1);
	},

	expoInOut: function(/* Decimal? */n){
		if(n == 0){ return 0; }
		if(n == 1){ return 1; }
		n = n * 2;
		if(n < 1){ return Math.pow(2, 10 * (n - 1)) / 2; }
		--n;
		return (-1 * Math.pow(2, -10 * n) + 2) / 2;
	},

	circIn: function(/* Decimal? */n){
		return -1 * (Math.sqrt(1 - Math.pow(n, 2)) - 1);
	},

	circOut: function(/* Decimal? */n){
		n = n - 1;
		return Math.sqrt(1 - Math.pow(n, 2));
	},

	circInOut: function(/* Decimal? */n){
		n = n * 2;
		if(n < 1){ return -1 / 2 * (Math.sqrt(1 - Math.pow(n, 2)) - 1); }
		n -= 2;
		return 1 / 2 * (Math.sqrt(1 - Math.pow(n, 2)) + 1);
	},

	backIn: function(/* Decimal? */n){
		// summary:
		//		An easing function that starts away from the target,
		//		and quickly accelerates towards the end value.
		//
		//		Use caution when the easing will cause values to become
		//		negative as some properties cannot be set to negative values.
		var s = 1.70158;
		return Math.pow(n, 2) * ((s + 1) * n - s);
	},

	backOut: function(/* Decimal? */n){
		// summary:
		//		An easing function that pops past the range briefly, and slowly comes back.
		// description:
		//		An easing function that pops past the range briefly, and slowly comes back.
		//
		//		Use caution when the easing will cause values to become negative as some
		//		properties cannot be set to negative values.

		n = n - 1;
		var s = 1.70158;
		return Math.pow(n, 2) * ((s + 1) * n + s) + 1;
	},

	backInOut: function(/* Decimal? */n){
		// summary:
		//		An easing function combining the effects of `backIn` and `backOut`
		// description:
		//		An easing function combining the effects of `backIn` and `backOut`.
		//		Use caution when the easing will cause values to become negative
		//		as some properties cannot be set to negative values.
		var s = 1.70158 * 1.525;
		n = n * 2;
		if(n < 1){ return (Math.pow(n, 2) * ((s + 1) * n - s)) / 2; }
		n-=2;
		return (Math.pow(n, 2) * ((s + 1) * n + s) + 2) / 2;
	},

	elasticIn: function(/* Decimal? */n){
		// summary:
		//		An easing function the elastically snaps from the start value
		// description:
		//		An easing function the elastically snaps from the start value
		//
		//		Use caution when the elasticity will cause values to become negative
		//		as some properties cannot be set to negative values.
		if(n == 0 || n == 1){ return n; }
		var p = .3;
		var s = p / 4;
		n = n - 1;
		return -1 * Math.pow(2, 10 * n) * Math.sin((n - s) * (2 * Math.PI) / p);
	},

	elasticOut: function(/* Decimal? */n){
		// summary:
		//		An easing function that elasticly snaps around the target value,
		//		near the end of the Animation
		// description:
		//		An easing function that elasticly snaps around the target value,
		//		near the end of the Animation
		//
		//		Use caution when the elasticity will cause values to become
		//		negative as some properties cannot be set to negative values.
		if(n==0 || n == 1){ return n; }
		var p = .3;
		var s = p / 4;
		return Math.pow(2, -10 * n) * Math.sin((n - s) * (2 * Math.PI) / p) + 1;
	},

	elasticInOut: function(/* Decimal? */n){
		// summary:
		//		An easing function that elasticly snaps around the value, near
		//		the beginning and end of the Animation.
		// description:
		//		An easing function that elasticly snaps around the value, near
		//		the beginning and end of the Animation.
		//
		//		Use caution when the elasticity will cause values to become
		//		negative as some properties cannot be set to negative values.
		if(n == 0) return 0;
		n = n * 2;
		if(n == 2) return 1;
		var p = .3 * 1.5;
		var s = p / 4;
		if(n < 1){
			n -= 1;
			return -.5 * (Math.pow(2, 10 * n) * Math.sin((n - s) * (2 * Math.PI) / p));
		}
		n -= 1;
		return .5 * (Math.pow(2, -10 * n) * Math.sin((n - s) * (2 * Math.PI) / p)) + 1;
	},

	bounceIn: function(/* Decimal? */n){
		// summary:
		//		An easing function that 'bounces' near the beginning of an Animation
		return (1 - easingFuncs.bounceOut(1 - n)); // Decimal
	},

	bounceOut: function(/* Decimal? */n){
		// summary:
		//		An easing function that 'bounces' near the end of an Animation
		var s = 7.5625;
		var p = 2.75;
		var l;
		if(n < (1 / p)){
			l = s * Math.pow(n, 2);
		}else if(n < (2 / p)){
			n -= (1.5 / p);
			l = s * Math.pow(n, 2) + .75;
		}else if(n < (2.5 / p)){
			n -= (2.25 / p);
			l = s * Math.pow(n, 2) + .9375;
		}else{
			n -= (2.625 / p);
			l = s * Math.pow(n, 2) + .984375;
		}
		return l;
	},

	bounceInOut: function(/* Decimal? */n){
		// summary:
		//		An easing function that 'bounces' at the beginning and end of the Animation
		if(n < 0.5){ return easingFuncs.bounceIn(n * 2) / 2; }
		return (easingFuncs.bounceOut(n * 2 - 1) / 2) + 0.5; // Decimal
	}
};

lang.setObject("dojo.fx.easing", easingFuncs);

return easingFuncs;
});

}}});
define("JBrowse/View/TrackList/Simple", ['dojo/_base/declare',
        'dojo/_base/array',
        'dojo/_base/event',
        'dojo/keys',
        'dojo/on',
        'dojo/dom-construct',
        'dojo/dom-class',
        'dijit/layout/ContentPane',
        'dojo/dnd/Source',
        'dojo/fx/easing',
        'dijit/form/TextBox',

        './_TextFilterMixin'
       ],
       function(
           declare,
           array,
           event,
           keys,
           on,
           dom,
           domClass,
           ContentPane,
           dndSource,
           animationEasing,
           dijitTextBox,

           _TextFilterMixin
       ) {

return declare( 'JBrowse.View.TrackList.Simple', _TextFilterMixin,

    /** @lends JBrowse.View.TrackList.Simple.prototype */
    {

    /**
     * Simple drag-and-drop track selector.
     * @constructs
     */
    constructor: function( args ) {
        this.browser = args.browser;

        // make the track list DOM nodes and widgets
        this.createTrackList( args.browser.container );

        // maintain a list of the HTML nodes of inactive tracks, so we
        // can flash them and whatnot
        this.inactiveTrackNodes = {};

        // populate our track list (in the right order)
        this.trackListWidget.insertNodes(
            false,
            args.trackConfigs
        );

        // subscribe to drop events for tracks being DND'ed
        this.browser.subscribe(
            "/dnd/drop",
            dojo.hitch( this,
                        function( source, nodes, copy, target ){
                            if( target !== this.trackListWidget )
                                return;

                            // get the configs from the tracks being dragged in
                            var confs = dojo.filter(
                                dojo.map( nodes, function(n) {
                                              return n.track && n.track.config;
                                          }
                                        ),
                                function(c) {return c;}
                            );

                            // return if no confs; whatever was
                            // dragged here probably wasn't a
                            // track
                            if( ! confs.length )
                                return;

                            this.dndDrop = true;
                            this.browser.publish( '/jbrowse/v1/v/tracks/hide', confs );
                            this.dndDrop = false;
                        }
                      ));

        // subscribe to commands coming from the the controller
        this.browser.subscribe( '/jbrowse/v1/c/tracks/show',
                                dojo.hitch( this, 'setTracksActive' ));
        this.browser.subscribe( '/jbrowse/v1/c/tracks/hide',
                                dojo.hitch( this, 'setTracksInactive' ));
        this.browser.subscribe( '/jbrowse/v1/c/tracks/new',
                                dojo.hitch( this, 'addTracks' ));
        this.browser.subscribe( '/jbrowse/v1/c/tracks/replace',
                                dojo.hitch( this, 'replaceTracks' ));
        this.browser.subscribe( '/jbrowse/v1/c/tracks/delete',
                                dojo.hitch( this, 'deleteTracks' ));
    },

    addTracks: function( trackConfigs ) {
        // note that new tracks are, by default, hidden, so we just put them in the list
        this.trackListWidget.insertNodes(
            false,
            trackConfigs
        );

        this._blinkTracks( trackConfigs );
    },

    replaceTracks: function( trackConfigs ) {
        // for each one
        array.forEach( trackConfigs, function( conf ) {
            var oldNode = this.inactiveTrackNodes[ conf.label ];
            if( ! oldNode )
                return;
            delete this.inactiveTrackNodes[ conf.label ];

            this.trackListWidget.delItem( oldNode.id );
            if( oldNode.parentNode )
                oldNode.parentNode.removeChild( oldNode );

           this.trackListWidget.insertNodes( false, [conf], false, oldNode.previousSibling );
       },this);
    },

    /** @private */
    createTrackList: function( renderTo ) {
        var leftPane = dojo.create(
            'div',
            { id: 'trackPane',
              className: 'jbrowseSimpleTrackSelector',
              style: { width: '12em' }
            },
            renderTo
        );

        //splitter on left side
        var leftWidget = new ContentPane({region: "left", splitter: true}, leftPane);

        var trackListDiv = this.div = this.containerNode = dojo.create(
            'div',
            { id: 'tracksAvail',
              className: 'container handles',
              style: { width: '100%', height: '100%', overflowX: 'hidden', overflowY: 'auto' },
              innerHTML: '<h2>Available Tracks</h2>'
            },
            leftPane
        );

        this._makeTextFilterNodes( trackListDiv );
        this._updateTextFilterControl();

        this.trackListWidget = new dndSource(
            trackListDiv,
            {
                accept: ["track"], // accepts only tracks into left div
                withHandles: false,
                creator: dojo.hitch( this, function( trackConfig, hint ) {
                    var key = trackConfig.key || trackConfig.name || trackConfig.label;
                    var node = dojo.create(
                        'div',
                        { className: 'tracklist-label',
                          title: key+' (drag or double-click to activate)',
                          innerHTML: key
                        }
                    );

                    //in the list, wrap the list item in a container for
                    //border drag-insertion-point monkeying
                    if ("avatar" != hint) {
                        on(node, "dblclick", dojo.hitch(this, function() {
                            this.browser.publish( '/jbrowse/v1/v/tracks/show', [trackConfig] );
                        }));

                        var container = dojo.create( 'div', { className: 'tracklist-container' });
                        container.appendChild(node);
                        node = container;
                        node.id = dojo.dnd.getUniqueId();
                        this.inactiveTrackNodes[trackConfig.label] = node;
                    }
                    return {node: node, data: trackConfig, type: ["track"]};
                })
            }
        );

        // The dojo onMouseDown and onMouseUp methods don't support the functionality we're looking for,
        // so we'll substitute our own
        this.trackListWidget.onMouseDown = dojo.hitch(this, "onMouseDown");
        this.trackListWidget.onMouseUp = dojo.hitch(this, "onMouseUp");

        // We want the escape key to deselect all tracks
        on(document, "keydown", dojo.hitch(this, "onKeyDown"));

        return trackListDiv;
    },

    onKeyDown: function(e) {
        switch(e.keyCode) {
          case keys.ESCAPE:
            this.trackListWidget.selectNone();
            break;
        }
    },

    onMouseDown: function(e) {
      var thisW = this.trackListWidget;
      if(!thisW.mouseDown && thisW._legalMouseDown(e)){
          thisW.mouseDown = true;
          thisW._lastX = e.pageX;
          thisW._lastY = e.pageY;
          this._onMouseDown(thisW.current, e);
      }
    },

    _onMouseDown: function(current, e) {
      if(!current) return;
      var thisW = this.trackListWidget;
      if(!e.ctrlKey && !e.shiftKey) {
          thisW.simpleSelection = true;
          if(!this._isSelected(current)) {
              thisW.selectNone();
              thisW.simpleSelection = false;
          }
      }
      if(e.shiftKey && this.anchor) {
          var i = 0;
          var nodes = thisW.getAllNodes();
          this._select(current);
          if(current != this.anchor) {
            for(; i < nodes.length; i++) {
                if(nodes[i] == this.anchor || nodes[i] == current) break;
            }
            i++;
            for(; i < nodes.length; i++) {
                if(nodes[i] == this.anchor || nodes[i] == current) break;
                this._select(nodes[i]);
            }
          }
      } else {
          e.ctrlKey ? this._toggle(current) : this._select(current);
          this.anchor = current;
      }
      event.stop(e);
    },

    onMouseUp: function(e) {
      var thisW = this.trackListWidget;
        if(thisW.mouseDown){
            thisW.mouseDown = false;
            this._onMouseUp(e);
        }
    },

    _onMouseUp: function(e) {
      var thisW = this.trackListWidget;
      if(thisW.simpleSelection && thisW.current) {
          thisW.selectNone();
          this._select(thisW.current);
      }
    },

    _isSelected: function(node) {
        return this.trackListWidget.selection[node.id];
    },

    _select: function(node) {
        this.trackListWidget.selection[node.id] = 1;
        this.trackListWidget._addItemClass(node, "Selected");
    },

    _deselect: function(node) {
        delete this.trackListWidget.selection[node.id];
        this.trackListWidget._removeItemClass(node, "Selected");
    },

    _toggle: function(node) {
        if(this.trackListWidget.selection[node.id]) {
          this._deselect(node);
        } else {
          this._select(node);
        }
    },

    /**
     * Given an array of track configs, update the track list to show
     * that they are turned on.  For this list, that just means
     * deleting them from our widget.
     */
    setTracksActive: function( /**Array[Object]*/ trackConfigs ) {
        this.deleteTracks( trackConfigs );
    },

    deleteTracks: function( /**Array[Object]*/ trackConfigs ) {
        // remove any tracks in our track list that are being set as visible
        array.forEach( trackConfigs || [], function( conf ) {
            var oldNode = this.inactiveTrackNodes[ conf.label ];
            if( ! oldNode )
                return;
            delete this.inactiveTrackNodes[ conf.label ];

            if( oldNode.parentNode )
                oldNode.parentNode.removeChild( oldNode );

            this.trackListWidget.delItem( oldNode.id );
        },this);
    },

    /**
     * Given an array of track configs, update the track list to show
     * that they are turned off.
     */
    setTracksInactive: function( /**Array[Object]*/ trackConfigs ) {

        // remove any tracks in our track list that are being set as visible
        if( ! this.dndDrop ) {
            var n = this.trackListWidget.insertNodes( false, trackConfigs );

            // blink the track(s) that we just turned off to make it
            // easier for users to tell where they went.
            // note that insertNodes will have put its html element in
            // inactivetracknodes
            this._blinkTracks( trackConfigs );
        }
    },

    _blinkTracks: function( trackConfigs ) {
            // scroll the tracklist all the way to the bottom so we can see the blinking nodes
            this.trackListWidget.node.scrollTop = this.trackListWidget.node.scrollHeight;

            array.forEach( trackConfigs, function(c) {
                var label = this.inactiveTrackNodes[c.label].firstChild;
                if( label ) {
                    dojo.animateProperty({
                                             node: label,
                                             duration: 400,
                                             properties: {
                                                 backgroundColor: { start: '#DEDEDE', end:  '#FFDE2B' }
                                             },
                                             easing: animationEasing.sine,
                                             repeat: 2,
                                             onEnd: function() {
                                                 label.style.backgroundColor = null;
                                             }
                                         }).play();
                }
            },this);
    },

    /**
     * Make the track selector visible.
     * This does nothing for the Simple track selector, since it is always visible.
     */
    show: function() {
    },

    /**
     * Make the track selector invisible.
     * This does nothing for the Simple track selector, since it is always visible.
     */
    hide: function() {
    },

    /**
     * Toggle visibility of this track selector.
     * This does nothing for the Simple track selector, since it is always visible.
     */
    toggle: function() {
    }

});
});