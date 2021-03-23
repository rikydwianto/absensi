<h1 class='page-head-line'>Buyer</h1>
<a href='<?php echo menu('buyer&act=tambah') ?>' class='btn btn-danger'><i class='fa fa-plus'></i> Tambah</a>
<a href='' class='btn btn-info'><i class='fa fa-refresh'></i> Reload</a>

<?php 
if(isset($_GET['act']))
{
	$menu=aman($_GET['act']);
	if($menu=='tambah')
		include"view/buyer/tambah.php";
	else if($menu=='hapus')
		include"view/buyer/hapus.php";
	else if($menu=='edit')
		include"view/buyer/edit.php";
	else if($menu=='style')
		include"view/buyer/style.php";
	else if($menu=='tambah-style')
		include"view/buyer/tambah-style.php";
}
else
	include"view/buyer/tampil.php";
?>
