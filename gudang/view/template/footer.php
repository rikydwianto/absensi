<div id="footer-sec">
	&copy; <?php echo date("Y")?> <?PHP echo $title ?> | Design By : <a href="http://www.binarytheme.com/" target="_blank">BinaryTheme.com</a>
</div>
<!-- /. FOOTER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.js"></script>
<!-- METISMENU SCRIPTS -->
<script src="assets/js/jquery.metisMenu.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
<script src="assets/plugins/select2/js/select2.js"></script>
<script type="text/javascript" src="assets/plugins/daterangepicker/moment.js"></script>
<script type="text/javascript" src="assets/plugins/daterangepicker/daterangepicker.js"></script>

<script>
	$("#buyer").select2();
	$("#select2").select2();
	$("#suplier").select2();
	$('#tgl').daterangepicker({
	singleDatePicker: true,
	locale: {
            format: 'DD/MM/YYYY'
	}
	});
	
	$('#tgl1').daterangepicker({
	singleDatePicker: true,
	locale: {
            format: 'YYYY/MM/DD'
	}
	});

</script>