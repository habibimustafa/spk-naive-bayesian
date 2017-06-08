function form_validation(){
	if($('#email').val()==''){
		$('#email').focus();
		$('.result').html('Email belum diisi!');
		$('.divresult').show('slow');
		return false;
	}else if($('#password').val()==''){
		$('#password').focus();
		$('.result').html('Password belum diisi!');
		$('.divresult').show('slow');
		return false;
	}
	return true;
}
function submitform(){
	if( form_validation() ){
		$.post('./mila-auth.php', {email: $('#email').val(), password: $('#password').val()},
			function(res){
				if(res == 1){
					location.href='./';
				}else{
					$('.result').html('Login gagal, email / password salah!');
					$('.divresult').show('slow');
				}
			}
		);
	}
}
$('.btn-login').click(function(){
	submitform();
	return false;
});
$(document).keyup(function(e){
	var code = e.keyCode || e.which;
	if (code == '13') submitform();
});