function save(key){
	val = CKEDITOR.instances.editor.getData();

	$.post('editText.php', {fieldname: key, content: val}).done(function(data){
		show_msg();
		
	});
}