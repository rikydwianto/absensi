<?php
include_once"fungsi/karyawan.php";
$id_cart=get("id");
$no=1;
$q=mysql_query("select * from loading_aksesoris join departemen on departemen.kode_departemen=loading_aksesoris.kode_departemen where id_loading_aksesoris='$id_cart'");
$rKaryawan=mysql_fetch_array($q);
$penerima=cek_karyawan($rKaryawan['id_karyawan_2']);
$pemberi=cek_karyawan($rKaryawan['id_karyawan']);
$query=mysql_query("select * from loading_aksesoris join detail_loading_aksesoris on loading_aksesoris.id_loading_aksesoris=detail_loading_aksesoris.id_loading_aksesoris
	join stock_aksesoris on stock_aksesoris.id_stock=detail_loading_aksesoris.id_stock where loading_aksesoris.id_loading_aksesoris='$id_cart'
");
$status = $rKaryawan['status_loading'];
if($status=='belum selesai')
	$label='warning';
else if($status=='selesai')
	$label='success';
else if($status=='batal')
	$label='danger';
?>
<table>
	<tr>
		<td>Yang Memberi/Input</td>    
		<td><?php echo $pemberi['nama_lengkap'] ?></td>                          
	</tr>                              
	<tr>
		<td>Yang Meminta Barang</td>
		<td><?php echo ($penerima['nama_lengkap'])?></td>
	</tr>
	<tr>   
		<td>Keperluan Untuk Departemen</td>      
		<td>&nbsp; <?php echo $rKaryawan['kode_departemen'] ?> - <?php echo $rKaryawan['nama_departemen'] ?></td>  
	</tr>             
	<tr>   
		<td>Tanggal</td>      
		<td>&nbsp; <?php echo tanggal($rKaryawan['tanggal_loading_aksesoris']) ?></td>  
	</tr>             
	<tr>   
		<td>Status</td>      
		<td>
			<span class='label label-<?php echo $label ?>'>
				<?php echo strtoupper($status)?>
			</span>
		</td>  
	</tr>
</table>   
<br/>    
<a href='<?php echo kembali() ?>' class='btn btn-danger'><i class='fa fa-angle-double-left'></i> kembali</a>
<form method=post>  
	<table class='table'>                            
		<thead>
			<tr>      
				<th>No</th> 
				<th>Nama Barang</th>
				<th>Size</th>
				<th>Warna</th>
				<th>QTY</th>
				<th>Satuan</th>
				<th>Keterangan</th>
			</tr>
		</thead> 
		<tbody>  
		<?php    
		if(mysql_num_rows($query)){
		while($rCart=mysql_fetch_array($query))            
		{
		?>       
			<tr> 
				<td>
					<?php echo $no?>                  
					<input type=hidden name='id_stock[]' value='<?php echo $rCart['id_stock'] ?>'/>
					<input type=hidden name='id_detail[]' value='<?php echo $rCart['id_detail_loading_aksesoris'] ?>'/>
				</td>                  
				<td><?php echo $rCart['deskripsi']?></td>  
				<td><?php echo $rCart['size']?></td>       
				<td><?php echo $rCart['warna']?></td>      
				<td><?php echo $rCart['qty_loading'] ?></td>    
				<td><?php echo $rCart['satuan'] ?></td>
				<td>
					<?php echo $rCart['keterangan_detail_loading_aksesoris'] ?>
				</td>
			</tr>
		<?php 
		$no++;
		}
		}
		else{
			echo "<tr><td align=center colspan=7>Tidak ada barang!</td></tr>";
		}
		?>
		</tbody>
	</table>    
</form>
<img src='<?php echo url("data/foto-ambilan/$rKaryawan[tanggal_loading_aksesoris]/$rKaryawan[bukti_loading_aksesoris]") ?>' style='width:100%'/>
<script>
	function hitung_stock(id)
	{
		var qty=$("#qty_" + id).val();
		var qty_stock=$("#qty_stock_" + id).val();
		var total = (qty_stock - qty);
		var cek=Number(qty_stock);
		if(total > 0 || total==0)
		{
			$("#peringatan_qty_" + id).html('');
		}
		else
		{
			$("#peringatan_qty_" + id).html("QTY Melebihi stock on hand");
		}			
	}
</script>