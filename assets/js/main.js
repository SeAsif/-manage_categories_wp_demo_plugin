jQuery(document).ready(function($) {
	alert(1)
	var categorie_name=$("#categorie_name");
	categorie_name.change(function(){
		$("#showurl").empty();
		var option= $("#categorie_name option:selected");
		var new_url='<a href="'+$.trim(option.val())+'" target="_blank">'+option.text()+'</a>';
		$( new_url ).appendTo( "#showurl" );
		console.log(new_url);
		
	});
	
});
   