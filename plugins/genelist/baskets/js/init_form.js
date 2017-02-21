$(function(){
						

	
	$("#formBarang").submit(function(){
		if(document.getElementById('namebarangid').value!=""){
		$.ajax({
			url:$(this).attr("action"),
			type:$(this).attr("method"),
			data:$(this).serialize(),
			success:function(data){
				if(data==1)
				{
					$("#content").load("plugins/genelist/baskets/listbarang.php");
					page=$(this).attr("href")
					$("#Formcontent").html("").unload(page);
					$("#cancelbtn").hide();
					return false
				}
				else
				{
					alert(data);
				}
			}
		});
		}else{
		alert('Please type in name to new gene list!');	
		}
		
		return false;
	});
	
})