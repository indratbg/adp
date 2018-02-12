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
				<?php echo $form->textField($row,'bg_cq_flg',array('class'=>'span','name'=>'Tcheq['.$x.'][bg_cq_flg]','readonly'=>'readonly')); ?>
			</td>
			<td class="chqNum">
				<?php echo $form->textField($row,'chq_num',array('class'=>'span','name'=>'Tcheq['.$x.'][chq_num]','readonly'=>'readonly')); ?>
			</td>
			<td class="chqAmt">
				<?php echo $form->textField($row,'chq_amt',array('class'=>'span tnumber','name'=>'Tcheq['.$x.'][chq_amt]','readonly'=>'readonly')); ?>
			</td>
			<td class="descrip">
				<?php echo $form->textField($row,'descrip',array('class'=>'span','name'=>'Tcheq['.$x.'][descrip]')); ?>
			</td>
			<td class="deductFee">
				<?php echo $form->textField($row,'deduct_fee',array('class'=>'span tnumber','name'=>'Tcheq['.$x.'][deduct_fee]','readonly'=>'readonly')); ?>
			</td>
			<td class="chqDt">
				<?php echo $form->textField($row,'chq_dt',array('class'=>'span tdate','name'=>'Tcheq['.$x.'][chq_dt]','readonly'=>'readonly')); ?>
			</td>
			<input type="hidden" name="Tcheq[<?php echo $x ?>][rowid]" value="<?php echo $row->rowid ?>" />
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>