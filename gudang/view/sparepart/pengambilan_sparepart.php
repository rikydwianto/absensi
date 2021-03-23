
<h1 class='page-head-line'>Input Data Ambilan Sparepart</h1>
<a href='<?php echo kembali() ?>' class='btn btn-danger'><i class='fa fa-angle-double-left'></i> Kembali</a>
<br/>
<form method=post>
<table class='table'>
	<tr>
		<td>
			Tanggal Ambil
		</td>
		<td>
			<input type=text name='tgl' id='tgl' class='form-control'>
		</td>
	</tr>
	<tr>
		<td>NIK</td>
		<td>
			<input onkeyup='cek_nik(this)' onkeydown='stopRKey(this)' onblur='cek_nik(this)'  class='form-control' type=text required name='nik' id='nik' /> <br/>
			
			<p class="help-block" id='nama_karyawan' style='color:red'></p>
		</td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td><textarea name='ket' class='form-control'></textarea></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<button name='simpan' class='btn btn-danger'><i class='fa fa-plus'></i> Lanjutkan</button>
		</td>
	</tr>
</table>
</form>
<?php
if(isset($_POST['simpan']))
{
	$nik=post("nik");
	$nik=mysql_query("select * from karyawan where nik='$nik'");
	$nik=mysql_fetch_array($nik);
	if(!empty($nik['id_karyawan'])){
		$tgl=ubah_tanggal(post("tgl"));
		$ket=post("ket");
		$q=mysql_query("insert into ambilan(id_karyawan,tanggal_ambilan,keterangan_ambilan) values('$nik[id_karyawan]','$tgl','$ket')");
		if($q){
			echo alert("Berhasil disimpan, silahkan pilih barang yang diambil $nik[nama_lengkap]");	
			$idinput=mysql_insert_id();
			direct(menu("pengambilan_sparepart&nik=$nik[nik]&id=$idinput"));
		}
		else{
			echo alert_error("Gagal, Koneksi/database error : ". mysql_error());
		}
	}
	else
	{
		echo alert_error("<h4>Operasi dihentikan, NIK Tidak ditemukan!</h4>");
	}
}

if(isset($_GET['nik'])){
	$nik=get("nik");
	$nik=mysql_query("select * from karyawan,ambilan where karyawan.id_karyawan=ambilan.id_karyawan and karyawan.nik='$nik'");
	$nik=mysql_fetch_array($nik);
	if(!empty($nik['id_karyawan'])){
	?>
	<h3 class=''>Pilih Sparepart yg diambil <?php echo $nik['nama_lengkap'] ?></h3>
	<h4>
	Tanggal : <?php echo tanggal($nik['tanggal_ambilan']) ?> <br/>
	Keterangan : <?php echo $nik['keterangan_ambilan'] ?> 
	</h4><hr/>
	<form method=post>
		<table class='table-hover'>
			<?php
			$no=1;
			$qsparepart=mysql_query("select * from sparepart where berbayar='ya' order by nama_sparepart asc") or die(mysql_error());
			while($sparepart=mysql_fetch_array($qsparepart))
			{
				$qty=$sparepart['stock_sparepart'];
				if($qty<1)
				{
					$c="style='color:red'";
					$disabled='readonly';
				}
				else{
					$c='';
					$disabled='';
				}
				?>
			<tr <?php echo $c; ?>>
				<td>
					<label>
						 <?php echo $sparepart['nama_sparepart'] ?> 
					</label>
				</td>
				<td>
					<input type='hidden' name='id_spare[]' id='cek_<?php echo $sparepart['id_sparepart']?>' value='<?php echo $sparepart['id_sparepart'] ?>' />
					<input type=number name='qty[]' class='form-control' id='input_<?php echo $sparepart['id_sparepart']?>' <?php echo $disabled ?>/>
					<input type=hidden name='harga[]' class='form-control' id='input_' value='<?php echo $sparepart['harga_sparepart']?>' />					
				</td>
				<td align=left>
					&nbsp;&nbsp;&nbsp;<?php echo rupiah($sparepart['harga_sparepart'])?>
				</td>
				<td align=left>
					&nbsp;&nbsp;&nbsp;<?php echo ($qty)?>
				</td>
			</tr>
				<?php
				$no++;
			}
			?>
			<tr>
				<td colspan=3>
					<center><input type=submit value='Selesai' name='lanjut' class='btn btn-danger'/> </center>
				</td>
			</tr>
		</table>
	</form>
	<?php
	}
	else
	{
		echo alert_error("<h4>Operasi dihentikan, Tidak ditemukan!</h4>");
	}
}
?>

<?php 
if(isset($_POST['lanjut']))
{
	$id=($_POST['id_spare']);
	$id_ambil=get("id");
	$qty1=($_POST['qty']);
	$harga=($_POST['harga']);
	for($i=0;$i<count($id);$i++){
		mysql_query("update sparepart set stock_sparepart=stock_sparepart - $qty1[$i] where id_sparepart='$id[$i]'");
		$input=mysql_query("insert into detail_ambilan_sp(id_ambilan_sp,id_sparepart,qty_ambilan,harga_ambilan)
		values($id_ambil,'$id[$i]','$qty1[$i]','$harga[$i]')
		");
	}
	if($input){
		mysql_query("update ambilan set status_ambilan='sukses' where id_ambilan_sp='$id_ambil'");
		// direct(menu("pengambilan_sparepart"));
	}
	else{
		echo alert_error("error :  ".mysql_error());
	}
}
?>


<script>
function cek_nik(nik){
	nik = nik.value;
	$.ajax({
		url:laman+'api/cek_karyawan.php',
		type:'post',
		data:'nik='+nik,
		beforeSend:function(){
			$("#nama_karyawan").html("Sedang mencari");
		},
		error:function(){
			$("#nama_karyawan").html("Error");
		},
		success:function(html){
			$("#nama_karyawan").html(html);
		}
	});
	return false;
}
function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}
document.onkeypress = stopRKey; 



</script>