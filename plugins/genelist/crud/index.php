<html>
<head>
  <script type="text/javascript" src="http://v22.popgenie.org/v3/sm/jquery-1.4.3.min.js"></script>
<script type="text/javascript">
$(function(){
	$("a.add").click(function(){
		page=$(this).attr("href")
		$("#Formcontent").html("loading...").load(page);
		return false
	})
})
</script>
<style type="text/css">
body,html
{
	font-family:Arial, Helvetica, sans-serif;
	font-size:10px;
}
</style>
</head>

<body>
<div id="Formcontent"></div>
<a href="http://v3.popgenie.org/crud/formbarang.php?action=add" class="add">add item</a>
<br /><br />

<div id="content"><?php include("/mnt/spruce/www/v3/crud/listbarang.php");?></div>
</body>
</html>
