<?php if($view=="cetak"){
?>
<title><?php echo $_POST['target'];?> Beasiswa</title>
<style>
@media all {
	@page { margin: 1cm 1cm 1cm 1.5cm }
	input,textarea,select{
	 font-family: Verdana,Tahoma,sans-serif;
	 font-size: 8pt;
	}

	table {
	 font-family: Verdana;
	 font-size: 8pt;
	 border-width: 1px;
	 border-style: solid;
	 border-color: #ccd2d2;
	 border-collapse: collapse;
	 background-color: #f9f9f9;
	 margin: 10px 0px;
	 width: 100%;
	}

	th {
	 color: #FFFFFF;
	 font-size: 7pt;
	 text-transform: uppercase;
	 text-align: center;
	 padding: 0.5em;
	 border-width: 1px;
	 border-style: solid;
	 border-color: #ccd2d2;
	 border-collapse: collapse;
	 background-color: #7D7D7D;
	}

	td {
	 padding: 0.5em;
	 color: #272727;
	 vertical-align: top;
	 border-width: 1px;
	 border-style: solid;
	 border-color: #ccd2d2;
	 border-collapse: collapse;
	}
	
	h2 {font-family: Verdana; text-align: center;}
}
</style>
<h2><?php echo $_POST['target'];?> Beasiswa</h2>
<table class="table">
<thead>
	<tr>
		<th>No.</th>
		<th>NIM</th>
		<th>Nama Lengkap</th>
		<th>L/P</th>
		<th>SMT</th>
		<th>Prodi</th>
		<th>Rekomendasi</th>
	</tr>
</thead>
<tbody>
<?php
	$query 	= mysqli_query($con,"select a.*, b.REKOMENDASI as REKO  from view_mahasiswa a, mila_rekomendasi b where a.NIM = b.NIM");
	if($query && mysqli_num_rows($query) > 0){ $num=0;
		while($row = mysqli_fetch_object($query)){$num++;?>
			<tr id="tr<?php echo $row->ID;?>">
				<td><?php echo $num;?></td>
				<td><?php echo $row->NIM;?></td>
				<td><?php echo $row->NAMA;?></td>
				<td><?php echo $row->JENKEL;?></td>
				<td><?php echo $row->SEMESTER;?></td>
				<td><?php echo $row->PRODI;?></td>
				<td><?php echo $row->REKO;?></td>
			</tr><?php
		}
	}
?>
</tbody>
</table>
<?php }else{ ?>
<h2><?php echo $_POST['target'];?></h2>
<div class="panel panel-primary filterable">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $_POST['target'];?> Beasiswa</h3>
		<div class="pull-right">
			<button class="btn btn-default btn-xs btn_cetak"><span class="glyphicon glyphicon-print"></span> Cetak</button>
		</div>
	</div>
	<table class="table">
		<thead>
			<tr>
				<th>No.</th>
				<th>NIM</th>
				<th>Nama Lengkap</th>
				<th>L/P</th>
				<th>SMT</th>
				<th>Prodi</th>
				<th bgcolor="#ddf9f4">Rekomendasi</th>
			</tr>
		</thead>
		<tbody>
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
							<td bgcolor="#ddf9f4"><?php echo $row->REKO;?></td>
						</tr><?php
					}
				}
			?>
		</tbody>
	</table>
</div>
<?php } ?>