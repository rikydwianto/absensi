<?php 
function cek_cart($id,$id_stock){
	$q=mysql_query("select id_stock from detail_loading_aksesoris where id_stock='$id_stock' and id_loading_aksesoris='$id'") or die("Error : ". mysql_error());
	if(mysql_num_rows($q))
	{
		//echo "ada";
	}
	else
	{
		echo "
		<span id='tambah_cart'>
			<a href='javascript:;' onclick='tambah_cart($id_stock,$id)' id='cart_$id_stock' class='btn btn-xs'><i class='fa fa-shopping-cart'></i> Add To Cart</a>
		</span>
			
		";
	}
}