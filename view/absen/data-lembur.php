
<h2>Data Lembur </h2>
<form method=post>
Pilih  : <select name='bulan'>
	<?php
	$bln=bulan();
	$hitung= count($bln);
	for($i=1;$i<=$hitung;$i++)
	{
		if($i==date('m') || $_POST['bulan']==$i)
			$sel="selected";
		else
			$sel="";
		echo"<option $sel value='$i'>$bln[$i]</option>";
	}
	?>
</select>
<select name='tahun'>
	<?php 
	$th=date("Y");
	for($a=$th;$a>2010;$a--)
	{
		echo "<option value='$a'>$a</option>";
	}
	?>
</select>
<input type=submit value='Cari' name='cr'/>
</form>

<table class='table table-hover' id='example1'>
	<thead>
		<tr>
			<td>No.</td>
			<td>Tanggal</td>
			<td>Jam</td>
			<td>Keterangan</td>
			<td>#</td>
		</tr>
	</thead>
	<tbody>
		<?php 
		if(isset($_POST['cr']))
		{
			$t=aman($_POST['tahun']);
			$b=aman($_POST['bulan']);
		}
		else{
			$b=date("m");
			$t=date("Y");
		}
		$no=1;
		$b=sprintf('%02s', $b);
		$q=data_lembur($b,$t);
		while($r=mysql_fetch_object($q)){
			if($r->tanggal_lembur==date("Y-m-d"))
				$sty="class='bg-aqua'";
			else
				$sty='';
		?>
		<tr <?php echo $sty ?>>
			<td><?php echo $no ?></td>
			<td><?php echo tanggal($r->tanggal_lembur)?></td>
			<td><?php echo $r->jam_mulai_lembur ?></td>
			<td><?php echo $r->keterangan ?></td>
			<td>
				<a href='<?php echo url("index.php?mn=lembur&act=hapus&id=$r->id_lembur_setting&url=".url_ref()) ?>' class='btn btn-danger btn-flat'><i class='fa fa-times'></i></a>
				<a href='<?php echo url("index.php?mn=lembur&act=edit&id=$r->id_lembur_setting&url=".url_ref()) ?>' class='btn bg-navy btn-flat'><i class='fa fa-edit'></i></a>
			</td>
		</tr>
			
			<?php
			$no++;
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<td>No.</td>
			<td>Tanggal</td>
			<td>Jam</td>
			<td>Keterangan</td>
			<td>#</td>
		</tr>
	</tfoot>
</table>