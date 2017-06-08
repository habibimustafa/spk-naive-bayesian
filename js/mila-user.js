function form_validation(){
	if($('#nim').val()==''){
		$('#nim').focus();
		$('.result').html('NIM belum diisi!');
		$('.divresult').show('slow');
		return false;
	}else {
		return true;
	}
}
function submitform(){
	if( form_validation() ){
		$.post('./mila-user-auth.php', {nim: $('#nim').val()},
			function(res){
				if(res == 0){
					$('.result').html('NIM yang Anda masukkan tidak terdaftar!');
					$('.divresult').show('slow');
				}else{
					$('.container').hide();
					$('.container').html(res);
					$('.container').show('slow');
				}
			}
		);
	}
}
$('.btn-cek').click(function(){
	submitform();
	return false;
});
$(document).keyup(function(e){
	var code = e.keyCode || e.which;
	if (code == '13') submitform();
});