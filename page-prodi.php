<?php if($view == "new" || $view == "edit"){
echo ($view == "new")?"<h2>Tambah Prodi</h2>":"<h2>Edit Prodi</h2>"; ?>
<div id="prodi" class="panel panel-primary filterable">
	<div class="panel-heading">
	<?php if($view == "new"){ ?>
		<h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Tambah Prodi</h3>
	<?php } else { ?>
		<h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Edit Prodi</h3>
	<?php } ?>
	</div>
	<div class="panel-body">
		<?php if($view == "new") {$r->ID=$r->JURUSAN=$r->PRODI=null;$r->JENJANG="D3";} else {
			$q = mysqli_query($con,"select * from mila_prodi where ID = $id");
			$r = mysqli_fetch_object($q);
		} ?>
		<form>
		<input type="hidden" name="id" value="<?php echo $r->ID;?>"  />
		<table class="table">
		  <tr>
			<th width="180" align="left" scope="row">Jurusan</th>
			<th width="20" scope="row">:</th>
			<td align="left">
				<select name="jurusan">
					<?php
					$qry = mysqli_query($con,"select * from mila_jurusan");
					while($row = mysqli_fetch_array($qry)){
					?>
						<option value="<?php echo $row['ID']; ?>" <?php echo ($r->JURUSAN==$row['ID'])?"selected":""; ?>>
							<?php echo $row['JURUSAN']; ?>
						</option>
					<?php } ?>
				</select>
			</td>
		  </tr>
		  <tr>
			<th width="180" align="left" scope="row">Prodi</th>
			<th width="20" scope="row">:</th>
			<td align="left">
				<input style="text-transform:uppercase;" type="text" name="prodi"
				size="50" value="<?php echo $r->PRODI;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th width="180" align="left" scope="row">Jenjang</th>
			<th width="20" scope="row">:</th>
			<td align="left">
				<div class="btn-group btn-toggle" data-toggle="buttons">
					<label class="btn btn-sm <?php echo ($r->JENJANG=="D3")?"btn-primary active":"btn-default"; ?>">
						<input type="radio" name="jenjang" value="D3" <?php echo ($r->JENJANG=="D3")?"checked":""; ?>>D3
					</label>
					<label class="btn btn-sm <?php echo ($r->JENJANG=="S1")?"btn-primary active":"btn-default"; ?>">
						<input type="radio" name="jenjang" value="S1" <?php echo ($r->JENJANG=="S1")?"checked":""; ?>>S1
					</label>
					<label class="btn btn-sm <?php echo ($r->JENJANG=="S2")?"btn-primary active":"btn-default"; ?>">
						<input type="radio" name="jenjang" value="S2" <?php echo ($r->JENJANG=="S2")?"checked":""; ?>>S2
					</label>
					<label class="btn btn-sm <?php echo ($r->JENJANG=="S3")?"btn-primary active":"btn-default"; ?>">
						<input type="radio" name="jenjang" value="S3" <?php echo ($r->JENJANG=="S3")?"checked":""; ?>>S3
					</label>
				</div>
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
	$query = mysqli_query($con,"select * from mila_prodi");
	$id = mysqli_num_rows($query) + 1;
	$d = json_decode(json_encode($_POST['data']));
	if(!empty($d->prodi)){ $d->prodi = strtoupper($d->prodi);
		$query = mysqli_query($con,"select * from mila_prodi where JURUSAN = $d->jurusan and PRODI = '$d->prodi' and JENJANG = '$d->jenjang'");
		if(mysqli_num_rows($query) == 0){
			$q = mysqli_query($con,"insert into mila_prodi (ID, JURUSAN, PRODI, JENJANG) value ($id, $d->jurusan, '$d->prodi', '$d->jenjang');");
			if($q) echo 1;
			else echo 4;
		}else{
			echo 2;
		}
	} else echo 3;

} else if($view == "update"){
	$d = json_decode(json_encode($_POST['data']));
	if(!empty($d->prodi)){ $d->prodi = strtoupper($d->prodi);
		$q = mysqli_query($con,"update mila_prodi set JURUSAN = $d->jurusan, PRODI = '$d->prodi',
			JENJANG = '$d->jenjang' where ID = $d->id;");
		if($q) echo 1;
		else 3;
	} else echo 2;

} else if($view == "delete"){
	$query = mysqli_query($con,"select * from mila_prodi where ID = '$id';");
	if($query && mysqli_num_rows($query) > 0){
		$query = mysqli_query($con,"delete from mila_prodi where ID = '$id';");
		if(mysql_affected_rows() == 1) echo 1;
		else echo 3;
	}else{
		echo 2;
	}
} else { ?>
<h2><?php echo $_POST['target'];?></h2>
<div id="prodi" class="panel panel-primary filterable">
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
				<th><input type="text" size=100 class="form-control" placeholder="Prodi" disabled></th>
				<th><input type="text" size=200 class="form-control" placeholder="Jurusan" disabled></th>
				<th>Edit</th>
				<th>Hapus</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query 	= mysqli_query($con,"select p.*, j.JURUSAN as JUR from mila_prodi as p, mila_jurusan as j where p.JURUSAN = j.ID");
				if($query && mysqli_num_rows($query) > 0){ $num=0;
					while($row = mysqli_fetch_object($query)){$num++;?>
						<tr id="tr<?php echo $row->ID;?>">
							<td><?php echo $num;?></td>
							<td class="name"><?php echo $row->JENJANG.' '.$row->PRODI;?></td>
							<td><?php echo $row->JUR;?></td>
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
