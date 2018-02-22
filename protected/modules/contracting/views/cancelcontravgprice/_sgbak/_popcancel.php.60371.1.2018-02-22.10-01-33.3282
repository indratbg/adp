<?php 
if($is_successsave): ?>
<script>
	window.parent.closePopupModalAndRedirect('<?php echo Yii::app()->createUrl('/contracting/cancelcontravgprice/index'); ?>')
</script>
<?php endif; ?>

<style>
	.form-horizontal .controls{margin-left: 0px;}
	.form-actions{text-align: right;}
</style>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array( 
    'id'=>'menuaction-form', 
    'enableAjaxValidation'=>false, 
    'type'=>'horizontal' 
)); ?>
	
	<?php echo $form->errorSummary($model); $errm2 = '';?>
	<?php if($model1 != null) echo $form->errorSummary($model1); ?>
	<?php if($model2 != null){
		
		foreach($model2 as $m){
			if(!empty($errm2)){
				echo $form->errorSummary($m);
				$errm2 = $m->error_msg;
			}
		}
	} ?>
	<?php if ($model2){?>
	<h4>Cancelled Contracts</h4>
	<table class='table-bordered table-condensed'>
		<thead>
			<tr>
				<th id="header1" style="width: 15%">Contract Date</th>
				<th id="header2">Client</th>
				<th id="header3" style="width: 10%">Beli/Jual</th>
				<th id="header4">Stock</th>
				<th id="header5">Qty</th>
				<th id="header6">Price</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($model3 as $row){?>
				<tr>
					<td><?php echo DateTime::createFromFormat('Y-m-d',$row->contr_dt)->format('d M Y');?></td>
					<td><?php echo $row->client_cd;?></td>
					<td><?php echo substr($row->contr_num,4,1)=='B'?'Beli':'Jual';?></td>
					<td><?php echo $row->stk_cd;?></td>
					<td style="text-align: right"><?php echo number_format($row->qty,0);?></td>
					<td style="text-align: right"><?php echo $row->price;?></td>
				</tr>
			<?php }?>
		</tbody>
	</table>
	<?php }?>
	<h4>Cancel Reason</h4>
	<?php echo $form->textAreaRow($model, 'cancel_reason', array('class'=>'span5', 'rows'=>3,'label'=>false)); ?>
	
    <div class="form-actions"> 
        <?php $this->widget('bootstrap.widgets.TbButton', array( 
            'buttonType'=>'submit', 
            'type'=>'primary', 
            'label'=>'Save'
        )); ?>
    </div> 
<?php $this->endWidget(); ?>
