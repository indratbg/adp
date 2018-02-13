<div class="detail" id="detailRetrieve">
	<table id='tableRetrieve' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="15%">Client Code</th>
				<th width="25%">Client Name</th>
				<th width="15%">Stock Code</th>
				<th width="15%">Theoritical Qty per <?php echo DateTime::createFromFormat('Y-m-d',$model->doc_dt)->format('d/m') ?></th>
				<th width="15%">Qty</th>
				<th width="5%">Repo</th>
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
					<?php echo $form->textField($row,'on_hand',array('class'=>'span tnumber','name'=>'Tstkretrieve['.$x.'][on_hand]','readonly'=>'readonly')); ?>
				</td>
				<td class="qty">
					<?php echo $form->textField($row,'qty',array('class'=>'span tnumber qtyDetailRetrieve','name'=>'Tstkretrieve['.$x.'][qty]','onChange'=>"countTotal('.qtyDetailRetrieve')")); ?>
				</td>
				<td class="check" style="text-align:center">
					<input class="withdrawCheck" type="checkbox" <?php if($row->qty > 0)echo 'checked' ?> />
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
	
	$(".qtyDetailRetrieve").on('change keyup keypress',function() //Check or uncheck the withdraw checkbox according to the value of Qty field
	{
		if($(this).val() > 0 )$(this).parent().siblings('td.check').children('input').prop('checked',true);
		else
			$(this).parent().siblings('td.check').children('input').prop('checked',false);
	});
	
	$(".withdrawCheck").change(function()
	{
		if(!$(this).is(':checked'))
		{
			$(this).parent().siblings('td.qty').children('input').val(0).trigger('change');
		}
	});
</script>