<?php
	function probabilitas($KOLOM){
		$bsw = mysqli_query($GLOBALS['con'],"select ID, BEASISWA as B from mila_beasiswa where AKTIF=1");
		$jmlbsw = mysqli_num_rows($bsw); while($r=mysqli_fetch_object($bsw)){$beasiswa[$r->ID]=$r->B;}

		if($KOLOM=="PRODI")
			$tabel = mysqli_query($GLOBALS['con'],"select ID, concat(JENJANG,' ',PRODI) as S from mila_prodi order by S ASC");
		else $tabel = mysqli_query($GLOBALS['con'],"select distinct($KOLOM) as S from mila_sample order by S ASC");
		$num=0; while($row = mysqli_fetch_object($tabel)){$num++;
			$item[]=$row->S; $sql=null; $n = $jmlbsw;
			foreach($beasiswa as $key =>$val){
				$n--; $NA = ($KOLOM=="PRODI")?$row->ID:$row->S;
				$sql .= "SELECT count(ID) as NILAI FROM mila_sample ";
				$sql .= "where BEASISWA=".$key." and CAST($KOLOM AS CHAR)=CAST('$NA' AS CHAR)";
				$sql .= " UNION ALL ";
				if($n==0){
					$sql .= "SELECT count(ID) as NILAI FROM mila_sample ";
					$sql .= "where BEASISWA=0 and CAST($KOLOM AS CHAR)=CAST('$NA' AS CHAR)";
				}
			}

			$ex = mysqli_query($GLOBALS['con'], $sql);
			while($x=mysqli_fetch_object($ex)){
				$nilai[$num-1][] = $x->NILAI;
			}
		}

		$baris = array();
		foreach($nilai as $key => $value){
			foreach($value as $a => $b){
				$baris[$a][] = $b;
			}
		}

		$total = $mean = $dev = $jdev = $sdev = array();
		foreach($baris as $c => $d){
			// Nilai Maksimum
			$maks[$c] = max($baris[$c]);

			// Total X1 s/d Xn
			$total[$c] = array_sum($baris[$c]);

			// Mean (Rata2)
			$mean[$c] = $total[$c]/$num;

			// Standar Deviasi
			foreach($d as $e => $f){
				$dev[$c][] = pow($f-$mean[$c], 2);
			}
			$jdev[$c] = array_sum($dev[$c]);
			$sdev[$c] = sqrt($jdev[$c] / ($num-1));
		}

		$result = array(
			"BEASISWA"	=> ($beasiswa),
			"ITEM" 		=> ($item),
			"NILAI"		=> ($nilai),
			"MAX"		=> ($maks),
			"TOTAL"		=> ($total),
			"MEAN"		=> ($mean),
			"STDEV"		=> ($sdev)
		);

		return json_encode($result);
	}

	function update_probabilitas(){
		$sql = mysqli_query($GLOBALS['con'],"select ID, KOLOM from mila_probabilitas;");
		while($hsl = mysqli_fetch_object($sql)){
			$d = "'".probabilitas($hsl->KOLOM)."'";
			$q = mysqli_query($GLOBALS['con'],"update mila_probabilitas set DATA = $d where ID = $hsl->ID;");
		}
	}

	function get_probabilitas($KOLOM){
		$sql = mysqli_query($GLOBALS['con'],"select DATA from mila_probabilitas where KOLOM = '$KOLOM';");
		$hsl = mysqli_fetch_object($sql);
		return $hsl->DATA;
	}

	function prob_grafik($element, $result){
		$result = json_decode($result);
		$graph['element'] = $element;
		foreach($result->NILAI as $key => $value){
			$node["ITEM"] = $result->ITEM[$key];
			foreach($value as $a => $b){
				$c = $a+1;
				$k = isset($result->BEASISWA->$c)?
					 $result->BEASISWA->$c:"TIDAK";
				$node[$k] = $b;
			}
			$graph['data'] = $node;
		}
		$graph['xkey'] = 'ITEM';
		foreach($result->BEASISWA as $a => $b){
			$graph['ykey'][] = $b;
			$graph['labels'][] = $b;
		}
		$graph['hideHover'] = 'auto';
		$graph['resize'] = true;

		return json_encode($graph);
	}

	function _ebeasiswa($beasiswa){
		foreach($beasiswa as $key =>$val){
			echo "<th><input type=\"text\" size=30 class=\"form-control\" placeholder=\"$val\" title=\"$val\" disabled></th>";
		}
		echo "<th><input type=\"text\" size=30 class=\"form-control\" placeholder=\"TIDAK\" title=\"TIDAK\" disabled></th>";
	}

	function _enilai($item, $nilai, $total, $tipe=null){
		foreach($nilai as $key => $value){
			echo "<tr id=\"tr".($key+1)."\">";
			echo "<td>".($key+1)."</td>";
			switch($tipe){
				default:
				echo "<td>".$item[$key]."</td>";
				break;

				case 'numeric':
				echo "<td>Rp. ".number_format($item[$key],0,',','.')."</td>";
				break;

				case 'semester':
				echo "<td>Semester ".$item[$key]."</td>";
				break;

				case 'piagam':
				echo "<td>".$item[$key]." Piagam</td>";
				break;

				case 'jenkel':
				echo "<td>";
				echo ($item[$key]=="L")?"Laki-laki":"Perempuan";
				echo "</td>";
				break;

				case 'pkm':
				echo "<td>";
				echo ($item[$key]=="Y")?"Ya":"Tidak";
				echo "</td>";
				break;
			}
			foreach($value as $a => $b){
				echo "<td>$b/$total[$a]</td>";
			}
			echo "</tr>";
		}
	}

	function _ehitung($title, $nilai, $koma=-1, $total=null){
		echo "<tr id=\"tr$title\">";
		echo "<th colspan=2>$title</th>";
		foreach($nilai as $k => $v){
			if($koma>=0){
				$val = number_format($v, $koma, ",", ".");
				if(is_null($total)) echo "<th>$val</th>";
				else echo "<th>$val/$total[$k]</th>";
			}else{
				if(is_null($total)) echo "<th>$v</th>";
				else echo "<th>$v/$total[$k]</th>";
			}
		}
		echo "</tr>";
	}

	function _etable($title, $result, $tipe=null, $mean=false, $stdev=false){ $result = json_decode($result); ?>
		<div class="panel panel-primary filterable probabilitas" style="margin-bottom:0px;">
			<table class="table">
				<thead>
					<tr class="filters">
						<th><input type="text" size=10 class="form-control" placeholder="#" title="No." disabled></th>
						<th><input type="text" size=50 class="form-control" placeholder="<?php echo $title;?>" title="<?php echo $title;?>" disabled></th>
						<?php _ebeasiswa($result->BEASISWA); ?>
					</tr>
				</thead>
				<tbody>
					<?php _enilai($result->ITEM, $result->NILAI, $result->TOTAL, $tipe); ?>
				</tbody>
				<tfoot>
					<?php _ehitung("Tertinggi", $result->MAX, -1, $result->TOTAL); ?>
					<?php _ehitung("Total", $result->TOTAL); ?>
					<?php if($mean) _ehitung("Mean (Rata-rata)", $result->MEAN, 3); ?>
					<?php if($stdev) _ehitung("Standar Deviasi", $result->STDEV, 3); ?>
				</tfoot>
			</table>
		</div>
	<?php }

	function densitas_gauss($stdev, $mean, $x){
		$phi = 22/7; $e = 2.71828182846;
		$ret = 1 / sqrt(2*$phi*$stdev);
		$epo = pow($e, ( -1*((pow($x-$mean, 2)) / (2*pow($stdev, 2))) ) );
		$ret = $ret * $epo;
		return $ret;
	}
	function update_rekomendasi(){
		$sql = mysqli_query($GLOBALS['con'],"select KOLOM, DATA from mila_probabilitas;");
		while($hsl = mysqli_fetch_object($sql)) $data[$hsl->KOLOM] = json_decode($hsl->DATA);
		foreach($data as $p => $q) foreach($q->ITEM as $k => $v) $ovale[$p][$v] = $q->NILAI[$k];
		$mhs = mysqli_query($GLOBALS['con'],"select * from view_mahasiswa");
		while($row=mysqli_fetch_object($mhs)){
			$beasiswa = end($data)->BEASISWA;
			foreach($beasiswa as $key =>$val){
				foreach($data as $p => $q){
					$hasil[$p][$val]['VAL'] = (array_key_exists($row->$p, $ovale[$p]))?$ovale[$p][$row->$p][$key-1]:0;
					if($p=="IPK" or $p=="GAJI" or $p=="REKLISTRIK"){
						$hasil[$p][$val]['STDEV'] = $q->STDEV[$key-1];
						$hasil[$p][$val]['MEAN']  = $q->MEAN[$key-1];
						$hasil[$p][$val]['NILAI'] = densitas_gauss($q->STDEV[$key-1], $q->MEAN[$key-1], $hasil[$p][$val]['VAL']);
					}else{
						$hasil[$p][$val]['TOTAL'] = $q->TOTAL[$key-1];
						$hasil[$p][$val]['NILAI'] = $hasil[$p][$val]['VAL'] / $q->TOTAL[$key-1];
					}

					if(end($beasiswa)==$val){
						$hasil[$p]['TIDAK']['VAL'] = (array_key_exists($row->$p, $ovale[$p]))?$ovale[$p][$row->$p][$key]:0;
						if($p=="IPK" or $p=="GAJI" or $p=="REKLISTRIK"){
							$hasil[$p]['TIDAK']['STDEV'] = $q->STDEV[$key];
							$hasil[$p]['TIDAK']['MEAN']  = $q->MEAN[$key];
							$hasil[$p]['TIDAK']['NILAI'] = densitas_gauss($q->STDEV[$key], $q->MEAN[$key], $hasil[$p]['TIDAK']['VAL']);
						}else{
							$hasil[$p]['TIDAK']['TOTAL'] = $q->TOTAL[$key];
							$hasil[$p]['TIDAK']['NILAI'] = $hasil[$p]['TIDAK']['VAL'] / $q->TOTAL[$key];
						}
					}
				}
			}

			foreach($beasiswa as $key =>$val){
				$ping = null;
				foreach($data as $p => $q){
					$ping[$val][] = $hasil[$p][$val]['NILAI'];
					if(end($beasiswa)==$val)
						$ping['TIDAK'][] = $hasil[$p]['TIDAK']['NILAI'];
				}
				$hasil['LIKELIHOOD'][$val] = array_product($ping[$val]);
				if(end($beasiswa)==$val)
					$hasil['LIKELIHOOD']['TIDAK']=array_product($ping['TIDAK']);
			}
			foreach($beasiswa as $key =>$val){
				$hasil['PROBABILITY'][$val]['TOTAL'] = array_sum($hasil['LIKELIHOOD']);
				if(end($beasiswa)==$val):
					$hasil['PROBABILITY']['TIDAK']['TOTAL'] = array_sum($hasil['LIKELIHOOD']);
				endif;

				if(array_sum($hasil['LIKELIHOOD'])>0):
					$hasil['PROBABILITY'][$val]['NILAI'] = $hasil['LIKELIHOOD'][$val] / $hasil['PROBABILITY'][$val]['TOTAL'];
					if(end($beasiswa)==$val):
						$hasil['PROBABILITY']['TIDAK']['NILAI'] = $hasil['LIKELIHOOD']['TIDAK'] / $hasil['PROBABILITY']['TIDAK']['TOTAL'];
					endif;
				else:
					$hasil['PROBABILITY'][$val]['NILAI'] = 0;
					if(end($beasiswa)==$val):
						$hasil['PROBABILITY']['TIDAK']['NILAI'] = 0;
					endif;
				endif;
			}
			if(max($hasil['LIKELIHOOD'])>0)
				$hasil['REKOMENDASI'] = array_search(max($hasil['LIKELIHOOD']), $hasil['LIKELIHOOD']);
			else
				$hasil['REKOMENDASI'] = "UNKNOWN";

			//$result[$row->NIM] = $hasil;
			$rets = json_encode($hasil);
			$query = mysqli_query($GLOBALS['con'],"select * from mila_rekomendasi where NIM = '$row->NIM'");
			if(mysqli_num_rows($query) == 0){
				mysqli_query($GLOBALS['con'],"insert into mila_rekomendasi (NIM, DATA, REKOMENDASI) values ($row->NIM, '$rets', '$hasil[REKOMENDASI]');");
			}else{
				mysqli_query($GLOBALS['con'],"update mila_rekomendasi set DATA='$rets', REKOMENDASI='$hasil[REKOMENDASI]' where NIM = '$row->NIM';");
			}
		}
		//return (json_encode($result));
	}

	function _epopulasi($title, $data, $koma=-1){ ?>
		<div class="panel panel-primary populasi">
			<div class="panel-body">
				<table class="table">
				<tbody>
					<?php foreach($data as $c => $d): ?>
					<tr>
						<th rowspan=2><?php echo "P ($title | $c)";?></th>
						<td><input type="text" placeholder="<?php echo $d->VAL;?>" title="<?php echo $d->VAL;?>" disabled></td>
						<td rowspan=2> = <?php echo ($koma>=0)?number_format($d->NILAI,$koma,',','.'):$d->NILAI;?></td>
					</tr>
					<tr class="per">
						<td><input type="text" placeholder="<?php echo $d->TOTAL;?>" title="<?php echo $d->TOTAL;?>" disabled></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			</div>
		</div>
	<?php }

	function _elikelihood($data, $koma=-1){ ?>
		<div class="panel panel-primary populasi">
			<div class="panel-body">
				<table class="table">
				<thead>
				<tr>
					<th class="center">BEASISWA</th>
					<?php $dt=0; foreach($data as $a => $b): $dt++; if($dt>8) break;
					switch($a){
						default: 		    $item=$a; break;
						case "REKLISTRIK": 	$item="LISTRIK"; break;
						case "JMLPIAGAM": 	$item="PIAGAM"; break;
						case "PROPOSALPKM": $item="P. PKM"; break;
					}
					?>
					<th class="center"><?php echo $item;?></th><th>&nbsp;</th>
					<?php endforeach; ?>
					<th class="center">HASIL</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach(reset($data) as $a => $b): ?>
				<tr>
					<th rowspan=2><?php echo $a;?></th>
					<?php $dt=0; $hit=null; foreach($data as $c => $d): $dt++; if($dt>8) break; ?>
					<?php if($dt<4 or $dt>6): $val=$d->$a->VAL;?>
					<td><input type="text" placeholder="<?php echo $val;?>" title="<?php echo $val;?>" disabled></td>
					<?php else: $nil=($koma>=0)?number_format($d->$a->NILAI,$koma,',','.'):$d->$a->NILAI;?>
					<td rowspan=2><input type="text" placeholder="<?php echo $nil;?>" title="<?php echo $nil;?>" disabled></td>
					<?php endif; ?>
					<?php echo ($dt==8)?"<td rowspan=2 class=\"center\"> = </td>":"<td rowspan=2 class=\"center\"> x </td>";?>
					<?php endforeach; ?>
					<?php $lik=$nil=($koma>=0)?number_format($data->LIKELIHOOD->$a,$koma,',','.'):$data->LIKELIHOOD->$a; ?>
					<td rowspan=2 class="wide"><input type="text" placeholder="<?php echo $lik;?>" title="<?php echo $lik;?>" disabled></td>
				</tr>
				<tr class="per">
					<?php $dt=0; $hit=null; foreach($data as $c => $d): $dt++; if($dt>8) break; ?>
					<?php if($dt<4 or $dt>6): $tot=$d->$a->TOTAL;?>
					<td><input type="text" placeholder="<?php echo $tot;?>" title="<?php echo $tot;?>" disabled></td>
					<?php endif; ?>
					<?php endforeach; ?>
				</tr>
				<?php endforeach; ?>
				</tbody>
				</table>
			</div>
		</div>
	<?php }

	function _eproba($data, $koma=-1){ ?>
		<div class="panel panel-primary populasi">
			<div class="panel-body">
				<table class="table">
				<tbody>
					<?php foreach($data->LIKELIHOOD as $c => $d): ?>
					<?php $d = ($koma>=0)?number_format($d,$koma,',','.'):$d;?>
					<?php $e = ($koma>=0)?number_format($data->PROBABILITY->$c->NILAI,$koma,',','.'):$data->PROBABILITY->$c->NILAI;?>
					<?php $f = ($koma>=0)?number_format($data->PROBABILITY->$c->TOTAL,$koma,',','.'):$data->PROBABILITY->$c->TOTAL;?>
					<tr>
						<th rowspan=2><?php echo $c;?></th>
						<td class="wide"><input size="150" type="text" placeholder="<?php echo $d;?>" title="<?php echo $d;?>" disabled></td>
						<td rowspan=2> = <?php echo $e;?></td>
					</tr>
					<tr class="per">
						<td class="wide"><input size="150" type="text" placeholder="<?php echo $f;?>" title="<?php echo $f;?>" disabled></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			</div>
		</div>
	<?php }

	function _estdeviasi($title, $data, $koma=-1){ ?>
		<div class="panel panel-primary populasi">
			<div class="panel-body">
				<table class="table">
				<tbody>
					<?php foreach($data as $c => $d):
					$stdev	  = ($koma>=0)?number_format($d->STDEV,$koma,',','.'):$d->STDEV;
					$mean	  = ($koma>=0)?number_format($d->MEAN,$koma,',','.'):$d->MEAN;
					$value	  = ($koma>=0)?number_format($d->VAL,$koma,',','.'):$d->VAL;
					$nilai	  = ($koma>=0)?number_format($d->NILAI,$koma,',','.'):$d->NILAI;
					$urltex   = "http://latex.codecogs.com/png.latex?\\dpi{150} ";
					$gambar1  = $urltex."\\frac{1}{\\sqrt{2\\pi\\sigma}}e^{\\frac{-\\left(x-\\mu\\right)^{2}}{2\\sigma^{2}}}";
					$gambar2  = $urltex."\\frac{1}{\\sqrt{2 . \\pi . ".$stdev."}}e^";
					$gambar2 .= "{\\frac{-\\left(".$value." - ".$mean."\\right)^{2}}{2 . ".$stdev."^{2}}}";
					$gambar3  = $urltex.$nilai;
					?>
					<tr>
						<th class="middle"><?php echo "P ($title | $c)";?></th>
						<td class="middle"> = </td>
						<td class="middle"><img src="<?php echo $gambar1;?>" /></td>
						<td class="middle"> = </td>
						<td class="middle"><img src="<?php echo $gambar2;?>" /></td>
						<td class="middle"> = </td>
						<td class="middle"><img src="<?php echo $gambar3;?>" /></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
			</div>
		</div>
	<?php }
