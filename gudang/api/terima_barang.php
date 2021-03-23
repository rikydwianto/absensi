<?php include"../config/setting.php"?>
<?php include"../config/koneksi.php"?>
<?php include"../fungsi/config.php"?>
<?php
$id= post('id_order');
$q=mysql_query("select * from order_aksesoris 
	join buyer on order_aksesoris.id_buyer=buyer.id_buyer 
	join suplier on order_aksesoris.id_suplier=suplier.id_suplier where id_order='$id'");

$barang=mysql_query("select sum(qty_datang) as barang from kedatangan_barang where id_order='$id'");
$barang=mysql_fetch_array($barang);
$barang=$barang['barang'];
if(empty($barang))
{
	$barang=0;
}
else{
	$barang=$barang;
}
$r=mysql_fetch_array($q);
$status=$r['status_order'];
if($status=='sukses' || $barang==$r['totalqty'])
{
	echo"Barang Sudah Sukses/sudah diterima, Tidak bisa dirubah lagi!";
}
else
{

?>
<div id='loading'><center><img src='<?php url() ?>assets/img/loading.gif'/></center></div>
<form id='form_terima_barang' onsubmit="return false">
	<input type=hidden name='id_order' value='<?php echo $id?>'>
	<table class='table'>
		<tr>
			<td>Tanggal Kedatangan</td>
			<td>
				<input class='form-control' id='tgl' type=text name='tgl_datang' value='<?php echo date("d/m/Y") ?>'/>
				<p class="help-block" style='color:red'>
					HH/BB/TTTT
				</p>
			</td>
		</tr>
		<tr>
			<td>QTY Order</td>
			<td>
				<div class="input-group">
				  <input class='form-control' id='qty_order' type=text name='qty_order' aria-describedby="sizing-addon2" value='<?php echo $r['totalqty'] ?>' readonly />
				  <span class="input-group-addon" id="sizing-addon2"><?php echo $r['satuan'] ?></span>
				</div>

			</td>
		</tr>
		<tr>
			<td>Sudah Diterima</td>
			<td><input class='form-control' onblur='hitung_qty_datang()' value='<?php echo $barang ?>' name='qty_sudah_terima' id='qty_sudah_terima' type=text readonly /></td>
		</tr>
		<tr>
			<td>QTY Datang</td>
			<td><input class='form-control'  onkeyup='hitung_qty_datang()' onblur='hitung_qty_datang()' id='qty_terima' type=text name='qty_terima' /></td>
		</tr>
		<tr>
			<td>QTY Order - QTY Datang</td>
			<td><input class='form-control' readonly id='total' type=text name='total' /></td>
		</tr>
		<tr>
			<td>Status</td>
			<td><input class='form-control' readonly id='status' type=text name='status' /></td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td><textarea class='form-control' id='keterangan' name='keterangan' ></textarea></td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>
				<input class='btn btn-danger' type=submit id='terima_barang1' name='terima_barang' value='Terima Barang' />
				<p class="help-block" style='color:red'><small>jika anda "mengklik Tombol 'Terima Barang'" Berarti anda sudah mengecek barang, akan menerima barang, dan menyetujui syarat&amp;ketentuan !
				<br/>
				Barang akan langsung dijadikan Stock Gudang!
				</small> </p>
			</td>
		</tr>
		
	</table>
</form>
	<div id='html_datang'></div>
<script>
	
	function hitung_qty_datang()
	{			
		var qty_order = $("#qty_order").val();
		var qty_terima = $("#qty_terima").val();
		var qty_sudah_terima = parseFloat($("#qty_sudah_terima").val());
		var total = qty_terima - qty_order + qty_sudah_terima;
		// total = Math.round(total);
		$("#total").val(total);
		if(total< 0)
		{
			$("#status").val('kurang');
		}
		else if(total==0){
			$("#status").val('sesuai');
		}
		else
		{
			$("#status").val('lebih');
		}
		
	}
	
	$("#terima_barang1").click(function(){
		var data=$("#form_terima_barang").serialize();
		$.ajax({
			url:laman+"api/confirm_barang.php",
			type:'POST',
			data:data,
			beforeSend:function(){
				$("#loading").show();
				$("#form_terima_barang").hide();
			},
			success:function(html){
				//$("#loading").hide();
				//$("#form_terima_barang").show();
				$("#loading").html("<img src='"+laman+"assets/img/success.png' />");
				$("#html_datang").html(html);
			},
			error:function(er,a,trow){
				alert("Error : " + trow + " \n Kode : " + er.status);	
			}
		});
	});
	
</script>
<?php 
} 
?>