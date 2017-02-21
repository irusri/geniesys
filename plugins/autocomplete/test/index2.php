<?php

?>

<!DOCTYPE html>
        <html lang="en">

        <head>
    <meta charset="utf-8">
    <title>jQuery UI Autocomplete - Remote JSONP datasource</title>
    <link rel="stylesheet" href="jqueryui.com/themes/base/jquery.ui.all.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js" type="text/javascript"></script>

    <style>
    .ui-autocomplete-loading { background: #CCCCCC  right center no-repeat; }
    #city { width: 25em; }
    </style>

    <script>
	
	$.widget( "custom.catcomplete", $.ui.autocomplete, {
		_renderMenu: function( ul, items ) {
			var that = this,
				currentCategory = "";
			$.each( items, function( index, item ) {
				if ( item.category != currentCategory ) {
					ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
					currentCategory = item.category;
				}
				that._renderItem( ul, item );
			});
		}
	});
	
	
    $(function() {
        function log( message ) {
            $( "<div/>" ).text( message ).prependTo( "#log" );
            $( "#log" ).scrollTop( 0 );
        }

        $( "#city" ).catcomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "search2.php",
                    dataType: "jsonp",
                    data: {
                        featureClass: "q",
                        style: "full",
                        maxRows: 12,
                        name_startsWith: request.term
                    },
                    success: function( data ) {
                        response( ( data, function( item ) {
                            return {
                                label: item.label + (item.value ? ", " + item.value : "") + ", " + item.category,
                                value: item.value
                            }
                        }));
                    }
                });
            },
            minLength: 2,
            select: function( event, ui ) {
                log( ui.item ?
                    "Selected: " + ui.item.label :
                    "Nothing selected, input was " + this.value);
            },
            open: function() {
                $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
            },
            close: function() {
                $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
            }
        });
    });
    </script>
</head>
<body>

<div class="demo">

<div class="ui-widget">
    <label for="city">Your city: </label>
    <input id="city" />
    Powered by <a href="http://geonames.org">geonames.org</a>
</div>

<div class="ui-widget" style="margin-top:2em; font-family:Arial">
    Result:
    <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
</div>

</div><!-- End demo -->



<div class="demo-description">
<p>The Autocomplete widgets provides suggestions while you type into the field. Here the suggestions are cities, displayed when at least two characters are entered into the field.</p>
<p>In this case, the datasource is the <a href="http://geonames.org">geonames.org webservice</a>. While only the city name itself ends up in the input after selecting an element, more info is displayed in the suggestions to help find the right entry. That data is also available in callbacks, as illustrated by the Result area below the input.</p>
</div><!-- End demo-description -->

</body>
</html>