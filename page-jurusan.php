<?php if($view == "new" || $view == "edit"){
echo ($view == "new")?"<h2>Tambah Jurusan</h2>":"<h2>Edit Jurusan</h2>"; ?>
<div id="jurusan" class="panel panel-primary filterable">
	<div class="panel-heading">
	<?php if($view == "new"){ ?>
		<h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Tambah Jurusan</h3>
	<?php } else { ?>
		<h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Edit Jurusan</h3>
	<?php } ?>
	</div>
	<div class="panel-body">
		<form><table class="table">
		  <tr>
			<th style="border:none;" width="180" align="left" scope="row">Nama Jurusan</th>
			<th style="border:none;" width="20" scope="row">:</th>
			<td style="border:none;" align="left">
				<?php if($view == "new"){ ?>
				<input style="text-transform:uppercase;" type="text" name="jurusan" size="50" value="" autocomplete="off"  />
				<?php } else {
				$query = mysqli_query($con, "select * from mila_jurusan where ID = $id");
				$r = mysqlii_fetch_object($query); ?>
				<input type="hidden" name="id" value="<?php echo $r->ID;?>"  />
				<input style="text-transform:uppercase;" type="text" name="jurusan" size="50" value="<?php echo $r->JURUSAN;?>"  />
				<?php } ?>
			</td>
		  </tr>
		</table></form>
	</div>
	<div class="panel-footer">
	<?php if($view == "new"){ ?>
		<button style="margin-left:11em;" title="Simpan" class="btn btn-primary btn-lg btn-save"><span class="glyphicon glyphicon-save"></span> Simpan</button>
	<?php } else { ?>
		<button style="margin-left:11em;" title="Update" class="btn btn-primary btn-lg btn-update"><span class="glyphicon glyphicon-refresh"></span> Update</button>
	<?php } ?>
		<button style="margin-left:0.5em;" title="Batal" class="btn btn-default btn-lg btn-cancel"><span class="glyphicon glyphicon-remove"></span> Batal</button>
	</div>
</div>
<?php } else if($view == "save"){
	$query = mysqli_query($con, "select * from mila_jurusan");
	$id = mysqli_num_rows($query) + 1;
	$data = json_decode(json_encode($_POST['data'])); $jurusan = strtoupper($data->jurusan);
	if(!empty($jurusan)){
		$query = mysqli_query($con,"select * from mila_jurusan where JURUSAN = '$jurusan'");
		if(mysqli_num_rows($query) == 0){
			$q = mysqli_query($con,"insert into mila_jurusan (ID, JURUSAN) value ($id, '$jurusan');");
			if($q) echo 1;
			else echo 4;
		}else{
			echo 2;
		}
	} else echo 3;

} else if($view == "update"){
	$data 	= json_decode(json_encode($_POST['data']));
	$id 	= $data->id;
	$jurusan 	= strtoupper($data->jurusan);
	if(!empty($jurusan)){
		$q = mysqli_query($con,"update mila_jurusan set JURUSAN = '$jurusan' where ID = $id;");
		if($q) echo 1;
		else echo 2;
	} else echo 3;

} else if($view == "delete"){
	$query = mysqli_query($con,"select * from mila_jurusan where ID = $id;");
	if($query && mysqli_num_rows($query) > 0){
		$query = mysqli_query($con,"delete from mila_jurusan where ID = $id;");
		if(mysqli_affected_rows() > 0){
			$query = mysqli_query($con,"delete from mila_prodi where JURUSAN = $id;");
			echo 1;
		} else 3;
	}else{
		echo 2;
	}
} else { ?>
<h2><?php echo $_POST['target'];?></h2>
<div id="jurusan" class="panel panel-primary filterable">
	<div class="panel-heading">
		<h3 class="panel-title"><?php echo $_POST['target'];?></h3>
		<div class="pull-right">
			<button class="btn btn-default btn-xs btn-baru"><span class="glyphicon glyphicon-plus"></span> Tambah</button>
			<button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
		</div>
	 </div>
	<table class="table">
		<thead>
			<tr class="filters">
				<th><input type="text" size=10 class="form-control" placeholder="#" disabled></th>
				<th><input type="text" size=300 class="form-control" placeholder="Nama Jurusan" disabled></th>
				<th>Edit</th>
				<th>Hapus</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query 	= mysqli_query($con,"select * from mila_jurusan");
				if($query && mysqli_num_rows($query) > 0){ $num=0;
					while($row = mysqli_fetch_object($query)){$num++;?>
						<tr id="tr<?php echo $row->ID;?>">
							<td><?php echo $num;?></td>
							<td class="name"><?php echo $row->JURUSAN;?></td>
							<td>
								<button title="Edit" class="btn btn-primary btn-xs btn_edit" value="<?php echo $row->ID;?>">
								<span class="glyphicon glyphicon-pencil"></span></button>
							</td>
							<td>
								<button title="Hapus" class="btn btn-danger btn-xs btn_delete" value="<?php echo $row->ID;?>">
								<span class="glyphicon glyphicon-trash"></span></button>
							</td>
						</tr><?php
					}
				}
			?>
		</tbody>
	</table>
</div>
<?php } ?>
