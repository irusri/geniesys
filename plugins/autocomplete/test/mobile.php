<?php
?>

<html>
<head>
<title>ConGenIE mobile</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/latest/jquery.mobile.min.css" />
    <link rel="stylesheet" type="text/css" href="../lib/jquery.autocomplete.css">
<script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/mobile/latest/jquery.mobile.min.js"></script>
   <script type="text/javascript" src="../lib/jquery.autocomplete.js"></script>


<script>
$(function() {

    $("#ac1").autocomplete('search.php', {
        minChars: 3
    });

    $("#flush").click(function() {
        var ac = $("#ac1").data('autocompleter');
        if (ac && $.isFunction(ac.cacheFlush)) {
            ac.cacheFlush();
        } else {
            alert('Error flushing cache');
        }
    });

    $("#ac2").autocomplete({
        url: 'search.php?output=json',
        sortFunction: function(a, b, filter) {
            var f = filter.toLowerCase();
            var fl = f.length;
            var a1 = a.value.toLowerCase().substring(0, fl) == f ? '0' : '1';
            var a1 = a1 + String(a.data[0]).toLowerCase();
            var b1 = b.value.toLowerCase().substring(0, fl) == f ? '0' : '1';
            var b1 = b1 + String(b.data[0]).toLowerCase();
            if (a1 > b1) {
                return 1;
            }
            if (a1 < b1) {
                return -1;
            }
            return 0;
        },
        showResult: function(value, data) {
            return '<span style="color:red">' + value + '</span>';
        },
        onItemSelect: function(item) {
            var text = 'You selected <b>' + item.value + '</b>';
            if (item.data.length) {
                text += ' <i>' + item.data.join(', ') + '</i>';
            }
            $("#last_selected").html(text);
        },
        mustMatch: true,
        maxItemsToShow: 5,
        selectFirst: false,
        autoFill: false,
        selectOnly: true,
        remoteDataType: 'json'
    });

    $("#ac3").autocomplete({
        data: [
            ['apple', 1],
            ['apricot', 2],
            ['pear', 3],
            ['prume', 4],
            ['Doyenné du Comice', 5]
        ]
    });

    $("#ac4").autocomplete({
        url: 'search.php',
        useCache: false,
        filterResults: false
    });

    $("#ac5").autocomplete('search.php', {
        minChars: 1,
        useDelimiter: true,
        selectFirst: true,
        autoFill: true,
    });

    $("#toggle").click(function() {
        $("#hide").toggle(); // To test repositioning
    });

    $("#ac6").autocomplete('search.php?output=json', {
        remoteDataType: 'json',
		 useCache: true,
        processData: function(data) {
			var i, processed = [];
			for (i=0; i < data.length; i++) {
				processed.push([data[i][0] + " - " + data[i][1] + " - " + data[i][2]]);
			}
			return processed;
        }
    });

    $("#ac7").autocomplete({
        data: [
            ['Chico Marx'],
            ['Harpo Marx'],
            ['Groucho Marx'],
        ],
        filter: function(result, filter) {
            var s = result.value.toLowerCase();
            var f = filter.toLowerCase();
            var p = s.indexOf(f);
            if (p >= 0) {
                // Start of text or after a whitespace
                return p === 0 || !$.trim(s.substr(p - 1, 1));
            }
            return false;
        }
    });

});

    </script>

</head>

<body>






<div data-role="page" id="mainPage">


	<div data-role="header">
		<h1>ConGenIE </h1>
	</div>

	<div data-role="content">


 <form>
        <input type="text" id="ac6" placeholder="Search">
        <ul id="suggestions" data-role="listview" data-inset="true"></ul>
    </form>



		

	</div>

	<div data-role="footer">
		<h4></h4>
	</div>

</div>



</body>
</html>
