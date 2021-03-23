<h1 class='page-head-line'>Satuan</h1>
<a href='<?php echo menu('satuan') ?>' class='btn btn-info'><i class='fa fa-plus'></i> Tampil</a>
<a href='<?php echo menu('satuan&act=tambah') ?>' class='btn btn-danger'><i class='fa fa-plus'></i> Tambah</a>
<a href='' class='btn btn-info'><i class='fa fa-refresh'></i> Reload</a>

<?php 
if(isset($_GET['act']))
{
	$menu=aman($_GET['act']);
	if($menu=='tambah')
		include"view/satuan/tambah-satuan.php";
	else if($menu=='hapus')
		include"view/satuan/hapus-satuan.php";
	else if($menu=='edit')
		include"view/satuan/edit-satuan.php";
}
else include"view/satuan/tampil.php";

?>