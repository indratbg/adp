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
			<tr id="row<?php echo $x ?>">
				<td class="glAcct">
					<?php echo $row->gl_acct_cd ?>
				</td>
				<td class="slAcct">
					<?php echo $row->sl_acct_cd ?>
				</td>
				<td class="amt" style="text-align:right">
					<?php echo Tmanydetail::reformatNumber($row->curr_val) ?>
				</td>
				<td class="dbcr">
					<?php echo $row->db_cr_flg=='D'?'DEBIT':'CREDIT' ?>
				</td>
				<td class="remarks">
					<?php echo $row->ledger_nar ?>
				</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
</div>