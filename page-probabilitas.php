<?php if($view=="process"): update_probabilitas(); ?>
  <div class="tab-pane fade in active" id="prodi"><?php _etable("Prodi", get_probabilitas("PRODI")); ?></div>
  <div class="tab-pane fade" id="smt"><?php _etable("Semester", get_probabilitas("SEMESTER"), 'semester'); ?></div>
  <div class="tab-pane fade" id="jkl"><?php _etable("Jenis Kelamin", get_probabilitas("JENKEL"), 'jenkel'); ?></div>
  <div class="tab-pane fade" id="ipk"><?php _etable("Indeks Prestasi", get_probabilitas("IPK"),null,true,true); ?></div>
  <div class="tab-pane fade" id="gaji"><?php _etable("Gaji Orang Tua", get_probabilitas("GAJI"), 'numeric',true,true); ?></div>
  <div class="tab-pane fade" id="lst"><?php _etable("Tagihan Listrik", get_probabilitas("REKLISTRIK"), 'numeric',true,true); ?></div>
  <div class="tab-pane fade" id="pgm"><?php _etable("Piagam", get_probabilitas("JMLPIAGAM"), 'piagam'); ?></div>
  <div class="tab-pane fade" id="pkm"><?php _etable("Proposal PKM", get_probabilitas("PROPOSALPKM"), 'pkm'); ?></div>
<?php else: ?>
<h2><?php echo $_POST['target'];?></h2>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary filterable" style="margin-bottom:0px;">
			<div class="panel-heading">
				<h3 class="panel-title">Tabel Probabilitas</h3>
				<div class="pull-right">
					<button class="btn btn-default btn-xs btn_process"><span class="glyphicon glyphicon-refresh"></span> Process</button>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="nav nav-tabs tabulasi" role="tablist">
				   <li class="active"><a href="#prodi" data-toggle="tab">Prodi</a></li>
				   <li><a href="#smt" data-toggle="tab">Semseter</a></li>
				   <li><a href="#jkl" data-toggle="tab">Jenis Kelamin</a></li>
				   <li><a href="#ipk" data-toggle="tab">Indeks Prestasi</a></li>
				   <li><a href="#gaji" data-toggle="tab">Gaji Orang Tua</a></li>
				   <li><a href="#lst" data-toggle="tab">Tagihan Listrik</a></li>
				   <li><a href="#pgm" data-toggle="tab">Piagam</a></li>
				   <li><a href="#pkm" data-toggle="tab">Proposal PKM</a></li>
				</ul>
				<div class="tab-content diproses">
				  <div class="tab-pane fade in active" id="prodi"><?php _etable("Prodi", get_probabilitas("PRODI")); ?></div>
				  <div class="tab-pane fade" id="smt"><?php _etable("Semester", get_probabilitas("SEMESTER"), 'semester'); ?></div>
				  <div class="tab-pane fade" id="jkl"><?php _etable("Jenis Kelamin", get_probabilitas("JENKEL"), 'jenkel'); ?></div>
				  <div class="tab-pane fade" id="ipk"><?php _etable("Indeks Prestasi", get_probabilitas("IPK"),null,true,true); ?></div>
				  <div class="tab-pane fade" id="gaji"><?php _etable("Gaji Orang Tua", get_probabilitas("GAJI"), 'numeric',true,true); ?></div>
				  <div class="tab-pane fade" id="lst"><?php _etable("Tagihan Listrik", get_probabilitas("REKLISTRIK"), 'numeric',true,true); ?></div>
				  <div class="tab-pane fade" id="pgm"><?php _etable("Piagam", get_probabilitas("JMLPIAGAM"), 'piagam'); ?></div>
				  <div class="tab-pane fade" id="pkm"><?php _etable("Proposal PKM", get_probabilitas("PROPOSALPKM"), 'pkm'); ?></div>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
</div>
<?php endif; ?>