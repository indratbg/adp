<div class="detail" id="detailRetrieve">
	<table id='tableRetrieve' class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th width="15%">Client Code</th>
				<th width="25%">Client Name</th>
				<th width="15%">Stock Code</th>
				<th width="15%"><?php if($scenario == 'retreverse')echo 'Direpokan';else if($scenario == 'settbuy')echo 'Buy Qty';else echo 'Sell Qty' ?></th>
				<th width="15%"><?php if($scenario == 'settbuy')echo 'Buy ';else if($scenario == 'settsell')echo 'Sell '?>Date</th>
				<th width="3%" style="text-align:center">
					<?php if($scenario == 'retreverse')echo 'Return';else echo 'Settle' ?>
					<br>
					<input type="checkbox" class="checkBoxAll" />
				</th>
				<th width="12%"></th>
			</tr>
		</thead>
		<tbody>
		<?php $x = 1;
			foreach($modelRetrieve as $row){ 
		?>
			<tr id="row<?php echo $x ?>">
				<td class="client">
					<?php echo $form->textField($row,'client_cd',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][client_cd]','readonly'=>'readonly')); ?>
					<input type="hidden" name="Tstkretrieve[<?php echo $x ?>][doc_num]" value="<?php echo $row->doc_num ?>"/>
				</td>
				<td>
					<?php echo $form->textField($row,'client_name',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][client_name]','readonly'=>'readonly')); ?>
				</td>
				<td class="stock">
					<?php echo $form->textField($row,'stk_cd',array('class'=>'span','name'=>'Tstkretrieve['.$x.'][stk_cd]','readonly'=>'readonly')); ?>
				</td>
				<td class="qty">
					<?php echo $form->textField($row,'qty',array('class'=>'span tnumber qtyDetailRetrieve','name'=>'Tstkretrieve['.$x.'][qty]','onChange'=>"countTotal('.qtyDetailRetrieve')",'readonly'=>'readonly')); ?>
					<input type="hidden" name="Tstkretrieve[<?php echo $x ?>][price]" value="<?php echo $row->price ?>"/>
				</td>
				<td>
					<?php echo $form->textField($row,'doc_dt',array('class'=>'span tdate','name'=>'Tstkretrieve['.$x.'][doc_dt]','readonly'=>'readonly')); ?>
				</td>
				<td class="check" style="text-align:center">
					<?php echo $form->checkBox($row,'check',array('value' => 'Y','uncheckValue'=>'N','name'=>'Tstkretrieve['.$x.'][check]','onChange'=>"checkToggle();countTotal('.qtyDetailRetrieve')")); ?>
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
</script>
