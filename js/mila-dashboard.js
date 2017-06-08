/*
Please consider that the JS part isn't production ready at all, I just code it to show the concept of merging filters and titles together !
*/
$(document).ready(function(){
	$.fn.serializeObject = function()
	{
	   var o = {};
	   var a = this.serializeArray();
	   $.each(a, function() {
		   if (o[this.name]) {
			   if (!o[this.name].push) {
				   o[this.name] = [o[this.name]];
			   }
			   o[this.name].push(this.value || '');
		   } else {
			   o[this.name] = this.value || '';
		   }
	   });
	   return o;
	};
	
	//$('.btn-toggle').click(function() {
	$(document).on('click', '.btn-toggle', function() {
		/*
		$(this).find('.btn').toggleClass('active');  
		
		if ($(this).find('.btn-primary').size()>0) {
			$(this).find('.btn').toggleClass('btn-primary');
		}
		if ($(this).find('.btn-danger').size()>0) {
			$(this).find('.btn').toggleClass('btn-danger');
		}
		if ($(this).find('.btn-success').size()>0) {
			$(this).find('.btn').toggleClass('btn-success');
		}
		if ($(this).find('.btn-info').size()>0) {
			$(this).find('.btn').toggleClass('btn-info');
		}
		
		$(this).find('.btn').toggleClass('btn-default');
		*/
		
		$(this).find('.btn').addClass('btn-default');
		
		if ($(this).find('.btn-primary').size()>0) {
			$(this).find('.btn-primary').toggleClass('btn-primary');
			$(this).find('.btn.active').toggleClass('btn-primary');
		}
		if ($(this).find('.btn-danger').size()>0) {
			$(this).find('.btn-danger').toggleClass('btn-danger');
			$(this).find('.btn.active').toggleClass('btn-danger');
		}
		if ($(this).find('.btn-success').size()>0) {
			$(this).find('.btn-success').toggleClass('btn-success');
			$(this).find('.btn.active').toggleClass('btn-success');
		}
		if ($(this).find('.btn-info').size()>0) {
			$(this).find('.btn-info').toggleClass('btn-info');
			$(this).find('.btn.active').toggleClass('btn-info');
		}
		
		$(this).find('.btn.active').toggleClass('btn-default');
	}); 
	
	$('#sample').dataTable();
	
	//$('.filterable .btn-filter').click(function(){
	$(document).on('click', '.filterable .btn-filter', function() {
        var $panel = $(this).parents('.filterable'),
        $filters = $panel.find('.filters input'),
        $tbody = $panel.find('.table tbody');
        if ($filters.prop('disabled') == true) {
            $filters.prop('disabled', false);
            $filters.first().focus();
        } else {
            $filters.val('').prop('disabled', true);
            $tbody.find('.no-result').remove();
            $tbody.find('tr').show();
        }
    });

    //$('.filterable .filters input').keyup(function(e){
    $(document).on('keyup', '.filterable .filters input', function(e) {
        /* Ignore tab key */
        var code = e.keyCode || e.which;
        if (code == '9') return;
        /* Useful DOM data and selectors */
        var $input = $(this),
        inputContent = $input.val().toLowerCase(),
        $panel = $input.parents('.filterable'),
        column = $panel.find('.filters th').index($input.parents('th')),
        $table = $panel.find('.table'),
        $rows = $table.find('tbody tr');
        /* Dirtiest filter function ever ;) */
        var $filteredRows = $rows.filter(function(){
            var value = $(this).find('td').eq(column).text().toLowerCase();
            return value.indexOf(inputContent) === -1;
        });
        /* Clean previous no-result if exist */
        $table.find('tbody .no-result').remove();
        /* Show all rows, hide filtered ones (never do that outside of a demo ! xD) */
        $rows.show();
        $filteredRows.hide();
        /* Prepend no-result row if all rows are filtered */
        if ($filteredRows.length === $rows.length) {
            $table.find('tbody').prepend($('<tr class="no-result text-center"><td colspan="'+ $table.find('.filters th').length +'">No result found</td></tr>'));
        }
    });
	
    $('#myCarousel').carousel({
    	interval:   4000
	});
	
	var clickEvent = false;
	$('#myCarousel').on('click', '.nav a', function() {
			clickEvent = true;
			$('.nav li').removeClass('active');
			$(this).parent().addClass('active');		
	}).on('slid.bs.carousel', function(e) {
		if(!clickEvent) {
			var count = $('.nav').children().length-1;
			var current = $('.nav li.active');
			current.removeClass('active').next().addClass('active');
			var id = parseInt(current.data('slide-to'));
			if(count == id) {
				$('.nav li').first().addClass('active');	
			}
		}
		clickEvent = false;
	});

	$('#accordion td a').click(function(){
		$.post('./mila-route.php', {target: $(this).text()},
			function(res){
				$('.well').hide();
				$('.well').html(res);
				$('.well').show('slow');
			}
		);
		return false;
	});
	
	$('.navbar ul.nav li:not(.dropdown) a[href$="#"]').click(function(){
		$.post('./mila-route.php', {target: $(this).text()},
			function(res){
				$('.well').hide();
				$('.well').html(res);
				$('.well').show('slow');
			}
		);
		return false;
	});
	
	$(document).on('click', '.btn-baru', function() {
		var page = $('#main h3.panel-title').text();
		$.post('./mila-route.php', {target: page, view: "new"},
			function(res){
				$('.well').hide();
				$('.well').html(res);
				$('.well').show('slow');
			}
		);
	});
	
	$(document).on('click', '.btn_edit', function() {
		var page = $('#main h3.panel-title').text();
		var x = $(this).val();
		$.post('./mila-route.php', {target: page, view: "edit", id: x},
			function(res){
				$('.well').hide();
				$('.well').html(res);
				$('.well').show('slow');
			}
		);
	});
	
	$(document).on('click', '.btn_delete', function() {		
		var x = $(this).val(); 
		var page = $('#main h3.panel-title').text();
		//var name = $('#tr'+x+' td').eq(1).text().trim();
		var name = $('#tr'+x+' td.name').text().trim();
		if (confirm("Anda yakin menghapus '"+name+"'?")) {
			$.post('./mila-route.php', {target: page, view: "delete", id: x},
				function(res){
					if(res == 1){
					  $('#tr'+x).hide('slow');
					  $('#tr'+x).remove();
					}else{ 
					  alert('Delete gagal');
					}
				}
			);
		}
	});
	
	$(document).on('click', '.btn-save', function() {
		var page = $('#main h3.panel-title').text();
		page = page.replace("Tambah","").toLowerCase().trim();
		$.post('./mila-route.php', {
			target: page, view: "save", data:$("form").serializeObject()},
			function(res){
					if(res == 1){
						$.post('./mila-route.php', {target: page},
							function(sss){
								$('.well').hide();
								$('.well').html(sss);
								$('.well').show('slow');
							}
						);
					}else if(res == 2){ 
					  alert('Simpan gagal! Data sudah ada.');
					}else if(res == 3){ 
					  alert('Simpan gagal! Data belum lengkap.');
					}else{ 
					  alert('Simpan gagal!'+res);
					}
			}
		);
	});
	
	$(document).on('click', '.btn-update', function() {
		var page = $('#main h3.panel-title').text();
		page = page.replace("Edit","").toLowerCase().trim();
		$.post('./mila-route.php', {
			target: page, view: "update", data:$("form").serializeObject()},
			function(res){
					if(res == 1){
						$.post('./mila-route.php', {target: page},
							function(sss){
								$('.well').hide();
								$('.well').html(sss);
								$('.well').show('slow');
							}
						);
					}else if(res == 2){ 
					  alert('Update gagal! Data belum lengkap.');
					}else{ 
					  alert('Update gagal!'+res);
					}
			}
		);
	});
	
	$(document).on('click', '.btn-cancel', function() {
		var page = $('#main h3.panel-title').text();
		page = page.replace("Tambah","").replace("Edit","").toLowerCase().trim();
		$.post('./mila-route.php', {target: page},
			function(res){
				$('.well').hide();
				$('.well').html(res);
				$('.well').show('slow');
			}
		);
	});
	
	$(document).on('change', '.cbo-jurusan', function() {
		var x = $(this).val(); var teks = $(this).children('option:selected').text();
		var page = $('#main h3.panel-title').text();
		page = page.replace("Tambah","").replace("Edit","").toLowerCase().trim();
		$.post('./mila-route.php', {target: page, view: "prodi", id: x, txt:teks},
			function(res){
				$('.cbo-prodi').hide();
				$('.cbo-prodi').html(res);
				$('.cbo-prodi').show('slow');
			}
		);
	}); 

	$(document).on('click', '.btn_process', function() {		
		var page = $('#main .well h2').text();
		$.post('./mila-route.php', {target: page, view: "process"},
			function(res){
				$('.diproses').hide();
				$('.diproses').html(res);
				$('.diproses').show('slow');
			}
		);
	});

	$(document).on('click', '.btn_detail', function() {		
		var x = $(this).val(); var page = $('#main .well h2').text();
		$.post('./mila-route.php', {target: page, view: "detail", id: x},
			function(res){
				$('.well').hide();
				$('.well').html(res);
				$('.well').show('slow');
			}
		);
	});
	
	$(document).on('click', '.btn_back', function() {		
		var page = $('#main .well h2').text();
		$.post('./mila-route.php', {target: page},
			function(res){
				$('.well').hide();
				$('.well').html(res);
				$('.well').show('slow');
			}
		);
	});
	
	$(document).on('click', '.btn_cetak', function() {	
		var page = $('#main .well h2').text();
		$.post('./mila-route.php', {target: page, view: "cetak"},
			function(res){
				//alert(res);
				var win = window.open('about:blank','_blank', 'width=900,height=600');
				if(win){
					with(win.document){
						open();
						write(res);
						close();
					}
					win.focus();
					win.print();
				}else{
					alert("Please allow popups for this site");
				}
			}
		);
	});
	
});