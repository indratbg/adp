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
<?php echo $form->textFieldRow($model,'xn_doc_num',array('class'=>'span5','maxlength'=>50)); ?>
<?php echo $form->textFieldRow($model,'ledger_nar',array('class'=>'span5','maxlength'=>50)); ?>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<script>
	$('#Tconsoljrn_from_date').datepicker({format : "dd/mm/yyyy"});
	$('#Tconsoljrn_to_date').datepicker({format : "dd/mm/yyyy"});
</script>
