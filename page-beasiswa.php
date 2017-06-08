<?php if($view == "new" || $view == "edit"){
echo ($view == "new")?"<h2>Tambah Beasiswa</h2>":"<h2>Edit Beasiswa</h2>"; ?>
<div id="beasiswa" class="panel panel-primary filterable">
	<div class="panel-heading">
	<?php if($view == "new"){ ?>
		<h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Tambah Beasiswa</h3>
	<?php } else { ?>
		<h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Edit Beasiswa</h3>
	<?php } ?>
	</div>
	<div class="panel-body">
		<?php if($view == "new") {
			@$r->ID=$r->BEASISWA=$r->JURUSAN=$r->PRODI=$r->SMTDARI=$r->SMTSMP=$r->IPKMIN=
			$r->TAHUN=null; $r->AKTIF=1;
		} else {
			$q = mysqli_query($con,"select * from mila_beasiswa where ID = $id");
			$r = mysqli_fetch_object($q);
		} ?>
		<form>
		<input type="hidden" name="id" value="<?php echo $r->ID;?>"  />
		<table class="table">
		  <tr>
			<th align="left" scope="row">Nama Beasiswa</th>
			<th scope="row">:</th>
			<td align="left">
				<input style="text-transform:uppercase;" type="text" name="beasiswa"
				size="50" value="<?php echo $r->BEASISWA;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Jurusan</th>
			<th scope="row">:</th>
			<td align="left">
				<select name="jurusan" class="cbo-jurusan">
					<option value=0>-- Semua Jurusan --</option>
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
			<th align="left" scope="row">Prodi</th>
			<th scope="row">:</th>
			<td align="left">
				<select name="prodi" class="cbo-prodi">
					<?php
					$whe = (isset($r->JURUSAN))?"where JURUSAN = $r->JURUSAN":null;
					$qry = mysqli_query($con,"select * from mila_prodi ".$whe);
					if($whe==null||$r->JURUSAN==0){ echo "<option value=0>-- Semua Prodi --</option>"; } else {
					while($row = mysqli_fetch_array($qry)){
					?>
						<option value="<?php echo $row['ID']; ?>" <?php echo ($r->PRODI==$row['ID'])?"selected":""; ?>>
							<?php echo $row['JENJANG'].' '.$row['PRODI']; ?>
						</option>
					<?php } } ?>
				</select>
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Semester</th>
			<th scope="row">:</th>
			<td align="left">
				<select name="smtdari">
				<?php for($v=1;$v<=8;$v++){ ?>
					<option value="<?php echo $v; ?>" <?php echo ($r->SMTDARI==$v)?"selected":""; ?>>
						<?php echo $v; ?>
					</option>
				<?php } ?>
				</select>
				 s/d
				<select name="smtsmp">
				<?php for($v=1;$v<=8;$v++){ ?>
					<option value="<?php echo $v; ?>" <?php echo ($r->SMTSMP==$v)?"selected":""; ?>>
						<?php echo $v; ?>
					</option>
				<?php } ?>
				</select>
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">IPK Minimal</th>
			<th scope="row">:</th>
			<td align="left">
				<input type="text" name="ipkmin" size="10" value="<?php echo $r->IPKMIN;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Tahun</th>
			<th scope="row">:</th>
			<td align="left">
				<select name="tahun">
				<?php for($v=date('Y');$v<=date('Y')+3;$v++){ ?>
					<option value="<?php echo $v; ?>" <?php echo ($r->TAHUN==$v)?"selected":""; ?>>
						<?php echo $v; ?>
					</option>
				<?php } ?>
				</select>
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Status</th>
			<th scope="row">:</th>
			<td align="left">
				<div class="btn-group btn-toggle" data-toggle="buttons">
					<label class="btn btn-sm <?php echo ($r->AKTIF==1||$r->AKTIF!=0)?"btn-primary active":"btn-default"; ?>" >
						<input type="radio" name="aktif" value=1 <?php echo ($r->AKTIF==1||$r->AKTIF!=0)?"checked":""; ?>>Aktif
					</label>
					<label class="btn btn-sm <?php echo ($r->AKTIF==0)?"btn-primary active":"btn-default"; ?>" >
						<input type="radio" name="aktif" value=0 <?php echo ($r->AKTIF==0)?"checked":""; ?>>Tidak Aktif
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
	$query = mysqli_query($con,"select * from mila_beasiswa");
	$id = mysqli_num_rows($query) + 1;
	$d 	= json_decode(json_encode($_POST['data']));
	if(!empty($d->beasiswa)){ $d->beasiswa = strtoupper($d->beasiswa);
		$query = mysqli_query($con,"select * from mila_beasiswa where BEASISWA = '$d->beasiswa' and TAHUN = $d->tahun");
		if(mysqli_num_rows($query) == 0){
			$q = mysqli_query($con,"insert into mila_beasiswa (ID, BEASISWA, JURUSAN, PRODI, SMTDARI, SMTSMP, IPKMIN,
				TAHUN, AKTIF) value ($id, '$d->beasiswa', $d->jurusan, $d->prodi, $d->smtdari, $d->smtsmp,
				$d->ipkmin, $d->tahun, $d->aktif);");
			if($q) echo 1;
			else echo 4;
		}else{
			echo 2;
		}
	} else echo 3;

} else if($view == "update"){
	$d 	= json_decode(json_encode($_POST['data']));
	if(!empty($d->beasiswa)){ $d->beasiswa = strtoupper($d->beasiswa);
		$q = mysqli_query($con,"update mila_beasiswa set BEASISWA = '$d->beasiswa', JURUSAN = $d->jurusan, PRODI = $d->prodi,
		SMTDARI = $d->smtdari, SMTSMP = $d->smtsmp, IPKMIN = $d->ipkmin, TAHUN = $d->tahun, AKTIF = $d->aktif
		where ID = $d->id;");
		if($q) echo 1;
		else 2;
	} else echo 3;

} else if($view == "delete"){
	$query = mysqli_query($con,"select * from mila_beasiswa where ID = '$id';");
	if($query && mysqli_num_rows($query) > 0){
		$query = mysqli_query($con,"delete from mila_beasiswa where ID = '$id';");
		if(mysql_affected_rows() >= 1) echo 1;
		else echo 3;
	}else{
		echo 2;
	}

} else if($view == "prodi"){
	if($id==0){
		echo "<option value=0>-- Semua Prodi --</option>";
	}else{
		echo "<option value=0>-- SEMUA ".$_POST['txt']." --</option>";
		$qry = mysqli_query($con,"select * from mila_prodi where JURUSAN = $id");
		while($row = mysqli_fetch_array($qry)){
		?>
			<option value="<?php echo $row['ID']; ?>"><?php echo $row['JENJANG'].' '.$row['PRODI']; ?></option>
		<?php }
	}

} else { ?>
<h2><?php echo $_POST['target'];?></h2>
<div id="beasiswa" class="panel panel-primary filterable">
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
				<th><input type="text" size=15 class="form-control" placeholder="#" disabled></th>
				<th><input type="text" size=120 class="form-control" placeholder="Nama Beasiswa" disabled></th>
				<th><input type="text" size=80 class="form-control" placeholder="Prodi" disabled></th>
				<th><input type="text" size=80 class="form-control" placeholder="Jurusan" disabled></th>
				<th><input type="text" size=50 class="form-control" placeholder="Semester" disabled></th>
				<th><input type="text" size=50 class="form-control" placeholder="IPK Min." disabled></th>
				<th><input type="text" size=50 class="form-control" placeholder="Tahun" disabled></th>
				<th><input type="text" size=50 class="form-control" placeholder="Status" disabled></th>
				<th>Edit</th>
				<th>Hapus</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query 	= mysqli_query($con,"select * from mila_beasiswa");
				if($query && mysqli_num_rows($query) > 0){ $num=0;
					while($row = mysqli_fetch_object($query)){$num++;
					if($row->PRODI!=0){
						$q 	= mysqli_query($con,"select p.JENJANG as JJ, p.PRODI as PRD, j.JURUSAN as JUR from
						mila_prodi as p, mila_jurusan as j where p.JURUSAN = j.ID and p.ID = $row->PRODI");
						$r = mysqli_fetch_object($q);
					}?>
						<tr id="tr<?php echo $row->ID;?>">
							<td><?php echo $num;?></td>
							<td class="name"><?php echo $row->BEASISWA;?></td>
							<td><?php echo ($row->PRODI==0)?"SEMUA PRODI":$r->JJ.' '.$r->PRD;?></td>
							<td><?php echo ($row->JURUSAN==0)?"SEMUA JURUSAN":$r->JUR;?></td>
							<td><?php echo $row->SMTDARI.' - '.$row->SMTSMP;?></td>
							<td><?php echo $row->IPKMIN;?></td>
							<td><?php echo $row->TAHUN;?></td>
							<td><?php echo ($row->AKTIF==1)?"Aktif":"Tidak";?></td>
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
