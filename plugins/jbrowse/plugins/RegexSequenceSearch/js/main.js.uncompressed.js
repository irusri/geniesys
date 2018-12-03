require({cache:{
'JBrowse/Plugin':function(){
define("JBrowse/Plugin", [
           'dojo/_base/declare',
           'JBrowse/Component'
       ],
       function( declare, Component ) {
return declare( Component,
{
    constructor: function( args ) {
        this.name = args.name;
        this.cssLoaded = args.cssLoaded;
        this._finalizeConfig( args.config );
    },

    _defaultConfig: function() {
        return {
            baseUrl: '/plugins/'+this.name
        };
    }
});
});
},
'RegexSequenceSearch/View/SearchSeqDialog':function(){
define([
        'dojo/_base/declare',
        'dojo/dom-construct',
        'dojo/aspect',
        'dijit/focus',
        'dijit/form/Button',
        'dijit/form/RadioButton',
        'dijit/form/CheckBox',
        'dijit/form/TextBox',
        'JBrowse/View/Dialog/WithActionBar'
    ],
    function(
        declare,
        dom,
        aspect,
        focus,
        dButton,
        dRButton,
        dCheckBox,
        dTextBox,
        ActionBarDialog
    ) {

return declare( ActionBarDialog, {

    constructor: function() {
        var thisB = this;
        aspect.after( this, 'hide', function() {
              focus.curNode && focus.curNode.blur();
              setTimeout( function() { thisB.destroyRecursive(); }, 500 );
        });
    },

    _dialogContent: function () {
        var content = this.content = {};

        var container = dom.create('div', { className: 'search-dialog' } );

        var introdiv = dom.create('div', {
            className: 'search-dialog intro',
            innerHTML: 'This tool creates tracks showing regions of the reference sequence (or its translations) that match a given DNA or amino acid sequence.'
        }, container );

        // Render text box
        var searchBoxDiv = dom.create('div', {
            className: "section"
        }, container );
        dom.create( 'span', {
                        className: "header",
                        innerHTML: "Search for"
                    }, searchBoxDiv );
        var translateDiv = dom.create("div", {
            className: "translateContainer"
        }, searchBoxDiv );
        function makeRadio( args, parent ) {
            var label = dom.create('label', {}, parent );
            var radio = new dRButton( args ).placeAt( label );
            dom.create('span', { innerHTML: args.label }, label );
            return radio;
        }
        makeRadio( { name: 'translate', value: 'no', label: 'DNA', checked: true }, translateDiv );
        content.translate = makeRadio( { name: 'translate', value: 'yes', label: 'AA' }, translateDiv );

        content.searchBox = new dTextBox({}).placeAt( searchBoxDiv );

        // Render 'ignore case' checkbox
        var textOptionsDiv = dom.create('div', {
            className: "section"
        }, container );

        var caseDiv = dom.create("div", {
            className: "checkboxdiv"
        }, textOptionsDiv );
        content.caseIgnore = new dCheckBox({ label: "Ignore case",
                                               id: "search_ignore_case",
                                               checked: true
                                            });
        caseDiv.appendChild( content.caseIgnore.domNode );
        dom.create( "label", { "for": "search_ignore_case", innerHTML: "Ignore Case"}, caseDiv );



        // Render 'treat as regex' checkbox
        var regexDiv = dom.create("div", {
            className: "checkboxdiv"
        }, textOptionsDiv );
        content.regex = new dCheckBox({
                                        label: "Treat as regular expression",
                                        id: "search_as_regex"
                                    }).placeAt( regexDiv );
        dom.create( "label", { "for": "search_as_regex", innerHTML: "Treat as regular expression" }, regexDiv );

        // Render 'forward strand' and 'reverse strand' checkboxes
        var strandsDiv = dom.create( 'div', {
            className: "section"
        }, container );
        dom.create( "span", {
            className: "header",
            innerHTML: "Search strands"
        }, strandsDiv );

        var fwdDiv = dom.create("div", {
            className: "checkboxdiv"
        });
        content.fwdStrand = new dCheckBox({
                                                id: "search_fwdstrand",
                                                checked: true
                                            });
        var revDiv = dom.create("div", {
            className: "checkboxdiv"
        });
        content.revStrand = new dCheckBox({
                                                id: "search_revstrand",
                                                checked: true
                                            });
        fwdDiv.appendChild( content.fwdStrand.domNode );
        dom.create( "label", { "for": "search_fwdstrand", innerHTML: "Forward"}, fwdDiv );
        revDiv.appendChild( content.revStrand.domNode );
        dom.create( "label", { "for": "search_revstrand", innerHTML: "Reverse"}, revDiv );
        strandsDiv.appendChild( fwdDiv );
        strandsDiv.appendChild( revDiv );

        return container;
    },

    _getSearchParams: function() {
        var content = this.content;
        return {
            expr: content.searchBox.get('value'),
            regex: content.regex.checked,
            caseIgnore: content.caseIgnore.checked,
            translate: content.translate.checked,
            fwdStrand: content.fwdStrand.checked,
            revStrand: content.revStrand.checked,
            maxLen: 100
        };
    },

    _fillActionBar: function ( actionBar ) {
        var thisB = this;

        new dButton({
                            label: 'Search',
                            iconClass: 'dijitIconBookmark',
                            onClick: function() {
                                var searchParams = thisB._getSearchParams();
                                thisB.callback( searchParams );
                                thisB.hide();
                            }
                        })
            .placeAt( actionBar );
        new dButton({
                            label: 'Cancel',
                            iconClass: 'dijitIconDelete',
                            onClick: function() {
                                thisB.callback( false );
                                thisB.hide();
                            }
                        })
            .placeAt( actionBar );
    },

    show: function ( callback ) {
        this.callback = callback || function() {};
        this.set( 'title', "Add sequence search track");
        this.set( 'content', this._dialogContent() );
        this.inherited( arguments );
        focus.focus( this.closeButtonNode );
    }

});
});
},
'RegexSequenceSearch/Store/SeqFeature/RegexSearch':function(){
define([
        'dojo/_base/declare',
        'dojo/_base/array',
        'dojo/_base/lang',
        'JBrowse/Store/SeqFeature',
        'JBrowse/Model/SimpleFeature',
        'JBrowse/Errors',
        'JBrowse/Util',
        'JBrowse/CodonTable'
    ],
    function(
        declare,
        array,
        lang,
        SeqFeatureStore,
        SimpleFeature,
        JBrowseErrors,
        Util,
        CodonTable
    ) {


    return declare( SeqFeatureStore , {

        constructor: function( args ) {
            this.searchParams = args.searchParams;
        },

        _defaultConfig: function() {
            return Util.deepUpdate(
                dojo.clone( this.inherited(arguments) ),
                {
                    regionSizeLimit: 200000 // 200kb
                });
        },

        getFeatures: function( query, featCallback, doneCallback, errorCallback ) {
            var searchParams = lang.mixin(
                // store the original query bounds - this helps prevent features from randomly disappearing
                { orig: { start: query.start, end: query.end }},
                this.searchParams,
                query.searchParams
            );

            var regionSize = query.end - query.start;
            if( regionSize > this.config.regionSizeLimit )
                throw new JBrowseErrors.DataOverflow( 'Region too large to search' );

            var thisB = this;
            this.browser.getStore('refseqs', function( refSeqStore ) {
                if( refSeqStore )
                    refSeqStore.getReferenceSequence(
                        query,
                        function( sequence ) {
                            thisB.doSearch( query, sequence, searchParams, featCallback );
                            doneCallback();
                        },
                        errorCallback
                    );
                 else
                     doneCallback();
             });
        },

        doSearch: function( query, sequence, params, featCallback ) {
            var expr = new RegExp(
                params.regex ? params.expr : this.escapeString( params.expr ),
                params.caseIgnore ? "gi" : "g"
            );

            var sequences = [];
            if( params.fwdStrand )
                sequences.push( [sequence,1] );
            if( params.revStrand )
                sequences.push( [Util.revcom( sequence ),-1] );

            array.forEach( sequences, function( r ) {
                if( params.translate ) {
                    for( var frameOffset = 0; frameOffset < 3; frameOffset++ ) {
                        this._searchSequence( query, r[0], expr, r[1], featCallback, true, frameOffset );
                    }
                } else {
                    this._searchSequence( query, r[0], expr, r[1], featCallback );
                }
            }, this );
        },

        _searchSequence: function( query, sequence, expr, strand, featCallback, translated, frameOffset ) {
            if( translated )
                sequence = this.translateSequence( sequence, frameOffset );

            frameOffset = frameOffset || 0;
            var multiplier = translated ? 3 : 1;

            var start = query.start, end = query.end;

            var features = [];
            var match;
            while( (match = expr.exec( sequence )) !== null && match.length ) {
                expr.lastIndex = match.index + 1;

                var result = match[0];

                var newStart = strand > 0 ? start + frameOffset + multiplier*match.index
                    : end - frameOffset - multiplier*(match.index + result.length);
                var newEnd = strand > 0 ? start + frameOffset + multiplier*(match.index + result.length)
                    : end - frameOffset - multiplier*match.index;

                var newFeat = new SimpleFeature(
                    {
                        data: {
                            start: newStart,
                            end: newEnd,
                            searchMatch: result,
                            strand: strand
                        },
                        id: [newStart,newEnd,result].join(',')
                    });
                featCallback( newFeat );
            }
        },

        translateSequence: function( sequence, frameOffset ) {
            var slicedSeq = sequence.slice( frameOffset );
            slicedSeq = slicedSeq.slice( 0, Math.floor( slicedSeq.length / 3 ) * 3);

            var translated = "";
            for(var i = 0; i < slicedSeq.length; i += 3) {
                var nextCodon = slicedSeq.slice(i, i + 3);
                translated = translated + CodonTable[nextCodon];
            }

            return translated;
        },

        escapeString: function( str ) {
            return (str+'').replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
        }

    });
});
}}});
define("RegexSequenceSearch/main", [
           'dojo/_base/declare',
           'dojo/_base/lang',
           'dojo/Deferred',
            'dijit/MenuItem',
           'JBrowse/Plugin',
           './View/SearchSeqDialog'
       ],
       function(
           declare,
           lang,
           Deferred,
           dijitMenuItem,
           JBrowsePlugin,
           SearchSeqDialog
       ) {
return declare( JBrowsePlugin,
{
    constructor: function( args ) {
        this._searchTrackCount = 0;

        var thisB = this;
        this.browser.afterMilestone('initView', function() {
            this.browser.addGlobalMenuItem( 'file', new dijitMenuItem(
                                           {
                                               label: 'Add sequence search track',
                                               iconClass: 'dijitIconBookmark',
                                               onClick: lang.hitch(this, 'createSearchTrack')
                                           }));
        }, this );

    },

    createSearchTrack: function() {

        var searchDialog = new SearchSeqDialog();
        var thisB = this;
        searchDialog.show(
            function( searchParams ) {
                if( !searchParams )
                    return;

                var storeConf = {
                    browser: thisB.browser,
                    refSeq: thisB.browser.refSeq,
                    type: 'RegexSequenceSearch/Store/SeqFeature/RegexSearch',
                    searchParams: searchParams
                };
                var storeName = thisB.browser.addStoreConfig( undefined, storeConf );
                storeConf.name = storeName;
                var searchTrackConfig = {
                    type: 'JBrowse/View/Track/CanvasFeatures',
                    label: 'search_track_' + (thisB._searchTrackCount++),
                    key: "Search reference sequence for '" + searchParams.expr + "'",
                    metadata: {
                        category: 'Local tracks',
                        Description: "Contains all matches of the text string/regular expression '" + storeConf.searchExpr + "'"
                    },
                    store: storeName
                };

                // send out a message about how the user wants to create the new track
                thisB.browser.publish( '/jbrowse/v1/v/tracks/new', [searchTrackConfig] );

                // Open the track immediately
                thisB.browser.publish( '/jbrowse/v1/v/tracks/show', [searchTrackConfig] );
            });
}

});
});
