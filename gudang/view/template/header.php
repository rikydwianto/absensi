<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo url() ?>">WAREHOUSE ACC</a>
	</div>

	<div class="header-right">
	<?php 
	if(isset($_SESSION['id_cart'])){
		?>
		<a href="<?php echo menu("cart") ?>" class="btn btn-info" title="Shopping Cart"><i class="fa fa-shopping-cart fa-2x"></i> Cart/Keranjang</a>
		<?php
	}
	?>
		<a href="logout.php" class="btn btn-danger" title="Logout"><i class="fa fa-sign-out fa-2x"></i></a>
	</div>
</nav>
