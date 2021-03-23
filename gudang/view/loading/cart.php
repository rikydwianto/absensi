<?php
include_once"fungsi/karyawan.php";
$id_cart=$_SESSION['id_cart'];
$no=1;
$q=mysql_query("select * from loading_aksesoris join departemen on departemen.kode_departemen=loading_aksesoris.kode_departemen where id_loading_aksesoris='$id_cart'");
$rKaryawan=mysql_fetch_array($q);
$penerima=cek_karyawan($rKaryawan['id_karyawan_2']);
$pemberi=cek_karyawan($rKaryawan['id_karyawan']);
$query=mysql_query("select * from loading_aksesoris join detail_loading_aksesoris on loading_aksesoris.id_loading_aksesoris=detail_loading_aksesoris.id_loading_aksesoris
	join stock_aksesoris on stock_aksesoris.id_stock=detail_loading_aksesoris.id_stock where loading_aksesoris.id_loading_aksesoris='$id_cart'
");

?>
<?php 
if(isset($_POST['next_cart']))
{
	$id_stock=$_POST['id_stock'];
	for($i=0;$i<count($id_stock);$i++)
	{
		$qty=$_POST['qty_loading'][$i];
		$id_detail=$_POST['id_detail'][$i];
		$keterangan=$_POST['keterangan'][$i];
		mysql_query("update stock_aksesoris set qty=qty-$qty, date_modified=now() where id_stock='$id_stock[$i]'");
		mysql_query("update detail_loading_aksesoris set qty_loading=$qty, keterangan_detail_loading_aksesoris='$keterangan',date_modified=now() where id_detail_loading_aksesoris='$id_stock[$i]'");
	}
	$input=mysql_query("update loading_aksesoris set status_loading='selesai', date_modified=now() where id_loading_aksesoris='$id_cart'");
	if($input)
	{
		echo alert("Berhasil disimpan");
		unset($_SESSION['id_cart']);
	}
	else
	{
		echo alert_error("Error : ".mysql_error());
	}
}
if(isset($_POST['batal_cart']))
{
	$input=mysql_query("update loading_aksesoris set status_loading='batal', date_modified=now() where id_loading_aksesoris='$id_cart'");
	if($input)
	{
		echo alert("Loading dibatalkan!");
		unset($_SESSION['id_cart']);
		direct(menu('data-loading'));
	}
	else
	{
		echo alert_error("Error : ".mysql_error());
	}
	
}
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
</table>   
<br/>    
<form method=post>  
	<table class='table'>                            
		<thead>
			<tr>      
				<th>No</th> 
				<th>Nama Barang</th>                       
				<th>Size</th>                              
				<th>Warna</th>                             
				<th>QTY Stock</th>
				<th>QTY</th>
				<th>Keterangan</th>                        
				<th>#</th>  
			</tr>
		</thead> 
		<tbody>  
		<?php    
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
				<td>   
					<div class="input-group">
					   <input type=text name='' id='qty_stock_<?php echo $rCart['id_detail_loading_aksesoris'] ?>' value='<?php echo $rCart['qty']?>' disabled class='form-control' />
						<span class="form-group input-group-btn">
						<label class="btn btn-default"><?php echo $rCart['satuan']?></label>

					  </span>
					</div>

				</td>      
				<td>        
					<div class="input-group">
					   <input type=text name='qty_loading[]' id='qty_<?php echo $rCart['id_detail_loading_aksesoris'] ?>' onkeyup='hitung_stock(<?php echo $rCart['id_detail_loading_aksesoris'] ?>)' onblur='hitung_stock(<?php echo $rCart['id_detail_loading_aksesoris'] ?>)' value='<?php echo $rCart['qty_loading']?>' class='form-control' />
						<span class="form-group input-group-btn">
						<label class="btn btn-default"><?php echo $rCart['satuan']?></label>

					  </span>
					</div>
					<span style='color:red' id='peringatan_qty_<?php echo $rCart['id_detail_loading_aksesoris'] ?>'></span>
				</td>
				<td>
					<textarea name='keterangan[]' class='form-control' style=';font-size:10px'><?php echo $rCart['keterangan_detail_loading_aksesoris'] ?></textarea>
				</td>
				<td><a href='#' class='btn btn-xs btn-danger'><i class='fa fa-times'></i></a></td>
			</tr>
		<?php 
		$no++;
		}
		?>
		</tbody>
		<tfoot>
			<tr>	
				<td colspan=8>
				<div class='pull-right'>
					<button class='btn btn-info' name='next_cart'><i class='fa fa-save'></i> Save &amp; Lanjutkan</button>
					<button class='btn btn-danger' name='batal_cart'><i class='fa fa-times'></i> Batal</button>
				</div>
				</td>
			</tr>
		</tfoot>
	</table>    
</form>         
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