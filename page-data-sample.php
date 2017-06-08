<?php if($view == "new" || $view == "edit"){
echo ($view == "new")?"<h2>Tambah Data Sample</h2>":"<h2>Edit Data Sample</h2>"; ?>
<div id="sample" class="panel panel-primary filterable">
	<div class="panel-heading">
	<?php if($view == "new"){ ?>
		<h3 class="panel-title"><span class="glyphicon glyphicon-plus"></span> Tambah <?php echo $_POST['target'];?></h3>
	<?php } else { ?>
		<h3 class="panel-title"><span class="glyphicon glyphicon-pencil"></span> Edit <?php echo $_POST['target'];?></h3>
	<?php } ?>
	</div>
	<div class="panel-body">
		<?php if($view == "new") { $r = new StdClass;
			$r->ID=$r->NIM=$r->NAMA=$r->PRODI=$r->JURUSAN=$r->ALAMAT=$r->IPK=$r->GAJI=
			$r->SEMESTER=$r->JENKEL=$r->REKLISTRIK=$r->JMLPIAGAM=$r->PROPOSALPKM=$r->BEASISWA=null;
		} else {
			$q = mysqli_query($con,"select * from mila_sample where ID = $id");
			$r = mysqli_fetch_object($q);
		} ?>
		<form>
		<input type="hidden" name="id" value="<?php echo $r->ID;?>"  />
		<table class="table">
		  <tr>
			<th width="180" align="left" scope="row">NIM</th>
			<th width="20" scope="row">:</th>
			<td align="left">
				<input type="text" name="nim" size="20" value="<?php echo $r->NIM;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Nama Lengkap</th>
			<th scope="row">:</th>
			<td align="left">
				<input style="text-transform:uppercase;" type="text" name="nama" size="50" value="<?php echo $r->NAMA;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Jurusan</th>
			<th scope="row">:</th>
			<td align="left">
				<select name="jurusan" class="cbo-jurusan">
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
					$whe = (isset($r->JURUSAN))?$r->JURUSAN:1;
					$qry = mysqli_query($con,"select * from mila_prodi where JURUSAN = ".$whe);
					while($row = mysqli_fetch_array($qry)){
					?>
						<option value="<?php echo $row['ID']; ?>" <?php echo ($r->PRODI==$row['ID'])?"selected":""; ?>>
							<?php echo $row['JENJANG'].' '.$row['PRODI']; ?>
						</option>
					<?php } ?>
				</select>
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">IPK</th>
			<th scope="row">:</th>
			<td align="left">
				<input type="text" name="ipk" size="10" value="<?php echo $r->IPK;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Gaji Orang Tua</th>
			<th scope="row">:</th>
			<td align="left">
				<input type="text" name="gaji" size="20" value="<?php echo $r->GAJI;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Semester</th>
			<th scope="row">:</th>
			<td align="left">
				<select name="semester">
				<?php for($v=1;$v<=8;$v++){ ?>
					<option value="<?php echo $v; ?>" <?php echo ($r->SEMESTER==$v)?"selected":""; ?>>
						<?php echo $v; ?>
					</option>
				<?php } ?>
				</select>
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Jenis Kelamin</th>
			<th scope="row">:</th>
			<td align="left">
				<div class="btn-group btn-toggle" data-toggle="buttons">
					<label class="btn btn-sm <?php echo ($r->JENKEL=="L"||$r->JENKEL!="P")?"btn-primary active":"btn-default"; ?>" >
						<input type="radio" name="jenkel" value="L" <?php echo ($r->JENKEL=="L"||$r->JENKEL!="P")?"checked":""; ?>>Laki-laki
					</label>
					<label class="btn btn-sm <?php echo ($r->JENKEL=="P")?"btn-primary active":"btn-default"; ?>" >
						<input type="radio" name="jenkel" value="P" <?php echo ($r->JENKEL=="P")?"checked":""; ?>>Perempuan
					</label>
				</div>
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Rekening Listrik</th>
			<th scope="row">:</th>
			<td align="left">
				<input type="text" name="reklistrik" size="20" value="<?php echo $r->REKLISTRIK;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Jumlah Piagam</th>
			<th scope="row">:</th>
			<td align="left">
				<input type="text" name="jmlpiagam" size="10" value="<?php echo $r->JMLPIAGAM;?>" autocomplete="off"  />
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Proposal PKM</th>
			<th scope="row">:</th>
			<td align="left">
				<div class="btn-group btn-toggle" data-toggle="buttons">
					<label class="btn btn-sm <?php echo ($r->PROPOSALPKM=="Y")?"btn-primary active":"btn-default"; ?>" >
						<input type="radio" name="proposalpkm" value="Y" <?php echo ($r->PROPOSALPKM=="Y")?"checked":""; ?>>Ya
					</label>
					<label class="btn btn-sm <?php echo ($r->PROPOSALPKM=="T"||$r->PROPOSALPKM!="Y")?"btn-primary active":"btn-default"; ?>" >
						<input type="radio" name="proposalpkm" value="T" <?php echo ($r->PROPOSALPKM=="T"||$r->PROPOSALPKM!="Y")?"checked":""; ?>>Tidak
					</label>
				</div>
			</td>
		  </tr>
		  <tr>
			<th align="left" scope="row">Beasiswa</th>
			<th scope="row">:</th>
			<td align="left">
				<select name="beasiswa" class="cbo-beasiswa">
					<option value=0>TIDAK MENDAPAT</option>
					<?php
					$qry = mysqli_query($con,"select * from mila_beasiswa where AKTIF=1");
					while($row = mysqli_fetch_array($qry)){
					?>
						<option value="<?php echo $row['ID']; ?>" <?php echo ($r->BEASISWA==$row['ID'])?"selected":""; ?>>
							<?php echo $row['BEASISWA']; ?>
						</option>
					<?php } ?>
				</select>
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
	$query = mysqli_query($con,"select * from mila_sample");
	$id = mysqli_num_rows($query) + 1;
	$d 	= json_decode(json_encode($_POST['data']));
	if(!empty($d->nama)){ $d->nama = strtoupper(mysql_escape_string($d->nama));
		$query = mysqli_query($con,"select * from mila_sample where NIM = '$d->nim'");
		if(mysqli_num_rows($query) == 0){
			$q = mysqli_query($con,"insert into mila_sample (ID, NIM, NAMA, PRODI, JURUSAN, IPK, GAJI, SEMESTER,
				JENKEL, REKLISTRIK, JMLPIAGAM, PROPOSALPKM, BEASISWA) value ($id, $d->nim, '$d->nama', $d->prodi,
				$d->jurusan, $d->ipk, $d->gaji, $d->semester, '$d->jenkel', $d->reklistrik, $d->jmlpiagam,
				'$d->proposalpkm', $d->beasiswa);");
			if($q) echo 1;
			else echo 4;
		}else{
			echo 2;
		}
	} else echo 3;

} else if($view == "update"){
	$d 	= json_decode(json_encode($_POST['data']));
	if(!empty($d->nama)){ $d->nama = strtoupper(mysql_escape_string($d->nama));
		$q = mysqli_query($con,"update mila_sample set NIM = $d->nim, NAMA = '$d->nama', PRODI = $d->prodi,
		JURUSAN = $d->jurusan, IPK = $d->ipk, GAJI = $d->gaji, SEMESTER = $d->semester, JENKEL = '$d->jenkel',
		REKLISTRIK = $d->reklistrik, JMLPIAGAM = $d->jmlpiagam, PROPOSALPKM = '$d->proposalpkm',
		BEASISWA = $d->beasiswa where ID = $d->id;");
		if($q) echo 1;
		else echo 2;
	} else echo 3;

} else if($view == "delete"){
	$query = mysqli_query($con,"select * from mila_sample where ID = '$id';");
	if($query && mysqli_num_rows($query) > 0){
		$query = mysqli_query($con,"delete from mila_sample where ID = '$id';");
		if(mysql_affected_rows() >= 1) echo 1;
		else echo 3;
	}else{
		echo 2;
	}

} else if($view == "prodi"){
	$qry = mysqli_query($con,"select * from mila_prodi where JURUSAN = $id");
	while($row = mysqli_fetch_array($qry)){
	?>
		<option value="<?php echo $row['ID']; ?>"><?php echo $row['JENJANG'].' '.$row['PRODI']; ?></option>
	<?php }

} else { ?>
<h2><?php echo $_POST['target'];?></h2>
<div id="sample" class="panel panel-primary filterable">
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
				<th><input type="text" size=10 class="form-control" placeholder="#" title="No." disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="NIM" title="NIM" disabled></th>
				<th><input type="text" size=80 class="form-control" placeholder="Nama Lengkap" title="Nama Lengkap" disabled></th>
				<th><input type="text" size=10 class="form-control" placeholder="L/P" title="L/P" disabled></th>
				<th><input type="text" size=15 class="form-control" placeholder="SMT" title="SMT" disabled></th>
				<th><input type="text" size=40 class="form-control" placeholder="Prodi" title="Prodi" disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="Jurusan" title="Jurusan" disabled></th>
				<th><input type="text" size=15 class="form-control" placeholder="IPK" title="IPK" disabled></th>
				<th><input type="text" size=40 class="form-control" placeholder="Gaji Ortu" title="Gaji Ortu" disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="R. Listrik" title="Rek. Listrik" disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="Piagam" title="Jml. Piagam" disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="Prop. PKM" title="Proposal PKM" disabled></th>
				<th><input type="text" size=30 class="form-control" placeholder="Beasiswa" title="Beasiswa" disabled></th>
				<th>Edit</th>
				<th>Hapus</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$query 	= mysqli_query($con,"select * from view_sample");
				if($query && mysqli_num_rows($query) > 0){ $num=0;
					while($row = mysqli_fetch_object($query)){$num++;
						$qry = mysqli_query($con,"select BEASISWA from mila_beasiswa where ID=$row->BEASISWA;");
						$bsw = mysqli_fetch_object($qry);?>
						<tr id="tr<?php echo $row->ID;?>">
							<td><?php echo $num;?></td>
							<td><?php echo $row->NIM;?></td>
							<td class="name"><?php echo $row->NAMA;?></td>
							<td><?php echo $row->JENKEL;?></td>
							<td><?php echo $row->SEMESTER;?></td>
							<td><?php echo $row->PRODI;?></td>
							<td><?php echo $row->JURUSAN;?></td>
							<td><?php echo $row->IPK;?></td>
							<td><?php echo number_format($row->GAJI, 0, ',', '.');?></td>
							<td><?php echo number_format($row->REKLISTRIK, 0, ',', '.');?></td>
							<td><?php echo $row->JMLPIAGAM;?></td>
							<td><?php echo ($row->PROPOSALPKM=='Y')?"YA":"TIDAK";?></td>
							<td><?php echo (isset($bsw->BEASISWA))?$bsw->BEASISWA:"TIDAK";?></td>
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
