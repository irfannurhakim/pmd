function home(){
	$.ajax({
		url: '<?php echo base_url();?>home'
	})
	.done(function(response, textStatus, jqhr){
		//initView('user-management-list-user','Enterprise Asset Management | User List');
		$('#home-index').html(response);
	}) 
	.fail(function(e){

	});
}