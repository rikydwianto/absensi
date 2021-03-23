<?php 
$q=mysql_query("select * from user order by id_user desc");
while($r=mysql_fetch_object($q))
{
	$det=detail_karyawan($r->id_karyawan);
?>
<div class="col-md-4 col-sm-4 col-xs-12 animated fadeInDown">
	<div class="col-sm-12">
		<h4 class="brief"><i><?php echo baca_level($r->lvl_user) ?></i></h4>
		<div class="left col-xs-7">
			<h2><?php echo @$r->username ?></h2>
			<?php echo @$det->nama_lengkap?>	
			<p><strong>Status: </strong> <?php echo baca_status($r->status) ?> 
			 <br />   
			 <strong> Last Login: </strong> <br /><?php echo waktu($r->last_login) ?></p>  

			
		</div>
		<div class="right col-xs-5 text-center">
															
			<a href='<?php echo url("data/foto/$det->file_foto") ?>'>
				<img src="<?php echo url(cek_photo($det->id_karyawan))?>" alt="" class="img-circle " width="70px">
			</a>
		</div>
	</div>
	<div class="col-xs-12 bottom text-center">
		 <div class="col-xs-12 col-sm-12 emphasis">
			<p class="ratings">
				<!-- <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#modal_edit_user_22"> <i class="glyphicon glyphicon-edit">
				</i>  Edit </button> -->
				
				<a  class="btn btn-danger btn-xs" href='<?php echo url('index.php?mn=user&act=hapus&id='.$r->id_user) ?>' onclick="return confirm('yakin untuk menghapus?')"> 
					<i class="fa fa-trash-o"></i>  Delete
				</a>
				<a  class="btn btn-warning btn-xs"  href='<?php echo url('index.php?mn=user&act=edit&id='.$r->id_user) ?>'> 
					<i class="fa fa-edit"></i>  Edit
				</a>
				 <a class="btn btn-primary btn-xs" > <i class="fa fa-user">
				</i> View Profile </a>
				
				
			</p>
		</div>
		
	</div>
</div>
<?php 
} ?>