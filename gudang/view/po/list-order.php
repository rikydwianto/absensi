<h1 class='page-head-line'>List Order</h1> <br/>
<table style='width:100%' class=' table-hovered'>
	<thead>
		<tr>
			<th>No</th>
			<th>Buyer</th>
			<th>Style</th>
			<th>Combo</th>
			<th>Kode</th>
			<th>Deskripsi</th>
			<th>Kombo/Warna</th>
			<th>QTY</th>
			<th>Tanggal</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$no=1;
		$q=mysql_query("select * from order_aksesoris inner join buyer on order_aksesoris.id_buyer=buyer.id_buyer
		order by id_order desc
		");
		while($rLis=mysql_fetch_array($q)){
		$status = $rLis['status_order'];
		if($status=='pending')
			$label='warning';
		else if($status=='barang kurang')
			$label='warning';
		else if($status=='batal')
			$label='danger';
		else if($status=='sukses')
			$label='success';
		?>
		<tr>
			<td><?php echo $no ?></td>
			<td><?php echo $rLis['nama_buyer'] ?></td>
			<td>
				<?php echo $rLis['nama_style'] ?>
				<span class="label label-<?php echo $label ?>">
					<?php echo $status ?>
				</span>
			</td>
			<td>
				Combo
			</td>
			<td>
				<?php echo $rLis['kode_po'] ?>
			</td>
			<td>
				<?php echo $rLis['deskripsi'] ?>
			</td>
			<td>
				<?php echo $rLis['warna'] ?>
			</td>
			<td><?php echo $rLis['totalqty'] ?> <?php echo $rLis['satuan'] ?></td>
			<td>
				<?php echo $rLis['tanggal_order'] ?>
			</td>
			<td>
				<a class='btn btn-sm btn-primary ' onclick="" href="javascript:detail_order(<?php echo $rLis['id_order']?>);" >
					<i class='fa fa-eye'></i> Detail
				</a>
				<?php
				if($status=='pending' || $status=='barang kurang')
				{
					?>
				<a href="javascript:terima_barang(<?php echo $rLis['id_order']?>);" onclick="" class='btn btn-sm btn-info'>
					<i class='fa fa-check-circle '></i> Terima Barang
				</a>
				<a href="javascript:batal_order(<?php echo $rLis['id_order']?>);" title='Batal Order?' onclick="" class='btn btn-sm btn-danger'>
					<i class='fa fa-times '></i>
				</a>
				<a href="<?php echo menu("edit-order&id=".$rLis['id_order'].'&url='.url_ref())?>" title='Edit Order?' onclick="" class='btn btn-sm btn-danger'>
					<i class='fa fa-edit '></i>
				</a>
					<?php
				}
				?>
			</td>
		</tr>
			<?php
		$no++;
		}
		?>
	</tbody>
</table>

<script>
	function detail_order(id){
		$.ajax({
			url: laman + 'api/detail_order.php',
			type:'POST',
			data:'id_order='+id,
			success:function(html){
				$("#isi_detail_order").html(html);
				$("#detail_order").modal();
			},
			error:function(er,a,trow){
				alert("Error : " + trow + " \n Kode : " + er.status );
			}
		});
	}
	
	function terima_barang(id){
		$.ajax({
			url: laman + 'api/terima_barang.php',
			type:'POST',
			data:'id_order='+id,
			success:function(html){
				$("#terima_barang").modal();
				$("#isi_terima_barang").html(html);
				$("#loading").hide();
			},
			error:function(er,a,trow){
				alert("Error : " + trow + " \n Kode : " + er.status );
			}
		});
	}
	function batal_order(id){
		$.ajax({
			url: laman + 'api/batal_order.php',
			type:'POST',
			data:'id_order='+id,
			success:function(html){
				$("#batal_order").modal();
				$("#isi_batal_order").html(html);
			},
			error:function(er,a,trow){
				alert("Error : " + trow + " \n Kode : " + er.status );
			}
		});
	}
	
		
</script>
<!-- Modal -->
<div class="modal fade" id="detail_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Order</h4>
      </div>
      <div class="modal-body">
        <span id='isi_detail_order'></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Oke</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="terima_barang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Terima Barang</h4>
      </div>
      <div class="modal-body">
		
        <span id='isi_terima_barang'></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade bs-example-modal-sm" id="batal_order" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Batal Order?</h4>
      </div>
      <div class="modal-body">
		
        <span id='isi_batal_order'></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>