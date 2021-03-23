<h1 class='page-head-line'>EDIT PO</h1> <br/>
<?php
$id=get("id");
if(isset($_POST['edit-order']))
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
	$q=mysql_query("update order_aksesoris set qty=$qty, cons=$cons, keterangan='$keterangan', totalqty=$totalqty , date_modified=now() where id_order='$id'");
	if($q)
	{
		echo alert("Berhasil disimpan, order <b>#$style</b> status pending");
	}
	else{
		echo alert_error("Gagal disimpan, Error : ". mysql_error());
	}
}
$qw=mysql_query("select * from order_aksesoris where id_order='$id'");
$e=mysql_fetch_array($qw);
?>
<a href='<?php echo kembali() ?>' class='btn'>Kembali</a>
<br/>
Note : Hanya dapat mngubah QTY,CONS, TOTAL QTY, dan Keterangan
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
										if($rBuy['id_buyer']==$e['id_buyer'])
											$select='selected';
										else $select='';
										echo "<option $select value='$rBuy[id_buyer]'>$rBuy[nama_buyer] [$rBuy[instansi_buyer]]</option>";
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
								<select id='style' name='style' reqiured class='form-control'>
								<?php 
								$s=mysql_query("select * from style where id_buyer='$e[id_buyer]' ");
								while($style=mysql_fetch_array($s))	
								{
									if($style['nama_style']==$e['nama_style'])
										$a='selected';
									else $a='';
									echo "<option $a value='$style[id_style]'>$style[nama_style]</option>";
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Kode PO
							</td>
							<td>
								<input type=text name=kode class='form-control' value='<?php echo $e['kode_po'] ?>' />
							</td>
						</tr>
						<tr>
							<td>
								Deskripsi
							</td>
							<td>
								<input type=text name='deskripsi' class='form-control' value='<?php echo $e['deskripsi'] ?>'/>
							</td>
						</tr>
						<tr>
							<td>
								Warna
							</td>
							<td>
								<input type=text name=warna class='form-control' value='<?php echo $e['warna'] ?>' />
							</td>
						</tr>
						<tr>
							<td>Size<br/><small>Ukuran</small></td>
							<td>
								<input type=text name='size' value='<?php echo $e['size'] ?>' class='form-control'>
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
											if($rSup['id_suplier']==$e['id_suplier'])
												$a1='selected';
											else $a1='';
											echo "<option $a1 value='$rSup[id_suplier]'>$rSup[nama_suplier]</option>";
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
									<input type=date name='tanggal_order' id='tgl' value='<?php echo date("d/m/Y", strtotime($e['tanggal_order']))?>' class='form-control'>
								</span>
							</td>
						</tr>
						<tr>
							<td>QTY</td>
							<td>
								<span class='col-sm-8'>
									<input type=text name='qty' value='<?php echo $e['qty'] ?>' onblur='kali_cons()' onkeypress='kali_cons()' id='qty' class='form-control'>
								</span>
								<span class='col-sm-4'>
								<select class='form-control' name='satuan'>
									<option value=''>Satuan</option>
									<?php 
									$q=mysql_query("select * from satuan ");
									while($rSat=mysql_fetch_array($q))
									{
										if($rSat['satuan']==$e['satuan'])
											$sat='selected';
										else $sat='';
										echo "<option $sat value='$rSat[satuan]'>$rSat[satuan]</option>";
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
									<input type=text onkeypress='kali_cons()' value='<?php echo $e['cons'] ?>' onblur='kali_cons()' class='form-control' name='cons' id='cons'/>
								</span>
							</td>
						</tr>
						<tr>
							<td>Total QTY</td>
							<td>
								<span class='col-sm-12'>
									<input type=text name='totalqty' value='<?php echo $e['totalqty'] ?>' class='form-control' id='totalqty'>
								</span>
							</td>
						</tr>
						<tr>
							<td>
								Keterangan
							</td>
							<td>
								<span class='col-sm-12'>
									<textarea name='keterangan' value='<?php echo $e['keterangan'] ?>' class='form-control'></textarea>
								</span>
							</td>
						</tr>
					</table>
					
				</td>
			</tr>
			<tr>
				<td colspan=2>
					<center>
						<button class='btn btn-info' type=submit name='edit-order'><i class='fa fa-save'></i> Perbarui </button>
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