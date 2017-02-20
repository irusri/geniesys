<div id='msg_box'>
	Data saved !
</div>
<style type="text/css">
		#msg_box{
			background: #16A6B6;
			color: #fff;
			padding-top: 25px;
			padding-bottom: 25px;
			width: 180px;
			text-align: center;
			margin: 0 auto;
			box-shadow: 5px 5px 5px #000;
			position: fixed;
			top: 50%;
			left: 50%;
			margin-top: -100px;
			margin-left: -250px;
			font-size: 18px;
			display: none;
		}

		#btn_submit{
			margin-top:10px;
			background:#DCDCDC;
			padding:10px;
			cursor:pointer;
			background:#D7D8D7;
			text-transform: capitalize;
		}
</style>

<script type="text/javascript">
	function show_msg(){
		var $div2 = $("#msg_box");
		if ($div2.is(":visible")) { return; }
		$div2.show();
		setTimeout(function() {
		$div2.hide();
		}, 1000);
	}

</script>