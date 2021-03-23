<?php 
$hitung=mysql_query("SELECT SUM(IF(jenis_kelamin=0,1,0)) AS laki,SUM(IF(jenis_kelamin=1,1,0)) AS cewe,SUM(IF(jenis_kelamin>2,1,0)) AS lain, COUNT(jenis_kelamin) AS total FROM karyawan");
$hitung=mysql_fetch_array($hitung);
$total=$hitung['total'];
?>
<table class='table'>
	<tr>
		<td>Laki Laki</td>
		<td><?php echo $hitung['laki'] ?></td>
		<td><?php echo round($hitung['laki'] / ($total/100),1)  ?>%</td>
	</tr>
	<tr>
		<td>Perempuan</td>
		<td><?php echo $hitung['cewe'] ?></td>
		<td><?php echo round($hitung['cewe'] / ($total/100),1) ?>%</td>
	</tr>
	<tr>
		<td>Lain - lain</td>
		<td><?php echo $hitung['lain'] ?></td>
		<td><?php echo round($hitung['lain'] / ($total/100),1) ?>%</td>
	</tr>
	<tr>
		<th>Total</th>
		<th><?php echo $total ?></th>
		<th><?php echo $total / ($total/100)?>%</th>
	</tr>
</table>
<div id="donut-example" style="height: 250px;"></div>
<script>
var laki = <?php echo $hitung['laki'] ?>;
var cewe = <?php echo $hitung['cewe'] ?>;
var lain = <?php echo $hitung['lain'] ?>;
Morris.Donut({
  element: 'donut-example',
  data: [
    {label: "Pria", value: laki},
    {label: "Wanita", value: cewe},
    {label: "Lain - lain", value: lain}
  ]
});

</script>