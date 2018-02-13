<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'type'=>'horizontal'
)); ?>

<h4>Primary Attributes</h4>
<div class="row-fluid control-group">
	<div class="span4">
		<?php echo $form->datePickerRow($model,'from_date',array('class'=>'span5'));?>
	</div>
	<div class="span6" style="margin-left: -10px;">
		<div class="span2">
			<label>To Date</label>
		</div>
		
		<div class="span5" style="margin-left: -20px;">
		<?php echo $form->datePickerRow($model,'to_date',array('class'=>'span8','label'=>FALSE));?>	
		</div>
		
	</div>
</div>
	
	<?php echo $form->textFieldRow($model,'folder_cd',array('class'=>'span5'));?>
	<?php echo $form->textFieldRow($model,'jvch_num',array('class'=>'span5'));?>
	<?php echo $form->textFieldRow($model,'remarks',array('class'=>'span5'));?>
	<?php // echo $form->textFieldRow($model,'budget_cd',array('class'=>'span5'));?>
	<?php echo $form->dropDownListRow($model,'budget_cd',array('GL'=>'GENERAL LEDGER','INTREPO'=>'INTEREST REPO'),array('class'=>'span5','prompt'=>'-Select Journal-'));?>
	<?php echo $form->textFieldRow($model,'user_id',array('class'=>'span5'));?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

<script>
<?php $from_date=Date('d/m/Y',strtotime('-35 days'));
 		$to_date=Date('d/m/Y');?>

		$('#Vgljournalindex_from_date').val('<?php echo $from_date;?>');
		$('#Vgljournalindex_to_date').val('<?php echo $to_date;?>');
		$("#Vgljournalindex_from_date").datepicker({format : "dd/mm/yyyy"});
		$("#Vgljournalindex_to_date").datepicker({format : "dd/mm/yyyy"});
	
	$('#Vgljournalindex_from_date').change(function(){
		$('#Vgljournalindex_to_date').val($('#Vgljournalindex_from_date').val());
	});
</script>
