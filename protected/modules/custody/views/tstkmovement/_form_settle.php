<div class="detail" id="detailRetrieve">
	<table id='tableRetrieve' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="10%">Client Code</th>
				<th width="24%">Client Name</th>
				<th width="9%">Stock Code</th>
				<th width="9%">Beli/Jual</th>
				<th width="13%">Quantity</th>
				<th width="20%">Bank Custody</th>
				<th width="5%" style="text-align:center">
					Journal
					<br>
					<input type="checkbox" class="checkBoxAll" />
				</th>
				<th width="10%"></th>
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
				<td>
					<?php echo $form->textField($row,'belijual',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][belijual]','readonly'=>'readonly')); ?>
				</td>
				<td class="qty">
					<?php echo $form->textField($row,'qty',array('class'=>'span tnumber qtyDetailRetrieve','name'=>'Tstkretrieve['.$x.'][qty]','onChange'=>"countTotal('.qtyDetailRetrieve',this)",'readonly'=>'readonly')); ?>
				</td>
				<td>
					<?php echo $form->textField($row,'custody_name',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][custody_name]','readonly'=>'readonly')); ?>
				</td>
				<td class="check" style="text-align:center">
					<?php echo $form->checkBox($row,'check',array('value' => 'Y','uncheckValue'=>'N','class'=>'withdrawCheck','name'=>'Tstkretrieve['.$x.'][check]','onChange'=>"checkToggle();countTotal('.qtyDetailRetrieve')")); ?>
				</td>
				<td class="rdi">
					<?php echo $form->textField($row,'rdi_flg',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][rdi_flg]','readonly'=>'readonly')); ?>
				</td>
			</tr>
		<?php $x++;} ?>
		</tbody>
	</table>
	
	<input type="hidden" id="retrieveCount" name="retrieveCount"/>
</div>

<script>
	var retrieveCount = <?php echo count($modelRetrieve) ?>;
	
	$(".qtyDetailRetrieve").on('change keyup keypress',function()  //Check or uncheck the withdraw checkbox according to the value of Qty field
	{
		if($(this).val() > 0 )$(this).parent().next().next().children('input').prop('checked',true);
		else
			$(this).parent().next().next().children('input').prop('checked',false);
	});
	
</script>
