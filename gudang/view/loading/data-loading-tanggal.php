<h1 class='page-head-line'>Data Loading</h1>
<h1 class="page-subhead-line">
Transaksi Tanggal : <?php 
$tgl = get("tgl");
echo tanggal($tgl); 
?>
</h1>

<a href='<?php echo kembali() ?>' class='btn btn-danger'><i class='fa fa-angle-double-left'></i> kembali</a>

<?php 
if(isset($_GET['act']))
{
	$act=get("act");
	$id=get("id");
	//BELUM SELESAI
	if($act=='belum selesai')
	{
		direct(menu('stock'));
		$_SESSION['id_cart']=$id;
		echo alert("Berhasil, Silahkan ke Stock on Hand untuk memilih barang yang dibutuhkan!");
	}
	else if($act=='batal'){
		$status='batal';
		$q=mysql_query("update loading_aksesoris set status_loading='$status', date_modified=now() where id_loading_aksesoris='$id'");
		if($q)
		{
			echo alert("Berhasil dibatalkan!");
			direct(kembali());
		}
		else{
			echo alert_error("Error : ". mysql_error());
		}
	}
}
?>
<table class='table'>
	<thead>
		<tr>
			<th>No. </th>
			<th>Nama</th>
			<th>Departemen</th>
			<th>Keterangan</th>
			<th colspan=2>#</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=1;
		$q=mysql_query("select * from loading_aksesoris inner join departemen on departemen.kode_departemen=loading_aksesoris.kode_departemen where tanggal_loading_aksesoris ='$tgl' order by id_loading_aksesoris desc") or die(alert_error("Error : ". mysql_error()));
		while($r=mysql_fetch_array($q)){
		$status = $r['status_loading'];
		if($status=='belum selesai')
			$label='warning';
		else if($status=='selesai')
			$label='success';
		else if($status=='batal')
			$label='danger';
		else if($status=='retur')
			$label='info';
		$karyawan=cek_karyawan($r['id_karyawan_2']);
		?>
		<tr>
			<td><?php echo $no ?></td>
			<td>
				<a href='<?php echo menu("detail_loading&id=$r[id_loading_aksesoris]&url=". url_ref()) ?>'>
					<?php echo $karyawan['nama_lengkap'] ; ?>
				</a>
			</td>
			<td><?php echo $r['nama_departemen'] ?></td>
			<td><?php echo $r['keterangan_loading_aksesoris'] ?></td>
			<td>
				<span class='label label-<?php echo $label ?>'><?php echo $status?></span>
				
			</td>
			<td>
				<?php 
				if($r['status_loading']=='belum selesai')
				{
					?>
				<a class=' btn btn-xs btn-info' href='<?php echo menu("data-loading-tanggal&act=belum selesai&id=$r[id_loading_aksesoris]&url=".url_ref()) ?>' title='Lanjutkan loading'><i class='fa fa-shopping-cart'></i> </a>
				<a class='btn btn-xs btn-danger' href='<?php echo menu("data-loading-tanggal&tgl=$tgl&act=batal&id=$r[id_loading_aksesoris]&url=".url_ref()) ?>' title='Batal Loading?'><i class='fa fa-times'></i> </a>
					<?php
				}
				?>
			</td>
		</tr>
			<?php
			$no++;
		}
		?>
		
	</tbody>
</table>