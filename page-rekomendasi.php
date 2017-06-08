<?php if($view=="process"){ update_rekomendasi();
	$query 	= mysqli_query($con,"select a.*, b.REKOMENDASI as REKO  from view_mahasiswa a, mila_rekomendasi b where a.NIM = b.NIM");
	if($query && mysqli_num_rows($query) > 0){ $num=0;
		while($row = mysqli_fetch_object($query)){$num++;?>
			<tr id="tr<?php echo $row->ID;?>">
				<td><?php echo $num;?></td>
				<td><?php echo $row->NIM;?></td>
				<td class="name"><?php echo $row->NAMA;?></td>
				<td><?php echo $row->JENKEL;?></td>
				<td><?php echo $row->SEMESTER;?></td>
				<td><?php echo $row->PRODI;?></td>
				<td><?php echo $row->IPK;?></td>
				<td><?php echo number_format($row->GAJI, 0, ',', '.');?></td>
				<td><?php echo number_format($row->REKLISTRIK, 0, ',', '.');?></td>
				<td><?php echo $row->JMLPIAGAM;?></td>
				<td><?php echo ($row->PROPOSALPKM=='Y')?"YA":"TIDAK";?></td>
				<td bgcolor="#ddf9f4"><?php echo $row->REKO;?></td>
				<td align=center>
				<button title="Detail"  class="btn btn-primary btn-xs btn_detail" value="<?php echo $row->NIM;?>" >
				<span class="glyphicon glyphicon-list-alt"></span></button>
				</td>
			</tr><?php
		}
	}
} else if($view == "hitung") { ?>
<h2><?php echo $_POST['target'];?></h2>
<?php } else if($view == "detail") { 
 $s = mysqli_query($con,"select * from view_mahasiswa where NIM = $id;");
 $m = mysqli_fetch_object($s);
 $s = mysqli_query($con,"select DATA from mila_rekomendasi where NIM = $id;");
 while($r=mysqli_fetch_object($s)) $data = json_decode($r->DATA);
?>
<h2><?php echo $_POST['target'];?></h2>
<div class="row">
	<div class="col-sm-4 col-md-4">
		<div class="jumbotron" style="margin-bottom:0;">
			<h4 style="text-align: center;"><?=$m->NAMA;?><br/>NIM: <?=$m->NIM;?></h4>
		</div>
	</div>
	<div class="col-sm-4 col-md-4 col-sm-offset-4 col-md-offset-4">
		<div class="jumbotron" style="margin-bottom:0;">
			<h4 style="text-align: center;">Rekomendasi:<br/> <?=$data->REKOMENDASI;?></h4>
		</div>
	</div>
	<?php /*
	<div class="col-sm-8 col-md-8">
		<div class="panel panel-default">
		<div class="panel-heading">Grafik</div>
		<div class="panel-body">
		<div id="morris-donut-chart" class="chart"></div>
		<script language="javascript">
		$(function() {
			Morris.Donut({
				element: 'morris-donut-chart',
				data: [
					<?php 
						foreach($data->PROBABILITY as $c => $d): 
						echo "{";
						echo "label:\"$c\",";
						echo "value:".number_format(($d->NILAI * 100),0,',','.');
						echo "}";
						echo ",\r\n";
						endforeach;
					?>
				],
				resize: true
			});	
			//$("#morris-donut-chart").css("position: fixed;");
			$("#morris-donut-chart").css("display:block; position:static;");
		});
		</script>
		</div>
		</div>
	</div>
	*/ ?>
</div>
<div id="rekomendasi" class="panel panel-primary filterable">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $_POST['target'];?> Beasiswa :: <?php echo ucwords(strtolower($m->NAMA));?></h3>
		<div class="pull-right">
		<button class="btn btn-default btn-xs btn_back"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</button>
		</div>
	 </div>
	<table class="table">
		<thead>
			<tr class="filters">
				<th><input type="text" size=50 class="form-control" placeholder="ITEM" title="ITEM" disabled></th>
				<th><input type="text" size=50 class="form-control" placeholder="NILAI" title="NILAI" disabled></th>
				<?php foreach(reset($data) as $a => $b): ?>
				<th><input type="text" size=35 class="form-control" placeholder="<?php echo $a;?>" title="<?php echo $a;?>" disabled></th>
				<?php endforeach; ?>
			</tr>
		</thead>
			</tr>
		<tbody>
			<?php $dt=0; foreach($data as $a => $b): $dt++; if($dt>8) break; 
			switch($m->$a){
				default:  $nilai = $m->$a; break;
				case "L": $nilai = "LAKI-LAKI"; break;
				case "P": $nilai = "PEREMPUAN"; break;
				case "Y": $nilai = "YA"; break;
				case "T": $nilai = "TIDAK"; break;
			}
			switch($a){
				default: 		    $item=$a; break;
				case "JENKEL": 		$item="JENIS KELAMIN"; break;
				case "IPK": 		$item="INDEKS PRESTASI"; break;
				case "GAJI": 		$item="GAJI ORANG TUA"; $nilai = "Rp. ".number_format($nilai, 0, ',', '.'); break;
				case "REKLISTRIK": 	$item="REK. LISTRIK"; $nilai = "Rp. ".number_format($nilai, 0, ',', '.'); break;
				case "JMLPIAGAM": 	$item="JML. PIAGAM"; break;
				case "PROPOSALPKM": $item="PROPOSAL PKM"; break;
			}
			?>
			<tr>
				<td><?php echo $item;?></td>
				<td><?php echo $nilai;?></td>
				<?php foreach($data->$a as $c => $d): ?>
				<td><?php echo number_format($d->NILAI,12,',','.');?></td>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan=2 align=center>LIKELIHOOD</th>
				<?php foreach($data->LIKELIHOOD as $c => $d): ?>
				<td><?php echo number_format($d,12,',','.');?></td>
				<?php endforeach; ?>
			</tr>
			<tr>
				<th colspan=2 align=center>LIKELIHOOD TOTAL</th>
				<?php foreach($data->PROBABILITY as $c => $d): ?>
				<td><?php echo number_format($d->TOTAL,12,',','.');?></td>
				<?php endforeach; ?>
			</tr>
			<tr>
				<th colspan=2 align=center>PROBABILITY VALUE</th>
				<?php foreach($data->PROBABILITY as $c => $d): ?>
				<td><?php echo number_format($d->NILAI,12,',','.');?></td>
				<?php endforeach; ?>
			</tr>
		</tfoot>
	</table>
</div>
<div class="panel panel-primary filterable">
	<div class="panel-heading">
		<h3 class="panel-title">Perhitungan Lengkap :: <?php echo ucwords(strtolower($m->NAMA));?></h3>
		<div class="pull-right">
		<button class="btn btn-default btn-xs btn_back"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</button>
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
		   <li><a href="#lkh" data-toggle="tab">Likehood</a></li>
		   <li><a href="#prb" data-toggle="tab">Probabilitas</a></li>
		</ul>
		<div class="tab-content">
		  <div class="tab-pane fade in active" id="prodi"><?php _epopulasi("Prodi ".$m->PRODI, $data->PRODI, 12);?></div>
		  <div class="tab-pane fade" id="smt"><?php _epopulasi("Semester ".$m->SEMESTER, $data->SEMESTER, 12);?></div>
		  <div class="tab-pane fade" id="jkl"><?php _epopulasi("Jenis Kelamin ".(($m->JENKEL=='L')?"LAKI-LAKI":"PEREMPUAN"), $data->JENKEL, 12);?></div>
		  
		  <div class="tab-pane fade" id="ipk"><?php _estdeviasi("Indeks Prestasi ".$m->IPK, $data->IPK, 6);?></div>
		  <div class="tab-pane fade" id="gaji"><?php _estdeviasi("Gaji Ortu "."Rp. ".number_format($m->GAJI, 0, ',', '.'), $data->GAJI, 6);?></div>
		  <div class="tab-pane fade" id="lst"><?php _estdeviasi("Tagihan Listrik "."Rp. ".number_format($m->REKLISTRIK, 0, ',', '.'), $data->REKLISTRIK, 6);?></div>
		  
		  <div class="tab-pane fade" id="pgm"><?php _epopulasi("Jumlah Piagam ".$m->JMLPIAGAM, $data->JMLPIAGAM, 12);?></div>
		  <div class="tab-pane fade" id="pkm"><?php _epopulasi("Proposal PKM ".(($m->PROPOSALPKM=='Y')?"YA":"TIDAK"), $data->PROPOSALPKM, 12);?></div>
		  <div class="tab-pane fade" id="lkh"><?php _elikelihood($data, 12);?></div>
		  <div class="tab-pane fade" id="prb"><?php _eproba($data, 12);?></div>
		</div>
	</div>
	<!-- /.panel-body -->
</div>
<?php } else { ?>
<h2><?php echo $_POST['target'];?></h2>
<div id="rekomendasi" class="panel panel-primary filterable">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $_POST['target'];?> Beasiswa</h3>
		<div class="pull-right">
			<button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
			<button class="btn btn-default btn-xs btn_process"><span class="glyphicon glyphicon-refresh"></span> Process</button>
		</div>
	 </div>
	<table class="table">
		<thead>
			<tr class="filters">
				<th><input type="text" size=10 class="form-control" placeholder="#" title="No." disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="NIM" title="NIM" disabled></th>
				<th><input type="text" size=80 class="form-control" placeholder="Nama Lengkap" title="Nama Lengkap" disabled></th>
				<th><input type="text" size=10 class="form-control" placeholder="L/P" title="L/P" disabled></th>
				<th><input type="text" size=15 class="form-control" placeholder="SMT" title="SMT" disabled></th>
				<th><input type="text" size=40 class="form-control" placeholder="Prodi" title="Prodi" disabled></th>
				<th><input type="text" size=15 class="form-control" placeholder="IPK" title="IPK" disabled></th>
				<th><input type="text" size=40 class="form-control" placeholder="Gaji Ortu" title="Gaji Ortu" disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="R. Listrik" title="Rek. Listrik" disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="Piagam" title="Jml. Piagam" disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="Prop. PKM" title="Proposal PKM" disabled></th>
				<th bgcolor="#ddf9f4"><input type="text" size=40 class="form-control" placeholder="Rekomendasi" title="Rekomendasi Beasiswa" disabled></th>
				<th size=40>Detail</th>
			</tr>
		</thead>
		<tbody class="diproses">
			<?php
				$query 	= mysqli_query($con,"select a.*, b.REKOMENDASI as REKO  from view_mahasiswa a, mila_rekomendasi b where a.NIM = b.NIM");
				if($query && mysqli_num_rows($query) > 0){ $num=0;
					while($row = mysqli_fetch_object($query)){$num++;?>
						<tr id="tr<?php echo $row->ID;?>">
							<td><?php echo $num;?></td>
							<td><?php echo $row->NIM;?></td>
							<td class="name"><?php echo $row->NAMA;?></td>
							<td><?php echo $row->JENKEL;?></td>
							<td><?php echo $row->SEMESTER;?></td>
							<td><?php echo $row->PRODI;?></td>
							<td><?php echo $row->IPK;?></td>
							<td><?php echo number_format($row->GAJI, 0, ',', '.');?></td>
							<td><?php echo number_format($row->REKLISTRIK, 0, ',', '.');?></td>
							<td><?php echo $row->JMLPIAGAM;?></td>
							<td><?php echo ($row->PROPOSALPKM=='Y')?"YA":"TIDAK";?></td>
							<td bgcolor="#ddf9f4"><?php echo $row->REKO;?></td>
							<td align=center>
							<button title="Detail"  class="btn btn-primary btn-xs btn_detail" value="<?php echo $row->NIM;?>" >
							<span class="glyphicon glyphicon-list-alt"></span></button>
							</td>
						</tr><?php
					}
				}
			?>
		</tbody>
	</table>
</div>
<?php } ?>