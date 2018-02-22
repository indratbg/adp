<table id='tableHist' class='table-bordered table-condensed'>
	<thead>
		<tr>
			<th width="14%">Repo Date</th>
			<th width="14%">Due Date</th>
			<th width="20%">Nomor Perjanjian</th>
			<th width="14%">Nilai</th>
			<th width="14%">Return Value</th>
			<th width="10%">Interest Rate %</th>
			<th width="10%">Tax</th>
			<?php if(!$model->isNewRecord): ?>
			<th width="4%">
				<a style="cursor:pointer" title="add" onclick="checkAddRow()"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/add.png"></a>
			</th><?php endif; ?>
		</tr>
	</thead>
	<tbody>
	<?php $x = 1;
		foreach($modelHist as $row){ 
	?>
		<tr id="row<?php echo $x ?>">
			<td><?php echo $form->textField($row,'repo_date',array('class'=>'span','readonly'=>$perpanjangan&&$x==count($modelHist)?'':'readonly','maxlength'=>30,'name'=>'Trepohist['.$x.'][repo_date]','onChange'=>$perpanjangan&&$x==count($modelHist)?'assignBottomUp(1)':'')); ?></td>
			<td><?php echo $form->textField($row,'due_date',array('class'=>'span','readonly'=>$perpanjangan&&$x==count($modelHist)?'':'readonly','maxlength'=>30,'name'=>'Trepohist['.$x.'][due_date]','onChange'=>$perpanjangan&&$x==count($modelHist)?'assignBottomUp(2)':'')); ?></td>
			<td><?php echo $form->textField($row,'repo_ref',array('class'=>'span','readonly'=>$perpanjangan&&$x==count($modelHist)?'':'readonly','maxlength'=>30,'name'=>'Trepohist['.$x.'][repo_ref]','onChange'=>$perpanjangan&&$x==count($modelHist)?'assignBottomUp(3)':'')); ?></td>
			<td><?php echo $form->textField($row,'repo_val',array('class'=>'span tnumber','style'=>'text-align:right','readonly'=>$perpanjangan&&$x==count($modelHist)?'':'readonly','maxlength'=>21,'name'=>'Trepohist['.$x.'][repo_val]','onChange'=>$perpanjangan&&$x==count($modelHist)?'assignBottomUp(4)':'')); ?></td>
			<td><?php echo $form->textField($row,'return_val',array('class'=>'span tnumber','style'=>'text-align:right','readonly'=>$perpanjangan&&$x==count($modelHist)?'':'readonly','maxlength'=>21,'name'=>'Trepohist['.$x.'][return_val]','onChange'=>$perpanjangan&&$x==count($modelHist)?'assignBottomUp(5)':'')); ?></td>
			<td><?php echo $form->textField($row,'interest_rate',array('class'=>'span','style'=>'text-align:right','readonly'=>$perpanjangan&&$x==count($modelHist)?'':'readonly','maxlength'=>9,'name'=>'Trepohist['.$x.'][interest_rate]','onChange'=>$perpanjangan&&$x==count($modelHist)?'assignBottomUp(6)':'')); ?></td>
			<td><?php echo $form->textField($row,'interest_tax',array('class'=>'span tnumber','style'=>'text-align:right','name'=>'Trepohist['.$x.'][interest_tax]','value'=>0)); ?></td>
			<?php if(!$model->isNewRecord): ?>
			<td>
				<?php if($perpanjangan&&$x==count($modelHist)): ?>
				<a style="cursor:pointer" title="delete" onclick="deleteRow(<?php echo $x ?>)"><img src="<?php echo Yii::app()->request->baseUrl ?>/images/delete.png"></a>
				<?php endif; ?>	
			</td>
			<?php endif; ?>
		</tr>
	<?php $x++;} ?>
	</tbody>
</table>