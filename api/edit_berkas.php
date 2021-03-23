<?php 
include"../config/setting.php";
include"../config/koneksi.php";
include"../fungsi/config.php";
include"../fungsi/karyawan.php";
$id=aman($_GET['id']);
$q=mysql_query("select * from berkas where id_berkas='$id'");
$berkas=mysql_fetch_array($q);
$karyawan=detail_karyawan($berkas['id_karyawan']);
$nik=$karyawan->nik;
if(!isset($_GET['act']))
{
?>
	<?php 

	$folder="../data/berkas/$nik/";
	$ext=pathinfo($folder.$berkas['file'],PATHINFO_EXTENSION);
	if($ext=='jpg' || $ext=='gif' || $ext=='png'|| $ext=='bmp')
	{
		$file="<a href='".url()."$folder/$berkas[file]' target=_blank><img src='".url()."$folder/$berkas[file]' class='img' style='width:100%;' /></a>";
	}
	?>
<h1><?php echo $berkas['judul'] ?></h1>
<h4><?php echo $berkas['file'] ?></h4>
<a href='<?php echo url("../data/berkas/$nik/$berkas[file]") ?>' target=_blank class='btn btn-flat btn-danger'><i class='fa fa-eye'></i> Lihat file</a>
<a href='javascript:detail_berkas(<?php echo $berkas['id_berkas'] ?>)'  class='btn btn-flat btn-info'><i class='fa fa-refresh'></i> Refresh</a>
<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
<form method=post onsubmit='return false' id='form_berkas' >
	<table class='table'>
		<tr>
			<td>Nama File</td>
			<td><input type=text name='file' class='form-control' value='<?php echo $berkas['file'] ?>' disabled /></td>
		</tr>
		<tr>
			<td>Judul File</td>
			<td><input type=text name='judul' class='form-control' value='<?php echo $berkas['judul'] ?>' /></td>
		</tr>
		<tr>
			<td>Deskripsi</td>
			<td><textarea name='deskripsi' class='form-control'><?php echo $berkas['deskripsi'] ?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input type=hidden name='id' value='<?php echo $berkas['id_berkas'] ?>' />
				<input type=submit name='edit_berkas' value='Simpan' id='act_berkas' class='btn btn-info btn-flat' />
				<input type=reset value='Reset' class='btn btn-danger btn-flat' />
				
			</td>
		</tr>
		<tr>
			<td colspan=2>
				<?php echo @$file ?>
			</td>
		</tr>
	</table>
</form>


<script>
	$("#act_berkas").click(function(){
		var data=($("#form_berkas").serialize());
		$.ajax({
			url:laman+'api/edit_berkas.php?act=edit',
			data:data,
			type:'POST',
			success:function(){
				$("#berhasil_berkas").modal();
			}
		});
	});
</script>
<?php 
}
else if(isset($_GET['act'])=='edit')
{
	$id=$_POST['id'];
	$judul=$_POST['judul'];
	$deskripsi=$_POST['deskripsi'];
	mysql_query("update berkas set judul='$judul', deskripsi='$deskripsi', date_modified=now() where id_berkas=$id");
}
?>