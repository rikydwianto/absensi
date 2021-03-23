<h1 class='page-head-line'>Loading</h1>
<h1 class="page-subhead-line">Transaksi Perpindahan Barang Gudang ...</h1>
 <br/>
<?php 
if(!empty(@post('loading')))
{
	@$nik=post("nik");
	$q=mysql_query("select id_karyawan,nama_lengkap,nama_departemen  from karyawan join jabatan on karyawan.id_jabatan=jabatan.id_jabatan join departemen on departemen.id_departemen=jabatan.id_departemen where nik='$nik'") or die(alert_error("Error : ". mysql_error()));
	if(!mysql_num_rows($q))
	{
		echo alert_error("Karyawan Tidak Ditemukan!, Proses tidak dapat dilanjutkan !");
	}
	else
	{
		$id_input=$_SESSION['ID'];
		$id=mysql_fetch_array($q);
		$id_karyawan_2=$id['id_karyawan'];
		$keterangan=post("keterangan");
		$kode_departemen=post("departemen");
		$query=mysql_query("
		insert into loading_aksesoris(id_karyawan,id_karyawan_2,kode_departemen,keterangan_loading_aksesoris,tanggal_loading_aksesoris,status_loading)
		values('$id_input','$id_karyawan_2','$kode_departemen','$keterangan',curdate(),'belum selesai')
		");
		if($query){
			direct(menu('stock'));
			$_SESSION['id_cart']=mysql_insert_id();
			echo alert("Berhasil, Silahkan ke Stock on Hand untuk memilih barang yang dibutuhkan!");
		}
		else{
			echo alert_error("Error : ". mysql_error());
		}
	}

}
?>
<form method=post>
	<table class='table'>
		<tr>
			<td>NIK</td>
			<td>
				<input onkeyup='cek_nik(this)' onkeydown='stopRKey(this)' onblur='cek_nik(this)' type=text class='form-control' required name='nik' id='nik' /> <br/>
				
				<p class="help-block" id='nama_karyawan' style='color:red'></p>
			</td>
		</tr>
		<tr>
			<td>untuk keperluan departemen?</td>
			<td>
				<select name='departemen' class='form-control'>
					<option value=''>Pilih Departemen</option>
					<?php 
					$q=mysql_query("select * from departemen order by kode_departemen ");
					while($Dep=mysql_fetch_array($q)){
						echo"<option value='$Dep[kode_departemen]'>$Dep[kode_departemen] - $Dep[nama_departemen]</option>";
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>Keterangan</td>
			<td>
				<textarea name='keterangan' class='form-control'></textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=submit name='loading' class='btn btn-danger' value='Lanjutkan'/>
			</td>
		</tr>
	</table>
</form>

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