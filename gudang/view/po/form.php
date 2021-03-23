<h1 class='page-head-line'>Form PO</h1> <br/>
<?php

if(isset($_POST['order']))
{
	$buyer=post('buyer');
	$suplier=post('suplier');
	$kode=post('kode');
	$satuan=post('satuan');
	$style=post('style');
	$deskripsi=post("deskripsi");
	$warna=post("warna");
	$keterangan=post("keterangan");
	$cons=post("cons");
	$qty=post("qty");
	$size=post("size");
	$totalqty=post("totalqty");
	$id_karyawan=$_SESSION['ID'];
	$tgl=ubah_tanggal(post("tanggal_order"));
	$q=mysql_query("INSERT INTO order_aksesoris (id_order,kode_po, nama_style, deskripsi, size, warna, cons, qty, keterangan, satuan, tanggal_order, id_karyawan, id_buyer, id_suplier, date_created, date_modified, status_order,totalqty) VALUES (NULL, '$kode','$style', '$deskripsi', '$size', '$warna', '$cons', '$qty', '$keterangan', '$satuan', '$tgl', '$id_karyawan', '$buyer', '$suplier', now(), now(), 'pending','$totalqty');");
	if($q)
	{
		echo alert("Berhasil disimpan, order <b>#$style</b> status pending");
	}
	else{
		echo alert_error("Gagal disimpan, Error : ". mysql_error());
	}
}
?>

<form method=post>
	<table class='table table-responsive'>
			<tr>
				<td>
					<table class='table'>
						<tr>
							<td>Buyer</td>
							<td>
								<select class='form-control select2' reqiured onchange="return pilih_style(this.value)"  name='buyer' id='buyer'>
									<option value=''>Pilih Buyer</option>
									<?php 
									$q=mysql_query("select * from buyer order by nama_buyer");
									while($rBuy=mysql_fetch_array($q))
									{
										echo "<option value='$rBuy[id_buyer]'>$rBuy[nama_buyer] [$rBuy[instansi_buyer]]</option>";
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Style
							</td>
							<td>
								<select id='style' name='style' reqiured class='form-control'></select>
							</td>
						</tr>
						<tr>
							<td>
								Kode PO
							</td>
							<td>
								<input type=text name=kode class='form-control' />
							</td>
						</tr>
						<tr>
							<td>
								Deskripsi
							</td>
							<td>
								<input type=text name='deskripsi' class='form-control'>
							</td>
						</tr>
						<tr>
							<td>
								Warna
							</td>
							<td>
								<input type=text name=warna class='form-control' />
							</td>
						</tr>
						<tr>
							<td>Size<br/><small>Ukuran</small></td>
							<td>
								<input type=text name='size' class='form-control'>
							</td>
						</tr>
					</table>
				
				
				</td>
				<td>
					<table class='table'>
						<tr>
							<td>Supplier</td>
							<td>
								<span class='col-sm-12'>
									<select class='form-control' required name='suplier' id='suplier'>
										<option value=''>Pilih Supplier</option>
										<?php 
										$q=mysql_query("select * from suplier order by nama_suplier");
										while($rSup=mysql_fetch_array($q))
										{
											echo "<option value='$rSup[id_suplier]'>$rSup[nama_suplier]</option>";
										}
										?>
									</select>
								</span>
							</td>
						</tr>
						<tr>
							<td>Tanggal<br/><small>DD/MM/YYYY</small></td>
							<td>
								<span class='col-sm-12'>
									<input type=date name='tanggal_order' id='tgl' value='<?php echo date("d/m/Y")?>' class='form-control'>
								</span>
							</td>
						</tr>
						<tr>
							<td>QTY</td>
							<td>
								<span class='col-sm-8'>
									<input type=text name='qty' onblur='kali_cons()' onkeypress='kali_cons()' id='qty' class='form-control'>
								</span>
								<span class='col-sm-4'>
								<select class='form-control' name='satuan'>
									<option value=''>Satuan</option>
									<?php 
									$q=mysql_query("select * from satuan ");
									while($rSat=mysql_fetch_array($q))
									{
										echo "<option value='$rSat[satuan]'>$rSat[satuan]</option>";
									}
									?>
								</select>
								</span>
							</td>
						</tr>
						<tr>
							<td>Cons<br/><small>penggunaan</small></td>
							<td>
								<span class='col-sm-4'>
									<input type=text onkeypress='kali_cons()' onblur='kali_cons()' class='form-control' name='cons' id='cons'/>
								</span>
							</td>
						</tr>
						<tr>
							<td>Total QTY</td>
							<td>
								<span class='col-sm-12'>
									<input type=text name='totalqty' class='form-control' id='totalqty'>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								Keterangan
							</td>
							<td>
								<span class='col-sm-12'>
									<textarea name='keterangan' class='form-control'></textarea>
								</span>
							</td>
						</tr>
					</table>
					
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<center>
						<button class='btn btn-info' type=submit name='order'><i class='fa fa-save'></i> Save </button>
						<button class='btn btn-danger' type=reset><i class='fa fa-times'></i> Reset </button>
						<a href='' class='btn btn-success' ><i class='fa fa-refresh'></i> Refresh </a>
					</center>
				</td>
			</tr>
	</table>
</form>
<script>
	function kali_cons()
	{
		var qty=document.getElementById("qty").value;
		var cons=document.getElementById("cons").value;
		if(cons=='')
		{
			document.getElementById("totalqty").value=qty;
		}
		else
		{
			document.getElementById("totalqty").value=qty * cons;
			
		}
	}
	function pilih_style(id)
	{
		$.ajax({
			url: laman + "api/pilih_style.php",
			data:"id_buyer="+id,
			type:'POST',
			success:function(html){
				$("#style").html(html);
			}
		});
		
	}
</script>