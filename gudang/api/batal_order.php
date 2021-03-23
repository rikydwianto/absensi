<?php include"../config/setting.php"?>
<?php include"../config/koneksi.php"?>
<?php include"../fungsi/config.php"?>
<?php 
$id= post('id_order');
$q=mysql_query("select * from order_aksesoris 
join buyer on order_aksesoris.id_buyer=buyer.id_buyer 
join suplier on order_aksesoris.id_suplier=suplier.id_suplier where id_order='$id'");
$r=mysql_fetch_array($q);

?>
<div id='keterangan'>
Apa anda yakin membatalkan order <br/>
Style : <b><?php echo $r['nama_style'] ?></b> <br/>
Deskripsi : <b><?php echo $r['deskripsi'] ?></b> <br/>                                  
Suplier : <b><?php echo $r['nama_suplier'] ?></b> ??
<br/>
<button type="button" onclick="javascript:batal_order_act(<?php echo $id ?>)" class="btn btn-danger ">Batal Order</button>
</div>
<script>
function batal_order_act(id){
	$.ajax({
		url:laman+"api/batal_order.php",
		type:'POST',
		data:'id_order='+id+"&state=i",
		beforeSend:function(){
			$("#keterangan").html("<img src='"+laman+"assets/img/loading.gif'/>");
		},
		success:function(html){
			$("#keterangan").html("<img src='"+laman+"assets/img/success.png'/>");
		}
	});
}
</script>
<?php 
@$state=post('state');
if($state=='i')
{
	mysql_query("update order_aksesoris set status_order='batal', date_modified=now() where id_order='$id'");
}
?>