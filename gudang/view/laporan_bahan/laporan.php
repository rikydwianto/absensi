<h1 class='page-head-line'>LAPORAN</h1>
<a href='<?php echo kembali() ?>' class='btn btn-success'><i class='fa fa-angle-double-left'></i> Kembali</a>
<a href='' class='btn btn-info'><i class='fa fa-refresh'></i> Reload</a>
<?php 
if(isset($_GET['jenis']))
{
	$id=get('id');
	$menu=aman($_GET['jenis']);
	if($menu=='mutasi_bahan')
		include"view/laporan_bahan/mutasi.php";
}
?>
