<div class="detail" id="detail">
	<table id='tableDetail' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="10%">GL Account</th>
				<th width="13%">SL Account</th>
				<th width="18%">Amount</th>
				<th width="9%">Db/Cr</th>
				<th width="30%">Journal Description</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelDetail as $row){ 
		?>
			<tr id="row">
				<td class="glAcct">
					<?php echo $form->textField($row,'gl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][gl_acct_cd]','readonly'=>'readonly')); ?>
				</td>
				<td class="slAcct">
					<?php echo $form->textField($row,'sl_acct_cd',array('class'=>'span','name'=>'Taccountledger['.$x.'][sl_acct_cd]','readonly'=>'readonly')); ?>
				</td>
				<td class="amt">
					<?php echo $form->textField($row,'curr_val',array('class'=>'span tnumberdec','name'=>'Taccountledger['.$x.'][curr_val]','readonly'=>'readonly')); ?>
				</td>
				<td class="dbcr">
					<?php echo $form->textField($row,'db_cr_flg',array('class'=>'span','name'=>'Taccountledger['.$x.'][db_cr_flg]','readonly'=>'readonly')); ?>
				</td>
				<td class="remarks">
					<?php echo $form->textField($row,'ledger_nar',array('class'=>'span','name'=>'Taccountledger['.$x.'][ledger_nar]')); ?>
				</td>
				<input type="hidden" class="rowid" name="Taccountledger[<?php echo $x ?>][rowid]" value="<?php echo $row->rowid ?>" />
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
</div>