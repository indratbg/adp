<table id='tableCheq' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="10%">Type</th>
			<th width="15%">Cheque Number</th>
			<th width="15%">Amount</th>
			<th width="35%">Description</th>
			<th width="10%">Fee</th>
			<th width="10%">Date</th>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelCheq as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td class="type">
				<?php echo $row->bg_cq_flg ?>
			</td>
			<td class="chqNum">
				<?php echo $row->chq_num ?>
			</td>
			<td class="chqAmt" style="text-align:right">
				<?php echo Tmanydetail::reformatNumber($row->chq_amt) ?>
			</td>
			<td class="descrip">
				<?php echo $row->descrip ?>
			</td>
			<td class="deductFee" style="text-align:right">
				<?php echo Tmanydetail::reformatNumber($row->deduct_fee) ?>
			</td>
			<td class="chqDt">
				<?php echo Tmanydetail::reformatDate($row->chq_dt) ?>
			</td>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>