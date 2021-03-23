<?php include"fungsi/cart.php"; ?>
<?php 
$batas=25;
if(isset($_GET['page']))
{
	$page=$_GET['page'];
	$posisi=($page-1)*$batas;
}
else
{
	$page=1;
	$posisi=0;
}


?>
<h1 class='page-head-line'>Kotak Sampah</h1> <br/>
<a href='' class='btn btn-info'><i class='fa fa-refresh'></i> Refresh</a>
<a href='<?php echo menu("kotak-sampah")?>' class='btn btn-info'><i class='fa fa-eyes'></i> Tampilkan semua</a>
<div class='pull-right'>
	<form method=get>
		<input type=hidden name='mn' value='kotak-sampah'/> 
		<input type=text name='cari' value='<?php echo @$_GET['cari'] ?>' placeholder='Cari Barang ...  '/> 
		<input type=submit name='kirim' value='Cari'>
	</form>
</div>
<table style='' class='table table-hover'>
	<thead>
		<tr>
			<th>No</th>
			<th>Style</th>
			<th>Deskripsi</th>
			<th>Warna</th>
			<th>Ukuran</th>
			<th>QTY</th>
			<th>Keterangan</th>
			<th>#</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(isset($_GET['cari']))
		{
			$cari=aman($_GET['cari']);
			$q="and deskripsi like '%$cari%'";
			
		}
		else
			$q='';

		$no=1;
		$tx="select stock_aksesoris.* from stock_aksesoris where hapus='ya' $q order by id_stock desc limit $posisi , $batas";
		$q=mysql_query("$tx") or die(alert_error("Error : ". mysql_error()));
		while($rLis=mysql_fetch_array($q)){
			$qty= $rLis['qty'] ;
		if($qty<1)
		{                                                                         
			$kosong="class='danger'";                                             
		}                                                                         
		else                                                                      
			$kosong='';                                                           
		?>                                                                        
		<tr <?php echo @$kosong ?> >                                              
			<td><?php echo $no ?></td>                                            
			<td>                                                                  
				<?php echo $rLis['nama_style'] ?>                                 
			</td>                                                                 
			<td>                                                                  
				<?php echo $rLis['deskripsi'] ?>                                  
			</td>                                                                 
			<td>                                                                  
				<?php echo $rLis['warna'] ?>
			</td>
			<td>
				<?php echo $rLis['size'] ?>
			</td>
			<td><?php echo $qty; ?> <?php echo $rLis['satuan'] ?></td>
			<td><?php echo $rLis['keterangan'] ?></td>
			<td><a href='<?php echo menu("restore&id=$rLis[id_stock]&url=".url_ref()) ?>' onclick='return confirm("Apakah anda yakin akan mengembalikan ke stock biasa?")'> <i class='fa fa-reply'></i> </a></td>
		</tr>
			<?php
		$no++;
		}
		?>
	</tbody>
</table>
<center>
<ul class="pagination">
<?php 
	$q2=mysql_num_rows(mysql_query("select stock_aksesoris.* from stock_aksesoris where hapus='ya' order by id_stock desc"));
   echo mysql_error();
	$jml=ceil($q2/$batas);
	$jumPage=$jml;
	if ($page > 1){
	echo  "<li><a href='".url('index.php?mn=stock&page='.($page-1))."'><< Prev</a></li>";
	}
	//menampilkan urutan paging
	for($i = 1; $i <= $jumPage; $i++){
	//mengurutkan agar yang tampil i+3 dan i-3
			 if ((($i >= $page - 3) && ($i <= $page + 3)) || ($i == 1) || ($i == $jumPage))
			 {
				if($i==$jumPage && $page <= $jumPage-5) echo "<li><a>...</a></li>";
				if ($i == $page) echo " <li class='active'><a >".$i."</a></li> ";
				else echo " <li> <a href='".url('index.php?mn=stock&page='.($i))."'>".$i."</a> </li>";
				if($i==1 && $page >= 6) echo "<li><a>...</a></li>";
			 }
	}
	//menampilkan link Next >>
	if ($page < $jumPage){
	echo "<li><a href='".url('index.php?mn=stock&page='.($page + 1))."'>Next >></a></li>";
	}
	?>
</ul>
</center>
<script>
	function tambah_cart(id_stock,id)
	{
		var css="#cart_" + id_stock;
		$.ajax({
			url:laman+"api/cek_cart.php",
			type:'post',
			data:'id_stock='+ id_stock +"&id_transaksi="+id,
			beforeSend:function(){
				$(css).html("Sedang diproses");
			},
			success:function(html){
				$(css).html(html);
				//alert(css);
			}
		});
	}

</script>
