<?php
if(isset($_POST['nim']))
{
	include "db.php"; $nim	= mysql_escape_string($_POST['nim']);
	$cek  = mysqli_query($con,"select *, count(*) as ROW from view_mahasiswa where NIM = '$nim'");
	$mhs = mysqli_fetch_object($cek);
	if($mhs->ROW <= 0): 
		echo 0;
	else:
		$s = mysqli_query($con,"select DATA from mila_rekomendasi where NIM = $nim;");
		$r = mysqli_fetch_object($s); $data = json_decode($r->DATA);
	?>
	<div class="row navi">
		<div class="col-md-2 col-md-offset-10">
		<div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-arrow-left"></span></span>
			<a href="./" class="btn btn-sm btn-primary btn-block btn-back" role="button">Kembali</a>
		</div>
		</div>
	</div>
	<div class="row navi">
		<div class="col-sm-4 col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">DATA  MAHASISWA</div>
				<div class="panel-body">
					<table class="table">
					<tr><th>NIM</th><td>:</td><td><?php echo $mhs->NIM;?></td></tr>
					<tr><th>Nama</th><td>:</td><th><?php echo $mhs->NAMA;?></th></tr>
					<?php $dt=0; foreach($data as $a => $b): $dt++; if($dt>8) break; 
					switch($mhs->$a){
						default:  $nilai = $mhs->$a; break;
						case "L": $nilai = "LAKI-LAKI"; break;
						case "P": $nilai = "PEREMPUAN"; break;
						case "Y": $nilai = "YA"; break;
						case "T": $nilai = "TIDAK"; break;
					}
					switch($a){
						default: 		    $item=ucwords(strtolower($a)); break;
						case "JENKEL": 		$item="Jenis Kelamin"; break;
						case "IPK": 		$item="Indeks Prestasi"; break;
						case "GAJI": 		$item="Gaji Orang Tua"; $nilai = "Rp. ".number_format($nilai, 0, ',', '.'); break;
						case "REKLISTRIK": 	$item="Rek. Listrik"; $nilai = "Rp. ".number_format($nilai, 0, ',', '.'); break;
						case "JMLPIAGAM": 	$item="Jml. Piagam"; break;
						case "PROPOSALPKM": $item="Prop. PKM"; break;
					}
					?>
					<tr><th><?php echo $item;?></th><td>:</td><td><?php echo $nilai;?></td></tr>
					<?php endforeach; ?>
					</table>
				</div>
				<div class="panel-foot">
				  <div style="padding: 15px;">
					<strong>Rekomendasi Beasiswa:</strong>
					<h3 style="text-align:center;margin:0;padding:5px 0px;background:#dedede;">
					<?php echo $data->REKOMENDASI;?>
					</h3>
				  </div>
				</div>
			</div>
		</div>
		<div class="col-sm-8 col-md-8">
			<div class="panel panel-primary">
				<div class="panel-heading">DETAIL REKOMENDASI</div>
				<div class="panel-body">
				<table class="table">
					<thead>
						<tr class="filters">
							<th>ITEM</th>
							<?php foreach(reset($data) as $a => $b): ?>
							<th><?php echo $a;?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
						</tr>
					<tbody>
						<?php $dt=0; foreach($data as $a => $b): $dt++; if($dt>8) break; 
						switch($a){
							default: 		    $item=$a; break;
							case "JENKEL": 		$item="JENIS KELAMIN"; break;
							case "IPK": 		$item="INDEKS PRESTASI"; break;
							case "GAJI": 		$item="GAJI ORANG TUA"; break;
							case "REKLISTRIK": 	$item="REK. LISTRIK"; break;
							case "JMLPIAGAM": 	$item="JML. PIAGAM"; break;
							case "PROPOSALPKM": $item="PROPOSAL PKM"; break;
						}
						?>
						<tr>
							<td><?php echo $item;?></td>
							<?php foreach($data->$a as $c => $d): ?>
							<td><?php echo number_format($d->NILAI,6,',','.');?></td>
							<?php endforeach; ?>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<th align=center>LIKELIHOOD</th>
							<?php foreach($data->LIKELIHOOD as $c => $d): ?>
							<td><?php echo number_format($d,6,',','.');?></td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<th align=center>LIKELIHOOD TOTAL</th>
							<?php foreach($data->PROBABILITY as $c => $d): ?>
							<td><?php echo number_format($d->TOTAL,6,',','.');?></td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<th align=center>PROBABILITY VALUE</th>
							<?php foreach($data->PROBABILITY as $c => $d): ?>
							<td><?php echo number_format($d->NILAI,6,',','.');?></td>
							<?php endforeach; ?>
						</tr>
					</tfoot>
				</table>
				</div>
			</div>		
		</div>
	</div>
	<?php endif;
}