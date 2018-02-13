<div class="detail" id="detailRetrieve">
	<table id='tableRetrieve' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="10%">Client Code</th>
				<th width="18%">Name</th>
				<th width="8%">Stock Code</th>
				<th width="13%">Quantity</th>
				<th width="13%">Withdraw Date</th>
				<th width="5%" style="text-align:center">
					Settle
					<br/>
					<input type="checkbox" class="checkBoxAll" />
				</th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelRetrieve as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td class="client">
					<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][client_cd]','readonly'=>'readonly')); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][client_name]','readonly'=>'readonly')); ?>
				</td>
				<td class="stock">
					<?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][stk_cd]','readonly'=>'readonly')); ?>
				</td>
				<td class="qty">
					<?php echo $form->textField($row,'qty',array('class'=>'span tnumber qtyDetailRetrieve','name'=>'Tstkretrieve['.$x.'][qty]','readonly'=>'readonly')); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'withdraw_dt',array('class'=>'span tdate','name'=>'Tstkretrieve['.$x.'][withdraw_dt]','readonly'=>'readonly')); ?>
				</td>
				<td class="check" style="text-align:center">
					<?php echo $form->checkBox($row,'check',array('value' => 'Y','uncheckValue'=>'N','name'=>'Tstkretrieve['.$x.'][check]','onChange'=>"checkToggle();countTotal('.qtyDetailRetrieve')")); ?>
				</td>
				<input type="hidden" name="Tstkretrieve[<?php echo $x ?>][withdraw_doc_num]" value="<?php echo $row->withdraw_doc_num ?>" />
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	<input type="hidden" id="retrieveCount" name="retrieveCount"/>
</div>

<script>
	var retrieveCount = <?php echo count($modelRetrieve) ?>;	
</script>