<div class='row'>
<?php 
$query=mysql_query("select * from berkas where id_karyawan=$id order by id_berkas desc");
while($berkas=mysql_fetch_array($query))
{
$folder="data/berkas/$nik/";
$ext=pathinfo($folder.$berkas['file'],PATHINFO_EXTENSION);
if($ext=='jpg' || $ext=='gif' || $ext=='png'|| $ext=='bmp'){
	$warna='info';
	$file="<img src='".url()."/$folder/$berkas[file]' class='img img-thumbnail' style='width:100%;height:150px' />";
}
else if($ext=='rar' || $ext=='zip' || $ext=='7zip' )
{
	$warna='danger';
	$file="<center><br/><br/><i class='fa fa-file-zip-o fa-5x'></i></center><br/><br/>";
}
else if($ext=='xlsx' || $ext=='xls' || $ext=='doc' || $ext=='docx' || $ext=='ppt' || $ext=='pptx' || $ext=='pdf')
{
	$warna='success';
	if($ext=='xlsx' || $ext=='xls')
		$icon="file-excel-o";
	else if($ext=='doc' || $ext=='docx')
		$icon="file-word-o";
	else if($ext=='ppt' || $ext=='pptx')
		$icon="file-powerpoint-o";
	else if($ext=='pdf')
		$icon="file-pdf-o";
	
	$file="<center><br/><br/><i class='fa fa-$icon fa-5x'></i></center><br/><br/>";
}
else if($ext=='exe'){
	$warna="danger";
	$file="<center><br/><br/><i class='fa fa-file fa-5x'></i></center><br/><br/>";
}
else{
	$warna="warning";
	$file="<center><br/><br/><i class='fa fa-file-archive-o fa-5x'></i></center><br/><br/>";
}
?>
	<div class='col-md-3'>
		<div class="box box-<?php echo $warna ?> box-solid">
			<div class="box-header with-border"> 
				<h5 class="box-title" style='font-size:13px'><?php echo $berkas['judul'] ?></h5>
				<div class="box-tools pull-right">
					<a href='javascript:detail_berkas(<?php echo $berkas['id_berkas'] ?>)' class="btn btn-box-tool" ><i class="fa fa-edit" title='Edit file?'></i></a>
					<a href='<?php echo url("index.php?mn=berkas&act=hapus&id=$berkas[id_berkas]&nik=$nik&url=".url_ref()) ?>' class="btn btn-box-tool" ><i class="fa fa-trash" title='Hapus file?'></i></a>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body" title='<?php echo $berkas['file'] ?>[<?php echo $berkas['judul'] ?>] - [<?php echo $berkas['deskripsi'] ?>]'>
				<a href='<?php echo url("data/berkas/$nik/$berkas[file]") ?>' style='color:black'><?php echo $file ?></a>
				 
			</div><!-- /.box-body -->
			<div class="box-footer">
					<p><?php echo substr($berkas['judul'],0,30) ?></p>
			</div>
		</div><!-- /.box -->
	</div>
<?php 
}
?>
</div>

<div class="modal fade bs-example-modal-lg" id='berkas' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit Berkas</h4>
		</div>
		<div class="modal-body">
			<p id='edit_berkas'></p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-sm" id='berhasil_berkas' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Berhasil diedit</h4>
		</div>
		<div class="modal-body">
			<?php echo alert("BERKAS BERHASIL DIEDIT!") ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-sm" id='lihat_berkas' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Lihat File</h4>
		</div>
		<div class="modal-body">
			<p id='detail_lihat_berkas'></p>
      </div>
    </div>
  </div>
</div>
<script>
function detail_berkas(id){
	$("#berkas").modal();
	$.ajax({
		url:laman + 'api/edit_berkas.php?id='+id,
		success:function(html){
			$("#edit_berkas").html(html);
		}
	});
}
</script>