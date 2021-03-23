<section class="content-header">
  <h1>
    <?php echo $title ?>
    <small><?php echo $nm_aplikasi ?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Hamalan Awal</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Halaman Awal</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
      <img src='<?php echo url('assets/img/page-header.jpg') ?>' class='img img-responsive img-thumbnail'/>
		<div class="alert alert- alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4 class="page-header">Selamat datang</h4>
				Pada <?php echo $nm_aplikasi ?><br/>
		</div>
	</div>
</div>
</section>