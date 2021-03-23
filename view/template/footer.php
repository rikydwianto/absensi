<!-- jQuery 2.1.4 -->
<script src="<?php echo url('assets/plugins') ?>/jQuery/jQuery-2.1.4.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo url('assets/js/') ?>/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo url('assets/') ?>bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo url('assets/js') ?>/raphael-min.js"></script>
<script src="<?php echo url('assets/plugins') ?>/morris/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo url('assets/plugins') ?>/sparkline/jquery.sparkline.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo url('assets/plugins') ?>/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<!-- -->
<script src="<?php echo url('assets/js') ?>/moment.min.js"></script>
<script src="<?php echo url('assets/plugins') ?>/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo url('assets/plugins') ?>/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo url('assets/plugins') ?>/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo url('assets/plugins') ?>/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo url('assets/plugins') ?>/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo url('assets/dist') ?>/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo url('assets/dist') ?>/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo url('assets/dist') ?>/js/demo.js"></script>

<script src="<?php echo url('assets/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo url('assets/') ?>plugins/datatables/dataTables.bootstrap.min.js"></script>


<script src="<?php echo url('assets/') ?>plugins/pace/pace.js"></script>

<script src="<?php echo url('assets/plugins/') ?>select2/select2.full.min.js"></script>
    <!-- InputMask -->
<script src="<?php echo url('assets/plugins/') ?>input-mask/jquery.inputmask.js"></script>
<script src="<?php echo url('assets/plugins/') ?>input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo url('assets/plugins/') ?>input-mask/jquery.inputmask.extensions.js"></script>
<!-- <script src="<?php echo url('assets/plugins/') ?>prettyphoto/jquery.prettyPhoto.js"></script> -->
<script>
  $("#example1").DataTable({
	paging: false
  }); 
  //$("a[rel^='prettyPhoto']").prettyPhoto();
  $("#example2").DataTable(); 
   $(".select2").select2();
	$("[data-mask]").inputmask();
	$('#reservation').daterangepicker({
		format: 'DD/MM/YYYY',
		autoApply: true,
	});
	$('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 1, format: 'DD/MM/YYYY HH:mm '});
	
    $('#tgl1').daterangepicker({
        singleDatePicker: true,
		format: 'DD/MM/YYYY',
        showDropdowns: true,
    });
    $('#tgl4').daterangepicker({
        singleDatePicker: true,
		format: 'YYYY-MM-DD',
        showDropdowns: true,
    });
	$('#tgl2').daterangepicker({
        singleDatePicker: true,
		format: 'DD/MM/YYYY',
        showDropdowns: true,
    });
	
	$(".timepicker").timepicker({
	  showInputs: false
	});
</script>
<script>
$("#dept").change(function(){
	var id=$(this).val();
	$.ajax({
		url: laman + 'api/jabatan.php?id=' + id,
		success:function(html){
			$("#jabatan").html(html);
		}
	});

});
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_upload_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#inputFile").change(function () {
        readURL(this);
    });
	
	
function klik_modal(id)
{
	$.ajax({
		url:laman + 'api/karyawan.php?mn=tampil&id='+id,
		type:'post',
		success:function(html){
			$("#nama_karyawan").html(html);
			$("#id_kar").val(id);
			$("#myModal").modal();
		}
	});
}
$("#klik_hapus").click(function(){
	var id = $("#id_kar").val();
	$.ajax({
		url:laman + 'api/karyawan.php?mn=hapus&id='+id,
		type:'post',
		beforeSend:function(){
			$(this).attr("class","disabled")
		},
		success:function(html){
			$("#error").html(html);
			$("#myModal").modal('hide');
			$("#myModal2").modal();
		}
	});
});
$('#myModal2').on('hidden.bs.modal', function (e) {

	location.replace(url_sekarang);
})


$("#selectall").click(function () {
var checkAll = $("#selectall").prop('checked');
    if (checkAll) {
        $(".case").prop("checked", true);
    } else {
        $(".case").prop("checked", false);
    }
});
function Fdetail(id)
{
	$.ajax({
		url:laman+'api/detail_resign.php',
		data:'id='+id,
		type:'post',
		beforeSend:function(){
			$("loading").attr('class','disabled');
		},
		success:function(html){
			$("#Dmodal").modal();
			$("#detail_modal").html(html);
			
		},
		error:function(er){
			alert("Error : Gagal untuk memuat halaman ");
		}
	});
}
	$("#refresh_rekap").click(function(){
		var ht = $("#reload_rekap").html();
		$.ajax({
			url:laman+'api/reload_rekap.php?jab='+getParameterByName('jab')+'&id_jabatan='+getParameterByName('id_jabatan')+'&tahun='+getParameterByName('tahun')+'&bulan='+getParameterByName('bulan')+'&cr=Cari',
			// data:'jab=20'+'&id_jabatan=22'+'&tahun=2016'+'&bulan=09'+'&cr=Cari',
			type:'get',
			beforeSend:function(){
			},
			success:function(html){
				$("#reload_rekap").html(html);
				
			},
			error:function(er){
				alert("Error : Gagal untuk memuat halaman ");
			}
		});
		
	});
	
	$("#klik_rinci").click(function(){
		var data = ($("#form_rinci_absen").serialize());
		$.ajax({
			url:laman+'api/rinci_absen.php',
			data:data,
			type:'get',
			beforeSend:function(){
				$("#rinci_absen").html("Wait a moment please ...");
			},
			success:function(html){
				$("#rinci_absen").html(html);
				
			},
			error:function(er){
				alert("Error : Gagal untuk memuat halaman ");
			}
		});
	});
	var data = ($("#form_rinci_absen").serialize());
	$.ajax({
		url:laman+'api/select_nik.php',
		data: data,
		success:function(html){
			$("#rinci_nik").html(html);
		}
		
	});
</script>
