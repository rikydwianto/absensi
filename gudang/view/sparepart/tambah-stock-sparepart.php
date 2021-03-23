<?php 
$id=get('id_sparepart');
if(isset($_POST['kirim']))
{
	$lama=post("lama");
	$baru=post("qty");
	$total=$lama + $baru;
	$insert=mysql_query("insert into stock_sparepart (id_sparepart,tanggal,stock_lama,stock_baru,total_stock)
	values('$id',curdate(),'$lama','$baru','$total')") or die(alert_error("Error : ". mysql_error()));
	$insert=mysqL_query("update sparepart set stock_sparepart=$total where id_sparepart='$id'")  or die(alert_error("Error : ". mysql_error()));
	if($insert)
		$status='berhasil';
	else
		$status='gagal';
}
$q=mysql_query("select * from sparepart where id_sparepart='$id'");
$sp=mysql_fetch_array($q);
?>

<h1 class='page-head-line'>Tambah Sparepart <?php echo $sp['nama_sparepart'] ?></h1>
<a href='<?php echo kembali() ?>' class='btn btn-danger'>Kembali</a>
<a href='<?php echo menu("sparepart") ?>' class='btn'>Data Sparepart</a>
<a href='<?php echo menu("sparepart-no") ?>' class='btn'>Aksesoris</a>

<form method=post id='form'>
	<table class='table'>
			</td>
		</tr>
		<tr>
			<td>Stock Lama</td>
			<td><input type=number id='lama' readonly name='lama' class='form-control' value='<?php echo $sp['stock_sparepart']?>' /></td>
		</tr>
		<tr>
			<td>Stock Baru</td>
			<td><input type=text id='baru' name='qty' onchange='tambah_stok()' onkeyup='tambah_stok()' class='form-control'  /></td>
		</tr>
		<tr>
			<td>Hasil Total</td>
			<td><b id='total'></b></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type=submit name='kirim' value='Simpan' class='btn' /></td>
		</tr>
		
	</table>
</form>
<?php 
if(@$status=='berhasil')
	echo alert("Berhasil ditambahkan");
else if(@$status=='gagal')
	echo alert_error("Berhasil ditambahkan");
?>
<script>
function tambah_stok(){
	var lama=form.lama.value;
	var baru=$("#baru").val();
	var total = Number(lama) + Number(baru) ;
	$("#total").html(total);
}
</script>