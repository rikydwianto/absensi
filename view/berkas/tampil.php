<?php 
$id=aman($_GET['id']);
$karyawan=detail_karyawan($id);
if(isset($_GET['url']))
	$url1= ($_GET['url']);
 else
	$url1= (url("index.php?mn=karyawan"));
if(empty($id) || empty($karyawan)){
	direct($url1);
}
$jabatan=mysql_query("select * from jabatan join departemen on departemen.id_departemen=jabatan.id_departemen where id_jabatan='$karyawan->id_jabatan'");
$jabatan=mysql_fetch_array($jabatan);
$nik=$karyawan->nik;
?>
<style>
#file-4{
}
</style>
<a href='<?php echo $url1?>#<?php echo $id?>' class='btn btn-danger btn-flat'><i class='fa fa-angle-double-left'></i> Kembali</a>
<a href='<?php echo url("index.php?mn=berkas&act=hapus-semua&id=$id&nik=$nik&url=".url_ref()) ?>' class='btn btn-info btn-flat'><i class='fa fa-trash'></i> Hapus Semua Berkas</a>
<a href='' class='btn btn-success btn-flat'><i class='fa fa-refresh'></i> Reload</a>
<table class='table' >
	<tr>
		<td>
		<img src="<?php echo cek_photo($karyawan->id_karyawan)?>" style='float:left;margin:3px'/>
			<table style='color:red;font-size:1.5em' >
				<tr>
					<td>Nik</td>
					<td><?php echo $karyawan->nik ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td><?php echo $karyawan->nama_lengkap ?></td>
				</tr>
				<tr>
					<td>Departemen</td>
					<td><?php echo $jabatan['nama_departemen'] ?></td>
				</tr>
				<tr>
					<td>Jabatan</td>
					<td><?php echo $jabatan['nama_jabatan'] ?></td>
				</tr>
			</table>
		</td>
		<td>
			<!-- UPLOAD FORM -->
			<form method=post enctype='multipart/form-data'> 
					<div class="box">
					
					<input type="hidden" name="url" value='<?php echo url_ref() ?>' /> <br/>
					<input type="file" name="file[]" id="file-4" class="inputfile inputfile-3" data-multiple-caption="{count} files selected" multiple /> <br/>
					<label for="file-4" class='btn btn-danger btn-flat'><span><i class='fa fa-plus'></i> Pilih Berkas&hellip;</span></label>
					<button type='submit' name='upload' class='btn btn-info btn-flat'><i class='fa fa-upload'></i> Upload Berkas</button>
				</div>
				</div>

			</form>
			<?php 
			if(isset($_POST['upload']))
			{
				$folder="data/berkas/$nik/";
				if(!file_exists($folder))
					mkdir("data/berkas/$nik");
				$file=$_FILES['file'];
				for($i=0;$i<count($file['tmp_name']);$i++){
					 if(file_exists($folder.$file['name'][$i])){
						 $namafile=$file['name'][$i];
						 $ext= pathinfo($folder.$namafile, PATHINFO_EXTENSION);
						 $pecah=explode(".",$namafile);
						 $gabung=array();
						 for($a=0;$a<count($pecah)-1;$a++)
						 {
							 $gabung[]= $pecah[$a];
						 }
						 $namafile=implode('_',$gabung).'-1.'.$ext;
					 }
					 else{
						 $namafile=$file['name'][$i];
					 }
					 $namafile=preg_replace('/[^A-Za-z0-9 _ .-]/', '', $namafile);
					 $up=move_uploaded_file($file['tmp_name'][$i],$folder.$namafile);
					 if($up){
						 echo $namafile.' <i class="fa fa-check"></i> <br/>';
						 mysql_query("insert into berkas(id_karyawan,judul,file,date_created) values($id,'Tidak ada judul','$namafile',now())") or die(alert_error("Error : ".mysql_error()));
					 }
					 else
						 echo $namafile." <i class='fa fa-times'></i> <br/>";
				}
				direct(urldecode($_POST['url']));
			}
			?>
		</td>
	</tr>
</table>

<hr/>

<?php include"view/berkas/data-berkas.php"; ?>