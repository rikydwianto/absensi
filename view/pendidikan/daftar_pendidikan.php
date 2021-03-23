<?php //i ?>
<section class="content-header">
  <h1>
    Pendidikan
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo url('index.php?mn=daftar_pendidikan') ?>">Pendidikan</a></li>
    <li class="active">Tampil</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Pendidikan</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
	<form method=get>
			<input type=hidden  name='mn' value='daftar_pendidikan'/>
			<input type=text class='form-control' name='sekolah' value='<?php echo @$_GET['sekolah']?>' placeholder='Nama Sekolah ...'/>
			<input type=submit name='submit' class='form-control' value='Cari'/>
		</form>
		<div class='table-responsive'>
			<table class='table'>
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Pendidikan</th>
					</tr>
				</thead>
				<tbody>
					<?php
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
					$no=1;
					if(isset($_GET['sekolah']))
					{
						$tambah="where nama_pendidikan like '%$_GET[sekolah]%'";
					}
					else
						$tambah="";
					$q=mysql_query("select *,count(nama_pendidikan) as hitung from riwayat_pendidikan $tambah group by nama_pendidikan limit $posisi,$batas") or die(alert_error(mysql_error()));
					while($rPen=mysql_fetch_object($q)){
						?>
						<tr>
							<td><?php echo $no ?></td>
							<td>
								<a href='<?php echo url('index.php?mn=detail_sekolah&sekolah='.urlencode($rPen->nama_pendidikan)) ?>'>
								<?php echo $rPen->nama_pendidikan ?>(<?php echo $rPen->hitung ?>)
								</a>
							</td>
						</tr>
						<?php
						$no++;
					}
					?>
				</tbody>
			</table>
			<div class='text-center'>
			<ul class='pagination '>
			<?php 
		   $q2=mysql_num_rows($q);
			echo mysql_error();
			$jml=ceil($q2/$batas);
			$jumPage=$jml;

			if ($page > 1){
			echo  "<li><a href='".url('index.php?mn=karyawan&page='.($page-1))."'><< Prev</a></li>";
			}
			//menampilkan urutan paging
			for($i = 1; $i <= $jumPage; $i++){
			//mengurutkan agar yang tampil i+3 dan i-3
					 if ((($i >= $page - 3) && ($i <= $page + 3)) || ($i == 1) || ($i == $jumPage))
					 {
						if($i==$jumPage && $page <= $jumPage-5) echo "<li><a>...</a></li>";
						if ($i == $page) echo " <li class='active'><a >".$i."</a></li> ";
						else echo " <li> <a href='".url('index.php?mn=karyawan&page='.($i))."'>".$i."</a> </li>";
						if($i==1 && $page >= 6) echo "<li><a>...</a></li>";
					 }
			}
			//menampilkan link Next >>
			if ($page < $jumPage){
			echo "<li><a href='".url('index.php?mn=karyawan&page='.($page + 1))."'>Next >></a></li>";
			}
			?>
			</ul>
			</div>
		</div>
    </div>
	</div>
</section>